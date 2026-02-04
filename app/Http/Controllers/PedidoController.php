<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $encriptacao = $request->encriptacao;
        $comprador = $request->comprador;
        $documento = $request->documento;
        $email = $request->email;
        $nomeCartao = $request->nomeCartao;
        $cvv = $request->cvv;
        $parcelas = $request->parcelas;
        $contrato = $request->contrato;
        $valor = ($request->valor) * 100;

        require_once('../vendor/autoload.php');

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://sandbox.api.pagseguro.com/orders', [
            'body' => '{
              "customer":
              {
                "name":"'. $comprador .'",
                "email":"'. $email .'",
                "tax_id":"'. $documento .'"
              },
              "reference_id":"'. $contrato .'",
              "items":
              [
                {
                  "name":"'. $request->nomeContrato .'",
                  "quantity":1,
                  "unit_amount":' . $valor . '
                }
              ],
              "charges":
              [
                {
                  "amount":
                  {
                    "value":'. $valor .',
                    "currency":"BRL"
                  },
                  "payment_method":
                  {
                    "card":
                    {
                      "holder":
                      {
                        "name":"'. $nomeCartao .'"
                      },
                      "security_code":"'. $cvv .'",
                      "store":false,
                      "encrypted":"'. $encriptacao . '"
                    },
                    "type":"CREDIT_CARD",
                    "installments":'. $parcelas .',
                    "capture":true,
                    "soft_descriptor":"Contrato Booat"
                  },
                  "reference_id":"'. $contrato .'",
                  "description":"Contrato Booat"
                }
              ]
            }',
            'headers' => [
              'Authorization' => '75E3CD975EEC4BEE97E23A1B66BBB03C',
              'accept' => 'application/json',
              'content-type' => 'application/json',
            ],
          ]);

          $pagamento = json_decode($response->getBody());

          $statusPagamento = $pagamento->charges[0]->status;
          $mensagemPagamento = $pagamento->charges[0]->payment_response->message;

          date_default_timezone_set('America/Sao_Paulo');
          $data = time();
          $dia = "d";
          $mes = "m";
          $ano = "Y";
          $hora = "H:i:s";

          $diaPagamento = date($dia, $data);
          $mesPagamento = date($mes, $data);
          $anoPagamento = date($ano, $data);
          $horaPagamento = date($hora, $data);

          $dataPagamento = "$anoPagamento-$mesPagamento-$diaPagamento $horaPagamento";

          return redirect()->route('verificarPagamento', [
              'contrato' => $contrato,
              'status' => $statusPagamento,
              'mensagem' => $mensagemPagamento,
              'data' => $dataPagamento,
              'comprador' => $comprador,
              'documento' => $documento
          ]);

    }

    public function verificarPagamento(Request $request)
    {
      if ($request->status == "PAID")
      {
        return redirect()->route('salvarPagamento', ['contrato' => $request->contrato, 'status' => $request->status, 'mensagem' => $request->mensagem, 'data' => $request->data, 'comprador' => $request->comprador, 'documento' => $request->documento]);
      }
      else
      {
        return redirect()->route('credito', ['contrato' => $request->contrato, 'mensagem' => $request->mensagem]);
      }
    }
}
