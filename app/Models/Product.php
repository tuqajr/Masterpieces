<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    
   /**
 * Get the users that favorited this product.
 */
/* public function favoritedBy()
{
    return $this->belongsToMany(User::class, 'favorites', 'product_id', 'user_id')
                ->withTimestamps();
} */
    
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'active', 
    ];

    protected $casts = [
        'gallery' => 'array',
    ];
}

