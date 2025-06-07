<?php
namespace App\Models;

class Wish extends Model {

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'description',
        'value',
        'is_fulfilled',
        'fulfilled_by',
        'fulfilled_at',
    ];

    /**
     * Get the user who owns this wish.
     *
     * @return User|null
     */
    public function user() {
        if (!isset($this->user_id)) {
            return null;
        }
        return User::get($this->user_id);
    }

    /**
     * Get the person who fulfilled this wish (guardian or parent).
     *
     * @return float
     */
    public function fullfiller() {
        if (!isset($this->fulfilled_by)) {
            return null;
        }
        return User::get($this->fulfilled_by);
    }
}
