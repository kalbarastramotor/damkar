<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class ReportAllModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_events_document';
    protected $primaryKey       = 'documentid';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['documentid', 'nomerdoc', 'month', 'year', 'target', 'budget' ];

   

    protected $column_order = ['documentid', 'nomerdoc', 'month', 'year', 'target', 'budget'];
    protected $column_search = [ 'nomerdoc', 'month', 'year', 'target', 'budget'];
    protected $order = ['documentid' => 'ASC'];
    protected $request;
    protected $db;
    protected $dt;


    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;

        $this->dt = $this->db->table($this->table);
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

        if($this->request->getPost('year')){
           $this->dt->where('year',$this->request->getPost('year'));

        }else{
           $this->dt->where('year',date('Y'));
        }
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

    public function getEventByCategory(){

       
        $query = $this->db->table("tb_events");
        $query = $query->join("tb_office", 'tb_office.officeid = tb_events.officeid');
        $query = $query->where('year',$_POST['tahun']);
        $query = $query->where('month',$_POST['bulan']);
        $query = $query->where('categoryid',$_POST['categoryid']);
        if($this->request->getPost('officeid')!=''){
            $query = $query->where('tb_office.officeid',$_POST['officeid']);
        }
        if ($this->request->getPost('length') != -1)
        $query = $query->limit($this->request->getPost('length'), $this->request->getPost('start'));
  
        $query = $query->get();
        return $query->getResult();

    }
    public function totalEventByCategory(){

        // $query = $this->db->->selectCount('eventid');
        $query = $this->db->table("tb_events");
        $query = $query->join("tb_office", 'tb_office.officeid = tb_events.officeid');
        $query = $query->where('year',$_POST['tahun']);
        $query = $query->where('month',$_POST['bulan']);
        $query = $query->where('categoryid',$_POST['categoryid']);
        if($this->request->getPost('officeid')!=''){
            $query = $query->where('tb_office.officeid',$_POST['officeid']);
        }
        
        // if ($this->request->getPost('length') != -1)
        // $query = $query->limit($this->request->getPost('length'), $this->request->getPost('start'));
  

        // print_r($this->request->getPost());
        // die();
        // // $query = $query->get();
        return $query->countAllResults();
        
        // return $query->getResult();

    }
    public function queryDashboardTotalEvent(){

        $query = $this->db->query("SELECT categoryid,status,COUNT(eventid) as total FROM tb_events WHERE status is NOT Null   AND categoryid!=0 GROUP BY categoryid,status");
        return $query->getResult();
    }
    public function getEventRunning(){


        $query = $this->db->table("tb_events");
        $query = $query->select("tb_events.eventid, tb_events.name, tb_events.date_start, tb_events.date_end, tb_events.location, tb_events.status, tb_events.target_visitor, tb_events.target_sell, tb_office.office_code, tb_office.office_name, tb_events_category.name as category_name");
        $query = $query->join("tb_office", 'tb_office.officeid = tb_events.officeid');
        $query = $query->join("tb_events_category", 'tb_events_category.id = tb_events.categoryid');
        $query = $query->where('status',4);
        $query = $query->get();
        return $query->getResult();
    }

    public function queryListCabang(){
        $sql ="SELECT DISTINCT office_group ,  GROUP_CONCAT(officeid) office_id FROM tb_office  GROUP BY office_group";
        $query = $this->db->query($sql);
        return $query->getResult();
    }
    public function totalEventPerCabang($id){
        $sql ="SELECT count(eventid) as total FROM tb_events WHERE officeid IN (".$id.") and status!=0;";
        $query = $this->db->query($sql);
        return $query->getRowArray();
    }
    public function mapsClick($eventid){

        $sql ="
        SELECT
            tb_events.categoryid,
            COUNT(tb_events.categoryid) AS total,
            tb_events_category.name,
            tb_events_category.code
        FROM
            tb_events
        JOIN tb_events_category ON(
                tb_events.categoryid = tb_events_category.id
            )
        WHERE
            officeid = ".$eventid." AND DATE_FORMAT(tb_events.date_end, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')
        GROUP BY
            tb_events.categoryid
        ";
        $query = $this->db->query($sql);
        $data =[];
        foreach ($query->getResult() as $list) {
            $data[ $list->code] =$list->total;
        }

        return $data;

    }

    public function getTotalMaps($eventid){
        $sql ="
        SELECT
            tb_events.status, 
            COUNT(tb_events.status) AS total
        FROM
            tb_events
        WHERE
            officeid = ".$eventid." AND DATE_FORMAT(tb_events.date_end, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')
            GROUP by tb_events.status
        ";
         $query = $this->db->query($sql);
         $data =[];
         foreach ($query->getResult() as $list) {
             $data[ $list->status] =$list->total;
         }
 
         return $data;
    }
    function getActualEventReport($year,$month){
        $sql="
        SELECT
		    SUM(butget) as actual_butget,
            COUNT(eventid) as actual_event
        FROM
            tb_events 
            WHERE month = ".$month."
            and year = ".$year;
    
        $query = $this->db->query($sql);
        $results =  $query->getRowArray();
        $data = [];
        $data['actual_butget'] = $results['actual_butget'];
        $data['actual_event'] = $results['actual_event'];
        return $data;
    
    }
    function getDataActualMaps($eventid){
        $sql ="
        SELECT
            sum(actual_visitor) as actual_visitor ,
            sum(actual_sell) as actual_sell,
            sum(target_actual_prospect) as target_actual_prospect
        FROM
            tb_events
        WHERE
            officeid = ".$eventid."  AND DATE_FORMAT(tb_events.date_end, '%Y-%m') = DATE_FORMAT(CURRENT_DATE(), '%Y-%m')
        ";

        $query = $this->db->query($sql);
        $results =  $query->getRowArray();
        $data = [];
        $data['actual_visitor'] = $results['actual_visitor'];
        $data['actual_sell'] = $results['actual_sell'];
        $data['target_actual_prospect'] = $results['target_actual_prospect'];
        return $data;

    }

   
}
