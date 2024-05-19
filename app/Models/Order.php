<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
class Order extends Model {

    protected $connection = 'mongodb';
    protected $collection = 'orders';

    protected $fillable = [
        'order_id'
    ];

    public function products()
    {
        return $this->embedsMany(Product::class);
    }
}
