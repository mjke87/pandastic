<?php

namespace App\Models;

use App\Models\Role;

class User extends Model {

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'role',
        'birthday',
        'multiplier',
        'goal',
        'goal_name', // funding goal description
    ];

    /**
     * Get all users with a specific role.
     *
     * @param Role $role
     * @return array<User>
     */
    public static function withRole(Role $role) {
        return array_filter(self::all(), fn($u) => $u->role === $role->value);
    }

    /**
     * Get all grades belonging to this user.
     *
     * @return array
     */
    public function grades() {
        $grades = Grade::all();
        return array_filter($grades, fn($grade) => $grade->user_id === $this->id);
    }

    /**
     * Check if the user's role matches the given Role or string.
     *
     * @param Role $role
     * @return bool
     */
    public function isRole(Role $role): bool {
        return $this->role === $role->value;
    }

    /**
     * Get the user's permissions based on their role.
     *
     * @return array
     */
    public function permissions(): array {
        $role = $this->role;
        $permissions = config('permissions');
        return $permissions[$role] ?? [];
    }

    /**
     * Check if the user has the given permission.
     *
     * @param string $permission
     * @return bool
     */
    public function can(string $permission): bool {
        return in_array($permission, $this->permissions());
    }

    /**
     * Calculate total funds earned by this user.
     * @return float
     */
    public function totalFundsEarned() {
        $grades = $this->grades();
        $total = 0;
        foreach ($grades as $grade) {
            $total += floatval($grade->reward());
        }
        return $total;
    }
}
