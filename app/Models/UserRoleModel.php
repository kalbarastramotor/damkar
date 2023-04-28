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
        $query = $this->db->table('tb_users_role');
        $query->join('tb_role', 'tb_role.roleid = tb_users_role.roleid');
        $where = ['userid' =>  $this->request->getPost('userid')];
        $query->where($where);
        $data = $query->get()->getRowArray();
        return $data;
    }
    public function checkRoleID($roleid)
    {
        $query = $this->db->table('tb_role');
        $where = ['roleid' =>  $roleid];
        $query->where($where);
        $data = $query->get()->getRowArray();
        return $data;
    }

    function checkRoleInOffice($officeid,$roleid,$userid){
        $where = ['tur.roleid' => $roleid,'tuo.officeid' => $officeid,'tuo.userid != '=>$userid];
        $query = $this->db->table("tb_users_office as tuo");
        $query->join('tb_users_role as tur', 'tuo.userid = tur.userid');
        $query->select('tuo.officeid , tur.roleid ,  tur.userid ');
        $query->where($where);
        $data = $query->get()->getResult();
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
