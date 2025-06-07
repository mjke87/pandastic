<?php
namespace App\Controllers;

use App\Models\Chore;
use App\Models\User;

class ChoreController extends ResourceController {
    public function __construct() {
        parent::__construct('chore', Chore::class);
    }

    /**
     * @permission view chores
     */
    public function index(): void {
        parent::index();
    }

    /**
     * @permission create chores
     */
    public function create(): void {
        parent::create();
    }

    /**
     * @permission create chores
     */
    public function store(): void {
        parent::store();
    }

    /**
     * @permission edit chores
     */
    public function edit(string $id): void {
        parent::edit($id);
    }

    /**
     * @permission edit chores
     */
    public function update(string $id): void {
        parent::update($id);
    }

    /**
     * @permission delete chores
     */
    public function destroy(string $id): void {
        parent::destroy($id);
    }

    /**
     * @permission claim chores
     */
    public function claim(string $id): void {
        $chore = Chore::get($id);
        $user = current_user();
        if ($chore && !$chore->is_done && $user->id) {
            Chore::update($id, [
                'is_done' => true,
                'done_at' => date('Y-m-d H:i:s'),
                'user_id' => $user->id,
            ]);
        }
        $this->redirect('chore.show', ['id' => $id]);
    }

    /**
     * @permission approve chores
     */
    public function approve(string $id): void {
        $chore = Chore::get($id);
        $user = current_user();
        if ($chore && $chore->is_done && !$chore->approved && $user->can('approve chores')) {
            Chore::update($id, [
                'approved' => true,
                'approved_by' => $user->id,
                'approved_at' => date('Y-m-d H:i:s'),
            ]);
        }
        $this->redirect('chore.show', ['id' => $id]);
    }

    protected function sanitize($data, $action) {
        return [
            'title' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'user_id' => $data['user_id'] ?? null,
            'value' => $data['value'] ?? 0,
            'is_done' => $data['is_done'] ?? false,
            'done_at' => $data['done_at'] ?? null,
            'approved' => $data['approved'] ?? false,
            'approved_by' => $data['approved_by'] ?? null,
            'approved_at' => $data['approved_at'] ?? null,
        ];
    }

    protected function preStore($data, $user) {
        $data['is_done'] = false;
        $data['done_at'] = null;
        $data['approved'] = false;
        $data['approved_by'] = null;
        $data['approved_at'] = null;
        $data['user_id'] = $user->can('manage users') ? ($data['user_id'] ?? '') : $user->id;
        return $data;
    }

    protected function preUpdate($data, $user, $id) {
        $data['user_id'] = $user->can('manage users') ? ($data['user_id'] ?? '') : $user->id;
        return $data;
    }

    protected function validate($data) {
        $requiredFields = ['title', 'user_id', 'value'];
        $invalid = array_diff($requiredFields, array_keys($data));
        if (!empty($invalid)) {
            return $invalid;
        }
        if (isset($data['value']) && !is_numeric($data['value'])) {
            $invalid[] = 'value';
        }
        if (isset($data['user_id']) && !User::get($data['user_id'])) {
            $invalid[] = 'user_id';
        }
        return $invalid;
    }
}
