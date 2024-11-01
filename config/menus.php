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
            'submenus' => [
                [
                    'title' => 'Machines',
                    'route' => 'dashboard'
                ],
                [
                    'title' => 'Watch',
                    'route' => 'watch_dashboard'
                ],
            ]
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
                [
                    'title' => 'Machines',
                    'route' => 'machines.index'
                ],
                [
                    'title' => 'Machine Types',
                    'route' => 'machinetypes.index'
                ],
                [
                    'title' => 'Segment',
                    'route' => 'segments.index'
                ],
            ]

        ],
        [
            'title' => 'Records',
            'route' => 'statusrecords.index'
        ],
    ]
];
