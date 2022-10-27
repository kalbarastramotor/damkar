<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_role';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['roleid', 'name', 'routes', 'creatby', 'creattime', 'editby', 'edittime', 'publish'];

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
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];



    protected $column_order = ['tb_role.roleid', 'tb_role.name', 'tb_role.routes', 'tb_role.creatby', 'tb_role.creattime', 'tb_role.editby', 'tb_role.edittime', 'tb_role.publish'];
    protected $column_search = ['tb_role.roleid', 'tb_role.name', 'tb_role.routes', 'tb_role.creatby', 'tb_role.creattime', 'tb_role.editby', 'tb_role.edittime', 'tb_role.publish'];
    protected $order = ['roleid' => 'DESC'];

    protected $column_order_detail = ['tb1.menuid', 'tb1.name', 'tb_menu.name as parent_name', 'tb_role.name as role_name', 'COALESCE(tb_role_menu.role_menu_id', '0) as status_role', 'tb1.code', 'tb1.url', 'tb1.parentid', 'tb1.publish', 'tb1.type'];
    protected $column_search_detail = ['tb1.menuid', 'tb1.name', 'tb_menu.name as parent_name', 'tb_role.name as role_name', 'COALESCE(tb_role_menu.role_menu_id', '0) as status_role', 'tb1.code', 'tb1.url', 'tb1.parentid', 'tb1.publish', 'tb1.type'];
    protected $order_detail = ['tb1.menuid' => 'DESC'];


    protected $request;
    protected $db;
    protected $dt;

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table);
        $this->dt->select('tb_role.roleid, tb_role.name, tb_role.routes, tb_role.creatby, tb_role.creattime, tb_role.editby, tb_role.edittime, tb_role.publish');

        // query detail 

        $this->detail = $this->db->table('tb_menu as tb1')
            ->select('tb1.menuid, tb1.name, tb_menu.name as parent_name, tb_role.name as role_name, COALESCE(tb_role_menu.role_menu_id,0) as status_role, tb1.code, tb1.url, tb1.parentid, tb1.publish, tb1.type')
            ->join('tb_menu', 'tb1.parentid=tb_menu.menuid')
            ->join('tb_role_menu', 'tb1.menuid=tb_role_menu.menuid OR tb_role_menu.menuid is null', 'LEFT')
            ->join('tb_role', 'tb_role_menu.roleid=tb_role.roleid ');
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

    // detail data role 

    private function getDatatablesQueryDetail()
    {
        $i = 0;
        if($this->request->getPost('roleid')!=0){
            $where = ['tb_role.roleid' => $this->request->getPost('roleid')];
            $this->detail->where($where);
            $this->detail->OrWhere('tb_role_menu.roleid is null',NULL, FALSE);;

        }
     
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
        $sql = "
            SELECT
                tb1.menuid,
                UPPER(tb1.name) as name,
                UPPER(tb_menu.name) AS parent_name,
                (SELECT role_menu_id FROM tb_role_menu WHERE tb_role_menu.menuid =  tb1.menuid AND tb_role_menu.roleid=".$this->request->getPost('roleid').") as status,
                tb1.code,
                tb1.url,
                tb1.parentid,
                tb1.publish,
                tb1.type
            FROM
                tb_menu AS tb1
            JOIN tb_menu ON(tb_menu.menuid = tb1.parentid)
            WHERE
                tb1.parentid != 0
                and 
                tb1.publish =1
        ";
        $query = $this->db->query($sql);
        return $query->getResult();
    }

    public function getMenuRole($id)
    {
        $sql = "
            SELECT
            tb1.menuid,
            UPPER(tb1.name) as name,
            UPPER(tb_menu.name) AS parent_name,
            tb1.url
        FROM
            tb_menu AS tb1
        JOIN tb_menu ON
            (tb_menu.menuid = tb1.parentid)
        JOIN tb_role_menu ON(tb_role_menu.menuid = tb1.menuid)
        WHERE
            tb_role_menu.roleid = ".$id." AND tb1.parentid != 0 AND tb1.publish = 1
        ORDER BY
            tb1.menuid ASC;
        ";
        $query = $this->db->query($sql);
        $array = array();
        foreach ($query->getResult() as $key => $value) {
            $index =strtolower( str_replace(" ","",$value->parent_name));
            $array[$index]['name']= $value->parent_name;
            $array[$index]['data'][] =  json_decode(json_encode($value), true); 
        }
        $results = array();
        foreach ($array as $key => $value) {
            $results[] = $value;
        }

       
        return $results;
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

    public function publishRole()
    {
        $query = $this->db->table('tb_role');
        $query->where('publish', 0);
        if (isset($_GET['search'])) {
            $where = ['name' => $_GET['search']];
            $query->or_like($where);
        }
        $data = $query->get()->getResult();
        return $data;
    }

  

}
