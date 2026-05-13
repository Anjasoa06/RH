<?php

namespace App\Controllers;

class EmployeController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Tableau de bord',
            'breadcrumb' => 'Accueil',
        ];
        return view('layouts/app', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Nouvelle demande de congé',
            'breadcrumb' => 'Accueil / Nouvelle demande',
        ];
        return view('layouts/app', $data);
    }

    public function demandes()
    {
        $data = [
            'title' => 'Mes demandes de congé',
            'breadcrumb' => 'Accueil / Mes demandes',
        ];
        return view('layouts/app', $data);
    }

    public function profil()
    {
        $data = [
            'title' => 'Mon profil',
            'breadcrumb' => 'Accueil / Mon profil',
        ];
        return view('layouts/app', $data);
    }
}