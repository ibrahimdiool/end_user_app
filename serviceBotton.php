<?php
function service1($message, $datee, $chatId)
{
    $token = '5612142866:AAFvvpi--r1CZY7VaEbZRkriMUEzwlC-arg';
    require("connexion.php");

    //----------------------------------------------------------------Collect data from data base
    $base->exec("SET CHARACTER SET utf8");
    $query1 = $base->prepare("SELECT * FROM transaction WHERE chatId = '$chatId'");
    //$query1->bindparam(':chat', $chatId);
    $query1->execute();
    $userTG = $query1->fetch();
    $id = $userTG['id'];

    if ($userTG['marchand'] == 1) {
        switch ($message) {
            case 10:
                $reeq = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);
                $reply = urlencode(" Thank you for using Diool. Sorry we could not finish this. \n \n See you next time.");
                $replyMarkupp = array(
                    'keyboard' => array(
                         array("Merchant Payment"),
                         array("Pay a bill", "Prepaid Top up"),
                         array("Refer the app", "Contact support")
                    ),
                    'resize_keyboard' => true
               );
               $replyMarkup = json_encode($replyMarkupp);
                break;
            case 99:
                $reeq = "UPDATE transaction set chatId=chatId*10, datee=" . $datee . " WHERE id =" . $id;
                $base->exec($reeq);
                $reply = urlencode("Hello, and welcome to <b>Diool Payment </b> Choose, \n 1. For merchant payment \n 2. To pay a bill \n 3. For prepaid Top up \n 4. For refer the app to a friend \n 5. To contact support");
                $replyMarkupp = array(
                    'keyboard' => array(
                         array("Merchant Payment"),
                         array("Pay a bill", "Prepaid Top up"),
                         array("Refer the app", "Contact support")
                    ),
                    'resize_keyboard' => true
               );
               $replyMarkup = json_encode($replyMarkupp);
                break;
            default:
                /*$q = $base->prepare('SELECT * FROM marchand WHERE marchandCode = :code');
                $q->bindparam(':code', $message);
                $q->execute();
                $marchand = $q->fetch();
                $marchandId = $marchand['id'];

                if ($q->rowCount() == 1) {
                    $req0 = "UPDATE transaction set marchand='$marchandId', datee='$datee' WHERE id ='$id'";
                    $base->exec($req0);
                    $reply = urlencode("votre marchand est: <b>" . $marchand['bename'] . "</b> \n Choisissez votre methode de paiement :\n 1. Pour Orange \n 2. Pour MTN  \n 3. Pour EXpres Union \n 99. Pour retourner \n 10. Pour annuler ");
                } else {
                    $reply = urlencode(" Marchand indisponible resaisissez a nouveau  \n 99. Pour return \n 10. Pour cancel ");
                }*/
                require_once('getEmailBotton.php');
                list($r, $replyMarkup) = getEmail($message, $id);

                $reply = urlencode($r);
        }
    } else {
        if ($userTG['methode'] == 0) {
            switch ($message) {
                case 1:
                    $req1 = "UPDATE transaction set methode=" . $message . ", datee=" . $datee . " WHERE id =" . $id;
                    $base->exec($req1);
                    //$_SESSION['code'] = $message;
                    $reply = urlencode(" Please send me the orange number you are paying with. <b>eg: 69XXXXXXX</b>  \n \n 99. To return \n 10. To end process ");
                    
                    //------------------------------------------------------botton option
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
                    
                    //------------------------------------------------------Reply botton option
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
                    
                    //------------------------------------------------------Reply botton option
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
                    break;
                case 99:
                    $req5 = "UPDATE transaction set marchand=1, datee=" . $datee . " WHERE id =" . $id;
                    $base->exec($req5);
                    $reply = urlencode(" Please send me the merchant's code or  \n \n 99.To return \n 10. To end process. ");
                    
                    //------------------------------------------------------Reply botton option
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
            }
        } else {
            $query2 = $base->prepare('SELECT * FROM transaction WHERE chatId = :chatId');
            $query2->bindparam(':chatId', $chatId);
            $query2->execute();
            $userTG = $query2->fetch();
            $id = $userTG['id'];
            $code = $userTG['methode'];
            if ($userTG['phone'] == 0) {
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
                        
                        
                    //------------------------------------------------------Reply botton option
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
                                    $reply = urlencode(" Please send me the amount or choose  \n \n 99. To return \n 10. To end process");
                                    
                                    
                                     //------------------------------------------------------Reply botton option
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
                                    $reply = urlencode(" Please send me the amount or choose  \n \n 99. To return \n 10. To end process");
                                    
                                    
                                    //------------------------------------------------------Reply botton option
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
                                    $reply = urlencode(" Please send me the amount or choose \n \n 99. To return \n 10. To end process");
                                    
                                    
                                    //------------------------------------------------------Reply botton option
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
                                    
                                    
                                    //------------------------------------------------------Reply botton option
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
                                    $reply = urlencode("Please Send me the reference of this payment or. \n \n 0. To skip this step ");
                                    
                                    
                                    //------------------------------------------------------Reply botton option
                                    $replyMarkupp = array(
                                        'keyboard' => array(
                                            array("skip this step")
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
                    if ($userTG['reference'] == NULL) {
                        if ($message == NULL) {
                            $req1 = "UPDATE transaction set reference=0, datee=" . $datee . " WHERE id =" . $id;
                            $base->exec($req1);
                        } else {
                            $req1 = "UPDATE transaction set reference='$message', datee='$datee' WHERE id = '$id'";
                            $base->exec($req1);
                        }
                        $q = $base->prepare('SELECT * FROM marchand WHERE id = :id');
                        $q->bindparam(':id', $userTG['marchand']);
                        $q->execute();
                        $marchand = $q->fetch();
                        //$marchand = $marchand['bename']; 
                        if ($message == "0") {
                            $ref = "";
                        } else {
                            $ref = "avec pour reference <b>" . $message . "</b>";
                        }
                        $reply = urlencode("The payment of <b>" . $userTG['amount'] . " </b> from number <b> " . $userTG['phone'] . " </b> to the marchand <b>" . $marchand['bename'] . "</b> " . $ref . " is pending... \n \n 1. To continue \n \n 10. To end process ");
                        
                        
                        //------------------------------------------------------Reply botton option
                        $replyMarkupp = array(
                            'keyboard' => array(
                                array("Continue", "10. End process")
                            ),
                            'resize_keyboard' => true
                        );
                        $replyMarkup = json_encode($replyMarkupp);
                    } else {

                        if ($userTG['statut'] == 100) {

                            switch ($message) {
                                case 1:
                                    switch ($userTG['methode']) {
                                        case 1:
                                            $validTest = urlencode("Confirm your transaction by dialing #150# or using your Orange Money Application");
                                            break;
                                        case 2:
                                            $validTest = urlencode("Confirm your transaction by dialing *126# or  using your MTN MOMO Application");
                                            break;
                                        case 3:
                                            $validTest = urlencode("Confirm the transaction in your Express Union application ");
                                            break;
                                    }
                                    file_get_contents("https://api.telegram.org/bot$token/sendmessage?chat_id=$chatId&text=$validTest");
                                    require_once('paymentBotton.php');
                                    list($resp, $replyMarkup) = payment($userTG['chatId']);
                                    $reply = urlencode($resp);
                                    //$reply = "opération Validé avec succès...";

                                    break;
                                case 10:
                                    $reeq = "UPDATE transaction set chatId=chatId*1000, datee=" . $datee . " WHERE id =" . $id;
                                    $base->exec($reeq);
                                    $reply = " Thank you for using Diool. Sorry we could not finish this. \n \n See you next time.";
                                    break;
                                default:
                                    $reply = urlencode("invalid choice, The payment of<b>" . $userTG['amount'] . " </b> from number <b> " . $userTG['phone'] . " </b> to the marchand <b>" . $marchand['bename'] . " " . $ref . "</b>is pending... \n \n 99. To return \n 10. To end process ");
                            }
                        } else {
                            //---------------------not using now (for raiting)
                            if ($userTG['favorite'] == 0) {
                                switch ($message) {

                                        // ------------------------------------------pour ajouter ce marchand dans la liste des favorites
                                        /*case 1:
                                        $q = $base->prepare('SELECT * FROM marchand WHERE id = :code');
                                        $q->bindparam(':code', $userTG['marchand']);
                                        $q->execute();
                                        $marchand = $q->fetch();
                                        $marchandname = $marchand['bename'];

                                        $query1 = $base->prepare('INSERT INTO favorite (marchand, name, chatUser)VALUES(:marchand, :name, :chatUser)');
                                        $query1->execute(array(
                                            'marchand' => $userTG['marchand'],
                                            'name' => $marchandname,
                                            'chatUser' => $userTG['chatId'],
                                        ));

                                        $req1 = "UPDATE transaction set favorite=2  WHERE id =" . $id;
                                        $base->exec($req1);

                                        $reply = urlencode("le marchand " . $marchandname . " a été enregistré avec succèss dans vos favoris  \n\n donnez un avis sur le marchand \n 0. Pour passer \n 10. Pour annuler  ");
                                        break;*/
                                    case 2:
                                        $req1 = "UPDATE transaction set chatId=chatId*1000, favorite=1  WHERE id =" . $id;
                                        $base->exec($req1);
                                        // $_SESSION['code'] = $message;
                                        $reply = urlencode("The bot's share link is: http://t.me/dioolPayment_bot \n Thank you for using DIOOL ");
                                        $replyMarkupp = array(
                                            'keyboard' => array(
                                                array("Menu")
                                            ),
                                            'resize_keyboard' => true
                                        );
                                        $replyMarkup = json_encode($replyMarkupp);
                                        break;
                                        /*case 3:
                                        $req1 = "UPDATE transaction set favorite=3  WHERE id =" . $id;
                                        $base->exec($req1);
                                        // $_SESSION['code'] = $message;
                                        $reply = urlencode("donnez un avis sur le marchand \n \n 0. Pour passer \n 10. Pour annuler </b>");
                                        break;*/
                                    case 10:
                                        $req5 = "UPDATE transaction set chatId=chatId*10 WHERE id =" . $id;
                                        $base->exec($req5);
                                        $reply = urlencode("Thank you for using DIOOL and let me know if you need anything else");
                                        $replyMarkupp = array(
                                            'keyboard' => array(
                                                array("Menu")
                                            ),
                                            'resize_keyboard' => true
                                        );
                                        $replyMarkup = json_encode($replyMarkupp);
                                        break;
                                    default:
                                        $reply = urlencode("Ooups, not sure what you want me to do. Can you please provide a valid option ?");
                                }
                            } else {
                                if ($userTG['avisMarchand'] == NULL) {
                                    switch ($message) {
                                        case 0:
                                            $req1 = "UPDATE transaction set avisMarchand='rien' WHERE id =" . $id;
                                            $base->exec($req1);
                                            $reply = urlencode("Donnez une note de 1 à 5 au Marchand (sans virgule)... \n \n 0. Pour passer \n 10. Pour annuler ");
                                            break;
                                        case 10:
                                            $req2 = "UPDATE transaction set chatId=chatId*10 WHERE id =" . $id;
                                            $base->exec($req2);
                                            $reply = urlencode(" Thank you for using Diool. Sorry we could not finish this. \n \n See you next time.\n ");
                                            break;
                                        default:
                                            $req3 = "UPDATE transaction set avisMarchand=" . $message . " WHERE id =" . $id;
                                            $base->exec($req3);
                                            $reply = urlencode("Donnez une note de 1 à 5 au Marchand (sans virgule)...  \n \n 0. Pour passer cette etape \n 10. Pour annuler ");
                                    }
                                } else {
                                    if ($userTG['noteMarchand'] == 10) {
                                        switch ($message) {
                                            case 0:
                                            case 1:
                                            case 2:
                                            case 3:
                                            case 4:
                                            case 5:
                                                $req1 = "UPDATE transaction set noteMarchand=" . $message . " WHERE id =" . $id;
                                                $base->exec($req1);
                                                $reply = urlencode("Donnez un avis sur l'application ... \n \n 0. Pour passer \n 10. Pour annuler ");
                                                break;

                                            case 10:
                                                $req2 = "UPDATE transaction set chatId=chatId*10 WHERE id =" . $id;
                                                $base->exec($req2);
                                                $reply = urlencode("Diool vous remercie... \n ");
                                                break;
                                            default:
                                                $reply = urlencode("Choix érroné veuillez resaisir votre choix ");
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    return array($reply, $replyMarkup) ;
    //return "My name is ".$param1;
}
