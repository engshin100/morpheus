<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Arquivo extends Model
{
    use HasFactory;

    protected $fillable = ['cliente_id', 'arquivo'];

    protected $casts = ['arquivo' => 'array'];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
