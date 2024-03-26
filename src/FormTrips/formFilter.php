<!DOCTYPE html>
<html>
<head>
    <title>Форма вывода поездок курьеров</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<header class="site-header">
    <a href="../index.php">Добавить поездку</a>
</header>
<body>
<h3>Выберете диапозон дат :</h3>
<form id="tripForm">
    <label for="start_date">Начальная дата:</label>
    <input type="date" id="start_date" name="start_date">
    <label for="end_date">Конечная дата:</label>
    <input type="date" id="end_date" name="end_date">

    <label for="sort_direction">Сортировка даты:</label>
    <select id="sort_direction" name="sort_direction">
        <option value="asc">По возрастанию</option>
        <option value="desc">По убыванию</option>
    </select>
</form>
<div id="tripResults">
    <table>
        <thead>
        <tr>
            <th>Регион</th>
            <th>Курьер</th>
            <th>Дата отправки</th>
            <th>Дата прибытия</th>
        </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
<div id="tripResults"></div>
</body>
</html>


