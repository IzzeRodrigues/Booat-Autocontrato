<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contratante extends Model
{
    use HasFactory;

    protected $table = 'tb_contratante';

    protected $fillable = [
        'cd_contratante',
        'nm_contratante',
        'cd_cnpj_contratante',
        'nm_email_contratante',
        'ds_tipo_estabelecimento',
        'cd_controle_contratante',
        'cd_contrato',
    ];
}
