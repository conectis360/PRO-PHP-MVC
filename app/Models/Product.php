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

    protected function setDescriptionAttribute(string $value){
        $limit = 50;
        $ending = '...';

        if (mb_strwidth($value, 'UTF-8' <= $limit)){
            return $value;
        }
        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $ending;
    }
}