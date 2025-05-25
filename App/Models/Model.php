<?php

namespace App\Models;

abstract class Model {

    protected $storage;
    protected $fileStorage;
    protected $databaseStorage;

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
        return array_map(fn($e) => (object) $e, self::make()->storage()->all());
    }
    public static function add($data) {
        return self::make()->storage()->add($data);
    }
    public static function get($id) {
        return (object) self::make()->storage()->get($id);
    }
    public static function update($id, $data) {
        return self::make()->storage()->update($id, $data);
    }
    public static function delete($id) {
        return self::make()->storage()->delete($id);
    }
}