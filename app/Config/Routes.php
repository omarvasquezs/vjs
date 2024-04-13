<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('clientes', 'Home::clientes');
$routes->get('clientes/(:any)', 'Home::clientes/$1');
$routes->post('clientes', 'Home::clientes');
$routes->post('clientes/(:any)', 'Home::clientes');
$routes->get('estado_comprobantes','Home::estado_comprobantes');
$routes->get('estado_comprobantes/(:any)','Home::estado_comprobantes/$1');
$routes->post('estado_comprobantes','Home::estado_comprobantes');
$routes->post('estado_comprobantes/(:any)','Home::estado_comprobantes');
$routes->get('estado_ropa','Home::estado_ropa');
$routes->get('estado_ropa/(:any)','Home::estado_ropa/$1');
$routes->post('estado_ropa','Home::estado_ropa');
$routes->post('estado_ropa/(:any)','Home::estado_ropa');
$routes->get('metodo_pago','Home::metodo_pago');
$routes->get('metodo_pago/(:any)','Home::metodo_pago/$1');
$routes->post('metodo_pago','Home::metodo_pago');
$routes->post('metodo_pago/(:any)','Home::metodo_pago');
$routes->get('roles','Home::roles');
$routes->get('roles/(:any)','Home::roles/$1');
$routes->post('roles','Home::roles');
$routes->post('roles/(:any)','Home::roles');
$routes->get('servicios','Home::servicios');
$routes->get('servicios/(:any)','Home::servicios/$1');
$routes->post('servicios','Home::servicios');
$routes->post('servicios/(:any)','Home::servicios');

$routes->get('users','Home::users');
$routes->get('users/(:any)','Home::users/$1');
$routes->post('users','Home::users');
$routes->post('users/(:any)','Home::users');

$routes->get('change_password/(:any)','Home::change_password/$1');
$routes->post('change_password/(:any)','Home::change_password');

$routes->get('locales','Home::locales');
$routes->get('locales/(:any)','Home::locales/$1');
$routes->post('locales','Home::locales');
$routes->post('locales/(:any)','Home::locales');

$routes->get('comprobantes','Home::comprobantes');
$routes->get('comprobantes/(:any)','Home::comprobantes/$1');
$routes->post('comprobantes','Home::comprobantes');
$routes->post('comprobantes/(:any)','Home::comprobantes');

$routes->get('comprobantes_recibidos','Home::comprobantes');
$routes->get('comprobantes_recibidos/(:any)','Home::comprobantes/$1');
$routes->post('comprobantes_recibidos','Home::comprobantes');
$routes->post('comprobantes_recibidos/(:any)','Home::comprobantes');

$routes->get('comprobantes_cancelados','Home::comprobantes');
$routes->get('comprobantes_cancelados/(:any)','Home::comprobantes/$1');
$routes->post('comprobantes_cancelados','Home::comprobantes');
$routes->post('comprobantes_cancelados/(:any)','Home::comprobantes');

$routes->get('comprobantes_abonados','Home::comprobantes');
$routes->get('comprobantes_abonados/(:any)','Home::comprobantes/$1');
$routes->post('comprobantes_abonados','Home::comprobantes');
$routes->post('comprobantes_abonados/(:any)','Home::comprobantes');

$routes->get('comprobantes_pendiente_pago','Home::comprobantes');
$routes->get('comprobantes_pendiente_pago/(:any)','Home::comprobantes/$1');
$routes->post('comprobantes_pendiente_pago','Home::comprobantes');
$routes->post('comprobantes_pendiente_pago/(:any)','Home::comprobantes');

$routes->get('comprobantes_todos','Home::comprobantes');
$routes->get('comprobantes_todos/(:any)','Home::comprobantes/$1');
$routes->post('comprobantes_todos','Home::comprobantes');
$routes->post('comprobantes_todos/(:any)','Home::comprobantes');

$routes->get('registrar_comprobante','Home::registrar_comprobante');
$routes->get('fetchServicios','Home::fetchServicios');
$routes->get('fetchServicioDetails','Home::fetchServicioDetails');
$routes->get('fetchServicioDetails/(:any)','Home::fetchServicioDetails/$1');
$routes->post('fetchServicioDetails','Home::fetchServicioDetails');
$routes->post('fetchServicioDetails/(:any)','Home::fetchServicioDetails');
$routes->get('fetchMetodoPago','Home::fetchMetodoPago');
$routes->get('fetchClientes','Home::fetchClientes');
$routes->get('fetchEstadocomprobantes','Home::fetchEstadocomprobantes');

$routes->post('submit_comprobante','Home::submit_comprobantes_form');
$routes->post('submit_adicionales','Home::submit_adicionales_form');

$routes->get('ver_detalles/(:any)','Home::view_details/$1');

$routes->get('logout','Auth::logout');
$routes->get('login', 'Auth::login');
$routes->post('authenticate', 'Auth::authenticate');

$routes->get('comprobante/(:num)/a4', 'Home::generatePdfA4/$1');
$routes->get('comprobante/(:num)/a4/(:any)', 'Home::generatePdfA4/$1');
$routes->get('comprobante/(:num)/58mm', 'Home::generatePdf58mm/$1');
$routes->get('comprobante/(:num)/58mm/(:any)', 'Home::generatePdf58mm/$1');

$routes->get('whatsapp','Home::whatsapp');

$routes->post('exportcsv','Home::exportCSV');
$routes->post('exportexcel','Home::exportExcel');
$routes->post('fetch_reporte_ingresos_web','Home::fetch_reporte_ingresos_web');

$routes->post('exportcsvtrabajo','Home::exportCSVtrabajo');
$routes->post('exportexceltrabajo','Home::exportExceltrabajo');
$routes->get('exportexceltrabajoall','Home::exportExceltrabajoAll');
$routes->post('exportexceltrabajoall','Home::exportExceltrabajoAll');
$routes->post('fetch_reporte_trabajo_web','Home::fetch_reporte_trabajo_web');

$routes->get('registrar_cliente/(:any)', 'Home::clientes/$1');
$routes->post('registrar_cliente', 'Home::clientes');
$routes->post('registrar_cliente/(:any)', 'Home::clientes');

$routes->get('reenviarpdf/(:any)','Home::reenviarPDF/$1');

$routes->get('reporte_trabajo','Home::reporte_trabajo');
$routes->get('reporte_ingresos','Home::reporte_ingresos');

$routes->get('adicionales','Home::adicionales');
$routes->get('adicionales/(:any)','Home::adicionales/$1');
$routes->post('adicionales','Home::adicionales');
$routes->post('adicionales/(:any)','Home::adicionales');