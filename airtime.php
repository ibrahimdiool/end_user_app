<?php
function airtime($param1, $ref, $code)
{

     if($code == 0){

     

    require("connexion.php");

    //----------------------------------------------------------------Collect data from data base
    $base->exec("SET CHARACTER SET utf8");
    $query = $base->prepare('SELECT * FROM transaction WHERE chatId = :chatId');
    $query->bindparam(':chatId', $param1);
    $query->execute();
    $userTG = $query->fetch();
    $id = $userTG['id'];
    $phone = $userTG['phoneAirtime'] + 237000000000;
    $amount = $userTG['amount'];

    //_________________________________________ get the network using the phone number
    $tel = (int)($userTG['phoneAirtime']/1000000);
    switch(true){
        case $tel >= 690:
			$code = 62402;
            break;
        case $tel >= 670 && $tel <= 679:
			$code = 62401;
            break;
        case $tel >= 660 && $tel <= 669:
			$code = 62404;
            break;
        case $tel >= 655 && $tel <= 659:
			$code = 62402;
            break;
        case $tel >= 650 && $tel <= 654:
			$code = 62401;
            break;
    }


    //____________________________________________________________________ header for API
    $headers =  [
        "Content-Type: application/json",
        "Authorization: Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6IlFrSTVPVUV5UkRNMU5ETTNSalZFUlVWRlJUTXpNRE16TjBFeE5rUTBNekZEUkRRek1qQkJOQSJ9.eyJodHRwOi8vand0LmRpb29sLmNvbS91c2VybmFtZSI6InRlc3RkaW9vbGNhbXJfZ21haWxfY29tIiwiaHR0cDovL2p3dC5kaW9vbC5jb20vdXNlcl9pZCI6ImF1dGgwfDYzMjllOGQ5NjM3NzNiMWRkMTI3YThkMCIsImh0dHA6Ly9qd3QuZGlvb2wuY29tL3Byb2ZpbCI6ImFnZW50IiwiaHR0cDovL2p3dC5kaW9vbC5jb20vZW1haWwiOiJ0ZXN0ZGlvb2xjYW1yQGdtYWlsLmNvbSIsImh0dHA6Ly9qd3QuZGlvb2wuY29tL2VtYWlsX3ZlcmlmaWVkIjp0cnVlLCJodHRwOi8vand0LmRpb29sLmNvbS9yb2xlcyI6WyJzY3JlZW46cGF5bWVudHRlcm1pbmFsIiwiZWRpdDpwYXltZW50Iiwic2NyZWVuOmhpc3RvcnkiLCJzY3JlZW46dHJhbnNhY3Rpb25zIiwidmlldzp0cmFuc2FjdGlvbkhpc3RvcnkiLCJleHBvcnQ6dHJhbnNhY3Rpb25IaXN0b3J5Iiwic2NyZWVuOmxlZGdlciIsInZpZXc6TGVkZ2VyIiwic2NyZWVuOmFkZHJlc3Nib29rIiwidmlldzpnZXRBZGRyZXNzQm9vayIsImVkaXQ6YWRkTmV3Q29udGFjdCIsInZpZXc6Y2hlY2tEaW9vbEFjY291bnQiLCJlZGl0Om1vZGlmeUNvbnRhY3QiLCJlZGl0OmRlbGV0ZUNvbnRhY3QiLCJlZGl0OmFkZHJlc3NCb29rVHJhbnNmZXIiLCJzY3JlZW46Y293b3JrZXJzIiwidmlldzpzZWVDb3dvcmtlcnNMaXN0IiwiZWRpdDpkaW9vbF90cmFuc2ZlciIsInZpZXc6dXNlcklkQnlFbWFpbCIsInNjcmVlbjphY2NvdW50cyIsInZpZXc6YmFsYW5jZSIsImVkaXQ6YWRkRnVuZHMiLCJlZGl0OndpdGhkcmF3RnVuZHMiLCJlZGl0OnJlZGVlbSIsImVkaXQ6d2l0aGRyYXdSZXZlbnVlIiwiZWRpdDpwYXlSZXZlbnVlRGViaXQiLCJzY3JlZW46c2V0dGluZ3MiLCJzY3JlZW46cGF5bWVudE1ldGhvZHMiLCJ2aWV3OnBheW1lbnRNZXRob2RzIiwiZWRpdDphZGRFeHRlcm5hbERlZmF1bHRBY2NvdW50IiwiZWRpdDpzZXREZWZhdWx0QWNjb3VudCIsImVkaXQ6YXJjaGl2ZUV4dGVybmFsRGVmYXVsdEFjY291bnQiLCJzY3JlZW46c2V0dGluZ3MiLCJzY3JlZW46cHJvZmlsZSIsInZpZXc6cGVyc29uYWxJbmZvIiwidmlldzpidXNpbmVzc0VudGl0eUluZm8iLCJlZGl0OmNoYW5nZVBhc3N3b3JkIiwiZWRpdDpjaGFuZ2VFbWFpbCIsImVkaXQ6Y2hhbmdlVXNlclBpY3R1cmUiLCJzY3JlZW46Y2FzaHBvaW50Iiwic2NyZWVuOmFpcnRpbWUiLCJlZGl0OmFpcnRpbWVfdHJhbnNmZXIiLCJzY3JlZW46ZGVwb3NpdCIsImVkaXQ6ZGVwb3NpdF90cmFuc2ZlciIsInNjcmVlbjp3aXRoZHJhdyIsImVkaXQ6d2l0aGRyYXdfdHJhbnNmZXIiXSwiaHR0cDovL2p3dC5kaW9vbC5jb20vaXNNMk1Ub2tlbiI6ZmFsc2UsImh0dHA6Ly9qd3QuZGlvb2wuY29tL2Vudmlyb25tZW50IjoiIiwiaHR0cDovL2p3dC5kaW9vbC5jb20vcGFyZW50SWQiOiJhdXRoMHw2MmNmZTFhNWZjZGEyMDYwYThlZTQxMTAiLCJodHRwOi8vand0LmRpb29sLmNvbS9pc0RlbW9Vc2VyIjpmYWxzZSwiaXNzIjoiaHR0cHM6Ly9hdXRoLmRpb29sLmNvbS8iLCJzdWIiOiJhdXRoMHw2MzI5ZThkOTYzNzczYjFkZDEyN2E4ZDAiLCJhdWQiOlsiaHR0cHM6Ly8xMjcuMC4wLjE6ODA4MC9kaW9vbC9hcGkvdjEiLCJodHRwczovL215bW9uZXltb2JpbGUuZXUuYXV0aDAuY29tL3VzZXJpbmZvIl0sImlhdCI6MTY2Mzc0NTMxOCwiZXhwIjoxNjY2MzM3MzE4LCJhenAiOiJrcW1ORUk3Q0JEOXVBUlQyZXBabGVTMXZBNjRIbGQxTyIsInNjb3BlIjoib3BlbmlkIHByb2ZpbGUgZW1haWwiLCJwZXJtaXNzaW9ucyI6W119.cw-TVkXEdigaKRImTJt3tZdYsnDn61Nangc6hYDfUSycnX53rma4SYsQ90lhT1pPqsaFyNbaG7i06d0d6-TSF61P00l4NatXIvgpigJ_8lEqrEDMESa5ZRVl6CRcSa5_Rm0ifGtikiOBPYsb83X7vR4pIWAWQJCLqWPEQ1Q7n14bRLYOgRGVUqXbaHULCnSauPjz4GAEcwHwkxMuWskiNKhkSKmKAS6U7NnGu9P78LoA7vAKmxX17ZrbPMyOCjJFxHp9GK4nxCb0Ug5HH0je3SM_liRxSGDoqQMbDR_btP_BFM6KNZlFOUXvykjNGO390XJkfzMAw3rq__FRJoSSyQ",
        "Access-Control-Allow-Origin: *",
        "Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-GitHub-OTP, X-Requested-With",
        "Access-Control-Expose-Headers: ETag, Link, X-GitHub-OTP, x-ratelimit-limit, x-ratelimit-remaining, x-ratelimit-reset, X-OAuth-Scopes, X-Accepted-OAuth-Scopes, X-Poll-Interval",
        "x-beversion: 3.5.0"
    ];

    $link = curl_init();
    curl_setopt($link, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($link, CURLOPT_RETURNTRANSFER, true);


    curl_setopt($link, CURLOPT_URL, "https://core.diool.me/core/api/v1/operations/airtime_transfer");
    curl_setopt($link, CURLOPT_POST, true);
    curl_setopt($link, CURLOPT_RETURNTRANSFER, true);
        $data = [
            "senderProviderIdentifier" => "DIOOL",
            "senderServiceType" => "MOBILE_MONEY",
            "senderProviderAccountID" => "",
            "senderUserIdentifier" => "auth0|6329e8d963773b1dd127a8d0",
            "amount" => $amount,
            "recipientProviderIdentifier" => $code,
            "recipientServiceType" => "AIRTIME",
            "recipientProviderAccountID" => $phone,
            "recipientUserIdentifier" => "",
            "remark" => "Telegram Airtime",
            "senderComment" => "",
            "senderLongitude" => "",
            "senderLatitude" => "",
            "senderDeviceID" => "",
            "shopId" => "92",
            "channel" => "web",
            "issuerParents" => [
                "0",
                "auth0|62cfe1a5fcda2060a8ee4110"
            ],
            "confirm" => false
        ];
    curl_setopt($link, CURLOPT_POSTFIELDS, json_encode($data));
    //curl_setopt($link, CURLOPT_POSTFIELDS, $data);

    $reponse = curl_exec($link);
    $data1 = json_decode($reponse, true);

    $h = curl_getinfo($link, CURLINFO_HTTP_CODE);
    $h1 = $data1['code'];
    curl_close($link);
    //echo $h1;

    
    $d1 = strtotime(date('Y-m-d h:i:s'));
    if ($data1['code'] == 0) {
        // file_get_contents("https://api.telegram.org/bot$token/sendmessage?chat_id=$param1&text=$reply");
        
        $ref1 = $data1['result']['uniqueReference'];
        //$reponse =  "Paiement effectuer avec succès chez <b>" . $marchand['bename'] . "</b> \n reférence de la transaction <b>" . $ref . "</b>, taper  \n 1. Pour enregistrer ce marchand dans les favorites  \n 2. Pour Partager l'application a un ami \n 3. Pour donner un avis \n 10. Pour quitter ";
        $reponse =  "Your Airtime payment  of  <b>".$amount." FCFA </b> to <b>" . $phone . "</b> \n was successful, reference <b>" . $ref . " and ".$ref1."</b>.";

        $reqq = "UPDATE transaction set datee='$d1', chatId=chatId*10, refInterne='$ref',  refExterne='$ref1', statut='$h1' WHERE id ='$id'";
        $base->exec($reqq);
    } else {
        $reponse = "echec de la transaction \n reference de la transaction <b>" .$ref. " et ".$ref1."</b> Diool vous remercie... " ;
        
        $reqq = "UPDATE transaction set chatId=chatId*10, datee='$d1', refInterne='$ref',  refExterne='$ref1', statut='$h1' WHERE id ='$id'";
        $base->exec($reqq);
        //file_get_contents("https://api.telegram.org/bot$token/sendmessage?chat_id=$param1&text=$reply");
    }
        
        
    }else{
        $reponse = "echec de la transaction au niveau 1 \n reference de la transaction <b>" .$ref. "</b> Diool vous remercie... " ;
        
    }
    $replyMarkupp = array(
        'keyboard' => array(
            array("Menu")
        ),
        'resize_keyboard' => true
    );
    $replyMarkup = json_encode($replyMarkupp);

    
    return array($reponse, $replyMarkup);
    //return "My name is ".$param1;
}