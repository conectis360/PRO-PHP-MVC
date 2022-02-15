<?php

namespace App\Models;

use Exception;

class Product extends Model {
    protected string $table;

    public function setTable(string $table):static{
        $this->table = $table;
        return $this;
    }

    public function getTable():string {
        if(!isset($this->table)) {
            throw new Exception('$table is not set and getTable is not defined');
        }
        return $this->table;
    }
}