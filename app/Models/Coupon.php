<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'discount_type', 'is_active', 'expires_at', 'min_cart_amount'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
