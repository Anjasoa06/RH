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

// Routes protégées avec filtre auth
$routes->group('', ['filter' => 'auth'], function($routes) {
    // Employé
    $routes->get('/employe', 'EmployeController::index');
    $routes->get('/employe/create', 'EmployeController::create');
    $routes->post('/employe/create', 'EmployeController::store');
    $routes->get('/employe/demandes', 'EmployeController::demandes');
    $routes->get('/employe/profil', 'EmployeController::profil');
    $routes->post('/employe/changerMotDePasse', 'EmployeController::changerMotDePasse');
    
    // RH
    $routes->get('/rh', 'RhController::index');
    $routes->get('/rh/demandes', 'RhController::index');
    $routes->get('/rh/traiter/(:alpha)/(:num)', 'RhController::traiter/$1/$2');
    $routes->get('/rh/historique', 'RhController::historique');
    $routes->get('/rh/soldes', 'RhController::soldes');
    
    // Admin
    $routes->get('/admin', 'AdminController::index');
    $routes->get('/admin/employes', 'AdminController::employes');
    $routes->get('/admin/demandes', 'AdminController::demandes');
    $routes->get('/admin/departements', 'AdminController::departements');
    $routes->get('/admin/types-conge', 'AdminController::typesCongé');
    $routes->get('/admin/soldes', 'AdminController::soldes');
});