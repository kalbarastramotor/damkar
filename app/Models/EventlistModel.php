<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class EventlistModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_events';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'eventid', 'userid', 'event_plan_id', 'name', 'cover', 'location', 'date_start', 'date_end', 'status', 'location_lat', 'location_long', 'description', 'total_approval', 'documentid', 'officeid', 'categoryid', 'month', 'year', 'target', 'butget', 'target_visitor', 'actual_visitor', 'target_sell', 'actual_sell', 'target_prospect', 'target_actual_prospect'
    ];



    protected $column_order = [
        'tb_events.eventid', 'tb_events.name', 'tb_events.cover', 'tb_events.date_start', 'tb_events.date_end',
        'tb_events.status', 'tb_events.location_lat', 'tb_events.location_long', 'tb_events.description', 'tb_events.documentid', 'tb_events.officeid',
        'tb_events.categoryid', 'tb_events.month', 'tb_events.year', 'tb_events.target', 'tb_events.butget', 'tb_events.target_visitor', 'tb_events.actual_visitor',
        'tb_events.target_sell', 'tb_events.actual_sell'
    ];
    protected $column_search = [
        'eventid', 'name', 'cover', 'date_start', 'date_end', 'status', 'location_lat', 'location_long',
        'description', 'documentid', 'officeid', 'categoryid', 'month', 'year', 'target', 'butget',
        'taget_visitor', 'actual_visitor', 'target_sell', 'actual_sell'
    ];
    protected $order = ['eventid' => 'ASC'];
    protected $request;
    protected $db;
    protected $dt;


    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table);
        $this->dt->select(
            'tb_events.eventid, tb_events.name, tb_events.cover, tb_events.date_start, tb_events.date_end, tb_events.status,
            tb_events.location_lat, tb_events.location_long, tb_events.description, tb_events.documentid, tb_events.officeid, tb_events.categoryid,
            tb_events.month, tb_events.year, tb_events.target, tb_events.butget, tb_events.target_visitor, tb_events.actual_visitor,
            tb_events.target_sell, tb_events.actual_sell'
        );
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
