<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'user_id',
        'nama_kategori',
    ];

    /**
     * Category dimiliki oleh seorang user (nullable untuk kategori default sistem).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Category memiliki banyak transactions.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
