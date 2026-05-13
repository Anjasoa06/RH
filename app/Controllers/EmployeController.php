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
                ->findAll(),
            'soldes' => $this->soldeModel
                ->select('soldes.*, types_conge.nom as type_nom')
                ->join('types_conge', 'types_conge.id = soldes.type_conge_id')
                ->where('employe_id', $userId)
                ->findAll(),
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

        // Validation des dates
        $debut = new \DateTime($dateDebut);
        $fin = new \DateTime($dateFin);
        $today = new \DateTime(date('Y-m-d'));

        // Vérifier que la date de début est dans le futur
        if ($debut < $today) {
            return redirect()->back()->with('error', 'La date de début doit être dans le futur.');
        }

        // Vérifier que la date de fin n'est pas avant la date de début
        if ($fin < $debut) {
            return redirect()->back()->with('error', 'La date de fin doit être après la date de début.');
        }

        // Calculer le nombre de jours
        $interval = $debut->diff($fin);
        $nbJours = $interval->days + 1;

        // Vérifier le solde disponible
        $soldeModel = new \App\Models\SoldeModel();
        $solde = $soldeModel
            ->where('employe_id', $userId)
            ->where('type_conge_id', $typeCongeId)
            ->first();

        if (!$solde || $solde['solde'] < $nbJours) {
            $soldeDisponible = $solde ? $solde['solde'] : 0;
            return redirect()->back()->with('error', "Solde insuffisant. Vous n'avez que $soldeDisponible jour(s) disponible(s).");
        }

        // Vérifier s'il y a un chevauchement avec un autre congé
        $existant = $this->congeModel
            ->where('employe_id', $userId)
            ->whereIn('statut', ['en_attente', 'approuvee'])
            ->groupStart()
                ->whereIn('date_debut', '>=', $dateDebut)
                ->whereIn('date_debut', '<=', $dateFin)
            ->groupEnd()
            ->orGroupStart()
                ->where('date_fin >=', $dateDebut)
                ->where('date_fin <=', $dateFin)
            ->groupEnd()
            ->first();

        if ($existant) {
            return redirect()->back()->with('error', 'Une demande de congé existe déjà pour cette période.');
        }

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

    public function annulerConge($id)
    {
        $userId = session()->get('id');
        $conge = $this->congeModel->find($id);

        if (!$conge) {
            return redirect()->back()->with('error', 'Congé non trouvé.');
        }

        // Vérifier que le congé appartient à l'employé connecté
        if ($conge['employe_id'] != $userId) {
            return redirect()->back()->with('error', 'Vous ne pouvez annuler que vos propres congés.');
        }

        // Seuls les congés en attente peuvent être annulés sans recrédit
        // Les congés approuvés peuvent être annulés et recréditent les soldes
        if ($conge['statut'] === 'en_attente') {
            $this->congeModel->update($id, ['statut' => 'annulee']);
            return redirect()->back()->with('success', 'Congé annulé.');
        } elseif ($conge['statut'] === 'approuvee') {
            // Recrédit des soldes
            $employeModel = new \App\Models\EmployeModel();
            $soldeModel = new \App\Models\SoldeModel();

            $solde = $soldeModel
                ->where('employe_id', $conge['employe_id'])
                ->where('type_conge_id', $conge['type_conge_id'])
                ->first();
            
            if ($solde) {
                $newSolde = $solde['solde'] + $conge['nb_jours'];
                $soldeModel->update($solde['id'], ['solde' => $newSolde]);
            }

            $this->congeModel->update($id, ['statut' => 'annulee']);
            return redirect()->back()->with('success', 'Congé annulé et solde recrédit.');
        }

        return redirect()->back()->with('error', 'Seuls les congés en attente ou approuvés peuvent être annulés.');
    }
}