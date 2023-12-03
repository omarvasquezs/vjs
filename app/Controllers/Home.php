<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;
use Dompdf\Dompdf;

class Home extends BaseController
{
    private function _mainOutput($output = null)
    {
        return view('output', (array) $output);
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
            'direccion' => 'DIRECCION',
            'callmebot_api_key' => 'CALL ME BOT API KEY'
        ]);

        // Check if it's the add or edit page based on the 'state' parameter in the URL
        $uri = service('uri');
        $segments = $uri->getSegments();
        $state = null;

        foreach ($segments as $segment) {
            if ($segment == 'add') {
                $state = 'add';
                break;
            } elseif ($segment == 'edit') {
                $state = 'edit';
                break;
            }
        }

        // Render the CRUD
        $output = $crud->render();

        // Additional information or text to be added at the top of the form for add/edit pages
        $additional_text = '';

        if ($state === 'add' || $state === 'edit') {
            $additional_text = '<div class="card text-center mx-auto" style="width: 100%;max-width: 98.5%;">
            <h5 class="card-header">IMPORTANTE</h5>
            <div class="card-body">              
              <p class="card-text">Si el cliente quiere que le lleguen notificaciones de whatsapp, debes proporcionarle el link del Call me bot de whatsapp y de ahi él/ella te debe proporcionar el API KEY.</p>
              <button id="copyButton" class="btn btn-primary">HAZ CLICK AQUÍ PARA COPIAR EL LINK DEL CALLMEBOT</button>
            </div>
          </div>';
        }

        // Insert the additional text before the existing output
        $output->output = $additional_text . $output->output;

        $css_files = $output->css_files;
        $js_files = $output->js_files;
        $css_class = 'clientes';
        $output = $output->output;

        return $this->_mainOutput(['output' => $output, 'css_class' => $css_class, 'css_files' => $css_files, 'js_files' => $js_files]);
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
        $crud->setRelation('metodo_pago_id', 'metodo_pago', 'nom_metodo_pago');
        $crud->setRelation('estado_comprobante_id', 'estado_comprobantes', 'nom_estado');
        $crud->setRelation('local_id', 'locales', 'nombre');
        $crud->setRelation('user_id', 'users', 'username');
        $crud->setRelation('estado_ropa_id', 'estado_ropa', 'nom_estado_ropa');
        $crud->setRelationNtoN('SERVICIOS', 'comprobantes_detalles', 'servicios', 'comprobante_id', 'servicio_id', 'nom_servicio');
        $crud->editFields(['tipo_comprobante', 'cliente_id', 'estado_comprobante_id', 'estado_ropa_id','observaciones']);
        $crud->unsetEditFields(['SERVICIOS']);
        $crud->unsetExport();
        $crud->unsetPrint();
        $crud->unsetAdd();
        $crud->unsetDelete();
        $crud->setRead();
        $crud->displayAs([
            'id' => 'COMPROBANTE',
            'comprobante' => 'COMPROBANTE',
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
            'tipo_comprobante' => 'TIPO'
        ]);

        $crud->readFields(['id', 'tipo_comprobante', 'cliente_id', 'user_id', 'fecha', 'metodo_pago_id', 'num_ruc', 'razon_social', 'estado_comprobante_id', 'estado_ropa_id', 'local_id', 'SERVICIOS', 'observaciones']);

        // All visible columns on the table, including custom columns
        $crud->columns(['comprobante', 'tipo_comprobante', 'cliente_id', 'estado_comprobante_id', 'estado_ropa_id', 'user_id', 'fecha']);

        $crud->setActionButton('Vista de Impresion', 'print-icon-custom', function ($row) {
            return site_url('comprobante/' . $row);
        }, true);

        // Add this callback to modify the tipo_comprobante column in the list view
        $crud->callbackColumn('tipo_comprobante', array($this, 'displayTipoComprobante'));

        // Add this callback to modify the tipo_comprobante field in the read view
        $crud->callbackReadField('tipo_comprobante', array($this, 'displayTipoComprobante'));

        // Adding custom column
        $crud->callbackColumn('comprobante', array($this, 'displayComprobante'));

        $crud->callbackReadField('id', array($this, 'displayIdWithTipoComprobante'));

        $db = \Config\Database::connect();

        // Add beforeUpdate event
        $crud->callbackBeforeUpdate(function ($stateParameters) use ($db) {
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
                    $message = "VJ's Laundry le informa que su ropa ya está lista para recoger, favor de apersonarse a nuestro local. Si no ha pagado aún o tiene un deuda pendiente con nosotros, favor de pagarlo lo antes posible, ya que sino se le retendrá la ropa. Su código de comprobante es ".$this->displayComprobanteWSP($stateParameters->data['tipo_comprobante'], $stateParameters->primaryKeyValue);


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
    private function displayComprobanteWSP($tipo_comprobante, $comprobante_id)
    {
        // Modify the id based on the tipo_comprobante value
        switch ($tipo_comprobante) {
            case 'B':
                return 'B001-' . $comprobante_id;
            case 'F':
                return 'F001-' . $comprobante_id;
            case 'N':
                return 'NV001-' . $comprobante_id;
            default:
                return $comprobante_id;
        }
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
        $builder->select('comprobantes.id as comprobantes_id, clientes.dni as dni, clientes.direccion as direccion, comprobantes.*, clientes.nombres, users.username, metodo_pago.nom_metodo_pago');
        $builder->join('clientes', 'comprobantes.cliente_id = clientes.id');
        $builder->join('users', 'comprobantes.user_id = users.id');
        $builder->join('metodo_pago', 'comprobantes.metodo_pago_id = metodo_pago.id');
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

        $dompdf = new Dompdf(['isRemoteEnabled' => true]);
        $dompdf->loadHtml(view('pdf_view_a4', $data), 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('comprobante_a4-' . date('YmdHis') . '.pdf', ['Attachment' => false]);
        exit();
    }
    public function generatePdf58mm($id)
    {
        $db = \Config\Database::connect();

        // Fetch comprobantes data
        $builder = $db->table('comprobantes');
        $builder->select('comprobantes.id as comprobantes_id, comprobantes.*, clientes.*, users.*, metodo_pago.*');
        $builder->join('clientes', 'comprobantes.cliente_id = clientes.id');
        $builder->join('users', 'comprobantes.user_id = users.id');
        $builder->join('metodo_pago', 'comprobantes.metodo_pago_id = metodo_pago.id');
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
            'estado_comprobante_id' => $this->request->getPost('estadoComprobante')
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

        $clientes = $model_clientes->where('id', $this->request->getPost('clienteDropdown'))->first();

        $this->whatsapp_pdf($model_comprobantes->getInsertID(), $clientes['telefono']);

        return redirect()->to('/comprobantes');
    }
}