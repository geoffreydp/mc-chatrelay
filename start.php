<?php

$obj = array(
      "version" => "v2",
      "content" => array(
        "actions" => array(
          array(
          "action" => "set_field_value",
          "field_name" => "sessionId",
          "value" => uniqid()
        )
        )
      )

);

header('Content-Type: application/json');
echo json_encode($obj);
