<?php
class mtracking_package extends CI_Model {

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
		
		$this->db->select("p.ID, p.No, CONCAT(u1.Nama,' - ',d1.Nama) Pengirim, CONCAT(u2.Nama,' - ',d2.Nama) FinalStop, p.Status");
        $this->db->from("paket p");
		$this->db->join('user u1','u1.ID = p.Pengirim','LEFT');
		$this->db->join('departemen d1','d1.ID = u1.DeptID','LEFT');
		$this->db->join('user u2','u2.ID = p.TujuanAkhir','LEFT');
		$this->db->join('departemen d2','d2.ID = u2.DeptID','LEFT');
        $this->db->where('p.No', $header['no']);
		$this->db->where('p.Active <', '2');
		$this->db->where('p.Status <>', 'DRAFT');
        $query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			$history['header'] = $query->row_array();
			$paketid = $history['header']['ID'];
			
			$this->db->select("DATE_FORMAT(ph.TglKirim,'%d-%m-%Y %H:%i') TglKirim, 
								IF(ph.TglTerima is NULL,'-',DATE_FORMAT(ph.TglTerima,'%d-%m-%Y %H:%i')) TglTerima,
								CONCAT(u1.Nama,' - ',d1.Nama) Tujuan, IF(u2.Nama is NULL,'-',CONCAT(u2.Nama,' - ',d2.Nama)) Penerima, 
								k.Nama Kurir, ph.Status ");
			$this->db->from("paket_history ph");
			$this->db->join('user u1','u1.ID = ph.Tujuan','LEFT');
			$this->db->join('departemen d1','d1.ID = u1.DeptID','LEFT');
			$this->db->join('user u2','u2.ID = ph.Penerima','LEFT');
			$this->db->join('departemen d2','d2.ID = u2.DeptID','LEFT');
			$this->db->join('kurir k','k.ID = ph.KurirID','LEFT');
			$this->db->where('ph.PaketID', $paketid);
			$this->db->where('ph.Active <', '2');		
			$this->db->order_by('ph.TglKirim','ASC');	
			$query = $this->db->get();
			$history['data'] = $query->result_array();
			$history['status'] = 'ok';
			
			if ($history['header']['Status'] == 'COMPLETE' || $history['header']['Status'] == 'STOP')
			{
				$this->db->select("timediff(
					(select TglSelesai
					from paket 
					where ID = '".$paketid."')
					,
					(select ph.TglKirim
					from paket_history ph
					where ph.PaketID = '".$paketid."'
					and ph.Active < 2
					order by ph.TglKirim
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