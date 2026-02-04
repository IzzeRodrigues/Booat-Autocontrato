<?php

session_start();

$nome = $_GET['nome'];
$cpf = $_GET['cpf'];
$correioEletronico = $_GET['correioEletronico'];

require '../vendor/autoload.php'; // If you're using Composer (recommended)
// Comment out the above line if not using Composer
//require("../vendor/sendgrid/sendgrid-php.php");
// If not using Composer, uncomment the above line and
// download sendgrid-php.zip from the latest release here,
// replacing <PATH TO> with the path to the sendgrid-php.php file,
// which is included in the download:
// https://github.com/sendgrid/sendgrid-php/releases

$email = new \SendGrid\Mail\Mail(); 
$email->setFrom($correioEletronico, "Lucas Craveiro");
$email->setSubject("Contrato fechado");
$email->addTo("lucas.craveiro@booat.com.br", $nome);
$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
$email->addContent(
    "text/html", "<strong>Por meio desta eu, {$nome}, portador do CPF {$cpf}, email {$correioEletronico}, solicito um cadastro para utilização do software.</strong>"
);
$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}

return redirect() -> to('/') -> send();


?>