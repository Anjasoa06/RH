<?php

namespace App\Controllers;

use App\Models\CongeModel;
use App\Models\SoldeModel;
use App\Models\DepartementModel;

class EmployeController extends BaseController
{
    protected $congeModel;
    protected $soldeModel;
    protected $departementModel;

    public function __construct()
    {
        $this->congeModel = new CongeModel();
        $this->soldeModel = new SoldeModel();
        $this->departementModel = new DepartementModel();
    }

    public function index()
    {
        $userId = session()->get('id');
        
        $data = [
            'title' => 'Tableau de bord',
            'breadcrumb' => 'Accueil',
            'conges' => $this->congeModel
                ->select('conges.*, types_conge.nom as type_nom')
                ->join('types_conge', 'types_conge.id = conges.type_conge_id')
                ->where('employe_id', $userId)
                ->limit(5)
                ->findAll(),
            'soldes' => $this->soldeModel->where('employe_id', $userId)->findAll(),
        ];
        return view('employe/dashboard', $data);
    }

    public function create()
    {
        $userId = session()->get('id');
        $typeCongeModel = new \App\Models\TypeCongeModel();
        
        $data = [
            'title' => 'Nouvelle demande de congé',
            'breadcrumb' => 'Accueil / Nouvelle demande',
            'types_conge' => $typeCongeModel->findAll(),
            'soldes' => $this->soldeModel
                ->select('soldes.*, types_conge.nom as type_nom')
                ->join('types_conge', 'types_conge.id = soldes.type_conge_id')
                ->where('employe_id', $userId)
                ->findAll(),
        ];
        return view('employe/create', $data);
    }

    public function demandes()
    {
        $userId = session()->get('id');
        
        $data = [
            'title' => 'Mes demandes de congé',
            'breadcrumb' => 'Accueil / Mes demandes',
            'conges' => $this->congeModel
                ->select('conges.*, types_conge.nom as type_nom')
                ->join('types_conge', 'types_conge.id = conges.type_conge_id')
                ->where('conges.employe_id', $userId)
                ->findAll(),
        ];
        return view('employe/index', $data);
    }

    public function profil()
    {
        $userId = session()->get('id');
        $employeModel = new \App\Models\EmployeModel();
        $employe = $employeModel->find($userId);
        
        $data = [
            'title' => 'Mon profil',
            'breadcrumb' => 'Accueil / Mon profil',
            'employe' => $employe,
        ];
        return view('employe/profil', $data);
    }

    public function store()
    {
        $userId = session()->get('id');
        $typeCongeId = $this->request->getPost('type_conge_id');
        $dateDebut = $this->request->getPost('date_debut');
        $dateFin = $this->request->getPost('date_fin');
        $motif = $this->request->getPost('motif');

        // Calculer le nombre de jours
        $debut = new \DateTime($dateDebut);
        $fin = new \DateTime($dateFin);
        $interval = $debut->diff($fin);
        $nbJours = $interval->days + 1;

        $data = [
            'employe_id' => $userId,
            'type_conge_id' => $typeCongeId,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'nb_jours' => $nbJours,
            'motif' => $motif,
            'statut' => 'en_attente',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if ($this->congeModel->insert($data)) {
            return redirect()->to(site_url('employe/demandes'))->with('success', 'Votre demande a été soumise avec succès.');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de la soumission de votre demande.');
        }
    }

    public function changerMotDePasse()
    {
        $userId = session()->get('id');
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        $employeModel = new \App\Models\EmployeModel();
        $employe = $employeModel->find($userId);

        // Vérifier le mot de passe actuel
        if (!password_verify($currentPassword, $employe['password'])) {
            return redirect()->back()->with('error', 'Le mot de passe actuel est incorrect.');
        }

        // Vérifier que les nouveaux mots de passe correspondent
        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Les nouveaux mots de passe ne correspondent pas.');
        }

        // Mettre à jour le mot de passe
        if ($employeModel->update($userId, ['password' => $newPassword])) {
            return redirect()->back()->with('success', 'Mot de passe modifié avec succès.');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de la modification du mot de passe.');
        }
    }
}