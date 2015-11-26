<?php
/**
 * Created by PhpStorm.
 * User: Quy
 * Date: 11/18/2015
 * Time: 9:26 AM
 */

namespace Drupal\purchase\Controller;

use Drupal\Core\Controller\ControllerBase;
use Zend\Diactoros\Response\JsonResponse;

class PurchaseController extends ControllerBase {

    public function buyNow($product_id = NULL, $price = NULL, $quantity = NULL) {
        $response = array();

        if (isset($product_id) && $product_id > 0 && isset($price) && $price > 0 && isset($quantity) && $quantity > 0) {
            $userId = \Drupal::currentUser()->id();
            $curUser = \Drupal\user\Entity\User::load($userId);
            $user_storage = \Drupal::entityManager()->getStorage('user');
            $node_storage = \Drupal::entityManager()->getStorage('node');
            $node = $node_storage->load($product_id);

            if ($node != null && $curUser != null) {
                $curQty = $node->field_quantity->value;
                if ($quantity <= $curQty) {
                    $total_price = $price * $quantity;

                    // update user
                    if (!isset($curUser->field_total_money->value)) {
                        $curUser->field_total_money->value = $total_price;
                    } else {
                        $curUser->field_total_money->value += $total_price;
                    }
                    $user_storage->save($curUser);

                    // insert new row
                    $fields = array(
                        'product_id' => $product_id,
                        'user_id' => $userId,
                        'quantity' => $quantity,
                        'price' => $price,
                        'total_price' => $total_price,
                        'date' => time());
                    db_insert('product_user_relationship')->fields($fields)->execute();

                    // update quantity in db
                    $curQty -= $quantity;
                    $node->field_quantity->value = $curQty;
                    if ($curQty <= 0) {
                        $node->field_available->value = 0;
                    }
                    $node_storage->save($node);

                    $response = array(
                        'success' => true,
                        'message' => $this->t('Purchased successfully.')
                    );
                    //return new JsonResponse($response);
                } else {
                    $response = array(
                        'success' => false,
                        'message' => $this->t('The purchased quantity must be less than current quantity of product.')
                    );
                }
            } else {
                $response = array(
                    'success' => false,
                    'message' => $this->t('The purchased product id is invalid.')
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => $this->t('Unspecified error.')
            );
        }

        return new JsonResponse($response);
    }

    public function updateStatus($relationship_id = NULL, $status_id = NULL) {
        $response = array();

        if (isset($relationship_id) && $relationship_id > 0 && isset($status_id) && $status_id > 0) {
            $query = db_select('product_user_relationship', 'e')
                ->condition('rid', $relationship_id)
                ->fields('e', array('status'))
                ->execute()->fetchAll();
            if (count($query) > 0) {
                $old_status_id = $query[0]->status;
                if ($old_status_id == $status_id) {
                    $response = array(
                        'success' => true,
                        'message' => $this->t('Status not changed.')
                    );
                    return new JsonResponse($response);
                }

                $num_updated = db_update('product_user_relationship')
                    ->condition('rid', $relationship_id)
                    ->fields(array(
                        'status' => $status_id,
                    ))
                    ->execute();

                // get customer entity
                $query = db_select('product_user_relationship', 'e')
                    ->condition('rid', $relationship_id)
                    ->fields('e', array('user_id', 'total_price'))
                    ->execute()->fetchAll();
                $customer_id = $query[0]->user_id;
                $total_price = $query[0]->total_price;
                $user_storage = \Drupal::entityManager()->getStorage('user');
                $customer = \Drupal\user\Entity\User::load($customer_id);

                // update total price of customer
                if ($status_id == 3) {
                    $customer->field_total_money->value -= $total_price;
                } else if ($old_status_id == 3) {
                    $customer->field_total_money->value += $total_price;
                }
                $user_storage->save($customer);

                $response = array(
                    'success' => true,
                    'message' => $this->t('Change status successfully.')
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => $this->t('Change status unsuccessfully.')
                );
            }
        }

        return new JsonResponse($response);
    }

}