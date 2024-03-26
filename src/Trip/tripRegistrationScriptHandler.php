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
$startDate = isset($_POST['date']) ? $conn->real_escape_string($_POST['date']) : '';
$regionId = $conn->real_escape_string($_POST['region']); // Защита от SQL инъекций
$courierId = $conn->real_escape_string($_POST['courier']);

$sql = $conn->query("SELECT duration_to_destination FROM regions WHERE id = '$regionId'");
$duration = $sql->fetch_assoc();
$daysTrip = $duration['duration_to_destination'] * 2;
$endDate = date('Y-m-d', strtotime($startDate . ' +' . $daysTrip . ' days'));
$getDate = $conn->query("SELECT departure_date, return_date FROM trips WHERE courier_id = '$courierId'");
$allDate = $getDate->fetch_all();

$availableDates = array();

foreach ($allDate as $key => $date) {
    if (isset($allDate[$key + 1])) {
        $date1 = strtotime($date[1]);
        $date2 = strtotime($allDate[$key + 1][0]);
        $diff_days = ($date2 - $date1) / (60 * 60 * 24);
        if ($diff_days >= $daysTrip) {
            $availableDates[] = $date[1];
        }
    }
}

$getArrivalDate = $conn->query("SELECT return_date FROM trips WHERE courier_id = '$courierId' ORDER BY return_date DESC LIMIT 1");
$availableDateLast = $getArrivalDate->fetch_assoc();
if (!empty($availableDates)) {
    $availableDates[] = $availableDateLast['return_date'];
    $_SESSION['availableDates'] = $availableDates;
    $maxDate = end($_SESSION['availableDates']);
    while (count($_SESSION['availableDates']) < 11) {
        $newDate = date('Y-m-d', strtotime($maxDate . ' +' . count($_SESSION['availableDates']) . ' days'));
        $_SESSION['availableDates'][] = $newDate;
    }
    echo json_encode(array('availableDates' => $_SESSION['availableDates'], 'dateArrivalReg' => $duration['duration_to_destination']));

}else if(empty($availableDateLast)){
    $_SESSION['availableDates'] = array(date('Y-m-d'));
    $maxDate = date('Y-m-d');

    for ($i = 1; $i <= 10; $i++) {
        $newDate = date('Y-m-d', strtotime($maxDate . ' +' . $i . ' days'));
        $_SESSION['availableDates'][] = $newDate;
    }
    echo json_encode(array('availableDates' => $_SESSION['availableDates'], 'dateArrivalReg' => $duration['duration_to_destination']));
} else {
    $_SESSION['availableDates'] = array($availableDateLast['return_date']);
    $maxDate = $availableDateLast['return_date'];
    for ($i = 1; $i <= 10; $i++) {
        $newDate = date('Y-m-d', strtotime($maxDate . ' +' . $i . ' days'));
        $_SESSION['availableDates'][] = $newDate;
    }

    echo json_encode(array('availableDates' => $_SESSION['availableDates'], 'dateArrivalReg' => $duration['duration_to_destination']));
}
$conn->close();
