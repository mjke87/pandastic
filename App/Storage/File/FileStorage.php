<?php

namespace App\Storage\File;
use Exception;
use App\Storage\Storage;

abstract class FileStorage implements Storage {

    protected $filePath;
    protected $fileLock;
    protected static $file = null;

    public static function data() {
        $instance = new static();
        $data_dir = config('app.data_dir');
        $instance->filePath = $data_dir . '/' . static::$file . '.json';
        $instance->fileLock = fopen($instance->filePath, 'c+');
        if (!$instance->fileLock) {
            throw new Exception("Could not open " . $instance->filePath . " for locking. Check permissions.");
        }
        register_shutdown_function([$instance, 'close']);
        return $instance;
    }

    protected function lock() {
        if (!flock($this->fileLock, LOCK_EX)) {
            throw new Exception("Could not acquire lock on " . $this->filePath . ".");
        }
    }

    protected function unlock() {
        flock($this->fileLock, LOCK_UN);
    }

    public function close() {
        if (is_resource($this->fileLock)) {
            fclose($this->fileLock);
            $this->fileLock = null;
        }
    }

    protected function read() {
        $data = file_get_contents($this->filePath);
        return $data ? json_decode($data, true) : [];
    }

    protected function write(array $data) {
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function all() {
        $this->lock();
        $data = $this->read();
        $this->unlock();
        return array_values($data);
    }

    public function add($newData) {
        $this->lock();
        $data = $this->read();
        $newId = uniqid();
        $newData['id'] = $newId;
        $data[$newId] = $newData;
        $this->write($data);
        $this->unlock();
        return $newId;
    }

    public function get($id) {
        if (empty($id)) {
            return null;
        }
        $this->lock();
        $data = $this->read();
        $this->unlock();
        return $data[$id] ?? null;

    }

    public function update($id, $newData) {
        $this->lock();
        $data = $this->read();
        if (isset($data[$id])) {
            $data[$id] = array_merge($data[$id], $newData);
            $this->write($data);
        }
        $this->unlock();
    }

    public function delete($id) {
        $this->lock();
        $data = $this->read();
        if (isset($data[$id])) {
            unset($data[$id]);
            $this->write($data);
        }
        $this->unlock();
    }
}
