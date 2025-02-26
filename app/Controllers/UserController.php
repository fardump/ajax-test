<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    protected $userModel;

    public function index()
    {
        $data['users'] = $this->userModel->findAll();
        return view('MSUser/index', $data);
    }
}
