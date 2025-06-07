<?php
namespace App\Models;

class Chore extends Model {

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'description',
        'bambux_reward',
        'is_done',
        'done_at',
        'approved',
        'approved_by',
        'approved_at',
    ];

    /**
     * Get the user who owns this chore.
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
     * Get the person who approved this chore (guardian or parent).
     *
     * @return User|null
     */
    public function approver() {
        if (!isset($this->approved_by)) {
            return null;
        }
        return User::get($this->approved_by);
    }
}
