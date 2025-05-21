<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'customer_name',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'status',
        'payment_method',
        'notes',
        'total'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}
}