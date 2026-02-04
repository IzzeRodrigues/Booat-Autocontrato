<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $table = 'tb_contrato';

    protected $fillable = [
        'cd_contrato',
        'nm_contrato',
        'vl_contrato',
        'ds_tipo_plano',
        'nr_parcelas',
        'nr_tempo_duracao',
        'nr_tempo_midia',
        'vl_rescisao',
        'nr_tempo_rescisao',
        'nr_tempo_validade',
        'dt_contrato',
        'nr_token',
        'ds_status',
        'cd_controle_contrato',
        'arquivo',
    ];
}
