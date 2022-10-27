<?php

namespace App\Controllers;

use App\Models\ProvinceModel;
use App\Models\ReportBtlModel;
use App\Models\OfficeModel;
use Config\Services;



class Report extends BaseController
{

    public function __construct()
    {
        $this->request = Services::request();
        $this->provinceModel = new ProvinceModel($this->request);
        $this->officeModel = new OfficeModel($this->request);
        $this->btlModel = new ReportBtlModel($this->request);

        $this->session = session(); 
        $this->data_session = array(
            "title"=>$this->session->get('name')." -  ". $this->session->get('rolename'),
            "id"=>$this->session->get('id'),
            "name"=>$this->session->get('name'),
        );

     
    }
    public function btl()
    {
        $data = array(
            "header"=> $this->data_session,
            "title"=>"Report BTL Target",
            "css"=> global_css(),
            "extends_css"=>datatablescss(),
            "js"=>global_js(),
            "extends_js"=>array_merge(
                    array(
                        "/js/report.js",
                    ),
                    datatablesjs_js()

                ),
            "view"=>"report/btl-target"
        );
        return view('index',$data);
    }

    public function data_btl()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->btlModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            
            foreach ($lists as $list) {

                $button = '<div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-soft-success waves-effect waves-light"  data-bs-toggle="modal" data-bs-target="#myModal-maps"><i class="bx bx-map-pin font-size-16 align-middle"></i></button>     
                    <button type="button" class="btn btn-soft-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal"><i class="bx bx-edit-alt font-size-16 align-middle"></i></button>
                    <button type="button" class="btn btn-soft-danger waves-effect waves-light"  onclick="delete_dealer('.$list->officeid.',\''.$list->office_name.'\')"><i  class="bx bx-trash-alt font-size-16 align-middle"></i></button>
                    </div>';
                $no++;
                $row = [];
                $row[] = $list->office_group;
                $row[] = $list->office_code;
                $row[] = '<span id="'.$list->officeid.'" name="first_name" class="editable">'.$list->office_name.'</span>';
                $row[] = '<span id="'.$list->officeid.'" name="target" category="1" class="editable">0</span>';
                $row[] = '<span id="'.$list->officeid.'" name="butget" category="1" class="editable">Rp.0</span>';
                $row[] = '<span id="'.$list->officeid.'" name="target" category="2" class="editable">0</span>';
                $row[] = '<span id="'.$list->officeid.'" name="butget" category="2" class="editable">Rp.0</span>';
                $row[] = '<span id="'.$list->officeid.'" name="target" category="3" class="editable">0</span>';
                $row[] = '<span id="'.$list->officeid.'" name="butget" category="3" class="editable">Rp.0</span>';
             

                $data[] = $row;

             
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->btlModel->countAll(),
                'recordsFiltered' => $this->btlModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

}
