<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Mtype;
use Exception;

class Type extends BaseController
{

    protected $typeModel;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->typeModel = new Mtype();
    }
    public function index()
    {
        $data = [
            'title' => 'Province',
            'type' => $this->typeModel->findAll()
        ];
        return view('master/type/v_type', $data);
    }

    public function save()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'typename' => 'required',
            'isactive' => 'required',
        ]);
        
        $data = [
            'typename' => $this->request->getPost('typename'),
            'isactive' => $this->request->getPost('isactive') == '1' ? '1' : '0',
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => '1',
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => '1',
        ];
        $this->typeModel->saveType($data);
        return view('master/type/v_type', $data);
    }

    public function delete()
    {
        $id = $this->request->getPost('typeid');
        if (empty($typeid)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID Tidak Boleh Kosong']);
        }

        if ($this->typeModel->delete($typeid)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Dihapus']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Dihapus']);
        }
    }

    public function edit($typeid)
    {
        $data = $this->typeModel->find($typeid);
        if (empty($data)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Tidak Ditemukan']);
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $data]);
    }
}

