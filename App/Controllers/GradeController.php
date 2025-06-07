<?php

namespace App\Controllers;

use App\Models\Grade;
use App\Models\User;

class GradeController extends ResourceController {

    /**
     * Create a new instance of this controller.
     */
    public function __construct() {
        parent::__construct('grade', Grade::class);
    }

    /**
     * @permission view grades
     */
    public function index(): void {
        parent::index();
    }

    /**
     * @permission create grades
     */
    public function create(): void {
        parent::create();
    }

    /**
     * @permission create grades
     */
    public function store(): void {
        parent::store();
    }

    /**
     * @permission edit grades
     */
    public function edit(string $id): void {
        parent::edit($id);
    }

    /**
     * @permission modify grades
     */
    public function update(string $id): void {
        parent::update($id);
    }

    /**
     * @permission delete grades
     */
    public function destroy(string $id): void {
        parent::destroy($id);
    }

    /**
     * @permission view grades
     */
    public function show(string $id): void {
        parent::show($id);
    }

    protected function sanitize($data, $action) {
        // Only allow relevant fields for add/update
        return [
            'grade' => $data['grade'] ?? '',
            'date' => $data['date'] ?? date('Y-m-d'),
            'subject' => $data['subject'] ?? '',
            'user_id' => $data['user_id'] ?? null,
            'reward' => $data['reward'] ?? 0,
        ];
    }

    protected function validate($data) {

        // Validate required fields
        $requiredFields = ['grade', 'subject', 'user_id'];
        $invalid = array_diff($requiredFields, array_keys($data));

        // Abort early if required fields are missing
        if (!empty($invalid)) {
            return $invalid;
        }

        // Check if date is valid
        if ($data['date'] && !\DateTime::createFromFormat('Y-m-d', $data['date'])) {
            $invalid[] = 'date';
        }

        // Check if user_id is valid
        if (isset($data['user_id']) && !User::get($data['user_id'])) {
            $invalid[] = 'user_id';
        }
        return $invalid;
    }
}
