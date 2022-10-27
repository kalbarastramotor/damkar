<?php

namespace App\Models;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class CityModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_city';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }
    public function optionData()
    {
        $query = $this->db->table($this->table);
        if(isset($_GET['search'])){
            $where = ['name' => $_GET['search'] ];
            $query->like($where);
        }
        $query->limit(5);
        $data = $query->get()->getResult();
        return $data;
    }

}
