<?php
class mvisit extends CI_Model {

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
        $this->db->select('v.id, DATE_FORMAT( v.visitdate, "%d-%m-%Y" ) visitdate, CONCAT( v.userid, " - ", u.NAME ) AS salesman, CONCAT( v.customerno, " - ", cus.NAME ) AS customer, l1.lookupdesc as not_buy_reason, l2.lookupdesc as not_visit_reason');        
		$this->db->from('visit v');
		$this->db->join("lookup l1","l1.lookupvalue = v.notbuyreason AND l1.lookupkey = 'not_buy_reason'","LEFT OUTER");
		$this->db->join("lookup l2","l2.lookupvalue = v.notbuyreason AND l1.lookupkey = 'not_visit_reason'","LEFT OUTER");
		$this->db->join('customer cus','cus.customerno = v.customerno','LEFT OUTER');
		$this->db->join('user u','u.userid = v.userid','LEFT OUTER');    		       
        $this->db->where('v.active','0');	
		$this->db->where('v.visitdate >=',$arr[3]);	
		$this->db->where('v.visitdate <=',$arr[4]);	
		if ($arr[0] <> "-" && $arr[0] <> "") //regionid
		{
			$this->db->where('v.regionid',$arr[0]);	
		}
		if ($arr[1] <> "-" && $arr[1] <> "") //salesofficeid
		{
			$this->db->where('v.salesofficeid',$arr[1]);	
		}			
		if ($arr[2] <> "-" && $arr[2] <> "") //salesmanid
		{
			$this->db->where('v.userid',$arr[2]);	
		}
		if ($this->session->userdata('regionid') <> '0')
		{
			$this->db->where('v.regionid in ('.$this->session->userdata('regionid').')',NULL,FALSE);
		}
		if ($this->session->userdata('salesofficeid') <> '0')
		{
			$this->db->where('v.salesofficeid in ('.$this->session->userdata('salesofficeid').')',NULL,FALSE);
		}
		$this->db->order_by('v.visitdate','DESC');
        $query = $this->db->get();        
        return $query;
    }  
			
	function save($data) {
		$data = json_decode($data,true);
	
		$header = $data["header"];
		$header = json_decode($header,true);
		$periode = $this->mglobal->getPeriode($header["visitdate"]);
		$territory = $this->mglobal->getTerritory($header["customerno"]);
		if($header["nvr"]=='-'){
			$header["nvr"]=0;
		}
		if($header["nbr"]=='-'){
			$header["nbr"]=0;
		}
		// print_r($territory);exit;
		// print_r($header);exit;
		if ($header['id'] > 0) //edit
		{
			$headerdata = array(
					"userid" => $header["userid"],					
					"customerno" => $header['customerno'],
					"visitdate" => $header['visitdate'],
					"notvisitreason" => $header['nvr'],
					"notbuyreason" => $header['nbr'],
					"regionid" => $territory[0]["regionid"],					
					"salesofficeid" => $territory[0]['salesofficeid'],
					"salesgroupid" => $territory[0]['salesgroupid'],
					"salesdistrictid" => $territory[0]['salesdistrictid'],
					"cycle" => $periode[0]['cycle'],
					"week" => $periode[0]["week"],					
					"year" => $periode[0]['year'],
					"active" => 0,																		
					"updatedby" => $this->session->userdata('id'),
					"updatedon" => date("Y-m-d H:i:s")							
			);
			
			$this->db->where('id', $header['id']);
			$this->db->update('visit', $headerdata);
			
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
			if (count($territory) > 0 && count($periode) > 0)
			{
				$headerdata = array(
					"userid" => $header["userid"],					
					"customerno" => $header['customerno'],
					"visitdate" => $header['visitdate'],
					"notvisitreason" => $header['nvr'],
					"notbuyreason" => $header['nbr'],
					"regionid" => $territory[0]["regionid"],					
					"salesofficeid" => $territory[0]['salesofficeid'],
					"salesgroupid" => $territory[0]['salesgroupid'],
					"salesdistrictid" => $territory[0]['salesdistrictid'],
					"cycle" => $periode[0]['cycle'],
					"week" => $periode[0]["week"],					
					"year" => $periode[0]['year'],
					"active" => 0,							
					"createdby" => $this->session->userdata('id'),
					"createdon" => date("Y-m-d H:i:s")							
				);
				
				$this->db->insert('visit', $headerdata);	
			
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
			
		return $ret;
	}
	
	function getDetail($id){        
		$this->db->select('v.id, v.customerno, v.visitdate, v.userid, v.regionid, v.salesofficeid, v.salesgroupid, v.salesdistrictid, v.notvisitreason, v.notbuyreason, v.cycle, v.week, v.year');        
		$this->db->from('visit v'); 
		$this->db->join('customer c','c.customerno = v.customerno','LEFT OUTER');   	       					  
        $this->db->where('v.active','< 2');		
		$this->db->where('v.id',$id);		
		$query = $this->db->get();
		
        if ($query->num_rows()==0){
            return false;
        }else{
            $data['header'] = $query->row_array();
                             
            return $data;         
        }
    }
			
	function delete_visit($data) {
						
		$arr = array(
			'active' => '2',
			'updatedon' => date("Y-m-d H:i:s"),
			'updatedby' => $this->session->userdata('id'),	
		);
		$this->db->where('id', $data);
		$this->db->update('visit', $arr);				
		
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