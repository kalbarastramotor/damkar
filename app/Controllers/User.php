<?php

namespace App\Controllers;

// use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Oauth;
use \OAuth2\Request;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\UserOfficeModel;
use App\Models\UserRoleModel;
use App\Models\RoleModel;
use Config\Services;



class User extends BaseController
{
	use ResponseTrait;

    public function __construct()
    {
        $this->request = Services::request();
        $this->userModel = new UserModel($this->request);
        $this->userOfficeModel = new UserOfficeModel($this->request);
        $this->userRoleModel = new UserRoleModel($this->request);
        $this->roleModel = new RoleModel($this->request);

        $this->oauth = new Oauth();
		$this->requestOauth = new Request();

        $this->session = session(); 

     
    }
    public function index()
    {
        $data = array(
            "header"=> array(
                "title"=>$this->session->get('name')." -  ". $this->session->get('rolename'),
                "id"=>$this->session->get('id'),
                "name"=>$this->session->get('name'),
            ),
            "title"=>"Data Menu",
            "css"=> global_css(),
            "extends_css"=>datatablescss(),
            "js"=>global_js(),
            "extends_js"=>array_merge(datatablesjs_js(),array("/js/users.js")),
            "view"=>"datamaster/users/users"
        );
       
        return view('index',$data);
    }
    public function data()
    {
       
      
        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->userModel ->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            foreach ($lists as $list) {

                $resetPassword = '<button type="button" onclick="reset_password('.$list->userid.')" class="btn btn-danger waves-effect waves-light"> <i class="bx bx-cog font-size-16 align-middle me-2"></i> Reset Password </button>';
                $lockUser = '<button type="button" onclick="lock_user('.$list->userid.','.$list->banned.')"  class="btn btn-warning waves-effect waves-light"> <i class="bx bx-block font-size-16 align-middle me-2"></i> Banned  </button>';
                $editUser  = '<button type="button"   id="edit_role_'.$list->userid.'" name="'.$list->fullname.'" email="'.$list->email.'"  phone="'.$list->phone.'"  gender="'.$list->gender.'"  onclick="edit_user('.$list->userid.',this.id)" class="btn btn-info waves-effect waves-light"> <i class="bx bxs-user-detail font-size-16 align-middle me-2"></i> Edit Data </button>';
                $setAksesUser = '<button type="button"  onclick="change_access('.$list->userid.',\''.$list->roleid.'\',\''.$list->role_name.'\')" class="btn btn-success waves-effect waves-light"> <i class="bx bx-user-circle font-size-16 align-middle me-2"></i> Hak Akses  </button>';
                $pindahOffice = '<button type="button" onclick="change_office('.$list->userid.',\''.$list->officeid.'\',\''.$list->dealer.'\')" class="btn btn-success waves-effect waves-light"> <i class="bx bx-user-circle font-size-16 align-middle me-2"></i> Pindah Dealer  </button>';
                $button = '<div class="d-flex flex-wrap gap-2">
                '.$resetPassword.'
                '.$lockUser.'
                '.$setAksesUser.'
                '.$editUser.'
                '.$pindahOffice.'
                </div>';

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->fullname;
                $row[] = $list->email;
                $row[] = $list->phone;
                $row[] = $list->dealer;
                $row[] = $list->role_name;
                if($list->banned==1){
                    $btnStatus ='<div class="text-center"> <span class="badge rounded-pill badge-soft-danger font-size-11">Inactive</span></div>';
                }else{
                    $btnStatus ='<div class="text-center"> <span class="badge rounded-pill badge-soft-info font-size-11">Active</span></div>';
                }
                $row[] = $btnStatus;
                $row[] = $button;
                $row[] = $list->banned;
                $row[] =$list->area;
 
                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->userModel->countAll(),
                'recordsFiltered' => $this->userModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    public function login(){
	

		$respond = $this->oauth->server->handleTokenRequest($this->requestOauth->createFromGlobals());
       
       
        $code = $respond->getStatusCode();
		$body = json_decode($respond->getResponseBody());
        
   
        $userid =  $this->userModel->GetUserID($body->access_token);

    
        
        if($userid==""){
            $body->error ="invalid_role";
        }else{
            
            $dataRole =  $this->userModel->getRoleUserByID($userid['userid']);
    
            if($dataRole==""){
                $body->error ="invalid_role";
            }
            $dataOffice =  $this->userModel->getOfficeUserByID($userid['userid']);
            $listarea = array();
            if($dataRole['area']!=""){
                $listarea = $this->userRoleModel->getOfficeGroup($dataRole['area']);
            }

            if($dataOffice==""){
                $body->error ="invalid_office";
            }
        
            $officeid = 0;
            if($dataOffice!=""){
                $officeid = $dataOffice['officeid'];
                $officename = $dataOffice['office_name'];
            }
            $dataSession= array(
                "id" => $userid['userid'],
                "name" => $userid['fullname'],
                "email" => $userid['email'],
                "phone" => $userid['phone'],
                "roleid" => $dataRole['roleid'],
                "rolecode" => $dataRole['routes'],
                "rolename" => $dataRole['name'],
                "officeid"=> $officeid,
                "office_name"=> $officename,
                "area" => json_decode(json_encode($listarea), true),
                "menu"=> $this->roleModel->getMenuRole($dataRole['roleid'])
            );
            $this->session->set($dataSession);
        }
		return $this->respond($body, $code);
	}

	public function register(){
		$data = [];
		if($this->request->getMethod() != 'post')
			return $this->fail('Only post request is allowed');


		$rules = [
			'firstname' => 'required|min_length[3]|max_length[20]',
			'lastname' => 'required|min_length[3]|max_length[20]',
			'email' => 'required|valid_email|is_unique[users.email]',
			'password' => 'required|min_length[8]',
			'password_confirm' => 'matches[password]',
		];

		if(! $this->validate($rules)){
			return $this->fail($this->validator->getErrors());
		}else{

			$data = [
			'firstname' => $this->request->getVar('firstname'),
			'lastname' => $this->request->getVar('lastname'),
			'email' => $this->request->getVar('email'),
			'password' => $this->request->getVar('password'),
			];

			$user_id = $this->userModel->insert($data);
			$data= $user_id;

			unset($data['password']);

			return $this->respondCreated($data);
		}

	}
    public function datalist()
    {
        
        $lists = $this->userModel ->listUsers();
        $data = [];

        foreach ($lists as $list) {
            $row = array(
                "id"=>$list->userid,
                "text"=>$list->fullname." - ".$list->email
            );
            $data[] = $row;
        }

        
        echo json_encode($data);
    }

    function lock(){

        $data = array(
            'banned'=> $_POST['banned'],
        );
        $hasil = $this->userModel->where('userid',$_POST['userid'])->set($data)->update();
        if($hasil!=0){
            successJsonResponse($hasil); 
        }else{
            failedJsonResponse($hasil);
        }
    }

    public function setofficeuser()
    {
        $dataoffice = $this->userOfficeModel->checkUserHaveOffice();
        $datarole = $this->userRoleModel->checkUserHaveRole();
        if($datarole['roleid']==4 ){
            $checkRoleinOffice = $this->userRoleModel->checkRoleInOffice($_POST['officeid'],$datarole['roleid'],$_POST['userid']);
            $officeData = $this->userOfficeModel->getOfficeByID($_POST['officeid']);
            if( count($checkRoleinOffice) > 0){
                errorJsonResponse("role_ready_set", $officeData['office_name']." tersebut telah memiliki ".$datarole['name']);
                exit();
            }
        }

      
        if($dataoffice==""){
            $data = array(
                "officeid"=>$_POST['officeid'],
                "userid"=>$_POST['userid'],
            );
            
            $hasil = $this->userOfficeModel->insert($data);
            if($hasil!=0){
                successJsonResponse($hasil); 
            }else{
                failedJsonResponse($hasil);
            }
        }else{
            $data = array(
                "officeid"=>$_POST['officeid'],
                "userid"=>$_POST['userid'],
            );
            
            $hasil = $this->userOfficeModel->where('user_orrice_id', $dataoffice['user_orrice_id'])->set($data)->update();
            if($hasil!=0){
                successJsonResponse($hasil); 
            }else{
                failedJsonResponse($hasil);
            }
        }
    }
    public function setRoleUsers()
    {
        $dataRole = $this->userRoleModel->checkUserHaveRole();

        if($_POST['roleid']==4){
            $dataoffice = $this->userOfficeModel->checkUserHaveOffice();
            $datacheckrole = $this->userRoleModel->checkRoleID($_POST['roleid']);
            $checkRoleinOffice = $this->userRoleModel->checkRoleInOffice($dataoffice['officeid'],$_POST['roleid'],$_POST['userid']);
            if( count($checkRoleinOffice) > 0){
                errorJsonResponse("role_ready_set",$dataoffice['office_name']." tersebut telah memiliki ".$datacheckrole['name']);
                exit();
            }
        }
        if($dataRole==""){
            $data = array(
                "roleid"=>$_POST['roleid'],
                "userid"=>$_POST['userid'],
                "area"=>$_POST['area'],
            );
            
            $hasil = $this->userRoleModel->insert($data);
            if($hasil!=0){
                successJsonResponse($hasil); 
            }else{
                failedJsonResponse($hasil);
            }
        }else{
            $data = array(
                "roleid"=>$_POST['roleid'],
                "userid"=>$_POST['userid'],
                "area"=>$_POST['area'],
            );
            
            $hasil = $this->userRoleModel->where('user_role_id', $dataRole['user_role_id'])->set($data)->update();
            if($hasil!=0){
                successJsonResponse($hasil); 
            }else{
                failedJsonResponse($hasil);
            }
        }
    }

    public function  gender()
    {
        
        $data = [];
        $publish = array(
            "id"=>1,
            "text"=>"PRIA"
        );
        $data[] = $publish;

        $unpublish = array(
            "id"=>2,
            "text"=>"WANITA"
        );
        $data[] = $unpublish;
        return $this->response->setJSON($data);
    }
    public function save(){
        $data = [
			'fullname' => $this->request->getVar('name'),
			'email' => $this->request->getVar('email'),
			'phone' => $this->request->getVar('phone'),
			'password' => $this->request->getVar('password'),
			'gender' => $this->request->getVar('gender'),
		];

        $user_id = $this->userModel->insert($data);
        if($user_id!=0){
            successJsonResponse($user_id); 
        }else{
            failedJsonResponse($user_id);
        }
    }
    public function updateUser(){
        $data = [
			'fullname' => $this->request->getVar('name'),
			'email' => $this->request->getVar('email'),
			'phone' => $this->request->getVar('phone'),
			'gender' => $this->request->getVar('gender'),
		];

        $user_id = $this->userModel->where('userid', $this->request->getVar('userid'))->set($data)->update();
        if($user_id!=0){
            successJsonResponse($hasil); 
        }else{
            failedJsonResponse($hasil);
        }
    }

    public function updatePassword(){
        $data = [
			'password' => $this->request->getVar('password'),
		];

        $user_id = $this->userModel->where('userid', $this->request->getVar('userid'))->set($data)->update();
        if($user_id!=0){
            successJsonResponse($user_id); 
        }else{
            failedJsonResponse($user_id);
        }
    }
}
