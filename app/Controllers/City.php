<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Mcity;
use Exception;

class City extends BaseController
{

    protected $cityModel;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->cityModel = new Mcity();
    }
    public function index()
    {
        $data = [
            'title' => 'City',
        ];  
        return view('master/city/v_city', $data);
    }

    public function form()
    {
        return view('master/city/v_form', $data);
    }
}
