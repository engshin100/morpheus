<?php

namespace App\Filament\Enums;
use Filament\Support\Contracts\HasLabel;

enum HasTipoContatoEnum: string implements HasLabel
{
    case Pessoal = 'Pessoal';
    case Parente = 'Parente';
    case Recado = 'Recado';

    public function getLabel(): ?string
    {
        return $this->name;
    }
}
