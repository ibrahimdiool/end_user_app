<?php
function topup($message, $datee, $chatId)
{

    require("connexion.php");
    //----------------------------------------------------------------Collect data from data base
    $base->exec("SET CHARACTER SET utf8");
    $query1 = $base->prepare("SELECT * FROM transaction WHERE chatId = '$chatId'");
    //$query1->bindparam(':chat', $chatId);
    $query1->execute();
    $userTG = $query1->fetch();
    $id = $userTG['id'];
    $code = $userTG['methode'];


    if ($userTG['reference'] == NULL) {
        switch ($message) {
            case 10:
                $reeq = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);
                $reply = urlencode(" Diool user support vous remercie...");
                $replyMarkupp = array(
                    'keyboard' => array(
                        array("Menu"),
                    ),
                    'resize_keyboard' => true
                );
                $replyMarkup = json_encode($replyMarkupp);

                break;
            case 99:
                $reeq = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);
                $reply = urlencode("Hello, and welcome to <b>Diool </b> Choose, \n 1. For merchant payment \n 2. To pay a bill \n 3. For prepaid Top up \n 4. For refer the app to a friend \n 5. To contact support");

                //$replyMarkupp = NULL;
                //$replyMarkup = json_encode($replyMarkupp);
                break;
            default:
            //----------------------------------------------- Save top up option for the provider

                $reeq = "UPDATE transaction set reference='$message', datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);

                $reply = urlencode("Please add your payment method ? Choose \n \n");
                $replyMarkupp = array(
                    'keyboard' => array(
                        array("Orange money", "MTN MOMO"),
                        array("Express Union Money"),
                        array("99. Return", "10. End process")
                    ),
                    'resize_keyboard' => true
                );
                $replyMarkup = json_encode($replyMarkupp);
        }
    } else {
        if ($userTG['methode'] == 0) {
            //----------------------------------------------- Save payment methode
            switch ($message) {
                case 1:
                    $req1 = "UPDATE transaction set methode=" . $message . ", datee=" . $datee . " WHERE id =" . $id;
                    $base->exec($req1);
                    //$_SESSION['code'] = $message;
                    $reply = urlencode(" Please send me the orange number you are paying with. <b>eg: 69XXXXXXX</b>  \n \n 99. To return \n 10. To end process ");
                    $replyMarkupp = array(
                        'keyboard' => array(
                            array("99. Return", "10. End process")
                        ),
                        'resize_keyboard' => true
                    );
                    $replyMarkup = json_encode($replyMarkupp);
                    break;
                case 2:
                    $req1 = "UPDATE transaction set methode=" . $message . ", datee=" . $datee . " WHERE id =" . $id;
                    $base->exec($req1);
                    // $_SESSION['code'] = $message;
                    $reply = urlencode(" Please send me the MTN number you are paying with. <b>eg: 67XXXXXXX  \n \n 99. To return \n 10. To end process  </b>");
                    $replyMarkupp = array(
                        'keyboard' => array(
                            array("99. Return", "10. End process")
                        ),
                        'resize_keyboard' => true
                    );
                    $replyMarkup = json_encode($replyMarkupp);
                    break;
                case 3:
                    $req1 = "UPDATE transaction set methode=" . $message . ", datee=" . $datee . " WHERE id =" . $id;
                    $base->exec($req1);
                    //$_SESSION['code'] = $message;
                    $reply = urlencode(" Please send me the Express Union account number you are paying from. <b>eg: 69XXXXXXX ou 67XXXXXXX</b>   \n \n 99. To return \n 10. To end process ");
                    $replyMarkupp = array(
                        'keyboard' => array(
                            array("99. Return", "10. End process")
                        ),
                        'resize_keyboard' => true
                    );
                    $replyMarkup = json_encode($replyMarkupp);
                    break;
                case 10:
                    $req5 = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                    $base->exec($req5);
                    $reply = urlencode(" Thank you for using Diool. Sorry we could not finish this. \n \n See you next time.");
                    $replyMarkupp = array(
                        'keyboard' => array(
                            array("Menu"),
                        ),
                        'resize_keyboard' => true
                    );
                    $replyMarkup = json_encode($replyMarkupp);
                    break;
                case 99:
                    $req5 = "UPDATE transaction set reference=NULL, datee=" . $datee . " WHERE id =" . $id;
                    $base->exec($req5);
                    $reply = urlencode(" Please send me the merchant's code or  \n \n 99.To return \n 10. To end process. ");
                    $replyMarkupp = array(
                        'keyboard' => array(
                            array("99. Return", "10. End process")
                        ),
                        'resize_keyboard' => true
                    );
                    $replyMarkup = json_encode($replyMarkupp);
                    break;
                default:
                    $reply = urlencode("Ooups, not sure what you want me to do. Can you please provide a valid option ?");
                    $replyMarkupp = array(
                        'keyboard' => array(
                            array("Orange money", "MTN MOMO"),
                            array("Express Union Money"),
                            array("99. Return", "10. End process")
                        ),
                        'resize_keyboard' => true
                    );
                    $replyMarkup = json_encode($replyMarkupp);
            }
        } else {
            if ($userTG['phone'] == 0) {
                //----------------------------------------------- Save the phone number

                switch ($message) {
                    case 10:
                        $req5 = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                        $base->exec($req5);
                        $reply = urlencode(" Thank you for using Diool. Sorry we could not finish this. \n \n See you next time.");
                        break;
                    case 99:
                        $req4 = "UPDATE transaction set methode=0, datee=" . $datee . " WHERE id =" . $id;
                        $base->exec($req4);
                        $reply = urlencode("Please Choose \n\n 1. For Orange Money \n 2. MTN MOMO \n 3. Express Eunion Mobile Money    \n \n 99. To return \n 10. To end process ");
                        $replyMarkupp = array(
                            'keyboard' => array(
                                array("Orange money", "MTN MOMO"),
                                array("Express Union Money"),
                                array("99. Return", "10. End process")
                            ),
                            'resize_keyboard' => true
                        );
                        $replyMarkup = json_encode($replyMarkupp);
                        break;
                    default:
                        switch ($code) {
                            case 1:
                                if ($message > 655000000 && $message <= 699999999) {
                                    $req1 = "UPDATE transaction set phone=" . $message . ", datee=" . $datee . " WHERE id =" . $id;
                                    $base->exec($req1);
                                    $reply = urlencode(" Please send me the amount or choose \n \n ");
                                    $replyMarkupp = array(
                                        'keyboard' => array(
                                            array("99. Return", "10. End process")
                                        ),
                                        'resize_keyboard' => true
                                    );
                                    $replyMarkup = json_encode($replyMarkupp);
                                } else {
                                    $reply = urlencode("Invalid phone number. Please send me a valid Orange number  Ex: 69XXXXXXX");
                                }
                                break;
                            case 2:
                                if ($message > 650000000 && $message <= 689999999) {
                                    $req1 = "UPDATE transaction set phone=" . $message . ", datee=" . $datee . " WHERE id =" . $id;
                                    $base->exec($req1);
                                    $reply = urlencode(" Please send me the amount or choose \n \n ");
                                    $replyMarkupp = array(
                                        'keyboard' => array(
                                            array("99. Return", "10. End process")
                                        ),
                                        'resize_keyboard' => true
                                    );
                                    $replyMarkup = json_encode($replyMarkupp);
                                } else {
                                    $reply = urlencode("Invalid phone number. Please send me a valid MTN number  Ex: 67XXXXXXX");
                                }
                                break;
                            case 3:
                                if ($message > 650000000 && $message <= 699999999) {
                                    $req1 = "UPDATE transaction set phone=" . $message . ", datee=" . $datee . " WHERE id =" . $id;
                                    $base->exec($req1);
                                    $reply = urlencode(" Please send me the amount or choose  \n \n ");
                                    $replyMarkupp = array(
                                        'keyboard' => array(
                                            array("99. Return", "10. End process")
                                        ),
                                        'resize_keyboard' => true
                                    );
                                    $replyMarkup = json_encode($replyMarkupp);
                                } else {
                                    $reply = urlencode("Invalid phone number. Please send me a valid number Ex: 67XXXXXXX ou 69XXXXXXX");
                                }
                                break;
                        }
                }
            } else {
                if ($userTG['amount'] == 0) {
                    if (is_numeric($message)) {
                        if ($message <= 0) {
                            $reply = urlencode("Not enough funds to complete transaction. Please specify an amount within the limits of the available funds. \n ");
                        } else {
                            switch ($message) {
                                case 10:
                                    $req1 = "UPDATE transaction set chatId=chatId*100, datee=" . $datee . " WHERE id =" . $id;
                                    $base->exec($req1);
                                    $reply = urlencode(" Thank you for using Diool. Sorry we could not finish this. \n \n See you next time.");
                                    $replyMarkupp = array(
                                        'keyboard' => array(
                                            array("Menu")
                                        ),
                                        'resize_keyboard' => true
                                    );
                                    $replyMarkup = json_encode($replyMarkupp);
                                    break;
                                case 99:
                                    $req1 = "UPDATE transaction set phone=0, datee=" . $datee . " WHERE id =" . $id;
                                    $base->exec($req1);
                                    $reply = urlencode("Resaisisser votre numero de téléphone... \n ");
                                    break;
                                default:
                                    $req5 = "UPDATE transaction set amount=" . $message . ", datee=" . $datee . " WHERE id =" . $id;
                                    $base->exec($req5);

                                    //$r = payment($userTG['chatId']);
                                    //$r = 4;
                                    //$reqq = "UPDATE tgdata set chatId=chatId*10000, datee=".$datee." WHERE id =".$id ;
                                    //$base->exec($reqq);
                                    //$reply=urlencode("The payment of ".$message." from the account ".$userTG['phone']." is pending... \n ".$validTest);
                                    //$reply = urlencode("Le paiement de <b>" . $message . " </b> du numero <b> " . $userTG['phone'] . " </b> vers le compte <b>" . $userTG['textt'] . "</b> est encour... \n 1. pour valider \n 99. pour annuler ");
                                    $reply = urlencode(" Please send me the phone number how will received the airtime  \n \n ");
                                    $replyMarkupp = array(
                                        'keyboard' => array(
                                            array("99. Return", "10. End process")
                                        ),
                                        'resize_keyboard' => true
                                    );
                                    $replyMarkup = json_encode($replyMarkupp);
                            }
                        }
                    } else {
                        $reply = urlencode(" the entered value is not a number ");
                    }
                } else {
                    if ($userTG['phoneAirtime'] == 0) {
                        if ($message > 650000000 && $message <= 699999999) {
                            $req1 = "UPDATE transaction set phoneAirtime=" . $message . ", datee=" . $datee . " WHERE id =" . $id;
                            $base->exec($req1);
                            $reply = urlencode(" Achat airtime d'un montant de " . $userTG['amount'] . " pour le numero " . $message . " par le compte " . $userTG['phone'] . " \n \n ");
                            $replyMarkupp = array(
                                'keyboard' => array(
                                    array("Continue", "End process")
                                ),
                                'resize_keyboard' => true
                            );
                            $replyMarkup = json_encode($replyMarkupp);
                        } else {
                            $reply = urlencode("Invalid phone number. Please send me a valid number Ex: 67XXXXXXX ou 69XXXXXXX");
                        }
                    } else {
                        switch ($message) {
                            case 1:
                                require_once('paymentAirtimeBotton.php');
                                list($repl, $replyMarkup) = paymentAirtime($chatId);

                                $reply = urlencode($repl);
                                break;
                            case 10:
                                $req1 = "UPDATE transaction set chatId=chatId*100, datee=" . $datee . " WHERE id =" . $id;
                                $base->exec($req1);
                                $reply = urlencode(" Thank you for using Diool. Sorry we could not finish this. \n \n See you next time.");
                                $replyMarkupp = array(
                                    'keyboard' => array(
                                        array("Menu")
                                    ),
                                    'resize_keyboard' => true
                                );
                                $replyMarkup = json_encode($replyMarkupp);
                                break;
                        }
                    }
                }
            }
        }
    }
    return array($reply, $replyMarkup);
}
