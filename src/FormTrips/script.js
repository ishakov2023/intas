function loadTrips() {
    $.ajax({
        type: 'POST',
        url: 'tripData.php',
        data: $('#tripForm').serialize(),
        success: function (response) {
            var trips = JSON.parse(response);
            var tbody = $('#tripResults table tbody');
            tbody.empty();
            trips.forEach(function (trip) {
                var row = '<tr>';
                row += '<td>' + trip.region_name + '</td>';
                row += '<td>' + trip.courier_name + '</td>';
                row += '<td>' + trip.departure_date + '</td>';
                row += '<td>' + trip.arrival_date + '</td>';
                row += '</tr>';
                tbody.append(row);
            });
        }
    });
}

function sortTrips(direction) {
    var tripsTable = $('#tripResults table');
    var tripsRows = tripsTable.find('tr:gt(0)').toArray();

    tripsRows.sort(function (a, b) {
        var dateA = new Date($(a).find('td:eq(2)').text());
        var dateB = new Date($(b).find('td:eq(2)').text());

        if (direction === 'asc') {
            return dateA - dateB;
        } else {
            return dateB - dateA;
        }
    });

    tripsTable.find('tr:gt(0)').remove();
    tripsRows.forEach(function (row) {
        tripsTable.append(row);
    });
}

$(document).ready(function () {
    loadTrips();
    $('#start_date, #end_date').change(function () {
        loadTrips();
    });

    $('#sort_direction').change(function () {
        var direction = $(this).val();
        sortTrips(direction);
    });
});
