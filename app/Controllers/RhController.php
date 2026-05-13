<?php

namespace App\Controllers;

class RhController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Demandes à traiter',
            'breadcrumb' => 'Accueil / Demandes',
        ];
        return view('layouts/app', $data);
    }
}