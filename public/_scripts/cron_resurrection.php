<?php

require_once 'config.php';


//
// ALIVE NIMIPETS THAT HAVEN'T RECEIVED RESURRECTION
//
$sql = "SELECT user_id, nimi_lastfed, nimi_value, nimi_name, nimi_born FROM nimipets WHERE nimi_state = 'alive'";
$result = $conn->query($sql);
$alive_nimipets = array();
while ($row = $result->fetch_assoc()) {
    $alive_nimipets[] = $row;
}

// remove possible single quotes from JSON string
$alive_nimipets = str_replace("'", "", $alive_nimipets);

$not_dead = [];

$date_one_month_ago = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - 2592000);
$date_one_day_ago = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - 86400);


// $i is how many nimipets are older than one month and eaten less than 1 day ago
$i = 0;
foreach ($alive_nimipets as $nimipet) {
    if ((date($nimipet["nimi_born"]) < $date_one_month_ago) && (date($nimipet["nimi_lastfed"]) > $date_one_day_ago)) {
        $not_dead[] = $nimipet;
        $i++;
    }
}

// check how many selected nimipets haven't received resurrection
$will_receive = [];
foreach ($not_dead as $nimipet) {
    $sql = "SELECT received FROM items WHERE user_id = ".$nimipet["user_id"]." AND item='resurrection'";
    $result = $conn->query($sql);
    if ($result) {
        $received = $result->fetch_assoc();
        if ($received["received"] == 0) {
            $will_receive[] = $nimipet["user_id"];
        }
    }
}

var_dump($will_receive);
// exit;

foreach ($will_receive as $nimipet) {
    $sql = "UPDATE items SET available = 1, received = 1 WHERE user_id = '$nimipet' AND item = 'resurrection'";
    $conn->query($sql);
}

?>