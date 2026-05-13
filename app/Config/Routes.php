<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Routes publiques
$routes->get('/', 'AuthController::loginForm');
$routes->get('/login', 'AuthController::loginForm');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');

// Routes pour les Employés
$routes->group('', ['filter' => 'auth:employe'], function($routes) {
    $routes->get('/employe', 'EmployeController::index');
    $routes->get('/employe/create', 'EmployeController::create');
    $routes->post('/employe/create', 'EmployeController::store');
    $routes->get('/employe/demandes', 'EmployeController::demandes');
    $routes->get('/employe/annuler/(:num)', 'EmployeController::annulerConge/$1');
    $routes->get('/employe/profil', 'EmployeController::profil');
    $routes->post('/employe/changerMotDePasse', 'EmployeController::changerMotDePasse');
});

// Routes pour les RH
$routes->group('', ['filter' => 'auth:rh'], function($routes) {
    $routes->get('/rh', 'RhController::index');
    $routes->get('/rh/demandes', 'RhController::index');
    $routes->get('/rh/traiter/(:alpha)/(:num)', 'RhController::traiter/$1/$2');
    $routes->get('/rh/annuler/(:num)', 'RhController::annuler/$1');
    $routes->get('/rh/historique', 'RhController::historique');
    $routes->get('/rh/soldes', 'RhController::soldes');
});

// Routes pour les Administrateurs
$routes->group('', ['filter' => 'auth:admin'], function($routes) {
    // Admin Dashboard
    $routes->get('/admin', 'AdminController::index');
    
    // Employés CRUD
    $routes->get('/admin/employes', 'AdminController::employes');
    $routes->post('/admin/employes', 'AdminController::storeEmploye');
    $routes->get('/admin/employes/edit/(:num)', 'AdminController::editEmploye/$1');
    $routes->post('/admin/employes/update/(:num)', 'AdminController::updateEmploye/$1');
    $routes->get('/admin/employes/delete/(:num)', 'AdminController::deleteEmploye/$1');
    
    // Départements CRUD
    $routes->get('/admin/departements', 'AdminController::departements');
    $routes->post('/admin/departements', 'AdminController::storeDepartement');
    $routes->get('/admin/departements/edit/(:num)', 'AdminController::editDepartement/$1');
    $routes->post('/admin/departements/update/(:num)', 'AdminController::updateDepartement/$1');
    $routes->get('/admin/departements/delete/(:num)', 'AdminController::deleteDepartement/$1');
    
    // Types de congé CRUD
    $routes->get('/admin/types-conge', 'AdminController::typesCongé');
    $routes->post('/admin/types-conge', 'AdminController::storeTypeCongé');
    $routes->get('/admin/types-conge/edit/(:num)', 'AdminController::editTypeCongé/$1');
    $routes->post('/admin/types-conge/update/(:num)', 'AdminController::updateTypeCongé/$1');
    $routes->get('/admin/types-conge/delete/(:num)', 'AdminController::deleteTypeCongé/$1');
    
    // Admin Reports
    $routes->get('/admin/demandes', 'AdminController::demandes');
    $routes->get('/admin/soldes', 'AdminController::soldes');
});