<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representante extends Model
{
    use HasFactory;

    protected $table = 'tb_representante';

    protected $fillable = [
        'cd_representante',
        'nm_representante',
        'cd_cpf_representante',
        'cd_contratante',
    ];
}
