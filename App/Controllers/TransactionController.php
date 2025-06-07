<?php
namespace App\Controllers;

use App\Models\Transaction;

class TransactionController extends ResourceController {
    public function __construct() {
        parent::__construct('transaction', Transaction::class);
    }

    /**
     * @permission view transactions
     */
    public function index(): void {
        parent::index();
    }

    /**
     * @permission create transactions
     */
    public function create(): void {
        parent::create();
    }

    /**
     * @permission create transactions
     */
    public function store(): void {
        parent::store();
    }

    /**
     * @permission edit transactions
     */
    public function edit(string $id): void {
        parent::edit($id);
    }

    /**
     * @permission edit transactions
     */
    public function update(string $id): void {
        parent::update($id);
    }

    /**
     * @permission delete transactions
     */
    public function destroy(string $id): void {
        parent::destroy($id);
    }

    /**
     * @permission view transactions
     */
    public function show(string $id): void {
        parent::show($id);
    }

    // Optionally add validation/sanitization as needed
}
