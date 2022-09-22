<?php
function paymentAirtime($param1)
{
     $tokenBot = '5612142866:AAFvvpi--r1CZY7VaEbZRkriMUEzwlC-arg';

    require("connexion.php");

    //----------------------------------------------------------------Collect data from data base
    $base->exec("SET CHARACTER SET utf8");
    $query = $base->prepare('SELECT * FROM transaction WHERE chatId = :chatId');
    $query->bindparam(':chatId', $param1);
    $query->execute();
    $userTG = $query->fetch();
    $id = $userTG['id'];
    $phone = $userTG['phone'] + 237000000000;
    $amount = $userTG['amount'];

    if ($userTG['methode'] == 1) {
        $code = 62402;
    }
    if ($userTG['methode'] == 2) {
        $code = 62401;
    }
    if ($userTG['methode'] == 3) {
        $code = "EUMM";
    }


    //____________________________________________________________________ header for API
    $headers =  [
        "Content-Type: application/json",
        "Authorization: Bearer api_live.4UDet5+nRsTRfFM1KcLjsIZ/SqPruNUZURZqrveR/TdGyzIrUfAvyetjkgMh9DZt",
        "Access-Control-Allow-Origin: *",
        "Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-GitHub-OTP, X-Requested-With",
        "Access-Control-Expose-Headers: ETag, Link, X-GitHub-OTP, x-ratelimit-limit, x-ratelimit-remaining, x-ratelimit-reset, X-OAuth-Scopes, X-Accepted-OAuth-Scopes, X-Poll-Interval"
    ];

    
    // ---------------------------------------------------------body of the request and send the request
    $link = curl_init();
    curl_setopt($link, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($link, CURLOPT_RETURNTRANSFER, true);


    curl_setopt($link, CURLOPT_URL, "https://core.diool.me/core/dioolapi/v1/payment");
    curl_setopt($link, CURLOPT_POST, true);
    curl_setopt($link, CURLOPT_RETURNTRANSFER, true);
    $data = [
        'accountIdentifier' => $phone,
        'amount' => $amount,
        'providerIdentifier' => $code,
        'referenceOrder' => $userTG['reference'],
    ];
    curl_setopt($link, CURLOPT_POSTFIELDS, json_encode($data));
    //curl_setopt($link, CURLOPT_POSTFIELDS, $data);

    $reponse = curl_exec($link);
    $data1 = json_decode($reponse, true);

    $h = curl_getinfo($link, CURLINFO_HTTP_CODE);
    curl_close($link);
    //echo $h1;

        
    $c = $data1['code'];
    $ref = $data1['result']['uniqueReference'];
    require_once('airtime.php');
    list($reply, $replyMarkup) = airtime($param1, $ref, $c);

    return array($reply, $replyMarkup);
    //return "My name is ".$param1;
}
