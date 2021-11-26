<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Storage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(StorageItem::class);
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, StorageItem::class, 'product_id', 'id', 'id', 'storage_id');
    }
}
