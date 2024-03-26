<?php
require "../Connect/Database.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$db = new Database();
$conn = $db->getConnection();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $regionId = $_POST['region'];
    $courierId = $_POST['courier'];
    $selectedDate = $_POST['date'];

    $getDays = $conn->query("SELECT duration_to_destination FROM regions WHERE id = '$regionId'");
    $days = $getDays->fetch_assoc();
    $daysTrip = $days['duration_to_destination']*2;
    $endDate = date('Y-m-d', strtotime($selectedDate . ' +' . $daysTrip . ' days'));
    $arrivalDate = date('Y-m-d', strtotime($selectedDate . ' +' . $days['duration_to_destination'] . ' days'));
    $stmt = $conn->prepare("INSERT INTO trips (region_id, courier_id,departure_date,arrival_date,return_date) VALUES (?,?,?,?,?)");
    $stmt->bind_param("iisss", $regionId, $courierId, $selectedDate, $arrivalDate,$endDate);

    if ($stmt->execute()) {
        header("Location: ../index.php");
        $_SESSION['flash'] = 'Доставка успешно зарегистрированна на:' . $selectedDate.'<br>' .'Дата поступления в место выдачи:' . $arrivalDate;
        exit;
    } else {
        echo "Ошибка при добавлении поездки: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
