<?php
if(!function_exists('criaSessaoOperador')){
    function criaSessaoOperador($operador)
    {
        $dados['operador'] = [
            'id' => $operador[0]->cd_usuario,
            'nome' => $operador[0]->nm_usuario,
            'email' => $operador[0]->nm_email_usuario,
        ];

        session($dados);
    }
}

if(!function_exists('encerrarSessaoOperador')){
    function encerrarSessaoOperador(){
        session()->forget('operador');
    }
}
