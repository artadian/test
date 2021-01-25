<?php
class msend_package extends CI_Model {

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
		$this->db->where('u.ID <>',$this->session->userdata('id'));
		$this->db->order_by('u.Nama','ASC');
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 

	function getData(){
        $this->db->select('ph.ID, p.No, DATE_FORMAT(ph.TglKirim,"%d-%m-%Y") Tanggal, u1.Nama as FinalStop, u2.Nama as Pengirim, u3.Nama as Dari, p.Keterangan');        
		$this->db->from('paket p');
        $this->db->join('paket_history ph','ph.PaketID = p.ID','LEFT');
		$this->db->join('user u1','u1.ID = p.TujuanAkhir','LEFT');
        $this->db->join('user u2','u2.ID = ph.Pengirim','LEFT');	
		$this->db->join('user u3','u3.ID = p.Pengirim','LEFT');				
        $this->db->where('p.Active <','2');
		$this->db->where('ph.Active','< 2');	
		$this->db->where('ph.Tujuan',$this->session->userdata('id'));
		//$this->db->where('p.TujuanAkhir <> ph.Tujuan',NULL,FALSE);
		$this->db->where('(select count(ID) from paket_history where PaketID = p.ID and Active < 2) < getJumlahRoute(p.Route)',NULL,FALSE);
		$this->db->where('ph.Status','RECEIVED');
		$this->db->where('p.Status','PROGRESS');
		$this->db->order_by('ph.TglKirim','ASC');
        $query = $this->db->get();
        //$query = $query->result_array();  
        return $query;
    } 
	
	function getCountData(){
        $this->db->select('ph.ID, p.No, DATE_FORMAT(ph.TglKirim,"%d-%m-%Y") Tanggal, u1.Nama as FinalStop, u2.Nama as Pengirim, u3.Nama as Dari, p.Keterangan');        
		$this->db->from('paket p');
        $this->db->join('paket_history ph','ph.PaketID = p.ID','LEFT');
		$this->db->join('user u1','u1.ID = p.TujuanAkhir','LEFT');
        $this->db->join('user u2','u2.ID = ph.Pengirim','LEFT');	
		$this->db->join('user u3','u3.ID = p.Pengirim','LEFT');				
        $this->db->where('p.Active <','2');
		$this->db->where('ph.Active','< 2');	
		$this->db->where('ph.Tujuan',$this->session->userdata('id'));
		//$this->db->where('p.TujuanAkhir <> ph.Tujuan',NULL,FALSE);
		$this->db->where('(select count(ID) from paket_history where PaketID = p.ID and Active < 2) < getJumlahRoute(p.Route)',NULL,FALSE);
		$this->db->where('ph.Status','RECEIVED');
		$this->db->where('p.Status','PROGRESS');
		$this->db->order_by('ph.TglKirim','ASC');
        $query = $this->db->get();
        //$query = $query->result_array();  
        return $query->num_rows();
    } 
	
	function getDetail($id){        
		$this->db->select('ph.ID, p.ID PaketID, p.No, DATE_FORMAT(p.Tanggal,"%d-%m-%Y") Tanggal, CONCAT(u1.Nama," - ",d1.Nama) as FinalStop, CONCAT(u2.Nama," - ",d2.Nama) as Dari, p.Keterangan, p.Confidential, p.Route, getNamaRoute(p.Route) NamaRoute, getNextRoute(p.ID) NextStop, getRouteNow(p.ID) RouteNow, p.TujuanAkhir FinalStopID');        
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
			
			$this->db->select('d.ID, d.No, d.Revisi, j.Nama Jenis, d.Deskripsi, d.Keterangan, d.Jumlah, d.Nominal, d.Jenis JenisID');        
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
	
	function send($data) {
		$data = json_decode($data,true);
		
		$header = $data["header"];
		$header = json_decode($header,true);
		
		$detail = $data["detail"];
		$detail = json_decode($detail,true);
								
		$arr = array(
			'Status' => 'COMPLETE',			
		);
		$this->db->where('ID', $header['id']);
		$this->db->update('paket_history', $arr);
		
		$this->db->where('PaketHistoryID', $header['id']);
		$this->db->where('Active <', '2');
		$this->db->update('dokumen_history', $arr);
				
		if ($header['nextStopRoute'] != $header['nextStop'])
		{
			/*$arrRouteID = explode(',',$header['route']);				
			array_splice($arrRouteID, $header['routeNow']+1, 0, $header['nextStop']);	
			$route = implode(',',$arrRouteID);*/
			
			$arrRouteID = explode(',',$header['route']);	
			$idxRoute = array_search($header['nextStop'].'D',$arrRouteID); 			
			
			if ($idxRoute == "") //add new route
			{
				array_splice($arrRouteID, $header['routeNow']+1, 0, $header['nextStop'].'N');	
			}
			else //skip route
			{
				for ($j=($header['routeNow']+1);$j<$idxRoute;$j++)
				{					
					$rt = substr($arrRouteID[$j],0,strlen($arrRouteID[$j])-1);
					array_splice($arrRouteID, $j, 1, $rt.'S');
				}					
			}
			
			$route = implode(',',$arrRouteID);
			
			$arr = array(
				'Route' => $route,			
			);
			$this->db->where('ID', $header['paketid']);
			$this->db->update('paket', $arr);
		}
		else
		{
			$route = $header['route'];
		}
		
		$headerdata = array(
					"PaketID" => $header['paketid'],
					"TglKirim" => date("Y-m-d H:i:s"),
					"Pengirim" => $this->session->userdata('id'),
					"Tujuan" => $header["nextStop"],
					"KurirID" => $header["courier"],
					"Status" => 'PROGRESS',
					"Route" => $route,
					"Active" => 0,
					"RecUser" => $this->session->userdata('id'),
					"RecDate" => date("Y-m-d H:i:s")
		);
		
		$this->db->insert('paket_history', $headerdata);
		$pakethistoryid = $this->db->insert_id();
		
		for ($i=0;$i<count($detail);$i++)
		{
			$detaildata = array(
						"NoDokumen" => $detail[$i]['no'],
						"PaketID" => $header['paketid'],
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
	
	function stop($data) {
		$data = json_decode($data,true);
		
		$header = $data["header"];
		$header = json_decode($header,true);
			
		$arr = array(
			'Status' => 'STOP',			
		);
		$this->db->where('ID', $header['id']);
		$this->db->update('paket_history', $arr);
			
		$arr = array(
			'Status' => 'STOP',	
			'IsStop' => '1',			
		);	
		$this->db->where('PaketHistoryID', $header['id']);
		$this->db->where('Active <', '2');
		$this->db->update('dokumen_history', $arr);
		
		$arr = array(
			'Status' => 'STOP',		
			'TglSelesai' => date("Y-m-d H:i:s"),			
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
	
	function group_by($key, $data) {
		$result = array();
	
		foreach($data as $val) {
			if(array_key_exists($key, $val)){
				$result[$val[$key]][] = $val;
			}else{
				$result[""][] = $val;
			}
		}
	
		return $result;
	}

	function split($data) {
		$data = json_decode($data,true);
		
		$header = $data["header"];
		$header = json_decode($header,true);
		
		$detail = $data["detail"];
		$detail = json_decode($detail,true);
			
		//stop package	
		$arr = array(
			'Status' => 'STOP',			
		);
		$this->db->where('ID', $header['id']);
		$this->db->update('paket_history', $arr);
			
		$arr = array(
			'Status' => 'STOP',	
			'IsStop' => '1',			
		);	
		$this->db->where('PaketHistoryID', $header['id']);
		$this->db->where('Active <', '2');
		$this->db->update('dokumen_history', $arr);
		
		$arr = array(
			'Status' => 'STOP',		
			'TglSelesai' => date("Y-m-d H:i:s"),			
		);
		$this->db->where('ID', $header['paketid']);
		$this->db->update('paket', $arr);		
		
		//create new
		
		//print_r($arrNextStop); exit;
		//print_r(array_intersect_key($detail, $arrNextStop)); exit;
		
		/*$arr = array();

		foreach ($detail as $key => $item) {
		   $arr[$item['nextstop']][$key] = $item;
		}
		
		ksort($arr, SORT_NUMERIC);
		print_r($arr[8]); exit;*/
		$arrNextStop = array_values(array_unique(array_column($detail, 'nextstop')));
		$arrGroup = $this->group_by("nextstop", $detail);
		
		$arrNoPaket = '';
		for ($i=0;$i<count($arrNextStop);$i++)
		{
			$nextstop = $arrNextStop[$i];
			
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
			
			$arrNoPaket = $arrNoPaket.$no.', ';
			$arrRouteID = explode(',',$header['route']);	
			$idxRoute = array_search($nextstop.'D',$arrRouteID); 			
			
			if ($idxRoute == "" || $idxRoute <> ($header['routeNow']+1)) //add new route
			{
				array_splice($arrRouteID, 0, $header['routeNow']+1, $nextstop.'D');	
			}
			else if ($idxRoute == ($header['routeNow']+1)) //sama dengan next route awal
			{					
				unset($arrRouteID[$header['routeNow']]);		
			}
			
			$route = implode(',',$arrRouteID);
			
			$headerdata = array(
						"No" => $no,
						"Tanggal" => date("Y-m-d"),
						"TujuanAkhir" => $header["finalStop"],
						"TujuanBerikut" => $nextstop,
						"Keterangan" => $header["notes"],
						"KurirID" => $arrGroup[$nextstop][0]['courier'],
						"Status" => 'PROGRESS',
						"Pengirim" => $this->session->userdata('id'),
						"Route" => $route,
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
						"Tujuan" => $nextstop,
						"KurirID" => $arrGroup[$nextstop][0]['courier'],
						"Status" => 'PROGRESS',
						"Route" => $route,
						"Active" => 0,
						"RecUser" => $this->session->userdata('id'),
						"RecDate" => date("Y-m-d H:i:s")
			);
			
			$this->db->insert('paket_history', $headerdata);
			$pakethistoryid = $this->db->insert_id();
					
			foreach ($arrGroup[$nextstop] as $row) {				
				$detaildata = array(
						"PaketID" => $paketid,
						"No" => $row["no"],
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
						"NoDokumen" => $row["no"],
						"PaketID" => $paketid,
						"PaketHistoryID" => $pakethistoryid,
						"TglKirim" => date("Y-m-d H:i:s"),
						"Pengirim" => $this->session->userdata('id'),
						"Tujuan" => $nextstop,
						"KurirID" => $arrGroup[$nextstop][0]['courier'],
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
		
		if (substr($arrNoPaket,-2) == ', ')
		{
			$arrNoPaket = substr($arrNoPaket,0,strlen($arrNoPaket)-2);
		}
		
		if ($this->db->trans_status() === TRUE){	
			$ret["status"] = 1;			
			$ret["nopaket"] = $arrNoPaket;															
			$this->db->trans_commit();
		}else{
			$ret["status"] = 0;
			$this->db->trans_rollback();						
		}
		
		return $ret;			
		
	}
}