<?php
namespace App\Models;

class Reward extends Model {

    protected $fillable = [
        'id',
        'title',
        'description',
        'value',
        'is_claimed',
        'claimed_by',
        'claimed_at',
        'approved',
        'approved_by',
        'approved_at'
    ];

    /**
     * Get the user who claimed this reward.
     *
     * @return User|null
     */
    public function claimer() {
        if (!isset($this->claimed_by)) {
            return null;
        }
        return User::get($this->claimed_by);
    }

    /**
     * Get the user who approved this reward claim.
     *
     * @return User|null
     */
    public function approver() {
        if (!isset($this->approved_by)) {
            return null;
        }
        return User::get($this->approved_by);
    }
    /**
     * Get the user who created this reward.
     *
     * @return User|null
     */
    public function creator() {
        if (!isset($this->created_by)) {
            return null;
        }
        return User::get($this->created_by);
    }
}
