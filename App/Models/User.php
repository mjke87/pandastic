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

    /**
     * Get all grades belonging to this user.
     *
     * @return array
     */
    public function grades() {
        $grades = Grade::all();
        return array_filter($grades, fn($grade) => $grade->user_id === $this->id);
    }
}
