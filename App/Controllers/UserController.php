<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends ResourceController
{
    public function __construct() {
        parent::__construct('user', User::class);
    }

    /**
     * @permission view users
     */
    public function index(): void {
        parent::index();
    }

    /**
     * @permission create users
     */
    public function create(): void {
        parent::create();
    }

    /**
     * @permission create users
     */
    public function store(): void {
        parent::store();
    }

    /**
     * @permission edit users
     */
    public function edit(string $id): void {
        parent::edit($id);
    }

    /**
     * @permission edit users
     */
    public function update(string $id): void {
        parent::update($id);
    }

    /**
     * @permission delete users
     */
    public function destroy(string $id): void {
        parent::destroy($id);
    }

    /**
     * @permission view users
     */
    public function show(string $id): void {
        parent::show($id);
    }

    protected function sanitize($data, $action) {
        $sanitized = [
            'username' => $data['username'] ?? '',
            'name' => $data['name'] ?? '',
            'birthday' => $data['birthday'] ?? '',
            'multiplier' => floatval($data['multiplier'] ?? 1),
            'goal' => floatval($data['goal'] ?? 100),
            'goal_name' => $data['goal_name'] ?? '',
        ];
        if ($action === 'add' && !empty($data['password'])) {
            $sanitized['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        if ($action === 'update' && !empty($data['password'])) {
            $sanitized['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return $sanitized;
    }

    protected function validate($data) {
        $requiredFields = ['username', 'name'];
        $invalid = array_diff($requiredFields, array_keys($data));
        if (!empty($invalid)) {
            return $invalid;
        }
        // Optionally validate more fields here
        return $invalid;
    }
}
