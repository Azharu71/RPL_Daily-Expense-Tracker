<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anggaran extends Model
{
    protected $fillable = [
        'user_id',
        'bulan',
        'tahun',
        'nominal_anggaran',
    ];

    protected $casts = [
        'nominal_anggaran' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
