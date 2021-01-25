<?php
class mlist_ongoing extends CI_Model {

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
	
	function receive($data) {
		for ($i=0;$i<count($data);$i++)
		{					
			$arr = array(
				'Status' => 'RECEIVED',
				'TglTerima' => date("Y-m-d H:i:s"),
				'Penerima' => $this->session->userdata('id'),	
			);
			$this->db->where('ID', $data[$i]);
			$this->db->update('paket_history', $arr);				
		
			$arr = array(
				'Status' => 'RECEIVED',
				'TglTerima' => date("Y-m-d H:i:s"),
				'Penerima' => $this->session->userdata('id'),	
			);
			$this->db->where('PaketHistoryID', $data[$i]);
			$this->db->where('Active <', '2');			
			$this->db->update('dokumen_history', $arr);
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
	
	function getData(){
        $this->db->select('ph.ID, p.No, DATE_FORMAT(ph.TglKirim,"%d-%m-%Y") Tanggal, u1.Nama as FinalStop, u2.Nama as Pengirim, u3.Nama as Dari, k.Nama Kurir, p.Keterangan, u4.Nama NextStop');        
		$this->db->from('paket p');
        $this->db->join('paket_history ph','ph.PaketID = p.ID','LEFT');
		$this->db->join('user u1','u1.ID = p.TujuanAkhir','LEFT');
        $this->db->join('user u2','u2.ID = ph.Pengirim','LEFT');	
		$this->db->join('user u3','u3.ID = p.Pengirim','LEFT');		
		$this->db->join('user u4','u4.ID = ph.Tujuan','LEFT');				
        $this->db->join('kurir k','k.ID = ph.KurirID','LEFT');
        $this->db->where('p.Active <','2');	
		$this->db->where('ph.Active <','2');	
		$this->db->where('u4.DeptID',$this->session->userdata('deptid'));
		$this->db->where('ph.Status','PROGRESS');
		$this->db->where('p.Status','PROGRESS');
		$this->db->order_by('ph.TglKirim','ASC');
        $query = $this->db->get();
        //$query = $query->result_array();  
        return $query;
    } 
	
	function getSumSellin(){
        $salesofficeid = $this->session->userdata('salesofficeid');
        
        $this->db->select('sum(s.amount) as total');        
        $this->db->from('sellin s');
        if($salesofficeid != 0){
            $this->db->where('s.salesofficeid',$this->session->userdata('salesofficeid'));
        }	
		$this->db->where('s.active',0);
        $query = $this->db->get()->result_array();
        //$query = $query->result_array();  
        return $query;
    } 

    function getCountData(){
        $salesofficeid = $this->session->userdata('salesofficeid');
        
        $this->db->select('s.*');        
        $this->db->from('sellin s');
        if($salesofficeid != 0){
            $this->db->where('s.salesofficeid',$this->session->userdata('salesofficeid'));
        }	
		$this->db->where('s.active',0);
        $query = $this->db->get();
        //$query = $query->result_array();  
        return $query->num_rows();
    } 
}