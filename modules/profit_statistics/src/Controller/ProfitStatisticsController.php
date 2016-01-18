<?php
/**
 * Created by PhpStorm.
 * User: Quy
 * Date: 11/24/2015
 * Time: 8:56 AM
 */

namespace Drupal\profit_statistics\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProfitStatisticsController extends ControllerBase {

    public function viewProfitStatistics() {
        $build = array(
            '#theme' => 'profit_statistics',
        );
        return $build;
    }

    public function getProfitStatistics(Request $request) {
        $response = array();
        $data = array();
        $content = $request->getContent();

        if (!empty($content)) {
            $data = json_decode($content, TRUE);

            $date_from = $data['date_from'];
            $date_to = $data['date_to'];

            $tmpArr = $this->_totalIncome($date_from, $date_to);
            $total_income = $tmpArr['total_price'];
            $total_cost = $tmpArr['total_cost'];

            $total_expenditure = $this->_totalExpenditure($date_from, $date_to);
            $total_profit = $total_income - $total_cost - $total_expenditure;

            $response = array(
                'success' => true,
                'total_profit' => $total_profit,
                'total_receipt' => $total_income,
                'total_cost' => $total_cost,
                'total_expenditure' => $total_expenditure,
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Create unsuccessfully',
            );
        }

        return new JsonResponse($response);
    }

    public function getProfitStatisticsFull(Request $request) {
        $response = array();
        $data = array();
        $content = $request->getContent();

        if (!empty($content)) {
            $data = json_decode($content, TRUE);

            $date_from = $data['date_from'];
            $date_to = $data['date_to'];

            $tmpArr = $this->_totalIncomeFull($date_from, $date_to);
            $total_income = $tmpArr['total_price'];
            $total_cost = $tmpArr['total_cost'];

            $total_expenditure = $this->_totalExpenditure($date_from, $date_to);
            $total_profit = $total_income - $total_cost - $total_expenditure;

            $response = array(
                'success' => true,
                'total_profit' => $total_profit,
                'total_receipt' => $total_income,
                'total_cost' => $total_cost,
                'total_expenditure' => $total_expenditure,
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Create unsuccessfully',
            );
        }

        return new JsonResponse($response);
    }

    public function totalUsers() {
        $query = db_select('users_data', 'e')
            ->fields('e', array('uid'))
            ->execute()->fetchAll();

        $response = array(
            'success' => false,
            'total_users' => count($query),
        );

        return new JsonResponse($response);
    }

    private function _totalIncome($date_from, $date_to){
        if (!empty($date_from)) {
            $date_from_timestamp = strtotime($date_from);
        } else {
            $date_from_timestamp = NULL;
        }
        if (!empty($date_to)) {
            $date_to_timestamp = strtotime($date_to);
            $date_to_timestamp = strtotime('+1 day', $date_to_timestamp);
        } else {
            $date_to_timestamp = NULL;
        }

        $query = db_select('invoice', 'e')
            ->condition('status', 5)
            ->condition('date', isset($date_from_timestamp) ? $date_from_timestamp : 0, '>=')
            ->condition('date', isset($date_to_timestamp) ? $date_to_timestamp : 9999999999, '<=')
            ->fields('e', array('total_price', 'id'))
            ->execute()->fetchAll();

        $total_price = 0;
        $total_cost = 0;
        foreach ($query as $row) {
            $total_price += $row->total_price;
            $total_cost += $this->_totalInvoiceCost($row->id);
        }

        return array(
            'total_price' => $total_price,
            'total_cost' => $total_cost,
        );
    }

    private function _totalIncomeFull($date_from, $date_to){
        if (!empty($date_from)) {
            $date_from_timestamp = strtotime($date_from);
        } else {
            $date_from_timestamp = NULL;
        }
        if (!empty($date_to)) {
            $date_to_timestamp = strtotime($date_to);
            $date_to_timestamp = strtotime('+1 day', $date_to_timestamp);
        } else {
            $date_to_timestamp = NULL;
        }

        $query = db_select('product_user_relationship', 'e')
            ->condition('status', 3, '<')
            ->condition('date', isset($date_from_timestamp) ? $date_from_timestamp : 0, '>=')
            ->condition('date', isset($date_to_timestamp) ? $date_to_timestamp : 9999999999, '<=')
            ->fields('e', array('total_price', 'price', 'product_id', 'quantity'))
            ->execute()->fetchAll();

        $total_price = 0;
        $total_cost = 0;
        foreach ($query as $row) {
            $total_price += $row->total_price;
            $total_cost += $this->_productCost($row->product_id, $row->quantity);
        }

        return array(
            'total_price' => $total_price,
            'total_cost' => $total_cost,
        );
    }

    private function _totalInvoiceCost($id) {
        $total_cost = 0;

        if (!empty($id)) {
            $products = db_select('product_user_relationship', 'e')
                ->condition('invoice_id', $id)
                ->condition('status', 3, '<')
                ->fields('e', array('product_id', 'quantity'))
                ->execute()->fetchAll();
            foreach ($products as $p) {
                $total_cost += $this->_productCost($p->product_id, $p->quantity);
            }
        }

        return $total_cost;
    }

    private function _productCost($nid, $quantity) {
        $total_cost = 0;

        if (!empty($nid)) {
            $node_storage = \Drupal::entityManager()->getStorage('node');
            $node = $node_storage->load($nid);
            if (isset($node)) {
                if ($node->getType() == 'product') {
                    $total_cost = $node->field_cost->value * $quantity;
                } else if ($node->getType() == 'facebook_product') {
                    $total_cost = $node->field_price->value * $quantity / 2;
                }
            }
        }

        return $total_cost;
    }

    private function _totalExpenditure($date_from, $date_to){
        if (!empty($date_from)) {
            $date_from_timestamp = strtotime($date_from);
        } else {
            $date_from_timestamp = NULL;
        }
        if (!empty($date_to)) {
            $date_to_timestamp = strtotime($date_to);
            $date_to_timestamp = strtotime('+1 day', $date_to_timestamp);
        } else {
            $date_to_timestamp = NULL;
        }

        $query = db_select('expenditure', 'e')
            ->condition('date', isset($date_from_timestamp) ? $date_from_timestamp : 0, '>=')
            ->condition('date', isset($date_to_timestamp) ? $date_to_timestamp : 9999999999, '<=')
            ->fields('e', array('total_cost'))
            ->execute()->fetchAll(c);

        $total_cost = 0;
        foreach ($query as $row) {
            $total_cost += $row->total_cost;
        }

        return $total_cost;
    }

}