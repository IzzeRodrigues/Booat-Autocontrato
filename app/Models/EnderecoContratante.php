<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnderecoContratante extends Model
{
    use HasFactory;

    protected $table = 'tb_endereco_contratante';

    protected $fillable = [
        'cd_endereco',
        'nm_endereco',
        'nr_numero',
        'nm_bairro',
        'nm_cidade',
        'sg_uf',
        'cd_contratante',
    ];
}
