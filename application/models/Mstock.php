<?php
class mstock extends CI_Model {
   	function getData($arr){	
		//print_r($arr);

        $this->db->select('s.id, DATE_FORMAT(s.stockdate,"%d-%m-%Y") stockdate, 
							CONCAT(s.userid," - ",u.name) as salesman, CONCAT(s.customerno," - ",c.name) as customer');        
		$this->db->from('stock s');
        $this->db->join('user u','u.userid = s.userid','LEFT');
		$this->db->join('customer c','c.customerno = s.customerno','LEFT');    		       
        $this->db->where('s.active','0');	
		$this->db->where('s.stockdate >=',$arr[3]);	
		$this->db->where('s.stockdate <=',$arr[4]);	
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
		$this->db->order_by('s.stockdate','DESC');
		$this->db->order_by('s.customerno','ASC');
        $query = $this->db->get();
        return $query;
        
    } 
    function getDetail($id){        
		$this->db->select('s.id,s.customerno,s.stockdate,s.userid,s.regionid, s.salesofficeid,c.priceid ');        
		$this->db->from('stock s'); 
		$this->db->join('customer c','c.customerno = s.customerno','LEFT');   	       					  
        $this->db->where('s.active','< 2');		
		$this->db->where('s.id',$id);		
		$query = $this->db->get();
		
        if ($query->num_rows()==0){
            return false;
        }else{
            $data['header'] = $query->row_array();
			
			$stockid = $data['header']['id'];
						
			$this->db->select('sd.id, sd.materialid,m.name as materialname, sd.bal, sd.slof, sd.pac, sd.qty,
								CAST((m.bal/m.pac) as SIGNED) balid, CAST((m.slof/m.pac) as SIGNED) slofid, 
								IFNULL(i.qtyorder,0) qtyorder, IFNULL(i.qtybonus,0) qtybonus,
								IF((select count(sdd.id) from stock ss left join stock_detail sdd on ss.id = sdd.stockid 
								 where ss.active = 0 and sdd.active = 0 
								 and sdd.materialid = sd.materialid
								 and ss.customerno = "'.$data['header']['customerno'].'"
								 and ss.id <> "'.$stockid.'") > 0,"Y","N") custintrodeal
								');
			$this->db->from('stock_detail sd');        			
			$this->db->join('material m','m.id = sd.materialid','LEFT'); 
			$this->db->join('introdeal i','i.materialid = sd.materialid 
								and i.salesofficeid = "'.$data['header']['salesofficeid'].'"
								and i.startdate <= "'.$data['header']['stockdate'].'"
								and i.enddate >= "'.$data['header']['stockdate'].'"','LEFT');   			
			$this->db->where('sd.active','0');		
			$this->db->where('sd.stockid',$stockid);		
			$query = $this->db->get();
			
			$data['detail'] = $query->result_array();
                              
            return $data;         
        }
    }
    function save($data) {
		$data = json_decode($data,true);
		
		$detail = $data["detail"];
		$detail = json_decode($detail,true);
		
		$header = $data["header"];
		$header = json_decode($header,true);
		
		if ($header['id'] > 0) //edit
		{

			$id = $this->mstock->getStockId($header['customerno'], $header["stockdate"], $header['id']);	
			if (count($id) > 0)
			{
				$ret["status"] = 0;
				$ret["message"] = "Double Stock for this customer";
			}
			else
			{


				$headerdata = array(	

						"updatedby" => $this->session->userdata('id'),
						"updatedon" => date("Y-m-d H:i:s")							
				);
				
				$this->db->where('id', $header['id']);
				$this->db->update('stock', $headerdata);		
					
				$headerdata = array(
						"active" => "2",																									
						"updatedby" => $this->session->userdata('id'),
						"updatedon" => date("Y-m-d H:i:s")							
				);	
				$this->db->where('stockid', $header['id']);
				$this->db->update('stock_detail', $headerdata);		
				
				$counter = 1;
				foreach ($detail as $row) {	
					if ($row['id'] == '0') //insert
					{
						$detaildata = array(
								"stockid" => $header['id'],
								"materialid" => $row["materialid"],
								"bal" => $row["bal"],
								"slof" => $row["slof"],
								"pac" => $row["pac"],
								"qty" => $row["qty"],
								"active" => 0,
								"createdby" => $this->session->userdata('id'),
								"createdon" => date("Y-m-d H:i:s")									
						);
						$this->db->insert('stock_detail', $detaildata);
					}
					else //update
					{
						$detaildata = array(							
								"materialid" => $row["materialid"],
								"bal" => $row["bal"],
								"slof" => $row["slof"],
								"pac" => $row["pac"],
								"qty" => $row["qty"],
								"active" => 0,
								"updatedby" => $this->session->userdata('id'),
								"updatedon" => date("Y-m-d H:i:s")									
						);
						$this->db->where('id', $row['id']);
						$this->db->update('stock_detail', $detaildata);		
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
			$id = $this->mstock->getStockId($header['customerno'], $header["stockdate"], '0');

			if (count($id) > 0)
			{
				$ret["status"] = 0;
				$ret["message"] = "Double Stock for this customer";
			}
			else
			{

				$territory = $this->mglobal->getTerritory($header['customerno']);	
				$periode = $this->mglobal->getPeriode($header['stockdate']);	
				
				//var_dump($header['customerno']);exit();
				if (count($territory) > 0 && count($periode) > 0)
				{
					$headerdata = array(
								
								"customerno" => $header["customerno"],
								"stockdate" => $header["stockdate"],
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
					
					$this->db->insert('stock', $headerdata);
					$stockid = $this->db->insert_id();
					
					foreach ($detail as $row) {					
						$detaildata = array(
								"stockid" => $stockid,
								"materialid" => $row["materialid"],
								"bal" => $row["bal"],
								"slof" => $row["slof"],
								"pac" => $row["pac"],
								"qty" => $row["qty"],
								"active" => 0,
								"createdby" => $this->session->userdata('id'),
								"createdon" => date("Y-m-d H:i:s")									
						);
						$this->db->insert('stock_detail', $detaildata);					
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
        $this->db->from('stock s');       
		$this->db->join('stock_detail sd','s.id = sd.stockid','LEFT');                
        $this->db->where('s.active','0');	
		$this->db->where('sd.active','0');	
		$this->db->where('sd.materialid',$materialid);	
		$this->db->where('s.customerno',$customerno);
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	
	
			
	function delete_stock($data) {
						
		$arr = array(
			'active' => '2',
			'updatedon' => date("Y-m-d H:i:s"),
			'updatedby' => $this->session->userdata('id'),	
		);
		$this->db->where('id', $data);
		$this->db->update('stock', $arr);				
		
		if ($this->db->trans_status() === TRUE){	
			$ret["status"] = 1;															
			$this->db->trans_commit();
		}else{
			$ret["status"] = 0;
			$this->db->trans_rollback();						
		}
		
		return $ret;	
	}  
	function getStockId($customerno, $tgl, $id){		
		$this->db->select('s.id');        
        $this->db->from('stock s');              
        $this->db->where('s.active','0');			
		$this->db->where('s.customerno',$customerno);	
		$this->db->where('s.stockdate',$tgl);	
		$this->db->where('s.id <>',$id);	
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }   

}