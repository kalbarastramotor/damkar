<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MenuModel;
use Config\Services;

class Menu extends BaseController
{
    public function __construct()
    {
        $this->request = Services::request();
        $this->menuModel = new MenuModel($this->request);
        $this->session = session();
        $this->data_session = array(
            "title" => $this->session->get('name') . " -  " . $this->session->get('rolename'),
            "id" => $this->session->get('id'),
            "name" => $this->session->get('name'),
        );
    }

    public function index()
    {
        $data = array(
            "header" => $this->data_session,
            "title" => "Data Menu",
            "css" => global_css(),
            "extends_css" => datatablescss(),
            "js" => global_js(),
            "extends_js" => array_merge(datatablesjs_js(), array("/js/menu.js")),
            "view" => "datamaster/menu/menu"
        );
        return view('index', $data);
    }

    public function data()
    {

        if ($this->request->getMethod(true) === 'POST') {
            $lists = $this->menuModel->getDatatables();
            $data = [];
            $no = $this->request->getPost('start');

            $buttondetail = false;
            if ($this->request->getPost('parent') != '') {
                $buttondetail = true;
            }


            foreach ($lists as $list) {
                $no++;
                $row = [];
                $row[] = $list->publish;
                $row[] = $no;
                $row[] = $list->name;
                $row[] = $list->code;
                $row[] = $list->url;

                $iconLock = 'bx-lock-open-alt';
                if ($list->publish == 1) {
                    $iconLock = ' <button onclick="lock_menu(' . $list->menuid . ',' . $list->publish . ',' . $buttondetail . ')" type="button" class="btn btn-soft-info waves-effect waves-light"><i class="bx bx-lock-open-alt font-size-16 align-middle"></i></button>';
                    $row[] = '<button type="button" class="btn btn-soft-success btn-rounded waves-effect waves-light">Active</button>';
                } else {
                    $iconLock = ' <button onclick="lock_menu(' . $list->menuid . ',' . $list->publish . ',' . $buttondetail . ')" type="button" class="btn btn-soft-danger waves-effect waves-light"><i class="bx bx-lock-alt font-size-16 align-middle"></i></button>';
                    $row[] = '<button type="button" class="btn btn-soft-danger btn-rounded waves-effect waves-light">Inactive</button>';
                }

                $editButton = ' <button id="edit_menu' . $list->menuid . '" onclick="edit_menu(' . $list->menuid . ',this.id)"  menuid="' . $list->menuid . '" menu_name="' . $list->name . '"  menu_code="' . $list->code . '"  menu_url="' . $list->url . '"  menu_status="' . $list->publish . '" menu_parentid="' . $list->parentid . '"  type="button" class="btn btn-soft-danger waves-effect waves-light"><i class="bx bx-edit font-size-16 align-middle"></i></button>';

                if ($buttondetail) {
                    $row[] = '
                    <div class="d-flex flex-wrap gap-2">
                    ' . $iconLock . '
                    ' . $editButton . '
                    </div>
                ';
                } else {
                    $row[] = '
                    <div class="d-flex flex-wrap gap-2">
                    <button onclick="detail_menu(' . $list->menuid . ',\'' . $list->name . '\')" type="button" class="btn btn-soft-info waves-effect waves-light"><i class="bx bx-detail font-size-16 align-middle"></i></button>     
                    ' . $iconLock . '
                    ' . $editButton . '
                    </div>
                ';
                }

                $data[] = $row;
            }

            $output = [
                'draw' => $this->request->getPost('draw'),
                'recordsTotal' => $this->menuModel->countAll(),
                'recordsFiltered' => $this->menuModel->countFiltered(),
                'data' => $data
            ];

            echo json_encode($output);
        }
    }
    function lock()
    {

        $hasil = $this->menuModel->where('menuid', $_POST['menuid'])->set(array('publish' => $_POST['status']))->update();
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }

    public function parentMenu()
    {

        $lists = $this->menuModel->parentMenu();
        $data = [];
        $parent = array(
            "id" => 0,
            "text" => "PARENT"
        );
        $data[] = $parent;
        foreach ($lists as $list) {
            $row = array(
                "id" => $list->menuid,
                "text" => $list->name
            );
            $data[] = $row;
        }

        return $this->response->setJSON($data);
    }
    public function publishMenu()
    {

        $lists = $this->menuModel->parentMenu();
        $data = [];
        $publish = array(
            "id" => 1,
            "text" => "PUBLISH"
        );
        $data[] = $publish;

        $unpublish = array(
            "id" => 0,
            "text" => "UNPUBLISH"
        );
        $data[] = $unpublish;
        return $this->response->setJSON($data);
    }
    public function getMenuNameByID()
    {
        $id = "";
        if (isset($_POST['menuid'])) {
            $id = $_POST['menuid'];
        }
        $data = $this->menuModel->getMenuNameByID($id);
        if ($data == "") {
            $data = array(
                "name" => "PARENT"
            );
            return $this->response->setJSON($data);
        } else {
            return $this->response->setJSON($data);
        }
    }
    public function save()
    {

        if (count($_POST) == 0) {
            failedJsonResponse(false);
        }


        $data = array(
            'name' => $_POST['menu_name'],
            'code' => $_POST['menu_code'],
            'url' => $_POST['menu_url'],
            'parentid' => $_POST['menu_parent'],
            'publish' => $_POST['menu_status'],
            'type' => ($_POST['menu_parent'] == 0) ? 1 : 2,
        );
        if ($_POST['menuid'] == "") {
            $hasil = $this->menuModel->insert($data);
        } else {
            $hasil = $this->menuModel->where('menuid', $_POST['menuid'])->set($data)->update();
        }
        $hasil = $this->menuModel->where('menuid', $_POST['menuid'])->set($data)->update();
        if ($hasil != 0) {
            successJsonResponse($hasil);
        } else {
            failedJsonResponse($hasil);
        }
    }
}
