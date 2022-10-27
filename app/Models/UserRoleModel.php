<?php

namespace App\Models;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class UserRoleModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_users_role';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_role_id', 'userid', 'roleid','area'];

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }
    public function checkUserHaveRole()
    {
        $query = $this->db->table($this->table);
        $where = ['userid' =>  $this->request->getPost('userid')];
        $query->where($where);
        $data = $query->get()->getRowArray();
        return $data;
    }

    public function getOfficeGroup($id)
    {
        $query = $this->db->table('tb_office_group');
        $query->whereIn('id',explode(',',$id));
        $data = $query->get()->getResult();
        $results = array();
        foreach ($data as $key => $value) {
            $results[] = $value->code;
        }
        return $results;
    }

    public function getOfficeGroupByID($id)
    {
        $query = $this->db->table('tb_office_group');
        $query->whereIn('id',explode(',',$id));
        $data = $query->get()->getResult();
       
        return $data;
    }



}
