<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    use HasFactory;

    protected $table = 'tb_usuario';

    protected $fillable = [
        'cd_usuario',
        'nm_usuario',
        'nm_senha_usuario',
        'nm_email_usuario',
    ];
}
