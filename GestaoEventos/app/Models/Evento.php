<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    // <---------------- Alterado por gemini: Campos permitidos para preenchimento em massa
    // Isto é uma segurança do Laravel para impedir que users maliciosos alterem campos que não devem.
    protected $fillable = [
        'titulo',
        'descricao',
        'data_hora',
        'local',
        'palestrante',
        'status',
    ];

    // <---------------- Alterado por gemini: Casting de dados
    // Garante que o Laravel trata a data como um objeto Carbon (super poderoso para manipular datas)
    protected $casts = [
        'data_hora' => 'datetime',
    ];
}