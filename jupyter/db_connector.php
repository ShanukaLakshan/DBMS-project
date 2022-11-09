<?php
try {
    $pdo = new PDO(
        "mysql:host=" . "localhost" . ";dbname=" . "jupiter" . ";charset=" . "utf8",
        $uname,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (Exception $ex) {
    exit($ex->getMessage());
}
