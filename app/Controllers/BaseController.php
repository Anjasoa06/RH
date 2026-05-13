<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    /**
     * Instance de la classe Request.
     *
     * @var \CodeIgniter\HTTP\IncomingRequest
     */
    protected $request;

    /**
     * Constructeur.
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.:
        // $this->session = \Config\Services::session();
    }
}
