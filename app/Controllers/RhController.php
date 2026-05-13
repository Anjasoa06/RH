<?php

namespace App\Controllers;

use App\Models\CongeModel;
use App\Models\EmployeModel;
use App\Models\TypeCongeModel;
use App\Models\SoldeModel;

class RhController extends BaseController
{
    protected $congeModel;
    protected $employeModel;
    protected $typeCongeModel;
    protected $soldeModel;

    public function __construct()
    {
        $this->congeModel = new CongeModel();
        $this->employeModel = new EmployeModel();
        $this->typeCongeModel = new TypeCongeModel();
        $this->soldeModel = new SoldeModel();
    }

    public function index()
    {
        // Récupérer les congés en attente avec les infos employé et type
        $conges = $this->congeModel
            ->select('conges.*, employes.nom as employe_nom, employes.departement_id, departements.nom as dept_nom, types_conge.nom as type_nom')
            ->join('employes', 'employes.id = conges.employe_id')
            ->join('departements', 'departements.id = employes.departement_id')
            ->join('types_conge', 'types_conge.id = conges.type_conge_id')
            ->where('conges.statut', 'en_attente')
            ->findAll();

        $data = [
            'title' => 'Demandes à traiter',
            'breadcrumb' => 'Accueil / Demandes',
            'conges' => $conges,
        ];
        return view('rh/index', $data);
    }

    public function traiter($action, $id)
    {
        $statut = ($action === 'approuver') ? 'approuvee' : 'refusee';
        $this->congeModel->update($id, ['statut' => $statut]);
        
        if ($action === 'approuver') {
            return redirect()->back()->with('success', 'Demande approuvée avec succès.');
        } else {
            return redirect()->back()->with('success', 'Demande refusée.');
        }
    }

    public function historique()
    {
        $conges = $this->congeModel
            ->select('conges.*, employes.nom as employe_nom, types_conge.nom as type_nom')
            ->join('employes', 'employes.id = conges.employe_id')
            ->join('types_conge', 'types_conge.id = conges.type_conge_id')
            ->whereIn('conges.statut', ['approuvee', 'refusee'])
            ->findAll();

        $data = [
            'title' => 'Historique des demandes',
            'breadcrumb' => 'RH / Historique',
            'conges' => $conges,
        ];
        return view('rh/historique', $data);
    }

    public function soldes()
    {
        $soldes = $this->soldeModel
            ->select('soldes.*, employes.nom as employe_nom, employes.departement_id, departements.nom as dept_nom, types_conge.nom as type_nom')
            ->join('employes', 'employes.id = soldes.employe_id')
            ->join('departements', 'departements.id = employes.departement_id')
            ->join('types_conge', 'types_conge.id = soldes.type_conge_id')
            ->findAll();

        $data = [
            'title' => 'Soldes des employés',
            'breadcrumb' => 'RH / Soldes',
            'soldes' => $soldes,
        ];
        return view('rh/soldes', $data);
    }
}