<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bancaria extends Model
{
    use HasFactory;

    protected $table = 'bancarias';

    protected $fillable = ['cliente_id', 'codigo', 'banco', 'agencia', 'conta', 'tipo', 'operacao', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }
}
