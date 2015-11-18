<?php

function purchase_views_data() {
    $data = array();

    $data['product_user_relationship'] = array();
    $data['product_user_relationship']['table'] = array();
    $data['product_user_relationship']['table']['group'] = t('Purchased products');
    //$data['product_user_relationship']['table']['provider'] = 'purchase';
    $data['product_user_relationship']['table']['base'] = array(
        'field' => 'rid',
        'title' => t('Purchased products'),
        'help' => t('Purchased products includes relationship between users and products'),
        'weight' => -10,
    );

    $data['product_user_relationship']['rid'] = array(
        'title' => t('Relationship id'),
        'help' => t('Primary key of the element'),
    );
    $data['product_user_relationship']['product_id'] = array(
        'title' => t('Node Id'),
        'help' => t('Product id is a node id'),
        'relationship' => array(
            'base' => 'node',
            'base field' => 'nid',
            'id' => 'standard',
            'label' => t('Product node'),
        ),
    );
    $data['product_user_relationship']['user_id'] = array(
        'title' => t('User Id'),
        'help' => t('User who purchased the product'),
        'relationship' => array(
            'base' => 'users',
            'base field' => 'uid',
            'id' => 'standard',
            'label' => t('User purchased product'),
        ),
    );
    $data['product_user_relationship']['quantity'] = array(
        'title' => t('Quantity'),
        'help' => t('Quantity of purchased product'),
        'field' => array(
            'id' => 'numeric',
        ),
        'sort' => array(
            'id' => 'standard',
        ),
        'filter' => array(
            'id' => 'numeric'
        ),
        'argument' => array(
            'id' => 'numeric',
        ),
    );
    $data['product_user_relationship']['price'] = array(
        'title' => t('Price'),
        'help' => t('Price of purchased product'),
        'field' => array(
            'id' => 'numeric',
        ),
        'sort' => array(
            'id' => 'standard',
        ),
        'filter' => array(
            'id' => 'numeric'
        ),
        'argument' => array(
            'id' => 'numeric',
        ),
    );
    $data['product_user_relationship']['total_price'] = array(
        'title' => t('Total price'),
        'help' => t('Total price of purchased product'),
        'field' => array(
            'id' => 'numeric',
        ),
        'sort' => array(
            'id' => 'standard',
        ),
        'filter' => array(
            'id' => 'numeric'
        ),
        'argument' => array(
            'id' => 'numeric',
        ),
    );
    $data['product_user_relationship']['date'] = array(
        'title' => t('Purchased date'),
        'help' => t('The date that product is purchased.'),
        'field' => array(
            'id' => 'date',
        ),
        'sort' => array(
            'id' => 'date',
        ),
        'filter' => array(
            'id' => 'date',
        ),
    );
    $data['views']['area'] = array(
        'title' => t('Text area'),
        'help' => t('Provide markup text for the area.'),
        'area' => array(
            'id' => 'text',
        ),
    );

    return $data;
}