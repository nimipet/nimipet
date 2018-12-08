<?php

require_once 'config.php';


$sql = "UPDATE nimipets SET food_today=0";

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();


?>