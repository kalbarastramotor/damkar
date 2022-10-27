<?php

namespace App\Controllers;

// use CodeIgniter\RESTful\ResourceController;
use \App\Libraries\Oauth;
use \OAuth2\Request;
use CodeIgniter\API\ResponseTrait;
use App\Models\CityModel;
use Config\Services;



class City extends BaseController
{
	use ResponseTrait;

    public function __construct()
    {
        $this->request = Services::request();
        $this->cityModel = new CityModel($this->request);

        $this->oauth = new Oauth();
		$this->requestOauth = new Request();

        $this->session = session(); 

     
    }
   
    public function optionData()
    {
        $lists = $this->cityModel->optionData();
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
