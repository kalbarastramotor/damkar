<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReportAllModel;
use App\Models\OfficeModel;
use App\Models\EventcategoryModel;
use App\Models\EventModel;
use App\Models\EventActivityModel;
use App\Models\EventHistoryModel;
use \App\Libraries\SendEmail;
use Config\Services;

class ReportAll extends BaseController
{
    public function __construct()
    {
        $this->request = Services::request();
        $this->reportAllModel = new ReportAllModel($this->request);
        $this->officeModel = new OfficeModel($this->request);
        $this->categoryModel = new EventcategoryModel($this->request);
        $this->eventModel = new EventModel($this->request);
        $this->eventHistoryModel = new EventHistoryModel($this->request);
        $this->eventActivityModel = new EventActivityModel($this->request);
        $this->mail = new SendEmail();  

        $this->session = session(); 
        $this->data_session = array(
            "title"=>$this->session->get('name')." -  ". $this->session->get('rolename'),
            "id"=>$this->session->get('id'),
            "name"=>$this->session->get('name'),
            "rolecode"=> $this->session->get('rolecode'),
        );
    }
    public function detail($id){
        $data = array(
            "header"=> $this->data_session,
            "title"=>"Report ",
            "css"=> global_css(),
            "extends_css"=>datatablescss(),
            "js"=>global_js(),
            "extends_js"=>array_merge(
                    array(
                        "/js/document.js",
                    ),
                    datatablesjs_js()
                ),
            "view"=>"report/doc/detail"
        );
        return view('index',$data);
    }
    public function filterOffice(){
        $list = $this->officeModel->filterOffice();
        $arrayParent=array();
        foreach ($list as $key => $value) {
            $index = str_replace(" ","-",$value->office_group);
            $index = str_replace(".","",$index);
            $arrayParent[$index]["text"] = $value->office_group;
            $arrayParent[$index]["children"][] =  array(
                "id"=>$value->officeid,
                "text"=>$value->office_name,
            );
        }
        $hasil = array();
        foreach ($arrayParent as $key => $value) {
            $hasil[] = $value;
        }
        echo json_encode($hasil);
    }
    public function detailreport($tahun,$bulan,$documentid){
        $data = array(
            "header"=> $this->data_session,
            "title"=>"Report ",
            "css"=> global_css(),
            "extends_css"=>datatablescss(),
            "js"=>global_js(),
            "params" => array(
                "tahun"=>$tahun,
                "bulan"=>$bulan,
                "documentid"=>$documentid
            ),
            "extends_js"=>array_merge(
                    array(
                        "/js/documentdetail.js",
                    ),
                    datatablesjs_js()
                ),
            "view"=>"report/doc/indexdetail"
        );
        return view('index',$data);
    }

    public function index()
    {
        $data = array(
            "header"=> $this->data_session,
            "title"=>"Report ",
            "css"=> global_css(),
            "extends_css"=>datatablescss(),
            "js"=>global_js(),
            "extends_js"=>array_merge(
                    array(
                        "/js/document.js",
                    ),
                    datatablesjs_js()
                ),
            "view"=>"report/doc/index"
        );
        return view('index',$data);
    }

    function getCategory(){
        echo json_encode( $this->categoryModel->optionList());
    }
    function updatecolumn(){
        $data = array(
            $_POST['column']=> $_POST['value'],
        );
        $hasil = $this->reportAllModel->where('documentid',$_POST['documentid'])->set($data)->update();
        if($hasil!=0){
            successJsonResponse($hasil); 
        }else{
            failedJsonResponse($hasil);
        }
    }

    /// email 
    function checkRequestApprove($officeid,$eventid){
		$dataAtasan = $this->eventModel->getAtasan($officeid);
		
        $historyApproval = $this->eventHistoryModel->getApproval($eventid);
        
        $dataAtasan['urutan'] = 1;
        if(count($historyApproval)==1){
            $dataAtasan['urutan'] = 2;
        }
        $dataApproval = array();
        if($dataAtasan['urutan'] ==1){
            if (array_key_exists('spvarea', $dataAtasan)) {
                $dataApproval = $dataAtasan['spvarea'];
            }
        }
        if($dataAtasan['urutan'] ==2){
            if (array_key_exists('kabag', $dataAtasan)) {
                $dataApproval = $dataAtasan['kabag'];
            }
        }
        // print_r($dataAtasan);

		// print_r($historyApproval);

       
        // die();



		return $dataApproval;
	}
	function sendEmailCron(){
        // print_r($_POST);
        // die();
        $sendemail =  $this->send_email($_POST['eventid']);
        $response = array();
        $response['email'] = $sendemail;
        successJsonResponseAll($response); 

    }
    public function send_email($eventid) {
		$eventData = $this->eventModel->DataEventByID($eventid);
        // print_r($eventData);
        // die();
		$data['nama'] = $eventData['fullname'];
		$data['nama'] = $eventData['fullname'];
		$data['event_name'] = $eventData['name'];
		$data['office_name'] = $eventData['office_name'];
		if($eventData['status']==1){
            $data['subject'] = "DAMKAR | Request Event ".$eventData['name'];
			$data['title'] = "Request Approve";
            $dataApproval = $this->checkRequestApprove($eventData['officeid'],$eventData['eventid']);
            $data['email'] = $dataApproval['email'];

            // print_r($dataApproval);
            // die();
			$layout = view('email/request',$data);
		}elseif($eventData['status']==2){
            $data['subject'] = "DAMKAR | Approved ".$eventData['name'];
			$data['title'] = "Approved ";
    		$data['email'] =$eventData['email'];
			$layout = view('email/approved',$data);
		}elseif($eventData['status']==3){
            $data['subject'] = "DAMKAR | Rejected ".$eventData['name'];
			$data['title'] = "Rejected ";
    		$data['email'] =$eventData['email'];
			$layout = view('email/rejected',$data);
		}
		$kirim = $this->mail->sendEmail($layout,$data);
		return $kirim;
    }

  
    public function status()
    {
        curlEmail();
        die();
        // $sess = $this->data_session;
        // $_POST['userid'] =  $sess['id'];
        // $_POST['role_code'] =  $sess['rolecode'];


        // if($_POST['status']==2){
        //     $historyApproval = $this->eventHistoryModel->getApproval($_POST['eventid']);
        //     if(count($historyApproval)>=1){
        //         $data = array(
        //             'status'=> $_POST['status']
        //         );
        //         $hasil = $this->eventModel->where('eventid',$_POST['eventid'])->set($data)->update();
        //     }
        // }else{
        //     $data = array(
        //         'status'=> $_POST['status']
        //     );
        //     $hasil = $this->eventModel->where('eventid',$_POST['eventid'])->set($data)->update();
        // }


       
        // $insert = $this->eventHistoryModel->insert($_POST);

        // if($insert!=0){
        //     successJsonResponse($insert); 
        // }else{
        //     failedJsonResponse($insert);
        // }

        // rollback 
        
        $sess = $this->data_session;
        $_POST['userid'] =  $sess['id'];
        $_POST['role_code'] =  $sess['rolecode'];

        if($_POST['status']==2){
            $historyApproval = $this->eventHistoryModel->getApproval($_POST['eventid']);
            if(count($historyApproval)>=1){
                $data = array(
                    'status'=> $_POST['status']
                );
                $hasil = $this->eventModel->where('eventid',$_POST['eventid'])->set($data)->update();
            }
        }else{
            $data = array(
                'status'=> $_POST['status']
            );
            $hasil = $this->eventModel->where('eventid',$_POST['eventid'])->set($data)->update();
        }
      

        if($_POST['status']==3){
            $dataFlag = array(
                'flag'=> 0
            );
            $updateFlagApproved = $this->eventHistoryModel->where(['eventid'=>$_POST['eventid'],'status'=>2])->set($dataFlag)->update();
        }
        $insert = $this->eventHistoryModel->insert($_POST);
		$eventData = $this->eventModel->DataEventByID($_POST['eventid']);
         
        if($_SESSION['rolecode']=='spvarea' && $_SESSION['id']==$eventData['userid']){
            $dataLog=array();
            $dataLog['notes'] = 'Approved by '.$_SESSION['name'].' - '.$_SESSION['office_name'];
            $dataLog['eventid'] = $_POST['eventid'];
            $dataLog['status'] = 2;
            $dataLog['userid'] =  $sess['id'];
            $dataLog['role_code'] =  $sess['rolecode'];
            $insertAreaAutoApprove = $this->eventHistoryModel->insert($dataLog);
        }

        // $sendemail =$this->send_email($_POST['eventid']);

        $response = array();
        // $response['email'] = $sendemail;
        $response['insert_log'] = $insert;
        
        successJsonResponseAll($response); 
        

    }
    public function data()
    {
        
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->reportAllModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');
            if($this->request->getPost('year')){
                $year  = $this->request->getPost('year');
     
             }else{
                $year  =  date('Y');
             }

            foreach ($lists as $list) {

                $dataActual = $this->reportAllModel->getActualEventReport($list->year,$list->month);
                // <a class="dropdown-item" href="'.base_url("/report/btl").'/'.$list->year.'/'.$list->month.'"  >  BTL </a>

                $button='
                        <span>
                        <div class="dropdown">
                        <a class="text-muted dropdown-toggle font-size-20" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-horizontal-rounded"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a class="dropdown-item" href="'.base_url("/report/detail").'/'.$list->year.'/'.$list->month.'/'.$list->documentid.'"  >  Show Detail</a>
                        </div>
                        </div>
                    </span>
                ';
                $row = [];
                $row[] = $list->month;
                $row[] = $list->nomerdoc."/".$list->month."/".$list->year;
                $row[] = $list->year;
                $date=date_create("2013-".$list->month."-15");
             
                $row[] =date_format($date,"F");
             
                // $row[] = $list->month;
             
                // $row[] ="Rp.".number_format( $list->butget);
                $row[] = '<span id="'.$list->documentid.'" name="budget" class="editable">Rp.'.number_format( $list->budget).'</span>';
                $row[] = 'Rp.'.number_format( $dataActual['actual_butget']); // buat alokasi

                $row[] = '<span id="'.$list->documentid.'" name="target" class="editable">'.$list->target.'</span>';
                $row[] = $dataActual['actual_event']; // actual event

                $row[] =  $button;
                $data[$list->month] = $row;


             
            }
           
            for ($i=1; $i < 13; $i++) { 
               

                if(array_key_exists($i,$data)){
                    $dataAppend[] = $data[$i];
                }else{
                    
                    $button='
                        <span>
                        <div class="dropdown">
                        <a class="text-muted dropdown-toggle font-size-20" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-horizontal-rounded"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                            <a class="dropdown-item" type="button" onclick="generate_document('.$year .','.$i.')" > Generate Document</a>
                        </div>
                        </div>
                    </span>
                    ';
                    $row = [];
                    $row[] = $i;
                    $row[] ="-" ;
                    $row[] = $year  ;
                    $date=date_create("2013-".$i."-15");

                    // $row[] = (strlen($i) ==1 ) ? "0".$i : $i;
                    $row[] =date_format($date,"F");
                    $row[] = 'Rp.0';
                    $row[] = 'Rp.0';
                    $row[] = '0';
                    $row[] = '0';
                $row[] =  $button;

                    $dataAppend[] = $row;
                }
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->reportAllModel->countAll(),
                'recordsFiltered' => $this->reportAllModel->countFiltered(),
                'data' => $dataAppend
            ];

            echo json_encode($output);
        }
    }
    function save(){
        $hasil = $this->reportAllModel->where('month',$_POST['month'])->where('year',$_POST['year'])->get()->getRowArray();
        if(is_array($hasil)){
            failedJsonResponse($hasil);
        }else{
           $insert = $this->reportAllModel->insert($_POST);
            successJsonResponse($insert); 

        }

 
    }
    function delete(){

        $hasil = $this->reportAllModel->where('officeid',$_POST['officeid'])->delete();
        if($hasil!=0){
            successJsonResponse($hasil); 
        }else{
            failedJsonResponse($hasil);
        }
    }
    function lock(){

        $data = array(
            'office_publish'=> $_POST['status'],
        );
        $hasil = $this->reportAllModel->where('officeid',$_POST['officeid'])->set($data)->update();
        if($hasil!=0){
            successJsonResponse($hasil); 
        }else{
            failedJsonResponse($hasil);
        }
    }

    function update(){

       $data = array(
            "office_code"=>$_POST['office_code'],
            "office_name"=>$_POST['office_name'],
            "office_phone"=>$_POST['office_phone'],
            "office_pic"=>$_POST['office_pic'],
            "office_province"=>$_POST['office_province'],
            "office_city"=>$_POST['office_city'],
            "office_address"=>$_POST['office_address'],
            "office_lat"=>$_POST['office_lat']
        );
        
        $hasil = $this->reportAllModel->where('officeid',$_POST['office_id'])->set($data)->update();
        if($hasil!=0){
            successJsonResponse($hasil); 
        }else{
            failedJsonResponse($hasil);
        }
    }
    
    function filterYear(){
        $data = [];
        for ($i=date('Y'); $i < date('Y') + 20 ; $i++) { 
            $data[] = array(
                "id"=>$i,
                "text"=>$i
            );
        }
        return $this->response->setJSON($data);
    }
    function filterMonth(){
        $data = [];
        for ($i=1; $i <13 ; $i++) { 
            $date=date_create("2013-".$i."-15");
            $data[] = array(
                "id"=>$i,
                "text"=>date_format($date,"F")
            );
        }
        return $this->response->setJSON($data);
    }


    public function by_category()
    {

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->reportAllModel->getEventByCategory();
            
            $data = [];
            $no = $this->request->getPost('start');


            $total =0;
            foreach ($lists as $list) {
    
                $no++;
                $row = [];
               
                $start = strtotime(date_format(date_create($list->date_start),"Y-m-d"));
                $end = strtotime(date_format(date_create($list->date_end),"Y-m-d"));

                $datediff = $end - $start;
                $days_between = round($datediff / (60 * 60 * 24)) + 1;

                $row[] =$no;
                $row[] = date_format(date_create($list->date_start),"d.m.Y");
                $row[] = date_format(date_create($list->date_end),"d.m.Y");
                $row[] = $days_between." Hari";
                $row[] = "13198";
                $row[] = $list->office_name;
                
                $row[] =$list->location;
                $row[] = $list->target_visitor;


                if ( $list->status== 4 ||  $list->status== "4") {
                    // $row[] =  '<span id="'.$list->eventid.'" style="cursor:pointer" name="actual_visitor" class="editable"  >'.$list->actual_visitor.'</span>';  // relita
                    $row[] =  '<span id="'.$list->eventid.'" style="cursor:pointer" name="actual_visitor"   >'.$list->actual_visitor.'</span>';  // relita
                }else{
                    $row[] = $list->actual_visitor;

                }
                $row[] = $list->target_sell;
                if ( $list->status== 4 ||  $list->status== "4") {
               
                // $row[] =  '<span id="'.$list->eventid.'" style="cursor:pointer" name="actual_sell" class="editable">'.$list->actual_sell.'</span>';  // relita
                $row[] =  '<span id="'.$list->eventid.'" style="cursor:pointer" name="actual_sell" >'.$list->actual_sell.'</span>';  // relita
                }else{
                    $row[] = $list->actual_sell;

                }
                if ( $list->status== 4 ||  $list->status== "4") {
                    $row[] =  '<span id="id_target_prospect_'.$list->eventid.'" target_prospect="'.$list->target_prospect.'"  target_actual_prospect="'.$list->target_actual_prospect.'" style="cursor:pointer" name="target_prospect" class="editable">'.$list->target_prospect.'</span>';  // relita
                    $row[] =  '<span id="id_target_actual_prospect_'.$list->eventid.'"  target_prospect="'.$list->target_prospect.'"  target_actual_prospect="'.$list->target_actual_prospect.'" style="cursor:pointer" name="target_actual_prospect" class="editable">'.$list->target_actual_prospect.'</span>';  // relita
                }else{
                    $row[] = $list->target_prospect;
                    $row[] = $list->target_actual_prospect;
                }                
                $presentase = "0%";
                if((int)$list->target_prospect==0 && (int)$list->target_actual_prospect==0){
                    $presentase = "0%";
                }else{

                    $presentase = get_percentage((int)$list->target_prospect,(int)$list->target_actual_prospect)."%";
                }

                $row[] =  '<span id="presentase_prospect_'.$list->eventid.'" >'. $presentase.'</span>';  // relita

                // print_r( /  (int)$list->target_actual_prospect);
                // die();

                $row[] = 'Rp.'.number_format($list->butget);
                $labelStatus ='<span><span class="badge badge-pill badge-soft-success font-size-12">Paid</span></span>';
           
                if ( $list->status== 1 ||  $list->status== "1") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
    
                } else if ( $list->status==  2 ||  $list->status== "2") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-primary font-size-12">Approved</span></span>';
                } else if ( $list->status== 3 ||  $list->status== "3") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-danger font-size-12">Rejected</span></span>';
                } else if ( $list->status== 4 ||  $list->status== "4") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-info font-size-12">Running</span></span>';
                } else if ( $list->status== 5 ||  $list->status== "5") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-success font-size-12">Done</span></span>';
                } else if ( $list->status== 0 ||  $list->status== "0") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-secondary font-size-12">Draft</span></span>';
                }else{
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-danger font-size-12">Paid</span></span>';

                }
                $row[] =$labelStatus;


                $row[] ='
                <span>
                <div class="dropdown">
                  <a class="text-muted dropdown-toggle font-size-20" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="bx bx-dots-horizontal-rounded"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end" style="">
                    <a class="dropdown-item" href="#">Detail</a>
                  </div>
                </div>
              </span>
                    ';

                $row[] = $list->status;
                $row[] = $list->butget;
                $data[] = $row;
            }
           

      
            $total_results = $this->reportAllModel->totalEventByCategory();
          
            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $total_results,
                'recordsFiltered' => $total_results,
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function eventRunning()
    {

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->reportAllModel->getEventRunning();
            
            $data = [];
            $no = $this->request->getPost('start');


            $total =0;
            foreach ($lists as $list) {
    
                // print_r($list);
                // die();
                $no++;
                $row = [];
               
                $start = strtotime(date_format(date_create($list->date_start),"Y-m-d"));
                $end = strtotime(date_format(date_create($list->date_end),"Y-m-d"));

                $datediff = $end - $start;
                $days_between = round($datediff / (60 * 60 * 24)) + 1;

                $row[] =$no;
                $row[] = $list->name;
                $row[] = $list->category_name;
                $row[] = date_format(date_create($list->date_start),"d.m.Y") ."-" . date_format(date_create($list->date_end),"d.m.Y");
                $row[] = $days_between." Hari";
                $row[] = $list->office_code." - ".$list->office_name;
                $row[] =$list->location;
                $row[] = $list->target_visitor;
                $row[] = $list->target_sell;
               
                // print_r( /  (int)$list->target_actual_prospect);
                // die();

                $labelStatus ='<span><span class="badge badge-pill badge-soft-success font-size-12">Paid</span></span>';
           
                if ( $list->status== 1 ||  $list->status== "1") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
    
                } else if ( $list->status==  2 ||  $list->status== "2") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-primary font-size-12">Approved</span></span>';
                } else if ( $list->status== 3 ||  $list->status== "3") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-danger font-size-12">Rejected</span></span>';
                } else if ( $list->status== 4 ||  $list->status== "4") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-info font-size-12">Running</span></span>';
                } else if ( $list->status== 5 ||  $list->status== "5") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-success font-size-12">Done</span></span>';
                } else if ( $list->status== 0 ||  $list->status== "0") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-secondary font-size-12">Draft</span></span>';
                }else{
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-danger font-size-12">Paid</span></span>';

                }
                $row[] =$labelStatus;

                $data[] = $row;
            }
           
            $output = [
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    function updatecolumnEvent(){
       
        $data = array(
            $_POST['columnName']=> $_POST['value'],
        );
        $hasil = $this->eventModel->where('eventid',$_POST['eventID'])->set($data)->update();
        if($hasil!=0){
            successJsonResponse($hasil); 
        }else{
            failedJsonResponse($hasil);
        }
    }
    function getActivityEvent(){

        $hasil = $this->eventActivityModel->getActivityEvent();
        $array = array();

        foreach ($hasil as $key => $value) {
            $value->images =base_url().'/uploads/berkas/'.$value->images;
            $array[$value->date] = json_decode(json_encode($value), true); 
        }

        $tanggal = (int)$_POST['tanggal'];

        $results = array();
        for ($i=0; $i < (int)$_POST['days'] ; $i++) { 
            $tgl = $tanggal;
            if(strlen($tanggal)==1){
                $tgl = "-0".$tanggal;
            }else{
                $tgl = "-".$tanggal;
            }
            $date = $_POST['startdate'].$tgl;
            $results[] = array(
                'date'=>$date,
                'images'=>$array[$date]['images'],
                'id'=>$array[$date]['id']
            );
            $tanggal++;
        }
        return $this->response->setJSON($results);
    }
    function deleteFile(){
        $id=$_POST['id'];
        $id =str_replace("show_image_","",$id);
        $id =str_replace("_delete","",$id);

        $paramsID = explode("--",$id);

		$hasil = $this->eventActivityModel->getImageFile($paramsID[0],$paramsID[1]);
        $delete = $this->eventActivityModel->where('id', $hasil['id'])->delete();

        $path_to_file = 'uploads/berkas/'.$hasil['images'];
        if(unlink($path_to_file)) {
            successJsonResponse($delete); 
        }
        else {
            failedJsonResponse($delete);
        }

    }
    function uploadFile(){
        
        $dataBerkas = $this->request->getFile('berkas');
		$fileName = $dataBerkas->getRandomName();
        $paramsID = explode("--",$this->request->getPost("id"));

		$hasil = $this->eventActivityModel->insert([
            'eventid'=>(int)str_replace('input_show_image_','', $paramsID[0]),
			'images' => $fileName,
			'date' => $paramsID[1]
		]);
		
        $dataBerkas->move('uploads/berkas/', $fileName);

        if($hasil!=0){
            successJsonResponse($hasil); 
        }else{
            failedJsonResponse($hasil);
        }

    }

}
