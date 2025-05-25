<?php

namespace App\Models;

class User extends Model {

    /**
     * The storage class used for file-based operations.
     *
     * @var class-string<\App\Storage\Storage>
     **/
    protected $fileStorage = \App\Storage\File\User::class;

    /**
     * The storage class used for database operations.
     *
     * @var class-string<\App\Storage\Storage>
     **/
    protected $databaseStorage = \App\Storage\Database\User::class;
}
