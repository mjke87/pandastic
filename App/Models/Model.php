<?php

namespace App\Models;

abstract class Model {

    /**
     * The storage class used for file-based operations.
     *
     * @var class-string<\App\Storage\Storage>
     **/
    protected $fileStorage;

    /**
     * The storage class used for database operations.
     *
     * @var class-string<\App\Storage\Storage>
     **/
    protected $databaseStorage;

    /**
     * The data that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The storage instance used for data operations.
     *
     * @var \App\Storage\Storage|null
     */
    protected $storage;

    /**
     * The data of the model instance.
     * This data represents the current stored state of the model.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Model constructor.
     *
     * @param array $data
     */
    public function __construct($data = []) {
        $this->data = $data;
    }

    /**
     * Get an attribute from the model.
     *
     * @param string $name
     * @return mixed|null
     */
    public function __get($name) {
        return $this->data[$name] ?? null;
    }

    /**
     * Set an attribute on the model.
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value) {
        if (in_array($name, $this->fillable)) {
            $this->data[$name] = $value;
        }
    }

    /**
     * Determine if the given attribute is set.
     *
     * @param string $name
     * @return bool
     */
    public function __isset($name) {
        return isset($this->data[$name]);
    }

    /**
     * Test if the model is empty.
     *
     * @return bool
     */
    public function empty() {
        return empty($this->data);
    }

    /**
     * Test if the model has an ID, indicating it exists in storage.
     *
     * @return bool
     */
    public function exists() {
        return isset($this->data['id']);
    }

    /**
     * Test if a key is fillable in the model.
     *
     * @param string $key
     * @return bool
     */
    public function fillable($key) {
        return isset($this->fillable[$key]);
    }

    /**
     * Get the storage instance based on the configured storage type.
     *
     * @return \App\Storage\Storage
     */
    protected function storage() {
        if ($this->storage) {
            return $this->storage;
        }
        if (empty($this->fileStorage) || empty($this->databaseStorage)) {
            $this->defaultStorage();
        }
        $this->storage = match (config('app.storage')) {
            'database' => new $this->databaseStorage,
            default => $this->fileStorage::data(),
        };
        return $this->storage;
    }

    /**
     * Assume the storage classes based on the model class name.
     * By default, it will use the model class name to infer the storage classes.
     *
     * @return void
     */
    protected function defaultStorage() {
        $class = substr(strrchr(static::class, '\\'), 1);
        if (empty($this->fileStorage)) {
            $this->fileStorage = "\\App\\Storage\\File\\" . $class;
        }
        if (empty($this->databaseStorage)) {
            $this->databaseStorage = "\\App\\Storage\\Database\\" . $class;
        }
    }

    /**
     * Save the current model instance.
     *
     * @return $this
     */
    public function save() {
        if (isset($this->data['id'])) {
            $this->storage()->update($this->data['id'], $this->data);
        }
        return $this;
    }

    // ------------------------------------------------
    // Static methods for model operations and creation
    // ------------------------------------------------

    /**
     * Create a new instance of the model.
     *
     * @param array $data
     * @return static
     */
    public static function make($data = []) {
        return new static($data);
    }

    /**
     * Fil a model instance with data.
     * Note that only fillable fields will be set, the reset will be ignored.
     *
     * @param array $data
     * @return static
     */
    public static function fill($data = []) {
        $instance = new static();
        foreach ($data as $key => $value) {
            if (in_array($key, $instance->fillable)) {
                $instance->data[$key] = $value;
            }
        }
        return $instance;
    }
    /**
     * Get all model records.
     *
     * @return static[]
     */
    public static function all() {
        return array_map(fn($e) => new static($e), self::make()->storage()->all());
    }

    /**
     * Add a new model record.
     *
     * @param array $data
     * @return static
     */
    public static function add($data) {
        self::make()->storage()->add($data);
        return new static($data);
    }

    /**
     * Get a model record by ID.
     *
     * @param mixed $id
     * @return static|null
     */
    public static function get($id) {
        $data = self::make()->storage()->get($id);
        return $data ? new static($data) : null;
    }

    /**
     * Update a model record by ID.
     *
     * @param mixed $id
     * @param array $data
     * @return static
     */
    public static function update($id, $data) {
        $instance = self::get($id);
        if (!$instance) {
            return $instance;
        }
        foreach ($data as $key => $value) {
            $instance->{$key} = $value;
        }
        $instance->save();
        return $instance;
    }

    /**
     * Delete a model record by ID.
     *
     * @param mixed $id
     * @return mixed
     */
    public static function delete($id) {
        return self::make()->storage()->delete($id);
    }
}