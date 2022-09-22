<?php
$input = file_get_contents('php://input');
$update = json_decode($input, true);
//$message = $update->message;
//$chat_id = $message->chat->id;

$token = '5612142866:AAFvvpi--r1CZY7VaEbZRkriMUEzwlC-arg';
$messageOld = $update["message"]["text"];
$datee = $update["message"]["date"];
$chatId = $update["message"]["chat"]["id"];
$reply = "Diool vous remercie";

//-------------------------------------conversion of the botton to action (code)
switch ($messageOld) {
    case "Merchant Payment":
        $message = 1;
        break;
    case "Pay a bill":
        $message = 2;
        break;
    case "Prepaid Top up":
        $message = 3;
        break;
    case "Refer the app":
        $message = 4;
        break;
    case "Contact support":
        $message = 5;
        break;
    case "99. Return":
        $message = 99;
        break;
    case "10. End process":
        $message = 10;
        break;
    case "Orange money":
        $message = 1;
        break;
    case "MTN MOMO":
        $message = 2;
        break;
    case "Express Union Money":
        $message = 3;
        break;
    case "skip this step":
        $message = 0;
        break;
    case "Continue":
        $message = 1;
        break;
    case "Share the application":
        $message = 2;
        break;
    case "Air time":
        $message = 1;
        break;
    case "End our chat":
        $message = 10;
        break;

    default:
        $message = $messageOld;
}


require("connexion.php");

$base->exec("SET CHARACTER SET utf8");

$query1 = $base->prepare("SELECT * FROM transaction WHERE chatId = '$chatId'");
//$query1->bindparam(':chat', $chatId);
$query1->execute();
$userTG = $query1->fetch();
$id = $userTG['id'];
$code = $userTG['methode'];
if ($query1->rowCount() == 1) {
    if ($userTG['servicee'] == 1) {
        //------------------------------------------------------For the marchand payment

        require_once('serviceBotton.php');
        list($reply, $replyMarkup) = service1($message, $datee, $chatId);
    } elseif ($userTG['servicee'] == 2) {
        //------------------------------------------------------For pay bill
        switch ($message) {
            case 10:
                $reeq = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);
                $reply = urlencode(" Diool Paiement facture vous remercie...");
                break;
            case 99:
                $reeq = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);
                $reply = urlencode("Hello, and welcome to <b>Diool </b> Choose, \n 1. For merchant payment \n 2. To pay a bill \n 3. For prepaid Top up \n 4. For refer the app to a friend \n 5. To contact support");
                break;
            default:
                $reply = urlencode("Ooups, not sure what you want me to do. Can you please provide a valid option ?");
        }
    } elseif ($userTG['servicee'] == 3) {
        //------------------------------------------------------For prepaid Top Up
        require_once('topup.php');
        list($reply, $replyMarkup) = topup($message, $datee, $chatId);
        
    } else {
        //------------------------------------------------------Contact support
        switch ($message) {
            case 10:
                $reeq = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);
                $reply = urlencode(" Click on this link to contact support \n http://t.me/ChatBot_diool_bot ");
                break;
            case 99:
                $reeq = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);
                $reply = urlencode("Hello, and welcome to <b>Diool </b> Choose, \n 1. For merchant payment \n 2. To pay a bill \n 3. For prepaid Top up \n 4. For refer the app to a friend \n 5. To contact support");
                break;
            default:
                $reply = urlencode("Ooups, not sure what you want me to do. Can you please provide a valid option ?");
        }
    }
} else {
    //------------------------------------------------------For a new action (payment, pay bill, Top Up)

    if ($message == 1 || $message == 2 || $message == 3 || $message == 5) {
        $query1 = $base->prepare('INSERT INTO transaction (servicee, refInterne, refExterne, phone, amount, datee, chatId, marchand)VALUES(:servicee, :refInterne, :refExterne, :phone, :amount, :datee, :chatId, :marchand)');
        $query1->execute(array(
            'servicee' => $message,
            'refInterne' => 'd',
            'refExterne' => 'd',
            'phone' => 0,
            'amount' => 0,
            'datee' => $datee,
            'chatId' => $chatId,
            'marchand' => 1,
        ));
    }
    switch ($message) {
        case 1:
            $reply = urlencode(" Please send me the merchant's code ");
            $replyMarkupp = array(
                'keyboard' => array(
                    array("99. Return", "10. End process")
                ),
                'resize_keyboard' => true
            );
            $replyMarkup = json_encode($replyMarkupp);
            break;
        case 2:
            $reply = urlencode("Invoice payment in design \n \n 99.To return \n 10. To end process.");
            break;
        case 3:
            $reply = urlencode("Choose one service in the menu \n \n  ");
            $replyMarkupp = array(
                'keyboard' => array(
                    array("Air time", "Canal +"),
                    array("Prepaid Eneo", "Prepaid Camwater"),
                    array("99. Return", "10. End process")
                ),
                'resize_keyboard' => true
            );
            $replyMarkup = json_encode($replyMarkupp);
            break;

        case 4:
            $reply = urlencode("To invite a friend to use the application, use the following link http://t.me/dioolPayment_bot Thank you.");
            break;

        case 5:
            $reply = urlencode("Support contact in development \n \n 99.To return \n 10. To end process.");
            break;
        default:
            $reply = urlencode("Hello, and welcome to <b>Diool </b> Choose one item in the menu \n \n ");
            $replyMarkupp = array(
                'keyboard' => array(
                    array("Merchant Payment"),
                    array("Pay a bill", "Prepaid Top up"),
                    array("Refer the app", "Contact support")
                ),
                'resize_keyboard' => true
            );
            $replyMarkup = json_encode($replyMarkupp);
    }
}



file_get_contents("https://api.telegram.org/bot$token/sendmessage?chat_id=$chatId&text=$reply&parse_mode=html&reply_markup=$replyMarkup");
