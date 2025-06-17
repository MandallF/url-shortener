<?php
class Url {
    private $pdo;

    public function __construct() {
        $this->pdo = require '../config/database.php';
    }

    public function findByOriginal($url) {
        $stmt = $this->pdo->prepare("SELECT * FROM urls WHERE original_url = ?");
        $stmt->execute([$url]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByShortCode($code) {
        $stmt = $this->pdo->prepare("SELECT * FROM urls WHERE short_code = ?");
        $stmt->execute([$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function save($url, $code) {
        $stmt = $this->pdo->prepare("INSERT INTO urls (original_url, short_code) VALUES (?, ?)");
        $stmt->execute([$url, $code]);
    }
}
