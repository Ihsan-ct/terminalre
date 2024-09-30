<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function authenticate()
    {
        $model = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            log_message('info', 'User authenticated successfully');
            session()->set([
                'username' => $user['username'],
                'isLoggedIn' => true,
                'role' => $user['role']
            ]);
        
            if ($user['role'] === 'admin') {
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/user/dashboard');
            }
        } else {
            log_message('error', 'Invalid login attempt for username: ' . $username);
            return redirect()->to('/login')->with('error', 'Invalid credentials');
        }
    }
        

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
