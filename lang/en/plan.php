<?php

return [
    'index' => [
        'title' => 'Plan List',
        'description' => 'This is a sample description',
        'table' => [
            'id' => 'ID',
            'name' => 'Name',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
            'popular' => 'popular',
            'index' => 'Index',
            'status' => 'Status',
            'action' => 'Action'
        ],
    ], 
    'create' => [
        'title' => 'Create Plan',
        'description' => 'This is a sample description',
        'form' => [
            'name' => 'Name',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
            'popular' => 'popular',
            'index' => 'Index',
            'status' => 'Status'
        ],
        'invalid_feedback' => 'Please enter valid: ',
        'valid_feedback' => 'Look\'s Good!',
        'save' => 'Save'        
    ],
    'edit' => [
        'title' => 'Plan Edit',
        'description' => 'Update the slider fields below',
        'form' => [
            'name' => 'Name',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
            'popular' => 'popular',
            'index' => 'Index',
            'status' => 'Status'
        ],
        'invalid_feedback' => 'Please enter valid: ',
        'valid_feedback' => 'Look\'s Good!',
        'save_changes' => 'Save Changes'
    ],
    'show' => [
        'title' => 'Plan Details',
        'description' => 'This is a sample description',
        'fields' => [
            'name' => 'Name',
            'monthly' => 'Monthly',
            'yearly' => 'Yearly',
            'popular' => 'popular',
            'index' => 'Index',
            'status' => 'Status'
        ],        
        'edit' => 'Edit',
        'delete' => 'Delete',
    ],
    'active' => 'Active',
    'inactive' => 'Pasive',
    'yes' => 'Yes',
    'no' => 'No',
    'currency' => ':value€'
];