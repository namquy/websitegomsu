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

        $total_price = 0;
        $total_cost = 0;

        // get total price
        $query = db_select('product_user_relationship', 'e')
            ->condition('date', isset($date_from_timestamp) ? $date_from_timestamp : 0, '>=')
            ->condition('date', isset($date_to_timestamp) ? $date_to_timestamp : 9999999999, '<=')
            ->condition('status', 2)
            ->fields('e', array('total_price'));
        $query->groupBy('e.total_price');
        $query->addExpression('SUM(total_price)', 'total_price_all');
        $query_total_price_result = $query->execute()->fetchAll();
        foreach ($query_total_price_result as $row) {
            $total_price += $row->total_price_all;
        }

        // get total cost of on-site products
        $query = db_select('node__field_cost', 'c')
            ->condition('bundle', 'product');
        $query->join('product_user_relationship', 'e', 'c.entity_id = e.product_id');
        $query->condition('e.date', isset($date_from_timestamp) ? $date_from_timestamp : 0, '>=');
        $query->condition('e.date', isset($date_to_timestamp) ? $date_to_timestamp : 9999999999, '<=');
        $query->condition('e.status', 2);
        $query->fields('c', array('field_cost_value'));
        $query->fields('e', array('quantity'));
        $query_total_cost_product = $query->execute()->fetchAll();
        foreach  ($query_total_cost_product as $row) {
            $total_cost += $row->field_cost_value * $row->quantity;
        }

        // get total cost of facebook products
        $query = db_select('node', 'c')
            ->condition('type', 'facebook_product');
        $query->join('product_user_relationship', 'e', 'c.nid = e.product_id');
        $query->condition('e.status', 2);
        $query->condition('e.date', isset($date_from_timestamp) ? $date_from_timestamp : 0, '>=');
        $query->condition('e.date', isset($date_to_timestamp) ? $date_to_timestamp : 9999999999, '<=');
        $query->fields('e', array('total_price'));
        $query->groupBy('e.total_price');
        $query->addExpression('SUM(total_price)', 'total_price_all');
        $query_total_cost_facebook_product = $query->execute()->fetchAll();
        foreach  ($query_total_cost_facebook_product as $row) {
            $total_cost += $row->total_price_all / 2;
        }

        return array(
            'total_price' => $total_price,
            'total_cost' => $total_cost,
        );
    }

    public function _totalIncomeFull(){
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

        $total_price = 0;
        $total_cost = 0;

        // get total price
        $query = db_select('product_user_relationship', 'e')
            ->condition('date', isset($date_from_timestamp) ? $date_from_timestamp : 0, '>=')
            ->condition('date', isset($date_to_timestamp) ? $date_to_timestamp : 9999999999, '<=')
            ->condition('status', 3, '<')
            ->fields('e', array('total_price'));
        $query->groupBy('e.total_price');
        $query->addExpression('SUM(total_price)', 'total_price_all');
        $query_total_price_result = $query->execute()->fetchAll();
        foreach ($query_total_price_result as $row) {
            $total_price += $row->total_price_all;
        }

        // get total cost of on-site products
        $query = db_select('node__field_cost', 'c')
            ->condition('bundle', 'product');
        $query->join('product_user_relationship', 'e', 'c.entity_id = e.product_id');
        $query->condition('e.date', isset($date_from_timestamp) ? $date_from_timestamp : 0, '>=');
        $query->condition('e.date', isset($date_to_timestamp) ? $date_to_timestamp : 9999999999, '<=');
        $query->condition('e.status', 3, '<');
        $query->fields('c', array('field_cost_value'));
        $query->fields('e', array('quantity'));
        $query_total_cost_product = $query->execute()->fetchAll();
        foreach  ($query_total_cost_product as $row) {
            $total_cost += $row->field_cost_value * $row->quantity;
        }

        // get total cost of facebook products
        $query = db_select('node', 'c')
            ->condition('type', 'facebook_product');
        $query->join('product_user_relationship', 'e', 'c.nid = e.product_id');
        $query->condition('e.status', 3, '<');
        $query->condition('e.date', isset($date_from_timestamp) ? $date_from_timestamp : 0, '>=');
        $query->condition('e.date', isset($date_to_timestamp) ? $date_to_timestamp : 9999999999, '<=');
        $query->fields('e', array('total_price'));
        $query->groupBy('e.total_price');
        $query->addExpression('SUM(total_price)', 'total_price_all');
        $query_total_cost_facebook_product = $query->execute()->fetchAll();
        foreach  ($query_total_cost_facebook_product as $row) {
            $total_cost += $row->total_price_all / 2;
        }

        return array(
            'total_price' => $total_price,
            'total_cost' => $total_cost,
        );
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
            ->execute()->fetchAll();

        $total_cost = 0;
        foreach ($query as $row) {
            $total_cost += $row->total_cost;
        }

        return $total_cost;
    }

}