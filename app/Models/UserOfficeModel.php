<?php

namespace App\Models;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class UserOfficeModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_users_office';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_orrice_id', 'userid', 'officeid', 'status', 'date_start', 'date_end'];

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }
    public function checkUserHaveOffice()
    {
        $query = $this->db->table('tb_users_office');
        $query->join('tb_office', 'tb_users_office.officeid = tb_office.officeid');
        $where = ['userid' =>  $this->request->getPost('userid')];
        $query->where($where);
        $data = $query->get()->getRowArray();
        return $data;
    }
    public function checkOfficeRole($officeid)
    {
        $query = $this->db->table($this->table);
        $where = ['officeid' =>  $officeid];
        $query->where($where);
        $data = $query->get()->getRowArray();
        return $data;
    }
    public function getOfficeByID($officeid)
    {
        $query = $this->db->table('tb_office');
        $where = ['officeid' =>  $officeid];
        $query->where($where);
        $data = $query->get()->getRowArray();
        return $data;
    }
}
