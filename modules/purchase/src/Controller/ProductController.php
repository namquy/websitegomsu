<?php
/**
 * Created by PhpStorm.
 * User: Quy
 * Date: 11/24/2015
 * Time: 8:56 AM
 */

namespace Drupal\purchase\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends ControllerBase {


    function fbtest() {
        $url = 'https://www.facebook.com/gomsunhatgiare/photos/pcb.506978799482483/506978392815857/?type=3&permPage=1';
        $arr = explode('/', $url);
        $photo_id = $arr[6];
        $url = 'http://graph.facebook.com/' . $photo_id . '/picture';

        $rez = $this->get_all_redirects($url);

        return new JsonResponse($rez);
    }

    public function createProducts(Request $request) {
        $response = array();
        $data = array();
        $content = $request->getContent();

        if (!empty($content)) {
            $data = json_decode($content, TRUE);

            for ($i = 0; $i < count($data); ++$i) {
                // pre create node
                if (!isset($data[$i]['title'])) {
                    $data[$i]['title'] = 'Facebook product';
                }
                if (!isset($data[$i]['status_id'])) {
                    $data[$i]['status_id'] = 1;
                }
                $data[$i]['image_link'] = $this->_getRealFacebookImageLink($data[$i]['image_link']);

                // create node
                $data[$i]['id'] = $this->_createFacebookProduct($data[$i]);
                $this->_insertPurchasedProduct($data[$i]);
            }

            $response = array(
                'success' => true,
                'message' => 'Create successfully',
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Create unsuccessfully',
            );
        }

        return new JsonResponse($response);
    }

    public function createMultipleProducts() {
        $build = array(
            '#theme' => 'create_multiple_products',
        );
        return $build;
    }

    function _createFacebookProduct($data) {
        $node = Node::create(array(
            'type' => 'facebook_product',
            'langcode' => \Drupal::languageManager()->getCurrentLanguage()->getId(),
            'created' => REQUEST_TIME,
            'changed' => REQUEST_TIME,
            'uid' => \Drupal::currentUser()->id(),
            'title' => $data['title'],
            'body' => array(
                'summary' => '',
                'value' => $data['body'],
                'format' => 'basic_html',
            ),
            'field_image_links' => array(
                array(
                    'uri' => $data['image_link'],
                ),
            ),
            'field_price' => $data['price'],
            'field_quantity' => $data['quantity'],
            'field_customer' => $data['customer_id'],
            'field_status' => $data['status_id'],
        ));
        $node->save();

        return $node->id();
    }

    function _insertPurchasedProduct($data) {
        $product_id = $data['id'];
        $quantity = $data['quantity'];
        $price = $data['price'];
        $customer_id = $data['customer_id'];
        $note = $data['body'];
        $status_id = $data['status_id'];
        $total_price = $price * $quantity;
        $user_storage = \Drupal::entityManager()->getStorage('user');
        $customer = \Drupal\user\Entity\User::load($customer_id);

        // update user
        if ($status_id != 3) {
            if (!isset($customer->field_total_money->value)) {
                $customer->field_total_money->value = $total_price;
            } else {
                $customer->field_total_money->value += $total_price;
            }
            $customer->field_debt->value = $customer->field_total_money->value - $customer->field_payment_money->value;
            $user_storage->save($customer);
        }

        // insert new row
        $fields = array(
            'product_id' => $product_id,
            'user_id' => $customer_id,
            'quantity' => $quantity,
            'price' => $price,
            'total_price' => $total_price,
            'status' => $status_id,
            'note' => $note,
            'date' => REQUEST_TIME
        );
        db_insert('product_user_relationship')->fields($fields)->execute();
    }

    function _getRealFacebookImageLink($url) {
        if (strpos($url, 'www.facebook.com')) {
            $arr = explode('/', $url);
            $photo_id = $arr[6];
            $url = 'http://graph.facebook.com/' . $photo_id . '/picture';
            return $this->get_final_url($url);
        }
        return $url;
    }

    /**
     * get_redirect_url()
     * Gets the address that the provided URL redirects to,
     * or FALSE if there's no redirect.
     *
     * @param string $url
     * @return string
     */
    function get_redirect_url($url){
        $redirect_url = null;

        $url_parts = @parse_url($url);
        if (!$url_parts) return false;
        if (!isset($url_parts['host'])) return false; //can't process relative URLs
        if (!isset($url_parts['path'])) $url_parts['path'] = '/';

        $sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int)$url_parts['port'] : 80), $errno, $errstr, 30);
        if (!$sock) return false;

        $request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?'.$url_parts['query'] : '') . " HTTP/1.1\r\n";
        $request .= 'Host: ' . $url_parts['host'] . "\r\n";
        $request .= "Connection: Close\r\n\r\n";
        fwrite($sock, $request);
        $response = '';
        while(!feof($sock)) $response .= fread($sock, 8192);
        fclose($sock);

        if (preg_match('/^Location: (.+?)$/m', $response, $matches)){
            if ( substr($matches[1], 0, 1) == "/" )
                return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
            else
                return trim($matches[1]);

        } else {
            return false;
        }

    }

    /**
     * get_all_redirects()
     * Follows and collects all redirects, in order, for the given URL.
     *
     * @param string $url
     * @return array
     */
    function get_all_redirects($url){
        $redirects = array();
        while ($newurl = $this->get_redirect_url($url)){
            if (in_array($newurl, $redirects)){
                break;
            }
            $redirects[] = $newurl;
            $url = $newurl;
        }
        return $redirects;
    }

    /**
     * get_final_url()
     * Gets the address that the URL ultimately leads to.
     * Returns $url itself if it isn't a redirect.
     *
     * @param string $url
     * @return string
     */
    function get_final_url($url){
        $redirects = $this->get_all_redirects($url);
        if (count($redirects)>0){
            return array_pop($redirects);
        } else {
            return $url;
        }
    }

}