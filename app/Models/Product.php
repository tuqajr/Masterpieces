<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'active', 
    ];


   // Many-to-many: A product can be favorited by many users
public function favoritedByUsers()
{
    return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
}

// Helper method to check if a product is favorited by a specific user
public function isFavoritedBy($user)
{
    return $this->favoritedByUsers()->where('user_id', $user->id)->exists();
}

public function images()
{
    return $this->hasMany(\App\Models\ProductImage::class);
}

}
