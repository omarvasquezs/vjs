<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;
// Reference the Dompdf namespace
use Dompdf\Dompdf;
// Reference the Options namespace
use Dompdf\Options;
// Reference the Font Metrics namespace
use Dompdf\FontMetrics;
// phpoffice for reports
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends BaseController
{
    private function _mainOutput($output = null)
    {
        return view('output', (array) $output);
    }
    private function _crudOutput($output = null)
    {
        return view('crud_output', (array) $output);
    }
    public function index()
    {
        $output = (object) [
            'css_files' => [],
            'js_files' => [],
            'output' => view('main')
        ];
        return $this->_mainOutput($output);
    }
    public function adicionales()
    {
        $output = (object) [
            'css_files' => [],
            'js_files' => [],
            'output' => view('adicionales')
        ];
        return $this->_crudOutput($output);
    }
    public function clientes()
    {
        $crud = new GroceryCrud();

        $crud->setTable('clientes');

        $crud->setTheme('flexigrid');
        $crud->setRead();
        if (session()->get('role_id') != 1) {
            $crud->unsetDelete();
        }
        $crud->unsetExport();
        $crud->unsetPrint();

        $crud->columns(['nombres', 'telefono', 'direccion']);

        $crud->setSubject('Cliente');

        $crud->displayAs([
            'nombres' => 'NOMBRE COMPLETO',
            'dni' => 'DNI',
            'telefono' => 'TELEFONO',
            'email' => 'E-MAIL',
            'direccion' => 'DIRECCION'
        ]);

        $uri = service('uri');
        $segment = $uri->getSegment(1); // get the first segment of the URL

        if ($segment == 'registrar_cliente') {
            $crud->unsetBackToDatagrid();
        }

        // Render the CRUD
        $output = $crud->render();

        $css_files = $output->css_files;
        $js_files = $output->js_files;
        $css_class = 'clientes';
        $output = $output->output;

        if ($segment == 'registrar_cliente') {
            return $this->_crudOutput(['output' => $output, 'css_class' => $css_class, 'css_files' => $css_files, 'js_files' => $js_files]);
        } else {
            return $this->_mainOutput(['output' => $output, 'css_class' => $css_class, 'css_files' => $css_files, 'js_files' => $js_files]);
        }
    }
    public function estado_comprobantes()
    {
        $crud = new GroceryCrud();

        $crud->setTable('estado_comprobantes');
        $crud->setSubject('ESTADO DE COMPROBANTE');
        $crud->fieldType('habilitado', 'true_false', array('0' => 'DESHABILITADO', '1' => 'HABILITADO'));
        $crud->displayAs([
            'nom_estado' => 'NOMBRE ESTADO DE COMPROBANTE',
            'habilitado' => 'ESTADO'
        ]);
        $crud->unsetExport();
        $crud->unsetPrint();
        $output = $crud->render();

        return $this->_mainOutput($output);
    }
    public function estado_ropa()
    {
        $crud = new GroceryCrud();

        $crud->setTable('estado_ropa');
        $crud->setSubject('ESTADO ROPA');
        $crud->displayAs([
            'nom_estado_ropa' => 'NOMBRE ESTADO ROPA'
        ]);
        $crud->unsetExport();
        $crud->unsetPrint();
        $output = $crud->render();

        return $this->_mainOutput($output);
    }
    public function metodo_pago()
    {
        $crud = new GroceryCrud();

        $crud->setTable('metodo_pago');
        $crud->setSubject('METODO DE PAGO');
        $crud->fieldType('habilitado', 'true_false', array('0' => 'DESHABILITADO', '1' => 'HABILITADO'));
        $crud->displayAs([
            'nom_metodo_pago' => 'METODO DE PAGO',
            'habilitado' => 'ESTADO'
        ]);
        $crud->unsetExport();
        $crud->unsetPrint();
        $output = $crud->render();

        return $this->_mainOutput($output);
    }
    public function roles()
    {
        $crud = new GroceryCrud();

        $crud->setTable('roles');
        $crud->fieldType('habilitado', 'true_false', array('0' => 'DESHABILITADO', '1' => 'HABILITADO'));
        $crud->setSubject('ROL');
        $crud->displayAs([
            'role_name' => 'ROL',
            'habilitado' => 'ESTADO'
        ]);
        $crud->unsetExport();
        $crud->unsetPrint();
        $output = $crud->render();

        return $this->_mainOutput($output);
    }
    public function servicios()
    {
        $crud = new GroceryCrud();

        $crud->setTable('servicios');
        $crud->setSubject('SERVICIO');
        $crud->fieldType('habilitado', 'true_false', array('0' => 'DESHABILITADO', '1' => 'HABILITADO'));
        $crud->columns(['nom_servicio', 'precio_kilo', 'habilitado']);
        $crud->displayAs([
            'nom_servicio' => 'SERVICIO',
            'habilitado' => 'ESTADO',
            'precio_kilo' => 'PRECIO POR KILO (S/.)'
        ]);
        $crud->unsetExport();
        $crud->unsetPrint();
        $output = $crud->render();

        return $this->_mainOutput($output);
    }
    public function users()
    {
        $crud = new GroceryCrud();

        $crud->setTable('users');
        $crud->columns(['username', 'role_id', 'habilitado']);
        $crud->setRelation('role_id', 'roles', 'role_name');
        $crud->setSubject('USUARIO DEL SISTEMA');
        $crud->fieldType('habilitado', 'true_false', array('0' => 'DESHABILITADO', '1' => 'HABILITADO'));
        $crud->unsetExport();
        $crud->unsetPrint();
        $crud->displayAs([
            'username' => 'USUARIO',
            'role_id' => 'ROL',
            'password' => 'CONTRASEÑA',
            'habilitado' => 'ESTADO'
        ]);
        // Add this callback to transform the username to uppercase in the view
        $crud->callbackColumn('username', function ($value, $row) {
            return strtoupper($value);
        });

        // Modify these callbacks to transform the username to uppercase in the add and edit forms
        $crud->callbackAddField('username', function () {
            return '<input class="form-control" type="text" maxlength="50" name="username" style="text-transform:uppercase">';
        });
        $crud->callbackEditField('username', function ($value, $primaryKey) {
            return '<input class="form-control" type="text" maxlength="50" name="username" value="' . strtoupper($value) . '">';
        });
        $crud->callbackAddField('password', function () {
            return '<input class="form-control" type="password" maxlength="50" name="password" style="width: 500px;max-width: 500px;height: 2.5rem;box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);">';
        });
        $crud->callbackEditField('password', function ($postArray, $primaryKey) {
            return $this->editar_campo_password($postArray, $primaryKey);
        });
        $crud->callbackBeforeInsert(function ($stateParameters) {
            return $this->encriptar_password($stateParameters);
        });
        $crud->callbackBeforeUpdate(function ($stateParameters) {
            return $this->actualizar_password($stateParameters);
        });
        $output = $crud->render();

        return $this->_mainOutput($output);
    }
    public function editar_campo_password($postArray, $primaryKey)
    {
        return '<input class="form-control" type="password" maxlength="50" name="password" style="width: 500px;max-width: 500px;height: 2.5rem;box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);">';
    }

    public function encriptar_password($stateParameters)
    {
        $stateParameters->data['password'] = md5(sha1($stateParameters->data['password']));
        return $stateParameters;
    }

    public function actualizar_password($stateParameters)
    {
        if (!empty($stateParameters->data['password'])) {
            $stateParameters->data['password'] = md5(sha1($stateParameters->data['password']));
        } else {
            unset($stateParameters->data['password']);
        }
        return $stateParameters;
    }
    public function locales()
    {
        $crud = new GroceryCrud();

        $crud->setTable('locales');
        $crud->setSubject('LOCAL');
        $crud->fieldType('habilitado', 'true_false', array('0' => 'DESHABILITADO', '1' => 'HABILITADO'));
        $crud->unsetExport();
        $crud->unsetPrint();
        $crud->displayAs([
            'nombre' => 'NOMBRES',
            'direccion' => 'DIRECCION',
            'telefono' => 'TELEFONO',
            'observaciones' => 'DETALLES DEL LOCAL',
            'habilitado' => 'ESTADO'
        ]);
        $output = $crud->render();

        return $this->_mainOutput($output);
    }
    public function comprobantes()
    {
        $crud = new GroceryCrud();

        $crud->setTable('comprobantes');
        $crud->setSubject('Comprobante');
        $crud->setRelation('cliente_id', 'clientes', 'nombres');
        $crud->setRelation('metodo_pago_id', 'metodo_pago', 'nom_metodo_pago', ['habilitado' => '1']);
        $crud->setRelation('estado_comprobante_id', 'estado_comprobantes', 'nom_estado', ['habilitado' => '1']);
        $crud->setRelation('local_id', 'locales', 'nombre');
        $crud->setRelation('user_id', 'users', 'username');
        $crud->setRelation('last_updated_by', 'users', 'username');
        $crud->setRelation('estado_ropa_id', 'estado_ropa', 'nom_estado_ropa');
        $crud->setRelationNtoN('SERVICIOS', 'comprobantes_detalles', 'servicios', 'comprobante_id', 'servicio_id', 'nom_servicio');
        $crud->readFields(['cod_comprobante', 'cliente_id', 'SERVICIOS', 'user_id', 'fecha', 'metodo_pago_id', 'num_ruc', 'razon_social', 'estado_comprobante_id', 'estado_ropa_id', 'local_id', 'monto_abonado', 'observaciones', 'last_updated_by']);
        $crud->columns(['cod_comprobante', 'cliente_id', 'estado_ropa_id', 'costo_total', 'deuda', 'fecha']);
        $crud->editFields(['cliente_id', 'cod_comprobante', 'estado_ropa_id', 'estado_comprobante_id', 'metodo_pago_id', 'monto_abonado', 'costo_total', 'observaciones']);

        $crud->defaultOrdering('comprobantes.fecha', 'desc');

        // Where close based on menu items
        $uri = service('uri');
        $segment = $uri->getSegment(1); // get the first segment of the URL

        switch ($segment) {
            case 'comprobantes_recibidos':
                // code to execute if the URL contains 'comprobantes_pagados'
                //$crud->where("comprobantes.estado_ropa_id != '4'");
                //$crud->where("comprobantes.estado_comprobante_id = '2'");

                $crud->where("comprobantes.estado_ropa_id IN (1, 3)");
                $crud->where("comprobantes.estado_comprobante_id IN (1, 2)");
                break;
            case 'comprobantes_cancelados':
                // code to execute if the URL contains 'comprobantes_pendiente_pago'
                //$crud->where("comprobantes.estado_ropa_id != '4'");
                //$crud->where("comprobantes.estado_comprobante_id = '1'");

                $crud->where("comprobantes.estado_ropa_id IN (1, 3)");
                $crud->where("comprobantes.estado_comprobante_id", 4);
                break;
            /*case 'comprobantes_todos':
                // code to execute if the URL contains 'comprobantes_pendiente_pago'
                echo '';
                break;*/
            default:
                // code to execute if the URL doesn't contain any of the above
                //$crud->where("comprobantes.estado_ropa_id != '4'");
                //$crud->where("comprobantes.estado_comprobante_id IN (1, 2, 4)");

                $crud->where("comprobantes.estado_ropa_id IN (1, 3)");
                $crud->where("comprobantes.estado_comprobante_id IN (1, 2, 4)");
                break;
        }

        $crud->unsetEditFields(['SERVICIOS']);
        $crud->unsetExport();
        $crud->unsetPrint();
        $crud->unsetAdd();
        $crud->unsetDelete();
        $crud->setRead();
        //$crud->requiredFields(['monto_abonado']);
        $crud->displayAs([
            'cod_comprobante' => 'COD COMPROBANTE',
            'cliente_id' => 'CLIENTE',
            'metodo_pago_id' => 'METODO DE PAGO',
            'estado_comprobante_id' => 'ESTADO COMPROBANTE',
            'estado_ropa_id' => 'ESTADO ROPA',
            'local_id' => 'LOCAL',
            'observaciones' => 'OBSERVACIONES',
            'user_id' => 'REGISTRADO POR',
            'fecha' => 'FECHA DE REGISTRO',
            'num_ruc' => 'N° DE RUC',
            'razon_social' => 'RAZÓN SOCIAL',
            'tipo_comprobante' => 'TIPO',
            'last_updated_by' => 'ACTUALIZADO POR',
            'costo_total' => 'COSTO TOTAL (S/.)',
            'deuda' => 'DEUDA (S/.)'
        ]);

        // Replace $id with the actual comprobante_id
        $maxValue = $this->calculateTotalCost(service('uri')->getSegment(service('uri')->getTotalSegments()));

        if ($crud->getState() == 'edit') {
            $montoAbonado = $this->getMontoAbonado(service('uri')->getSegment(service('uri')->getTotalSegments()));
            $remaining = number_format($maxValue - $montoAbonado, 2, '.', '');
            $crud->displayAs('monto_abonado', 'MONTO ABONADO (Máximo a abonar: ' . $remaining . ')');
            echo '<style>#cod_comprobante_field_box,#cliente_id_field_box {display: none;}</style>';
            if (number_format($maxValue, 2, '.', '') == number_format($montoAbonado, 2, '.', '')) {
                
                $crud->callbackEditField('monto_abonado', function ($value, $primary_key) use ($remaining) {
                    return '<input type="hidden" step="0.01" id="monto_abonado" name="monto_abonado" value="" style="width: 100%;">
                            <input type="number" step="0.01" id="monto_abonado2" name="monto_abonado2" value="'. $remaining .'" style="width: 100%;" disabled>';
                });
                echo '<style>#cod_comprobante_field_box, #estado_comprobante_id_field_box, #metodo_pago_id_field_box {display: none;}</style>';
            } else {
                $crud->callbackEditField('monto_abonado', function ($value, $primary_key) use ($remaining) {
                    return '<input type="number" step="0.01" id="monto_abonado" name="monto_abonado" value="" style="width: 100%;">
                            <input type="hidden" class="input-disabled" step="0.01" id="monto_abonado2" name="monto_abonado2" value="'. $remaining .'" style="width: 100%;" disabled>';
                });
            }
        } elseif ($crud->getState() == 'read') {
            $crud->displayAs('monto_abonado', 'MONTO ABONADO');
        } else {
            $crud->displayAs('monto_abonado', 'MONTO ABONADO');
        }

        $crud->setActionButton('Vista de Impresion', 'print-icon-custom', function ($row) {
            return site_url('comprobante/' . $row);
        }, true);

        $crud->setActionButton('Reenviar Comprobante', 'whatsapp-icon-custom', function ($row) {
            return site_url('reenviarpdf/' . $row);
        }, false);

        $crud->setActionButton('Añadir adicional', 'adicionales-icon-custom', function ($row) {
            return site_url('adicionales/' . $row);
        }, false);

        // Add this callback to modify the tipo_comprobante column in the list view
        $crud->callbackColumn('tipo_comprobante', array($this, 'displayTipoComprobante'));

        // Add this callback to modify the tipo_comprobante field in the read view
        $crud->callbackReadField('tipo_comprobante', array($this, 'displayTipoComprobante'));

        // Add this callback to modify the SERVICIOS field in the read view
        $crud->callbackReadField('SERVICIOS', array($this, 'displaySERVICIOS'));

        // Adding custom column
        //$crud->callbackColumn('comprobante', array($this, 'displayComprobante'));
        $crud->callbackColumn('deuda', array($this, 'displayDeuda'));

        //$crud->callbackReadField('id', array($this, 'displayIdWithTipoComprobante'));

        $db = \Config\Database::connect();

        // Add beforeUpdate event
        $crud->callbackBeforeUpdate(function ($stateParameters) use ($db) {

            //$this->updateEstadoComprobantesId($stateParameters->primaryKeyValue, $stateParameters->data['monto_abonado']);
            if ($stateParameters->data['monto_abonado'] === "0" || $stateParameters->data['monto_abonado'] === "0.00" || $stateParameters->data['monto_abonado'] === '') {
                unset($stateParameters->data['monto_abonado']);
            } else {
                $model_comprobantes = new \App\Models\Comprobantes();
                $monto_abonado_previo = $model_comprobantes->where('id', $stateParameters->primaryKeyValue)->first()['monto_abonado'];
                $monto_abonado_nuevo = $stateParameters->data['monto_abonado'];
                $monto_abonado_actualizado = $monto_abonado_previo + $monto_abonado_nuevo;
                $stateParameters->data['monto_abonado'] = $monto_abonado_actualizado;

                $model_reporte_ingresos = new \App\Models\ReporteIngresos();
                $data_ingresos = [
                    'cod_comprobante' => $stateParameters->data['cod_comprobante'],
                    'cliente_id' => $stateParameters->data['cliente_id'],
                    'metodo_pago_id' => $stateParameters->data['metodo_pago_id'],
                    'fecha' => date('Y-m-d H:i:s'),
                    'monto_abonado' => $monto_abonado_nuevo,  // use the new monto_abonado
                    'costo_total' => $stateParameters->data['costo_total']
                ];
                $model_reporte_ingresos->insert($data_ingresos);
            }

            $this->updateLastUpdatedBy($stateParameters->primaryKeyValue);

            $newEstadoRopaId = $stateParameters->data['estado_ropa_id'] ?? null;

            if ($newEstadoRopaId === '3') {

                // Get the cliente_id
                $cliente_id = $stateParameters->data['cliente_id'];

                // Query the clientes table to get the telefono
                $query = $db->table('clientes')->getWhere(['id' => $cliente_id]);
                $row_cliente = $query->getRow();

                // Check if telefono is not NULL, has 9 digits, and starts with 9
                if (!empty($row_cliente) && !is_null($row_cliente->telefono) && strlen($row_cliente->telefono) == 9 && $row_cliente->telefono[0] == '9') {

                    // The message to send
                    $message = "VJ's Laundry le informa que su ropa ya está lista para recoger, favor de apersonarse a nuestro local. Si no ha pagado aún o tiene un deuda pendiente con nosotros, favor de pagarlo lo antes posible, ya que sino se le retendrá la ropa. Su código de comprobante es " . $this->displayComprobanteWSP($stateParameters->primaryKeyValue);


                    $this->whatsapp_message($row_cliente->telefono, $message);
                }
            }

            return $stateParameters;
        });

        $output = $crud->render();
        $css_files = $output->css_files;
        $js_files = $output->js_files;
        $css_class = 'comprobantes';
        $output = $output->output;

        return $this->_mainOutput(['output' => $output, 'css_class' => $css_class, 'css_files' => $css_files, 'js_files' => $js_files]);
    }
    public function calculateTotalCost($comprobante_id)
    {
        $db = \Config\Database::connect();

        $query = $db->query("SELECT SUM(peso_kg * costo_kilo) as costo_total FROM comprobantes_detalles WHERE comprobante_id = ?", [$comprobante_id]);
        $result = $query->getRowArray();

        return $result['costo_total'];
    }
    public function getMontoAbonado($comprobante_id)
    {
        $db = \Config\Database::connect();

        $query = $db->query("SELECT monto_abonado as monto_abonado FROM comprobantes WHERE id = ?", [$comprobante_id]);
        $result = $query->getRowArray();

        return $result['monto_abonado'];
    }
    public function updateEstadoComprobantesId($comprobante_id, $monto_abonado)
    {
        $db = \Config\Database::connect();

        // Calculate the total cost
        $total_cost = $this->calculateTotalCost($comprobante_id);

        // Compare the total cost with monto_abonado and update estado_comprobante_id accordingly
        if ($monto_abonado >= $total_cost) {
            $db->query("UPDATE comprobantes SET estado_comprobante_id = ? WHERE id = ?", [4, $comprobante_id]);
        } elseif ($monto_abonado > 0 && $monto_abonado < $total_cost) {
            $db->query("UPDATE comprobantes SET estado_comprobante_id = ? WHERE id = ?", [2, $comprobante_id]);
        } elseif ($monto_abonado == 0 || $monto_abonado === null) {
            $db->query("UPDATE comprobantes SET estado_comprobante_id = ? WHERE id = ?", [1, $comprobante_id]);
        }
    }
    public function updateLastUpdatedBy($comprobante_id)
    {
        $db = \Config\Database::connect();

        // Get the user_id from the session
        $user_id = session()->get('user_id');

        // Update the last_updated_by field in the comprobantes table
        $db->query("UPDATE comprobantes SET last_updated_by = ? WHERE id = ?", [$user_id, $comprobante_id]);
    }
    private function whatsapp_message($phone_number, $message)
    {
        $url = 'https://api.textmebot.com/send.php?recipient=+51' . $phone_number . '&apikey=hCS2aZ9aHwhF&text=' . urlencode($message);

        return $this->send_request($url);
    }
    private function whatsapp_pdf($comprobante_id, $phone_number)
    {
        $url = 'https://api.textmebot.com/send.php?recipient=+51' . $phone_number . '&apikey=hCS2aZ9aHwhF&document=' . base_url() . 'comprobante/' . $comprobante_id . '/a4/comprobante_A4_' . date('YmdHis') . '.pdf';

        return $this->send_request($url);
    }
    private function send_request($url)
    {
        if ($ch = curl_init($url)) {
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $html = curl_exec($ch);
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return (int) $status;
        } else {
            return false;
        }
    }
    public function displayDeuda($value, $row)
    {
        return $row->costo_total - $row->monto_abonado;
    }
    public function displayComprobante($value, $row)
    {
        // Get the tipo_comprobante value
        $tipo_comprobante = $row->tipo_comprobante;

        // Modify the id based on the tipo_comprobante value
        switch ($tipo_comprobante) {
            case 'B':
                return 'B001-' . $row->id;
            case 'F':
                return 'F001-' . $row->id;
            case 'N':
                return 'NV001-' . $row->id;
            default:
                return $row->id;
        }
    }
    private function displayComprobanteWSP($comprobante_id)
    {
        // Get the database connection
        $db = \Config\Database::connect();
        // Query the database to get the cod_comprobante value for the current id
        $query = $db->query('SELECT cod_comprobante FROM comprobantes WHERE id = ?', [$comprobante_id]);
        $result = $query->getRow();
        return $result->cod_comprobante;
    }
    public function displayIdWithTipoComprobante($value, $row)
    {
        // Get the database connection
        $db = \Config\Database::connect();

        // Query the database to get the tipo_comprobante value for the current id
        $query = $db->query('SELECT tipo_comprobante FROM comprobantes WHERE id = ?', [$value]);
        $result = $query->getRow();

        // Check if the query returned a result
        if ($result) {
            $tipo_comprobante = $result->tipo_comprobante;
        } else {
            // Handle the case where no result was returned
            // For example, you might want to return the original id value
            return $value;
        }

        // Modify the id based on the tipo_comprobante value
        switch ($tipo_comprobante) {
            case 'B':
                return 'B001-' . $value;
            case 'F':
                return 'F001-' . $value;
            case 'N':
                return 'NV001-' . $value;
            default:
                return $value;
        }
    }
    public function generatePdfA4($id)
    {
        $db = \Config\Database::connect();

        // Fetch comprobantes data
        $builder = $db->table('comprobantes');
        $builder->select('comprobantes.cod_comprobante as cod_comprobante, comprobantes.estado_comprobante_id as estado_comprobante_id, comprobantes.id as comprobantes_id, clientes.dni as dni, clientes.direccion as direccion, comprobantes.*, clientes.nombres, users.username, estado_comprobantes.nom_estado as estado_comprobante');
        $builder->join('clientes', 'comprobantes.cliente_id = clientes.id');
        $builder->join('users', 'comprobantes.user_id = users.id');
        $builder->join('estado_comprobantes', 'comprobantes.estado_comprobante_id = estado_comprobantes.id', 'left');
        $builder->where('comprobantes.id', $id);
        $comprobante = $builder->get()->getRowArray();

        // Fetch comprobantes_detalles data
        $builder = $db->table('comprobantes_detalles');
        $builder->join('servicios', 'comprobantes_detalles.servicio_id = servicios.id');
        $builder->where('comprobante_id', $id);
        $details = $builder->get()->getResultArray();

        $data = [
            'comprobante' => $comprobante,
            'details' => $details,
            // Add other data you want to pass to the view...
        ];
        // Set options to enable embedded PHP 
        $options = new Options();
        $options->set('isPhpEnabled', 'true');
        $dompdf = new Dompdf(['isRemoteEnabled' => true]);
        $dompdf->loadHtml(view('pdf_view_a4', $data), 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        // Instantiate canvas instance 
        /*$canvas = $dompdf->getCanvas();

        // Instantiate font metrics class 
        $fontMetrics = new FontMetrics($canvas, $options);

        // Get height and width of page 
        $w = $canvas->get_width();
        $h = $canvas->get_height();

        // Get font family file 
        $font = $fontMetrics->getFont('times');

        // Specify watermark text
        switch ($comprobante['estado_comprobante_id']) {
            case 1:
                $text = "PENDIENTE DE PAGO";
                $fontSize = 55;
                break;
            case 2:
                $text = "PARCIALMENTE PAGADO";
                $fontSize = 45;
                break;
            case 3:
                $text = "ANULADO";
                $fontSize = 85;
                break;
            default:
                $text = "";
                $fontSize = 0;
                break;
        }

        // Get height and width of text 
        $txtHeight = $fontMetrics->getFontHeight($font, $fontSize);
        $textWidth = $fontMetrics->getTextWidth($text, $font, $fontSize);

        // Set text opacity 
        $canvas->set_opacity(.2);

        // Specify horizontal and vertical position 
        $x = (($w - $textWidth) / 2);
        $y = (($h - $txtHeight) / 3);

        // Writes text at the specified x and y coordinates 
        $canvas->text($x, $y, $text, $font, $fontSize, array(255, 0, 0), '', '', 20);*/
        $dompdf->stream('comprobante_a4-' . date('YmdHis') . '.pdf', ['Attachment' => false]);
        exit();
    }
    public function generatePdf58mm($id)
    {
        $db = \Config\Database::connect();

        // Fetch comprobantes data
        $builder = $db->table('comprobantes');
        $builder->select('comprobantes.cod_comprobante as cod_comprobante, comprobantes.id as comprobantes_id, comprobantes.*, clientes.*, users.*, estado_comprobantes.nom_estado as estado_comprobante');
        $builder->join('clientes', 'comprobantes.cliente_id = clientes.id');
        $builder->join('users', 'comprobantes.user_id = users.id');
        $builder->join('estado_comprobantes', 'comprobantes.estado_comprobante_id = estado_comprobantes.id', 'left');
        $builder->where('comprobantes.id', $id);
        $comprobante = $builder->get()->getRowArray();

        // Fetch comprobantes_detalles data
        $builder = $db->table('comprobantes_detalles');
        $builder->join('servicios', 'comprobantes_detalles.servicio_id = servicios.id');
        $builder->where('comprobante_id', $id);
        $details = $builder->get()->getResultArray();

        $data = [
            'comprobante' => $comprobante,
            'details' => $details,
            // Add other data you want to pass to the view...
        ];
        // Set options to enable embedded PHP 
        $options = new Options();
        $options->set('isPhpEnabled', 'true');
        $dompdf = new Dompdf();
        $dompdf->setPaper([0, 0, 164, 841.89 * 20]);
        $dompdf->loadHtml(view('pdf_view_58mm', $data), 'UTF-8');
        $GLOBALS['bodyHeight'] = 0;
        $dompdf->setCallbacks([
            'myCallbacks' => [
                'event' => 'end_frame',
                'f' => function ($frame) {
                    $node = $frame->get_node();
                    if (strtolower($node->nodeName) === "body") {
                        $padding_box = $frame->get_padding_box();
                        $GLOBALS['bodyHeight'] += $padding_box['h'];
                    }
                }
            ]
        ]);
        $dompdf->render();
        $docHeight = $GLOBALS['bodyHeight'] * 1.25 - 50;
        unset($dompdf);
        $dompdf = new Dompdf(['isRemoteEnabled' => true]);
        $dompdf->setPaper(array(0, 0, 164, $docHeight));
        $dompdf->loadHtml(view('pdf_view_58mm', $data), 'UTF-8');
        $dompdf->render();
        // Instantiate canvas instance 
        /*$canvas = $dompdf->getCanvas();

        // Instantiate font metrics class 
        $fontMetrics = new FontMetrics($canvas, $options);

        // Get height and width of page 
        $w = $canvas->get_width();
        $h = $canvas->get_height();

        // Get font family file 
        $font = $fontMetrics->getFont('times');

        // Specify watermark text 
        $text = "";

        // Get height and width of text 
        $txtHeight = $fontMetrics->getFontHeight($font, 75);
        $textWidth = $fontMetrics->getTextWidth($text, $font, 75);

        // Set text opacity 
        $canvas->set_opacity(.2);

        // Specify horizontal and vertical position 
        $x = (($w - $textWidth) / 2);
        $y = (($h - $txtHeight) / 2);

        // Writes text at the specified x and y coordinates 
        $canvas->text($x, $y, $text, $font, 75);*/
        $dompdf->stream('comprobante_58mm-' . date('YmdHis') . '.pdf', array("Attachment" => false));
        exit();
    }
    public function displayTipoComprobante($value, $row)
    {
        // Define the mapping of values
        $tipoMapping = [
            'B' => 'BOLETA',
            'F' => 'FACTURA',
            'N' => 'NOTA DE VENTA',
        ];

        // Check if the value exists in the mapping, if not, display the original value
        if (array_key_exists($value, $tipoMapping)) {
            return $tipoMapping[$value];
        }

        return $value;
    }
    public function displaySERVICIOS($value, $row)
    {
        $db = \Config\Database::connect();

        // Fetch comprobantes_detalles data
        $builder = $db->table('comprobantes_detalles');
        $builder->select('servicios.nom_servicio, comprobantes_detalles.peso_kg, comprobantes_detalles.costo_kilo');
        $builder->join('servicios', 'comprobantes_detalles.servicio_id = servicios.id');
        $builder->where('comprobante_id', service('uri')->getSegment(service('uri')->getTotalSegments()));
        $details = $builder->get()->getResultArray();

        $table = '<style>
        .table-style {
            border-collapse: collapse;
            width: 100%;
        }
        .table-style th, .table-style td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        /* Add spacing between columns */
        .table-style td {
            padding-right: 15px; /* Adjust as needed */
        }
      </style>';

        $table .= '<table class="table-style">
        <thead>
            <tr>
                <th>SERVICIO</th>
                <th>PESO (KG)</th>
                <th>COSTO X KILO (S/.)</th>
                <th>COSTO TOTAL (S/.)</th>
            </tr>
        </thead>
        <tbody>';

        $total_costo_total = 0; // Variable to hold the total costo_total

        foreach ($details as $detail) {
            $costo_total = $detail['peso_kg'] * $detail['costo_kilo'];
            $total_costo_total += $costo_total; // Accumulate the total costo_total
            $table .= '<tr>
            <td>' . $detail['nom_servicio'] . '</td>
            <td><center>' . $detail['peso_kg'] . '</center></td>
            <td><center>' . $detail['costo_kilo'] . '</center></td>
            <td><center>' . $costo_total . '</center></td>
        </tr>';
        }

        // Add the last row with the total
        $table .= '<tr>
        <td colspan="3"><strong>TOTAL</strong></td>
        <td><center>' . $total_costo_total . '</center></td>
        </tr>';

        $table .= '</tbody></table>';

        return $table;
    }
    public function registrar_comprobante()
    {
        $output = (object) [
            'css_files' => [],
            'js_files' => [],
            'output' => view('registrar_comprobante')
        ];
        return $this->_mainOutput($output);
    }
    public function fetchMetodoPago()
    {
        $metodoPagoModel = new \App\Models\MetodoPago();

        // Get the search term from the request
        $searchTerm = $this->request->getVar('q');

        // If a search term is provided, filter results
        if ($searchTerm !== null) {
            $metodopago = $metodoPagoModel
                ->like('nom_metodo_pago', $searchTerm) // Adjust 'nom_metodo_pago' based on your database column
                ->where('habilitado', 1)
                ->findAll();
        } else {
            // If no search term, retrieve all enabled metodo de pago
            $metodopago = $metodoPagoModel->where('habilitado', 1)->findAll();
        }

        return $this->response->setJSON($metodopago);
    }
    public function fetchServicios()
    {
        $servicioModel = new \App\Models\Servicios();

        // Get the search term from the request
        $searchTerm = $this->request->getVar('q');

        // If a search term is provided, filter results
        if ($searchTerm !== null) {
            $servicios = $servicioModel
                ->like('nom_servicio', $searchTerm) // Adjust 'nom_servicio' based on your database column
                ->where('habilitado', 1)
                ->findAll();
        } else {
            // If no search term, retrieve all enabled servicios
            $servicios = $servicioModel->where('habilitado', 1)->findAll();
        }

        return $this->response->setJSON($servicios);
    }
    public function fetchServicioDetails()
    {
        $servicioModel = new \App\Models\Servicios();
        $servicioId = $this->request->getPost('servicio_id');
        $servicio = $servicioModel->getServicioDetails($servicioId);

        return $this->response->setJSON($servicio);
    }
    public function fetchClientes()
    {
        $clientesModel = new \App\Models\Clientes();

        // Get the search term from the request
        $searchTerm = $this->request->getVar('q');

        // If a search term is provided, filter results
        if ($searchTerm !== null) {
            $clientes = $clientesModel
                ->like('nombres', $searchTerm) // Adjust 'nombres' based on your database column
                ->findAll();
        } else {
            // If no search term, retrieve all enabled clientes
            $clientes = $clientesModel->findAll();
        }

        return $this->response->setJSON($clientes);
    }
    public function fetchEstadocomprobantes()
    {
        $ecModel = new \App\Models\Estadocomprobantes();

        // Get the search term from the request
        $searchTerm = $this->request->getVar('q');

        // If a search term is provided, filter results
        if ($searchTerm !== null) {
            $ec = $ecModel
                ->where('id !=', 3) // Should not be equal to ANULADO
                ->like('nom_estado', $searchTerm) // Adjust 'nom_estado' based on your database column
                ->findAll();
        } else {
            // If no search term, retrieve all enabled estado comprobantes
            $ec = $ecModel
                ->where('id !=', 3) // Should not be equal to ANULADO
                ->findAll();
        }

        return $this->response->setJSON($ec);
    }
    public function submit_comprobantes_form()
    {
        helper(['form', 'url']);

        $model_comprobantes = new \App\Models\Comprobantes();
        $model_comprobantes_detalles = new \App\Models\ComprobantesDetalles();
        $model_clientes = new \App\Models\Clientes();
        $model_reporte_ingresos = new \App\Models\ReporteIngresos();

        $estadoComprobante = $this->request->getPost('estadoComprobante');
        $montoAbonado = $this->request->getPost('monto_abonado');
        $totalRegisterInput = $this->request->getPost('total_register_input');

        if ($estadoComprobante == '1') {
            $montoAbonado = 0;
        } elseif ($estadoComprobante == '4') {
            $montoAbonado = $totalRegisterInput;
        }

        $data_comprobantes = [
            'cliente_id' => $this->request->getPost('clienteDropdown'),
            'metodo_pago_id' => $this->request->getPost('metodopagoDropdown'),
            'tipo_comprobante' => $this->request->getPost('btnradio'),
            'num_ruc' => $this->request->getPost('num_ruc'),
            'razon_social' => $this->request->getPost('razon_social'),
            'observaciones' => $this->request->getPost('comprobante_observaciones'),
            'user_id' => session()->get('user_id'),
            'local_id' => 5,
            'estado_ropa_id' => 1,
            'fecha' => date('Y-m-d H:i:s'),
            'estado_comprobante_id' => $estadoComprobante,
            'monto_abonado' => $montoAbonado,
            'last_updated_by' => session()->get('user_id'),
            'costo_total' => $totalRegisterInput
        ];

        $inserted_id = $model_comprobantes->insert($data_comprobantes);

        $val_id_servicio = $this->request->getPost('val_id_servicio');
        $val_kg_ropa_register = $this->request->getPost('val_kg_ropa_register');
        $val_precio_kilo = $this->request->getPost('val_precio_kilo');

        $data_comprobantes_detalles = [];

        foreach ($val_id_servicio as $key => $value) {
            $data_comprobantes_detalles[] = [
                'servicio_id' => $val_id_servicio[$key],
                'peso_kg' => $val_kg_ropa_register[$key],
                'costo_kilo' => $val_precio_kilo[$key],
                'comprobante_id' => $inserted_id
            ];
        }

        $model_comprobantes_detalles->insertBatch($data_comprobantes_detalles);

        //$this->updateEstadoComprobantesId($model_comprobantes->getInsertID(), $this->request->getPost('monto_abonado'));
        $this->incrementComprobanteCounter($model_comprobantes->getInsertID(), $this->request->getPost('btnradio'));

        $clientes = $model_clientes->where('id', $this->request->getPost('clienteDropdown'))->first();

        $this->whatsapp_pdf($model_comprobantes->getInsertID(), $clientes['telefono']);

        $cod_comprobante = $model_comprobantes->where('id', $model_comprobantes->getInsertID())->first()['cod_comprobante'];

        $data_ingresos = [
            'cod_comprobante' => $cod_comprobante,
            'cliente_id' => $this->request->getPost('clienteDropdown'),
            'metodo_pago_id' => $this->request->getPost('metodopagoDropdown'),
            'fecha' => date('Y-m-d H:i:s'),
            'monto_abonado' => $montoAbonado,
            'costo_total' => $totalRegisterInput
        ];

        $model_reporte_ingresos->insert($data_ingresos);
        
        session()->setFlashdata('success_message', 'El código de comprobante generado es: ' . $cod_comprobante);
        
        // Create a script block that will display the cod_comprobante in a JavaScript alert before redirecting
        echo "<script>
            alert('El código de comprobante generado es: " . $model_comprobantes->where('id', $model_comprobantes->getInsertID())->first()['cod_comprobante'] . "');
            window.location.href = '/comprobantes';
        </script>";
        //return redirect()->to('/comprobantes');
    }
    public function submit_adicionales_form()
    {
        helper(['form', 'url']);
    
        $model_comprobantes_detalles = new \App\Models\ComprobantesDetalles();
        $model_comprobantes = new \App\Models\Comprobantes();
        $model_clientes = new \App\Models\Clientes();
        $db = \Config\Database::connect(); // Get a reference to the database
    
        $inserted_id = $this->request->getPost('comprobante_id');
    
        $val_id_servicio = $this->request->getPost('val_id_servicio');
        $val_kg_ropa_register = $this->request->getPost('val_kg_ropa_register');
        $val_precio_kilo = $this->request->getPost('val_precio_kilo');
    
        $data_comprobantes_detalles = [];
        $total_cost = 0; // This will hold the sum of peso_kg * costo_kilo
    
        foreach ($val_id_servicio as $key => $value) {
            $peso_kg = $val_kg_ropa_register[$key];
            $costo_kilo = $val_precio_kilo[$key];
            $total_cost += $peso_kg * $costo_kilo; // Calculate the sum for each item
    
            $data_comprobantes_detalles[] = [
                'servicio_id' => $val_id_servicio[$key],
                'peso_kg' => $peso_kg,
                'costo_kilo' => $costo_kilo,
                'comprobante_id' => $inserted_id
            ];
        }
    
        $model_comprobantes_detalles->insertBatch($data_comprobantes_detalles);

        $estado_comprobante_id = $model_comprobantes->where('id', $inserted_id)->first()['estado_comprobante_id'];
        $cliente_id = $model_comprobantes->where('id', $inserted_id)->first()['cliente_id'];
        $cod_comprobante = $model_comprobantes->where('id', $inserted_id)->first()['cod_comprobante'];
        $telefono = $model_clientes->where('id', $cliente_id)->first()['telefono'];

        // Check if comprobante is already CANCELADO
        if($estado_comprobante_id == 4)
        {
            $db->table('comprobantes')->where('id', $inserted_id)->update(['estado_comprobante_id' => 2]);
        }
    
        // Fetch the current costo_total from the comprobantes table
        $current_costo_total = $db->table('comprobantes')->where('id', $inserted_id)->get()->getRow()->costo_total;
    
        // Update the costo_total in the comprobantes table
        $db->table('comprobantes')->where('id', $inserted_id)->update(['costo_total' => $current_costo_total + $total_cost]);

        // Send new comprobante through whatsapp
        $this->whatsapp_pdf($inserted_id, $telefono);

        session()->setFlashdata('success_message', 'Se actualizo con éxito el siguiente comprobante: ' . $cod_comprobante);

        // After all your PHP code, output the JavaScript code to reload the parent page
        echo "<script>window.parent.location.reload();</script>";
    }
    public function reenviarPDF($comprobante_id)
    {
        $model_comprobantes = new \App\Models\Comprobantes();
        $model_clientes = new \App\Models\Clientes();

        $cliente_id = $model_comprobantes->where('id', $comprobante_id)->first()['cliente_id'];

        $telefono = $model_clientes->where('id', $cliente_id)->first()['telefono'];

        $this->whatsapp_pdf($comprobante_id, $telefono);

        return redirect()->to(previous_url());
    }
    public function incrementComprobanteCounter($id, $tipo_comprobante)
    {
        $db = \Config\Database::connect();

        // Get the last_value for the tipo_comprobante
        $query = $db->query("SELECT last_value FROM comprobante_counter WHERE tipo_comprobante = ?", [$tipo_comprobante]);
        $row = $query->getRow();

        // If this tipo_comprobante is not in the comprobante_counter table yet, initialize it
        if ($row === null) {
            $db->query("INSERT INTO comprobante_counter(tipo_comprobante, last_value) VALUES (?, 1)", [$tipo_comprobante]);
            $last_value = 1;
        } else {
            $last_value = $row->last_value + 1;
            $db->query("UPDATE comprobante_counter SET last_value = ? WHERE tipo_comprobante = ?", [$last_value, $tipo_comprobante]);
        }

        // Generate the cod_comprobante
        $prefix = '';
        switch ($tipo_comprobante) {
            case 'N':
                $prefix = 'NV';
                break;
            case 'B':
                $prefix = 'B';
                break;
            case 'F':
                $prefix = 'F';
                break;
        }
        $cod_comprobante = $prefix . '001-' . $last_value;

        $db->query("UPDATE comprobantes SET cod_comprobante = ? WHERE id = ?", [$cod_comprobante, $id]);
    }
    public function exportCSV()
    {
        // file name
        $filename = 'registro_ingresos_comprobantes_' . date('YmdHis') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');

        // get data
        $db = \Config\Database::connect();
        $builder = $db->table('reporte_ingresos');
        $builder->select('reporte_ingresos.cod_comprobante, clientes.nombres, DATE_FORMAT(reporte_ingresos.fecha, "%Y-%m-%d") as fecha, COALESCE(NULLIF(metodo_pago.nom_metodo_pago, ""), "NINGUNO") as nom_metodo_pago, reporte_ingresos.monto_abonado');
        $builder->join('metodo_pago', 'reporte_ingresos.metodo_pago_id = metodo_pago.id', 'left');  // use LEFT JOIN
        //$builder->join('metodo_pago', 'reporte_ingresos.metodo_pago_id = metodo_pago.id');
        $builder->join('clientes', 'reporte_ingresos.cliente_id = clientes.id');
        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(reporte_ingresos.fecha) >=', $start_date);
            $builder->where('DATE(reporte_ingresos.fecha) <=', $end_date);
        }
        $builder->where('reporte_ingresos.monto_abonado >', 0);
        $comprobantesData = $builder->get()->getResultArray();

        // file creation
        $file = fopen('php://output', 'w');

        $header = array("COMPROBANTE", "CLIENTE", "FECHA DE ABONO", "METODO DE PAGO", "MONTO ABONADO");
        fputcsv($file, $header);
        foreach ($comprobantesData as $key => $line) {
            $line = array_map(function ($value) {
                return mb_convert_encoding($value, 'ISO-8859-1', 'UTF-8');
            }, $line);
            fputcsv($file, $line);
        }
        fclose($file);
        exit;
    }
    public function exportExcel()
    {
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');

        // Get data
        $db = \Config\Database::connect();
        $builder = $db->table('reporte_ingresos');
        $builder->select('reporte_ingresos.cod_comprobante, clientes.nombres, DATE_FORMAT(reporte_ingresos.fecha, "%Y-%m-%d") as fecha, COALESCE(NULLIF(metodo_pago.nom_metodo_pago, ""), "NINGUNO") as nom_metodo_pago, reporte_ingresos.monto_abonado');
        $builder->join('metodo_pago', 'reporte_ingresos.metodo_pago_id = metodo_pago.id', 'left'); // use LEFT JOIN
        //$builder->join('metodo_pago', 'reporte_ingresos.metodo_pago_id = metodo_pago.id'); // use LEFT JOIN
        $builder->join('clientes', 'reporte_ingresos.cliente_id = clientes.id');
        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(reporte_ingresos.fecha) >=', $start_date);
            $builder->where('DATE(reporte_ingresos.fecha) <=', $end_date);
        }
        $builder->where('reporte_ingresos.monto_abonado >', 0);
        $comprobantesData = $builder->get()->getResultArray();

        // Set the headers
        $headers = array("COMPROBANTE", "CLIENTE", "FECHA DE ABONO", "METODO DE PAGO", "MONTO ABONADO");
        foreach ($headers as $key => $header) {
            $sheet->setCellValueByColumnAndRow($key + 1, 1, $header);
        }

        // Add the data
        $rowNumber = 2;
        foreach ($comprobantesData as $dataRow) {
            $column = 1;
            foreach ($dataRow as $value) {
                // Encode special characters
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                $sheet->setCellValueByColumnAndRow($column, $rowNumber, $value);
                $column++;
            }
            $rowNumber++;
        }

        // Save to a temporary file as XLSX format explicitly
        $writer = new Xlsx($spreadsheet);

        $filename = 'registro_ingresos_comprobantes_' . date('YmdHis');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file
        die;
    }
    public function fetch_reporte_ingresos_web()
    {
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');

        // Get data
        $db = \Config\Database::connect();
        $builder = $db->table('reporte_ingresos');
        $builder->select('reporte_ingresos.cod_comprobante, clientes.nombres, DATE_FORMAT(reporte_ingresos.fecha, "%Y-%m-%d") as fecha, metodo_pago.nom_metodo_pago, reporte_ingresos.monto_abonado');
        $builder->join('metodo_pago', 'reporte_ingresos.metodo_pago_id = metodo_pago.id', 'left'); // use LEFT JOIN
        //$builder->join('metodo_pago', 'reporte_ingresos.metodo_pago_id = metodo_pago.id'); // use LEFT JOIN
        $builder->join('clientes', 'reporte_ingresos.cliente_id = clientes.id');
        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(reporte_ingresos.fecha) >=', $start_date);
            $builder->where('DATE(reporte_ingresos.fecha) <=', $end_date);
        }
        $builder->where('reporte_ingresos.monto_abonado >', 0);
        $comprobantesData = $builder->get()->getResultArray();

        // Return data as JSON
        return $this->response->setJSON($comprobantesData);
    }
    public function exportCSVtrabajo()
    {
        // file name
        $filename = 'registro_trabajo_comprobantes_' . date('YmdHis') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');

        // get data
        $db = \Config\Database::connect();
        $builder = $db->table('comprobantes');
        $builder->select('comprobantes.cod_comprobante, clientes.nombres, DATE_FORMAT(comprobantes.fecha, "%Y-%m-%d") as fecha, comprobantes.costo_total');
        //$builder->join('metodo_pago', 'reporte_ingresos.metodo_pago_id = metodo_pago.id', 'left');  // use LEFT JOIN
        $builder->join('clientes', 'comprobantes.cliente_id = clientes.id');
        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(comprobantes.fecha) >=', $start_date);
            $builder->where('DATE(comprobantes.fecha) <=', $end_date);
        }
        $comprobantesData = $builder->get()->getResultArray();

        // file creation
        $file = fopen('php://output', 'w');

        $header = array("COMPROBANTE", "CLIENTE", "FECHA", "COSTO TOTAL");
        fputcsv($file, $header);
        foreach ($comprobantesData as $key => $line) {
            $line = array_map(function ($value) {
                return mb_convert_encoding($value, 'ISO-8859-1', 'UTF-8');
            }, $line);
            fputcsv($file, $line);
        }
        fclose($file);
        exit;
    }
    public function exportExceltrabajo()
    {
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');

        // Get data
        $db = \Config\Database::connect();
        $builder = $db->table('comprobantes');
        $builder->select('comprobantes.cod_comprobante, clientes.nombres, DATE_FORMAT(comprobantes.fecha, "%Y-%m-%d") as fecha, comprobantes.costo_total');
        //$builder->join('metodo_pago', 'reporte_ingresos.metodo_pago_id = metodo_pago.id', 'left'); // use LEFT JOIN
        $builder->join('clientes', 'comprobantes.cliente_id = clientes.id');
        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(comprobantes.fecha) >=', $start_date);
            $builder->where('DATE(comprobantes.fecha) <=', $end_date);
        }
        $comprobantesData = $builder->get()->getResultArray();

        // Set the headers
        $headers = array("COMPROBANTE", "CLIENTE", "FECHA", "COSTO TOTAL");
        foreach ($headers as $key => $header) {
            $sheet->setCellValueByColumnAndRow($key + 1, 1, $header);
        }

        // Add the data
        $rowNumber = 2;
        foreach ($comprobantesData as $dataRow) {
            $column = 1;
            foreach ($dataRow as $value) {
                // Encode special characters
                $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                $sheet->setCellValueByColumnAndRow($column, $rowNumber, $value);
                $column++;
            }
            $rowNumber++;
        }

        // Save to a temporary file as XLSX format explicitly
        $writer = new Xlsx($spreadsheet);

        $filename = 'registro_trabajo_comprobantes_' . date('YmdHis');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output'); // download file
        die;
    }
    public function fetch_reporte_trabajo_web()
    {
        $start_date = $this->request->getPost('start_date');
        $end_date = $this->request->getPost('end_date');

        // Get data
        $db = \Config\Database::connect();
        $builder = $db->table('comprobantes');
        $builder->select('comprobantes.cod_comprobante, clientes.nombres, DATE_FORMAT(comprobantes.fecha, "%Y-%m-%d") as fecha, comprobantes.costo_total');
        //$builder->join('metodo_pago', 'reporte_ingresos.metodo_pago_id = metodo_pago.id', 'left'); // use LEFT JOIN
        $builder->join('clientes', 'comprobantes.cliente_id = clientes.id');
        if (!empty($start_date) && !empty($end_date)) {
            $builder->where('DATE(comprobantes.fecha) >=', $start_date);
            $builder->where('DATE(comprobantes.fecha) <=', $end_date);
        }
        $comprobantesData = $builder->get()->getResultArray();

        // Return data as JSON
        return $this->response->setJSON($comprobantesData);
    }
    public function reporte_ingresos()
    {
        $output = (object) [
            'css_files' => [],
            'js_files' => [],
            'output' => view('reporte_ingresos')
        ];
        return $this->_mainOutput($output);
    }
    public function reporte_trabajo()
    {
        $output = (object) [
            'css_files' => [],
            'js_files' => [],
            'output' => view('reporte_trabajo')
        ];
        return $this->_mainOutput($output);
    }
    public function change_password()
    {
        if (session()->get('user_id') != service('uri')->getSegment(service('uri')->getTotalSegments())) {
            return redirect()->to('/');
        } else {
            $crud = new GroceryCrud();

            $crud->setTable('users');
            $crud->setSubject('USUARIO DEL SISTEMA');
            $crud->displayAs([
                'password' => 'CONTRASEÑA'
            ]);
            $crud->editFields(['password']);
            $crud->unsetBackToDatagrid();
            // Modify these callbacks to transform the username to uppercase in the add and edit forms
            $crud->callbackEditField('password', function ($postArray, $primaryKey) {
                return $this->editar_campo_password($postArray, $primaryKey);
            });
            $crud->callbackBeforeUpdate(function ($stateParameters) {
                return $this->actualizar_password($stateParameters);
            });
            $output = $crud->render();

            return $this->_mainOutput($output);
        }
    }
}