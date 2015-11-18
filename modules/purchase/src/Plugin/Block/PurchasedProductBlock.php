<?php
/**
 * Created by PhpStorm.
 * User: Quy
 * Date: 11/18/2015
 * Time: 3:36 PM
 */

namespace Drupal\purchase\Plugin\Block;

use \Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Purchased Product' block.
 *
 * @Block(
 *   id = "purchased_product_block",
 *   admin_label = @Translation("Purchased Product Block"),
 * )
 */
class PurchasedProductBlock extends BlockBase {

    /**
     * @inheritDoc
     */
    public function build()
    {
        $userId = \Drupal::currentUser()->id();
        $curUser = \Drupal\user\Entity\User::load($userId);

        return array(
            '#markup' => $this->t('Hello, World!'),
        );
    }
}