<?php

declare(strict_types=1);

namespace Framework;

use PDO;
use PDOException;
use PDOStatement;
use App\Controllers\ErrorController;

class Database
{
    private PDO $conn;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->conn = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            ErrorController::randomError('DB error');
            exit;           
        }
    }

    protected function dbQuery(string $query, array $params = []): PDOStatement
    {
        try {
            $stmt = $this->conn->prepare($query);

            foreach ($params as $param => $value) {
                $stmt->bindValue(':' . $param, $value);
            }

            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            ErrorController::randomError('DB error');
            exit; 
        }
    }
}
