<?php

return [
    'index' => [
        'title' => 'Lista e Sllajdeve',
        'description' => 'Një pëshkrim shembull',
        'table' => [
            'id' => 'ID',
            'name' => 'Emri',
            'caption' => 'Titulli',
            'index' => 'Indexi',
            'description' => 'Përshkrimi',
            'status' => 'Statusi',
            'image' => 'Foto',
            'action' => 'Veprimet'
        ],
    ],
    'create' => [
        'title' => 'Shto Sllajd',
        'description' => 'Një pëshkrim shembull',
        'form' => [
            'name' => 'Emri',
            'caption' => 'Titulli',
            'index' => 'Indexi',
            'description' => 'Përshkrimi',
            'status' => 'Statusi',
            'image' => 'Foto'
        ],  
        'invalid_feedback' => 'Ju lutem vendosni valide fushen: ',
        'valid_feedback' => 'Pranohet!',
        'save' => 'Ruaj'               
    ],
    'edit' => [
        'title' => 'Ndryshimi i Sllajdit',
        'description' => 'Azhuroni fushat e mëposhtme të sllajdit',
        'form' => [
            'name' => 'Emri',
            'caption' => 'Titulli',
            'index' => 'Indexi',
            'description' => 'Përshkrimi',
            'status' => 'Statusi',
            'image' => 'Foto'
        ],
        'invalid_feedback' => 'Ju lutem vendosni valide fushen: ',
        'valid_feedback' => 'Pranohet!',
        'save_changes' => 'Ruaj Ndryshimet'       
    ],
    'show' => [
        'title' => 'Detajet e Sllajdit',
        'description' => 'Një pëshkrim shembull',
        'fields' => [
            'name' => 'Emri',
            'caption' => 'Titulli',
            'index' => 'Indexi',
            'description' => 'Përshkrimi',
            'status' => 'Statusi',
            'image' => 'Foto'
        ],        
        'edit' => 'Ndrysho',
        'delete' => 'Fshije',
    ],
    'active' => 'Aktiv',
    'inactive' => 'Pasiv'
];