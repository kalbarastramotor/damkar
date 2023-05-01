<?php

namespace App\Models;


use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class EventModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tb_events';
    protected $primaryKey       = 'eventid';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['eventid', 'userid', 'event_plan_id', 'name', 'cover', 'date_start', 'date_end', 'status', 'location_lat', 'location_long', 'description', 'total_approval', 'documentid', 'officeid', 'categoryid', 'month', 'year', 'target', 'butget', 'target_visitor', 'actual_visitor', 'target_sell', 'actual_sell','target_prospect','target_actual_prospect','target_riding','actual_riding'];

    protected $column_order = [
      '','tb_events.name', 'tb_events.date_start', 'tb_events.date_end','', 'tb_events.status','tb_events_category.name', 'tb_office.office_code','tb_office.office_name','tb_office.office_group'
    ];
    protected $column_search = [
        '','tb_events.name', 'tb_events.date_start', 'tb_events.date_end','', 'tb_events.status','tb_events_category.name', 'tb_office.office_code','tb_office.office_name','tb_office.office_group'
    ];

    public function __construct(RequestInterface $request)
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table);
        $this->dt->select('tb_events.eventid, tb_events.name, tb_events.cover, tb_events.date_start, tb_events.date_end, tb_events.status, tb_events.location_lat, tb_events.location_long, tb_events.description, tb_events.documentid, tb_events.officeid, tb_events.categoryid, tb_events.month, tb_events.year, tb_events.target, tb_events.butget, tb_events.target_visitor, tb_events.actual_visitor, tb_events.target_sell, tb_events.actual_sell,tb_office.officeid,tb_office.office_code,tb_office.office_name,tb_events_category.name as category_name,tb_events.userid,tb_office.office_group');
        $this->dt->join('tb_office', 'tb_office.officeid = tb_events.officeid');
        $this->dt->join('tb_events_category', 'tb_events_category.id = tb_events.categoryid');

    }

    private function getDatatablesQuery()
    {
        
      
        if ($this->request->getPost('officeid')!="") {
            $this->dt->where('tb_events.officeid',$this->request->getPost('officeid'));
        }
      
        if ($this->request->getPost('status')!="") {
            $this->dt->where('status',$this->request->getPost('status'));
        }
        if ($this->request->getPost('year')!="") {
            $this->dt->where('year',$this->request->getPost('year'));
        }
        if ($this->request->getPost('month')!="") {
            
            $bulan = $this->request->getPost('month');
            if(strlen($this->request->getPost('month'))==1){
                $bulan = "0". $this->request->getPost('month');
            }
          
            if((int)date("m")!=$this->request->getPost('month')){
                // $this->dt->where('month',$this->request->getPost('month'));
                $this->dt->where('( month ='.$this->request->getPost('month').' or month='.$bulan.')');
            }

        }
        if ($this->request->getPost('categoryid')!="") {
            $this->dt->where('tb_events.categoryid',$this->request->getPost('categoryid'));
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
            if($this->request->getPost('order')['0']['column']==0){
                $this->dt->orderBy('tb_events.eventid','desc');

            }else{
                $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
                
            }
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }else{
            $this->dt->orderBy('tb_events.eventid','desc');
        }
    }

    public function getDatatables()
    {
      
      
        $this->getDatatablesQuery();

        if($_SESSION['rolecode']=='staff'){
            $this->dt->where('( userid ='.$_SESSION['id'].' or tb_events.officeid='.$_SESSION['officeid'].' )');
        }elseif($_SESSION['rolecode']=='spvarea'){
            if(count($_SESSION['area']) > 0){
                $this->dt->whereIn('tb_office.office_group',$_SESSION['area']);
                $this->dt->orWhere('( tb_events.officeid='.$_SESSION['officeid'].' )');
            }else{
                $this->dt->where('tb_events.officeid',$_SESSION['officeid']);
            }
        }elseif($_SESSION['rolecode']=='spvpromosi'){
            $this->dt->where('( userid ='.$_SESSION['id'].' or tb_events.officeid='.$_SESSION['officeid'].' )');
        }elseif($_SESSION['rolecode']=='kabag'){
            $this->dt->where('( status !=0 or userid='.$_SESSION['id'] .')');
        }else{
            $this->dt->where('tb_events.officeid',$_SESSION['officeid']);
        }

       

        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }

    public function countFiltered()
    {
        $this->getDatatablesQuery();

        if($_SESSION['rolecode']=='staff'){
            $this->dt->where('( userid ='.$_SESSION['id'].' or tb_events.officeid='.$_SESSION['officeid'].' )');
        }elseif($_SESSION['rolecode']=='spvarea'){
            if(count($_SESSION['area']) > 0){
                $this->dt->whereIn('tb_office.office_group',$_SESSION['area']);
                $this->dt->orWhere('( tb_events.officeid='.$_SESSION['officeid'].' )');
            }else{
                $this->dt->where('tb_events.officeid',$_SESSION['officeid']);
            }
        }elseif($_SESSION['rolecode']=='spvpromosi'){
            $this->dt->where('( userid ='.$_SESSION['id'].' or tb_events.officeid='.$_SESSION['officeid'].' )');
        }elseif($_SESSION['rolecode']=='kabag'){
            $this->dt->where('( status !=0 or userid='.$_SESSION['id'] .')');
        }else{
            $this->dt->where('tb_events.officeid',$_SESSION['officeid']);
        }


        return $this->dt->countAllResults();
    }

    public function countAll()
    {
        
        $tbl_storage = $this->db->table($this->table);
        $tbl_storage->select('tb_events.eventid, tb_events.name, tb_events.cover, tb_events.date_start, tb_events.date_end, tb_events.status, tb_events.location_lat, tb_events.location_long, tb_events.description, tb_events.documentid, tb_events.officeid, tb_events.categoryid, tb_events.month, tb_events.year, tb_events.target, tb_events.butget, tb_events.target_visitor, tb_events.actual_visitor, tb_events.target_sell, tb_events.actual_sell,tb_office.officeid,tb_office.office_code,tb_office.office_name,tb_events_category.name as category_name,tb_events.userid,tb_office.office_group');
        $tbl_storage->join('tb_office', 'tb_office.officeid = tb_events.officeid');
        $tbl_storage->join('tb_events_category', 'tb_events_category.id = tb_events.categoryid');
        
        if($_SESSION['rolecode']=='staff'){
            $tbl_storage->where('( userid ='.$_SESSION['id'].' or tb_events.officeid='.$_SESSION['officeid'].' )');
        }elseif($_SESSION['rolecode']=='spvarea'){
            if(count($_SESSION['area']) > 0){
                $tbl_storage->whereIn('tb_office.office_group',$_SESSION['area']);
                $tbl_storage->orWhere('( tb_events.officeid='.$_SESSION['officeid'].' )');
            }else{
                $tbl_storage->where('tb_events.officeid',$_SESSION['officeid']);
            }
        }elseif($_SESSION['rolecode']=='spvpromosi'){
            $tbl_storage->where('( userid ='.$_SESSION['id'].' or tb_events.officeid='.$_SESSION['officeid'].' )');
        }elseif($_SESSION['rolecode']=='kabag'){
            $tbl_storage->where('( status !=0 or userid='.$_SESSION['id'] .')');
        }else{
            $tbl_storage->where('tb_events.officeid',$_SESSION['officeid']);
        }



        return $tbl_storage->countAllResults();
    }
    public function getDataEventByID()
    {
        $query = $this->db->table($this->table);
        $query->select('tb_events.userid,tb_events.eventid,tb_events.location, tb_events.name, tb_events.cover, tb_events.date_start, tb_events.date_end, tb_events.status, tb_events.location_lat, tb_events.location_long, tb_events.description, tb_events.documentid, tb_events.officeid, tb_events.categoryid, tb_events.month, tb_events.year, tb_events.target, tb_events.butget, tb_events.target_visitor, tb_events.actual_visitor, tb_events.target_sell, tb_events.actual_sell,tb_office.officeid,tb_office.office_code,tb_office.office_name,tb_events_category.name as category_name, tb_events.target_prospect, tb_events.target_actual_prospect,tb_events.target_riding,tb_events.actual_riding');
        $query->join('tb_office', 'tb_office.officeid = tb_events.officeid');
        $query->join('tb_events_category', 'tb_events_category.id = tb_events.categoryid');
        $query->where('tb_events.eventid',$this->request->getPost('id'));
        return $query->get()->getRowArray();
    }

    public function getMarkerModel()
    {
        $query = $this->db->table($this->table);
        $query->select('tb_events.eventid, tb_events.name, tb_events.cover, tb_events.date_start, tb_events.date_end, tb_events.status, tb_events.location_lat, tb_events.location_long, tb_events.description, tb_events.documentid, tb_events.officeid, tb_events.categoryid, tb_events.month, tb_events.year, tb_events.target, tb_events.butget, tb_events.target_visitor, tb_events.actual_visitor, tb_events.target_sell, tb_events.actual_sell');
        return $query->get()->getResult();
    }

    public function excelReport($officeid,$statusEvent,$category,$tahun,$bulan){
        $query = $this->db->table("tb_events");
        $query->select('tb_events.eventid, 
                tb_events.name, 
                tb_events.cover,
                tb_events.date_start,
                tb_events.date_end, 
                tb_events.status,
                tb_events.location_lat,
                tb_events.location_long,
                tb_events.location,
                tb_events.description,
                tb_events.documentid,
                tb_events.officeid, 
                tb_office.office_code, 
                tb_office.office_name, 
                tb_events.categoryid, 
                tb_events_category.name as category_name,
                tb_events.month, 
                tb_events.year, 
                tb_events.target, 
                tb_events.butget, 
                tb_events.target_visitor, 
                tb_events.actual_visitor,
                tb_events.target_prospect,
                tb_events.target_actual_prospect, 
                tb_events.target_sell, 
                tb_events.actual_sell');
        $query = $query->join("tb_office",'tb_office.officeid = tb_events.officeid');
        $query = $query->join("tb_events_category",'tb_events_category.id = tb_events.categoryid');
       
       
        if($officeid!=0){
            $query->where('tb_office.officeid',$officeid);
        }else{
            if($_SESSION['rolecode']=='staff'){
                $query->where('( userid ='.$_SESSION['id'].' or tb_events.officeid='.$_SESSION['officeid'].' )');
            }elseif($_SESSION['rolecode']=='spvarea'){
                if(count($_SESSION['area']) > 0){
                    $query->whereIn('tb_office.office_group',$_SESSION['area']);
                    $query->orWhere('( tb_events.officeid='.$_SESSION['officeid'].' )');
                }else{
                    $query->where('tb_events.officeid',$_SESSION['officeid']);
                }
            }elseif($_SESSION['rolecode']=='spvpromosi'){
                $query->where('( userid ='.$_SESSION['id'].' or tb_events.officeid='.$_SESSION['officeid'].' )');
            }elseif($_SESSION['rolecode']=='kabag'){
                $query->where('( status !=0 or userid='.$_SESSION['id'] .')');
            }else{
                $query->where('tb_events.officeid',$_SESSION['officeid']);
            }
        }

        if($statusEvent!=0){
            $query->where('tb_events.status',$statusEvent);
        }else{
            $EventStatus = [4,5];
            $query->whereIn('tb_events.status', $EventStatus);
            // $query->where('tb_events.status!=',$statusEvent);
        }

        if($category!=0){
            $query->where('tb_events.categoryid',$category);
        } 

        if($tahun!=0){
            $query->where('tb_events.year',$tahun);
        }else{
            $query->where('tb_events.year',date('Y'));
        }
        if($bulan!=0){
            $query->where('tb_events.month',$bulan);
        }else{
            $query->where('tb_events.month',(int)date('m'));
        }
        $query->orderBy('tb_events.eventid','DESC');

        $query = $query->get();

        $data = $query->getResult();
        
        return json_decode(json_encode($query->getResult()), true);
    }
}
