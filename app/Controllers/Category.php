<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Mcategory;
use Exception;
use config\Services;
use Fpdf\Fpdf;

class Category extends BaseController
{

    protected $categoryModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->categoryModel = new Mcategory();
    }

    public function index()
    {
        $data = [
            'title' => 'Category',
        ];

        return view('master/category/v_category', $data);
    }

    public function table()
    {
        $page = $this->request->getVar('page') ?? 1;
        $startdate = $this->request->getVar('min');
        $enddate = $this->request->getVar('max');
        $search = $this->request->getVar('search');
        $limit = 8;

        $result = $this->categoryModel->datatable($limit, $startdate, $enddate, $search, $page);

        $pager = \Config\Services::pager();
        $pager->makeLinks($page, $limit, $result['total'], 'category_pagination');

        return $this->response->setJSON([
            'data' => $result['data'],
            'pager' => $pager->links(),
        ]);
    }

    public function add()
    {
        $nama = $this->request->getPost('nama');
        $isactive = $this->request->getPost('isactive') ? 1 : 0;

        $this->db->transbegin();

        try {

            if (empty($nama)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Nama Tidak Boleh Kosong']);
            }

            $data = [
                'catname' => $nama,
                'isactive' => $isactive,
                'createddate' => date('Y-m-d H:i:s'),
                'createdby' => '1',
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => '1'
            ];

            $this->categoryModel->store($data);
            $this->db->transcommit();
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Ditambahkan']);
        } catch (\Throwable $th) {
            $this->db->transrollback();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Ditambahkan']);
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');

        $this->db->transbegin();

        try {
            $this->categoryModel->delete($id);
            $this->db->transcommit();
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Dihapus']);
        } catch (\Throwable $th) {
            $this->db->transrollback();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Dihapus']);
        }
    }

    public function updateCategory($id)
    {

        $nama = $this->request->getPost('catname');

        $this->db->transbegin();

        try {

            if (empty($nama)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Nama Tidak Boleh Kosong']);
            };

            $data = [
                'catname' => $nama
            ];

            $this->categoryModel->editname($data, $id);
            $this->db->transcommit();
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Diupdate']);
        } catch (\Throwable $th) {
            $this->db->transrollback();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal DiUpdate']);
        }
    }

    public function updateCheck($id)
    {
        $isactie = $this->request->getPost('isactive');

        $this->db->transBegin();

        try {

            $data = [
                'isactive' => $isactie,
            ];

            $this->categoryModel->updateCheck($id, $data);
            $this->db->transCommit();
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Diupdate']);
        } catch (\Throwable $th) {
            $this->db->transRollback();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Diupdate']);
        }
    }

    public function print()
    {
        $pdf = new FPDF();

        $pdf->SetTitle('Print Data');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Image('public/category/emindo_logo.jpeg', $pdf->GetX() + 5, $pdf->GetY() + -1, 25);
        $pdf->Cell(35, 24, '', 1, 0, 'C'); 
        $pdf->Cell(85, 24, 'FORM LAPORAN KELUHAN PELANGGAN', 1, 0, 'C'); 

        // Kolom detail di kanan
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(20, 6, 'Dokumen ', 1, 0, 'L'); 
        $pdf->Cell(25, 6, '04.1.FRM-MKT ', 1, 0, 'L'); 
        $pdf->MultiCell(25, 3, 'Disetujui oleh : Manager Mutu', 1, 'C'); 
        $pdf->SetX(130); 
        $pdf->Cell(20, 6, 'Revisi ', 1, 0, 'L'); 
        $pdf->Cell(25, 6, '001 ', 1, 0, 'L'); 
        $pdf->Cell(25, 6, ' ', 'R', 1, 'L'); 
        $pdf->SetX(130); 
        $pdf->Cell(20, 6, 'Tanggal Terbit', 1, 0, 'L'); 
        $pdf->Cell(25, 6, '12 October 2022', 1, 0, 'L'); 
        $pdf->Cell(25, 6, '', 'R', 1 , 'L'); 
        $pdf->SetX(130);
        $pdf->Image('public/category/ttd-header.png', $pdf->GetX() + 46, $pdf->GetY() + -11, 23);
        $pdf->Cell(20, 6, 'Halaman', 1, 0, 'L');
        $pdf->Cell(25, 6, '1', 1, 0, 'L');
        $pdf->Cell(25, 6, 'Winna Oktavia P.', 1, 1, 'L');

        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 13);
        $pdf->Cell(0, 10, 'Laporan Keluhan Pelanggan', 0, 0, 'C');
        $pdf->Ln(20);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30, 7, 'No Keluhan', 0, 0, 'L');
        $pdf->Cell(5, 7, ':', 0, 0, 'L');
        $pdf->Cell(30, 7, '085/MKT-EMINDO/III/2025 ', 0, 1, '');
        $pdf->Cell(30, 7, 'Nama Customer', 0, 0, 'L');
        $pdf->Cell(5, 7, ': ', 0, 0, 'L');
        $pdf->Cell(30, 7, 'RUMAH SAKIT UMUM DAERAH KRAMAT JATI ', 0, 1, '');
        $pdf->Cell(30, 7, 'Nama Pemohon', 0, 0, 'L');
        $pdf->Cell(5, 7, ': ', 0, 0, 'L');
        $pdf->Cell(30, 7, 'Firman ' , 0, 1, '');
        $pdf->Cell(30, 7, 'Telp', 0, 0, 'L');
        $pdf->Cell(5, 7, ': ', 0, 0, 'L');
        $pdf->Cell(30, 7, '081338577270 ', 0, 1, '');
        $pdf->Cell(30, 7, 'Alamat', 0, 0, 'L');
        $pdf->Cell(5, 7, ': ', 0, 0, 'L');
        $pdf->Cell(30, 7, 'Jl Raya Inpres No 48 ', 0, 1, '');

        $pdf->Ln(10);
        
        $pdf->MultiCell(0, 5, 'Deskripsi : 
Uap nebulizer tidak keluar, informasi teknisi motor pompa sudah lemah', 1, 'L');
        $pdf->MultiCell(0, 5, 'Hasil Laporan : 
New Data', 1, 'L');

        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C');
        $pdf->Cell(50, 8, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(20, 8, 'UOM', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Kuantitas', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Serial number', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Status', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Deskripsi', 1, 1, 'C');

        $pdf->setFont('arial', '', 8);
        $pdf->setXY(10, 135);
        $pdf->Cell(10, 10, '1', 1, 0, 'C');
        $pdf->MultiCell(50, 5, 'Elitech - INDONESIA MEDICAL NEBULIZER PROMIST 3', 1, 'L');
        $pdf->setXY(70, 135);
        $pdf->Cell(20, 10, 'Unit', 1, 0, 'L');
        $pdf->Cell(20, 10, '1', 1, 0, 'C');
        $pdf->Cell(30, 10, 'MN009324212', 1, 0, 'L');
        $pdf->Cell(20, 10, 'Bergaransi', 1, 0, 'L');
        $pdf->Cell(40, 10, '', 1, 0, 'L');
        
        $pdf->Ln(15);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(40, 5, 'Jakarta 10 Maret 2025 
        Diterima oleh,
        ', 0);
        $pdf->Image('public/category/ttd.png', $pdf->GetX() + 5, $pdf->GetY() + -5, 25);
        $pdf->Ln(20);
        $pdf->Cell(20, 5, 'DIAN MEDIANA', 0, 1, 'L');
        
        $pdf->Output();
        exit;
    }
}
