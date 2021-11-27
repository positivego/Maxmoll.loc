<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $dates = ['completed_at'];

    protected $fillable = [
        'customer',
        'phone',
        'created_at',
        'completed_at',
        'user_id',
        'type',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class, 'id', 'order_id');
    }

    public function products(): HasManyThrough
    {
        return $this->hasManyThrough(Product::class, OrderItem::class, 'product_id', 'id', 'id', 'order_id');
    }

    public function storage(): BelongsTo
    {
        return $this->belongsTo(StorageToOrderItem::class, 'id', 'order_id');
    }
}
