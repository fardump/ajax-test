<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Mcategory;
use Exception;

class Category extends BaseController {

    protected $categoryModel;
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->categoryModel = new Mcategory();
    }
    public function index(){
$data =[
    'title' => 'Category',
];
return view('master/category/v_category', $data);
    }
}
?>