<?php

use Infobip\Configuration;
use Infobip\ApiException;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Api\SmsApi;

    $configuration = new Configuration(
        host: 'https://ejpep2.api.infobip.com',
        apiKey: '09fcf148fa4536dafc8b69df8f968ab4-473147a3-9811-4fb6-865d-9702a35153ce'
    );

$curl = curl_init();

$sendSmsApi = new SmsApi(config: $configuration);

$message = new SmsTextualMessage(
    destinations: [
        new SmsDestination(to: '5513996886902')
    ],
    from: 'Voce Mesmo',
    text: 'Você é incrível'
);

$request = new SmsAdvancedTextualRequest(messages: [$message]);

try {
    $smsResponse = $sendSmsApi->sendSmsMessage($request);
} catch (ApiException $apiException) {
    // HANDLE THE EXCEPTION
}