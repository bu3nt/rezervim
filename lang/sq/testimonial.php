<?php

return [
    'index' => [
        'title' => 'Lista e Dëshmive',
        'description' => 'Një pëshkrim shembull',
        'table' => [
            'id' => 'ID',
            'name' => 'Emri',
            'position' => 'Pozita',
            'rating' => 'Vlerësimi',
            'message' => 'Mesazhi',
            'status' => 'Statusi',
            'image' => 'Foto',
            'action' => 'Veprimet'
        ],
    ],
    'create' => [
        'title' => 'Shto Dëshmi',
        'description' => 'Një pëshkrim shembull',
        'form' => [
            'name' => 'Emri',
            'position' => 'Pozita',
            'rating' => 'Vlerësimi',
            'message' => 'Mesazhi',
            'status' => 'Statusi',
            'image' => 'Foto'
        ],  
        'invalid_feedback' => 'Ju lutem vendosni valide fushen: ',
        'valid_feedback' => 'Pranohet!',
        'save' => 'Ruaj'               
    ],
    'edit' => [
        'title' => 'Ndryshimi i dëshmisë',
        'description' => 'Azhuroni fushat e mëposhtme të dëshmisë',
        'form' => [
            'name' => 'Emri',
            'position' => 'Pozita',
            'rating' => 'Vlerësimi',
            'message' => 'Mesazhi',
            'status' => 'Statusi',
            'image' => 'Foto'
        ],
        'invalid_feedback' => 'Ju lutem vendosni valide fushen: ',
        'valid_feedback' => 'Pranohet!',
        'save_changes' => 'Ruaj Ndryshimet'       
    ],
    'show' => [
        'title' => 'Detajet e dëshmisë',
        'description' => 'Një pëshkrim shembull',
        'fields' => [
            'name' => 'Emri',
            'position' => 'Pozita',
            'rating' => 'Vlerësimi',
            'message' => 'Mesazhi',
            'status' => 'Statusi',
            'image' => 'Foto'
        ],        
        'edit' => 'Ndrysho',
        'delete' => 'Fshije',
    ],
    'active' => 'Aktiv',
    'inactive' => 'Pasiv'
];