<?php

namespace App\Models;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class EventHistoryModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_events_history';
    protected $primaryKey       = 'idhistory';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['userid', 'notes', 'status', 'create_time', 'eventid', 'role_code'];
    protected $request;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function getHistoryEvent($id)
    {
        $where = ['eventid' => $id];
        $query = $this->db->table($this->table);
        $query->join('tb_users', 'tb_users.userid = tb_events_history.userid');
        $query->select('tb_events_history.notes, tb_events_history.status, tb_events_history.create_time, tb_events_history.eventid, tb_users.fullname as userid,tb_events_history.role_code');
        $query->orderBy("tb_events_history.idhistory", "desc");
        $query->where($where);
        $data = $query->get()->getResult();
        return $data;
    }

    public function getApproval($id)
    {
        $where = ['eventid' => $id, 'tb_events_history.status' => 2];
        $query = $this->db->table($this->table);
        $query->join('tb_users', 'tb_users.userid = tb_events_history.userid');
        $query->select('tb_events_history.role_code');
        $query->where($where);
        $data = $query->get()->getResult();
        $arrayResult = array();
        foreach ($data as $key => $value) {
            array_push($arrayResult, $value->role_code);
        }
        return $arrayResult;
    }
}
