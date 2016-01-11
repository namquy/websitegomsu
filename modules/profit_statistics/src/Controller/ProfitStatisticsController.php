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

            $total_income = $this->_totalIncome($date_from, $date_to);
            $total_expenditure = $this->_totalExpenditure($date_from, $date_to);
            $total_profit = $total_income - $total_expenditure;

            $response = array(
                'success' => true,
                'total_profit' => $total_profit,
                'total_income' => $total_income,
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
            ->fields('e', array('total_price'))
            ->execute()->fetchAll();

        $total_price = 0;
        foreach ($query as $row) {
            $total_price += $row->total_price;
        }

        return $total_price;
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