<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Traits\HasCartItems;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;




/**
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\CartItem[] $cartItems
 */

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

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

   
public function favorites()
{
    return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id')->withTimestamps();

        return $this->belongsToMany(Product::class, 'favorites');

}

    
     /**
     * Get the products that the user has favorited.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    /* public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites');
    }
 */
    /**
     * Get the products in the user's cart.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cart()
    {
        return $this->hasMany(CartItem::class);
    }


    public function userOrders()
{
    /** @var User $user */
    $user = Auth::user();

    $orders = $user->orders()
        ->with('orderItems')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('orders.user-orders', compact('orders'));
}
}

