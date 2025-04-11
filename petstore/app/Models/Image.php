<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'item_id'];

    // Define the relationship with the Item model
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function selection()
    {
        return $this->belongsTo(Selection::class);
    }
}
