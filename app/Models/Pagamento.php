<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    protected $table = 'tb_pagamento';

    protected $fillable = [
        'cd_pagamento',
        'nm_pagante',
        'cd_cpf_pagante',
        'dt_pagamento',
        'cd_contrato',
        'id_transacao',
        'id_pagamento',
        'status',
    ];
}
