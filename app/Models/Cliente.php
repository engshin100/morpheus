<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'nome', 'cpf', 'data_nascimento', 'rg', 'rg_exp', 'naturalidade', 'genitora', 'genitor', 'sexo', 'estado_civil', 'user_id'
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'rg_exp' => 'date'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contatos(): HasMany
    {
        return $this->hasMany(Contato::class);
    }

    public function bancaria(): HasOne
    {
        return $this->hasOne(Bancaria::class);
    }

    public function residencial(): HasOne
    {
        return $this->hasOne(Residencial::class);
    }

    public function arquivos(): HasMany
    {
        return $this->hasMany(Arquivo::class);
    }

}
