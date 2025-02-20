<?php

declare(strict_types=1);

namespace Framework;

use PDO;
use PDOException;
use PDOStatement;
use App\Controllers\ErrorController;

class Database
{
    protected $conn;

    protected function __construct(array $config)
    {
        $dns = "mysql:host={$config['host']};dbname={$config['dbname']}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        try {
            $this->conn = new PDO($dns, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            ErrorController::randomError('DB error');
            exit;           
        }
    }

    protected function dbQuery(string $query, array $params = []): PDOStatement
    {
        try {
            $str = $this->conn->prepare($query);

            foreach ($params as $param => $value) {
                $str->bindValue(':' . $param, $value);
            }

            $str->execute();

            return $str;
        } catch (PDOException $e) {
            ErrorController::randomError('DB error');
            exit; 
        }
    }
}
