<?php

class Database {
    private $pdo;

    public function __construct($host, $db, $user, $pass) {
        $this->pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    public function commit() {
        return $this->pdo->commit();
    }

    public function rollBack() {
        return $this->pdo->rollBack();
    }
}
