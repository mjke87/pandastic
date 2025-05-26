<?php

namespace App\Models;

class Grade extends Model {

    protected $fileStorage = \App\Storage\File\Grade::class;
    protected $databaseStorage = \App\Storage\Database\Grade::class;
    protected $fillable = [
        'grade',
        'date',
        'subject',
        'user_id',
    ];

    /**
     * Get the user who owns this grade.
     *
     * @return User|null
     */
    public function user() {
        if (!isset($this->user_id)) {
            return null;
        }
        return User::get($this->user_id);
    }
}