<?php
namespace App\Controllers;

use App\Models\Reward;

class RewardController extends ResourceController {
    public function __construct() {
        parent::__construct('reward', Reward::class);
    }

    /**
     * @permission view rewards
     */
    public function index(): void {
        parent::index();
    }

    /**
     * @permission create rewards
     */
    public function create(): void {
        parent::create();
    }

    /**
     * @permission create rewards
     */
    public function store(): void {
        parent::store();
    }

    /**
     * @permission edit rewards
     */
    public function edit(string $id): void {
        parent::edit($id);
    }

    /**
     * @permission edit rewards
     */
    public function update(string $id): void {
        parent::update($id);
    }

    /**
     * @permission delete rewards
     */
    public function destroy(string $id): void {
        parent::destroy($id);
    }

    /**
     * @permission view rewards
     */
    public function show(string $id): void {
        parent::show($id);
    }

    public function validate(array $data): array {
        // Implement validation logic for reward data
        // Return validated data or throw an exception if invalid
        return []; // Placeholder, implement actual validation
    }
}
