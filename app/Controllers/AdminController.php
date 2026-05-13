<?php

namespace App\Controllers;

class AdminController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Vue d\'ensemble',
            'breadcrumb' => 'Administration',
        ];
        return view('layouts/app', $data);
    }

    public function employes()
    {
        $data = [
            'title' => 'Gestion des employés',
            'breadcrumb' => 'Admin / Employés',
        ];
        return view('layouts/app', $data);
    }
}