<?php
class mtrial extends CI_Model {
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
	
	function getData($arr){				
        $this->db->select('t.id, DATE_FORMAT(t.trialdate,"%d-%m-%Y") trialdate, 
							CONCAT(t.userid," - ",u.name) as salesman, 
							l.lookupdesc AS trialtype, t.location, t.`name`, 
							CONCAT(t.materialid, " - ", m.name) as material');        
		$this->db->from('trial t');
        $this->db->join('user u','u.userid = t.userid','LEFT');
		$this->db->join('lookup l','l.lookupvalue = t.trialtype and l.lookupkey="trial_type"','LEFT');
		$this->db->join('material m','m.id = t.materialid','LEFT');
		// $this->db->join('material_default d','d.materialid = m.id','LEFT');
		$this->db->join('competitor_brand c','c.id = t.competitorbrandid','LEFT');
        $this->db->where('t.active','0');	
		$this->db->where('t.trialdate >=',$arr[3]);	
		$this->db->where('t.trialdate <=',$arr[4]);	
		if ($arr[0] <> "-" && $arr[0] <> "") //regionid
		{
			$this->db->where('u.regionid',$arr[0]);	
		}
		if ($arr[1] <> "-" && $arr[1] <> "") //salesofficeid
		{
			$this->db->where('u.salesofficeid',$arr[1]);	
		}			
		if ($arr[2] <> "-" && $arr[2] <> "") //salesmanid
		{
			$this->db->where('t.userid',$arr[2]);	
		}
		if ($this->session->userdata('regionid') <> '0')
		{
			$this->db->where('u.regionid in ('.$this->session->userdata('regionid').')',NULL,FALSE);
		}
		if ($this->session->userdata('salesofficeid') <> '0')
		{
			$this->db->where('u.salesofficeid in ('.$this->session->userdata('salesofficeid').')',NULL,FALSE);
		}
		$this->db->order_by('t.trialdate','DESC');

        $query = $this->db->get();    
        return $query;
    } 
			
	function save($data) {
		$data = json_decode($data,true);
		
		$header = $data["header"];
		$header = json_decode($header,true);
		
		if ($header['id'] > 0) //edit
		{
			$headerdata = array(
				"userid" => $header["salesman"],
				"trialdate" => $header["trialdate"],
				"trialtype" => $header["trialtype"],
				"location" => $header["triallocation"],
				"name" => $header["name"],
				"phone" => $header["phone"],
				"age" => $header["age"],
				"materialid" => $header["material"],
				"qty" => $header["qty"],
				"price" => $header["price"],
				"amount" => $header['total'],
				"competitorbrandid" => $header['brandbefore'],
				"knowing" => $header['knowproduct'],
				"taste" => $header['taste'],
				"packaging" => $header['packaging'],
				"outletname" => $header['outletname'],
				"outletaddress" => $header['outletaddress'],
				"notes" => $header['notes'],
				"active" => '0',	
				"updatedby" => $this->session->userdata('id'),
				"updatedon" => date("Y-m-d H:i:s")							
			);
			
			$this->db->where('id', $header['id']);
			$this->db->update('trial', $headerdata);	
			
			if ($this->db->trans_status() === TRUE){	
				$ret["status"] = 1;																	
				$this->db->trans_commit();
			}else{
				$ret["status"] = 0;
				$this->db->trans_rollback();						
			}	
		}
		else //new
		{
			
			$headerdata = array(
				"userid" => $header["salesman"],
				"trialdate" => $header["trialdate"],
				"trialtype" => $header["trialtype"],
				"location" => $header["triallocation"],
				"name" => $header["name"],
				"phone" => $header["phone"],
				"age" => $header["age"],
				"materialid" => $header["material"],
				"qty" => $header["qty"],
				"price" => $header["price"],
				"amount" => $header['total'],
				"competitorbrandid" => $header['brandbefore'],
				"knowing" => $header['knowproduct'],
				"taste" => $header['taste'],
				"packaging" => $header['packaging'],
				"outletname" => $header['outletname'],
				"outletaddress" => $header['outletaddress'],
				"notes" => $header['notes'],
				"active" => '0',
				"createdby" => $this->session->userdata('id'),
				"createdon" => date("Y-m-d H:i:s")
			);

			$this->db->insert('trial', $headerdata);

			if ($this->db->trans_status() === TRUE){	
				$ret["status"] = 1;	
				$this->db->trans_commit();
			}else{
				$ret["status"] = 0;
				$this->db->trans_rollback();
			}			
		}
		return $ret;
	}
	
	function getDetail($id){    
		$this->db->select('t.id, t.userid, t.trialdate, CONCAT(t.userid," - ",u.name) as salesman, t.materialid, 
							t.trialtype as trialtypevalue, l.lookupdesc AS trialtype, t.location, t.`name`, 
							CONCAT(t.materialid, " - ", m.name) as material, u.regionid, u.salesofficeid,
							t.name, t.phone, t.age, t.qty, t.price, t.amount as total, 
							c.name as brandbefore, c.id as competitorbrandid,
							lknow.lookupdesc as knowing, t.knowing as knowingid,
							lpack.lookupdesc as packaging, t.packaging as packagingid,
							ltaste.lookupdesc as taste, t.taste as tasteid,
							t.outletname, t.outletaddress, t.notes ');        
		$this->db->from('trial t');
        $this->db->join('user u','u.userid = t.userid','LEFT');
		$this->db->join('lookup l','l.lookupvalue = t.trialtype and l.lookupkey="trial_type"','LEFT');
		$this->db->join('lookup lknow','l.lookupvalue = t.knowing and l.lookupkey="trial_knowing"','LEFT');
		$this->db->join('lookup lpack','l.lookupvalue = t.packaging and l.lookupkey="trial_packaging"','LEFT');
		$this->db->join('lookup ltaste','l.lookupvalue = t.taste and l.lookupkey="trial_taste"','LEFT');
		$this->db->join('material m','m.id = t.materialid','LEFT');
		$this->db->join('competitor_brand c','c.id = t.competitorbrandid','LEFT');
        $this->db->where('t.active','< 2');
        $this->db->where('t.id',$id);
		$this->db->order_by('t.trialdate','DESC');

        $query = $this->db->get();  
        $data['header'] = $query->row_array();  
        // print_r($this->db->last_query()); exit();  
        return $data;
    }
			
	function delete_trial($data) {
						
		$arr = array(
			'active' => '2',
			'updatedon' => date("Y-m-d H:i:s"),
			'updatedby' => $this->session->userdata('id'),	
		);
		$this->db->where('id', $data);
		$this->db->update('trial', $arr);				
		
		if ($this->db->trans_status() === TRUE){	
			$ret["status"] = 1;															
			$this->db->trans_commit();
		}else{
			$ret["status"] = 0;
			$this->db->trans_rollback();						
		}
		
		return $ret;	
	}  

	function getLookup($lookupkey){
        $this->db->select('lo.lookupvalue as id, lo.lookupdesc as name');        
        $this->db->from('lookup lo');       
        $this->db->where('lo.active','0');	
		$this->db->where('lo.lookupkey',$lookupkey);
		$this->db->order_by('lo.lookupdesc','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }

	function getPrice($materialid, $priceid, $tgl){		
		$this->db->select('mp.value');        
        $this->db->from('material_price mp');                       
        $this->db->where('mp.active','0');	
		$this->db->where('mp.materialid',$materialid);
		$this->db->where('mp.priceid',$priceid);				
		$this->db->where('mp.validfrom <=',$tgl);
		$this->db->where('mp.validto >=',$tgl);
        $query = $this->db->get();
        $query = $query->result_array();  
        //print_r($this->db->last_query());
        return $query;
    } 

    function getMaterialGroup($materialid){
    	$this->db->select('m.materialgroupid as value');        
        $this->db->from('material m');                       
        $this->db->where('m.active','0');	
		$this->db->where('m.id',$materialid);
        $query = $this->db->get();
        $query = $query->result_array();  
        // print_r($this->db->last_query());
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
			$this->db->where('u.userroleid in (2,3)',NULL,FALSE);	
		}
		else if ($type == '2') //launching
		{
			$this->db->where('u.userroleid in (3)',NULL,FALSE);	
		}
		$this->db->order_by('u.name','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 

	function getBrandBefore($salesofficeid,$materialgroupid){
		$this->db->select('cb.id, cb.name');        
        $this->db->from('competitor_brand cb');       
        $this->db->join('sob s','s.competitorbrandid = cb.id','LEFT'); 
        $this->db->where('cb.active','0');	
        $this->db->where('s.materialgroupid',$materialgroupid);	
		$this->db->where('s.salesofficeid',$salesofficeid);		
		$this->db->order_by('cb.name','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();
        // print_r($this->db->last_query()); 
        return $query;
    } 

    function getCompetitorBrand($id){
    	$this->db->select('cb.id, CONCAT(cb.id," - ",cb.name) name');        
        $this->db->from('competitor_brand cb');       
        $this->db->where('cb.active','0');	
		$this->db->where('cb.id',$id);		
		$this->db->order_by('cb.name','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }
}