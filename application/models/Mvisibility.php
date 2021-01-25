<?php
class mvisibility extends CI_Model {

	function getData($arr){		
		$this->db->select("so.type");
        $this->db->from("sales_office so");
		$this->db->where('so.active', '0');
		$this->db->where('so.id', $arr[1]);        
        $query = $this->db->get();
        $data['so'] = $query->row_array();
		$type = $data['so']['type'];	

        $this->db->select('v.id, DATE_FORMAT(v.visibilitydate,"%d-%m-%Y") visibilitydate, u.name as salesman, c.name as customer');        
		$this->db->from('visibility v');
		$this->db->join('user u','u.userid = v.userid','LEFT');
		$this->db->join('customer c','c.customerno = v.customerno','LEFT');
        $this->db->where('v.active','0');	
        $this->db->where('v.visibilitydate >=',$arr[3]);	
		$this->db->where('v.visibilitydate <=',$arr[4]);
		if ($type == '1') //reguler
		{
			$this->db->where('u.userroleid in (1,2)',NULL,FALSE);	
		}
		else if ($type == '2') //launching
		{
			$this->db->where('u.userroleid in (1)',NULL,FALSE);	
		}	

        if ($arr[0] <> "-" && $arr[0] <> "") //Region
		{
			$this->db->where('v.regionid',$arr[0]);	
		}
		if ($arr[1] <> "-" && $arr[1] <> "") //Sales Office
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
		// if ($this->session->userdata('salesofficeid') <> '0')
		// {
		// 	$this->db->where('v.salesofficeid in ('.$this->session->userdata('salesofficeid').')',NULL,FALSE);
		// }
		// if ($this->session->userdata('salesmanid') <> '0')
		// {
		// 	$this->db->where('v.userid in ('.$this->session->userdata('salesmanid').')',NULL,FALSE);
		// }
        $query = $this->db->get();   
        // print_r($this->db->last_query()); exit();
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
			$headerdata = array(
				"visibilitydate" => $header["tanggal"],
				"regionid" => $header["regionid"],
				"salesofficeid" => $header["salesofficeid"],
				"userid" => $header["salesmanid"],
				"customerno" => $header["customerid"],
				"active" => '0',
				"updatedby" => $this->session->userdata('id'),
				"updatedon" => date("Y-m-d H:i:s")							
			);
			
			$this->db->where('id', $header['id']);
			$this->db->update('visibility', $headerdata);

			// history detail data
			$detaildata = array(		
				"active" => 2,
				"updatedby" => $this->session->userdata('id'),
				"updatedon" => date("Y-m-d H:i:s")									
			);
			$this->db->where('visibilityid', $header['id']);
			$this->db->update('visibility_detail', $detaildata);

			foreach ($detail as $row) {
				if ($row['detailID'] == '0') //insert
				{
					$detaildata = array(
						"visibilityid" => $header['id'],
						"materialid" => $row["materialid"],
						"pac" => $row["pac"],
						"active" => 0,
						"createdby" => $this->session->userdata('id'),
						"createdon" => date("Y-m-d H:i:s"),										
					);
					$this->db->insert('visibility_detail', $detaildata);
				}
				else //update
				{
					$detaildata = array(							
						"visibilityid" => $header['id'],
						"materialid" => $row["materialid"],
						"pac" => $row["pac"],
						"active" => 0,
						"updatedby" => $this->session->userdata('id'),
						"updatedon" => date("Y-m-d H:i:s")									
					);
					$this->db->where('id', $row['detailID']);
					$this->db->update('visibility_detail', $detaildata);		
				}								
			}
			
			if ($this->db->trans_status() === TRUE){	
				$ret["status"] = 1;																	
				$this->db->trans_commit();
			} else {
				$ret["status"] = 0;
				$this->db->trans_rollback();						
			}	
		}
		else { //new 
			$territory = $this->mglobal->getTerritory($header['customerid']);	
			$periode = $this->mglobal->getPeriode($header['tanggal']);

			$headerdata = array(
				"customerno" => $header["customerid"],
				"userid" => $header["salesmanid"],
				"visibilitydate" => $header["tanggal"],
				// "regionid" => $header["regionid"],
				// "salesofficeid" => $header["salesofficeid"],
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

			$this->db->insert('visibility', $headerdata);
			$visibilityid = $this->db->insert_id();

			foreach ($detail as $row) {	
				$detaildata = array(
					"visibilityid" => $visibilityid,
					"materialid" => $row["materialid"],
					"pac" => $row["pac"],
					"active" => 0,
					"createdby" => $this->session->userdata('id'),
					"createdon" => date("Y-m-d H:i:s")
				);
				$this->db->insert('visibility_detail', $detaildata);	
			}	

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
		$this->db->select('v.id, v.userid, v.visibilitydate, v.regionid, v.salesofficeid, v.userid, v.customerno');        
		$this->db->from('visibility v');
		// $this->db->join('outlet o','o.id = m.outletid','LEFT');
		// $this->db->join('merchandiser md','md.id = m.merchandiserid','LEFT');
		// $this->db->join('brand b','b.id = m.competitorbrandid','LEFT');
        $this->db->where('v.active','< 2');
        $this->db->where('v.id',$id);

        $query = $this->db->get(); 
        if ($query->num_rows()==0){
            return false;
        }else{
            $data['header'] = $query->row_array();
			
			$visibilityid = $data['header']['id'];
						
			$this->db->select('d.id AS detailID, d.visibilityid, d.materialid, d.pac, CONCAT(m.id," - ",m.name) material');
			$this->db->from('visibility_detail d');        			
			$this->db->join('visibility v','v.id = d.visibilityid','LEFT'); 
			$this->db->join('material m','m.id = d.materialid','LEFT'); 
			$this->db->where('d.active','0');		
			$this->db->where('d.visibilityid',$visibilityid);		
			$query = $this->db->get();
			
			$data['detail'] = $query->result_array();
                              
            return $data;         
        } 
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

	 function getSalesman($salesofficeid){		
        $this->db->select('u.userid, CONCAT(u.userid," - ",u.name) name');        
        $this->db->from('user u');       
        $this->db->where('u.active','0');	
		$this->db->where('u.salesofficeid',$salesofficeid);
		$this->db->where('u.userroleid in (1,2)',NULL,FALSE);	
		$this->db->order_by('u.name','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 

    function getPacMax($customerno,$materialid){
    	$this->db->select('v.pac as maxvalue');        
        $this->db->from('customer_wsp c');    
        $this->db->join('visibility_wsp v','v.materialgroupid = c.materialgroupid and c.class = v.wspclass','LEFT');                   
        $this->db->join('material m','m.materialgroupid = c.materialgroupid','LEFT');                   
        $this->db->where('c.active','0');	
        $this->db->where('v.active','0');	
		$this->db->where('c.customerno',$customerno);
		$this->db->where('m.id',$materialid);
        $query = $this->db->get();
        $query = $query->result_array();  
        // print_r($this->db->last_query());
        return $query;
    }
}