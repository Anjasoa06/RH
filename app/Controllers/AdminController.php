<?php

namespace App\Controllers;

use App\Models\EmployeModel;
use App\Models\DepartementModel;
use App\Models\TypeCongeModel;
use App\Models\CongeModel;
use App\Models\SoldeModel;

class AdminController extends BaseController
{
    protected $employeModel;
    protected $departementModel;
    protected $typeCongeModel;
    protected $congeModel;
    protected $soldeModel;

    public function __construct()
    {
        $this->employeModel = new EmployeModel();
        $this->departementModel = new DepartementModel();
        $this->typeCongeModel = new TypeCongeModel();
        $this->congeModel = new CongeModel();
        $this->soldeModel = new SoldeModel();
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
        
        $departements = $this->departementModel->findAll();

        $data = [
            'title' => 'Gestion des employés',
            'breadcrumb' => 'Admin / Employés',
            'employes' => $employes,
            'departements' => $departements,
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

    // EMPLOYÉS CRUD
    public function storeEmploye()
    {
        $nom = $this->request->getPost('nom');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $departement_id = $this->request->getPost('departement_id');
        $role = $this->request->getPost('role');

        // Validation basique
        if (empty($nom) || empty($email) || empty($password) || empty($departement_id) || empty($role)) {
            return redirect()->back()->with('error', 'Tous les champs sont requis')->withInput();
        }

        // Vérifier que l'email n'existe pas déjà
        $existing = $this->employeModel->where('email', $email)->first();
        if ($existing) {
            return redirect()->back()->with('error', 'Cet email existe déjà')->withInput();
        }

        // Créer l'employé
        $employe_id = $this->employeModel->insert([
            'nom' => $nom,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'departement_id' => $departement_id,
            'role' => $role,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        if (!$employe_id) {
            return redirect()->back()->with('error', 'Erreur lors de la création de l\'employé')->withInput();
        }

        // Initialiser les soldes pour tous les types de congé
        $types = $this->typeCongeModel->findAll();
        foreach ($types as $type) {
            $this->soldeModel->insert([
                'employe_id' => $employe_id,
                'type_conge_id' => $type['id'],
                'solde' => $type['jours_par_an'],
            ]);
        }

        return redirect()->to('/admin/employes')->with('success', 'Employé créé avec succès! Email: ' . $email);
    }

    public function editEmploye($id)
    {
        $employe = $this->employeModel->find($id);
        $departements = $this->departementModel->findAll();

        $data = [
            'title' => 'Modifier l\'employé',
            'breadcrumb' => 'Admin / Employés / Modifier',
            'employe' => $employe,
            'departements' => $departements,
        ];
        return view('admin/employe-edit', $data);
    }

    public function updateEmploye($id)
    {
        $nom = $this->request->getPost('nom');
        $email = $this->request->getPost('email');
        $departement_id = $this->request->getPost('departement_id');
        $role = $this->request->getPost('role');

        $this->employeModel->update($id, [
            'nom' => $nom,
            'email' => $email,
            'departement_id' => $departement_id,
            'role' => $role,
        ]);

        return redirect()->to('/admin/employes')->with('success', 'Employé modifié avec succès');
    }

    public function deleteEmploye($id)
    {
        $this->employeModel->delete($id);
        return redirect()->to('/admin/employes')->with('success', 'Employé supprimé avec succès');
    }

    // DÉPARTEMENTS CRUD
    public function storeDepartement()
    {
        $nom = $this->request->getPost('nom');

        $this->departementModel->insert([
            'nom' => $nom,
        ]);

        return redirect()->to('/admin/departements')->with('success', 'Département créé avec succès');
    }

    public function editDepartement($id)
    {
        $departement = $this->departementModel->find($id);

        $data = [
            'title' => 'Modifier le département',
            'breadcrumb' => 'Admin / Départements / Modifier',
            'departement' => $departement,
        ];
        return view('admin/departement-edit', $data);
    }

    public function updateDepartement($id)
    {
        $nom = $this->request->getPost('nom');

        $this->departementModel->update($id, [
            'nom' => $nom,
        ]);

        return redirect()->to('/admin/departements')->with('success', 'Département modifié avec succès');
    }

    public function deleteDepartement($id)
    {
        $this->departementModel->delete($id);
        return redirect()->to('/admin/departements')->with('success', 'Département supprimé avec succès');
    }

    // TYPES DE CONGÉ CRUD
    public function storeTypeCongé()
    {
        $nom = $this->request->getPost('nom');
        $jours_par_an = $this->request->getPost('jours_par_an');

        $type_id = $this->typeCongeModel->insert([
            'nom' => $nom,
            'jours_par_an' => $jours_par_an,
        ]);

        // Initialiser les soldes pour tous les employés existants
        $employes = $this->employeModel->findAll();
        foreach ($employes as $employe) {
            $this->soldeModel->insert([
                'employe_id' => $employe['id'],
                'type_conge_id' => $type_id,
                'solde' => $jours_par_an,
            ]);
        }

        return redirect()->to('/admin/types-conge')->with('success', 'Type de congé créé et soldes initialisés pour tous les employés');
    }

    public function editTypeCongé($id)
    {
        $type = $this->typeCongeModel->find($id);

        $data = [
            'title' => 'Modifier le type de congé',
            'breadcrumb' => 'Admin / Types de congé / Modifier',
            'type' => $type,
        ];
        return view('admin/type-conge-edit', $data);
    }

    public function updateTypeCongé($id)
    {
        $nom = $this->request->getPost('nom');
        $jours_par_an = $this->request->getPost('jours_par_an');

        $this->typeCongeModel->update($id, [
            'nom' => $nom,
            'jours_par_an' => $jours_par_an,
        ]);

        return redirect()->to('/admin/types-conge')->with('success', 'Type de congé modifié avec succès');
    }

    public function deleteTypeCongé($id)
    {
        $this->typeCongeModel->delete($id);
        return redirect()->to('/admin/types-conge')->with('success', 'Type de congé supprimé avec succès');
    }
}