<?php
$access_token = '5612142866:AAFvvpi--r1CZY7VaEbZRkriMUEzwlC-arg';
$api = 'https://api.telegram.org/bot' . $access_token;
$output = json_decode(file_get_contents('php://input'), TRUE);
$message = $output['message']['text'];
$chat_id = $output['message']['chat']['id'];

if ($output['callback_query'] != null){
    $data = $output['callback_query']['data'];
    $data_id = $output['callback_query']['id'];
    $chat = $output['callback_query']['message']['chat']['id'];
    switch($data){
        case "/123":
           answerCallback($data_id, 'marchand mayment');
           sendMessage($chat, "oui grand", null);
        break;
        case "/plz":
           answerCallback($data_id, 'bill payment');
           sendMessage($chat, "non petit", null);
        break;
     }
   }
elseif ($message != null) {
    switch($message) {
        case '/test':  
        $inline_button1 = array("text"=>"Marchant payment","callback_data"=>"/123");
        $inline_button2 = array("text"=>"2","callback_data"=>'/plz');
        $inline_button3 = array("text"=>"3","callback_data"=>'/plz');
        $inline_button4 = array("text"=>"work plz","callback_data"=>'/plz');
        $inline_button5 = array("text"=>"work plz","callback_data"=>'/plz');
        $inline_keyboard = [[$inline_button1, $inline_button2, $inline_button3, $inline_button4, $inline_button5]];
        $keyboard=array("inline_keyboard"=>$inline_keyboard, "resize_keyboard" => true);
        $replyMarkup = json_encode($keyboard); 
         sendMessage($chat_id, "ok", $replyMarkup);
        break;
        case 1:
            $replyMarkupp = array(
                'keyboard' => array(
                     array("Get all foods"),
                     array("Menu", "List"),
                     array("Menu", "List"),
                     array("Menu", "List"),
                     array("Menu", "List"),
                     array("Menu", "List"),
                     array("Cancel")
                ),
                'resize_keyboard' => true
           );
           $replyMarkup = json_encode($replyMarkupp); 
            sendMessage($chat_id, "bonjour", $replyMarkup);
            break;
        case "List":
            $replyMarkupp = array(
                'keyboard' => array(
                     array("Get all foods"),
                     array("Menu", "List"),
                     array("Cancel")
                ),
                'resize_keyboard' => true
           );
           $replyMarkup = json_encode($replyMarkupp); 
            sendMessage($chat_id, "nom non", $replyMarkup);
            break;

    }
}

function sendMessage($chat_id, $message, $replyMarkup) {
  file_get_contents($GLOBALS['api'] . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($message) . '&reply_markup=' . $replyMarkup);
}
function answerCallback($id, $text) {
    file_get_contents($GLOBALS['api'] . '/answerCallbackQuery?callback_query_id='.$id.'&text='.$text);
}
?>