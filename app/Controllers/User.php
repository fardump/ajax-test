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
            'title' => 'User',
            'user' => $this->userModel->findAll()
        ];
        return view('master/user/v_user', $data);
    }

    public function deleteUsers($id)
    {
        $deleted = $this->userModel->delete($id);

        if ($deleted) {
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
    public function loadTable()
    {
        $data = $this->userModel->findAll();
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function update()
    {

        $userid = $this->request->getPost('userid');
        $username = $this->request->getPost('username');
        $isactive = $this->request->getPost('isactive');

        $data = [
            'username' => $username,
            'isactive' => $isactive,
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => '1'
        ];

        if ($this->userModel->update($userid, $data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data has been saved '
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update username'
            ]);
        }
    }
}
