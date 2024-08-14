<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contato extends Model
{
    use HasFactory;

    protected $table = 'contatos';

    protected $fillable = ['cliente_id', 'phone', 'tipo'];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(cliente::class);
    }
}
