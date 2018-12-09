<?php

require_once 'config.php';


// Nim value
$dbresult = "SELECT nimi_value FROM deadlist WHERE a = 0 AND b = 0";
$dbresult = $conn->query($dbresult);

$nim_value = array();
while ($row = $dbresult->fetch_assoc()) {
    $nim_value[] = $row;
}

$nim_value_calc = 0;

foreach ($nim_value as $row) {
    $nim_value_calc += $row["nimi_value"];
}

echo($nim_value_calc);

exit;


$total_divided = ($nim_value_calc) / 2;

echo("\n TOTAL/2: " . $total_divided);


echo("\n");


$fund = $wpdb->get_var("SELECT balance FROM wallets_admin WHERE pool = 'fund'");
// echo($fund);
$fund = $fund + $total_divided;

$wpdb->update( 'wallets_admin', array ( 'balance' => $fund, 'timestamp' => date('Y-m-d H:i:s') ), array ( 'pool' => 'fund') );


$alive_nimipets = $wpdb->get_results ("SELECT user_ID, nim_lastfed, nim_value, nim_name, nim_born FROM nimipets WHERE nim_state = 'alive'");

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



    if ((date($nimipet->nim_lastfed) > $dead_before) && (date($nimipet->nim_born) < $born_before)) {

        $not_dead[] = $nimipet;

        $i++;
    }
}

echo("\n Total: " . $i . "\n");


function cmp($a, $b)
{
    return strnatcmp($a->nim_born, $b->nim_born);
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
    $nim_name = $nimipet->nim_name;
    $html .= $nim_name . ": " . $nimipet->number . " NIM<br>";
}

$wpdb->insert( 
	'airdrop', 
	array( 
		'amount' => $total_amount, 
        'html' => $html,
        'timestamp' => date('Y-m-d H:i:s')
	)
);


// Give all living nimipets NIMs
foreach ($not_dead as $nimipet) {
    echo($nimipet->nim_value);
    $nim_value = $nimipet->nim_value + $nimipet->number;
    echo ($nimipet->nim_name . $nim_value . "\n");

    $wpdb->update( 'nimipets', array ( 'nim_value' => $nim_value ), array ('user_ID' => $nimipet->user_ID) );
}

// Drop values from dead nimipets
$wpdb->query( 
    "
    UPDATE deadlist 
    SET a = '1'

    "
);


?>