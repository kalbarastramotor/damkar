<?php

namespace App\Models;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['fullname', 'email','password','banned','userid','officeid','gender','phone'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['beforeInsert'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['beforeUpdate'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    protected $column_order = ['tb_users.userid', 'tb_users.fullname', 'tb_users.email','tb_users.phone','tb_office.office_name','tb_role.name','tb_users.active','tb_users.banned'];
    protected $column_search = ['fullname', 'email'];
    protected $order = ['tb_users.userid' => 'ASC'];
    protected $request;
    protected $db;
    protected $dt;


    protected function beforeInsert(array $data){
        $data = $this->passwordHash($data);
        return $data;
    }

    protected function beforeUpdate(array $data){
        $data = $this->passwordHash($data);
        return $data;
    }
    
    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table);
        $this->dt->select('tb_users.userid,tb_users_role.area, tb_users.fullname, tb_users.email, tb_users.phone,tb_office.officeid, tb_office.office_name as dealer,tb_role.roleid, tb_role.name as role_name, tb_users.active as status, tb_users.gender,tb_users.banned');
        $this->dt->join('tb_users_office', 'tb_users.userid = tb_users_office.userid','left');
        $this->dt->join('tb_office', 'tb_office.officeid = tb_users_office.officeid','left');
        $this->dt->join('tb_users_role', 'tb_users_role.userid  = tb_users.userid','left');
        $this->dt->join('tb_role', 'tb_role.roleid  = tb_users_role.roleid','left');

    }
    
    
    protected function passwordHash(array $data){
    if(isset($data['data']['password']))
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

    return $data;
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

    public function GetUserID($access_token)
    {
        $query = $this->db->table('oauth_access_tokens');
        $query->select('tb_users.userid,tb_users.fullname,tb_users.email,tb_users.phone');
        $where = ['access_token' => $access_token];
        $query->join('tb_users','tb_users.userid=oauth_access_tokens.user_id');
      
        $query->where($where);
        $data_access_token = $query->get()->getRowArray();
        return $data_access_token;
    }

    public function getRoleUserByID($userid){

        $query = $this->db->table('tb_role');
        $query->join('tb_users_role','tb_role.roleid=tb_users_role.roleid');
        $where = ['tb_users_role.userid' => $userid];
      
        $query->where($where);
        $data_access_token = $query->get()->getRowArray();
        return $data_access_token;

    }
    public function GetUserIDByID($userid){

        $query = $this->db->table($this->table);
        $query->select('active,email,fullname');
        $where = ['userid' => $userid];
        $query->where($where);
        $data = $query->get()->getRowArray();
        return $data;

    }
    public function getOfficeUserByID($userid)
    {

        $query = $this->db->table('tb_users_office');
        $query->join('tb_office','tb_office.officeid=tb_users_office.officeid');
        $query->select('userid,tb_users_office.officeid,tb_office.office_name');
        $where = ['userid' => $userid];
        $query->where($where);
        $results = $query->get()->getRowArray();
        return $results;
    }

    public function listUsers()
    {
      
        $query = $this->db->table('tb_users');
        if(isset($_GET['search'])){
            $where = ['fullname' => $_GET['search'] ];
            $query->like($where);
        }
        $query->limit(5);
        $data = $query->get()->getResult();
        return $data;
    }

}
