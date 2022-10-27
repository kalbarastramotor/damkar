<?php

namespace App\Models;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class EventActivityModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_event_activity';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [ 'date','eventid', 'images', 'status','notes','userid'];

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function getActivityEvent(){
        $where = ['eventid' => $this->request->getPost('eventid')];
        $query = $this->db->table($this->table);
        $query->like($where);
        $data = $query->get()->getResult();
        return $data;
    }
    public function getImageFile($eventid,$date)
    {
        $query = $this->db->table($this->table);
        $where = ['eventid' =>  $eventid,'date'=>$date];
        $query->where($where);
        $data = $query->get()->getRowArray();
        return $data;
    }
    public function getActivityEventByID($eventid){
        $where = ['eventid' => $eventid];
        $query = $this->db->table($this->table);
        $query->like($where);
        $data = $query->get()->getResult();
        return $data;
    }
}
