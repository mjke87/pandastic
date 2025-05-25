<?php

namespace App\Models;

class Grade extends Model {

    /**
     * The storage class used for file-based operations.
     *
     * @var class-string<\App\Storage\Storage>
     **/
    protected $fileStorage = \App\Storage\File\Grade::class;

    /**
     * The storage class used for database operations.
     *
     * @var class-string<\App\Storage\Storage>
     **/
    protected $databaseStorage = \App\Storage\Database\Grade::class;
}