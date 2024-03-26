<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require "../Connect/Database.php";

$db = new Database();
$conn = $db->getConnection();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];
$sortDirection = isset($_POST['sort_direction']) ? $_POST['sort_direction'] : 'asc';

$sql = "SELECT trips.id, 
               regions.name AS region_name, 
               couriers.name AS courier_name, 
               trips.departure_date, 
               trips.arrival_date
        FROM trips
        JOIN regions ON trips.region_id = regions.id
        JOIN couriers ON trips.courier_id = couriers.id
        WHERE trips.departure_date BETWEEN ? AND ?
        ORDER BY trips.departure_date $sortDirection;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();

$result = $stmt->get_result();
$trips = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($trips);

