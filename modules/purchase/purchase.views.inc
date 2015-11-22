<?php

function purchase_views_data() {
    $data = array();

    // define invoice view
    $data['invoice'] = array();
    $data['invoice']['table'] = array();
    $data['invoice']['table']['group'] = t('Invoice');
    $data['invoice']['table']['base'] = array(
        'field' => 'id',
        'title' => t('Invoice'),
        'help' => t('Invoice of purchased products'),
        'weight' => -11,
    );
    $data['invoice']['id'] = array(
        'title' => t('Invoice id'),
        'help' => t('The invoice id'),
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
    $data['invoice']['user_id'] = array(
        'title' => t('User'),
        'help' => t('User who purchased the product'),
        'relationship' => array(
            'base' => 'users_field_data',
            'base field' => 'uid',
            'id' => 'standard',
            'label' => t('User purchased product'),
        ),
    );
    $data['invoice']['total_quantity'] = array(
        'title' => t('Total quantity'),
        'help' => t('Total quantity of purchased product'),
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
    $data['invoice']['total_price'] = array(
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
    $data['invoice']['date'] = array(
        'title' => t('Created date'),
        'help' => t('Created date of the invoice.'),
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
    $data['invoice']['status'] = array(
        'title' => t('Status'),
        'help' => t('The status of the invoice.'),
        'relationship' => array(
            'base' => 'taxonomy_term_field_data',
            'base field' => 'tid',
            'id' => 'standard',
            'label' => t('Purchased status'),
        ),
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
    $data['invoice']['note'] = array(
        'title' => t('Note'),
        'help' => t('The note.'),
        'field' => array(
            'id' => 'standard',
        ),
        'sort' => array(
            'id' => 'standard',
        ),
        'filter' => array(
            'id' => 'string',
        ),
        'argument' => array(
            'id' => 'string',
        ),
    );

    // define purchased product view
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
    $data['product_user_relationship']['product_id'] = array(
        'title' => t('Node'),
        'help' => t('Product id is a node id'),
        'relationship' => array(
            'base' => 'node_field_data',
            'base field' => 'nid',
            'id' => 'standard',
            'label' => t('Product node'),
        ),
    );
    $data['product_user_relationship']['user_id'] = array(
        'title' => t('User'),
        'help' => t('User who purchased the product'),
        'relationship' => array(
            'base' => 'users_field_data',
            'base field' => 'uid',
            'id' => 'standard',
            'label' => t('User purchased product'),
        ),
    );
    $data['product_user_relationship']['invoice_id'] = array(
        'title' => t('Invoice'),
        'help' => t('Invoice includes the purchased product'),
        'relationship' => array(
            'base' => 'invoice',
            'base field' => 'id',
            'id' => 'standard',
            'label' => t('Invoice includes product'),
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
    $data['product_user_relationship']['status'] = array(
        'title' => t('Status'),
        'help' => t('The purchased status of the product.'),
        'relationship' => array(
            'base' => 'taxonomy_term_field_data',
            'base field' => 'tid',
            'id' => 'standard',
            'label' => t('Purchased status'),
        ),
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
    $data['product_user_relationship']['note'] = array(
        'title' => t('Note'),
        'help' => t('The note.'),
        'field' => array(
            'id' => 'standard',
        ),
        'sort' => array(
            'id' => 'standard',
        ),
        'filter' => array(
            'id' => 'string',
        ),
        'argument' => array(
            'id' => 'string',
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