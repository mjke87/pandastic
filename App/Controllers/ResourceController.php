<?php

namespace App\Controllers;

/**
 * Abstract ResourceController providing standard CRUD actions for resources.
 *
 * Child controllers should call parent::__construct($resource, $model)
 * and may override preStore, preUpdate, postUpdate, sanitize, and validate as needed.
 *
 * @package App\Controllers
 */
abstract class ResourceController extends Controller {

    /**
     * @var string The resource name (e.g. 'grade', 'user')
     */
    protected $resource;

    /**
     * @var string The fully qualified model class name
     */
    protected $model;

    /**
     * ResourceController constructor.
     *
     * @param string $resource
     * @param string $model
     */
    public function __construct($resource, $model) {
        $this->resource = $resource;
        $this->model = $model;
    }

    /**
     * List all resources.
     *
     * @return void
     */
    public function index(): void {
        $model = $this->model;
        $items = $model::all();
        $this->render($this->resource . '.list', ['items' => $items]);
    }

    /**
     * Show form to create a new resource.
     *
     * @return void
     */
    public function create(): void {
        $model = $this->model;
        $this->render($this->resource . '.edit', [$this->resource => $model::make()]);
    }

    /**
     * Store a new resource.
     *
     * @return void
     */
    public function store(): void {
        $model = $this->model;
        $data = $this->request()->getData();
        $user = current_user();
        $data = $this->preStore($data, $user);
        $invalid = $this->validate($data);
        if (empty($invalid)) {
            $model::add($this->sanitize($data, 'add'));
            $this->redirect($this->resource . '.index');
        } else {
            $this->render($this->resource . '.edit', [
                $this->resource => $model::fill($data),
                'error' => __('The following fields are invalid or missing:'),
                'fields' => $invalid,
            ]);
        }
    }

    /**
     * Show form to edit a resource.
     *
     * @param string $id
     * @return void
     */
    public function edit(string $id): void {
        $model = $this->model;
        $item = $model::get($id);
        if (!$item) {
            $this->notFound();
        }
        $this->render($this->resource . '.edit', [$this->resource => $item]);
    }

    /**
     * Update a resource.
     *
     * @param string $id
     * @return void
     */
    public function update(string $id): void {
        $model = $this->model;
        $data = $this->request()->getData();
        $user = current_user();
        $data = $this->preUpdate($data, $user, $id);
        $invalid = $this->validate($data);
        if (empty($invalid)) {
            $model::update($id, $this->sanitize($data, 'update'));
            $this->postUpdate($id, $data);
            $this->flash(__(':resource updated successfully.', ['resource' => __($this->resource)]), 'success');
            $this->render($this->resource . '.detail', [
                $this->resource => $model::get($id),
            ]);
        } else {
            $this->flash(__('Failed to update :resource.', ['resource' => __($this->resource)]), 'error');
            $this->render($this->resource . '.edit', [
                $this->resource => $model::fill($data),
                'error' => __('The following fields are invalid or missing:'),
                'fields' => $invalid,
            ]);
        }
    }

    /**
     * Delete a resource.
     *
     * @param string $id
     * @return void
     */
    public function destroy(string $id): void {
        $model = $this->model;
        $model::delete($id);
        $this->redirect($this->resource . '.index');
    }

    /**
     * Show a resource.
     *
     * @param string $id
     * @return void
     */
    public function show(string $id): void {
        $model = $this->model;
        $item = $model::get($id);
        if (!$item) {
            $this->notFound();
            return;
        }
        $this->render($this->resource . '.detail', [$this->resource => $item]);
    }

    /**
     * Sanitize data before add/update.
     * Override in child if needed.
     *
     * @param array $data
     * @param string $action
     * @return array
     */
    protected function sanitize($data, $action) {
        return $data;
    }

    /**
     * Hook before storing a resource.
     * Override in child if needed.
     *
     * @param array $data
     * @param mixed $user
     * @return array
     */
    protected function preStore($data, $user) {
        return $data;
    }

    /**
     * Hook before updating a resource.
     * Override in child if needed.
     *
     * @param array $data
     * @param mixed $user
     * @param string $id
     * @return array
     */
    protected function preUpdate($data, $user, $id) {
        return $data;
    }

    /**
     * Hook after updating a resource.
     * Override in child if needed.
     *
     * @param string $id
     * @param array $data
     * @return void
     */
    protected function postUpdate($id, $data) {
        // No-op
    }

    /**
     * Validate the data for creating or editing a resource.
     * Override in child if needed.
     *
     * @param array $data The data to validate
     * @return array List of invalid fields, empty if all are valid
     */
    protected function validate(array $data) {
        // Default implementation, can be overridden in child classes
        $requiredFields = []; // Example fields, adjust as needed
        $invalid = array_diff($requiredFields, array_keys($data));
        return $invalid;
    }

    /**
     * Render a view when the resource is not found.
     *
     * @return void
     */
    protected function notFound() {
        $this->error(
            __(':resource not found', ['resource' => __(ucfirst($this->resource))]),
            __('The requested :resource does not exist or has been deleted.', ['resource' => __($this->resource)])
        );
        exit;
    }
}
