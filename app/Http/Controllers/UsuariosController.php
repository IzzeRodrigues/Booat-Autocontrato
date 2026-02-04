<?php

namespace App\Http\Controllers;

use App\Models\Contratante;
use App\Models\Contrato;
use App\Models\EnderecoContratante;
use App\Models\Representante;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{

    public function verificarUsuario(Request $request)
    {

        $nome_usuario = $request->usuario;
        $senha = $request->senha;

        $usuario = Usuarios::query()->where('nm_usuario', $nome_usuario)->get();

        if(!isset($usuario[0]))
        {
            $usuario = Usuarios::query()->where('nm_email_usuario', $nome_usuario)->get();
        }

        if(!isset($usuario[0]))
        {
            return redirect()->route('inicio', ['status' => 'erro']);
        }

        if ($senha != $usuario[0]->nm_senha_usuario)
        {
            return redirect()->route('inicio', ['status' => 'erro']);
        }

        criaSessaoOperador($usuario);
        return redirect()->route('criarContrato');

    }

}
