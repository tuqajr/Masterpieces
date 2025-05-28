<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'delivery_date',
        'shipping_address',
        'phone',
        'payment_status',
        'payment_method',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'delivery_date' => 'datetime',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
{
return $this->belongsTo(\App\Models\User::class, 'user_id');}
}