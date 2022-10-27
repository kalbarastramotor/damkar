<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_menu';
    protected $primaryKey       = 'menuid';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name','code','url','parentid','menuid','publish','icon','display','type','creatby','creattime','editby','edittime','appcode'];

   

    protected $column_order = ['name','code','url','parentid','menuid','publish','icon','display','type','creatby','creattime','editby','edittime','appcode'];
    protected $column_search = ['name','code','url','type'];
    protected $order = ['menuid' => 'ASC'];
    protected $request;
    protected $db;
    protected $dt;


    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table);
        // $this->dt->select('tb_users.userid, tb_users.fullname, tb_users.email, tb_users.phone, tb_office.office_name as dealer, tb_role.name as role_name, tb_users.active as status');
        // $this->dt->join('tb_users_office', 'tb_users.userid = tb_users_office.userid','left');
        // $this->dt->join('tb_office', 'tb_office.officeid = tb_users_office.officeid','left');
        // $this->dt->join('tb_users_role', 'tb_users_role.userid  = tb_users.userid','left');
        // $this->dt->join('tb_role', 'tb_role.roleid  = tb_users_role.roleid','left');

    }
    
    

    private function getDatatablesQuery()
    {
        if($this->request->getPost('status')!=''){
            $this->dt->where('type',$this->request->getPost('status'));
        }

        if($this->request->getPost('parent')!=''){
            $this->dt->where('parentid',$this->request->getPost('parent'));
        }

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
        if($this->request->getPost('status')!=''){
            $tbl_storage->where('type',$this->request->getPost('status'));
        }

        if($this->request->getPost('parent')!=''){
            $tbl_storage->where('parentid',$this->request->getPost('parent'));
        }
        return $tbl_storage->countAllResults();
    }
    

    public function parentMenu()
    {
        $query = $this->db->table('tb_menu');
        $query->where('parentid',0);
        if(isset($_GET['search'])){
            $where = ['name' => $_GET['search'] ];
            $query->or_like($where);
        }
        $data = $query->get()->getResult();
        return $data;
    }
    public function getMenuNameByID($id)
    {
        if($id==0 || $id==""){
            return "";
        }else{
            $query = $this->db->table('tb_menu');
            $query->select("name");
            $query->where('menuid',$id);
            $data = $query->get()->getRow();
            return $data;
        }
    }
}
