<?php

return [
    'parent' => [
        'view users',
        'create users',
        'edit users',
        'delete users',
        'manage users',
        'view grades',
        'create grades',
        'edit grades',
        'delete grades',
        'manage grades',
    ],
    'child' => [
        //'view users',
        'view grades',
    ],
    'guest' => [
        // No permissions
    ],
];
