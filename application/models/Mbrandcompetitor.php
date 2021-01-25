<?php
class mbrandcompetitor extends CI_Model {

	function getData($arr){				
        $this->db->select('cb.id, cb.name as brand, c.name as competitor ');        
		$this->db->from('competitor_brand cb');
		$this->db->join('competitor c','c.id = cb.competitorid','LEFT');
        $this->db->where('cb.active','0');	
        if ($arr[0] <> "-" && $arr[0] <> "") //competitor
		{
			$this->db->where('cb.competitorid',$arr[0]);	
		}
		$this->db->order_by('cb.name','ASC');
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
				"name" => $header["name"],
				"competitorid" => $header["competitor"],
				"active" => '0',	
				"updatedby" => $this->session->userdata('id'),
				"updatedon" => date("Y-m-d H:i:s")							
			);
			
			$this->db->where('id', $header['id']);
			$this->db->update('competitor_brand', $headerdata);	
			
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
				"name" => $header["name"],
				"competitorid" => $header["competitor"],
				"active" => '0',
				"createdby" => $this->session->userdata('id'),
				"createdon" => date("Y-m-d H:i:s")
			);

			$this->db->insert('competitor_brand', $headerdata);

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
		$this->db->select('cb.id, cb.name as brand, c.name as competitor, c.id as competitorid ');        
		$this->db->from('competitor_brand cb');
		$this->db->join('competitor c','c.id = cb.competitorid','LEFT');
        $this->db->where('cb.id',$id);
		$this->db->order_by('cb.name','ASC');
        $query = $this->db->get();  
        $data['header'] = $query->row_array();   
        return $data;
    }
			
	function delete_brand_competitor($data) {
						
		$arr = array(
			'active' => '2',
			'updatedon' => date("Y-m-d H:i:s"),
			'updatedby' => $this->session->userdata('id'),	
		);
		$this->db->where('id', $data);
		$this->db->update('competitor_brand', $arr);				
		
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