<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\RoleMenuModel;
use App\Models\UserRoleModel;


use Config\Services;
use OAuth2\Request;

class Crontab extends BaseController
{
    protected RoleMenuModel $roleMenuModel;
    protected RoleModel $roleModel;
    protected UserRoleModel $userRoleModel;

    public $request;

    protected $session;
    protected $data_session;

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
