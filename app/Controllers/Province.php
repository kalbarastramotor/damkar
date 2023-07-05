<?php

namespace App\Controllers;

// use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Oauth;
use App\Models\OfficeGroupModel;
use \OAuth2\Request;
use CodeIgniter\API\ResponseTrait;
use App\Models\ProvinceModel;
use Config\Services;



class Province extends BaseController
{
	use ResponseTrait;

    protected ProvinceModel $provinceModel;

    public $request;

    protected $session;
    protected $data_session;


    protected Oauth $oauth;
    protected Request $requestOauth;


    public function __construct()
    {
        $this->request = Services::request();
        $this->provinceModel = new ProvinceModel($this->request);

        $this->oauth = new Oauth();
		$this->requestOauth = new Request();

        $this->session = session(); 

     
    }
   
    public function optionData()
    {
        $lists = $this->provinceModel->optionData();
        $data = [];
        foreach ($lists as $list) {
            $row = array(
                "id"=>$list->id,
                "text"=>$list->name
            );
            $data[] = $row;
        }
        echo json_encode($data);
    }

}
