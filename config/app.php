<?php

return [
    'source_dir' => APP_ROOT . '/App',
    'data_dir' => APP_ROOT . '/data',
    'public_dir' => APP_ROOT . '/public',
    'vendor_dir' => APP_ROOT . '/vendor',
    'config_dir' => __DIR__,
    'templates_dir' => APP_ROOT . '/views',

    'name' => 'Pandastic',

    'currency' => 'CHF ',
    // Grade rewards: grade value => reward amount
    'grade_rewards' => [
        6 => 10,
        5.75 => 7.5,
        5.5 => 5,
        5 => 2,
    ],

    'date_format' => 'd.m.Y',

    'storage' => 'file', // or 'database'
];
