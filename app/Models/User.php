<?php

namespace App\Models;


use App\Models\Product;
use App\Models\CartItem;
use App\Models\Traits\HasCartItems;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Order;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasCartItems;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user.
     */
    public function isUser()
    {
        return $this->role === 'user';
    }

    /**
     * Get cart items for the user.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * The products that the user has favorited.
     */

    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id')
            ->withTimestamps();
    }

    /**
     * Get the products in the user's cart.
     */
    public function cart(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    
}

