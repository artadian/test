<?php
class mtarget extends CI_Model {

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
	
	function getYear(){	
		$this->db->distinct();	
		$this->db->select('t.year id, t.year name');        
        $this->db->from('target t');                       
        $this->db->where('t.active','0');	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function getYearInput(){			
		$this->db->select('t.year id, t.year name
						from target t
						where t.active < 2
						union
						select year(now()) id, year(curdate()) name 
						union
						select year(DATE_ADD(NOW(), INTERVAL 1 YEAR)) id, year(DATE_ADD(NOW(), INTERVAL 1 YEAR)) name
						');        
        					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function getData($arr){	
		//print_r($arr);			
        $this->db->select('t.id, t.year, t.cycle, 
							CONCAT(t.userid," - ",u.name) as salesman, CONCAT(t.materialgroupid," - ",mg.name) as materialgroup,
							t.call, t.effectivecall, t.nota, t.volume');        
		$this->db->from('target t');
        $this->db->join('user u','u.userid = t.userid','LEFT');
		$this->db->join('material_group mg','mg.id = t.materialgroupid','LEFT');    		       
        $this->db->where('t.active','0');			
		if ($arr[0] <> "-" && $arr[0] <> "") //regionid
		{
			$this->db->where('t.regionid',$arr[0]);	
		}
		if ($arr[1] <> "-" && $arr[1] <> "") //salesofficeid
		{
			$this->db->where('t.salesofficeid',$arr[1]);	
		}			
		if ($arr[2] <> "-" && $arr[2] <> "") //salesmanid
		{
			$this->db->where('t.userid',$arr[2]);	
		}
		if ($arr[3] <> "-" && $arr[3] <> "") //year
		{
			$this->db->where('t.year',$arr[3]);	
		}
		if ($arr[4] <> "-" && $arr[4] <> "") //cycle
		{
			$this->db->where('t.cycle',$arr[4]);	
		}
		if ($this->session->userdata('regionid') <> '0')
		{
			$this->db->where('t.regionid in ('.$this->session->userdata('regionid').')',NULL,FALSE);
		}
		if ($this->session->userdata('salesofficeid') <> '0')
		{
			$this->db->where('t.salesofficeid in ('.$this->session->userdata('salesofficeid').')',NULL,FALSE);
		}
		$this->db->order_by('t.userid','ASC');
        $query = $this->db->get();        
        return $query;
    } 
		
	function getTargetId($year, $cycle, $userid, $materialgroupid, $id){		
		$this->db->select('t.id');        
        $this->db->from('target t');              
        $this->db->where('t.active','0');			
		$this->db->where('t.year',$year);	
		$this->db->where('t.cycle',$cycle);	
		$this->db->where('t.userid',$userid);	
		$this->db->where('t.materialgroupid',$materialgroupid);	
		$this->db->where('t.id <>',$id);	
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function save($data) {
		$data = json_decode($data,true);
			
		$header = $data["header"];
		$header = json_decode($header,true);
		
		if ($header['id'] > 0) //edit
		{
			$id = $this->mtarget->getTargetId($header['year'], $header["cycle"], $header["userid"], $header["materialgroup"], $header["id"]);	
			
			if (count($id) > 0)
			{
				$ret["status"] = 0;
				$ret["message"] = "Double target for this salesman";
			}
			else
			{
				$headerdata = array(						
						"call" => $header["call"],
						"effectivecall" => $header["effectivecall"],
						"nota" => $header["nota"],
						"volume" => $header["volume"],																
						"updatedby" => $this->session->userdata('id'),
						"updatedon" => date("Y-m-d H:i:s")							
				);
				
				$this->db->where('id', $header['id']);
				$this->db->update('target', $headerdata);		
							
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
			$id = $this->mtarget->getTargetId($header['year'], $header["cycle"], $header["userid"], $header["materialgroup"], '0');	
			
			if (count($id) > 0)
			{
				$ret["status"] = 0;
				$ret["message"] = "Double target for this salesman";
			}
			else
			{				
				$headerdata = array(
							"year" => $header["year"],
							"cycle" => $header["cycle"],
							"regionid" => $header["regionid"],
							"salesofficeid" => $header["salesofficeid"],
							"userid" => $header["userid"],							
							"materialgroupid" => $header['materialgroup'],
							"call" => $header["call"],
							"effectivecall" => $header["effectivecall"],
							"nota" => $header["nota"],
							"volume" => $header["volume"],							
							"active" => '0',							
							"createdby" => $this->session->userdata('id'),
							"createdon" => date("Y-m-d H:i:s")							
				);
				
				$this->db->insert('target', $headerdata);
							
				if ($this->db->trans_status() === TRUE){	
					$ret["status"] = 1;																	
					$this->db->trans_commit();
				}else{
					$ret["status"] = 0;
					$this->db->trans_rollback();						
				}	
				
				
			}	
			
						
		}
			
		return $ret;
	}
	
	function getDetail($id){        
		$this->db->select('t.id, t.year, t.cycle, 
						t.regionid, t.salesofficeid, t.userid, t.materialgroupid,
						t.call, t.effectivecall, t.nota, t.volume ');        
		$this->db->from('target t'); 							  
        $this->db->where('t.active','< 2');		
		$this->db->where('t.id',$id);		
		$query = $this->db->get();
		
        if ($query->num_rows()==0){
            return false;
        }else{
            $data['header'] = $query->row_array();
			                             
            return $data;         
        }
    }
			
	function delete_target($data) {
						
		$arr = array(
			'active' => '2',
			'updatedon' => date("Y-m-d H:i:s"),
			'updatedby' => $this->session->userdata('id'),	
		);
		$this->db->where('id', $data);
		$this->db->update('target', $arr);				
		
		if ($this->db->trans_status() === TRUE){	
			$ret["status"] = 1;															
			$this->db->trans_commit();
		}else{
			$ret["status"] = 0;
			$this->db->trans_rollback();						
		}
		
		return $ret;	
	}   
	
	function upload($data) {
		$data = json_decode($data,true);
			
		$detail = $data["detail"];
		$detail = json_decode($detail,true);
		
		$ret["message"] = "";
		$counter = 0;
		$countsuccess = 0;
		$countfailed = 0;
		foreach ($detail as $row) {	
			$counter += 1;
			$ok = true;
			
			$periode = $this->mtarget->getPeriode($row["year"], $row['cycle']);
			$salesmanid = $this->mtarget->getSalesman($row["userid"]);
			$materialgroupid = $this->mtarget->getMaterialGroup($row["materialgroup"]);
			$id = $this->mtarget->getTargetId($row['year'], $row["cycle"], $row["userid"], $row["materialgroup"], '0');	
			if ($row['year'] == '' || $row["cycle"] == '' || $row["userid"] == '' || $row["materialgroup"] == '' || $row["call"] == '' || $row["effectivecall"] == '' || $row["nota"] == '' || $row["volume"] == '')
			{				
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Please enter data in all columns<br/> ";
				$countfailed += 1;
				$ok = false;
			}
			else if (count($periode) == 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Year / Cycle not valid<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			else if (count($salesmanid) == 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Salesman not found<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			else if (count($materialgroupid) == 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Material Group not found<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			else if (count($id) > 0)
			{
				$ret["message"] .= "Row ".($counter+1)." : <strong>FAILED !!!</strong> Double target for this salesman<br/> ";
				$countfailed += 1;
				$ok = false;				
			}
			
			if ($ok == true)
			{
				$territory = $this->mglobal->getTerritoryUser($row["userid"]);
				$detaildata = array(
						"year" => $row["year"],
						"cycle" => $row["cycle"],
						"regionid" => $territory[0]["regionid"],
						"salesofficeid" => $territory[0]["salesofficeid"],
						"userid" => $row["userid"],							
						"materialgroupid" => $row['materialgroup'],
						"call" => $row["call"],
						"effectivecall" => $row["effectivecall"],
						"nota" => $row["nota"],
						"volume" => $row["volume"],							
						"active" => '0',							
						"createdby" => $this->session->userdata('id'),
						"createdon" => date("Y-m-d H:i:s")								
				);
				$this->db->insert('target', $detaildata);	
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
	
	function getSalesman($userid){			
		$this->db->select('u.userid');        
        $this->db->from('user u');                       
        $this->db->where('u.active','0');	
		$this->db->where('u.userid',$userid);	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function getMaterialGroup($materialgroupid){			
		$this->db->select('mg.id');        
        $this->db->from('material_group mg');                       
        $this->db->where('mg.active','0');	
		$this->db->where('mg.id',$materialgroupid);	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function getPeriode($year, $cycle){			
		$this->db->select('p.id');        
        $this->db->from('periode_cycle p');                       
        $this->db->where('p.active','0');	
		$this->db->where('p.year',$year);	
		$this->db->where('p.cycle',$cycle);	
					
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
}