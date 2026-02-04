<?php

require_once BASE_PATH . 'app/controllers/BaseController.php';

class HomeController extends BaseController
{

    public function index()
    {
        $data = [
            'title' => 'Welcome to CraftWise!',
            'message' => 'Your ultimate destination for building custom PCs.'
        ];
        $this->view('home', $data);
    }
}
