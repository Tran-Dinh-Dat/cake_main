<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'amount',
        'data',
        'status',
        'parent_id'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
