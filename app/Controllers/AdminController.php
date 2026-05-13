<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\DepartementModel;
use App\Models\TypeCongeModel;
use App\Models\CongeModel;

class AdminController extends BaseController
{
    protected $employeModel;
    protected $departementModel;
    protected $typeCongeModel;
    protected $congeModel;

    public function __construct()
    {
        $this->employeModel = new EmployeModel();
        $this->departementModel = new DepartementModel();
        $this->typeCongeModel = new TypeCongeModel();
        $this->congeModel = new CongeModel();
    }

    public function index()
    {
        // Récupérer les absents du jour
        $db = \Config\Database::connect();
        $absents = $db->query("
            SELECT DISTINCT conges.id, employes.nom, types_conge.nom as type_nom
            FROM conges
            JOIN employes ON employes.id = conges.employe_id
            JOIN types_conge ON types_conge.id = conges.type_conge_id
            WHERE conges.statut = 'approuvee'
            AND conges.date_debut <= DATE('now')
            AND conges.date_fin >= DATE('now')
        ")->getResultArray();

        $data = [
            'title' => 'Vue d\'ensemble',
            'breadcrumb' => 'Administration',
            'total_employes' => $this->employeModel->countAll(),
            'demandes_en_attente' => $this->congeModel->where('statut', 'en_attente')->countAllResults(),
            'demandes_approuvees' => $this->congeModel->where('statut', 'approuvee')->countAllResults(),
            'absents_aujourd_hui' => $absents,
        ];
        return view('admin/dashboard', $data);
    }

    public function employes()
    {
        $employes = $this->employeModel
            ->select('employes.*, departements.nom as dept_nom')
            ->join('departements', 'departements.id = employes.departement_id')
            ->findAll();

        $data = [
            'title' => 'Gestion des employés',
            'breadcrumb' => 'Admin / Employés',
            'employes' => $employes,
        ];
        return view('admin/employe', $data);
    }

    public function demandes()
    {
        $conges = $this->congeModel
            ->select('conges.*, employes.nom as employe_nom, types_conge.nom as type_nom')
            ->join('employes', 'employes.id = conges.employe_id')
            ->join('types_conge', 'types_conge.id = conges.type_conge_id')
            ->findAll();

        $data = [
            'title' => 'Toutes les demandes',
            'breadcrumb' => 'Admin / Demandes',
            'conges' => $conges,
        ];
        return view('admin/demandes', $data);
    }

    public function departements()
    {
        $departements = $this->departementModel
            ->select('departements.*, COUNT(employes.id) as nb_employes')
            ->join('employes', 'employes.departement_id = departements.id', 'left')
            ->groupBy('departements.id')
            ->findAll();

        $data = [
            'title' => 'Gestion des départements',
            'breadcrumb' => 'Admin / Départements',
            'departements' => $departements,
        ];
        return view('admin/departements', $data);
    }

    public function typesCongé()
    {
        $types = $this->typeCongeModel->findAll();

        $data = [
            'title' => 'Types de congé',
            'breadcrumb' => 'Admin / Types de congé',
            'types_conge' => $types,
        ];
        return view('admin/types-conge', $data);
    }

    public function soldes()
    {
        $data = [
            'title' => 'Soldes annuels',
            'breadcrumb' => 'Admin / Soldes annuels',
        ];
        return view('admin/soldes', $data);
    }
}