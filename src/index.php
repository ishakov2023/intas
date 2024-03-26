<?php
session_start();
require "Trip/optionsTrip.php"
?>
<!DOCTYPE html>
<html>
<div class="site-header">
    <a href="FormTrips/formFilter.php">Расписание доставок</a>
</div>
<head>
    <title>Добавить поездку</title>
    <?php
    if (isset($_SESSION['flash'])) {
        echo '<div class="message">';
        echo $_SESSION['flash'];
        echo '</div>';
        unset($_SESSION['flash']);
    }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>

<h1>Добавить поездку</h1>
<form action="Trip/tripRegistrationHandler.php" method="POST">
    <label for="region">Регион:</label>
    <select name="region" required>
        <?php
        if (isset($_SESSION['regions']) && !empty($_SESSION['regions'])) {
            foreach ($_SESSION['regions'] as $region) {
                echo "<option value='" . $region['id'] . "'>" . $region['name'] . "</option>";
            }
        }
        ?>
    </select><br>

    <label for="courier">ФИО курьера:</label>
    <select name="courier" required>
        <?php
        if (isset($_SESSION['couriers']) && !empty($_SESSION['couriers'])) {
            // Заполнение списка регионов
            foreach ($_SESSION['couriers'] as $courier) {
                echo "<option value='" . $courier['id'] . "'>" . $courier['name'] . "</option>";
            }
        }
        ?>
    </select><br>

    <label for="date">Ближайшие даты на отправку:</label>
    <select name="date" id="dates" required>
        <option value="">Выберите дату</option>
    </select><br>

    <label for="arrival_date">Дата прибытия в регион:</label>
    <span id="arrival_date"></span><br>

    <input type="submit" id="submit_btn" value="Добавить поездку">
</form>
</body>
</html>