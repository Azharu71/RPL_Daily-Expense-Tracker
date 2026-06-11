<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'tipe',
        'nominal',
        'tanggal',
    ];

    protected function casts(): array
    {
        return [
            'nominal' => 'decimal:2',
            'tanggal' => 'date',
        ];
    }

    /**
     * Transaction dimiliki oleh seorang user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Transaction dimiliki oleh sebuah category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
