<?php

return [
    'index' => [
        'title' => 'Lista e Planeve',
        'description' => 'Një pëshkrim shembull',
        'table' => [
            'id' => 'ID',
            'name' => 'Emri',
            'monthly' => 'Mujore',
            'yearly' => 'Vjetore',
            'popular' => 'Preferuar',
            'index' => 'Indexi',
            'status' => 'Statusi',
            'action' => 'Veprimet'
        ],
    ],
    'create' => [
        'title' => 'Shto Plan',
        'description' => 'Një pëshkrim shembull',
        'form' => [
            'name' => 'Emri',
            'monthly' => 'Mujore',
            'yearly' => 'Vjetore',
            'popular' => 'Preferuar',
            'index' => 'Indexi',
            'status' => 'Statusi',
        ],  
        'invalid_feedback' => 'Ju lutem vendosni valide fushen: ',
        'valid_feedback' => 'Pranohet!',
        'save' => 'Ruaj'               
    ],
    'edit' => [
        'title' => 'Ndryshimi i planit',
        'description' => 'Azhuroni fushat e mëposhtme të sliderit',
        'form' => [
            'name' => 'Emri',
            'monthly' => 'Mujore',
            'yearly' => 'Vjetore',
            'popular' => 'Preferuar',
            'index' => 'Indexi',
            'status' => 'Statusi',
        ],
        'invalid_feedback' => 'Ju lutem vendosni valide fushen: ',
        'valid_feedback' => 'Pranohet!',
        'save_changes' => 'Ruaj Ndryshimet'       
    ],
    'show' => [
        'title' => 'Detajet e planit',
        'description' => 'Një pëshkrim shembull',
        'fields' => [
            'name' => 'Emri',
            'monthly' => 'Mujore',
            'yearly' => 'Vjetore',
            'popular' => 'Preferuar',
            'index' => 'Indexi',
            'status' => 'Statusi',
        ],        
        'edit' => 'Ndrysho',
        'delete' => 'Fshije',
    ],
    'active' => 'Aktiv',
    'inactive' => 'Pasiv',
    'yes' => 'Po',
    'no' => 'Jo',
    'currency' => ':value€'
];