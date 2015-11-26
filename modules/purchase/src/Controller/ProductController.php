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

    public function createProduct(Request $request) {
        $response = array();
        $data = array();
        $content = $request->getContent();

        if (!empty($content)) {
            $data = json_decode($content, TRUE);

            // create node
            $data['id'] = $this->_createFacebookProduct($data);
            $this->_insertPurchasedProduct($data);

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

}