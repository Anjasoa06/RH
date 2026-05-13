<?php

namespace App\Controllers;

use App\Models\EmployeModel;

class AuthController extends BaseController
{
    public function loginForm()
    {
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $model = new EmployeModel();

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $employe = $model->where('email', $email)->first();

        if ($employe && password_verify($password, $employe['password'])) {
            $session->set([
                'id' => $employe['id'],
                'nom' => $employe['nom'],
                'email' => $employe['email'],
                'role' => $employe['role'],
                'isLoggedIn' => true,
            ]);

            // Redirection selon le rôle
            if ($employe['role'] == 'admin') {
                return redirect()->to('/admin')->with('success', 'Bienvenue ' . $employe['nom']);
            } elseif ($employe['role'] == 'rh') {
                return redirect()->to('/rh')->with('success', 'Bienvenue ' . $employe['nom']);
            } else {
                return redirect()->to('/employe')->with('success', 'Bienvenue ' . $employe['nom']);
            }
        } else {
            return redirect()->back()->with('error', 'Email ou mot de passe incorrect');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Déconnecté avec succès');
    }
}