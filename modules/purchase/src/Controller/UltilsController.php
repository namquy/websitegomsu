<?php
/**
 * Created by PhpStorm.
 * User: Quy
 * Date: 11/27/2015
 * Time: 12:42 AM
 */

namespace Drupal\purchase\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

class UltilsController extends ControllerBase {
    function userAutocomplete($query = NULL) {

        $query = db_select('users_field_data', 'e')
            ->fields('e', array('uid', 'name'))
            ->condition('name', '%' . db_like($query) . '%', 'LIKE')
            ->range(0, 10)
            ->execute();

        $result = array();
        foreach ($query as $row) {
            $result[] = array(
                'id' => $row->uid,
                'name' => $row->name,
            );
        }

        return new JsonResponse($result);
    }
}