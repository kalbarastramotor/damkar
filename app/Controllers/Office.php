<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OfficeModel;
use Config\Services;

class Office extends BaseController
{
    public function __construct()
    {
        $this->request = Services::request();
        $this->officeModel = new OfficeModel($this->request);

        $this->session = session();
        $this->data_session = array(
            "title" => $this->session->get('name') . " -  " . $this->session->get('rolename'),
            "id" => $this->session->get('id'),
            "name" => $this->session->get('name'),
        );
    }


    public function index()
    {
        $data = array(
            "header" => $this->data_session,
            "title" => "Data Dealer",
            "css" => global_css(),
            "map" => mapsjs(),
            "extends_css" => datatablescss(),
            "js" => global_js(),
            "extends_js" => array_merge(
                array(
                    "/js/office.js",
                ),
                datatablesjs_js()

            ),
            "view" => "datamaster/office/office"
        );
        return view('index', $data);
    }

    public function data()
    {

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->officeModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');



            foreach ($lists as $list) {
                $btnMaps = ' <button class="btn btn-soft-success waves-effect waves-light" onclick="getMap('.$list->officeid.',\''.$list->office_lat.'\',\''.$list->office_long.'\')" ><i class="bx bx-map-pin font-size-16 align-middle"></i></button>';
                $btnEdit = '<button type="button" class="btn btn-soft-primary waves-effect waves-light" 
                id="edit_office_' . $list->officeid . '"
                onclick="edit_dealer(' . $list->officeid . ',this.id)"
                office_code="' . $list->office_code . '"
                office_name="' . $list->office_name . '"
                userid="' . $list->userid . '"
                username="' . $list->fullname . '"
                office_phone="' . $list->office_phone . '"
                office_province="' . $list->office_province . '"
                office_province_name="' . $list->office_province_name . '"
                office_city="' . $list->office_city . '"
                office_city_name="' . $list->office_city_name . '"
                office_address="' . $list->office_address . '"
                office_publish="' . $list->office_publish . '"
                office_map="' . $list->office_lat . ',' . $list->office_long . '"
                ><i class="bx bx-edit-alt font-size-16 align-middle"></i></button>';
                $btnDelete = '<button type="button" class="btn btn-soft-danger waves-effect waves-light"  onclick="delete_dealer(' . $list->officeid . ',\'' . $list->office_name . '\')"><i  class="bx bx-trash-alt font-size-16 align-middle"></i></button>';
                if ($list->office_publish == 0) {
                    $btnLock = '<button type="button" class="btn btn-soft-danger waves-effect waves-light"  onclick="lock_office(' . $list->officeid . ',' . $list->office_publish . ',\'' . $list->office_name . '\')"><i  class="bx bx-lock-alt font-size-16 align-middle"></i></button>';
                } else {
                    $btnLock = '<button type="button" class="btn btn-soft-warning waves-effect waves-light"  onclick="lock_office(' . $list->officeid . ',' . $list->office_publish . ',\'' . $list->office_name . '\')"><i  class="bx bx-lock-open-alt font-size-16 align-middle"></i></button>';
                }
                $button = '
                    <div class="d-flex flex-wrap gap-2">
                    ' . $btnMaps . '    
                    ' . $btnEdit . '    
                    ' . $btnLock . '    
                    ' . $btnDelete . '    
                    </div>';
                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->office_code;
                $row[] = $list->office_name;
                $row[] = $list->office_phone;
                $row[] = $list->office_province_name;
                $row[] = $list->office_city_name;
                $row[] = $list->office_address;
                $row[] = $button;
                $row[] = $list->office_publish;
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
    function save()
    {
        $hasil = $this->officeModel->insert($_POST);
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }
    function delete()
    {

        $hasil = $this->officeModel->where('officeid', $_POST['officeid'])->delete();
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }
    function lock()
    {

        $data = array(
            'office_publish' => $_POST['status'],
        );
        $hasil = $this->officeModel->where('officeid', $_POST['officeid'])->set($data)->update();
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }
    function updatemaps($officeid)
    {
        $hasil = $this->officeModel->where('officeid', $officeid)->set($_POST)->update();
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }

    function update()
    {

        $data = array(
            "office_code" => $_POST['office_code'],
            "office_name" => $_POST['office_name'],
            "office_phone" => $_POST['office_phone'],
            "office_province" => $_POST['office_province'],
            "office_city" => $_POST['office_city'],
            "office_address" => $_POST['office_address'],
        );
     

        $hasil = $this->officeModel->where('officeid', $_POST['office_id'])->set($data)->update();
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }

    public function selectOptionOffice()
    {

        $lists = $this->officeModel->optionList();
        $data = [];

        foreach ($lists as $list) {
            $row = array(
                "id" => $list->officeid,
                "text" => $list->office_name . " - " . $list->office_code
            );
            $data[] = $row;
        }


        echo json_encode($data);
    }
    
    public function filterOffice(){
        $list = $this->officeModel->filterOffice();
        $arrayParent=array();
        foreach ($list as $key => $value) {
            $index = str_replace(" ","-",$value->office_group);
            $index = str_replace(".","",$index);
            $arrayParent[$index]["name"] = $value->office_group;
            $arrayParent[$index]["data"][] =  array(
                "id"=>$value->officeid,
                "index"=>$value->office_name,
            );
        }
        echo json_encode($arrayParent);
    }
}
