<?php
class mregion extends CI_Model {

	function getData(){                
        $this->db->select('id,name');        
        $this->db->from('region');        
        $this->db->where('active','0'); 
        $this->db->order_by('name','ASC');
        $query = $this->db->get();    
        return $query;
    } 
    function getDetail($id){
        $this->db->select('id,name');        
        $this->db->from('region');  
        $this->db->where('id',$id); 
        $this->db->where('active','0');
        $this->db->order_by('name','ASC');
        $query = $this->db->get();
            
        if ($query->num_rows()==0){
            return false;
        }else{
            $data['header'] = $query->row_array();                          
            return $data;         
        }
    } 
   function save($data) {
        $data = json_decode($data,true);
        
        $header = $data["header"];
        $header = json_decode($header,true);

        if ($header['id'] > 0) //edit
        {
            $headerdata = array(
                "name"      => $header["name"],
                "active"    => '0',   
                "updatedby" => $this->session->userdata('id'),
                "updatedon" => date("Y-m-d H:i:s")                          
            );
            
            $this->db->where('id', $header['id']);
            $this->db->update('region', $headerdata);   
            
            if ($this->db->trans_status() === TRUE){    
                $ret["status"] = 1;                                                                 
                $this->db->trans_commit();
            }else{
                $ret["status"] = 0;
                $this->db->trans_rollback();                        
            }   
        }
        else //new
        {
            $headerdata = array(
                "name"      => $header["name"],
                "active"    => '0',
                "createdby" => $this->session->userdata('id'),
                "createdon" => date("Y-m-d H:i:s")
            );

            $this->db->insert('region', $headerdata);

            if ($this->db->trans_status() === TRUE){    
                $ret["status"] = 1; 
                $this->db->trans_commit();
            }else{
                $ret["status"] = 0;
                $this->db->trans_rollback();
            }
        }
        return $ret;
    }
	function delete_region($data) {
                        
        $arr = array(
            'active' => '2',
            'updatedon' => date("Y-m-d H:i:s"),
            'updatedby' => $this->session->userdata('id'),  
        );
        $this->db->where('id', $data);
        $this->db->update('region', $arr);              
        
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