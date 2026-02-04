<?php

require '../vendor/autoload.php'; // If you're using Composer (recommended)
// Comment out the above line if not using Composer
//require("../vendor/sendgrid/sendgrid-php.php");
// If not using Composer, uncomment the above line and
// download sendgrid-php.zip from the latest release here,
// replacing <PATH TO> with the path to the sendgrid-php.php file,
// which is included in the download:
// https://github.com/sendgrid/sendgrid-php/releases

$link = $_REQUEST['link'];
$token = $_REQUEST['token'];
$nome = $_REQUEST['nome'];
$nomeContrato = $_REQUEST['nomeContrato'];

$email = new \SendGrid\Mail\Mail(); 
$email->setFrom("lucas.craveiro@booat.com.br", "Lucas Craveiro");
$email->setSubject("$nomeContrato");
$email->addTo("lucas.craveiro@booat.com.br", 'Lucas Craveiro');
$email->addContent(
    "text/html", "O seu contrato foi criado, para visualizá-lo e assiná-lo digitalmente acesse o seguinte link: $link e utilize o código $token quando for pedido."
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

echo ('Email enviado');

return redirect()->route('conclusaoEmail');
?>