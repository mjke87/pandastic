<?php

namespace App\Models;

use App\Models\Role;

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
        return $this->role === $role->value || $this->role === (string)$role;
    }
}
