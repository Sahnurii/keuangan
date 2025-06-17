<?php

require_once 'Controller.php';

class BaseController extends Controller
{
    protected $allowedRoles = [];

    public function __construct()
    {
        parent::__construct(); // load model, view, dsb kalau ada

        AuthMiddleware::isAuthenticated();

        if (!empty($this->allowedRoles)) {
            AuthMiddleware::requireRole($this->allowedRoles);
        }
    }
}
