<?php

$configs = include('config.php');

try {
    $ch = curl_init();
    $userquery = $_POST['userSays'];
    $query = curl_escape($ch,$_POST['userSays']);
    $sessionid = curl_escape($ch,$_POST['sessionId']);
// works!    curl_setopt($ch, CURLOPT_URL, "https://api.dialogflow.com/v1/query?v=20150910&query=hello&lang=en&sessionId=5b8339095ca30");
    curl_setopt($ch, CURLOPT_URL, "https://api.dialogflow.com/v1/query?v=20150910&query=".$query."&lang=en&sessionId=".$sessionid);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer '.trim($configs['CLIENT_ACCESS_TOKEN'])));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    $dec = json_decode($output);
    $messages = $dec->result->fulfillment->messages;
    $speech = '';
    for($idx = 0; $idx < count($messages); $idx++){
        $obj = $messages[$idx];
        if($obj->type=='0'){
            $speech = $obj->speech;
        }
    }
    curl_close($ch);
    $obj = array(
          "version" => "v2",
          "content" => array(
            "messages" => array(
              array(
              "type" => "text",
              "text" => $speech
            )
            )
          )

    );
/* = original $obj from sample
      $obj = (object) [
        'messages' => array(
            (object)[
            'text'=>$speech
        ])
    ];
*/
    header('Content-Type: application/json');
    echo json_encode($obj);
}catch (Exception $e) {
    error_log($e->getMessage(), 0);
}
