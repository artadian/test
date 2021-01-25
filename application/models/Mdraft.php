<?php
class mdraft extends CI_Model {

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
        $this->db->select('p.ID, p.No, DATE_FORMAT(p.Tanggal,"%d-%m-%Y") Tanggal, u1.Nama as FinalStop, u2.Nama as NextStop, p.Keterangan, k.Nama Kurir');        
		$this->db->from('paket p');        
		$this->db->join('user u1','u1.ID = p.TujuanAkhir','LEFT');
        $this->db->join('user u2','u2.ID = p.TujuanBerikut','LEFT');			
		$this->db->join('kurir k','k.ID = p.KurirID','LEFT');					
        $this->db->where('p.Active <','2');
		$this->db->where('p.Pengirim',$this->session->userdata('id'));		
		$this->db->where('p.Status','DRAFT');
		$this->db->order_by('p.Tanggal','DESC');
        $query = $this->db->get();
        //$query = $query->result_array();  
        return $query;
    } 
	
	function getDetail($id){        
		$this->db->select('p.ID, p.No, DATE_FORMAT(p.Tanggal,"%d-%m-%Y") Tanggal, CONCAT(u1.Nama," - ",d1.Nama) as FinalStop, IFNULL(CONCAT(k.Nama, " - ", l.Nama),k.Nama) as Kurir, p.Keterangan, p.Confidential, p.Route, getNamaRoute(p.Route) NamaRoute, CONCAT(u2.Nama," - ",d2.Nama) as Dari');        
		$this->db->from('paket p');        		
		$this->db->join('user u1','u1.ID = p.TujuanAkhir','LEFT');   
		$this->db->join('departemen d1','d1.ID = u1.DeptID','LEFT');        
		$this->db->join('kurir k','k.ID = p.KurirID','LEFT');		
		$this->db->join('lokasi l','l.ID = k.Lokasi','LEFT');	
		$this->db->join('user u2','u2.ID = p.Pengirim','LEFT');   
		$this->db->join('departemen d2','d2.ID = u2.DeptID','LEFT');  						  
        $this->db->where('p.Active','< 2');		
		$this->db->where('p.ID',$id);		
		$query = $this->db->get();
		
        if ($query->num_rows()==0){
            return false;
        }else{
            $data['header'] = $query->row_array();
			
			$paketid = $data['header']['ID'];
			
			$this->db->select('d.ID, d.No, d.Revisi, j.Nama Jenis, d.Deskripsi, d.Keterangan, d.Jumlah, d.Nominal');        
			$this->db->from('dokumen d');        			
			$this->db->join('jenis j','j.ID = d.Jenis','LEFT');   			
			$this->db->where('d.Active','< 2');		
			$this->db->where('d.PaketID',$paketid);		
			$query = $this->db->get();
			
			$data['detail'] = $query->result_array();
                              
            return $data;         
        }
    }	
	
	function getPrint($id){        
		$this->db->select('p.No, DATE_FORMAT(p.Tanggal,"%d-%m-%Y") Tanggal, CONCAT(u1.Nama," - ",d1.Nama," (",l1.Nama,")") as NextStop, CONCAT(u2.Nama," - ",d2.Nama," (",l2.Nama,")") as Pengirim');        
		$this->db->from('paket p');        				
		$this->db->join('user u1','u1.ID = p.TujuanBerikut','LEFT');   
		$this->db->join('departemen d1','d1.ID = u1.DeptID','LEFT'); 
		$this->db->join('lokasi l1','l1.ID = u1.LokasiID','LEFT'); 
		$this->db->join('user u2','u2.ID = p.Pengirim','LEFT');   
		$this->db->join('departemen d2','d2.ID = u2.DeptID','LEFT');      
		$this->db->join('lokasi l2','l2.ID = u2.LokasiID','LEFT');   						  
        $this->db->where('p.Active <','2');		
		$this->db->where('p.ID',$id);				
		$query = $this->db->get();
		
        if ($query->num_rows()==0){
            return false;
        }else{
            $data = $query->row_array();			
			                              
            return $data;         
        }
    }	
	
}