<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Price;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function prices()
    {
        return $this->hasMany(Price::class, 'product_id', 'id');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($product) {
             $product->prices()->delete();
        });
    }
}
