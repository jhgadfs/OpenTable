<?php
function getDatabaseConnection(): PDO{
    try {
        $dsn = 'mysql:host=127.0.0.1;port=3306;dbname=MRestrDB;charset=utf8mb4';
        $username = 'root';
        $password = '1234';

        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        return $pdo;
    } catch (PDOException $e) {
        echo $e->getMessage();
}

}
