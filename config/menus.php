<?php

return [

    /*
    |--------------------------------------------------------------------------
    | DEFINE MENU
    |--------------------------------------------------------------------------
    */

    'items' => [
        [
            'title' => 'Dashboard',
            'route' => 'dashboard'
        ],
        [
            'title' => 'Masterfile',
            'submenus' => [
                [
                    'title' => 'Users',
                    'route' => 'users.index'
                ],
                [
                    'title' => 'Status',
                    'route' => 'statuses.index'
                ],
                [
                    'title' => 'Groups',
                    'route' => 'groups.index'
                ],
                [
                    'title' => 'Watches',
                    'route' => 'watches.index'
                ],
            ]

        ]
    ]
];
