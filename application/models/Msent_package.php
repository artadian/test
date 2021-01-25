<?php
class msent_package extends CI_Model {

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
	
	function getData(){
		$this->db->select('ph.ID, p.No, DATE_FORMAT(ph.TglKirim, "%d-%m-%Y") Tanggal, u1.Nama as FinalStop, u2.Nama as Pengirim
					, u3.Nama as Dari, p.Keterangan, p.Status, ph.Status StatusHistory
					FROM paket p
					LEFT JOIN paket_history ph ON ph.PaketID = p.ID
					LEFT JOIN user u1 ON u1.ID = p.TujuanAkhir
					LEFT JOIN user u2 ON u2.ID = ph.Pengirim
					LEFT JOIN user u3 ON u3.ID = p.Pengirim
					WHERE p.Active < 2
					AND ph.Active < 2 AND ph.Tujuan = "'.$this->session->userdata('id').'"
					AND (select count(ID) from paket_history where PaketID = p.ID and Active < 2) > 1 
					AND ph.ID <> (select ID from paket_history where PaketID = p.ID and Active < 2 order by TglKirim desc limit 0,1) 
					AND ph.Status in ("COMPLETE") 
					AND p.Status <> "DRAFT"
					union
					SELECT ph.ID, p.No, DATE_FORMAT(ph.TglKirim, "%d-%m-%Y") Tanggal, u1.Nama as FinalStop, u2.Nama as Pengirim,
					u3.Nama as Dari, p.Keterangan, p.Status, ph.Status StatusHistory
					FROM paket p
					LEFT JOIN paket_history ph ON ph.PaketID = p.ID
					LEFT JOIN user u1 ON u1.ID = p.TujuanAkhir
					LEFT JOIN user u2 ON u2.ID = ph.Pengirim
					LEFT JOIN user u3 ON u3.ID = p.Pengirim
					WHERE p.Active < 2
					AND ph.Active < 2 AND ph.Tujuan = "'.$this->session->userdata('id').'"
					AND ph.Status in ("STOP") 
					AND p.Status <> "DRAFT"
					ORDER BY Tanggal ASC');   
		
        /*$this->db->select('ph.ID, p.No, DATE_FORMAT(ph.TglKirim,"%d-%m-%Y") Tanggal, u1.Nama as FinalStop, u2.Nama as Pengirim, u3.Nama as Dari, p.Keterangan, p.Status');        
		$this->db->from('paketa p');
        $this->db->join('paket_history ph','ph.PaketID = p.ID','LEFT');
		$this->db->join('user u1','u1.ID = p.TujuanAkhir','LEFT');
        $this->db->join('user u2','u2.ID = ph.Pengirim','LEFT');	
		$this->db->join('user u3','u3.ID = p.Pengirim','LEFT');				
        $this->db->where('p.Active <','2');
		$this->db->where('ph.Active','< 2');	
		$this->db->where('ph.Tujuan',$this->session->userdata('id'));		
		$this->db->where('(select count(ID) from paket_history where PaketID = p.ID and Active < 2) > 1',NULL,FALSE);
		$this->db->where('ph.ID <> (select ID from paket_history where PaketID = p.ID and Active < 2 order by TglKirim desc limit 0,1)',NULL,FALSE);
		$this->db->where('ph.Status in ("COMPLETE","STOP")',NULL,FALSE);		
		$this->db->where('p.Status <>','DRAFT');
		$this->db->order_by('ph.TglKirim','ASC');*/
        $query = $this->db->get();
        //$query = $query->result_array();  
        return $query;
    } 
	
	function getDetail($id){        
		$this->db->select('ph.ID, p.ID PaketID, p.No, DATE_FORMAT(p.Tanggal,"%d-%m-%Y") Tanggal, CONCAT(u1.Nama," - ",d1.Nama) as FinalStop, CONCAT(u2.Nama," - ",d2.Nama) as Dari, p.Keterangan, p.Confidential, p.Route, getNamaRoute(p.Route) NamaRoute, getNextRoute(p.ID) NextStop, getRouteNow(p.ID) RouteNow, IFNULL((select ID from paket_history where PaketID = p.ID and Status = "PROGRESS" and Pengirim = ph.Tujuan and Active < 2),0) HistoryID, ph.Pengirim, ph.Tujuan, IFNULL((select Pengirim from paket_history where PaketID = p.ID and Status = "PROGRESS" and Pengirim = ph.Tujuan and Active < 2),0) HistoryPengirim, IFNULL((select Tujuan from paket_history where PaketID = p.ID and Status = "PROGRESS" and Pengirim = ph.Tujuan and Active < 2),0) HistoryTujuan, ph.Status, (select count(ID) from dokumen_history where Active < 2 and PaketHistoryID = ph.ID and IsStop = 1 and Status = "COMPLETE") JumStop');        
		$this->db->from('paket p');        
		$this->db->join('paket_history ph','ph.PaketID = p.ID','LEFT');
		$this->db->join('user u1','u1.ID = p.TujuanAkhir','LEFT');   
		$this->db->join('departemen d1','d1.ID = u1.DeptID','LEFT');        
		$this->db->join('user u2','u2.ID = p.Pengirim','LEFT');				
		$this->db->join('departemen d2','d2.ID = u2.DeptID','LEFT');        
        $this->db->where('p.Active <','2');	
		$this->db->where('ph.Active','< 2');		
		$this->db->where('ph.ID',$id);		
		$query = $this->db->get();
		
        if ($query->num_rows()==0){
            return false;
        }else{            
			$data['header'] = $query->row_array();
			
			$paketid = $data['header']['PaketID'];
			
			$this->db->select('d.ID, d.No, d.Revisi, j.Nama Jenis, d.Deskripsi, d.Keterangan, d.Jumlah, d.Nominal');        
			$this->db->from('dokumen d');        			
			$this->db->join('jenis j','j.ID = d.Jenis','LEFT');   			
			$this->db->where('d.Active <','2');		
			$this->db->where('d.PaketID',$paketid);		
			$query = $this->db->get();			
			$data['detail'] = $query->result_array();
			
			$this->db->select('DATE_FORMAT(ph.TglKirim,"%d-%m-%Y %H:%i") TglKirim, DATE_FORMAT(ph.TglTerima,"%d-%m-%Y %H:%i") TglTerima');        	$this->db->from('paket_history ph');        						
			$this->db->where('ph.Active <','2');		
			$this->db->where('ph.PaketID',$paketid);	
			$this->db->order_by('ph.TglKirim','ASC');	
			$query = $this->db->get();			
			$data['history'] = $query->result_array();
                              
            return $data;         
        }
    }
	
	function cancel($data) {
		$data = json_decode($data,true);
		
		$header = $data["header"];
		$header = json_decode($header,true);
		
		if ($header['status'] == 'COMPLETE')
		{
			$arr = array(
				'Active' => '2',	
				'RecUser' => $this->session->userdata('id'),			
				'RecDate' => date("Y-m-d H:i:s"),	
			);
			$this->db->where('ID', $header['historyid']);
			$this->db->update('paket_history', $arr);
			
			$this->db->where('PaketHistoryID', $header['historyid']);	
			$this->db->where('Active <', 2);	
			$this->db->update('dokumen_history', $arr);
		}
				
		$arr = array(
			'Status' => 'RECEIVED',	
			'RecUser' => $this->session->userdata('id'),			
			'RecDate' => date("Y-m-d H:i:s"),	
		);
		$this->db->where('ID', $header['id']);
		$this->db->update('paket_history', $arr);
				
		$arr = array(
			'Status' => 'RECEIVED',	
			'IsStop' => '0',	
			'RecUser' => $this->session->userdata('id'),			
			'RecDate' => date("Y-m-d H:i:s"),	
		);
		$this->db->where('PaketHistoryID', $header['id']);
		$this->db->where('Active <', 2);				
		$this->db->update('dokumen_history', $arr);
		
		$arr = array(
			'Status' => 'PROGRESS',	
			'TglSelesai' => NULL,		
			'RecUser' => $this->session->userdata('id'),			
			'RecDate' => date("Y-m-d H:i:s"),			
		);
		$this->db->where('ID', $header['paketid']);
		$this->db->update('paket', $arr);			
		
		if ($this->db->trans_status() === TRUE){	
			$ret["status"] = 1;															
			$this->db->trans_commit();
		}else{
			$ret["status"] = 0;
			$this->db->trans_rollback();						
		}
		
		return $ret;			
		
	}
	
	function getPrint($id){ 
		$this->db->select('PaketID');
		$this->db->from('paket_history'); 
		$this->db->where('ID',$id);   
		$query = $this->db->get();
		$header = $query->row_array();
			       
		$this->db->select('p.No, DATE_FORMAT(ph.TglKirim,"%d-%m-%Y") Tanggal, CONCAT(u1.Nama," - ",d1.Nama," (",l1.Nama,")") as NextStop, CONCAT(u2.Nama," - ",d2.Nama," (",l2.Nama,")") as Pengirim');        
		$this->db->from('paket p');        		
		$this->db->join('paket_history ph','ph.PaketID = p.ID','LEFT');   
		$this->db->join('user u1','u1.ID = ph.Tujuan','LEFT');   
		$this->db->join('departemen d1','d1.ID = u1.DeptID','LEFT'); 
		$this->db->join('lokasi l1','l1.ID = u1.LokasiID','LEFT'); 
		$this->db->join('user u2','u2.ID = ph.Pengirim','LEFT');   
		$this->db->join('departemen d2','d2.ID = u2.DeptID','LEFT');      
		$this->db->join('lokasi l2','l2.ID = u2.LokasiID','LEFT');   						  
        $this->db->where('p.Active <','2');
		$this->db->where('ph.Active <','2');				
		$this->db->where('p.ID',$header['PaketID']);
		$this->db->where('ph.ID >',$id);		
		$this->db->order_by('ph.TglKirim','ASC');
		$this->db->limit(1);	
		$query = $this->db->get();
		
        if ($query->num_rows()==0){
            return false;
        }else{
            $data = $query->row_array();			
			                              
            return $data;         
        }
    }	
}