<?php
class mcustomermapping extends CI_Model {

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

	function getData($arr){	
		//print_r($arr);			
        $this->db->select('t1.id, t1.customerno, CONCAT(t1.customerno, " - ", t4.`name`) as customername, t1.visitweek, t2.lookupdesc as week, t1.visitday, t3.lookupdesc as day, COALESCE(t1.nourut,0) as nourut');        
		$this->db->from('customer_user t1');
        $this->db->join("lookup t2","t1.visitweek=t2.lookupvalue AND t2.lookupkey='visit_week'","LEFT OUTER");
		$this->db->join("lookup t3","t1.visitday=t3.lookupvalue AND t3.lookupkey='visit_day'","LEFT OUTER");
		$this->db->join("customer t4","t4.customerno=t1.customerno","LEFT OUTER");
        $this->db->where('t1.active','0');		
		if ($arr[2] <> "-" && $arr[2] <> "") //salesmanid
		{
			$this->db->where('t1.userid',$arr[2]);	
		}
		if ($arr[3] <> "-" && $arr[3] <> "") //dayid
		{
			$this->db->where('t1.visitday',$arr[3]);	
		}
		if ($arr[4] <> "-" && $arr[4] <> "") //weekid
		{
			$this->db->where('t1.visitweek',$arr[4]);	
		}
		$this->db->group_by('t1.customerno');
		$this->db->order_by('t1.nourut','ASC');
        $query = $this->db->get();        
        return $query;
	}

	function cekSalesman($userid){		
		$this->db->select('u.userid');        
        $this->db->from('user u');
        $this->db->where('u.active','0');
		$this->db->where("u.userid",$userid);	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}
	
	function cekCustomer($customerno){		
		$this->db->select('c.customerno');        
        $this->db->from('customer c');
        $this->db->where('c.active','0');
		$this->db->where("c.customerno",$customerno);	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}
	
	function cekDay($dayid){		
		$this->db->select('l.lookupvalue');        
        $this->db->from('lookup l');
        $this->db->where('l.active','0');
		$this->db->where("l.lookupvalue",$dayid);
		$this->db->where("l.lookupkey",'visit_day');	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}
	
	function cekWeek($weekid){		
		$this->db->select('l.lookupvalue');        
        $this->db->from('lookup l');
        $this->db->where('l.active','0');
		$this->db->where("l.lookupvalue",$weekid);
		$this->db->where("l.lookupkey",'visit_week');	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}
	
	function cekMapping($customerno, $weekid, $dayid){		
		$this->db->select('cu.id');        
        $this->db->from('customer_user cu');
        $this->db->where('cu.active','0');
		$this->db->where("cu.customerno",$customerno);
		$this->db->where("cu.visitday",$dayid);
		$this->db->where("cu.visitweek",$weekid);	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
	
	function upload($data) {
		$data = json_decode($data,true);
		// print_r($data);exit;	
		$detail = $data["detail"];
		$detail = json_decode($detail,true);
		// print_r($detail);exit;	
		$ret["message"] = "";
		$counter = 0;
		$countsuccess = 0;
		$countfailed = 0;
		foreach ($detail as $row) {	
			$counter += 1;
			$ok = true;
			
			$cekSalesman = $this->cekSalesman($row["Salesman"]);
			$cekCustomer = $this->cekCustomer($row["Customerno"]);
			$cekDay = $this->cekDay($row["Day"]);
			$cekWeek = $this->cekWeek($row["Week"]);
			$cekMapping = $this->cekMapping($row["Customerno"],$row["Week"],$row["Day"]);

			if ($row['Salesman'] == '' || $row["Customerno"] == '' || $row["Day"] == '' || $row["Week"] == '' || $row["Urut"] == '' )
			{				
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Please enter data in all columns<br/> ";
				$countfailed += 1;
				$ok = false;
			}
			else if (count($cekSalesman) == 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Sales ID not valid<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			else if (count($cekCustomer) == 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Customer Number not found<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			else if (count($cekDay) == 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Day not found<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			else if (count($cekWeek) == 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Week not found<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			else if (count($cekMapping) > 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Double Mapping for this salesman<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			
			if ($ok == true)
			{
				// $salesoffice_code = $this->getSalesOfficeCode($row['Sales_Office']);
				
				// $customerno = $this->getCustomerNo($salesoffice_code[0]["code"]);
				// print_r($customerno[0]["customerno"]);exit;
				$detaildata = array(
						"userid" => $row["Salesman"],
						"visitday" => $row["Day"],
						"visitweek" => $row["Week"],
						"customerno" => $row["Customerno"],														
						"active" => '0',
						"nourut" => $row['Urut'],							
						"createdby" => $this->session->userdata('id'),
						"createdon" => date("Y-m-d H:i:s")								
				);
				$this->db->insert('customer_user', $detaildata);	
				$countsuccess += 1;				
			}
									
			$ret['countsuccess'] = $countsuccess;
			$ret['countfailed'] = $countfailed;
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
}