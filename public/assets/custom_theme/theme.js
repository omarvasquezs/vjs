/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/js/theme.js":
/*!*************************!*\
  !*** ./src/js/theme.js ***!
  \*************************/
/***/ (() => {

(function ($) {
  "use strict";

  // Dynamic content on registering a comprobante
  $(document).ready(function () {
    // Calculate the total of the fourth column values
    function calculateTotal() {
      var total = 0;
      $(".table tbody").find('tr input[type="number"]').each(function () {
        var row = $(this).closest('tr');
        var input = $(this).val();
        var thirdColumn = parseFloat(row.find('td:eq(2)').text());

        // Check if input is empty or not
        var inputValue = input.trim() === '' ? 0 : parseFloat(input);

        // Calculate the sum
        var sum = inputValue * thirdColumn || 0; // If either input or thirdColumn is NaN, set sum as 0

        // Display the sum in the fourth column
        row.find('td:eq(3)').text(sum.toFixed(2));
        total += sum;
      });
      return total;
    }

    // Update the total register span element with the calculated total
    function updateTotalRegister() {
      var total = calculateTotal();
      var igv = total * 0.18;
      var subtotal = total - igv;
      $("#total_register").text('S/. ' + total.toFixed(2));
      $("#total_register_input").val(total.toFixed(2));
      $("#igv_register").text('S/. ' + igv.toFixed(2));
      $("#sub_total_register").text('S/. ' + subtotal.toFixed(2));
    }

    // Bind the calculateTotal() function to the keyup and blur events of all number input elements
    $(".table tbody").on('keyup blur', 'tr input[type="number"]', function () {
      updateTotalRegister();
    });

    // Call the updateTotalRegister() function on page load
    updateTotalRegister();

    // Fetch and populate metodo de pago using Select2
    var metodopagoDropdown = $('#metodopagoDropdown');
    metodopagoDropdown.select2({
      placeholder: "-- CONDICIÓN DE PAGO --",
      allowClear: true,
      theme: "bootstrap-5",
      minimumInputLength: 0,
      // Minimum characters to start searching
      minimumResultsForSearch: Infinity,
      language: {
        inputTooShort: function inputTooShort(args) {
          return "Coloque 2 o más letras.";
        },
        noResults: function noResults() {
          return "No hay resultados.";
        },
        searching: function searching() {
          return "Buscando...";
        }
      },
      ajax: {
        url: 'fetchMetodoPago',
        // Update with your actual URL for fetching servicio data
        dataType: 'json',
        type: "GET",
        quietMillis: 20,
        delay: 250,
        data: function data(params) {
          return {
            q: params.term || '',
            page: params.page || 1
          };
        },
        processResults: function processResults(data) {
          return {
            results: $.map(data, function (item) {
              return {
                id: item.id,
                text: item.nom_metodo_pago
              };
            })
          };
        },
        cache: true
      }
    });

    // Fetch and populate clientes using Select2
    var servicioDropdown = $('#clienteDropdown');
    servicioDropdown.select2({
      placeholder: "-- SELECCIONAR CLIENTE --",
      allowClear: true,
      theme: "bootstrap-5",
      minimumInputLength: 2,
      // Minimum characters to start searching
      language: {
        inputTooShort: function inputTooShort(args) {
          return "Coloque 2 o más letras.";
        },
        noResults: function noResults() {
          return "No hay resultados.";
        },
        searching: function searching() {
          return "Buscando...";
        }
      },
      ajax: {
        url: 'fetchClientes',
        // Update with your actual URL for fetching servicio data
        dataType: 'json',
        type: "GET",
        quietMillis: 20,
        delay: 250,
        data: function data(params) {
          return {
            q: params.term || '',
            page: params.page || 1
          };
        },
        processResults: function processResults(data) {
          return {
            results: $.map(data, function (item) {
              return {
                id: item.id,
                text: item.nombres
              };
            })
          };
        },
        cache: true
      }
    });

    // Fetch and populate servicios using Select2
    var servicioDropdown = $('#servicioDropdown');
    servicioDropdown.select2({
      placeholder: "-- SELECCIONAR SERVICIO --",
      allowClear: true,
      theme: "bootstrap-5",
      minimumInputLength: 2,
      // Minimum characters to start searching
      language: {
        inputTooShort: function inputTooShort(args) {
          return "Coloque 2 o más letras.";
        },
        noResults: function noResults() {
          return "No hay resultados.";
        },
        searching: function searching() {
          return "Buscando...";
        }
      },
      ajax: {
        url: 'fetchServicios',
        // Update with your actual URL for fetching servicio data
        dataType: 'json',
        type: "GET",
        quietMillis: 20,
        delay: 250,
        data: function data(params) {
          return {
            q: params.term || '',
            page: params.page || 1
          };
        },
        processResults: function processResults(data) {
          return {
            results: $.map(data, function (item) {
              return {
                id: item.id,
                text: item.nom_servicio
              };
            })
          };
        },
        cache: true
      }
    });

    // Fetch and populate estado comprobantes using select2
    var ecDropdown = $('#estadoComprobante');
    ecDropdown.select2({
      placeholder: "-- ESTADO COMPROBANTE --",
      allowClear: true,
      theme: "bootstrap-5",
      minimumInputLength: 0,
      // Minimum characters to start searching
      minimumResultsForSearch: Infinity,
      language: {
        inputTooShort: function inputTooShort(args) {
          return "Coloque 2 o más letras.";
        },
        noResults: function noResults() {
          return "No hay resultados.";
        },
        searching: function searching() {
          return "Buscando...";
        }
      },
      ajax: {
        url: 'fetchEstadocomprobantes',
        // Update with your actual URL for fetching estado comprobante data
        dataType: 'json',
        type: "GET",
        quietMillis: 20,
        delay: 250,
        data: function data(params) {
          return {
            q: params.term || '',
            page: params.page || 1
          };
        },
        processResults: function processResults(data) {
          return {
            results: $.map(data, function (item) {
              return {
                id: item.id,
                text: item.nom_estado
              };
            })
          };
        },
        cache: true
      }
    }).on('change', function () {
      var selectedValue = $(this).val();
      if (selectedValue == '2') {
        $('#monto_abonado').prop('disabled', false);
        $('#metodopagoDropdown').prop('disabled', false);
      } else if (selectedValue == '4') {
        $('#monto_abonado').prop('disabled', true).val(''); // Reset monto_abonado input
        $('#metodopagoDropdown').prop('disabled', false);
      } else {
        $('#monto_abonado').prop('disabled', true).val(''); // Reset monto_abonado input
        $('#metodopagoDropdown').prop('disabled', true).val('').trigger('change'); // Reset metodopagoDropdown select
      }
    });

    // Add a row when the "Add Row" button is clicked
    $('#addRowButton').click(function (e) {
      e.preventDefault();
      var servicioId = $('#servicioDropdown').val();
      if (servicioId) {
        // Fetch servicio details based on the selected servicio ID
        $.post('fetchServicioDetails', {
          servicio_id: servicioId
        }, function (data) {
          var servicio = data;
          if (servicio) {
            var newRow = $('<tr style="vertical-align: middle;">');
            newRow.append('<td>' + servicio.nom_servicio + '<input name="val_id_servicio[]" type="hidden" value="' + servicio.id + '"></td>');
            newRow.append('<td><input type="number" step="0.01" class="form-control" name="val_kg_ropa_register[]" id="kg_ropa_register" style="width: 5rem;" required></td>'); // Empty cell, no quantity needed
            newRow.append('<td class="text-center">' + servicio.precio_kilo + '<input name="val_precio_kilo[]" type="hidden" value="' + servicio.precio_kilo + '"></td>');
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
  // Comprobante registrar button
  $(document).ready(function () {
    $('#btn_registrar_comprobante').click(function (event) {
      var tableContent = $('table tbody').html().trim();
      if (tableContent === '') {
        alert('Favor ingrese servicios en el comprobante!');
        event.preventDefault();
      } else {
        var emptyRequiredInputs = $('input:enabled[required], select:enabled[required]').filter(function () {
          return this.value === '';
        });
        var kgRopaRegister = $('#kg_ropa_register').val();
        if (emptyRequiredInputs.length > 0) {
          alert('Favor de completar todos los campos.');
          event.preventDefault();
        } else if (kgRopaRegister <= 0) {
          alert('Uno de los campos PESO EN KG tine valor igual o menor que 0.');
          event.preventDefault();
        } else {
          return confirm('Esta accion es irreversible, confirma que esta 100% seguro?');
        }
      }
    });
  });
  // radio options for RUC fields behavior
  $(document).ready(function () {
    $('#btnradio3').change(function () {
      $('#num_ruc, #razon_social').prop('disabled', !this.checked);
      $('#num_ruc, #razon_social').prop('required', this.checked);
    });
    $('#btnradio1, #btnradio2').change(function () {
      $('#num_ruc, #razon_social').prop('disabled', true);
      $('#num_ruc, #razon_social').prop('required', false);
    });
  });

  // New action button for printing
  $(document).ready(function () {
    // Adding print icon on grocery crud flexigrid
    // Find all elements with class 'print-icon-custom'
    $('.print-icon-custom').each(function () {
      // Create a new <span> element with class 'print-icon'
      var printIconSpan = $('<span class="print-icon"></span>');

      // Replace the text inside the <a> tag with the created <span> element
      $(this).html(printIconSpan);
    });

    // Find all elements with class 'whatsapp-icon-custom'
    $('.whatsapp-icon-custom').each(function () {
      // Create a new <span> element with class 'whatsapp-icon'
      var whatsappIconSpan = $('<span class="whatsapp-icon"></span>');

      // Replace the text inside the <a> tag with the created <span> element
      $(this).html(whatsappIconSpan);
    });

    // jQuery code to handle the action button click
    $('.print-icon-custom').on('click', function (e) {
      e.preventDefault();

      // Get the URL from the action button's data-url attribute
      var url = $(this).attr('href');

      // Set the iframe src attribute to the URL with "/58mm" appended
      $('#printIframe').attr('src', url + '/58mm');

      // Set the iframe src attribute to the URL with "/a4" appended
      $('#printIframe2').attr('src', url + '/a4');

      // Open the Bootstrap modal
      $('#printModal').modal('show');
      return false;
    });
  });
  $(document).ajaxComplete(function () {
    // Adding print icon on grocery crud flexigrid
    // Find all elements with class 'print-icon-custom'
    $('.print-icon-custom').each(function () {
      // Create a new <span> element with class 'print-icon'
      var printIconSpan = $('<span class="print-icon"></span>');

      // Replace the text inside the <a> tag with the created <span> element
      $(this).html(printIconSpan);
    });

    // Find all elements with class 'whatsapp-icon-custom'
    $('.whatsapp-icon-custom').each(function () {
      // Create a new <span> element with class 'whatsapp-icon'
      var whatsappIconSpan = $('<span class="whatsapp-icon"></span>');

      // Replace the text inside the <a> tag with the created <span> element
      $(this).html(whatsappIconSpan);
    });

    // jQuery code to handle the action button click
    $('.print-icon-custom').on('click', function (e) {
      e.preventDefault();

      // Get the URL from the action button's data-url attribute
      var url = $(this).attr('href');

      // Set the iframe src attribute to the URL with "/58mm" appended
      $('#printIframe').attr('src', url + '/58mm');

      // Set the iframe src attribute to the URL with "/a4" appended
      $('#printIframe2').attr('src', url + '/a4');

      // Open the Bootstrap modal
      $('#printModal').modal('show');
      return false;
    });
  });
  // Adding new cliente through registrar comprobante form
  $(document).ready(function () {
    // jQuery code to handle the action button click
    $('#addNewCliente').on('click', function (e) {
      e.preventDefault();
      // Open the Bootstrap modal
      $('#clienteModal').modal('show');
      return false;
    });
  });
  $(document).ready(function () {
    $('#reporte_ingresos').submit(function (e) {
      var start_date = $('#start_date').val();
      var end_date = $('#end_date').val();
      if (!start_date || !end_date) {
        alert('Asegurese que los campos no esten vacios.');
        e.preventDefault(); // prevent form from submitting
      } else if (new Date(start_date) > new Date(end_date)) {
        alert('Fecha Fin no puede ser mas antiguo que Fecha Inicio.');
        e.preventDefault(); // prevent form from submitting
      }
    });

    $('.export-option').click(function (e) {
      e.preventDefault();
      var action = $(this).data('action');
      var start_date = $('#start_date').val();
      var end_date = $('#end_date').val();
      if (!start_date || !end_date) {
        alert('Asegurese que los campos no esten vacios.');
        return;
      }
      if (action === '/fetch_reporte_ingresos_web') {
        $.ajax({
          type: "POST",
          url: "fetch_reporte_ingresos_web",
          data: {
            start_date: start_date,
            end_date: end_date
          },
          dataType: "json",
          success: function success(response) {
            var table = '<table class="table table-striped table-bordered"><thead><tr>' + '<th>COMPROBANTE</th>' + '<th>CLIENTE</th>' + '<th>FECHA DE ABONO</th>' + '<th>METODO DE PAGO</th>' + '<th>MONTO ABONADO</th>' + '</tr></thead><tbody>';
            var totalSum = 0; // Variable to store the sum of 'monto_abonado'

            $.each(response, function (index, item) {
              var metodoPago = item.nom_metodo_pago !== null ? item.nom_metodo_pago : 'NINGUNO';
              table += '<tr>' + '<td>' + item.cod_comprobante + '</td>' + '<td>' + item.nombres + '</td>' + '<td>' + item.fecha + '</td>' + '<td>' + metodoPago + '</td>' + '<td>' + item.monto_abonado + '</td>' + '</tr>';

              // Add 'monto_abonado' value to the totalSum
              totalSum += parseFloat(item.monto_abonado);
            });
            table += '</tbody><tfoot>' + '<tr>' + '<td colspan="4"><strong>Total:</strong></td>' + '<td><strong>' + totalSum.toFixed(2) + '</strong></td>' +
            // Display the total sum
            '</tr>' + '</tfoot></table>';
            $('#data-table').html(table);
          },
          error: function error(xhr, status, _error) {
            console.error(xhr.responseText);
            alert('Error occurred while fetching data.');
          }
        });
      } else {
        $('#reporte_ingresos').attr('action', action);
        $('#reporte_ingresos').submit();
      }
    });
  });
  $(document).ready(function () {
    $('#reporte_trabajo').submit(function (e) {
      var start_date = $('#start_date').val();
      var end_date = $('#end_date').val();
      if (!start_date || !end_date) {
        alert('Asegurese que los campos no esten vacios.');
        e.preventDefault(); // prevent form from submitting
      } else if (new Date(start_date) > new Date(end_date)) {
        alert('Fecha Fin no puede ser mas antiguo que Fecha Inicio.');
        e.preventDefault(); // prevent form from submitting
      }
    });

    $('.export-option').click(function (e) {
      e.preventDefault();
      var action = $(this).data('action');
      var start_date = $('#start_date').val();
      var end_date = $('#end_date').val();
      if (!start_date || !end_date) {
        alert('Asegurese que los campos no esten vacios.');
        return;
      }
      if (action === '/fetch_reporte_trabajo_web') {
        $.ajax({
          type: "POST",
          url: "fetch_reporte_trabajo_web",
          data: {
            start_date: start_date,
            end_date: end_date
          },
          dataType: "json",
          success: function success(response) {
            var table = '<table class="table table-striped table-bordered"><thead><tr>' + '<th>COMPROBANTE</th>' + '<th>CLIENTE</th>' + '<th>FECHA</th>' + '<th>COSTO TOTAL</th>' + '</tr></thead><tbody>';
            var totalSum = 0; // Variable to store the sum of 'costo_total'

            $.each(response, function (index, item) {
              table += '<tr>' + '<td>' + item.cod_comprobante + '</td>' + '<td>' + item.nombres + '</td>' + '<td>' + item.fecha + '</td>' + '<td>' + item.costo_total + '</td>' + '</tr>';
              // Add 'costo_total' value to the totalSum
              totalSum += parseFloat(item.costo_total);
            });
            table += '</tbody><tfoot>' + '<tr>' + '<td colspan="3"><strong>Total:</strong></td>' + '<td><strong>' + totalSum.toFixed(2) + '</strong></td>' +
            // Display the total sum
            '</tr>' + '</tfoot></table>';
            $('#data-table').html(table);
          },
          error: function error(xhr, status, _error2) {
            console.error(xhr.responseText);
            alert('Error occurred while fetching data.');
          }
        });
      } else {
        $('#reporte_trabajo').attr('action', action);
        $('#reporte_trabajo').submit();
      }
    });
  });
  $(document).ready(function () {
    var startDateInput = $('#start_date');
    var endDateInput = $('#end_date');
    var setCurrentDateCheckbox = $('#set_current_date');
    var setThisMonthCheckbox = $('#set_this_month');
    setCurrentDateCheckbox.on('change', function () {
      if ($(this).is(':checked')) {
        var today = new Date().toISOString().split('T')[0];
        startDateInput.val(today);
        endDateInput.val(today);
        setThisMonthCheckbox.prop('checked', false);
      } else {
        startDateInput.val('');
        endDateInput.val('');
      }
    });
    setThisMonthCheckbox.on('change', function () {
      if ($(this).is(':checked')) {
        var today = new Date();
        var firstDay = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
        var lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0).toISOString().split('T')[0];
        startDateInput.val(firstDay);
        endDateInput.val(lastDay);
        setCurrentDateCheckbox.prop('checked', false);
      } else {
        startDateInput.val('');
        endDateInput.val('');
      }
    });
    startDateInput.on('change', function () {
      setThisMonthCheckbox.prop('checked', false);
      setCurrentDateCheckbox.prop('checked', false);
    });
    endDateInput.on('change', function () {
      setThisMonthCheckbox.prop('checked', false);
      setCurrentDateCheckbox.prop('checked', false);
    });
  });
  $(document).ready(function () {
    // Function to erase cookies with names starting with 'hidden_sorting' or 'hidden_ordering'
    function eraseCookiesStartingWith(prefix) {
      var cookies = document.cookie.split(';');
      for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i].trim();

        // Check if the cookie name starts with the specified prefix
        if (cookie.indexOf(prefix) === 0) {
          // Get the cookie name
          var cookieName = cookie.split('=')[0];

          // Set the cookie value to an empty string
          document.cookie = cookieName + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
        }
      }
    }

    // Call the function to erase cookies starting with 'hidden_sorting' or 'hidden_ordering'
    eraseCookiesStartingWith('hidden_sorting');
    eraseCookiesStartingWith('hidden_ordering');
  });
})(jQuery);

/***/ }),

/***/ "./src/scss/style.scss":
/*!*****************************!*\
  !*** ./src/scss/style.scss ***!
  \*****************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	(() => {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = (result, chunkIds, fn, priority) => {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var [chunkIds, fn, priority] = deferred[i];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every((key) => (__webpack_require__.O[key](chunkIds[j])))) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	(() => {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/theme": 0,
/******/ 			"style": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = (chunkId) => (installedChunks[chunkId] === 0);
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = (parentChunkLoadingFunction, data) => {
/******/ 			var [chunkIds, moreModules, runtime] = data;
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some((id) => (installedChunks[id] !== 0))) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkvjs_custom"] = self["webpackChunkvjs_custom"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	})();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["style"], () => (__webpack_require__("./src/js/theme.js")))
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["style"], () => (__webpack_require__("./src/scss/style.scss")))
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;