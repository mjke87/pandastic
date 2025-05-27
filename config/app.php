<?php

return [
    'source_dir' => __DIR__ . '/../App',
    'data_dir' => __DIR__ . '/../data',
    'public_dir' => __DIR__ . '/../public',
    'vendor_dir' => __DIR__ . '/../vendor',
    'config_dir' => __DIR__,
    'templates_dir' => __DIR__ . '/../views',

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
