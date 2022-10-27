<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\EventlistModel;
use App\Models\EventHistoryModel;
use Config\Services;

class Eventlist extends BaseController
{
    public function __construct()
    {
        $this->request = Services::request();
        $this->EventlistModel = new EventlistModel($this->request);
        $this->eventHistoryModel = new EventHistoryModel($this->request);
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
            "title" => "Event List",
            "css" => global_css(),
            "extends_css" => datatablescss(),
            "js" => global_js(),
            "extends_js" => array_merge(
                array(
                    "/js/eventlist.js",
                ),
                datatablesjs_js()

            ),
            "view" => "datamaster/eventlist/eventlist"
        );
        return view('index', $data);
    }

    // Get Data Table
    public function data()
    {


        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->EventlistModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');


            foreach ($lists as $list) {

                $btnEdit = '<button type="button" class="btn btn-soft-primary waves-effect waves-light" 
                id="edit_eventlist_' . $list->eventid . '"
                onclick="edit_eventlist(' . $list->eventid . ',this.eventid)" 
                eventid="' . $list->eventid . '" 
                name="' . $list->name . '" 
                cover="' . $list->cover . '"
                ><i class="bx bx-edit-alt font-size-16 align-middle"></i></button>';

                $btnDelete = '<button type="button" class="btn btn-soft-danger waves-effect waves-light"  onclick="delete_eventlist(' . $list->eventid . ',\'' . $list->name . '\')"><i  class="bx bx-trash-alt font-size-16 align-middle"></i></button>';

                $button =

                    '<div class="d-flex flex-wrap gap-2">  
                    ' . $btnEdit . '     
                    ' . $btnDelete . '    
                    </div>';

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->name;
                $row[] = $list->date_start;
                $row[] = $list->date_end;
                $row[] = $list->categoryid;
                $row[] = $list->butget;
                $row[] = $list->status;
                $row[] = $button;
                $data[] = $row;
            }


            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->EventlistModel->countAll(),
                'recordsFiltered' => $this->EventlistModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    function update($id){
       
        if($_POST['cover']!='undefined'){
            $dataBerkas = $this->request->getFile('cover');
            $fileName = $dataBerkas->getRandomName();
            $dataBerkas->move('uploads/cover/', $fileName);
            $_POST['cover'] = $fileName;

        }else{
            unset($_POST['cover']);
        }
        $dateStart=date_create($_POST['date_start']);
        $_POST['date_start'] = date_format($dateStart,"Y-m-d H:i:s");

        $dateEnd=date_create($_POST['date_end']);
        $_POST['date_end'] = date_format($dateEnd,"Y-m-d H:i:s");

        $_POST['month'] = date_format($dateStart,"m");
        $_POST['year'] = date_format($dateStart,"Y");
        
        $hasil = $this->EventlistModel->where('eventid', $id)->set($_POST)->update();
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }

    }
    function save()
    {
        
        $dataBerkas = $this->request->getFile('cover');
		$fileName = $dataBerkas->getRandomName();
        
        $dataBerkas->move('uploads/cover/', $fileName);

        $dateStart=date_create($_POST['date_start']);
        $_POST['date_start'] = date_format($dateStart,"Y-m-d H:i:s");

        $dateEnd=date_create($_POST['date_end']);
        $_POST['date_end'] = date_format($dateEnd,"Y-m-d H:i:s");

        $_POST['cover'] = $fileName;
     
        $_POST['userid'] = $_SESSION['id'];

        $_POST['month'] = date_format($dateStart,"m");
        $_POST['year'] = date_format($dateStart,"Y");
        
    
        $hasil = $this->EventlistModel->insert($_POST);

        
        $insertDataHistory = array();
        $insertDataHistory['notes']= 'Created Event';
        $insertDataHistory['eventid']=$hasil;
        $insertDataHistory['status']=0;
        $insertDataHistory['userid']= $_SESSION['id'];

        $insert = $this->eventHistoryModel->insert($insertDataHistory);

        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }

    function delete()
    {
        $hasil = $this->EventlistModel->where('eventid', $_POST['id'])->delete();
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }

    // function edit()
    // {
    //     // print_r($_POST);
    //     // die();
    //     $data = array(
    //         "name" => $_POST['name'],
    //         "code" => $_POST['code']
    //     );

    //     $hasil = $this->EventlistModel->where('id', $_POST['id'])->set($data)->edit();
    //     if ($hasil != 0) {
    //         successJsonResponse($hasil);
    //     } else {
    //         failedJsonResponse($hasil);
    //     }
    // }
}
