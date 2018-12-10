<?php

require_once 'config.php';


// Nim value
$dbresult = "SELECT nimi_value FROM deadlist WHERE a = 0 AND b = 0";
$dbresult = $conn->query($dbresult);

$nimi_value = array();
while ($row = $dbresult->fetch_assoc()) {
    $nimi_value[] = $row;
}

$nimi_value_calc = 0;

foreach ($nimi_value as $row) {
    $nimi_value_calc += $row["nimi_value"];
}

echo("TOTAL: " . $nimi_value_calc);

$total_divided = ($nimi_value_calc) / 2;

echo("\nTOTAL/2: " . $total_divided);
echo("\n");

$fund = "SELECT balance FROM wallets_admin WHERE pool = 'fund'";
$fund = $conn->query($fund);
$fund = $fund->fetch_assoc();

echo($fund["balance"]);

$fund = $fund["balance"] + $total_divided;

echo ("\n".$fund);
// exit;


// // $wpdb->update( 'wallets_admin', array ( 'balance' => $fund, 'timestamp' => date('Y-m-d H:i:s') ), array ( 'pool' => 'fund') );
// $sql = "UPDATE wallets_admin SET balance = ".$fund.", timestamp = ".date('Y-m-d H:i:s')." WHERE pool = 'fund'";
// $conn->query($sql);


// $alive_nimipets = $wpdb->get_results ("SELECT user_ID, nimi_lastfed, nimi_value, nimi_name, nimi_born FROM nimipets WHERE nimi_state = 'alive'");
$dbresult = "SELECT user_ID, nimi_lastfed, nimi_value, nimi_name, nimi_born FROM nimipets WHERE nimi_state = 'alive'";
$dbresult = $conn->query($dbresult);
$alive_nimipets = array();
while ($row = $dbresult->fetch_assoc()) {
    $alive_nimipets[] = $row;
}

// remove possible single quotes from JSON string
$alive_nimipets = str_replace("'", "", $alive_nimipets);


// var_dump($alive_nimipets);

// those who are not dead yet
$not_dead = [];

// current date -1 day
$dead_before = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - 86400);

echo(" D: " . date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - 86400) );

$born_before = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) - 259200);

echo("\n\n" . date('Y-m-d H:i:s') . "   " . $born_before . "\n\n");

$i = 0;
foreach ($alive_nimipets as $nimipet) {
    // $now = "2018-05-29 14:10:01";
    // $dead_before = date("2018-06-08 02:45:01");

    if ((date($nimipet["nimi_lastfed"]) > $dead_before) && (date($nimipet["nimi_born"]) < $born_before)) {

        $not_dead[] = $nimipet;

        $i++;
    }
}

echo("\n Total: " . $i . "\n");

function cmp($a, $b)
{
    return strnatcmp($a->nimi_born, $b->nimi_born);
}
usort($not_dead, "cmp");

$arraylength = count($not_dead);


$steps = 2 / ($arraylength -1);

// var_dump($not_dead);

$number = range(1, 3, $steps);


$number = array_reverse($number);
// print_r ($number);

$i = 0;
foreach ($not_dead as $nimipet) {
    $nimipet->number = $number[$i];
    $i++;
}

// var_dump($not_dead);

$total = 0;
foreach ($not_dead as $nimipet) {
    $total += $nimipet->number;
}

// echo($total);

$single_share = $total_divided / $total;

$total_amount = 0;
foreach ($not_dead as $nimipet) {
    $nimipet->number = $nimipet->number * $single_share;
    $total_amount += $nimipet->number;
}



$html = "";
echo("Total for community: " . $total_amount . "\n");

foreach ($not_dead as $nimipet) {
    $nimi_name = $nimipet->nimi_name;
    $html .= $nimi_name . ": " . $nimipet->number . " NIM<br>";
}

// LARA
echo("INSERT AIRDROP __");
// $wpdb->insert( 
// 	'airdrop', 
// 	array( 
// 		'amount' => $total_amount, 
//         'html' => $html,
//         'timestamp' => date('Y-m-d H:i:s')
// 	)
// );


// Give all living nimipets NIMs
foreach ($not_dead as $nimipet) {
    echo($nimipet->nimi_value);
    $nimi_value = $nimipet->nimi_value + $nimipet->number;
    echo ($nimipet->nimi_name . $nimi_value . "\n");

    // LARA
    echo ("UPDATE NIMIPETS_");
    // $wpdb->update( 'nimipets', array ( 'nimi_value' => $nimi_value ), array ('user_ID' => $nimipet->user_ID) );
}


// Drop values from dead nimipets
echo "LAST";
// $wpdb->query( 
//     "
//     UPDATE deadlist 
//     SET a = '1'

//     "
// );


?>