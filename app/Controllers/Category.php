<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use Config\Services;

class Category extends BaseController
{
    protected $officeModel;
    public $request;
   
    protected $session;
    protected $data_session;

    public function __construct()
    {
        $this->request = Services::request();
        $this->officeModel = new CategoryModel($this->request);

        $this->session = session(); 
        $this->data_session = array(
            "title"=>$this->session->get('name')." -  ". $this->session->get('rolename'),
            "id"=>$this->session->get('id'),
            "name"=>$this->session->get('name'),
        );
    }


    public function index()
    {
        $data = array(
            "header"=> $this->data_session,
            "title"=>"Data Category",
            "css"=> global_css(),
            "extends_css"=>datatablescss(),
            "js"=>global_js(),
            "extends_js"=>array_merge(
                    array(
                        "/js/category.js",
                    ),
                    datatablesjs_js()

                ),
            "view"=>"datamaster/category/category"
        );
        return view('index',$data);
    }

    public function data()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->officeModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            

            foreach ($lists as $list) {
               
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->name;
                $row[] = $list->code;
                $data[] = $row;

             
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->officeModel->countAll(),
                'recordsFiltered' => $this->officeModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
   
}
