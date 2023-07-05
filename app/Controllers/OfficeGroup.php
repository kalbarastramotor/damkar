<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OfficeGroupModel;
use App\Models\OfficeModel;
use Config\Services;



class OfficeGroup extends BaseController
{
    protected OfficeGroupModel $officeGroupModel;

    public $request;

    protected $session;
    protected $data_session;

    public function __construct()
    {
        $this->request = Services::request();
        $this->officeGroupModel = new OfficeGroupModel($this->request);

        $this->session = session();
        $this->data_session = array(
            "title" => $this->session->get('name') . " -  " . $this->session->get('rolename'),
            "id" => $this->session->get('id'),
            "name" => $this->session->get('name'),
        );
    }

    public function selectOptionOfficeGroup()
    {

        $lists = $this->officeGroupModel->optionList();
        $data = [];

        foreach ($lists as $list) {
            $row = array(
                "id" => $list->id,
                "text" => $list->code
            );
            $data[] = $row;
        }


        echo json_encode($data);
    }

}
