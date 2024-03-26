<?php

require_once "../Connect/Database.php";

$db = new Database();
$conn = $db->getConnection();

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$regions_id = [];
$regions_query = $conn->query("SELECT id, duration_to_destination FROM regions");
while ($row = $regions_query->fetch_assoc()) {
    $regions_id[$row['id']] = $row['duration_to_destination'];
}

$couriers = [];
$couriers_query = $conn->query("SELECT id FROM couriers");
while ($row = $couriers_query->fetch_assoc()) {
    $couriers[] = $row['id'];
}

$start_date = strtotime('today');
$end_date = strtotime('+3 months', $start_date);

for ($current_date = $start_date; $current_date < $end_date; $current_date = strtotime('+1 day', $current_date)) {
    $courier_id = $couriers[array_rand($couriers)];
    $region_id = array_rand($regions_id);
    $duration = $regions_id[$region_id];
    $returnDuration = $duration * 2;
    $departure_date = date('Y-m-d', $current_date);
    $arrival_date = date('Y-m-d', strtotime("+$duration days", $current_date));
    $return_date = date('Y-m-d', strtotime("+$returnDuration days", $current_date));
    $getArrivalDate = $conn->query("SELECT return_date FROM trips WHERE courier_id = '$courier_id' ORDER BY return_date DESC LIMIT 1");
    $courierReturnDate = $getArrivalDate->fetch_assoc();
    $getDeparture = $conn->query("SELECT departure_date FROM trips ORDER BY departure_date DESC LIMIT 1");
    $departureDate = $getDeparture->fetch_assoc();
    if (empty($courierReturnDate)) {
        $insert_query = "INSERT INTO trips (region_id, courier_id, departure_date, arrival_date, return_date) VALUES ('$region_id', '$courier_id', '$departure_date', '$arrival_date','$return_date')";
        $conn->query($insert_query);
    } elseif (!empty($departureDate['departure_date']) && strtotime($departureDate['departure_date']) <= $end_date) {
        $departure_date = $courierReturnDate['return_date'];
        $arrival_date = date('Y-m-d', strtotime("$departure_date + $duration days"));
        $return_date = date('Y-m-d', strtotime("$departure_date + $returnDuration days"));
        $insert_query = "INSERT INTO trips (region_id, courier_id, departure_date, arrival_date, return_date) VALUES ('$region_id', '$courier_id', '$departure_date', '$arrival_date','$return_date')";
        $conn->query($insert_query);
    }
    $date = date('Y-m-d', $end_date);
    $conn->query("DELETE FROM trips WHERE departure_date > '$date'");
}
echo "Записи в БД успешно добавленны";
$conn->close();