<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Mtype;
use Exception;

class Type extends BaseController {

    protected $typeModel;
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->typeModel = new Mtype();
    }
    public function index(){
$data =[
    'title' => 'Province',
];
return view('master/type/v_type', $data);
    }
}
?>