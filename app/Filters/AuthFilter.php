<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Vérifier si l'utilisateur est connecté
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Veuillez vous connecter');
        }
        
        // Vérifier le rôle si spécifié dans les arguments
        if (!empty($arguments) && !in_array($session->get('role'), $arguments)) {
            return redirect()->to('/')->with('error', 'Accès non autorisé');
        }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Rien après
    }
}