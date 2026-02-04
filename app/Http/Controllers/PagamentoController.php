<?php

namespace App\Http\Controllers;

use App\Models\Contrato;
use App\Models\Pagamento;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PagamentoController extends Controller
{

    private $access_token;

    public function __construct()
    {
        $this->access_token = env('PAGBANK_ACCESS_TOKEN');
    }

    public function pagarComCartao(Request $request)
    {

        $client = new Client();

        $items[] = [
            "name" => "Contrato Booat",
            "quantity" => 1,
            "unit_amount" => (removerCaracteres(['.'], session('contrato_para_assinar.valor')*100)),
        ];

        $charges[] = [
            "reference_id" => "contrato_booat_".session('contrato_para_assinar.id_contrato'),
            "description" => "Contrato Booat",
            "amount" => [
                "value" => (removerCaracteres(['.'], session('contrato_para_assinar.valor')*100)),
                "currency" => "BRL"
            ],

            "payment_method" => [
                "type" => "CREDIT_CARD",
                "installments" => session('contrato_para_assinar.parcelas'),
                "capture" => true,
                "card" => [
                    "encrypted" => $_POST['encrypted'],
                    "security_code" => $request->security_code,
                    "store" => false
                ]
            ]
        ];

        $compra = [
            "customer" => [
                "tax_id" => !empty($request->numDocumento) ? removerCaracteres(['.', '-', '/'], $request->numDocumento) : '',
                "name" => $request->nomeComprador,
                "email" => $request->endEmail
            ],

            "items" => $items,

            "charges" => $charges,
        ];

        try{
//            $response = $client->request('POST', 'https://sandbox.api.pagseguro.com/orders', [
            $response = $client->request('POST', 'https://api.pagseguro.com/orders', [
                'body' => json_encode($compra),
                'headers' => [
                    'Authorization' => 'Bearer '.$this->access_token,
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ],
            ]);

            echo $response->getBody();
            die();

            $pagamento = json_decode($response->getBody());

            $this->salvarPagamento($request, $pagamento);

            return response()->json([
                'status' => isset($pagamento->charges) && $pagamento->charges[0]->status == 'PAID' ? 'ok' : 'erro',
                'id_transacao' => $pagamento->id,
                'id_pagamento' => isset($pagamento->charges) ? $pagamento->charges[0]->id : null,
            ]);

        } catch (ClientException $e){
            return $e->getMessage();
        }

    }

    public function gerarQRCode(Request $request)
    {

        $client = new Client();

        $items[] = [
            "name" => "Contrato Booat",
            "quantity" => 1,
            "unit_amount" => (removerCaracteres(['.'], session('contrato_para_assinar.valor')*100)),
        ];

        $qrcodes[] = [
            "amount" => [
                "value" => (removerCaracteres(['.'], session('contrato_para_assinar.valor')*100))
            ]
        ];

        $compra = [
            "customer" => [
                "tax_id" => $request->numDocumento,
                "name" => $request->nomeComprador,
                "email" => $request->endEmail
            ],

            "items" => $items,

            //"charges" => $charges,

            "qr_codes" => $qrcodes,
        ];

        try{
            //$response = $client->request('POST', 'https://sandbox.api.pagseguro.com/orders', [
            $response = $client->request('POST', 'https://api.pagseguro.com/orders', [
                'body' => json_encode($compra),
                'headers' => [
                    'Authorization' => 'Bearer '.$this->access_token,
                    'accept' => 'application/json',
                    'content-type' => 'application/json',
                ],
            ]);

            $pagamento = json_decode($response->getBody());

            $this->salvarPagamento($request, $pagamento);

            return response()->json([
                'status' => 'ok',
                'id_transacao' => $pagamento->id,
                'qr_code_image' => $pagamento->qr_codes[0]->links[0]->href,
                'qr_code_text' => $pagamento->qr_codes[0]->text,
            ]);

        } catch (ClientException $e){
            return $e->getMessage();
        }

    }

    private function salvarPagamento($request = null, $pagamento, $tipo = 'cartao')
    {

        switch ($tipo):
            case 'cartao':
                $contrato = Contrato::query()->where('cd_controle_contrato', $request->controleContrato)->get();
                Pagamento::query()->create([
                    'nm_pagante' => $request->nomeComprador,
                    'cd_cpf_pagante' => removerCaracteres(['.', '-', '/'], $request->numDocumento),
                    'dt_pagamento' => date('Y-m-d H:i:s'),
                    'cd_contrato' => $contrato[0]->cd_contrato,
                    'id_transacao' => $pagamento->id,
                    'id_pagamento' => isset($pagamento->charges) ? $pagamento->charges[0]->id : null,
                    'status' => isset($pagamento->qr_codes) > 0 ? 'PENDING' : $pagamento->charges[0]->status
                ]);

                if(isset($pagamento->charges) && $pagamento->charges[0]->status):
                    Contrato::query()->where('cd_controle_contrato', $request->controleContrato)->update([
                        'ds_status' => 'Pago'
                    ]);
                endif;

                break;

            case 'pix':
                if(isset($pagamento->charges) && $pagamento->charges[0]->status == 'PAID'):
                    Pagamento::query()->where('id_transacao', $pagamento->id)->update([
                        'id_pagamento' => $pagamento->charges[0]->id,
                        'dt_pagamento' => date('Y-m-d H:i:s'),
                        'status' => $pagamento->charges[0]->status
                    ]);

                    if(isset($pagamento->charges) && $pagamento->charges[0]->status):
                        Contrato::query()->where('cd_contrato', $pagamento->cd_contrato)->update([
                            'ds_status' => 'Pago'
                        ]);
                    endif;
                endif;

        endswitch;
    }

    public function consultarPagamento($id_transacao)
    {

        $client = new Client();

        try{
            $response = $client->request('GET', 'https://sandbox.api.pagseguro.com/orders/'.$id_transacao, [
                'headers' => [
                    'Authorization' => 'Bearer '.$this->access_token,
                    'accept' => 'application/json',
                ],
            ]);

            $pagamento = json_decode($response->getBody());

            $this->salvarPagamento(null, $pagamento, 'pix');

            return response()->json([
                'status' => isset($pagamento->charges) && $pagamento->charges[0]->status == 'PAID' ? 'ok' : 'erro',
                //'pedido' => $pagamento
            ]);

        } catch (ClientException $e){
            return $e->getMessage();
        }

    }

}
