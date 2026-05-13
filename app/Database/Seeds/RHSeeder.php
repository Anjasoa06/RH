<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RHSeeder extends Seeder
{
    public function run()
    {
        
        $this->db->table('departements')->insertBatch([
            ['nom' => 'Informatique'],
            ['nom' => 'Ressources Humaines'],
            ['nom' => 'Commercial'],
            ['nom' => 'Comptabilité'],
        ]);

       
        $this->db->table('types_conge')->insertBatch([
            ['nom' => 'Congé payé', 'jours_par_an' => 30],
            ['nom' => 'Congé maladie', 'jours_par_an' => 10],
            ['nom' => 'Congé sans solde', 'jours_par_an' => 0],
        ]);


        $this->db->table('employes')->insertBatch([
            [
                'nom' => 'Admin User',
                'email' => 'admin@rh.mg',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'departement_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nom' => 'RH Manager',
                'email' => 'rh@rh.mg',
                'password' => password_hash('rh123', PASSWORD_DEFAULT),
                'role' => 'rh',
                'departement_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nom' => 'Jean Dupont',
                'email' => 'jean@rh.mg',
                'password' => password_hash('employe123', PASSWORD_DEFAULT),
                'role' => 'employe',
                'departement_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nom' => 'Marie Martin',
                'email' => 'marie@rh.mg',
                'password' => password_hash('employe123', PASSWORD_DEFAULT),
                'role' => 'employe',
                'departement_id' => 3,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ]);

        $employes = [1, 2, 3, 4];
        $typesConge = [
            ['id' => 1, 'jours' => 30],  // Congé payé
            ['id' => 2, 'jours' => 10],  // Congé maladie
            ['id' => 3, 'jours' => 0],   // Congé sans solde
        ];

        foreach ($employes as $employeId) {
            foreach ($typesConge as $type) {
                $this->db->table('soldes')->insert([
                    'employe_id' => $employeId,
                    'type_conge_id' => $type['id'],
                    'solde' => $type['jours'],
                ]);
            }
        }
    }
}