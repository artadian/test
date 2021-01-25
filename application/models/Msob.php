<?php
class msob extends CI_Model {

	function getData($arr){				
        $this->db->select('sob.id, so.name as salesoffice, CONCAT(mg.id, " - ", mg.name) as materialgroup, cb.name as competitorbrand, rg.id as regionid ');        
		$this->db->from('sob sob');
		$this->db->join('competitor_brand cb','cb.id = sob.competitorbrandid','LEFT');
		$this->db->join('material_group mg','mg.id = sob.materialgroupid','LEFT');
		$this->db->join('sales_office so','so.id = sob.salesofficeid','LEFT');
		$this->db->join('region rg','rg.id = so.regionid','LEFT');
        $this->db->where('sob.active','0');	
        if ($arr[0] <> "-" && $arr[0] <> "") //Region
		{
			$this->db->where('rg.id',$arr[0]);	
		}
		if ($arr[1] <> "-" && $arr[1] <> "") //Sales Office
		{
			$this->db->where('so.id',$arr[1]);	
		}
		if ($arr[2] <> "-" && $arr[2] <> "") //Material Group
		{
			$this->db->where('mg.id',$arr[2]);	
		}
		if ($this->session->userdata('regionid') <> '0')
		{
			$this->db->where('rg.id in ('.$this->session->userdata('regionid').')',NULL,FALSE);
		}
		if ($this->session->userdata('salesofficeid') <> '0')
		{
			$this->db->where('so.id in ('.$this->session->userdata('salesofficeid').')',NULL,FALSE);
		}
		$this->db->order_by('cb.name','ASC');
        $query = $this->db->get();   
        // print_r($this->db->last_query()); exit();
        return $query;
    } 
			
	function save($data) {
		$data = json_decode($data,true);
		
		$header = $data["header"];
		$header = json_decode($header,true);
		
		if ($header['id'] > 0) //edit
		{
			$headerdata = array(
				"salesofficeid" => $header["salesofficeid"],
				"materialgroupid" => $header["materialgroupid"],
				"competitorbrandid" => $header["competitorbrandid"],
				"active" => '0',	
				"updatedby" => $this->session->userdata('id'),
				"updatedon" => date("Y-m-d H:i:s")							
			);
			
			$this->db->where('id', $header['id']);
			$this->db->update('sob', $headerdata);	
			
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
				"salesofficeid" => $header["salesofficeid"],
				"materialgroupid" => $header["materialgroupid"],
				"competitorbrandid" => $header["competitorbrandid"],
				"active" => '0',
				"createdby" => $this->session->userdata('id'),
				"createdon" => date("Y-m-d H:i:s")
			);

			$this->db->insert('sob', $headerdata);

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
		    $this->db->select('sob.id, so.name as salesoffice, CONCAT(mg.id, " - ", mg.name) as materialgroup, cb.name as competitorbrand, rg.id as regionid, mg.id as materialgroupid, so.id as salesofficeid, cb.id as competitorbrandid');        
		$this->db->from('sob sob');
		$this->db->join('competitor_brand cb','cb.id = sob.competitorbrandid','LEFT');
		$this->db->join('material_group mg','mg.id = sob.materialgroupid','LEFT');
		$this->db->join('sales_office so','so.id = sob.salesofficeid','LEFT');
		$this->db->join('region rg','rg.id = so.regionid','LEFT');
        $this->db->where('sob.active','< 2');
        $this->db->where('sob.id',$id);
        $query = $this->db->get();  
        $data['header'] = $query->row_array();   
        return $data;
    }
			
	function delete_sob($data) {
						
		$arr = array(
			'active' => '2',
			'updatedon' => date("Y-m-d H:i:s"),
			'updatedby' => $this->session->userdata('id'),	
		);
		$this->db->where('id', $data);
		$this->db->update('sob', $arr);				
		
		if ($this->db->trans_status() === TRUE){	
			$ret["status"] = 1;															
			$this->db->trans_commit();
		}else{
			$ret["status"] = 0;
			$this->db->trans_rollback();						
		}
		
		return $ret;	
	}  
}