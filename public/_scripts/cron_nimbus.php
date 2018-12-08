<?php

require_once 'config.php';


$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $GLOBALS['api_url']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

// // comment these two lines on live server for security reasons!
// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, 0);
// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);

$headers = array();
$headers[] = $GLOBALS['api_auth'];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$output = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

// remove possible single quotes from JSON string
$output = str_replace("'", "", $output);

// Decode
$outputdecoded = json_decode($output, true);


$dbresult = "SELECT * FROM nimbus";
$dbresult = $conn->query($dbresult);
$dbblocks = array();
while ($row = $dbresult->fetch_assoc()) {
    $dbblocks[] = $row;
}


$dbresult = "SELECT user_id, nimi_value FROM nimipets";
$dbresult = $conn->query($dbresult);
$users = array();
while ($row = $dbresult->fetch_assoc()) {
    $users[] = $row;
}


foreach ($outputdecoded as $block) {
    $credit = true;
    foreach ($dbblocks as $dbblock) {
        if ($block["block"] == $dbblock["block"]) {
            $credit = false;
            break;
        }
    }
    if ($credit == true) {
        echo ("Block: " . $block["block"] . "\n");
        echo ("Total diff: " . $block["total_diff"] . "\n");
        echo ("Total Amount: " . $block["amount"] . " Satoshi \n\n" );
        foreach ($block["devices"] as $deviceKey => $device) {
            
            // if (substr($deviceKey, 0, 2) == 99) {
                // $user_ID = substr($deviceKey, 3);
                $user_ID = $deviceKey;
                $share = $device / $block["total_diff"] * $block["amount"] / 100000;
                echo "User: " . $user_ID . " " . $share . " NIM\n\n";

                foreach($users as $user) {
                    if ($user["user_id"] == $user_ID) {
                        $new_value = $user["nimi_value"] + $share;
                        
                        $sql = "UPDATE nimipets SET nimi_value = '$new_value' WHERE user_id = '$user_ID'";
                        $conn->query($sql);
                        break;
                    }
                }
            // }

        }
        $sql = "INSERT INTO nimbus (block, amount) VALUES (".$block["block"].", ".$block["amount"].")";
        $conn->query($sql);
    }
}

?>