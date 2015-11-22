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

class InvoiceController extends ControllerBase {

    public function createInvoice($user_id = NULL) {
        $response = array();

        if (isset($user_id) && $user_id > 0) {
            $user_storage = \Drupal::entityManager()->getStorage('user');
            $user = $user_storage->load($user_id);
            $total_price = 0;
            $total_quantity = 0;
            if (isset($user)) {
                // insert new invoice
                $fields = array(
                    'user_id' => $user_id,
                    'total_quantity' => 0,
                    'total_price' => 0,
                    'date' => time(),
                    'note' => '',
                );
                $invoice_id = db_insert('invoice')
                    ->fields($fields)
                    ->execute();

                // create relationship between invoice and purchased products of customer
                $fields = array(
                    'invoice_id' => $invoice_id,
                );
                db_update('product_user_relationship')
                    ->condition('user_id', $user_id)
                    ->condition('status', 1)
                    ->isNull('invoice_id')
                    ->fields($fields)
                    ->execute();

                // update total_price and total_quantity
                $rows = db_select('product_user_relationship', 'e')
                    ->condition('invoice_id', $invoice_id)
                    ->fields('e', array('total_price', ' quantity'))
                    ->execute()->fetchAll();
                foreach ($rows as $row) {
                    $total_price += $row->total_price;
                    $total_quantity += $row->quantity;
                }

                // re-update invoice: total price, total quantity
                $fields = array(
                    'total_price' => $total_price,
                    'total_quantity' => $total_quantity,
                );
                db_update('invoice')
                    ->condition('id', $invoice_id)
                    ->fields($fields)
                    ->execute();

                $response = array(
                    'success' => true,
                    'message' => $this->t('Create successfully.'),
                );
            }
        }

        return new JsonResponse($response);
    }

    public function startInvoice($invoice_id = NULL) {
        $response = array();

        if (isset($invoice_id) && $invoice_id > 0) {
            // update status of invoice
            $fields = array(
                'status' => 5,
            );
            $num_updated = db_update('invoice')
                ->condition('id', $invoice_id)
                ->fields($fields)
                ->execute();
            if ($num_updated > 0) {
                // update status of products
                $fields = array(
                    'status' => 2, // completed status
                );
                $num_updated = db_update('product_user_relationship')
                    ->condition('invoice_id', $invoice_id)
                    ->fields($fields)
                    ->execute();
                if ($num_updated > 0) {
                    $response = array(
                        'success' => true,
                        'message' => $this->t('Start invoice successfully.')
                    );
                } else {
                    $response = array(
                        'success' => false,
                        'message' => $this->t('Invoice is started but it have no product.')
                    );
                }
            } else {
                $response = array(
                    'success' => false,
                    'message' => $this->t('Invoice is not existed.')
                );
            }
        }

        return new JsonResponse($response);
    }

    public function detailInvoice($invoice_id = NULL) {
        $response = array();

        if (isset($invoice_id) && $invoice_id > 0) {
            /*
            $query = db_select('invoice', 'e')
                ->condition('id', $invoice_id)
                ->fields('e', array('id'))
                ->execute()->fetchAll();
            */
        }

        return new JsonResponse($response);
    }

}