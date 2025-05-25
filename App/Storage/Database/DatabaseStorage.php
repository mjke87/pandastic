<?php

namespace App\Storage\Database;
use PDO;
use Exception;
use App\Storage\Storage;

abstract class DatabaseStorage implements Storage {
    protected static $table = null;
    protected $pdo;

    public function __construct() {
        $config = require(__DIR__ . '/../../../config.php');
        $dsn = $config['db_dsn'];
        $user = $config['db_user'];
        $pass = $config['db_pass'];
        $this->pdo = new PDO($dsn, $user, $pass);
    }

    public static function data() {
        return new static();
    }

    public function all() {
        $stmt = $this->pdo->query("SELECT * FROM " . static::$table);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($newData) {
        $columns = array_keys($newData);
        $placeholders = array_map(fn($col) => ":$col", $columns);
        $sql = "INSERT INTO " . static::$table . " (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($newData);
        return $this->pdo->lastInsertId();
    }

    public function get($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $newData) {
        $set = [];
        foreach ($newData as $col => $val) {
            $set[] = "$col = :$col";
        }
        $sql = "UPDATE " . static::$table . " SET " . implode(',', $set) . " WHERE id = :id";
        $newData['id'] = $id;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($newData);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
        $stmt->execute([$id]);
    }
}
