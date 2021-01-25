<?php
class mglobal extends CI_Model {

    //-- insert function
	public function insert($data,$table){
        $this->db->insert($table,$data);        
        return $this->db->insert_id();
    }

    //-- edit function
    function edit_option($action, $id, $table){
        $this->db->where('id',$id);
        $this->db->update($table,$action);
        return;
    } 

    //-- update function
    function update($action, $id, $table){
        $this->db->where('id',$id);
        $this->db->update($table,$action);
        return;
    } 

    //-- delete function
    function delete($id,$table){
        $this->db->delete($table, array('id' => $id));
        return;
    }

    //-- user role delete function
    function delete_user_role($id,$table){
        $this->db->delete($table, array('user_id' => $id));
        return;
    }


    //-- select function
    function select($table){
        $this->db->select();
        $this->db->from($table);
		$this->db->where('Active <', '2');
        $this->db->order_by('Nama','ASC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    //-- select by id
    function select_option($id,$table){
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function getRegion(){
        $this->db->select('r.id, r.name');        
        $this->db->from('region r');       
        $this->db->where('r.active','0');	
		if ($this->session->userdata('regionid') <> '0')
		{
			$this->db->where('r.id in ('.$this->session->userdata('regionid').')',NULL,FALSE);
		}
		$this->db->order_by('r.name','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
    function getRole(){
        $this->db->select('r.id, r.name');        
        $this->db->from('user_role r');       
        $this->db->where('r.active','0');   
        if ($this->session->userdata('regionid') <> '0')
        {
            $this->db->where('r.id in ('.$this->session->userdata('regionid').')',NULL,FALSE);
        }
        $this->db->order_by('r.name','ASC');        
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 

    
	
	function getSalesOffice($regionid){
        $this->db->select('so.id, so.name');        
        $this->db->from('sales_office so');       
        $this->db->where('so.active','0');	
		$this->db->where('so.regionid',$regionid);	
		if ($this->session->userdata('salesofficeid') <> '0')
		{
			$this->db->where('so.id in ('.$this->session->userdata('salesofficeid').')',NULL,FALSE);
		}
		$this->db->order_by('so.name','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    
    function getSalesGroup($salesofficeid){
        $this->db->select('sg.id, sg.name');        
        $this->db->from('sales_group sg');       
        $this->db->where('sg.active','0');	
		$this->db->where('sg.salesofficeid',$salesofficeid);	
		// if ($this->session->userdata('salesofficeid') <> '0')
		// {
		// 	$this->db->where('so.id in ('.$this->session->userdata('salesofficeid').')',NULL,FALSE);
		// }
		$this->db->order_by('sg.name','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function getSalesDistrict($salesgroupid){
        $this->db->select('sd.id, sd.name');        
        $this->db->from('sales_district sd');       
        $this->db->where('sd.active','0');	
		$this->db->where('sd.salesgroupid',$salesgroupid);	
		// if ($this->session->userdata('salesofficeid') <> '0')
		// {
		// 	$this->db->where('so.id in ('.$this->session->userdata('salesofficeid').')',NULL,FALSE);
		// }
		$this->db->order_by('sd.name','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
	
	function getSalesman($salesofficeid){
		$this->db->select("so.type");
        $this->db->from("sales_office so");
		$this->db->where('so.active', '0');
		$this->db->where('so.id', $salesofficeid);        
        $query = $this->db->get();
        $data['so'] = $query->row_array();
		$type = $data['so']['type'];		
		
        $this->db->select('u.userid, CONCAT(u.userid," - ",u.name) name');        
        $this->db->from('user u');       
        $this->db->where('u.active','0');	
		$this->db->where('u.salesofficeid',$salesofficeid);
		if ($type == '1') //reguler
		{
			$this->db->where('u.userroleid in (1,2)',NULL,FALSE);	
		}
		else if ($type == '2') //launching
		{
			$this->db->where('u.userroleid in (1)',NULL,FALSE);	
		}
		$this->db->order_by('u.name','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function getCustomer($userid){
		$this->db->select("u.userroleid");
        $this->db->from("user u");
		$this->db->where('u.active', '0');
		$this->db->where('u.userid', $userid);        
        $query = $this->db->get();
        $data['user'] = $query->row_array();
		$userroleid = $data['user']['userroleid'];
		
        $this->db->select('c.customerno, CONCAT(c.customerno," - ",c.name) name');        
        $this->db->from('customer_user cu');  
		$this->db->join('customer c','c.customerno = cu.customerno','LEFT'); 
        $this->db->where('cu.active','0');	
		$this->db->where('cu.userid',$userid);			
		if ($userroleid == '2') //Promotor
		{
			$this->db->where('c.usersfaid',NULL);
		}
		$this->db->order_by('cu.customerno','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 

    function getCustomerByDate($salesmanid, $date){
        $query = $this->db->query("
        SELECT cus.customerno, CONCAT(cus.customerno,' - ',cus.`name` ) as name
        FROM customer cus 
        LEFT OUTER JOIN customer_user cusus ON cusus.customerno = cus.customerno 
        WHERE
            cusus.userid = '".$salesmanid."' 
            AND cusus.visitday = ( SELECT WEEKDAY( '".$date."' ) + 1 ) 
            AND (
            CASE
                WHEN ( SELECT ( ( SELECT `week` FROM periode_cycle WHERE '".$date."' BETWEEN startdate AND enddate ) % 2 ) ) = 0 THEN
                cusus.visitweek IN ( 1, 3 ) 
                WHEN ( SELECT ( ( SELECT `week` FROM periode_cycle WHERE '".$date."' BETWEEN startdate AND enddate ) % 2 ) ) = 1 THEN
                cusus.visitweek IN ( 1, 2 ) 
            END 
            )");
        $data = $query->result_array();
        return $data;
    }

    function getMaterial($salesofficeid){
		$this->db->select('m.id, CONCAT(m.id," - ",m.name) name,CAST((m.bal/m.pac) as SIGNED) bal, CAST((m.slof/m.pac) as SIGNED) slof');        
        $this->db->from('material_default md');       
        $this->db->join('material m','m.id = md.materialid','LEFT'); 
        $this->db->where('md.active','0');	
        $this->db->where('m.active','0');	
		$this->db->where('md.salesofficeid',$salesofficeid);		
		$this->db->order_by('m.name','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 	

    function getMaterialGroup(){
        $this->db->select('id, CONCAT(id," - ",name) name');        
        $this->db->from('material_group');
        $this->db->where('active','0');        
        $this->db->order_by('name','ASC');        
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 

    function getPrice(){
        $this->db->select('id, id as name');        
        $this->db->from('price');
        $this->db->where('active','0');        
        $this->db->order_by('id','ASC');        
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 

    function getCompetitor(){
        $this->db->select('id, name');        
        $this->db->from('competitor');       
        $this->db->where('active','0');   
        $this->db->order_by('name','ASC');        
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 

    function getCompetitorBrand(){
        $this->db->select('id, name');        
        $this->db->from('competitor_brand');       
        $this->db->where('active','0');   
        $this->db->order_by('name','ASC');        
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function getWSPClass(){
        $this->db->select('lookupvalue as id, lookupdesc as name');        
        $this->db->from('lookup');       
        $this->db->where('active','0');  
        $this->db->where('lookupkey','wsp_class'); 
        $this->db->order_by('lookupvalue','ASC');        
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function getsales_office_typeClass(){
        $this->db->select('lookupvalue as id, lookupdesc as name');        
        $this->db->from('lookup');       
        $this->db->where('active','0');  
        $this->db->where('lookupkey','sales_office_type'); 
        $this->db->order_by('lookupvalue','ASC');        
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function getNotVisitReason(){
        $this->db->select('lookupvalue as id, lookupdesc as name');        
        $this->db->from('lookup');       
        $this->db->where('active','0');  
        $this->db->where('lookupkey','not_visit_reason'); 
        $this->db->order_by('lookupvalue','ASC');        
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function getNotBuyReason(){
        $this->db->select('lookupvalue as id, lookupdesc as name');        
        $this->db->from('lookup');       
        $this->db->where('active','0');  
        $this->db->where('lookupkey','not_buy_reason'); 
        $this->db->order_by('lookupvalue','ASC');        
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
	
	function getTerritory($customerno){
		$this->db->select('c.salesdistrictid, sd.salesgroupid, sg.salesofficeid, so.regionid');        
        $this->db->from('customer c');       
        $this->db->join('sales_district sd','sd.id = c.salesdistrictid','LEFT'); 
		$this->db->join('sales_group sg','sg.id = sd.salesgroupid','LEFT'); 
		$this->db->join('sales_office so','so.id = sg.salesofficeid','LEFT'); 
        $this->db->where('c.active','0');	
        $this->db->where('sd.active','0');	
		$this->db->where('sg.active','0');	
		$this->db->where('so.active','0');	
		$this->db->where('c.customerno',$customerno);					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function getPeriode($tanggal){
		$this->db->select('pc.year, pc.cycle, pc.week');        
        $this->db->from('periode_cycle pc');               
        $this->db->where('pc.active','0');	        
		$this->db->where('pc.startdate <=',$tanggal);
		$this->db->where('pc.enddate >=',$tanggal);			
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    
    function getDay(){
		$this->db->select('lookupvalue as id, lookupdesc as name');        
        $this->db->from('lookup');               
        $this->db->where('active','0');	        
		$this->db->where('lookupkey =','visit_day');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

    function getweek(){
		$this->db->select('lookupvalue as id, lookupdesc as name');        
        $this->db->from('lookup');               
        $this->db->where('active','0');	        
		$this->db->where('lookupkey =','visit_week');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
	
	function getMaterialGroupDefault($salesofficeid){
		$this->db->select('mg.id, CONCAT(mg.id," - ",mg.name) name');        
        $this->db->from('material_default md');       
        $this->db->join('material m','m.id = md.materialid','LEFT'); 
		$this->db->join('material_group mg','mg.id = m.materialgroupid','LEFT'); 
        $this->db->where('mg.active','0');	
		$this->db->where('md.active','0');	
        $this->db->where('m.active','0');	
		$this->db->where('md.salesofficeid',$salesofficeid);		
		$this->db->order_by('mg.name','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 	
	
	function getTerritoryUser($userid){
		$this->db->select('u.salesdistrictid, u.salesgroupid, u.salesofficeid, u.regionid');        
        $this->db->from('user u');              
        $this->db->where('u.active','0');	        
		$this->db->where('u.userid',$userid);					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
}