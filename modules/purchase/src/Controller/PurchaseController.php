<?php
/**
 * Created by PhpStorm.
 * User: Quy
 * Date: 11/18/2015
 * Time: 9:26 AM
 */

namespace Drupal\purchase\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;
use Zend\Diactoros\Response\JsonResponse;

class PurchaseController extends ControllerBase {

    public function buyNow($product_id = NULL, $quantity = NULL) {
        $response = array();

        if (isset($product_id) && $product_id > 0 && isset($quantity) && $quantity > 0) {
            $user_storage = \Drupal::entityManager()->getStorage('user');
            $node_storage = \Drupal::entityManager()->getStorage('node');
            $tmpUser = \Drupal::currentUser();

            if ($tmpUser->isAuthenticated()) {
                $userId = \Drupal::currentUser()->id();
                $curUser = \Drupal\user\Entity\User::load($userId);
                $node = $node_storage->load($product_id);

                if ($node != null && $curUser != null) {
                    $price = $node->field_price->value;
                    $curQty = $node->field_quantity->value;
                    if ($quantity <= $curQty) {
                        $total_price = $price * $quantity;

                        // update user
                        if (!isset($curUser->field_total_money->value)) {
                            $curUser->field_total_money->value = $total_price;
                        } else {
                            $curUser->field_total_money->value += $total_price;
                        }
                        $curUser->field_debt->value = $curUser->field_total_money->value - $curUser->field_payment_money->value;
                        $curUser->field_last_purchased_date->value = format_date(REQUEST_TIME, 'custom', 'Y-m-d\TH:i:s');
                        $user_storage->save($curUser);

                        // insert new row
                        $fields = array(
                            'product_id' => $product_id,
                            'user_id' => $userId,
                            'quantity' => $quantity,
                            'price' => $price,
                            'total_price' => $total_price,
                            'status' => 1, // purchased status
                            'note' => "",
                            'date' => REQUEST_TIME
                        );
                        db_insert('product_user_relationship')->fields($fields)->execute();

                        // update quantity in db
                        $curQty -= $quantity;
                        $node->field_quantity->value = $curQty;
                        if ($curQty <= 0) {
                            $node->status->value = 0;
                        }
                        $node_storage->save($node);

                        $response = array(
                            'success' => true,
                            'message' => $this->t('Purchased successfully.'),
                            'quantity' => $curQty,
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
            } else { // anonymous
                $response = array(
                    'success' => false,
                    'isAnonymous' => true,
                    'message' => $this->t('You need to register or login before buying!'),
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

    public function refreshTotalCustomerDebts() {
        $response = array();

        $user_storage = \Drupal::entityManager()->getStorage('user');
        $query = db_select('users', 'e')
            ->fields('e', array('uid'))
            ->execute()->fetchAll();

        if (count($query) > 0) {
            foreach ($query as $row) {
                $uid = $row->uid;
                $debt = $this->_getTotalUserDebt($uid);
                $payment = $this->_getTotalUserPayment($uid);

                $user = $user_storage->load($uid);
                $user->field_debt->value = $debt;
                $user->field_payment_money->value = $payment;
                $user->field_total_money->value = $user->field_debt->value + $user->field_payment_money->value;
                $user_storage->save($user);
            }

            $response = array(
                'success' => true,
                'message' => 'Refresh successfully!',
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Refresh unsuccessfully!',
            );
        }

        return new JsonResponse($response);
    }

    private function _getTotalUserPayment($uid) {
        $query = db_select('product_user_relationship', 'e')
            ->condition('user_id', $uid)
            ->condition('status', 2)
            ->fields('e', array('total_price'));
        //$query->groupBy('e.status');
        $query->groupBy('e.total_price');
        $query->addExpression('SUM(total_price)', 'total_price_all');
        $query_result = $query->execute()->fetchAll();

        $total_price = 0;
        foreach ($query_result as $row) {
            $total_price += $row->total_price_all;
        }

        return $total_price;
    }

    private function _getTotalUserDebt($uid) {
        $query = db_select('product_user_relationship', 'e')
            ->condition('user_id', $uid)
            ->condition('status', 1)
            ->fields('e', array('total_price'));
        //$query->groupBy('e.status');
        $query->groupBy('e.total_price');
        $query->addExpression('SUM(total_price)', 'total_price_all');
        $query_result = $query->execute()->fetchAll();

        $total_price = 0;
        foreach ($query_result as $row) {
            $total_price += $row->total_price_all;
        }

        return $total_price;
    }

    public function createNewAccount($username = NULL) {
        $response = array();

        if (isset($username) && strlen($username) > 3) {
            $uids = db_select('users_field_data', 'e')
                ->condition('name', $username)
                ->fields('e', array('uid'))
                ->execute()->fetchAll();

            if (count($uids) == 0) {
                $password = '123456';
                $newUserId = $this->_createUser(array(
                    'username' => $username,
                    'password' => $password,
                ));

                $response = array(
                    'success' => true,
                    'uid' => $newUserId,
                    'username' => $username,
                    'password' => $password,
                    'message' => $this->t('Registry successfully.'),
                );
            } else {
                $response = array(
                    'success' => false,
                    'isExisted' => true,
                    'message' => $this->t('Username has already existed, please choose other username.'),
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => $this->t('Username must be not empty and its length larger 3 characters.'),
            );
        }

        return new JsonResponse($response);
    }

    public function loginWithAccount($user_id = NULl) {
        if (isset($user_id)) {
            $user = User::load($user_id);
            user_login_finalize($user);

            $response = array(
                'success' => true,
                'message' => $this->t('Login successfully.'),
            );
        } else {
            $response = array(
                'success' => false,
                'message' => $this->t('Login unsuccessfully.'),
            );
        }

        return new JsonResponse($response);
    }

    private function _createUser($data) {
        $user = User::create(array(
            'langcode' => 'en',
            'preferred_langcode' => \Drupal::languageManager()->getCurrentLanguage(),
            'preferred_admin_langcode' => \Drupal::languageManager()->getCurrentLanguage(),
            'name' => $data['username'],
            'status' => 1,
        ));
        $user->enforceIsNew();
        $user->setPassword($data['password']);
        $user->save();

        return $user->id();
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
                    ->fields('e', array('user_id', 'quantity', 'total_price', 'invoice_id'))
                    ->execute()->fetchAll();
                $customer_id = $query[0]->user_id;
                $total_price = $query[0]->total_price;
                $quantity = $query[0]->quantity;
                $invoice_id = $query[0]->invoice_id;
                $user_storage = \Drupal::entityManager()->getStorage('user');
                $customer = \Drupal\user\Entity\User::load($customer_id);

                // update total price of customer
                if ($status_id == 3) {
                    $customer->field_total_money->value -= $total_price;

                    // substract money in invoice (if has)
                    if (isset($invoice_id)) {
                        $query = db_select('invoice', 'e')
                            ->condition('id', $invoice_id)
                            ->fields('e', array('total_quantity', 'total_price'))
                            ->execute()
                            ->fetchAll();
                        $total_invoice_quantity = $query[0]->total_quantity;
                        $total_invoice_price = $query[0]->total_price;

                        $total_invoice_quantity -= $quantity;
                        $total_invoice_price -= $total_price;
                        db_update('invoice')
                            ->condition('id', $invoice_id)
                            ->fields(array(
                                'total_quantity' => $total_invoice_quantity,
                                'total_price' => $total_invoice_price,
                            ))
                            ->execute();
                    }
                } else if ($old_status_id == 3) {
                    $customer->field_total_money->value += $total_price;
                }
                $customer->field_debt->value = $customer->field_total_money->value - $customer->field_payment_money->value;
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

    public function refreshOldProducts() {
        $rows = db_select('node_field_data', 'e')
            ->condition('status', 1)
            ->condition('type', '%' . db_like('product'), 'LIKE')
            ->fields('e', array('nid'))
            ->execute()->fetchAll();

        if (count($rows)> 0) {
            $user_storage = \Drupal::entityManager()->getStorage('node');
            foreach ($rows as $row) {
                $nid = $row->nid;
                $node = Node::load($nid);
                if ($node->field_quantity->value > 0) {
                    $node->changed->value = REQUEST_TIME;
                    $user_storage->save($node);
                }
            }

            $response = array(
                'success' => true,
                'message' => $this->t('Refresh products successfully.'),
            );
        } else {
            $response = array(
                'success' => false,
                'message' => $this->t('There is no old product.'),
            );
        }

        return new JsonResponse($response);
    }
}