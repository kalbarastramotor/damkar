<?php

namespace App\Controllers;

use App\Models\OfficeModel;
use App\Models\ReportAllModel;
use App\Models\EventModel;
use App\Models\UserModel;
use App\Models\EventHistoryModel;
use App\Models\EventActivityModel;
use Config\Services;

class Home extends BaseController
{

    public function __construct()
    {
        $this->request = Services::request();
        $this->officeModel = new OfficeModel($this->request);
        $this->userModel = new UserModel($this->request);
        $this->reportAllModel = new ReportAllModel($this->request);
        $this->eventModel = new EventModel($this->request);
        $this->eventHistoryModel = new EventHistoryModel($this->request);
        $this->eventActivityModel = new EventActivityModel($this->request);

        $this->session = session();
        $this->data_session = array(
            "title" => $this->session->get('name') . " -  " . $this->session->get('rolename'),
            "id" => $this->session->get('id'),
            "name" => $this->session->get('name'),
            "rolecode"=> $this->session->get('rolecode'),
        );
    }
    public function dataDashboard(){
        $dataEventDashboard = $this->reportAllModel->queryDashboardTotalEvent();
        $temp= array();
        $tempTotalEvent= array();
        $totalEvent = 0;
        foreach ($dataEventDashboard as $key => $value) {
            $temp[$value->categoryid]['data'][] = array(
                "categoryid"=> (int)$value->categoryid,
                "status"=> (int)$value->status,
                "total"=> (int)$value->total,
            );
            if(array_key_exists($value->categoryid,$tempTotalEvent)){
            $tempTotalEvent[$value->categoryid] = $tempTotalEvent[$value->categoryid] + $value->total;
            }else{
                $tempTotalEvent[$value->categoryid] = $value->total;
            }
        }
        $results = array();
        foreach ($temp as $key => $value) {
            $value['total'] =(int)$tempTotalEvent[$key];
            $value['categoryid'] =(int)$key;
            $results[] = $value; 
        }
        return $this->response->setJSON($results);
        
    }
    public function listCabang(){
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->reportAllModel->queryListCabang();
            
            $data = [];
            $no = $this->request->getPost('start');

            $total =0;
            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $list->office_group;
                 $total = $this->reportAllModel->totalEventPerCabang($list->office_id);

                 
                $row[] = $total['total'];
                $data[] = $row;
            }
           

            $output = [
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    public function index()
    {
       
        
        $data = array(
            "header" => $this->data_session,
            "title" => "Dashboard",
            "css" => global_css(),
            "extends_css" => flatpickr_css(),
            "js" => array_merge( global_js(),datatablesjs_js(),array("/libs/apexcharts/apexcharts.min.js")),
            "map" => mapsjs(),
            "extends_js" => array('/js/dashboard.js'),
            // "extends_js"=>array_merge(apexcharts_js(),flatpickr_js(),todo_js(),array('/js/dashboard.js')),
            // "extends_js"=>array_merge(apexcharts_js(),flatpickr_js(),todo_js()),
            "view" => "dashboard/index"
        );
        return view('index', $data);
    }
    public function filterOffice()
    {
        $list = $this->officeModel->filterOffice();
        $arrayParent = array();
        foreach ($list as $key => $value) {
            $index = str_replace(" ", "-", $value->office_group);
            $index = str_replace(".", "", $index);
            $arrayParent[$index]["name"] = $value->office_group;
            $arrayParent[$index]["data"][] =  array(
                "id" => $value->officeid,
                "index" => $value->office_name,
            );
        }
        return $arrayParent;
    }

   
  
    public function event(){
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->eventModel->getDatatables();
        
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {
                $start = strtotime(date_format(date_create($list->date_start),"Y-m-d"));
                $end = strtotime(date_format(date_create($list->date_end),"Y-m-d"));
                $datediff = $end - $start;

                $days_between = round($datediff / (60 * 60 * 24)) + 1;

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->name;
                $row[] = date_format(date_create($list->date_start),"d.m.Y");
                $row[] = date_format(date_create($list->date_end),"d.m.Y");
                $row[] = $days_between." Hari";

               

                $labelStatus ='<span><span class="badge badge-pill badge-soft-success font-size-12">Unknown</span></span>';
                
                $buttonDefault ='<a class="dropdown-item" type="button" onclick="detail_event('. $list->eventid.')" >Detail</a>';
                $buttonActionList = '';
                if ( $list->status== 1 ||  $list->status== "1") {

                    $historyApproval = $this->eventHistoryModel->getApproval($list->eventid);
                    if($this->data_session['rolecode']=='staff'){
                        $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
                    }else{
                        
                        if(in_array($this->data_session['rolecode'],$historyApproval)){
                            $labelStatus ='<span><span class="badge badge-pill badge-soft-primary font-size-12">Approved</span></span>';
                        }else{
                                // if(count($historyApproval)==0){
                                //     if($this->data_session['rolecode']=='kabag'){
                                //         $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
                                //     }else{
                                //         $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
                                //     }
                                // }else{
                                //     $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
                                // }
                            if(count($historyApproval)==0){
                                if($this->data_session['rolecode']=='spvarea'){
                                    $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
                                }else{
                                    $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
                                }
                            }elseif(count($historyApproval)==1 && in_array('spvarea',$historyApproval) ){
                                if($this->data_session['rolecode']=='kabag'){
                                    $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
                                }else{
                                    $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
                                }
                            }else{
                                $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
                            }
                        }
                    }  
                } else if ( $list->status==  2 ||  $list->status== "2") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-primary font-size-12">Approved</span></span>';
                } else if ( $list->status== 3 ||  $list->status== "3") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-danger font-size-12">Rejected</span></span>';
                    $buttonActionList =  $this->buttonEditEvent($list->eventid,$list->userid);
                } else if ( $list->status== 4 ||  $list->status== "4") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-info font-size-12">Running</span></span>';
                    if($this->data_session['id']==$list->userid){
                        $buttonActionList = '<a class="dropdown-item" type="button" onclick="getFormUpload('.$list->eventid.','.$days_between.',\''.date_format(date_create($list->date_start),"Y-m").'\',\''.date_format(date_create($list->date_start),"d").'\')" >Upload Images</a>';
                    }                
                
                } else if ( $list->status== 5 ||  $list->status== "5") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-success font-size-12">Done</span></span>';
                } else if ( $list->status== 0 ||  $list->status== "0") {
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-secondary font-size-12">Draft</span></span>';
                    $buttonActionList = $this->buttonEditEvent($list->eventid,$list->userid);
                }else{
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-danger font-size-12">Unknown</span></span>';
                    $buttonActionList =  $this->buttonEditEvent($list->eventid,$list->userid);
                }

                $button = '
                    <span>
                        <div class="dropdown">
                        <a class="text-muted dropdown-toggle font-size-20" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-horizontal-rounded"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" style="">
                           '.$buttonDefault.'
                           '.$buttonActionList.'
                            
                        </div>
                        </div>
                    </span>
                ';

                $row[] = $labelStatus;
                $row[] =  $list->category_name;
                $row[] = $list->office_code;
                $row[] = $list->office_name;
                $row[] = $button ;
                $data[] = $row;
            }


            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->eventModel->countAll(),
                'recordsFiltered' => $this->eventModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    public function buttonEditEvent($eventid,$createdid){
        $btn ='';
        if($_SESSION['id']==$createdid){
            $btn = '
            <a class="dropdown-item" type="button" onclick="edit_event('. $eventid.')" >Edit</a>
            <a class="dropdown-item" type="button" onclick="delete_event('. $eventid.')" >Delete</a>
        ';
            
        }
        return $btn;
    }
    public function datamaster()
    {
       
        $data = array(
            "header" => $this->data_session,
            "title" => "Data Menu",
            "css" => global_css(),
            "map" => mapsjs(),
            "extends_css" => array_merge( 
                datatablescss(),
                array(  
                    array(
                        "assets"=>"/libs/flatpickr/flatpickr.min.css",
                        "id"=>""
                    )
                )
            ),
            "js" => global_js(),
            "extends_js" => array_merge(datatablesjs_js(), array("/libs/flatpickr/flatpickr.min.js","/js/dataevent.js")),
            "view" => "datamaster/index"
        );
        return view('index', $data);
    }
    public function dataBulan(){

       $data = array (
  
            array (
              'text'=> 'January',
              'short' => 'Jan',
              'id'=> 1,
              'days' => 31,
            ),
            array (
              'text'=> 'February',
              'short' => 'Feb',
              'id'=> 2,
              'days' => 28,
            ),
            array (
              'text'=> 'March',
              'short' => 'Mar',
              'id'=> 3,
              'days' => 31,
            ),
            array (
              'text'=> 'April',
              'short' => 'Apr',
              'id'=> 4,
              'days' => 30,
            ),
            array (
              'text'=> 'May',
              'short' => 'May',
              'id'=> 5,
              'days' => 31,
            ),
            array (
              'text'=> 'June',
              'short' => 'Jun',
              'id'=> 6,
              'days' => 30,
            ),
            array (
              'text'=> 'July',
              'short' => 'Jul',
              'id'=> 7,
              'days' => 31,
            ),
            array (
              'text'=> 'August',
              'short' => 'Aug',
              'id'=> 8,
              'days' => 31,
            ),
            array (
              'text'=> 'September',
              'short' => 'Sep',
              'id'=> 9,
              'days' => 30,
            ),
            array (
              'text'=> 'October',
              'short' => 'Oct',
              'id'=> 10,
              'days' => 31,
            ),
            array (
              'text'=> 'November',
              'short' => 'Nov',
              'id'=> 11,
              'days' => 30,
            ),
            array (
              'text'=> 'December',
              'short' => 'Dec',
              'id'=> 12,
              'days' => 31,
            ),
        );
        return $this->response->setJSON($data);

    }
    public function login()
    {
        return view('login/login', array('header' => $this->data_session));
    }

    public function dataEventStatus(){

        $data = array (
   
             array (
               'text'=> 'Pending',
               'id'=> 1,
             ),
             array (
               'text'=> 'Approved',
               'id'=> 2,
             ),
             array (
               'text'=> 'Rejected',
               'id'=> 3,
             ),
             array (
               'text'=> 'Running',
               'id'=> 4,
             ),
             array (
               'text'=> 'Done',
               'id'=> 5,
             ),
             array (
               'text'=> 'Draft',
               'id'=> 0,
             )
         );
         return $this->response->setJSON($data);
 
     }
     function GetDataEventByID(){

        $hasil = $this->eventModel->getDataEventByID();

        $hasil['users'] = $this->userModel->GetUserIDByID($hasil['userid']);
        $detail = $this->eventActivityModel->get()->getResult();
        $results = array();
        
        $detailImages = array();
        foreach ($detail as $key => $value) {
            $value->images =base_url().'/uploads/berkas/'.$value->images;
            $detailImages[$value->date] = json_decode(json_encode($value), true); 
        }

        $start = strtotime(date_format(date_create($hasil['date_start']),"Y-m-d"));
        $end = strtotime(date_format(date_create($hasil['date_end']),"Y-m-d"));

        $datediff = $end - $start;
        $days_between = round($datediff / (60 * 60 * 24)) + 1;

        $hasil['days'] = $days_between;
        $hasil['durasi'] = date_format(date_create($hasil['date_start']),"Y-m-d")." sampai ".date_format(date_create($hasil['date_end']),"Y-m-d");
        $monthStart =date_format(date_create($hasil['date_start']),"Y-m");
        $dateStart =(int)date_format(date_create($hasil['date_start']),"d");
        $array = array();
        for ($i=0; $i <$days_between ; $i++) { 
            if(strlen($dateStart)==1){
               $dateData = $monthStart."-0".$dateStart;
            }else{
               $dateData = $monthStart."-".$dateStart;
            }
            $detailImages[$dateData]['images'] = ($detailImages[$dateData]['images']=="") ? base_url()."/public/assets/images/dafault-image-notfound.jpeg" : $detailImages[$dateData]['images'] ;
            $detailImages[$dateData]['date'] = ($detailImages[$dateData]['date']=="") ? $dateData : $detailImages[$dateData]['date'] ;
           

            $array[] =array(
                "date"=>$dateData,
                "posisi"=>$this->displayImage($detailImages[$dateData]),
            );
           

            $dateStart++;
        }
       
        $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
        $action='';
        if ( $hasil['status'] == 1 ||  $hasil['status'] == "1") {
            // pengecekan approval berjenjang
            $historyApproval = $this->eventHistoryModel->getApproval($hasil['eventid']);
           
            // cek akses button 
            if($this->data_session['rolecode']=='staff'){
                $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
                $action =' 
                    <button type="button" class="btn btn-warning waves-effect waves-light">Waiting Approval</button>
                ';
            }else{
                
                if(in_array($this->data_session['rolecode'],$historyApproval)){
                    $labelStatus ='<span><span class="badge badge-pill badge-soft-primary font-size-12">Approved</span></span>';
                    $action =' 
                        <button type="button" class="btn btn-primary waves-effect waves-light">Approved</button>
                    ';
                }else{
                    if(count($historyApproval)==0){
                        if($this->data_session['rolecode']=='spvarea'){
                            $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
                            $action =' 
                                <button type="button" class="btn btn-success waves-effect waves-light" onclick="approve('.$hasil['eventid'].')">Approve</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="rejected('.$hasil['eventid'].')">Reject</button>
                            ';
                        }else{
                            $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval '.$this->data_session['rolecode'].'</span></span>';
                            $action =' 
                                <button type="button" class="btn btn-warning waves-effect waves-light">Waiting Approval</button>
                            ';
                        }
                    }elseif(count($historyApproval)==1 && in_array('spvarea',$historyApproval) ){
                        if($this->data_session['rolecode']=='kabag'){
                            $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
                            $action =' 
                                <button type="button" class="btn btn-success waves-effect waves-light" onclick="approve('.$hasil['eventid'].')">Approve</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="rejected('.$hasil['eventid'].')">Reject</button>
                            ';
                        }else{
                            $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
                            $action =' 
                                <button type="button" class="btn btn-warning waves-effect waves-light">  Waiting Approval</button>
                            ';
                        }
                    }
                   
                }

                
               
            }
            // cek akses button 

        } else if ( $hasil['status'] ==  2 ||  $hasil['status'] == "2") {
            $labelStatus ='<span><span class="badge badge-pill badge-soft-primary font-size-12">Approved</span></span>';
            $action =' 
                <button type="button" class="btn btn-primary waves-effect waves-light">Approved</button>
            ';
        } else if ( $hasil['status'] == 3 ||  $hasil['status'] == "3") {
            $labelStatus ='<span><span class="badge badge-pill badge-soft-danger font-size-12">Rejected</span></span>';
            $action =' 
                <button type="button" class="btn btn-primary waves-effect waves-light"  onclick="request_approve('.$hasil['eventid'].')">Request</button>
            ';
        } else if ( $hasil['status'] == 4 ||  $hasil['status'] == "4") {
            $labelStatus ='<span><span class="badge badge-pill badge-soft-info font-size-12">Running</span></span>';
            $action =' 
                <button type="button" class="btn btn-primary waves-effect waves-light">Running</button>
            ';
        } else if ( $hasil['status'] == 5 ||  $hasil['status'] == "5") {
            $labelStatus ='<span><span class="badge badge-pill badge-soft-success font-size-12">Done</span></span>';
            $action =' 
                <button type="button" class="btn btn-success waves-effect waves-light">Done</button>
            ';
        } else if ( $hasil['status'] == 0 ||  $hasil['status'] == "0") {
            $labelStatus ='<span><span class="badge badge-pill badge-soft-secondary font-size-12">Draft</span></span>';
            $action =' 
                <button type="button" class="btn btn-primary waves-effect waves-light"  onclick="request_approve('.$hasil['eventid'].')">Request</button>
            ';
        }else{
            $labelStatus ='<span><span class="badge badge-pill badge-soft-danger font-size-12">Paid</span></span>';
            $action =' 
                <button type="button" class="btn btn-primary waves-effect waves-light">Report</button>
            ';
        }

        // $action =' 
        //     <button type="button" class="btn btn-primary waves-effect waves-light">Done</button>
        //     <button type="button" class="btn btn-primary waves-effect waves-light"  onclick="request_approve('.$hasil['eventid'].')">Request</button>
        //     <button type="button" class="btn btn-primary waves-effect waves-light">Running</button>
        //     <button type="button" class="btn btn-primary waves-effect waves-light" onclick="rejected('.$hasil['eventid'].')">Reject</button>
        //     <button type="button" class="btn btn-primary waves-effect waves-light" onclick="approve('.$hasil['eventid'].')">Approve</button>
        //     <button type="button" class="btn btn-primary waves-effect waves-light">Pending</button>
        //     <button type="button" class="btn btn-primary waves-effect waves-light">Draft</button>
        // ';

        $actionHistory ='
            <button type="button" class="btn btn-primary-secondary" onclick="show_history_status('.$hasil['eventid'].')">Show</button>
        ';
       
       
        $hasil['status_event'] = $labelStatus;
       
        $hasil['action']=   ' <div class="d-flex flex-wrap gap-2">'.$action.'</div>';
        $hasil['action_history']=   ' <div class="d-flex flex-wrap gap-2">'.$actionHistory.'</div>';
        $results['data'] =$hasil;
        $results['detail'] =$array;

        return $this->response->setJSON($results);
    }
    function labelStatusEvent($status){
        $labelStatus ='<span><span class="badge badge-pill badge-soft-danger font-size-12">Unknown</span></span>';
        if ( $status == 1 ||  $status == "1") {
            $labelStatus ='<span><span class="badge badge-pill badge-soft-warning font-size-12">Waiting Approval</span></span>';
        } else if ( $status ==  2 ||  $status == "2") {
            $labelStatus ='<span><span class="badge badge-pill badge-soft-primary font-size-12">Approved</span></span>';
        } else if ( $status == 3 ||  $status == "3") {
            $labelStatus ='<span><span class="badge badge-pill badge-soft-danger font-size-12">Rejected</span></span>';
        } else if ( $status == 4 ||  $status == "4") {
            $labelStatus ='<span><span class="badge badge-pill badge-soft-info font-size-12">Running</span></span>';
        } else if ( $status == 5 ||  $status == "5") {
            $labelStatus ='<span><span class="badge badge-pill badge-soft-success font-size-12">Done</span></span>';
        } else if ( $status == 0 ||  $status == "0") {
            $labelStatus ='<span><span class="badge badge-pill badge-soft-secondary font-size-12">Draft</span></span>';
        }else{
            $labelStatus ='<span><span class="badge badge-pill badge-soft-danger font-size-12">Unknown</span></span>';
        }
        return $labelStatus;
    }
    function historyEvent(){
        $results = array();

        $data = $this->eventHistoryModel->getHistoryEvent( $this->request->getPost('eventid'));
        foreach ($data as $key => $value) {
            $value->status= $this->labelStatusEvent($value->status);
            $results[] = $value;
        }

        return $this->response->setJSON($results);

    }
    function displayImage($data){
        $html = '
        <div class="col-md-6 col-xl-3">
        <div>
          <img class="card-img-top img-fluid" style="max-height:200px !important" src="'.$data['images'].'" alt="Card image cap">
          <div class="card-body">
          <h4 class="card-title text-center" >'.$data['date'].'</h4>
          </div>
        </div>
      </div>
        ';
        return $html;
    }
    function markerEventMapsHome(){
        $results = $this->officeModel->getMapOffice();
    
        $array = array();
        foreach ($results as $key => $value) {
            $array[] = array(
                "officeid"=>$value->officeid,
                "office_name"=>$value->office_name, 
                "office_code"=>$value->office_code, 
                "office_address"=>$value->office_address, 
                "office_group"=>$value->office_group, 
                "lat"=>$value->office_lat,
                "lng"=>$value->office_long,
                "icon"=>base_url()."/public/assets/logo/".$value->office_image,
            );

        }
        return $this->response->setJSON($array);

    }
function clickMaps(){
        $dataEventCategory = $this->reportAllModel->mapsClick($_POST['officeid']);
        $dataEventStatus = $this->reportAllModel->getTotalMaps($_POST['officeid']);
        $dataEventTarget = $this->reportAllModel->getDataActualMaps($_POST['officeid']);

     
        $data['actual_visitor'] = $results['actual_visitor'];
        $data['actual_sell'] = $results['actual_sell'];
        $data['target_actual_prospect'] = $results['target_actual_prospect'];
        
        $results= array(
            "exhibiton"=>(array_key_exists('exhibiton',$dataEventCategory)? (int)$dataEventCategory['exhibiton'] : 0 ),
            "roadshow"=>(array_key_exists('roadshow-md',$dataEventCategory)? (int)$dataEventCategory['roadshow-md'] : 0 ),
            "showroom"=>(array_key_exists('roadshow-event',$dataEventCategory)? (int)$dataEventCategory['roadshow-event'] : 0 ),
            "inprogress"=>(array_key_exists(1,$dataEventStatus)? (int)$dataEventStatus[1] : 0 ),
            "running"=>(array_key_exists(4,$dataEventStatus)? (int)$dataEventStatus[4] : 0 ),
            "done"=>(array_key_exists(5,$dataEventStatus)? (int)$dataEventStatus[5] : 0 ),
            "visitor"=>(array_key_exists('actual_visitor',$dataEventTarget)? (int)$dataEventTarget['actual_visitor'] : 0 ),
            "prospek"=>(array_key_exists('target_actual_prospect',$dataEventTarget)? (int)$dataEventTarget['target_actual_prospect'] : 0 ),
            "deal"=>(array_key_exists('actual_sell',$dataEventTarget)? (int)$dataEventTarget['actual_sell'] : 0 ),
        );

        return $this->response->setJSON($results);

    }
   
}
