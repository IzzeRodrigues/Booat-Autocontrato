<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\EncriptacaoController;
use stdClass;

class controladorChave extends Controller
{
    public function index(Request $request)
    {
        
        require_once('../vendor/autoload.php');

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://sandbox.api.pagseguro.com/public-keys', [
        'body' => '{"type":"card"}',
        'headers' => [
            'Authorization' => '75E3CD975EEC4BEE97E23A1B66BBB03C',
            'accept' => 'application/json',
            'content-type' => 'application/json',
        ],
        ]);

        $resposta = json_decode($response->getBody());

        $chave = $resposta->public_key;

        $objetoCompra = [
            'comprador' => $request->nomeComprador,
            'companhia' => $request->nomeEstabelecimento,
            'documento' => $request->numDocumento,
            'email' => $request->endEmail,
            'nomeCartao' => $request->nomeCartao,
            'numCartao' => $request->numCartao,
            'cvv' => $request->cvv,
            'mes' => $request->mes,
            'ano' => $request->ano,
            'contrato' => $request->contrato,
            'chave' => $chave,
        ];

        return redirect()->route('encriptacao', $objetoCompra);
        
    }
}
