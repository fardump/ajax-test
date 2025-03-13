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
        $fileName = $this->request->getPost('fileName');
        $totalChunks = (int) $this->request->getPost('totalChunks');
        $chunkIndex = (int) $this->request->getPost('chunkIndex'); 
        $chunkData = $this->request->getFile('file');

        if (!$chunkData->isValid()) {
            return $this->response->setJSON(['status' => 'error', 'pesan' => 'Chunk upload failed']);
        }

        $uploadPath = WRITEPATH . 'uploads/'; 
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $oldimage = $this->cityModel->getImageUrl($id);
        if (!empty($oldimage->image)) {
            unlink(WRITEPATH . 'uploads/' . $oldimage->image);
        }

        $chunkPath = $uploadPath . $fileName . '_chunk_' . $chunkIndex;

        $chunkData->move($uploadPath, $fileName . '_chunk_' . $chunkIndex);

        $uploadedChunks = glob($uploadPath . $fileName . '_chunk_*');

        if (count($uploadedChunks) == $totalChunks) {
            $finalFilePath = $uploadPath . $fileName;
            $finalFile = fopen($finalFilePath, 'wb');

            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkFile = $uploadPath . $fileName . '_chunk_' . $i;

                if (file_exists($chunkFile)) {
                    $chunkContent = file_get_contents($chunkFile);
                    fwrite($finalFile, $chunkContent);
                    unlink($chunkFile); 
                }
            }

            fclose($finalFile);
            $data = [
                'image' => $fileName,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => 2,
            ];
            $this->cityModel->edit($data, $id);
        }

        return $this->response->setJSON(['status' => 'progress', 'pesan' => 'Chunk uploaded successfully']);
    }
}
