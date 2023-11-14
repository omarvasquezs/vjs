(function ($) {
    "use strict";

    // DEMO CHART
    $(document).ready(function () {
        const chartElement = document.getElementById('myChart');
        if (!chartElement) {
            console.log('Oops! The chart element with id "myChart" was not found on the page. Please make sure this element exists before generating the chart.');
        } else {
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    datasets: [{
                        label: 'N° de Boletas PAGADAS',
                        data: [12, 19, 3, 5, 2, 3, 13, 15, 5, 10, 11, 12],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });

    // Dynamic content on registering a comprobante
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

        // Fetch and populate clientes using Select2
        var servicioDropdown = $('#clienteDropdown');

        servicioDropdown.select2({
            placeholder: "-- SELECCIONAR CLIENTE --",
            allowClear: true,
            theme: "bootstrap",
            minimumInputLength: 2, // Minimum characters to start searching
            language: {
                inputTooShort: function (args) {
                    return "Coloque 2 o más letras.";
                },
                noResults: function () {
                    return "No hay resultados.";
                },
                searching: function () {
                    return "Buscando...";
                }
            },
            ajax: {
                url: 'fetchClientes', // Update with your actual URL for fetching servicio data
                dataType: 'json',
                type: "GET",
                quietMillis: 20,
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.nombres,
                            };
                        }),
                    };
                },
                cache: true,
            }
        });        

        // Fetch and populate servicios using Select2
        var servicioDropdown = $('#servicioDropdown');

        servicioDropdown.select2({
            placeholder: "-- SELECCIONAR SERVICIO --",
            allowClear: true,
            theme: "bootstrap",
            minimumInputLength: 2, // Minimum characters to start searching
            language: {
                inputTooShort: function (args) {
                    return "Coloque 2 o más letras.";
                },
                noResults: function () {
                    return "No hay resultados.";
                },
                searching: function () {
                    return "Buscando...";
                }
            },
            ajax: {
                url: 'fetchServicios', // Update with your actual URL for fetching servicio data
                dataType: 'json',
                type: "GET",
                quietMillis: 20,
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term || '',
                        page: params.page || 1
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.id,
                                text: item.nom_servicio,
                            };
                        }),
                    };
                },
                cache: true,
            }
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

                        // Disable selected option                        
                        $('#servicioDropdown option:selected').select2().prop("disabled", true);

                        // Clear the selected value in the dropdown
                        servicioDropdown.val(null).trigger('change'); // Clear the selected value in the Select2 dropdown
                    }
                });
            }
        });
    });

})(jQuery);