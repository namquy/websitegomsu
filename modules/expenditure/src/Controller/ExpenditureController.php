<?php
/**
 * Created by PhpStorm.
 * User: Quy
 * Date: 11/24/2015
 * Time: 8:56 AM
 */

namespace Drupal\expenditure\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ExpenditureController extends ControllerBase {

    public function createExpenditures(Request $request) {
        $response = array();
        $data = array();
        $content = $request->getContent();

        if (!empty($content)) {
            $data = json_decode($content, TRUE);

            for ($i = 0; $i < count($data); ++$i) {
                $this->_insertExpenditure($data[$i]);
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

    public function createMultipleExpenditures() {
        $build = array(
            '#theme' => 'create_multiple_expenditures',
        );
        return $build;
    }

    function _insertExpenditure($data) {
        $name = $data['name'];
        $total_cost = $data['total_cost'];
        $note = $data['note'];

        // insert new row
        $fields = array(
            'name' => $name,
            'total_cost' => $total_cost,
            'note' => $note,
            'date' => REQUEST_TIME
        );
        db_insert('expenditure')->fields($fields)->execute();
    }

    function delete($id) {
        $response = array();

        if (isset($id) && $id > 0) {
            $num_deleted = db_delete('expenditure')
                ->condition('eid', $id)
                ->execute();

            if ($num_deleted > 0) {
                $response = array(
                    'success' => true,
                    'message' => 'Delete successfully',
                );
            } else {
                $response = array(
                    'success' => false,
                    'message' => 'Delete unsuccessfully',
                );
            }
        } else {
            $response = array(
                'success' => false,
                'message' => 'Delete unsuccessfully',
            );
        }

        return new JsonResponse($response);
    }

}