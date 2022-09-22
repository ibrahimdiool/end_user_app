<?php
$input = file_get_contents('php://input');
$update = json_decode($input, true);
//$message = $update->message;
//$chat_id = $message->chat->id;

$token = '5612142866:AAFvvpi--r1CZY7VaEbZRkriMUEzwlC-arg';
$message = $update["message"]["text"];
$datee = $update["message"]["date"];
$chatId = $update["message"]["chat"]["id"];
$reply = "Diool vous remercie";

require("connexion.php");

$base->exec("SET CHARACTER SET utf8");

$query1 = $base->prepare("SELECT * FROM transaction WHERE chatId = '$chatId'");
//$query1->bindparam(':chat', $chatId);
$query1->execute();
$userTG = $query1->fetch();
$id = $userTG['id'];
if ($query1->rowCount() == 1) {
    if ($userTG['servicee'] == 1) {

        require_once('service1.php');
        $reply = service1($message, $datee, $chatId);

    } elseif ($userTG['service'] == 2) {
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
    } elseif ($userTG['service'] == 3) {
        switch ($message) {
            case 10:
                $reeq = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);
                $reply = urlencode(" Diool user support vous remercie...");
                break;
            case 99:
                $reeq = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);
                $reply = urlencode("Hello, and welcome to <b>Diool </b> Choose, \n 1. For merchant payment \n 2. To pay a bill \n 3. For prepaid Top up \n 4. For refer the app to a friend \n 5. To contact support");
                break;
            default:
                $reply = urlencode("Ooups, not sure what you want me to do. Can you please provide a valid option ?");
        }
    } else {
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
            $reply = urlencode(" Please send me the merchant's code or  \n \n 99.To return \n 10. To end process. ");
            break;
        case 2:
            $reply = urlencode("Invoice payment in design \n \n 99.To return \n 10. To end process.");
            break;
        case 3:
            $reply = urlencode("Prepaid Top up incoming  \n \n 99.To return \n 10. To end process. ");
            break;

        case 4:
            $reply = urlencode("To invite a friend to use the application, use the following link http://t.me/dioolPayment_bot Thank you.");
            break;

        case 5:
            $reply = urlencode("Support contact in development \n \n 99.To return \n 10. To end process.");
            break;
        default:
            $reply = urlencode("Hello, and welcome to <b>Diool </b> Choose, \n \n 1. For merchant payment \n 2. To pay a bill \n 3. For prepaid Top up \n 4. For <b>refer</b> the app to a friend \n 5. To <b>contact support</b>");
    }
}
    


file_get_contents("https://api.telegram.org/bot$token/sendmessage?chat_id=$chatId&text=$reply&parse_mode=html&reply_markup=$replyMarkup");
