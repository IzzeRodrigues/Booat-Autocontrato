<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    use HasFactory;

    protected $table = 'tb_assinatura';

    protected $fillable = [
        'cd_assinatura',
        'nm_pessoa',
        'cd_cpf_pessoa',
        'dt_assinatura',
        'cd_contrato',
    ];
}
