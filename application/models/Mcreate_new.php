<?php
class mcreate_new extends CI_Model {

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

	function getCourier(){
        $this->db->select('k.ID');
        $this->db->select('IFNULL(CONCAT(k.Nama, " - ", l.Nama),k.Nama) as Nama');		
        $this->db->from('kurir k');
        $this->db->join('lokasi l','k.Lokasi = l.ID','LEFT');
        $this->db->where('k.Active <','2');		
		$this->db->order_by('k.Nama','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function getUserStop(){
        $this->db->select('u.ID');
        $this->db->select('CONCAT(u.Nama," - ",d.Nama) as Nama');		
        $this->db->from('user u');
        $this->db->join('departemen d','d.ID = u.DeptID','LEFT');
        $this->db->where('u.Active <','2');
		//$this->db->where('u.ID <>',$this->session->userdata('id'));
		$this->db->order_by('u.Nama','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function getUserRoute($route){    
		if ($route <> '')
		{
			$arrRoute = explode(",",$route);    
			$str = "case u.ID ";
			for ($i=0;$i<count($arrRoute);$i++)	
			{
				$rt = substr($arrRoute[$i],0,strlen($arrRoute[$i])-1);
				$str .= "when ".$rt." then ".($i+1)." ";
			}
			$str .= "else ".count($arrRoute)." end";
		}
		else
		{
			$str = "u.Nama";
		}
		
		/*$this->db->select('u.ID, CONCAT(u.Nama," - ",d.Nama) as Nama
					from user u
					left join departemen d on d.ID = u.DeptID
					where u.Active < 2
					and u.ID <> '.$this->session->userdata('id').'
					order by '.$str);*/
					
		$this->db->select('u.ID, CONCAT(u.Nama," - ",d.Nama) as Nama
					from user u
					left join departemen d on d.ID = u.DeptID
					where u.Active < 2					
					order by '.$str);
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function getDocument(){
        $this->db->select('d.No as ID');
        $this->db->select('CONCAT(d.No," - ",d.Deskripsi) as Nama');		
        $this->db->from('dokumen d');        
		$this->db->join('dokumen_history dh','d.No = dh.NoDokumen and dh.PaketID = d.PaketID','LEFT');
		$this->db->where('d.Active <','2');		
		$this->db->where('dh.Active <','2');
		$this->db->where('dh.Tujuan',$this->session->userdata('id'));
		$this->db->where('dh.Status','STOP');		
		$this->db->order_by('d.No','ASC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
	
	function send($data) {
		$data = json_decode($data,true);
		//print_r($data);
		$detail = $data["detail"];
		$detail = json_decode($detail,true);
		//print_r(count($data["detail"])); 
		$header = $data["header"];
		$header = json_decode($header,true);
		//print_r($header["finalStop"]);
		//print_r($detail[0]["typeid"]); 
		if ($header['id'] > 0) //edit
		{
			$no = $header['no'];			
			
			$headerdata = array(						
						"Tanggal" => date("Y-m-d"),
						"TujuanAkhir" => $header["finalStop"],
						"TujuanBerikut" => $header["nextStop"],
						"Keterangan" => $header["notes"],
						"KurirID" => $header["courier"],
						"Status" => 'PROGRESS',
						"Pengirim" => $this->session->userdata('id'),
						"Route" => $header['route'],
						"Confidential" => $header["confidential"],						
						"Active" => 0,
						"RecUser" => $this->session->userdata('id'),
						"RecDate" => date("Y-m-d H:i:s")
			);
			
			$this->db->where('ID', $header['id']);
			$this->db->update('paket', $headerdata);		
								
			$headerdata = array(
						"PaketID" => $header['id'],
						"TglKirim" => date("Y-m-d H:i:s"),
						"Pengirim" => $this->session->userdata('id'),
						"Tujuan" => $header["nextStop"],
						"KurirID" => $header["courier"],
						"Status" => 'PROGRESS',
						"Route" => $header['route'],
						"Active" => 0,
						"RecUser" => $this->session->userdata('id'),
						"RecDate" => date("Y-m-d H:i:s")
			);
			
			$this->db->insert('paket_history', $headerdata);
			$pakethistoryid = $this->db->insert_id();
			
			$this->db->where('PaketID', $header['id']);
			$this->db->delete('dokumen');
			
			$counter = 1;
			foreach ($detail as $row) {
				if ($row['no'] == '-')
				{
					$nodok = $no.'.'.str_pad($counter,2,'0',STR_PAD_LEFT);
					$counter += 1;
				}
				else
				{
					$nodok = $row["no"];
				}
				$detaildata = array(
						"PaketID" => $header['id'],
						"No" => $nodok,
						"Revisi" => $row["revisi"],
						"Jenis" => $row["typeid"],
						"Deskripsi" => $row["desc"],
						"Keterangan" => $row["notes"],
						"Jumlah" => $row["qty"],
						"Nominal" => $row["amount"],
						"Active" => 0					
				);
				$this->db->insert('dokumen', $detaildata);	
				$dokumenid = $this->db->insert_id();	
				
				$detaildata = array(
						"NoDokumen" => $nodok,
						"PaketID" => $header['id'],
						"PaketHistoryID" => $pakethistoryid,
						"TglKirim" => date("Y-m-d H:i:s"),
						"Pengirim" => $this->session->userdata('id'),
						"Tujuan" => $header["nextStop"],
						"KurirID" => $header["courier"],
						"Status" => 'PROGRESS',					
						"Active" => 0,
						"RecUser" => $this->session->userdata('id'),
						"RecDate" => date("Y-m-d H:i:s")
				);			
				$this->db->insert('dokumen_history', $detaildata);
				
				if ($row['no'] <> '-')
				{
					$arr = array(
						'Status' => 'COMPLETE',			
					);
									
					$this->db->where('NoDokumen', $row['no']);
					$this->db->where('Status', 'STOP');
					$this->db->update('dokumen_history', $arr);
				}
			}
		}
		else //new
		{
			$this->db->select('p.No');       
			$this->db->from('paket p');        
			$this->db->where('p.Active','< 2');
			$this->db->like('p.No', date("Ym"), 'after');
			$this->db->order_by('p.No','DESC');
			$this->db->limit(1, 0);
			$query = $this->db->get();
			$jum = $query->num_rows();
			$row = $query->row();
			if ($jum > 0)
			{
				$no = $row->No + 1;
			}
			else
			{
				$no = date("Ym").'0001';
			}
			
			
			$headerdata = array(
						"No" => $no,
						"Tanggal" => date("Y-m-d"),
						"TujuanAkhir" => $header["finalStop"],
						"TujuanBerikut" => $header["nextStop"],
						"Keterangan" => $header["notes"],
						"KurirID" => $header["courier"],
						"Status" => 'PROGRESS',
						"Pengirim" => $this->session->userdata('id'),
						"Route" => $header['route'],
						"Confidential" => $header["confidential"],						
						"Active" => 0,
						"RecUser" => $this->session->userdata('id'),
						"RecDate" => date("Y-m-d H:i:s")
			);
			
			$this->db->insert('paket', $headerdata);
			$paketid = $this->db->insert_id();
			
			$headerdata = array(
						"PaketID" => $paketid,
						"TglKirim" => date("Y-m-d H:i:s"),
						"Pengirim" => $this->session->userdata('id'),
						"Tujuan" => $header["nextStop"],
						"KurirID" => $header["courier"],
						"Status" => 'PROGRESS',
						"Route" => $header['route'],
						"Active" => 0,
						"RecUser" => $this->session->userdata('id'),
						"RecDate" => date("Y-m-d H:i:s")
			);
			
			$this->db->insert('paket_history', $headerdata);
			$pakethistoryid = $this->db->insert_id();
			
			$counter = 1;
			foreach ($detail as $row) {
				if ($row['no'] == '-')
				{
					$nodok = $no.'.'.str_pad($counter,2,'0',STR_PAD_LEFT);
					$counter += 1;
				}
				else
				{
					$nodok = $row["no"];
				}
				$detaildata = array(
						"PaketID" => $paketid,
						"No" => $nodok,
						"Revisi" => $row["revisi"],
						"Jenis" => $row["typeid"],
						"Deskripsi" => $row["desc"],
						"Keterangan" => $row["notes"],
						"Jumlah" => $row["qty"],
						"Nominal" => $row["amount"],
						"Active" => 0					
				);
				$this->db->insert('dokumen', $detaildata);	
				$dokumenid = $this->db->insert_id();	
				
				$detaildata = array(
						"NoDokumen" => $nodok,
						"PaketID" => $paketid,
						"PaketHistoryID" => $pakethistoryid,
						"TglKirim" => date("Y-m-d H:i:s"),
						"Pengirim" => $this->session->userdata('id'),
						"Tujuan" => $header["nextStop"],
						"KurirID" => $header["courier"],
						"Status" => 'PROGRESS',					
						"Active" => 0,
						"RecUser" => $this->session->userdata('id'),
						"RecDate" => date("Y-m-d H:i:s")
				);			
				$this->db->insert('dokumen_history', $detaildata);
				
				if ($row['no'] <> '-')
				{
					$arr = array(
						'Status' => 'COMPLETE',			
					);
									
					$this->db->where('NoDokumen', $row['no']);
					$this->db->where('Status', 'STOP');
					$this->db->update('dokumen_history', $arr);
				}
			}	
		}
				
		if ($this->db->trans_status() === TRUE){	
			$ret["status"] = 1;								
			$ret['paketno'] = $no;						
			$this->db->trans_commit();
		}else{
			$ret["status"] = 0;
			$this->db->trans_rollback();						
		}
		
		return $ret;
	}
	
	function getNoDocument($data) {
				
		$this->db->select('d.Revisi, d.Jenis, d.Deskripsi, d.Keterangan, d.Jumlah, d.Nominal, j.Nama JenisNama, IF(p.Pengirim = '.$this->session->userdata('id').',(d.Revisi+1),d.Revisi) Revisi');       
        $this->db->from('dokumen d');     
		$this->db->join('dokumen_history dh','d.No = dh.NoDokumen and dh.PaketID = d.PaketID','LEFT');
		$this->db->join('jenis j','j.ID = d.Jenis','LEFT');   
		$this->db->join('paket p','p.ID = d.PaketID','LEFT');  		
        $this->db->where('d.Active','< 2');
		$this->db->where('p.Active','< 2');
		$this->db->where('d.No',$data);	
		$this->db->where('dh.Active <','2');
		$this->db->where('dh.Tujuan',$this->session->userdata('id'));
		$this->db->where('dh.Status','STOP');		
		$this->db->order_by('p.Tanggal','DESC');
		$this->db->limit(1, 0);	
        $query = $this->db->get();
		$query = $query->result_array();  
		return $query;
	}
	
	function getDataStop(){
        $this->db->select('d.No, DATE_FORMAT(dh.TglTerima,"%d-%m-%Y") TglTerima, p.No NoPaket, u.Nama Dari, j.Nama Jenis, d.Deskripsi, d.Jumlah, d.Nominal, j.ID JenisID, d.Keterangan, IF(p.Pengirim = '.$this->session->userdata('id').',(d.Revisi+1),d.Revisi) Revisi');
        $this->db->from('dokumen d');        
		$this->db->join('dokumen_history dh','d.No = dh.NoDokumen and dh.PaketID = d.PaketID','LEFT');
		$this->db->join('paket p','p.ID = d.PaketID','LEFT');
		$this->db->join('user u','u.ID = p.Pengirim','LEFT');
		$this->db->join('jenis j','j.ID = d.Jenis','LEFT');
		$this->db->where('d.Active <','2');		
		$this->db->where('p.Active <','2');	
		$this->db->where('u.Active <','2');	
		$this->db->where('dh.Active <','2');
		$this->db->where('dh.Tujuan',$this->session->userdata('id'));
		$this->db->where('dh.Status','STOP');		
		$this->db->order_by('d.No','ASC');
        $query = $this->db->get();
        //$query = $query->result_array();  
        return $query;
    } 
	
	function draft($data) {
		$data = json_decode($data,true);
		//print_r($data);
		$detail = $data["detail"];
		$detail = json_decode($detail,true);
		//print_r(count($data["detail"])); 
		$header = $data["header"];
		$header = json_decode($header,true);
		//print_r($header["route"]); exit;
		//print_r($detail[0]["typeid"]); 	
		if ($header['id'] > 0) //edit
		{
			$headerdata = array(						
						"Tanggal" => date("Y-m-d"),
						"TujuanAkhir" => $header["finalStop"],
						"TujuanBerikut" => $header["nextStop"],
						"Keterangan" => $header["notes"],
						"KurirID" => $header["courier"],
						"Status" => 'DRAFT',
						"Pengirim" => $this->session->userdata('id'),
						"Route" => $header['route'],
						"Confidential" => $header["confidential"],						
						"Active" => 0,
						"RecUser" => $this->session->userdata('id'),
						"RecDate" => date("Y-m-d H:i:s")
			);
			$this->db->where('ID', $header['id']);
			$this->db->update('paket', $headerdata);		
			
			$this->db->where('PaketID', $header['id']);
			$this->db->delete('dokumen');
			
			$no = $header['no'];		
			$counter = 1;
			foreach ($detail as $row) {
				if ($row['no'] == '-')
				{
					$nodok = $no.'.'.str_pad($counter,2,'0',STR_PAD_LEFT);
					$counter += 1;
				}
				else
				{
					$nodok = $row["no"];
				}
				$detaildata = array(
						"PaketID" => $header['id'],
						"No" => $nodok,
						"Revisi" => $row["revisi"],
						"Jenis" => $row["typeid"],
						"Deskripsi" => $row["desc"],
						"Keterangan" => $row["notes"],
						"Jumlah" => $row["qty"],
						"Nominal" => $row["amount"],
						"Active" => 0					
				);
				$this->db->insert('dokumen', $detaildata);				
				
			}
		}
		else //new 
		{
			$this->db->select('p.No');       
			$this->db->from('paket p');        
			$this->db->where('p.Active','< 2');
			$this->db->like('p.No', date("Ym"), 'after');
			$this->db->order_by('p.No','DESC');
			$this->db->limit(1, 0);
			$query = $this->db->get();
			$jum = $query->num_rows();
			$row = $query->row();
			if ($jum > 0)
			{
				$no = $row->No + 1;
			}
			else
			{
				$no = date("Ym").'0001';
			}
			
			
			$headerdata = array(
						"No" => $no,
						"Tanggal" => date("Y-m-d"),
						"TujuanAkhir" => $header["finalStop"],
						"TujuanBerikut" => $header["nextStop"],
						"Keterangan" => $header["notes"],
						"KurirID" => $header["courier"],
						"Status" => 'DRAFT',
						"Pengirim" => $this->session->userdata('id'),
						"Route" => $header['route'],
						"Confidential" => $header["confidential"],						
						"Active" => 0,
						"RecUser" => $this->session->userdata('id'),
						"RecDate" => date("Y-m-d H:i:s")
			);
			
			$this->db->insert('paket', $headerdata);
			$paketid = $this->db->insert_id();
							
			$counter = 1;
			foreach ($detail as $row) {
				if ($row['no'] == '-')
				{
					$nodok = $no.'.'.str_pad($counter,2,'0',STR_PAD_LEFT);
					$counter += 1;
				}
				else
				{
					$nodok = $row["no"];
				}
				$detaildata = array(
						"PaketID" => $paketid,
						"No" => $nodok,
						"Revisi" => $row["revisi"],
						"Jenis" => $row["typeid"],
						"Deskripsi" => $row["desc"],
						"Keterangan" => $row["notes"],
						"Jumlah" => $row["qty"],
						"Nominal" => $row["amount"],
						"Active" => 0					
				);
				$this->db->insert('dokumen', $detaildata);						
				
			}
		}
				
		if ($this->db->trans_status() === TRUE){	
			$ret["status"] = 1;								
			$ret['paketno'] = $no;						
			$this->db->trans_commit();
		}else{
			$ret["status"] = 0;
			$this->db->trans_rollback();						
		}
		
		return $ret;
	}
	
	function getDetail($id){        
		$this->db->select('p.ID, p.No, DATE_FORMAT(p.Tanggal,"%d-%m-%Y") Tanggal, p.TujuanAkhir, p.TujuanBerikut, p.KurirID, p.Keterangan, p.Confidential, p.Route, getNamaRoute(p.Route) NamaRoute');        
		$this->db->from('paket p');        					  
        $this->db->where('p.Active','< 2');		
		$this->db->where('p.ID',$id);		
		$query = $this->db->get();
		
        if ($query->num_rows()==0){
            return false;
        }else{
            $data['header'] = $query->row_array();
			
			$paketid = $data['header']['ID'];
			$paketno = $data['header']['No'];
			
			$this->db->select('d.ID, if(SUBSTR(d.No,1,10)="'.$paketno.'","-",d.No) No, d.Revisi, j.Nama Jenis, d.Deskripsi, d.Keterangan, d.Jumlah, d.Nominal, j.ID JenisID');        
			$this->db->from('dokumen d');        			
			$this->db->join('jenis j','j.ID = d.Jenis','LEFT');   			
			$this->db->where('d.Active','< 2');		
			$this->db->where('d.PaketID',$paketid);		
			$query = $this->db->get();
			
			$data['detail'] = $query->result_array();
                              
            return $data;         
        }
    }
	
	function getTemplate($data) {
		$data = json_decode($data,true);
		
		$header = $data["header"];
		$header = json_decode($header,true);
		
		$this->db->select("td.Jenis, td.Deskripsi, td.Keterangan, td.Jumlah, td.Nominal, j.Nama JenisNama");
        $this->db->from("template_detail td");
		$this->db->join('jenis j','j.ID = td.Jenis','LEFT');		
        $this->db->where('td.TemplateID', $header['templateid']);
		$this->db->where('td.Active <', '2');		
        $query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			$history['header'] = $query->result_array();	
			$history['status'] = 'ok';
		}
		else
		{
			$history['status'] = "no";
		}
				
		return $history;
	}	
	
	function getDefaultRoute(){   		
		$this->db->select('u.Route, getNamaRoute(u.Route) NamaRoute');        
		$this->db->from('user u');        					  
		$this->db->where('u.Active','< 2');		
		$this->db->where('u.ID',$this->session->userdata('id'));	    		
				
		$query = $this->db->get();
		
		if ($query->num_rows()==0){
			return false;
		}else{				
			$data = $query->row_array();							  
			return $data;         
		}	
		
		
    }

}