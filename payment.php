<?php
function payment($param1)
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

    //---------------------------------------------------------------------Données de la table marchand
    $q = $base->prepare('SELECT * FROM marchand WHERE id = :id');
    $q->bindparam(':id', $userTG['marchand']);
    $q->execute();
    $marchand = $q->fetch();
    $marchandId = $marchand['id'];
    $token = $marchand['token'];
    $chatUser = $marchand['chatId'];



    //____________________________________________________________________ header for API
    $headers =  [
        "Content-Type: application/json",
        "Authorization: Bearer ".$token,
        "Access-Control-Allow-Origin: *",
        "Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-GitHub-OTP, X-Requested-With",
        "Access-Control-Expose-Headers: ETag, Link, X-GitHub-OTP, x-ratelimit-limit, x-ratelimit-remaining, x-ratelimit-reset, X-OAuth-Scopes, X-Accepted-OAuth-Scopes, X-Poll-Interval"
    ];

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
    //echo curl_errno($reponse);
    //echo curl_error($reponse);
    $data1 = json_decode($reponse, true);
    //echo $reponse;
    //echo $data1['errors'];

    $h = curl_getinfo($link, CURLINFO_HTTP_CODE);
    $h1 = $data1['code'];
    curl_close($link);
    //echo $h1;

    
    $d1 = strtotime(date('Y-m-d h:i:s'));
    if ($data1['code'] == 0) {
        // file_get_contents("https://api.telegram.org/bot$token/sendmessage?chat_id=$param1&text=$reply");
        
        $ref = $data1['result']['uniqueReference'];
        //$reponse =  "Paiement effectuer avec succès chez <b>" . $marchand['bename'] . "</b> \n reférence de la transaction <b>" . $ref . "</b>, taper  \n 1. Pour enregistrer ce marchand dans les favorites  \n 2. Pour Partager l'application a un ami \n 3. Pour donner un avis \n 10. Pour quitter ";
        $reponse =  "Your payment of  <b>".$amount." FCFA </b> to <b>" . $marchand['bename'] . "</b> \n was successful, reference <b>" . $ref . "</b>, Choose \n 2. To share the application with a friend \n 10. To end our chat. ";
        $reponseM =  "you received a paiement of <b>" . $amount . "</b> \n \n was successful, reference  <b>" . $ref . "</b> \n from:" .$userTG['phone'];
        $replyMarkupp = array(
            'keyboard' => array(
                array("Continue", "10. End process")
            ),
            'resize_keyboard' => true
        );
        $replyMarkup = json_encode($replyMarkupp);

        $reqq = "UPDATE transaction set datee='$d1', refInterne='$ref', statut='$h1' WHERE id ='$id'";
        $base->exec($reqq);
    } else {
        $reponse = "echec de la transaction \n reference de la transaction <b>" .$ref. "</b> Diool vous remercie... " ;
        $reponseMarchand =  "you received a paiement of <b>" . $amount . "</b> \n \n was not successful, reference  <b>" . $ref . "</b> \n from:" .$userTG['phone'];
        
        $reqq = "UPDATE transaction set chatId=chatId*10, datee='$d1', refInterne='$ref', statut='$h1' WHERE id ='$id'";
        $base->exec($reqq);
        //file_get_contents("https://api.telegram.org/bot$token/sendmessage?chat_id=$param1&text=$reply");
    }
        
    $reponseMarchand = urlencode($reponseM);   
        file_get_contents("https://api.telegram.org/bot$tokenBot/sendmessage?chat_id=$chatUser&text=$reponseMarchand&parse_mode=html");



    
    return $reponse;
    //return "My name is ".$param1;
}

/*
$d1=strtotime("July 04 2022");
$d2=ceil(($d1-time())/60/60/24);
echo "There are " . $d1 ." days until 4th of July.";*/
