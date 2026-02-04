<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Paginacao extends Controller
{
    public function home()
    {
        return view('login');
    }

    public function criarConta()
    {
        return view('criarConta');
    }

    public function criarContrato()
    {
        return view('criarContrato');
    }

    public function confirmarContrato()
    {
        return view('confirmarContrato', ['dominio' => $_SERVER['HTTP_HOST'] ]);
    }

    public function linkGerado()
    {
        return view('linkGerado');
    }

    public function enviarEmail()
    {
        return view('enviarEmail');
    }

    public function solicitacaoConta()
    {
        return view('solicitacaoConta');
    }

    public function envioSMS()
    {
        return view('envioSMS');
    }

    public function cartao()
    {
        return view('cartao');
    }

    public function encriptacao()
    {
        return view('encriptacao');
    }

    public function credito()
    {
        return view('credito');
    }

    public function inicio()
    {
        return view('inicio');
    }

    public function pagamento()
    {
        return view('pagamento');
    }

    public function termos()
    {
        return view('termos');
    }

    public function criadorContrato()
    {
        return view('report');
    }

    public function leituraContrato()
    {
        return view('leituraContrato', ['dominio' => $_SERVER['HTTP_HOST'] ]);
    }

    public function conclusaoEmail()
    {
        limparContratoTemporario();
        encerrarSessaoOperador();
        return view('conclusaoEmail');
    }

    public function conclusaoPagamento()
    {
        limparContratoParaAssinar();
        return view('conclusaoPagamento');
    }

}
