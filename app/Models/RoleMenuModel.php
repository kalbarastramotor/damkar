<?php

namespace App\Models;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class RoleMenuModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_role_menu';
    protected $primaryKey       = 'role_menu_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['role_menu_id', 'menuid', 'roleid'];

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }
    public function checkUserHaveRole()
    {
        $query = $this->db->table($this->table);
        $where = [
            'roleid' =>  $this->request->getPost('roleid'),
            'menuid' =>  $this->request->getPost('menuid')
        ];
        $query->where($where);
        $data = $query->get()->getRowArray();
        return $data;
    }



}
