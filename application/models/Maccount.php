<?php
class maccount extends CI_Model {

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

	function change_password($data) {
		$data = json_decode($data,true);
		
		$header = $data["header"];
		$header = json_decode($header,true);
		
		$this->db->select('ID');       
		$this->db->from('user');        
		$this->db->where('Active <','2');
		$this->db->where('ID',$this->session->userdata('id'));
		$this->db->where('Password',md5($header['currentPassword']));
		$query = $this->db->get();
		$jum = $query->num_rows();		
		if ($jum > 0)
		{
			$arr = array(
				'Password' => md5($header['newPassword']),			
			);							
			$this->db->where('ID', $this->session->userdata('id'));			
			$this->db->update('user', $arr);
			
			if ($this->db->trans_status() === TRUE){	
				$ret["status"] = 1;													
				$this->db->trans_commit();
			}else{
				$ret["status"] = 0;
				$this->db->trans_rollback();						
			}
		}
		else
		{
			$ret["status"] = 0;
			$ret["message"] = 'Wrong current password';
		}		
		
		return $ret;
	}	

}