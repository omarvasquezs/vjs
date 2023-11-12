<?php

namespace App\Controllers;

use App\Libraries\GroceryCrud;

class Home extends BaseController
{
    private function _mainOutput($output = null) {
        return view('output', (array)$output);
    }
    public function index() {        
        $output = (object)[
            'css_files' => [],
            'js_files' => [],           
            'output' => view('main')
        ];        
        return $this->_mainOutput($output);
    }
	public function clientes() {
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

	    $output = $crud->render();
        $css_files = $output->css_files;
        $js_files = $output->js_files;
        $css_class = 'clientes';
        $output = $output->output;

		return $this->_mainOutput(['output' => $output, 'css_class' => $css_class, 'css_files' => $css_files,'js_files' => $js_files]);
	}
    public function estado_boletas() {
        $crud = new GroceryCrud();

	    $crud->setTable('estado_boletas');
        $crud->setSubject('ESTADO DE BOLETA');
        $crud->fieldType('habilitado','true_false', array('0' => 'DESHABILITADO', '1' => 'HABILITADO'));
        $crud->displayAs([
            'nom_estado' => 'NOMBRE ESTADO DE BOLETA',
            'habilitado' => 'ESTADO'
        ]);
        $crud->unsetExport();
        $crud->unsetPrint();
        $output = $crud->render();

		return $this->_mainOutput($output);
    }
    public function metodo_pago() {
        $crud = new GroceryCrud();

	    $crud->setTable('metodo_pago');
        $crud->setSubject('METODO DE PAGO');
        $crud->fieldType('habilitado','true_false', array('0' => 'DESHABILITADO', '1' => 'HABILITADO'));
        $crud->displayAs([
            'nom_metodo_pago' => 'METODO DE PAGO',
            'habilitado' => 'ESTADO'
        ]);
        $crud->unsetExport();
        $crud->unsetPrint();
        $output = $crud->render();

		return $this->_mainOutput($output);
    }
    public function roles () {
        $crud = new GroceryCrud();

	    $crud->setTable('roles');
        $crud->fieldType('habilitado','true_false', array('0' => 'DESHABILITADO', '1' => 'HABILITADO'));
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
    public function servicios () {
        $crud = new GroceryCrud();

	    $crud->setTable('servicios');
        $crud->setSubject('SERVICIO');
        $crud->fieldType('habilitado','true_false', array('0' => 'DESHABILITADO', '1' => 'HABILITADO'));
        $crud->columns(['nom_servicio','precio_kilo','habilitado']);
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
    public function users () {
        $crud = new GroceryCrud();

	    $crud->setTable('users');
        $crud->columns(['username', 'role_id', 'habilitado']);
        $crud->setRelation('role_id', 'roles', 'role_name');
        $crud->setSubject('USUARIO DEL SISTEMA');
        $crud->fieldType('habilitado','true_false', array('0' => 'DESHABILITADO', '1' => 'HABILITADO'));
        $crud->unsetExport();
        $crud->unsetPrint();
        $crud->displayAs([
            'username' => 'USUARIO',
            'role_id' => 'ROL',
            'password' => 'CONTRASEÑA',
            'habilitado' => 'ESTADO'
        ]);
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
    public function editar_campo_password($postArray, $primaryKey){
        return '<input class="form-control" type="password" maxlength="50" name="password" style="width: 500px;max-width: 500px;height: 2.5rem;box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);">';
    }
    
    public function encriptar_password($stateParameters) {
        $stateParameters->data['password'] = md5(sha1($stateParameters->data['password']));
        return $stateParameters;
    }
    
    public function actualizar_password($stateParameters) {
        if(!empty($stateParameters->data['password'])) {
            $stateParameters->data['password'] = md5(sha1($stateParameters->data['password']));
        } else {
            unset($stateParameters->data['password']);
        }
        return $stateParameters;
    }    
    public function locales () {
        $crud = new GroceryCrud();

	    $crud->setTable('locales');
        $crud->setSubject('LOCAL');
        $crud->fieldType('habilitado','true_false', array('0' => 'DESHABILITADO', '1' => 'HABILITADO'));
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
    public function boletas() {
        $crud = new GroceryCrud();

        $crud->setTable('boletas');
        $crud->setSubject('Boleta');
        $crud->setRelation('cliente_id','clientes','nombres');        
        $crud->setRelation('metodo_pago_id','metodo_pago','nom_metodo_pago');
        $crud->setRelation('estado_boleta_id','estado_boletas','nom_estado');
        $crud->setRelation('local_id','locales','nombre');
        $crud->fieldType('user_id', 'hidden', session()->get('role_id'));
        $crud->unsetEdit();
        $crud->unsetExport();
        $crud->unsetPrint();
        $crud->unsetAdd();
        $crud->displayAs([
            'cliente_id' => 'CLIENTE',
            'metodo_pago_id' => 'METODO DE PAGO',
            'estado_boleta_id' => 'ESTADO',
            'local_id' => 'LOCAL',
            'observaciones' => 'OBSERVACIONES'
        ]);
        $output = $crud->render();
        $css_files = $output->css_files;
        $js_files = $output->js_files;
        $css_class = 'boletas';
        $output = $output->output;

		return $this->_mainOutput(['output' => $output, 'css_class' => $css_class, 'css_files' => $css_files,'js_files' => $js_files]);
    }
    public function registrar_boleta() {
        $output = (object)[
            'css_files' => [],
            'js_files' => [],           
            'output' => view('registrar_boleta')
        ];        
        return $this->_mainOutput($output);        
    }
    public function fetchMetodoPago() {
        $metodoPagoModel = new \App\Models\MetodoPago();
        $metodopago = $metodoPagoModel->where('habilitado', 1)->findAll();

        return $this->response->setJSON($metodopago);
    }
    public function fetchServicios() {
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
    public function fetchServicioDetails() {
        $servicioModel = new \App\Models\Servicios();
        $servicioId = $this->request->getPost('servicio_id');
        $servicio = $servicioModel->getServicioDetails($servicioId);

        return $this->response->setJSON($servicio);
    }
}
