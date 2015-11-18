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

}