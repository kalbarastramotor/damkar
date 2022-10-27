<?php

namespace App\Models;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class OfficeGroupModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_office_group';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [ 'code'];

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
    }

    public function optionList()
    {
        $query = $this->db->table($this->table);
        if (isset($_GET['search'])) {
            $where = ['code' => $_GET['search']];
            $query->like($where);
        }
        $data = $query->get()->getResult();
        return $data;
    }

}
