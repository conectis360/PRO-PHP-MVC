<?php

namespace Framework\Database;

use Framework\Database\Connection\Connection;
use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Connection\SqliteConnection;
use Framework\Database\Exception\ConnectionException;

abstract class Model {
    protected Connection $connection;
    protected array $attributes;

    public static function with(array $attributes = []):static {
        $model = new static();
        $model->attributes = $attributes;

        return $model;
    }

    public function all(): array {
        if (!isset($this->type)) {
            $this->select();
        }
    }


    public function first(): array {
        if (!isset($this->type)) {
            $this->select();
        }
    }

    public static function query():mixed {
        $model = new static();
        $query = $model->getConnection()->query();
        
        return $model->getConnection()->query()->from($model->getTable());
    }

    public static function __callStatic(string $method, array $parameters): mixed
    {
        return static::query()->$method(...$parameters);
    }

    public function setConnection(Connection $connection): static {
        $this->connection = $connection;
        return $this;
    }

    public function getConnection(): Connection {
        if(!isset($this->connection)) {
            $factory = new Factory();
            $factory->addConnector('mysql', function($config){
                return new MysqlConnection($config);
            });

            $factory->addConnector('sqlite', function($config){
                return new SqliteConnection($config);
            });

            $config = require basePath() . 'config/database.php';

            $this->connection = $factory->connect($config[$config['default']]);
        }
        return $this->connection;
    }
}