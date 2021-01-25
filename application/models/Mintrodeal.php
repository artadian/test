<?php
class mintrodeal extends CI_Model {

	function getData($arr){				
        $this->db->select('i.id, r.name AS region, s.name AS salesoffice, CONCAT(m.id, " - ", m.name) as material, i.qtyorder, i.qtybonus, i.startdate, i.enddate');        
		$this->db->from('introdeal i');
		$this->db->join('material m','m.id = i.materialid','LEFT');
		$this->db->join('sales_office s','s.id = i.salesofficeid','LEFT');
		$this->db->join('region r','r.id = s.regionid','LEFT');
        $this->db->where('i.active','0');	
        if ($arr[0] <> "-" && $arr[0] <> "") //Region
		{
			$this->db->where('s.regionid',$arr[0]);	
		}
		if ($arr[1] <> "-" && $arr[1] <> "") //Sales Office
		{
			$this->db->where('s.id',$arr[1]);	
		}
		if ($this->session->userdata('regionid') <> '0')
		{
			$this->db->where('s.regionid in ('.$this->session->userdata('regionid').')',NULL,FALSE);
		}
		if ($this->session->userdata('salesofficeid') <> '0')
		{
			$this->db->where('s.id in ('.$this->session->userdata('salesofficeid').')',NULL,FALSE);
		}
		// $this->db->order_by('i.material','ASC');
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
				"salesofficeid" => $header["salesofficeid"],
				"materialid" => $header["materialid"],
				"qtyorder" => $header["qtyorder"],
				"qtybonus" => $header["qtybonus"],
				"startdate" => $header["startdate"],
				"enddate" => $header["enddate"],
				"active" => '0',	
				"updatedby" => $this->session->userdata('id'),
				"updatedon" => date("Y-m-d H:i:s")							
			);
			
			$this->db->where('id', $header['id']);
			$this->db->update('introdeal', $headerdata);	
			
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
				"materialid" => $header["materialid"],
				"qtyorder" => $header["qtyorder"],
				"qtybonus" => $header["qtybonus"],
				"startdate" => $header["startdate"],
				"enddate" => $header["enddate"],
				"active" => '0',
				"createdby" => $this->session->userdata('id'),
				"createdon" => date("Y-m-d H:i:s")
			);

			$this->db->insert('introdeal', $headerdata);

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
		    $this->db->select('i.id, CONCAT(m.id, " - ", m.name) as material, i.qtyorder, i.qtybonus, i.startdate, i.enddate, rg.id as regionid, m.id as materialid, so.id as salesofficeid');        
		$this->db->from('introdeal i');
		$this->db->join('material m','m.id = i.materialid','LEFT');
		$this->db->join('sales_office so','so.id = i.salesofficeid','LEFT');
		$this->db->join('region rg','rg.id = so.regionid','LEFT');
        $this->db->where('i.active','< 2');
        $this->db->where('i.id',$id);
        $query = $this->db->get();  
        $data['header'] = $query->row_array();   
        return $data;
    }
			
	function delete_introdeal($data) {
						
		$arr = array(
			'active' => '2',
			'updatedon' => date("Y-m-d H:i:s"),
			'updatedby' => $this->session->userdata('id'),	
		);
		$this->db->where('id', $data);
		$this->db->update('introdeal', $arr);				
		
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