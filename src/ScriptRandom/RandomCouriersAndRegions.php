<?php

require_once "../Connect/Database.php";

$db = new Database();
$conn = $db->getConnection();

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$couriers = [
    'Дима',
    'Карина',
    'Виталя',
    'Миша',
    'Маша',
    'Егор',
    'Сергей',
    'Аркадий',
    'Ваня',
    'Катя'
];

foreach ($couriers as $name) {
    $insert_query = "INSERT INTO couriers (name) VALUES ('$name')";
    $conn->query($insert_query);
}

$regions = [
    'Санкт-Петербург' => rand(1, 10),
    'Уфа' => rand(1, 10),
    'Нижний Новгород' => rand(1, 10),
    'Владимир' => rand(1, 10),
    'Кострома' => rand(1, 10),
    'Екатеринбург' => rand(1, 10),
    'Ковров' => rand(1, 10),
    'Воронеж' => rand(1, 10),
    'Самара' => rand(1, 10),
    'Астрахань' => rand(1, 10)
];

foreach ($regions as $name => $duration) {
    $insert_query = "INSERT INTO regions (name, duration_to_destination,duration_return_trip) VALUES ('$name', '$duration','$duration')";
    $conn->query($insert_query);
}

echo "Записи в БД успешно добавленны";
$conn->close();

