<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ReportBtlModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_office';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['officeid','office_name','office_code','office_address','office_image','office_phone','office_pic','office_lat','office_long','office_parent_id','office_province','office_city','creatby','creattime','editby','edittime'];


    protected $column_order = ['officeid','office_name','office_code','office_group'];
    protected $column_search = ['officeid','office_name','office_code','office_group'];
    protected $order = ['office_group' => 'ASC'];
    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table);
        $this->dt->select('officeid,office_name,office_code,office_group');
        $this->dt->orderBy('office_group', 'ASC');
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

    public function countFiltered()
    {
        $this->getDatatablesQuery();
        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        return $this->dt->countAllResults();
    }

    public function getData()
    {
        $query = $this->dt->get();
        return $query->getResult();
    }
}
