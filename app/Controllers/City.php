<?php

namespace App\Controllers;

use App\Controllers\BaseController;
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

    public function getAll()
    {
        $page = $this->request->getGet('page') ?? 1;
        $fromdate = $this->request->getGet('fromdate');
        $todate = $this->request->getGet('todate');
        $search = $this->request->getGet('search');
        $perPage = 10;
        $data = $this->cityModel->datatable($perPage, $page, $fromdate, $todate, $search);
        return $this->response->setJSON($data);
    }

    public function add()
    {
        $cityname = $this->request->getPost('cityname');
        $isactive = $this->request->getPost('isactive');
        $this->db->transBegin();
        try {
            if (empty($cityname)) {
                return $this->response->setJSON(['pesan' => 'Data city dibutuhkan', 'sukses' => 0]);
            }
            $data = [
                'cityname' => $cityname,
                'isactive' => $isactive,
                'createddate' => date('Y-m-d H:i:s'),
                'createdby' => 2,
            ];
            $this->cityModel->store($data);
            $this->db->transCommit();
            return $this->response->setJSON(['pesan' => 'Data has been saved successfully', 'sukses' => 1, 'Data' => $data]);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON(['error' => $e->getMessage(), 'sukses' => 0]);
        }
    }

    public function update()
    {
        $cityid = $this->request->getPost('cityid');
        $cityname = $this->request->getPost('cityname');
        $isactive = $this->request->getPost('isactive');
        $this->db->transBegin();
        try {
            $data = [
                'cityname' => $cityname,
                'isactive' => $isactive,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => 2,
            ];
            $this->cityModel->edit($data, $cityid);
            $this->db->transCommit();
            return $this->response->setJSON(['pesan' => 'Data has been saved successfully', 'sukses' => 1,  'Data' => $data]);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON(['error' => $e->getMessage(), 'sukses' => 0]);
        }
    }

    public function delete($id)
    {
        $id = $this->request->getPost('id');
        $this->db->transBegin();
        try {
            $urlname = $this->cityModel->getImageUrl($id);
            if (!empty($urlname->image)) {
                unlink(WRITEPATH . 'uploads/' . $urlname->image);
            }
            $this->cityModel->destroy($id);
            $this->db->transCommit();
            return $this->response->setJSON(['pesan' => 'Data has been deleted successfully', 'sukses' => 1]);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON(['error' => $e->getMessage(), 'sukses' => 0]);
        }
    }

    public function deleteImage($id)
    {
        $id = $this->request->getPost('id');
        $this->db->transBegin();
        try {
            $urlname = $this->cityModel->getImageUrl($id);
            if (!empty($urlname->image)) {
                unlink(WRITEPATH . 'uploads/' . $urlname->image);
            }
            $data = [
                'image' => null,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => 2,
            ];
            $this->cityModel->edit($data, $id);
            $this->db->transCommit();
            return $this->response->setJSON(['pesan' => 'Data has been deleted successfully', 'sukses' => 1]);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON(['error' => $e->getMessage(), 'sukses' => 0]);
        }
    }

    // public function uploadImage()
    // {
    //     $file = $this->request->getFile('file');
    //     $id = $this->request->getPost('id');
    //     $this->db->transBegin();
    //     try {
    //         $newName = $file->getName();
    //         $file->move('writable/uploads', $newName);
    //         $data = [
    //             'image' => $newName,
    //             'updateddate' => date('Y-m-d H:i:s'),
    //             'updatedby' => 2,
    //         ];
    //         $this->cityModel->edit($data, $id);
    //         $this->db->transCommit();
    //         return $this->response->setJSON(['pesan' => 'Data has been saved successfully', 'sukses' => 1]);
    //     } catch (Exception $e) {
    //         $this->db->transRollback();
    //         return $this->response->setJSON(['error' => $e->getMessage(), 'sukses' => 0]);
    //     }
    // }

    public function uploadChunk()
    {
        $id = $this->request->getPost('id');
        $file = $this->request->getFile('file');
        $this->db->transBegin();
        try {

            if (!$file->isValid()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid file']);
            }
            $urlname = $this->cityModel->getImageUrl($id);
            if (!empty($urlname->image)) {
                unlink(WRITEPATH . 'uploads/' . $urlname->image);
            }

            $fileName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads/', $fileName);

            $data = [
                'image' => $fileName,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => 2,
            ];
            $this->cityModel->edit($data, $id);
            $this->db->transCommit();
            return $this->response->setJSON(['status' => 'success', 'file' => $fileName]);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
