<?php
/**
 * Created by PhpStorm.
 * User: Quy Nguyen Nam
 * Date: 1/4/2016
 * Time: 9:32 AM
 */

namespace Drupal\purchase\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class UserRouting extends RouteSubscriberBase {

    /**
     * {@inheritdoc}
     */
    public function alterRoutes(RouteCollection $collection) {
        // Change path '/user/login' to '/customer/login'.
        if ($route = $collection->get('user.login')) {
            $route->setPath('/customer/login');
        }
        // Change path '/user/register' to '/customer/register'.
        if ($route = $collection->get('user.register')) {
            $route->setPath('/customer/register');
        }
        // Change path '/user/password' to '/customer/password'.
        if ($route = $collection->get('user.pass')) {
            $route->setPath('/customer/password');
        }
        /*
        // Always deny access to '/user/logout'.
        // Note that the second parameter of setRequirement() is a string.
        if ($route = $collection->get('user.logout')) {
            $route->setRequirement('_access', 'FALSE');
        }
        */
    }

}
?>