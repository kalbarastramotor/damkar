<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class EventcategoryModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_events_category';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'name', 'code'];



    protected $column_order = ['tb_events_category.id', 'tb_events_category.name', 'tb_events_category.code'];
    protected $column_search = ['id', 'name', 'code'];
    protected $order = ['id' => 'ASC'];
    protected $request;
    protected $db;
    protected $dt;


    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table);
        $this->dt->select('tb_events_category.id, tb_events_category.name, tb_events_category.code');
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
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }

    private function getDatatablesQueryDetail()
    {
        $i = 0;
        foreach ($this->column_search_detail as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->detail->groupStart();
                    $this->detail->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->detail->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search_detail) - 1 == $i)
                    $this->detail->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->detail->orderBy($this->column_order_detail[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order_detail)) {
            $order = $this->order_detail;
            $this->detail->orderBy(key($order), $order[key($order)]);
        }
    }

    public function getDatatablesDetail()
    {
        $this->getDatatablesQueryDetail();
        if ($this->request->getPost('length') != -1)
            $this->detail->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->detail->get();
        return $query->getResult();
    }

    public function countFilteredDetail()
    {
        $this->getDatatablesQuery();
        return $this->detail->countAllResults();
    }

    public function countAllDetail()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }
    public function optionList()
    {

        $query = $this->db->table($this->table);
        if (isset($_GET['search'])) {
            $where = ['name' => $_GET['search']];
            $query->like($where);
        }
        $query->limit(5);
        $data = $query->get()->getResult();
        return $data;
    }
}
