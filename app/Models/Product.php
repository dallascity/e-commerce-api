<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    // Doldurulabilir alanlar
    protected $fillable = ['name', 'price', 'stock', 'image', 'description'];
    protected $hidden = ['deleted_at'];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
