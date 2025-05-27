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
        'reward', // added
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

    /**
     * Get the grade reward as a float (stored value or default from config).
     *
     * @return float
     */
    public function reward() {
        if (isset($this->reward) && $this->reward !== '') {
            return floatval($this->reward);
        }
        // Default: get from config based on grade value
        $gradeValue = isset($this->grade) ? floatval($this->grade) : 0;
        $rewards = config('app.grade_rewards') ?? [];
        foreach ($rewards as $minGrade => $amount) {
            if ($gradeValue >= $minGrade) {
                return $amount;
            }
        }
        return 0;
    }
}