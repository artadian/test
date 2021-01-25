<?php
class msellin extends CI_Model {

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
		//print_r($arr);			
        $this->db->select('s.id, s.sellinno, DATE_FORMAT(s.sellindate,"%d-%m-%Y") sellindate, 
							CONCAT(s.userid," - ",u.name) as salesman, CONCAT(s.customerno," - ",c.name) as customer,
							s.amount');        
		$this->db->from('sellin s');
        $this->db->join('user u','u.userid = s.userid','LEFT');
		$this->db->join('customer c','c.customerno = s.customerno','LEFT');    		       
        $this->db->where('s.active','0');	
		$this->db->where('s.sellindate >=',$arr[3]);	
		$this->db->where('s.sellindate <=',$arr[4]);	
		if ($arr[0] <> "-" && $arr[0] <> "") //regionid
		{
			$this->db->where('s.regionid',$arr[0]);	
		}
		if ($arr[1] <> "-" && $arr[1] <> "") //salesofficeid
		{
			$this->db->where('s.salesofficeid',$arr[1]);	
		}			
		if ($arr[2] <> "-" && $arr[2] <> "") //salesmanid
		{
			$this->db->where('s.userid',$arr[2]);	
		}
		if ($this->session->userdata('regionid') <> '0')
		{
			$this->db->where('s.regionid in ('.$this->session->userdata('regionid').')',NULL,FALSE);
		}
		if ($this->session->userdata('salesofficeid') <> '0')
		{
			$this->db->where('s.salesofficeid in ('.$this->session->userdata('salesofficeid').')',NULL,FALSE);
		}
		$this->db->order_by('s.sellindate','DESC');
		$this->db->order_by('s.customerno','ASC');
        $query = $this->db->get();        
        return $query;
    } 
	
	function getPriceID($id){		
		$this->db->select('c.priceid');        
        $this->db->from('customer c');                       
        $this->db->where('c.active','0');	
		$this->db->where('c.customerno',$id);				
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
        return $query;
    } 
	
	function getBalSlofPac($materialid){		
		$this->db->select('CAST((m.bal/m.pac) as SIGNED) bal, CAST((m.slof/m.pac) as SIGNED) slof');        
        $this->db->from('material m');                       
        $this->db->where('m.active','0');	
		$this->db->where('m.id',$materialid);		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function getIntrodeal($materialid, $salesofficeid, $tgl){		
		$this->db->select('i.qtyorder, i.qtybonus');        
        $this->db->from('introdeal i');                       
        $this->db->where('i.active','0');	
		$this->db->where('i.materialid',$materialid);	
		$this->db->where('i.salesofficeid',$salesofficeid);
		$this->db->where('i.startdate <=',$tgl);
		$this->db->where('i.enddate >=',$tgl);	
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function getCustIntrodeal($materialid, $customerno){		
		$this->db->select('sd.id');        
        $this->db->from('sellin s');       
		$this->db->join('sellin_detail sd','s.id = sd.sellinid','LEFT');                
        $this->db->where('s.active','0');	
		$this->db->where('sd.active','0');	
		$this->db->where('sd.materialid',$materialid);	
		$this->db->where('s.customerno',$customerno);	
		$this->db->where('sd.qtyintrodeal >','0');	
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function getSellinId($customerno, $tgl, $id){		
		$this->db->select('s.id');        
        $this->db->from('sellin s');              
        $this->db->where('s.active','0');			
		$this->db->where('s.customerno',$customerno);	
		$this->db->where('s.sellindate',$tgl);	
		$this->db->where('s.id <>',$id);	
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
			
	function save($data) {
		$data = json_decode($data,true);
		
		$detail = $data["detail"];
		$detail = json_decode($detail,true);
		
		$header = $data["header"];
		$header = json_decode($header,true);
		
		if ($header['id'] > 0) //edit
		{
			$id = $this->msellin->getSellinId($header['customerno'], $header["sellindate"], $header['id']);	
			
			if (count($id) > 0)
			{
				$ret["status"] = 0;
				$ret["message"] = "Double sellin for this customer";
			}
			else
			{
				$headerdata = array(
						"sellinno" => $header["sellinno"],					
						"amount" => $header['total'],																
						"updatedby" => $this->session->userdata('id'),
						"updatedon" => date("Y-m-d H:i:s")							
				);
				
				$this->db->where('id', $header['id']);
				$this->db->update('sellin', $headerdata);		
					
				$headerdata = array(
						"active" => "2",																									
						"updatedby" => $this->session->userdata('id'),
						"updatedon" => date("Y-m-d H:i:s")							
				);	
				$this->db->where('sellinid', $header['id']);
				$this->db->update('sellin_detail', $headerdata);		
				
				$counter = 1;
				foreach ($detail as $row) {	
					if ($row['id'] == '0') //insert
					{
						$detaildata = array(
								"sellinid" => $header['id'],
								"materialid" => $row["materialid"],
								"bal" => $row["bal"],
								"slof" => $row["slof"],
								"pac" => $row["pac"],
								"qty" => $row["qty"],
								"qtyintrodeal" => $row["qtyintrodeal"],
								"price" => $row["price"],
								"sellinvalue" => $row["sellinvalue"],
								"active" => 0,
								"createdby" => $this->session->userdata('id'),
								"createdon" => date("Y-m-d H:i:s")									
						);
						$this->db->insert('sellin_detail', $detaildata);
					}
					else //update
					{
						$detaildata = array(							
								"materialid" => $row["materialid"],
								"bal" => $row["bal"],
								"slof" => $row["slof"],
								"pac" => $row["pac"],
								"qty" => $row["qty"],
								"qtyintrodeal" => $row["qtyintrodeal"],
								"price" => $row["price"],
								"sellinvalue" => $row["sellinvalue"],
								"active" => 0,
								"updatedby" => $this->session->userdata('id'),
								"updatedon" => date("Y-m-d H:i:s")									
						);
						$this->db->where('id', $row['id']);
						$this->db->update('sellin_detail', $detaildata);		
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
			$id = $this->msellin->getSellinId($header['customerno'], $header["sellindate"], '0');	
			
			if (count($id) > 0)
			{
				$ret["status"] = 0;
				$ret["message"] = "Double sellin for this customer";
			}
			else
			{
				$territory = $this->mglobal->getTerritory($header['customerno']);	
				$periode = $this->mglobal->getPeriode($header['sellindate']);	
				
				if (count($territory) > 0 && count($periode) > 0)
				{
					$headerdata = array(
								"sellinno" => $header["sellinno"],
								"customerno" => $header["customerno"],
								"sellindate" => $header["sellindate"],
								"userid" => $header["userid"],
								"regionid" => $territory[0]["regionid"],
								"salesofficeid" => $territory[0]["salesofficeid"],
								"salesgroupid" => $territory[0]["salesgroupid"],
								"salesdistrictid" => $territory[0]["salesdistrictid"],
								"amount" => $header['total'],
								"cycle" => $periode[0]["cycle"],
								"week" => $periode[0]["week"],
								"year" => $periode[0]["year"],
								"export" => '0',
								"active" => '0',							
								"createdby" => $this->session->userdata('id'),
								"createdon" => date("Y-m-d H:i:s")							
					);
					
					$this->db->insert('sellin', $headerdata);
					$sellinid = $this->db->insert_id();
					
					foreach ($detail as $row) {					
						$detaildata = array(
								"sellinid" => $sellinid,
								"materialid" => $row["materialid"],
								"bal" => $row["bal"],
								"slof" => $row["slof"],
								"pac" => $row["pac"],
								"qty" => $row["qty"],
								"qtyintrodeal" => $row["qtyintrodeal"],
								"price" => $row["price"],
								"sellinvalue" => $row["sellinvalue"],
								"active" => 0,
								"createdby" => $this->session->userdata('id'),
								"createdon" => date("Y-m-d H:i:s")									
						);
						$this->db->insert('sellin_detail', $detaildata);					
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
		$this->db->select('s.id, s.sellinno, s.customerno, s.sellindate, s.userid, s.amount, 
						s.regionid, s.salesofficeid, c.priceid');        
		$this->db->from('sellin s'); 
		$this->db->join('customer c','c.customerno = s.customerno','LEFT');   	       					  
        $this->db->where('s.active','< 2');		
		$this->db->where('s.id',$id);		
		$query = $this->db->get();
		
        if ($query->num_rows()==0){
            return false;
        }else{
            $data['header'] = $query->row_array();
			
			$sellinid = $data['header']['id'];
						
			$this->db->select('sd.id, sd.materialid, sd.bal, sd.slof, sd.pac, sd.qty, sd.qtyintrodeal, sd.price, sd.sellinvalue,
								CAST((m.bal/m.pac) as SIGNED) balid, CAST((m.slof/m.pac) as SIGNED) slofid, 
								IFNULL(i.qtyorder,0) qtyorder, IFNULL(i.qtybonus,0) qtybonus,
								IF((select count(sdd.id) from sellin ss left join sellin_detail sdd on ss.id = sdd.sellinid 
								 where ss.active = 0 and sdd.active = 0 
								 and sdd.materialid = sd.materialid
								 and ss.customerno = "'.$data['header']['customerno'].'"
								 and sdd.qtyintrodeal > 0
								 and ss.id <> "'.$sellinid.'") > 0,"Y","N") custintrodeal
								');
			$this->db->from('sellin_detail sd');        			
			$this->db->join('material m','m.id = sd.materialid','LEFT'); 
			$this->db->join('introdeal i','i.materialid = sd.materialid 
								and i.salesofficeid = "'.$data['header']['salesofficeid'].'"
								and i.startdate <= "'.$data['header']['sellindate'].'"
								and i.enddate >= "'.$data['header']['sellindate'].'"','LEFT');   			
			$this->db->where('sd.active','0');		
			$this->db->where('sd.sellinid',$sellinid);		
			$query = $this->db->get();
			
			$data['detail'] = $query->result_array();
                              
            return $data;         
        }
    }
			
	function delete_sellin($data) {
						
		$arr = array(
			'active' => '2',
			'updatedon' => date("Y-m-d H:i:s"),
			'updatedby' => $this->session->userdata('id'),	
		);
		$this->db->where('id', $data);
		$this->db->update('sellin', $arr);				
		
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