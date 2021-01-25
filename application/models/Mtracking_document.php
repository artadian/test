<?php
class mtracking_document extends CI_Model {

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

	function search($data) {
		$data = json_decode($data,true);
		
		$header = $data["header"];
		$header = json_decode($header,true);
		
		$this->db->select("d.No");
        $this->db->from("dokumen d");		
        $this->db->where('d.No', $header['no']);
		$this->db->where('d.Active <', '2');		
        $query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			$history['header'] = $query->row_array();
			$no = $history['header']['No'];
			
			$this->db->select("DATE_FORMAT(dh.TglKirim,'%d-%m-%Y %H:%i') TglKirim, 
								IF(dh.TglTerima is NULL,'-',DATE_FORMAT(dh.TglTerima,'%d-%m-%Y %H:%i')) TglTerima,
								CONCAT(u1.Nama,' - ',d1.Nama) Tujuan, IF(u2.Nama is NULL,'-',CONCAT(u2.Nama,' - ',d2.Nama)) Penerima, 
								k.Nama Kurir, dh.Status, p.No PaketNo, CONCAT(u3.Nama,' - ',d3.Nama) Pengirim ");
			$this->db->from("dokumen_history dh");
			$this->db->join('paket p','p.ID = dh.PaketID','LEFT');
			$this->db->join('user u1','u1.ID = dh.Tujuan','LEFT');
			$this->db->join('departemen d1','d1.ID = u1.DeptID','LEFT');
			$this->db->join('user u2','u2.ID = dh.Penerima','LEFT');
			$this->db->join('departemen d2','d2.ID = u2.DeptID','LEFT');
			$this->db->join('user u3','u3.ID = dh.Pengirim','LEFT');
			$this->db->join('departemen d3','d3.ID = u3.DeptID','LEFT');
			$this->db->join('kurir k','k.ID = dh.KurirID','LEFT');
			$this->db->where('dh.NoDokumen', $no);
			$this->db->where('dh.Active <', '2');		
			$this->db->order_by('dh.TglKirim','ASC');	
			$query = $this->db->get();
			$history['data'] = $query->result_array();
			$jum = $query->num_rows();
			if ($history['data'][$jum-1]['Status'] == 'RECEIVED' || $history['data'][$jum-1]['Status'] == 'PROGRESS')
			{
				$statusdok = 'PROGRESS';				
			}
			else 
			{
				$statusdok = $history['data'][$jum-1]['Status'];				
			}
			$history['header']['Status'] = $statusdok;
			$history['header']['Pengirim'] = $history['data'][0]['Pengirim'];
			$history['status'] = 'ok';
			
			if ($statusdok == 'COMPLETE')
			{
				$this->db->select("timediff(
					(select p.TglSelesai
					from dokumen_history dh, paket p
					where dh.PaketID = p.ID
					and dh.NoDokumen = '".$header['no']."'
					and dh.Active < 2
					order by dh.TglKirim desc
					limit 1)
					,
					(select dh.TglKirim
					from dokumen_history dh, paket p
					where dh.PaketID = p.ID
					and dh.NoDokumen = '".$header['no']."'
					and dh.Active < 2
					order by dh.TglKirim
					limit 1)) durasi");				
				$query = $this->db->get();
				$durasi = $query->row_array();
				$arrDurasi = explode(':',$durasi['durasi']);
				$jam = (int) $arrDurasi[0];
				$menit = (int) $arrDurasi[1];
				$hari = 0;
				if ($jam > 24)
				{
					$hari = floor($jam / 24);
					$jam = $jam % 24;
				}
				$history['header']['Hari'] = $hari;
				$history['header']['Jam'] = $jam;
				$history['header']['Menit'] = $menit;
			}
			else
			{
				$history['header']['Hari'] = '0';
				$history['header']['Jam'] = '0';
				$history['header']['Menit'] = '0';
			}
			
		}
		else
		{
			$history['status'] = "no";
		}
				
		return $history;
	}	

}