(function ($) {
    "use strict";
    // Prevent users from modifying the input
    $(document).ready(function () {
        $('#id_user_register').keydown(function (e) {
            e.preventDefault();
        });
    });

    $(document).ready(function () {
        // Calculate the total of the fifth column values
        function calculateTotal() {
            var total = 0;
            $(".table tbody").find('tr input[type="number"]').each(function () {
                var row = $(this).closest('tr');
                var input = $(this).val();
                var thirdColumn = row.find('td:eq(2)').text();

                // Calculate the sum
                var sum = parseFloat(input) * parseFloat(thirdColumn);

                // Display the sum in the fourth column
                row.find('td:eq(3)').text(sum);

                total += sum;
            });

            return total;
        }
        // Update the total register span element with the calculated total
        function updateTotalRegister() {
            var total = calculateTotal();
            $("#total_register").text(total);
        }
        // Bind the calculateTotal() function to the keyup and blur events of all number input elements
        $(".table tbody").on('keyup blur', 'tr input[type="number"]', function () {
            updateTotalRegister();
        });
        // Call the updateTotalRegister() function on page load
        updateTotalRegister();
        // Fetch and populate metodo de pago in the dropdown
        var metodopagoDropdown = $('#metodopagoDropdown');
        var metodopagoData = []; // To store all metodo de pago data

        $.get('fetchMetodoPago', function (data) {
            metodopagoData = data;
            $.each(data, function (key, value) {
                metodopagoDropdown.append($('<option>', {
                    value: value.id,
                    text: value.nom_metodo_pago
                }));
            });
        });

        // Fetch and populate servicios in the dropdown
        var servicioDropdown = $('#servicioDropdown');
        var serviciosData = []; // To store all servicio data

        $.get('fetchServicios', function (data) {
            serviciosData = data;
            $.each(data, function (key, value) {
                servicioDropdown.append($('<option>', {
                    value: value.id,
                    text: value.nom_servicio
                }));
            });
        });

        // Add a row when the "Add Row" button is clicked
        $('#addRowButton').click(function (e) {
            e.preventDefault();

            var servicioId = $('#servicioDropdown').val();

            if (servicioId) {
                // Fetch servicio details based on the selected servicio ID
                $.post('fetchServicioDetails', { servicio_id: servicioId }, function (data) {
                    var servicio = data;

                    if (servicio) {
                        var newRow = $('<tr>');
                        newRow.append('<td>' + servicio.nom_servicio + '</td>');
                        newRow.append('<td><input type="number" step="0.01" class="form-control" id="kg_ropa_register" style="width: 5rem;" required></td>'); // Empty cell, no quantity needed
                        newRow.append('<td class="text-center">' + servicio.precio_kilo + '</td>');
                        newRow.append('<td class="text-center"></td>'); // Empty cell, no total cost needed
                        newRow.append('<td><button class="btn btn-danger btn-sm delete-row"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/></svg></button></td>');
                        newRow.append('</tr>');
                        $('#productTableBody tbody').append(newRow);

                        // Add a click event for the delete button
                        newRow.find('.delete-row').click(function () {
                            newRow.remove(); // Remove the row when the delete button is clicked
                            // Re-enable the corresponding option in the dropdown
                            servicioDropdown.find('option[value="' + servicio.id + '"]').prop('disabled', false);
                            // Update the total register after a row is deleted
                            updateTotalRegister();
                        });

                        // Disable the option in the dropdown to prevent it from being added again
                        servicioDropdown.find('option[value="' + servicio.id + '"]').prop('disabled', true);
                        // Clear the selected value in the dropdown
                        servicioDropdown.val('');
                    }
                });
            }
        });

        // Handle change in the "servicios" dropdown
        servicioDropdown.change(function () {
            var selectedServicioId = $(this).val();
            if (selectedServicioId) {
                // Check if the selected servicio is disabled
                if (servicioDropdown.find('option[value="' + selectedServicioId + '"]').is(':disabled')) {
                    // Enable the option and clear the selection
                    servicioDropdown.find('option[value="' + selectedServicioId + '"]').prop('disabled', false);
                    $(this).val('');
                }
            }
        });
    });

})(jQuery);