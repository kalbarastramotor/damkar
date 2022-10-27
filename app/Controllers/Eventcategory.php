<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\EventcategoryModel;
use Config\Services;

class Eventcategory extends BaseController
{
    public function __construct()
    {
        $this->request = Services::request();
        $this->EventcategoryModel = new EventcategoryModel($this->request);
        $this->session = session();
        $this->data_session = array(
            "title" => $this->session->get('name') . " -  " . $this->session->get('rolename'),
            "id" => $this->session->get('id'),
            "name" => $this->session->get('name'),

        );
    }

    // Table
    public function index()
    {
        $data = array(
            "header" => $this->data_session,
            "title" => "Event Category",
            "css" => global_css(),
            "extends_css" => datatablescss(),
            "js" => global_js(),
            "extends_js" => array_merge(
                array(
                    "/js/eventcategory.js",
                ),
                datatablesjs_js()

            ),
            "view" => "datamaster/eventcategory/eventcategory"
        );
        return view('index', $data);
    }

    // Get Data Table
    public function data()
    {


        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->EventcategoryModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');


            foreach ($lists as $list) {

                $btnEdit = '<button type="button" class="btn btn-soft-primary waves-effect waves-light" 
                id="edit_eventcategory_' . $list->id . '"
                onclick="edit_eventcategory(' . $list->id . ',this.id)" 
                id="' . $list->id . '" 
                name="' . $list->name . '" 
                code="' . $list->code . '"
                ><i class="bx bx-edit-alt font-size-16 align-middle"></i></button>';

                $btnDelete = '<button type="button" class="btn btn-soft-danger waves-effect waves-light"  onclick="delete_eventcategory(' . $list->id . ',\'' . $list->name . '\')"><i  class="bx bx-trash-alt font-size-16 align-middle"></i></button>';

                $button =

                    '<div class="d-flex flex-wrap gap-2">  
                    ' . $btnEdit . '     
                    ' . $btnDelete . '    
                    </div>';

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->name;
                $row[] = $list->code;
                $row[] = $button;
                $data[] = $row;
            }


            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->EventcategoryModel->countAll(),
                'recordsFiltered' => $this->EventcategoryModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    // function save()
    // {
    //     // print_r($_POST);
    //     // die();
    //     $hasil = $this->EventcategoryModel->insert($_POST);
    //     if ($hasil != 0) {
    //         successJsonResponse($hasil);
    //     } else {
    //         failedJsonResponse($hasil);
    //     }
    // }

    public function save()
    {

        if (count($_POST) == 0) {
            failedJsonResponse(false);
        }


        $data = array(
            'id' => $_POST['id'],
            'name' => $_POST['name'],
            'code' => $_POST['code'],
        );
        if ($_POST['menuid'] == "") {
            $hasil = $this->EventcategoryModel->insert($data);
        } else {
            $hasil = $this->EventcategoryModel->where('id', $_POST['id'])->set($data)->update();
        }
        $hasil = $this->EventcategoryModel->where('id', $_POST['id'])->set($data)->update();
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }



    function delete()
    {

        $hasil = $this->EventcategoryModel->where('id', $_POST['id'])->delete();
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }

    function edit()
    {
        // print_r($_POST);
        // die();
        $data = array(
            "name" => $_POST['name'],
            "code" => $_POST['code']
        );

        $hasil = $this->EventcategoryModel->where('id', $_POST['id'])->set($data)->edit();
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }

    function selectOption(){
        $hasil = $this->EventcategoryModel->get()->getResult();
        $array = array();
        foreach ($hasil as $key => $value) {
            $array[] = array(
                'id'=>(int)$value->id,
                'text'=>$value->name
            );
        }
        return $this->response->setJSON($array);
    }
  
}
