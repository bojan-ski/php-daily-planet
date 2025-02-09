<?php

declare(strict_types=1);

namespace Framework;

use PDO;
use PDOException;
use Exception;

class Database
{
    public $conn;

    public function __construct(array $config)
    {
        $dns = "mysql:host={$config['host']};dbname={$config['dbname']}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->conn = new PDO($dns, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: {$e->getMessage()}");
        }
    }

    public function dbQuery(string $query, array $params = []): mixed
    {
        try {
            $str = $this->conn->prepare($query);

            foreach ($params as $param => $value) {
                $str->bindValue(':' . $param, $value);
            }

            $str->execute();

            return $str;
        } catch (PDOException $e) {
            throw new Exception("Query failed to execute: {$e->getMessage()}");
        }
    }
}
