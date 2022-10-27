<?php

namespace App\Controllers;


use App\Controllers\BaseController;
use App\Models\RoleModel;
use App\Models\RoleMenuModel;
use App\Models\UserRoleModel;


use Config\Services;

class Role extends BaseController
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
            "header" => $this->data_session,
            "title" => "Data Role",
            "css" => global_css(),
            "extends_css" => datatablescss(),
            "js" => global_js(),
            "extends_js" => array_merge(
                array(
                    "/js/role.js",
                ),
                datatablesjs_js()

            ),
            "view" => "datamaster/role/role"
        );
        return view('index', $data);
    }

    // Get Data
    public function data()
    {


        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->roleModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');


            foreach ($lists as $list) {

                $btnDetail = '<button class="btn btn-soft-info waves-effect waves-light" onclick="detail_role(' . $row[] = $list->roleid . ',\'' . $list->name . '\')"><i class="bx bx-detail font-size-16 align-middle"></i></button> ';

                $btnEdit = '<button type="button" class="btn btn-soft-primary waves-effect waves-light" 
                id="update_role_' . $list->roleid . '"
                onclick="update_role(' . $list->roleid . ',this.id)"
                roleid="' . $list->roleid . '"
                name="' . $list->name . '"
                routes="' . $list->routes . '"
                publish="' . $list->publish . '"
                ><i class="bx bx-edit-alt font-size-16 align-middle"></i></button>';

                $btnDelete = '<button type="button" class="btn btn-soft-danger waves-effect waves-light"  onclick="delete_role(' . $list->roleid . ',\'' . $list->name . '\')"><i  class="bx bx-trash-alt font-size-16 align-middle"></i></button>';

                $button =

                    '<div class="d-flex flex-wrap gap-2">  
                    ' . $btnDetail . ' 
                    ' . $btnEdit . '     
                    ' . $btnDelete . '    
                    </div>';

                $no++;
                $row = [];
                $row[] = $no;
                $row[] = $list->name;
                $row[] = $list->routes;
                if ($list->publish == "1") {
                    $row[] = '<button type="button" class="btn btn-soft-success btn-rounded waves-effect waves-light">Active</button>';
                } else {
                    $row[] = '<button type="button" class="btn btn-soft-danger btn-rounded waves-effect waves-light">Inactive</button>';
                }
                $row[] = $button;
                $data[] = $row;
            }


            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->roleModel->countAll(),
                'recordsFiltered' => $this->roleModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    function save()
    {
        $hasil = $this->roleModel->insert($_POST);
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }
    function delete()
    {

        $hasil = $this->roleModel->where('roleid', $_POST['roleid'])->delete();
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }

    public function menu_data()
    {

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->roleModel->getDatatablesDetail();
            $data = [];
            $no = $this->request->getPost('start');


            foreach ($lists as $list) {

                
                $no++;
                $row = [];
                $row[] = $list->parent_name;
                $row[] = $list->name;
                if ($list->status == 0) {
                    $row[] = '<div class="form-check form-check-right">
                    <input class="form-check-input" id="check_setmenu" type="checkbox" onclick="checklistMenu('.$_POST['roleid'].','.$list->menuid.')">
                </div>';
                } else {
                    $row[] = '<div class="form-check form-check-right">
                    <input class="form-check-input"  id="check_setmenu" type="checkbox" onclick="checklistMenu('.$_POST['roleid'].','.$list->menuid.')" checked>
                </div>';
                }

                
                $data[] = $row;
            }


            $output = [
                'data' => $data
            ];

            echo json_encode($output);
        }
    }

    function update()
    {
        // print_r($_POST);
        // die();
        $data = array(
            "name" => $_POST['name'],
            "routes" => $_POST['routes'],
            "publish" => $_POST['publish']
        );

        $hasil = $this->roleModel->where('roleid', $_POST['roleid'])->set($data)->update();
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }
    // SELECT
    //     tb1.menuid,
    //     tb1.name,
    //     tb2.name as parent_name,
    //     tr.name as role_name,
    //     COALESCE(tbrm.role_menu_id,0) as status_role,
    //     tb1.code,
    //     tb1.url,
    //     tb1.parentid,
    //     tb1.publish,
    //     tb1.type

    // FROM
    //     tb_menu tb1
    //     join tb_menu tb2 on (tb1.parentid=tb2.menuid)
    //     LEFT JOIN tb_role_menu tbrm on (tb1.menuid=tbrm.menuid)
    //     LEFT JOIN tb_role tr on (tbrm.roleid=tr.roleid)
    //     ORDER BY tb2.menuid ASC;
    public function selectOptionAccess()
    {

        $lists = $this->roleModel->optionList();
        $data = [];

        foreach ($lists as $list) {
            $row = array(
                "id" => $list->roleid,
                "text" => $list->name
            );
            $data[] = $row;
        }


        echo json_encode($data);
    }

    public function getAreaUsers()
    {

        $lists = $this->userRoleModel->checkUserHaveRole();
        $data = [];
        if($lists['area']!=""){
            $listarea = $this->userRoleModel->getOfficeGroupByID($lists['area']);
            foreach ($listarea as $list) {
                $row = array(
                    "id" => $list->id,
                    "text" => $list->code
                );
                $data[] = $row;
            }
        }
        echo json_encode($data);
    }

    public function publishRole()
    {

        $lists = $this->roleModel->publishRole();
        $data = [];
        $publish = array(
            "id" => 1,
            "text" => "Active"
        );
        $data[] = $publish;
        foreach ($lists as $list) {
            $row = array(
                "id" => $list->roleid,
                "text" => $list->name
            );
            $data[] = $row;
        }
        return $this->response->setJSON($data);
    }
    public function add_menu_role()
    {
        $check = $this->roleMenuModel->checkUserHaveRole();
        if($check==""){
            $dataInsert = array(
                "menuid"=>$_POST["menuid"],
                "roleid"=>$_POST["roleid"],
            );

            $hasil = $this->roleMenuModel->insert($_POST);
            if ($hasil != 0) {
                successJsonResponse($hasil);
            } else {
                failedJsonResponse($hasil);
            }
        }else{
            $hasil = $this->roleMenuModel->where('role_menu_id',  $check['role_menu_id'])->delete();
            if ($hasil != 0) {
                successJsonResponse($hasil);
            } else {
                failedJsonResponse($hasil);
            }
        }

        
       
    }
}
