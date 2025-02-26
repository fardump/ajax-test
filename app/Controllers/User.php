<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Muser;
use Exception;

class User extends BaseController
{

    protected $userModel;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->userModel = new Muser();
    }
    public function index()
    {

        $data = [
            'title' => 'user',
            'user' => $this->userModel->findAll()
        ];
        return view('master/user/v_user', $data);
    }

    public function deleteUsers()
    {
        $id = $this->request->getPost('id');

        if ($this->userModel->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Berhasil Dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data Gagal Dihapus'
            ]);
        }
    }

    public function add()
    {

        $validation = $this->validate([
            'username' => 'required|min_length[3]|max_length[255]',
            'isactive' => 'required|in_list[0,1]',
        ]);
        if (!$validation) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $Data = [
            'username' => $this->request->getPost('username'),
            'isactive' => $this->request->getPost('isactive'),
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => '1',
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => '1'
        ];

        $this->userModel->insert($Data);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan!',
            'data' => $Data,
        ]);
    }
}
