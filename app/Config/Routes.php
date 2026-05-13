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
    $routes->get('/employe/demandes', 'EmployeController::demandes');
    $routes->get('/employe/profil', 'EmployeController::profil');
    
    // RH
    $routes->get('/rh', 'RhController::index');
    $routes->get('/rh/demandes', 'RhController::index');
    
    // Admin
    $routes->get('/admin', 'AdminController::index');
    $routes->get('/admin/employes', 'AdminController::employes');
});