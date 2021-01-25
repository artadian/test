<?php
class mtransaksi extends CI_Model {

	
	function getData($arr){	
		//print_r($arr);			
        $this->db->select('b.kode,b.nama,b.merk,t.nama as tipe');        
		$this->db->from('barangsupplier b');
        $this->db->join('tipe t','b.tipe = t.id','LEFT');
		$this->db->order_by('b.createdon','DESC');
        $query = $this->db->get();        
        return $query;
    }  
    function getSumPO(){
        // $salesofficeid = $this->session->userdata('salesofficeid');
        
        $this->db->select('count(p.id) as totalPO');        
        $this->db->from('poheader p');
        $query = $this->db->get()->result_array();
        //$query = $query->result_array();  
        return $query;
    } 

    function getDataPO($arr){	
		//print_r($arr);			
        $this->db->select('p.orderdate,s.nama,l.lookupvalue as status');        
		$this->db->from('poheader p');
        $this->db->join('supplier s','p.kodesupplier = s.kodesupplier','LEFT');
        $this->db->join('lookup l','p.status = l.lookupkey','LEFT');
        
		$this->db->order_by('p.orderdate','ASC');
        $query = $this->db->get();        
        return $query;
    }  

    function getMaterial($arr){	
		//print_r($arr);			
        $this->db->select('b.kode,b.nama');        
		$this->db->from('barangsupplier b');
        $this->db->join('supplier s','b.supplierid = s.kodesupplier','LEFT');
        $this->db->where('s.kodesupplier',$arr);
		$this->db->order_by('b.createdon','DESC');
        $query = $this->db->get();
		$query = $query->result_array();  
	    return $query;
    }  

    function getMaterialDetail($id){	
		// print_r($id);			
        $this->db->select('b.nama,b.merk');        
		$this->db->from('barangsupplier b');
        $this->db->where('b.kode',$id);
		$this->db->order_by('b.createdon','DESC');
        $query = $this->db->get();
		$query = $query->result_array();  
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
								"tipe" => $row["tipe"],
								"merk" => $row["merk"],
								"createdby" => $this->session->userdata('userid'),
								"createdon" => date("Y-m-d H:i:s")									
						);
						$this->db->insert('barang', $detaildata);					
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
	function savePO($data) {
		$data = json_decode($data,true);
		$detail = $data["detail"];
		$detail = json_decode($detail,true);
		
		$header = $data["header"];
		$header = json_decode($header,true);
		// var_dump($detail);exit();
		if ($detail == []) {
			$ret["status"] = 0;
			$ret["message"] = "Material Kosong";
			return $ret;
							}					
			$headerdata = array(
					"nomor" => $header['nomor'],
					"kodesupplier" => $header["kodesupplier"],
					"orderdate" => date("Y-m-d")								
			);
			$this->db->insert('poheader', $headerdata);	
			$idpo = $this->db->insert_id();				
			foreach ($detail as $row) {					
						$detaildata = array(
								"poheaderid" => $idpo,
								"kodebarang" => $row['kode'],
								"namabarang" => $row["nama"],
								"merkbarang" => $row["merk"],
								"qty" => $row['qty'],
								"satuan" => $row['satuan'],
								"createdby" => $this->session->userdata('userid'),
								"createdon" => date("Y-m-d H:i:s")									
						);
						$this->db->insert('podetail', $detaildata);					
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
	
	function getDetail(){        
		$this->db->select('b.nama,b.kode,b.merk,t.nama as tipe');        
		$this->db->from('barangsupplier b'); 
		$this->db->join('supplier t','t.kodesupplier = b.supplierid','LEFT');   	       					  	
		// $this->db->where('t.id',$id);		
		$query = $this->db->get();
		return false;
   //      if ($query->num_rows()==0){
   //          return false;
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
			
	
}