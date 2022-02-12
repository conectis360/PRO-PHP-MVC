<?php
namespace Framework\Database\Connection;

use Framework\Database\QueryBuilder\SqliteQueryBuilder;
use InvalidArgumentException;
use PDO;

class SqliteConnection extends Connection {
    private PDO $pdo;

    public function __construct(array $config){
        ['path' => $path] = $config;
        if (empty($path)) {
            throw new InvalidArgumentException('Connection incorrectly configured');
        }
        $this->pdo = new Pdo("sqlite:{$path}");
    }

    function pdo(): PDO
    {
        $this->pdo;
    }

    function query(): SqliteQueryBuilder{
        new SqliteQueryBuilder($this);
    }
}