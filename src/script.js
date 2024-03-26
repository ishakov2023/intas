$(document).ready(function () {
    $('select[name="region"], select[name="courier"]').on('change', function () {
        var regionId = $('select[name="region"]').val();
        var courierId = $('select[name="courier"]').val();
        var selectedDate = $(this).val();

        $.ajax({
            url: 'Trip/tripRegistrationScriptHandler.php',
            type: 'POST',
            data: {region: regionId, courier: courierId, date: selectedDate},
            dataType: 'json',
            success: function (data) {
                $('#dates').empty();
                if (Array.isArray(data.availableDates)) {
                    $.each(data.availableDates, function (index, date) {
                        $('#dates').append('<option value="' + date + '">' + date + '</option>');
                    });

                    function calculateArrivalDate() {
                        var selectedOptionDate = $('#dates').val();
                        var arrivalDate = new Date(selectedOptionDate);
                        var daysToAdd = parseInt(data.dateArrivalReg);
                        arrivalDate.setDate(arrivalDate.getDate() + daysToAdd);
                        var formattedArrivalDate = arrivalDate.toISOString().slice(0, 10);

                        $('#arrival_date').text(formattedArrivalDate);
                    }

                    calculateArrivalDate();

                    $('#dates').on('change', function () {
                        calculateArrivalDate();
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });
});
