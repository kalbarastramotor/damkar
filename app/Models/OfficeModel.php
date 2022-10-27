<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class OfficeModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_office';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['officeid','office_name','office_code','office_address','office_image','office_phone','office_pic','office_lat','office_long','office_parent_id','office_province','office_city','creatby','creattime','editby','edittime','office_publish','office_delete','tb_users.fullname'];


    protected $column_order = ['tb_office.office_name', 'tb_office.office_code', 'tb_office.office_address', 'tb_office.office_image', 'tb_office.office_phone', 'tb_office.office_lat', 'tb_office.office_long', 'tb_office.office_parent_id', 'tb_office.office_province', 'tb_office.office_city', 'tb_office.creatby','tb_office.office_publish','tb_office.office_delete'];
    protected $column_search = ['tb_office.office_name', 'tb_office.office_code', 'tb_office.office_address', 'tb_office.office_image', 'tb_office.office_phone', 'tb_office.office_lat', 'tb_office.office_long', 'tb_office.office_parent_id', 'tb_office.office_province', 'tb_office.office_city', 'tb_office.creatby','tb_office.office_publish','tb_office.office_delete'];
    protected $order = ['tb_office.officeid' => 'DESC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table);
        $this->dt->select('tb_office.officeid,tb_office.office_name,tb_office.office_code,tb_office.office_address,tb_office.office_image,tb_office.office_phone,tb_users.userid,tb_users.fullname,tb_office.office_lat,tb_office.office_long,tb_office.office_parent_id,tb_office.office_province ,tb_province.name as office_province_name,tb_office.office_city ,tb_city.name as office_city_name,tb_office.creatby,tb_office.office_province,tb_office.office_publish, tb_office.office_delete');
        $this->dt->join('tb_users','tb_users.userid=tb_office.office_pic','left');
        $this->dt->join('tb_province','tb_province.id=tb_office.office_province');
        $this->dt->join('tb_city','tb_city.id=tb_office.office_city');
    }

    private function getDatatablesQuery()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatables()
    {
        $this->getDatatablesQuery();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function getMapOffice(){
        $query = $this->db->table($this->table);
        $query->select('officeid,office_name,office_code,office_address,office_image,office_lat,office_long,office_group');
        return $query->get()->getResult();
       
    }
    public function countFiltered()
    {
        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        return $this->dt->countAllResults();
    }

    public function optionList()
    {
        $query = $this->db->table($this->table);
        if(isset($_GET['search'])){
            $query->like('office_name',$_GET['search']);
            $query->orLike('office_code',$_GET['search']);
        }
        $query->limit(5);
        $data = $query->get()->getResult();
        return $data;
    }

    public function filterOffice()
    {
        $query = $this->db->table($this->table);

        if(isset($_GET['search'])){
            $query->like('office_name',$_GET['search']);
            $query->orLike('office_group',$_GET['search']);
            $query->orLike('office_code',$_GET['search']);
        }
        $query->select('officeid,office_name,office_code,tb_office.office_lat,tb_office.office_long,office_group');
        $data = $query->get()->getResult();

        return $data;
    }
}
