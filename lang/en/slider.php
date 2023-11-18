<?php

return [
    'index' => [
        'title' => 'Slider List',
        'description' => 'This is a sample description',
        'table' => [
            'id' => 'ID',
            'name' => 'Name',
            'caption' => 'Caption',
            'index' => 'Index',
            'description' => 'Description',
            'status' => 'Status',
            'image' => 'Image',
            'action' => 'Action'
        ],
    ], 
    'create' => [
        'title' => 'Create Slider',
        'description' => 'This is a sample description',
        'form' => [
            'name' => 'Name',
            'caption' => 'Caption',
            'index' => 'Index',
            'description' => 'Description',
            'status' => 'Status',
            'image' => 'Image'
        ],
        'invalid_feedback' => 'Please enter valid: ',
        'valid_feedback' => 'Look\'s Good!',
        'save' => 'Save'        
    ],
    'edit' => [
        'title' => 'Slider Edit',
        'description' => 'Update the slider fields below',
        'form' => [
            'name' => 'Name',
            'caption' => 'Caption',
            'index' => 'Index',
            'description' => 'Description',
            'status' => 'Status',
            'image' => 'Image'
        ],
        'invalid_feedback' => 'Please enter valid: ',
        'valid_feedback' => 'Look\'s Good!',
        'save_changes' => 'Save Changes'
    ],
    'show' => [
        'title' => 'Slider Details',
        'description' => 'This is a sample description',
        'fields' => [
            'name' => 'Name',
            'caption' => 'Caption',
            'index' => 'Index',
            'description' => 'Description',
            'status' => 'Status',
            'image' => 'Image'
        ],        
        'edit' => 'Edit',
        'delete' => 'Delete',
    ],
    'active' => 'Active',
    'inactive' => 'Pasive'
];