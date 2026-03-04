<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'price',
        'image',
        'description',
        'is_available',
    ];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
