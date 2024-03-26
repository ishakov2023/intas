<?php
if(session_status() == PHP_SESSION_NONE) {
    session_start();
}
require "Connect/Database.php";

$db = new Database();
$conn = $db->getConnection();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sqlRegions = "SELECT id, name FROM regions";
$resultRegions = $conn->query($sqlRegions);

$regions = array();
if ($resultRegions->num_rows > 0) {
    while ($row = $resultRegions->fetch_assoc()) {
        $regions[] = $row;
    }
}

$_SESSION['regions'] = $regions;

$sqlCouriers = "SELECT id, name FROM couriers";
$resultCouriers = $conn->query($sqlCouriers);

$couriers = array();
if ($resultCouriers->num_rows > 0) {
    while ($row = $resultCouriers->fetch_assoc()) {
        $couriers[] = $row;
    }
}

$_SESSION['couriers'] = $couriers;

?>


