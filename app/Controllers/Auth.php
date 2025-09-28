<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;

class Auth extends BaseController
{
    protected $userModel;
    protected $session;
    
    public function __construct()
    {
        $this->userModel = new User();
        $this->session = \Config\Services::session();
    }
    
    public function login() {
        return view('login');
    }
    public function authenticate()
    {
        if (strtolower($this->request->getMethod()) === 'post') {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            
            if ($username && $password) {
                $user = $this->userModel->where('username', $username)->first();
                
                if ($user) {
                    // Usar md5(sha1()) como en el código original
                    if ($user['password'] === md5(sha1($password))) {
                        // Configurar la sesión
                        $sessionData = [
                            'user_id' => $user['id'],
                            'username' => $user['username'],
                            'isLoggedIn' => true
                        ];
                        $this->session->set($sessionData);
                        return redirect()->to('/');
                    }
                }
            }
            
            // Si llegamos aquí, la autenticación falló
            return redirect()->to('/login')->with('error', 'Credenciales inválidas');
        }
        
        // Si no es POST, redirigir al login
        return redirect()->to('/login');
    }
    public function logout() {
        // Destroy the session
        session()->destroy();
        
        // Redirect to the login page
        return redirect()->to('/login');
    }
}
