<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'from_storage_id',
        'to_storage_id',
        'log_type_id',
        'product_id',
        'stock',
    ];

    public function from(): BelongsTo
    {
        return $this->belongsTo(Storage::class, 'from_storage_id', 'id');
    }

    public function to(): BelongsTo
    {
        return $this->belongsTo(Storage::class, 'to_storage_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(LogType::class, 'log_type_id', 'id');
    }
}
