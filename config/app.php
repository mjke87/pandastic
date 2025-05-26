<?php

return [
    'source_dir' => __DIR__ . '/../App',
    'data_dir' => __DIR__ . '/../data',
    'public_dir' => __DIR__ . '/../public',
    'vendor_dir' => __DIR__ . '/../vendor',
    'config_dir' => __DIR__,
    'templates_dir' => __DIR__ . '/../views',

    'name' => 'Pandastic',

    'currency' => '$',
    'grade_rewards' => [
        6 => 10,
        5.75 => 7.5,
        5.5 => 5,
        5 => 2,
    ],

    'storage' => 'file', // or 'database'

    //'roles' => [
    //    'parent' => 'Parent',
    //    'child' => 'Child',
    //],
];
