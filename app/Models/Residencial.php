<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Residencial extends Model
{
    use HasFactory;

    protected $table = 'residenciais';

    protected $fillable = [
        'cliente_id', 'cep', 'logradouro', 'complemento', 'bairro', 'localidade', 'uf'
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

}
