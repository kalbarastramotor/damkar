<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\RoleMenuModel;
use App\Models\UserRoleModel;


use Config\Services;

class Crontab extends BaseController
{
    public function __construct()
    {
        $this->request = Services::request();
        $this->roleModel = new RoleModel($this->request);
        $this->roleMenuModel = new RoleMenuModel($this->request);
        $this->userRoleModel = new UserRoleModel($this->request);
        
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
            "status"=>true
        );
        return $this->response->setJSON($data);

    }

}
