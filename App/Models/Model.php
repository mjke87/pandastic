<?php

namespace App\Models;

abstract class Model {

    protected $storage;
    protected $fileStorage;
    protected $databaseStorage;
    protected $attributes = [];

    public function __construct($attributes = []) {
        $this->attributes = $attributes;
    }

    public function __get($name) {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value) {
        $this->attributes[$name] = $value;
    }

    public function isset($name) {
        return isset($this->attributes[$name]);
    }

    protected static function make() {
        return new static();
    }

    protected function storage() {
        if ($this->storage) {
            return $this->storage;
        }
        $this->storage = match (config('app.storage')) {
            'database' => new $this->databaseStorage,
            default => $this->fileStorage::data(),
        };
        return $this->storage;
    }

    public static function all() {
        return array_map(fn($e) => new static($e), self::make()->storage()->all());
    }

    public static function add($data) {
        self::make()->storage()->add($data);
        return new static($data);
    }

    public static function get($id) {
        $data = self::make()->storage()->get($id);
        return $data ? new static($data) : null;
    }

    public static function update($id, $data) {
        $data['id'] = $id;
        $instance = new static($data);
        $instance->save();
        return $instance;
    }

    public static function delete($id) {
        return self::make()->storage()->delete($id);
    }

    public function save() {
        if (isset($this->attributes['id'])) {
            $this->storage()->update($this->attributes['id'], $this->attributes);
        }
        return $this;
    }
}