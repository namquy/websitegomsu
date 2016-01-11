<?php

function expenditure_views_data() {
    $data = array();

    // define expenditure view
    $data['expenditure'] = array();
    $data['expenditure']['table'] = array();
    $data['expenditure']['table']['group'] = t('Expenditure');
    $data['expenditure']['table']['base'] = array(
        'field' => 'eid',
        'title' => t('Expenditure'),
        'help' => t('Expenditure'),
        'weight' => -11,
    );
    $data['expenditure']['eid'] = array(
        'title' => t('Expenditure id'),
        'help' => t('Expenditure id'),
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
    $data['expenditure']['name'] = array(
        'title' => t('Name'),
        'help' => t('The name of expenditure.'),
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
    $data['expenditure']['total_cost'] = array(
        'title' => t('Total cost'),
        'help' => t('Total cost of expenditure'),
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
    $data['expenditure']['date'] = array(
        'title' => t('Created date'),
        'help' => t('Created date of the Expenditure.'),
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
    $data['expenditure']['note'] = array(
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