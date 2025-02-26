<?php

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Mcity;
use Exception;

class City extends BaseController
{
class City extends BaseController
{

    protected $cityModel;
    public function __construct()
    {
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
    public function index()
    {
        $data = [
            'title' => 'City',
        ];  
        return view('master/city/v_city', $data);
    }

    public function getAll()
    {
        $data = $this->cityModel->datatable()->get()->getResultArray();
        return $this->response->setJSON(['data' => $data]);
    }

    public function add()
    {
        $cityname = $this->request->getPost('cityname');
        $isactive = $this->request->getPost('isactive');
        $this->db->transBegin();
        try{
            $data = [
                'cityname' => $cityname,
                'isactive' => $isactive,
                'createddate' => date('Y-m-d H:i:s'),
                'createdby' => 2,
            ];
            $this->cityModel->store($data);
            $this->db->transCommit();
            return $this->response->setJSON(['pesan' => 'Data has been saved successfully', 'sukses' => 1, 'Data' => $data]);
        }catch(Exception $e){
            return $this->response->setJSON(['error' => $e->getMessage(), 'sukses' => 0]);
        }
    }

    public function update()
    {
        $cityid = $this->request->getPost('cityid');
        $cityname = $this->request->getPost('cityname');
        $isactive = $this->request->getPost('isactive');
        $this->db->transBegin();
        try{
            $data = [
                'cityname' => $cityname,
                'isactive' => $isactive,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => 2,
            ];
            $this->cityModel->edit($data, $cityid);
            $this->db->transCommit();
            return $this->response->setJSON(['pesan' => 'Data has been saved successfully', 'sukses' => 1,  'Data' => $data]);
        }catch(Exception $e){
            return $this->response->setJSON(['error' => $e->getMessage(), 'sukses' => 0]);
        }
    }

    public function delete($id)
    {
        $id = $this->request->getPost('id');
        $this->db->transBegin();
        try{
            $this->cityModel->destroy($id);
            $this->db->transCommit();
            return $this->response->setJSON(['pesan' => 'Data has been deleted successfully', 'sukses' => 1]);
        }catch(Exception $e){
            return $this->response->setJSON(['error' => $e->getMessage(), 'sukses' => 0]);
        }
    }
}
