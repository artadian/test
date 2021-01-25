<?php
class mcustomer extends CI_Model {

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

	function getRole(){
        $this->db->select("id, name");
        $this->db->from("user_role");
		$this->db->where("active","0");
		$this->db->where("id in (1,2)");
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}

	function getCustomerGroup(){
        $this->db->select("id, name");
        $this->db->from("customer_group");
        $this->db->where("active","0");
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}
	
	function getData($arr){	
		//print_r($arr);			
        $this->db->select('cus.id, cus.customerno, cus.`name`, cus.address, cusg.`name` as custgroup,  reg.`name` as regional, so.`name` as salesoffice, sg.`name` as salesgroup, sd.`name` as salesdistrict');        
		$this->db->from('customer cus');
        $this->db->join('customer_group cusg','cus.customergroupid=cusg.id','LEFT OUTER');
		$this->db->join('sales_district sd','cus.salesdistrictid=sd.id','LEFT OUTER');
		$this->db->join('sales_group sg','sg.id=sd.salesgroupid','LEFT OUTER');
		$this->db->join('sales_office so','so.id=sg.salesofficeid','LEFT OUTER');
		$this->db->join('region reg','reg.id=so.regionid','LEFT OUTER');
		$this->db->where('cus.active < 2');
		if ($arr[0] <> "-" && $arr[0] <> "") //regionid
		{
			$this->db->where('reg.id',$arr[0]);	
		}
		if ($arr[1] <> "-" && $arr[1] <> "") //salesofficeid
		{
			$this->db->where('so.id',$arr[1]);	
		}			
		if ($arr[2] <> "-" && $arr[2] <> "") //salesgroupid
		{
			$this->db->where('sg.id',$arr[2]);	
		}
		if ($arr[3] <> "-" && $arr[3] <> "") //salesdistrictid
		{
			$this->db->where('sd.id',$arr[3]);	
		}
		if ($this->session->userdata('regionid') <> '0')
		{
			$this->db->where('reg.id in ('.$this->session->userdata('regionid').')',NULL,FALSE);
		}
		if ($this->session->userdata('salesofficeid') <> '0')
		{
			$this->db->where('so.id in ('.$this->session->userdata('salesofficeid').')',NULL,FALSE);
		}
		if ($this->session->userdata('salesgroupid') <> '0')
		{
			$this->db->where('sg.id in ('.$this->session->userdata('salesgroupid').')',NULL,FALSE);
		}
		if ($this->session->userdata('salesdistrictid') <> '0')
		{
			$this->db->where('sd.id in ('.$this->session->userdata('salesdistrictid').')',NULL,FALSE);
		}
		
		$this->db->order_by('cus.customerno','DESC');
        $query = $this->db->get();        
        return $query;
	}
	
	function getSalesOfficeCode($salesoffice_code){
		$this->db->select("code");
		$this->db->from("sales_office");
		$this->db->where("id",$salesoffice_code);
		$query = $this->db->get()->result_array();
		return $query;
	}
	
	function getCustomerNo($salesoffice_code){
		$customerno = $this->db->query("select getnocustomer(".$salesoffice_code.") as customerno")->result_array();
		return $customerno;
		// print_r($customerno);exit;
	}
	function save($data) {
		$data = json_decode($data,true);		
		$header = $data["header"];
		$header = json_decode($header,true);

		if ($header['id'] > 0) //edit
		{
			// print_r("masuk if");exit;
			// print_r($header);exit;
			$headerdata = array(					
				"name" => $header["name"],
				"address" => $header["address"],
				"city" => $header["city"],
				"owner" => $header["owner"],
				"phone" => $header["phone"],
				"customergroupid" => $header["customergroup"],
				"priceid" => $header["price"],
				"salesdistrictid" => $header["salesdistrict"],
				"userroleid" => $header["role"],
				"active" => '0',							
				"updatedby" => $this->session->userdata('userid'),
				"updatedon" => date("Y-m-d H:i:s")								
			);
			
			$this->db->where('id', $header['id']);
			$this->db->update('customer', $headerdata);		
			
			if ($this->db->trans_status() === TRUE){	
				$ret["status"] = 1;
				$ret["customerno"]	= $header["customerno"];																
				$this->db->trans_commit();
			}else{
				$ret["status"] = 0;
				$this->db->trans_rollback();						
			}	
		}
		else //new
		{
			$salesoffice_code = $this->getSalesOfficeCode($header['salesoffice']);
			$customerno = $this->getCustomerNo($salesoffice_code[0]["code"]);
			// print_r("masuk else");exit;

			$headerdata = array(
				"customerno" => $customerno[0]["customerno"],
				"name" => $header["name"],
				"address" => $header["address"],
				"city" => $header["city"],
				"owner" => $header["owner"],
				"phone" => $header["phone"],
				"customergroupid" => $header["customergroup"],
				"priceid" => $header["price"],
				"salesdistrictid" => $header["salesdistrict"],
				"userroleid" => $header["role"],
				"active" => '0',							
				"createdby" => $this->session->userdata('userid'),
				"createdon" => date("Y-m-d H:i:s")							
			);
			
			$this->db->insert('customer', $headerdata);			
			if ($this->db->trans_status() === TRUE){	
				$ret["status"] = 1;
				$ret["customerno"]= $customerno[0]["customerno"];																	
				$this->db->trans_commit();
			}else{
				$ret["status"] = 0;
				$this->db->trans_rollback();						
			}
						
		}
			
		return $ret;
	}

	function saveWSP($data) {
		$data = json_decode($data,true);		
		$header = $data["header"];
		$header = json_decode($header,true);
		$detail = $data["detail"];
		$detail = json_decode($detail,true);
		// print_r($detail);exit;

		$this->db->where('customerno',$header["customerno"]);
		$this->db->delete('customer_wsp');

		foreach ($detail as $row) {
			$data = array(					
				"customerno" => $header["customerno"],
				"startdate" => $row["startdate"],
				"enddate" => $row["enddate"],
				"class" => $row["wsp"],
				"materialgroupid" => $row["materialgroup"],
				"wspcode" => $row["wspcode"],
				"reason" => $row["reason"],
				"active" => '0',							
				"createdby" => $this->session->userdata('userid'),
				"createdon" => date("Y-m-d H:i:s")								
			);
			$this->db->insert('customer_wsp', $data);
			
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
		$this->db->select('cus.id, cus.customerno, cus.name , cus.address, cus.city, cus.`owner`, cus.phone, cg.id as customergroup_id, cg.`name` as customergroup_name, pr.id as priceid, rg.id as regionid, rg.`name` as region_name, so.id as salesoffice_id, so.`name` as salesoffice_name, sg.id as salesgroup_id, sg.`name` as salaesgroup_name, sd.id as salesdistrict_id, sd.`name` as salesdistrict_name, cus.userroleid');        
		$this->db->from('customer cus'); 
		$this->db->join('price pr','pr.id=cus.priceid','LEFT OUTER');
		$this->db->join('sales_district sd','sd.id=cus.salesdistrictid','LEFT OUTER'); 
		$this->db->join('sales_group sg','sg.id=sd.salesgroupid','LEFT OUTER'); 
		$this->db->join('sales_office so','so.id=sg.salesofficeid','LEFT OUTER'); 
		$this->db->join('region rg','rg.id=so.regionid','LEFT OUTER'); 
		$this->db->join('customer_group cg','cg.id=cus.customergroupid','LEFT OUTER');
		$this->db->join('user_role role','role.id IN (cus.userroleid)','LEFT OUTER');    	       					  
        $this->db->where('cus.active','< 2');		
		$this->db->where('cus.id',$id);		
		$query = $this->db->get();
		
        if ($query->num_rows()==0){
            return false;
        }else{
            $data['header'] = $query->row_array();                          
            return $data;         
        }
	}
	
	function getDetailWSP($customerno){        
		$this->db->select('id, customerno, name');        
		$this->db->from('customer');  	       					  
        $this->db->where('active','< 2');		
		$this->db->where('customerno',$customerno);		
		$query = $this->db->get();
		
        if ($query->num_rows()==0){
            return false;
        }else{
			$data['header'] = $query->row_array();
			$customerno = $data['header']['customerno'];
			
			$this->db->select('cusw.id, cusw.customerno, cusw.startdate, cusw.enddate, cusw.class, lk.lookupdesc as class_desc, mg.id as materialgroup_id, mg.description as materialgroup_desc, cusw.wspcode, cusw.reason');        
			$this->db->from('customer_wsp cusw'); 
			$this->db->join('customer cus','cus.customerno=cusw.customerno','LEFT OUTER');
			$this->db->join("lookup lk","lk.lookupkey='wsp_class' AND lk.lookupvalue=cusw.class","LEFT OUTER"); 
			$this->db->join('material_group mg','mg.id=cusw.materialgroupid','LEFT OUTER');    	       					  
			$this->db->where('cusw.active','< 2');		
			$this->db->where('cusw.customerno',$customerno);
			
			$query = $this->db->get();
			
			$data['detail'] = $query->result_array();
            return $data;         
        }
    }
			
	function delete_customer($data) {
						
		$arr = array(
			'active' => '2',
			'updatedon' => date("Y-m-d H:i:s"),
			'updatedby' => $this->session->userdata('userid'),	
		);
		$this->db->where('id', $data);
		$this->db->update('customer', $arr);				
		
		if ($this->db->trans_status() === TRUE){	
			$ret["status"] = 1;															
			$this->db->trans_commit();
		}else{
			$ret["status"] = 0;
			$this->db->trans_rollback();						
		}
		
		return $ret;	
	}

	function cekCustGroup($customergroupid){			
		$this->db->select('cg.id');        
        $this->db->from('customer_group cg');                       
        $this->db->where('cg.active','0');
		$this->db->where('cg.id',$customergroupid);	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}
	
	function cekPriceType($pricetype){			
		$this->db->select('p.id');        
        $this->db->from('price p');                       
        $this->db->where('p.active','0');
		$this->db->where('p.id',$pricetype);	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}
	
	function cekRegion($regionid){			
		$this->db->select('r.id');        
        $this->db->from('region r');                       
        $this->db->where('r.active','0');
		$this->db->where('r.id',$regionid);	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}
	
	function cekSalesOffice($salesofficeid){			
		$this->db->select('so.id');        
        $this->db->from('sales_office so');
        $this->db->where('so.active','0');
		$this->db->where('so.id',$salesofficeid);	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}
	
	function cekSalesGroup($salesgroupid){			
		$this->db->select('sg.id');        
        $this->db->from('sales_group sg');
        $this->db->where('sg.active','0');
		$this->db->where('sg.id',$salesgroupid);	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}
	
	function cekSalesDistrict($salesdistrictid){			
		$this->db->select('sd.id');        
        $this->db->from('sales_district sd');
        $this->db->where('sd.active','0');
		$this->db->where('sd.id',$salesdistrictid);	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}
	
	function cekRole($roleid){
		$role["id"] 	= explode(",", $roleid);
		// print_r($role["id"]);exit;			
		$this->db->select('r.id');        
        $this->db->from('user_role r');
        $this->db->where('r.active','0');
		$this->db->where("r.id in ($roleid)");	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
	
	function upload($data) {
		$data = json_decode($data,true);
		// print_r($data);exit;	
		$detail = $data["detail"];
		$detail = json_decode($detail,true);
		
		$ret["message"] = "";
		$counter = 0;
		$countsuccess = 0;
		$countfailed = 0;
		foreach ($detail as $row) {	
			$counter += 1;
			$ok = true;
			
			// $periode = $this->mtarget->getPeriode($row["year"], $row['cycle']);
			// $salesmanid = $this->mtarget->getSalesman($row["userid"]);
			// $materialgroupid = $this->mtarget->getMaterialGroup($row["materialgroup"]);
			// $id = $this->mtarget->getTargetId($row['year'], $row["cycle"], $row["userid"], $row["materialgroup"], '0');
			$cekCustGroup = $this->cekCustGroup($row["Customer_Group"]);
			$cekPriceType = $this->cekPriceType($row["Price_Type"]);
			$cekRegion = $this->cekRegion($row["Region"]);
			$cekSalesOffice = $this->cekSalesOffice($row["Sales_Office"]);
			$cekSalesGroup = $this->cekSalesGroup($row["Sales_Group"]);
			$cekSalesDistrict = $this->cekSalesDistrict($row["Sales_District"]);
			$cekRole = $this->cekRole($row["Role"]);

			if ($row['Nama'] == '' || $row["Address"] == '' || $row["City"] == '' || $row["Owner"] == '' || $row["Phone"] == '' || $row["Customer_Group"] == '' || $row["Price_Type"] == '' || $row["Region"] == '' || $row["Sales_Office"] == '' || $row["Sales_Group"] == '' || $row["Sales_District"] == '' || $row["Role"] == '')
			{				
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Please enter data in all columns<br/> ";
				$countfailed += 1;
				$ok = false;
			}
			else if (count($cekCustGroup) == 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Customer Group not valid<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			else if (count($cekPriceType) == 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Price Type not found<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			else if (count($cekRegion) == 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Region not found<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			else if (count($cekSalesOffice) == 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Sales Office not found<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			else if (count($cekSalesGroup) == 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Sales Group not found<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			else if (count($cekSalesDistrict) == 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Sales District not found<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			else if (count($cekRole) == 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Role not found<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			// else if (count($id) > 0)
			// {
			// 	$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Double target for this salesman<br/> ";
			// 	$countfailed += 1;
			// 	$ok = false;				
			// }
			
			if ($ok == true)
			{
				$salesoffice_code = $this->getSalesOfficeCode($row['Sales_Office']);
				
				$customerno = $this->getCustomerNo($salesoffice_code[0]["code"]);
				// print_r($customerno[0]["customerno"]);exit;
				$detaildata = array(
						"customerno" => $customerno[0]["customerno"],
						"name" => $row["Nama"],
						"address" => $row["Address"],
						"city" => $row["City"],
						"owner" => $row["Owner"],							
						"phone" => $row['Phone'],
						"customergroupid" => $row["Customer_Group"],
						"priceid" => $row["Price_Type"],
						"salesdistrictid" => $row["Sales_District"],
						"userroleid" => $row["Role"],							
						"active" => '0',							
						"createdby" => $this->session->userdata('id'),
						"createdon" => date("Y-m-d H:i:s")								
				);
				$this->db->insert('customer', $detaildata);	
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