<?php
namespace App\Models;

class Transaction extends Model {

    protected $fillable = [
        'grade',
        'date',
        'subject',
        'user_id',
        'reward', // added
    ];
}
