<?php

namespace App\Models;

class Order extends Model {
    protected string $table = 'orders';

    public function user():mixed {
        return $this->belongsTo(User::class, 'user_id');
    }
}