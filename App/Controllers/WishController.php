<?php
namespace App\Controllers;

use App\Models\Wish;

class WishController extends ResourceController {
    public function __construct() {
        parent::__construct('wish', Wish::class);
    }

    /**
     * @permission view wishes
     */
    public function index(): void {
        parent::index();
    }

    /**
     * @permission create wishes
     */
    public function create(): void {
        parent::create();
    }

    /**
     * @permission create wishes
     */
    public function store(): void {
        parent::store();
    }

    /**
     * @permission edit wishes
     */
    public function edit(string $id): void {
        parent::edit($id);
    }

    /**
     * @permission edit wishes
     */
    public function update(string $id): void {
        parent::update($id);
    }

    /**
     * @permission delete wishes
     */
    public function destroy(string $id): void {
        parent::destroy($id);
    }

    /**
     * @permission view wishes
     */
    public function show(string $id): void {
        parent::show($id);
    }

    /**
     * @permission fulfill wishes
     */
    public function fulfill(string $id): void {
        $wish = Wish::get($id);
        $user = current_user();
        if ($wish && $user->can('fulfill wishes')) {
            Wish::update($id, [
                'is_fulfilled' => true,
                'fulfilled_by' => $user->id,
                'fulfilled_at' => date('Y-m-d H:i:s'),
            ]);
        }
        $this->redirect('/wishes');
    }

    protected function sanitize($data, $action) {
        return [
            'title' => $data['title'] ?? '',
            'description' => $data['description'] ?? '',
            'user_id' => $data['user_id'] ?? null,
            'value' => $data['value'] ?? 0,
            'is_fulfilled' => $data['is_fulfilled'] ?? false,
            'fulfilled_by' => $data['fulfilled_by'] ?? null,
            'fulfilled_at' => $data['fulfilled_at'] ?? null,
        ];
    }

    protected function preStore($data, $user) {
        $data['user_id'] = $user->id;
        $data['value'] = $data['value'] ?? 0;
        $data['is_fulfilled'] = false;
        $data['fulfilled_by'] = null;
        $data['fulfilled_at'] = null;
        return $data;
    }

    protected function preUpdate($data, $user, $id) {
        $data['user_id'] = $user->can('manage users') ? ($data['user_id'] ?? '') : $user->id;
        return $data;
    }

    protected function validate($data) {
        $requiredFields = ['title', 'user_id'];
        $invalid = array_diff($requiredFields, array_keys($data));
        if (!empty($invalid)) {
            return $invalid;
        }
        if (isset($data['value']) && !is_numeric($data['value'])) {
            $invalid[] = 'value';
        }
        return $invalid;
    }
}
