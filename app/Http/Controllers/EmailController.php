<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use SendGrid\Mail\Mail;

class EmailController extends Controller
{
    public function index(Request $request)
    {
        require '../vendor/autoload.php';

        $link = $request->link;
        $token = $request->token;
        $nome = $request->nome;
        $nomeContrato = $request->nomeContrato;
        $emailContratante = $request->emailContratante;

        $email = new Mail();
        $email->setFrom("booat.ads1@booat.com.br", "Comercial Booat");
        $email->setSubject($nomeContrato);
        $email->addTo("$emailContratante", "$nome");
        $email->addContent(
            "text/html", "O seu contrato foi criado, para visualizá-lo e assiná-lo digitalmente acesse o seguinte link: $link e utilize o código $token quando for pedido."
        );
        $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
            $status = "Email enviado com sucesso";

            limparContratoTemporario();;
        } catch (Exception $e) {
            $status = "Houve uma falha na tentativa de envio de email, tente novamente";
        }

        //return redirect()->route('conclusaoEmail', ['resultado' => $status]);
        return redirect()->route('conclusaoEmail', ['resultado' => $status]);
    }
}
