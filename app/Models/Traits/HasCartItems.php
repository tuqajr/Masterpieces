<?php

namespace App\Models\Traits;

use App\Models\CartItem;

trait HasCartItems
{
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
