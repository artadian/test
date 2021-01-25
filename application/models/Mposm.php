<?php
class mposm extends CI_Model {

	function getUserRole($userid){
		$this->db->select('userroleid');        
        $this->db->from('user');                       
        $this->db->where('active','0');	
		$this->db->where('userid',$userid);
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
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
	
	function getPosmId($customerno, $tgl, $id){		
		$this->db->select('p.id');        
		$this->db->from('posm p');              
		$this->db->where('p.active','0');			
		$this->db->where('p.customerno',$customerno);	
		$this->db->where('p.posmdate',$tgl);	
		$this->db->where('p.id <>',$id);	
		$query = $this->db->get();
		$query = $query->result_array();  
		return $query;
	} 

	function getPosmType($salesofficeid,$userroleid){
		$this->db->select('l.lookupvalue as id, l.lookupdesc as name');        
        $this->db->from('posm_default pd');       
        $this->db->join('lookup l','pd.posmtypeid = l.lookupvalue AND l.lookupkey="posm_type"','LEFT'); 
        $this->db->where('pd.active','0');	
        $this->db->where('pd.userroleid',$userroleid);	
		$this->db->where('pd.salesofficeid',$salesofficeid);		
		$this->db->order_by('l.lookupdesc','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
	}

	function getMaterialGroup($salesofficeid){
		$this->db->select('mg.id as id, CONCAT(mg.id," - ",mg.description) as name');        
        $this->db->from('material_default md');       
        $this->db->join('material m','m.id = md.materialid','LEFT'); 
        $this->db->join('material_group mg','mg.id = m.materialgroupid','LEFT'); 
        $this->db->where('mg.active','0');		
		$this->db->where('md.salesofficeid',$salesofficeid);		
		$this->db->order_by('mg.description','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
	}

	function getData($arr){	
		//print_r($arr);			
        $this->db->select('p.id, DATE_FORMAT(p.posmdate,"%d-%m-%Y") posmdate, 
							CONCAT(p.userid," - ",u.name) as salesman, CONCAT(p.customerno," - ",c.name) as customer');        
		$this->db->from('posm p');
        $this->db->join('user u','u.userid = p.userid','LEFT');
		$this->db->join('customer c','c.customerno = p.customerno','LEFT');    		       
        $this->db->where('p.active','0');	
		$this->db->where('p.posmdate >=',$arr[3]);	
		$this->db->where('p.posmdate <=',$arr[4]);	
		if ($arr[0] <> "-" && $arr[0] <> "") //regionid
		{
			$this->db->where('p.regionid',$arr[0]);	
		}
		if ($arr[1] <> "-" && $arr[1] <> "") //salesofficeid
		{
			$this->db->where('p.salesofficeid',$arr[1]);	
		}			
		if ($arr[2] <> "-" && $arr[2] <> "") //salesmanid
		{
			$this->db->where('p.userid',$arr[2]);	
		}
		if ($this->session->userdata('regionid') <> '0')
		{
			$this->db->where('p.regionid in ('.$this->session->userdata('regionid').')',NULL,FALSE);
		}
		if ($this->session->userdata('salesofficeid') <> '0')
		{
			$this->db->where('p.salesofficeid in ('.$this->session->userdata('salesofficeid').')',NULL,FALSE);
		}
		$this->db->order_by('p.posmdate','DESC');
        $query = $this->db->get();        
        return $query;
    }  
			
	function save($data) {
		$data = json_decode($data,true);
		
		$detail = $data["detail"];
		$detail = json_decode($detail,true);
		
		$header = $data["header"];
		$header = json_decode($header,true);
		
		// print_r($detail);exit;
		if ($header['id'] > 0) //edit
		{
			$id = $this->getPosmId($header['customerno'], $header["posmdate"], $header['id']);	
			if (count($id) > 0)
			{
				$ret["status"] = 0;
				$ret["message"] = "Double posm for this customer";
			}
			else
			{
				$headerdata = array(
					"customerno" => $header["customerno"],					
					"userid" => $header['userid'],
					"posmdate" => $header['posmdate'],
					"regionid" => $header['regionid'],
					"salesofficeid" => $header['salesofficeid'],																	
					"updatedby" => $this->session->userdata('id'),
					"updatedon" => date("Y-m-d H:i:s")							
				);
				
				$this->db->where('id', $header['id']);
				$this->db->update('posm', $headerdata);		
					
				$headerdata = array(
						"active" => "2",																									
						"updatedby" => $this->session->userdata('id'),
						"updatedon" => date("Y-m-d H:i:s")							
				);	
				$this->db->where('posmid', $header['id']);
				$this->db->update('posm_detail', $headerdata);		
				
				$counter = 1;
				foreach ($detail as $row) {	
					if ($row['id'] == '0') //insert
					{
						$detaildata = array(
								"posmid" => $header['id'],
								"posmtypeid" => $row["posmtypeid"],
								"materialgroupid" => $row["materialgroupid"],
								"status" => $row["status"],
								"qty" => $row["qty"],
								"condition" => $row["condition"],
								"notes" => $row["notes"],
								"active" => 0,
								"createdby" => $this->session->userdata('id'),
								"createdon" => date("Y-m-d H:i:s")									
						);
						$this->db->insert('posm_detail', $detaildata);
					}
					else //update
					{
						$detaildata = array(							
								"posmtypeid" => $row["posmtypeid"],
								"materialgroupid" => $row["materialgroupid"],
								"status" => $row["status"],
								"qty" => $row["qty"],
								"condition" => $row["condition"],
								"notes" => $row["notes"],
								"active" => 0,
								"updatedby" => $this->session->userdata('id'),
								"updatedon" => date("Y-m-d H:i:s")									
						);
						$this->db->where('id', $row['id']);
						$this->db->update('posm_detail', $detaildata);		
					}								
				}
				
				if ($this->db->trans_status() === TRUE){	
					$ret["status"] = 1;																	
					$this->db->trans_commit();
				}else{
					$ret["status"] = 0;
					$this->db->trans_rollback();						
				}
			}	
		}
		else //new
		{
			$id = $this->getPosmId($header['customerno'], $header["posmdate"], '0');	

			if (count($id) > 0)
			{
				$ret["status"] = 0;
				$ret["message"] = "Double posm for this customer";
			}
			else
			{
				$territory = $this->mglobal->getTerritory($header['customerno']);	
				$periode = $this->mglobal->getPeriode($header['posmdate']);	
					
				if (count($territory) > 0 && count($periode) > 0)
				{
					$headerdata = array(
								"customerno" => $header["customerno"],
								"posmdate" => $header["posmdate"],
								"userid" => $header["userid"],
								"regionid" => $territory[0]["regionid"],
								"salesofficeid" => $territory[0]["salesofficeid"],
								"salesgroupid" => $territory[0]["salesgroupid"],
								"salesdistrictid" => $territory[0]["salesdistrictid"],
								"cycle" => $periode[0]["cycle"],
								"week" => $periode[0]["week"],
								"year" => $periode[0]["year"],
								"active" => '0',							
								"createdby" => $this->session->userdata('id'),
								"createdon" => date("Y-m-d H:i:s")							
					);
					
					$this->db->insert('posm', $headerdata);
					$posmid = $this->db->insert_id();
					
					foreach ($detail as $row) {					
						$detaildata = array(
								"posmid" => $posmid,
								"posmtypeid" => $row["posmtypeid"],
								"materialgroupid" => $row["materialgroupid"],
								"status" => $row["status"],
								"qty" => $row["qty"],
								"condition" => $row["condition"],
								"notes" => $row["notes"],
								"active" => 0,
								"createdby" => $this->session->userdata('id'),
								"createdon" => date("Y-m-d H:i:s")									
						);
						$this->db->insert('posm_detail', $detaildata);					
					}	
				
					if ($this->db->trans_status() === TRUE){	
						$ret["status"] = 1;																	
						$this->db->trans_commit();
					}else{
						$ret["status"] = 0;
						$this->db->trans_rollback();						
					}	
				
				}
				else
				{
					$ret["status"] = 0;
					$ret["message"] = "Territory or Cycle not found";
				}
			}						
		}
			
		return $ret;
	}
	
	function getDetail($id){        
		$this->db->select('b.nama,b.kode,b.merk,t.nama as tipe');        
		$this->db->from('barang b'); 
		$this->db->join('tipe t','t.id = b.tipe','LEFT');   	       					  	
		$this->db->where('b.id',$id);		
		$query = $this->db->get();
		
        if ($query->num_rows()==0){
            return false;
        }else{
            $data['header'] = $query->row_array();
			
			$posmid = $data['header']['id'];
						
			$this->db->select('pd.id, pd.posmtypeid, pd.materialgroupid, pd.status, pd.qty, pd.condition, pd.notes');
			$this->db->from('posm_detail pd');        			
			$this->db->join('material_group mg','mg.id = pd.materialgroupid','LEFT'); 
			$this->db->where('pd.active','0');		
			$this->db->where('pd.posmid',$posmid);		
			$query = $this->db->get();
			
			$data['detail'] = $query->result_array();
                              
            return $data;         
        }
    }
			
	function delete_posm($data) {
						
		$arr = array(
			'active' => '2',
			'updatedon' => date("Y-m-d H:i:s"),
			'updatedby' => $this->session->userdata('id'),	
		);
		$this->db->where('id', $data);
		$this->db->update('posm', $arr);				
		
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