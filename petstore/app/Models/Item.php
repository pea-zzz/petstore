<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'price', 
        'stock', 
        'selection', 
        'category_id'];

        public function category(): BelongsTo
        {
            return $this->belongsTo(Category::class);
        }
    
        public function shoppingCarts(): HasMany
        {
            return $this->hasMany(ShoppingCart::class);
        }
    
        public function orders(): HasMany
        {
            return $this->hasMany(Order::class);
        }
    
        public function browsingHistories(): HasMany
        {
            return $this->hasMany(BrowsingHistory::class);
        }
}
