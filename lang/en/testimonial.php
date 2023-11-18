<?php

return [
    'index' => [
        'title' => 'Testimonial List',
        'description' => 'This is a sample description',
        'table' => [
            'id' => 'ID',
            'name' => 'Name',
            'position' => 'Position',
            'rating' => 'Rating',
            'message' => 'Message',
            'status' => 'Status',
            'image' => 'Image',
            'action' => 'Action'
        ],
    ], 
    'create' => [
        'title' => 'Create Testimonial',
        'description' => 'This is a sample description',
        'form' => [
            'name' => 'Name',
            'position' => 'Position',
            'rating' => 'Rating',
            'message' => 'Message',
            'status' => 'Status',
            'image' => 'Image'
        ],
        'invalid_feedback' => 'Please enter valid: ',
        'valid_feedback' => 'Look\'s Good!',
        'save' => 'Save'        
    ],
    'edit' => [
        'title' => 'Testimonial Edit',
        'description' => 'Update the testimonial fields below',
        'form' => [
            'name' => 'Name',
            'position' => 'Position',
            'rating' => 'Rating',
            'message' => 'Message',
            'status' => 'Status',
            'image' => 'Image'
        ],
        'invalid_feedback' => 'Please enter valid: ',
        'valid_feedback' => 'Look\'s Good!',
        'save_changes' => 'Save Changes'
    ],
    'show' => [
        'title' => 'Testimonial Details',
        'description' => 'This is a sample description',
        'fields' => [
            'name' => 'Name',
            'position' => 'Position',
            'rating' => 'Rating',
            'message' => 'Message',
            'status' => 'Status',
            'image' => 'Image'
        ],        
        'edit' => 'Edit',
        'delete' => 'Delete',
    ],
    'active' => 'Active',
    'inactive' => 'Pasive'
];