<?php
function getEmail($param1, $id)
{
    require("connexion.php");

    //----------------------------------------------------------------Collect data from data base
    $base->exec("SET CHARACTER SET utf8");
    $q = $base->prepare("SELECT * FROM marchand WHERE marchandCode = '$param1' AND statut='verify'");
    $q->bindparam(':code', $param1);
    $q->execute();
    $marchand = $q->fetch();
    $marchandId = $marchand['id'];
    $tokenAll = $marchand['tokenAll'];
    session_start();
    $_SESSION['bename'] = NULL;


    if ($q->rowCount() == 1) {
        $req0 = "UPDATE transaction set marchand='$marchandId' WHERE id ='$id'";
        $base->exec($req0);


        //____________________________________________________________________ header for API
        $headers =  [
            "Content-Type: application/json",
            "Authorization: Bearer " . $tokenAll,
            "Access-Control-Allow-Origin: *",
            "Access-Control-Allow-Headers: Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-GitHub-OTP, X-Requested-With",
            "Access-Control-Expose-Headers: ETag, Link, X-GitHub-OTP, x-ratelimit-limit, x-ratelimit-remaining, x-ratelimit-reset, X-OAuth-Scopes, X-Accepted-OAuth-Scopes, X-Poll-Interval",
            "x-beversion: 3.5.0"
        ];
        // ---------------------------------------------------------body of the request and send the request
        $link = curl_init();
        curl_setopt($link, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($link, CURLOPT_RETURNTRANSFER, true);


        curl_setopt($link, CURLOPT_URL, "https://core.diool.me/core/api/v1/useraccount/getBusinessEntityInfo");
        //curl_setopt($link, CURLOPT_ , true);
        //curl_setopt($link, CURLOPT_RETURNTRANSFER, true);

        //curl_setopt($link, CURLOPT_POSTFIELDS, $data);

        $reponse = curl_exec($link);
        $data1 = json_decode($reponse, true);
        //echo $reponse;
        //echo $data1['errors'];

        $h = curl_getinfo($link, CURLINFO_HTTP_CODE);
        $h1 = $data1['code'];
        curl_close($link);
        //echo $h1;

        if ($data1['code'] == 0) {
            //------------------------------------------------------when the request is successful

            $mail = $data1['result']['primaryOwnerInfo']['email'];
            $bename = $data1['result']['businessName'];

            $req00 = "UPDATE marchand set bename='$bename', mail='$mail' WHERE id ='$marchandId'";
            $base->exec($req00);
            $reply = ("Great! Your Merchant is: <b>" . $bename . "</b> \n How would you like to pay ? Choose \n \n 1. For Orange Money \n 2. MTN MOMO  \n 3. Express Eunion Mobile Money  \n \n 99. To return \n 10. To end process ");
            $replyMarkupp = array(
                'keyboard' => array(
                    array("Orange money", "MTN MOMO"),
                    array("Express Union Money"),
                    array("99. Return", "10. End process")
                ),
                'resize_keyboard' => true
           );
           $replyMarkup = json_encode($replyMarkupp);
        } else {
            //------------------------------------------------------when the request is fail
            $reply = "diool server failure  \n \n 99. To return \n 10. To end process ";
            $replyMarkupp = array(
                'keyboard' => array(
                    array("99. Return", "10. End process")
                ),
                'resize_keyboard' => true
            );
            $replyMarkup = json_encode($replyMarkupp);
        }
    } else {
        //------------------------------------------------------when the marchand not exist

        $reply = (" Ooups! Sorry we cannot find this merchant on our system. Please check that you sent a valid merchant code or send a new one  \n \n 99. To return \n 10. To end process ");
        $replyMarkupp = array(
            'keyboard' => array(
                array("99. Return", "10. End process")
            ),
            'resize_keyboard' => true
        );
        $replyMarkup = json_encode($replyMarkupp);
    }

    return array($reply, $replyMarkup);
    //return "My name is ".$param1;
}
