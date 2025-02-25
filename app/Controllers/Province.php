<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Mprovince;
use Exception;

class Province extends BaseController {

    protected $provinceModel;
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->provinceModel = new Mprovince();
    }
    public function index(){
$data =[
    'title' => 'Province',
];
return view('master/province/v_province', $data);
    }
}
?>