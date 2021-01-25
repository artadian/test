<?php
class mmasterdata extends CI_Model {

	function getUserRole($userid){
		$this->db->select('userroleid');        
        $this->db->from('user');                       
        $this->db->where('active','0');	
		$this->db->where('userid',$userid);
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
	}

	function getTipe(){
	        $this->db->select('id,nama');        
	        $this->db->from('tipe ');       
	        $query = $this->db->get();
	        $query = $query->result_array();  
	        return $query;
		}

	function getSupplier(){
	        $this->db->select('kodesupplier,nama');        
	        $this->db->from('supplier');       
	        $query = $this->db->get();
	        $query = $query->result_array();  
	        return $query;
		}

	function getUOM(){
	        $this->db->select('id,nama');        
	        $this->db->from('uom'); 
	        $this->db->where('active','1');   
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

	function getDataBarang(){	
		//print_r($arr);			
        $this->db->select('b.kode,b.nama,b.merk,s.kodesupplier');        
		$this->db->from('barangsupplier b');
		$this->db->join('supplier s','s.kodesupplier = b.supplierid','LEFT');
		$this->db->order_by('b.createdon','DESC');
        $query = $this->db->get();        
        return $query;
    }  

    function getDataSupplier(){	
		//print_r($arr);			
        $this->db->select('s.kodesupplier,s.nama,s.alamat,s.kota,s.telpon,s.email');        
		$this->db->from('supplier s');
		$this->db->where('s.isactive','1');		
		// $this->db->join('supplier s','s.kodesupplier = b.supplierid','LEFT');
		$this->db->order_by('s.nama','ASC');
        $query = $this->db->get();        
        return $query;
    }  
			
	function savebarang($data) {
		$data = json_decode($data,true);
		$detail = $data;
		$detail = json_decode($detail,true);

			// var_dump($detail);exit();
		foreach ($detail as $row) {					
						$detaildata = array(
								"kode" => $row['kode'],
								"nama" => $row["nama"],
								"supplierid" => $row["supplier"],
								"merk" => $row["merk"],
								"createdby" => $this->session->userdata('userid'),
								"createdon" => date("Y-m-d H:i:s")									
						);
						$this->db->insert('barangsupplier', $detaildata);					
					}
					
				
					if ($this->db->trans_status() === TRUE){	
						$ret["status"] = 1;																	
						$this->db->trans_commit();
					}else{
						$ret["status"] = 0;
						$this->db->trans_rollback();						
					}	

		return $ret;
	}
	function savesupplier($data) {
		$data = json_decode($data,true);
		$detail = $data["detail"];
		$detail = json_decode($detail,true);
		
		$header = $data["header"];
		$header = json_decode($header,true);
							
			$headerdata = array(
					"kodesupplier" => $header['kodesupplier'],
					"nama" => $header["nama"],
					"alamat" => $header["alamat"],
					"kota" => $header["kota"],
					"telpon" => $header["telepon"],
					"email" => $header["email"],
					"isactive" => "1",
					"createdon" => date("Y-m-d H:i:s")									
			);
			$this->db->insert('supplier', $headerdata);					
			foreach ($detail as $row) {					
						$detaildata = array(
								"kode" => $row['kode'],
								"nama" => $row["nama"],
								"merk" => $row["merk"],
								"supplierid" => $header['kodesupplier'],
								"createdby" => $this->session->userdata('userid'),
								"createdon" => date("Y-m-d H:i:s")									
						);
						$this->db->insert('barangsupplier', $detaildata);					
					}			
					
				
					if ($this->db->trans_status() === TRUE){	
						$ret["status"] = 1;																	
						$this->db->trans_commit();
					}else{
						$ret["status"] = 0;
						$this->db->trans_rollback();						
					}	

		return $ret;
	}
	
	function getDetail($id){        

		
		$this->db->select('b.kode,b.nama,b.merk');         
		$this->db->from('barangsupplier b');    	       					  	
		$this->db->where('b.nama',$id);		
		$query = $this->db->get();
		return false;
        // if ($query->num_rows()==0){
            // return false;
   //      }else{
   //          $data['header'] = $query->row_array();
			
			// $posmid = $data['header']['id'];
						
			// $this->db->select('pd.id, pd.posmtypeid, pd.materialgroupid, pd.status, pd.qty, pd.condition, pd.notes');
			// $this->db->from('posm_detail pd');        			
			// $this->db->join('material_group mg','mg.id = pd.materialgroupid','LEFT'); 
			// $this->db->where('pd.active','0');		
			// $this->db->where('pd.posmid',$posmid);		
			// $query = $this->db->get();
			
			// $data['detail'] = $query->result_array();
                              
   //          return $data;         
   //      }
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