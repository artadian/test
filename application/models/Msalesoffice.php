<?php
class msalesoffice extends CI_Model {

	function getData($arr){                
        $this->db->select('a.id,b.name as region_nama,a.code,a.name,c.lookupdesc,a.type ');  
        $this->db->from('sales_office a');
		$this->db->join('region b','a.regionid = b.id','LEFT');
		$this->db->join('lookup c','a.type = c.lookupvalue','LEFT');
        $this->db->where('c.lookupkey','sales_office_type');	
        $this->db->where('a.active','0');
        if ($arr[0] <> "-" && $arr[0] <> "") //regionid
        {
            $this->db->where('a.regionid',$arr[0]); 
        }
		$this->db->order_by('b.name','ASC');
        $query = $this->db->get();    
        return $query;
    }  

    function getDetail($id){
        $this->db->select('a.id,b.id as regionid, b.name as region_nama,a.code,a.name,c.lookupdesc,a.type ');  
        $this->db->from('sales_office a');
        $this->db->join('region b','a.regionid = b.id','LEFT');
        $this->db->join('lookup c','a.type = c.lookupvalue','LEFT');
        $this->db->where('c.lookupkey','sales_office_type');  
        $this->db->where('a.id',$id);  
        $this->db->where('a.active','0');
        $this->db->order_by('b.name','ASC');
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
                "regionid"  => $header["region"],
                "code"      => $header["code"],
                "name"      => $header["name"],
                "type"      => $header["type"],
                "active"    => '0',   
                "updatedby" => $this->session->userdata('id'),
                "updatedon" => date("Y-m-d H:i:s")                          
            );
            
            $this->db->where('id', $header['id']);
            $this->db->update('sales_office', $headerdata);   
            
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
                "regionid"  => $header["region"],
                "code"      => $header["code"],
                "name"      => $header["name"],
                "type"      => $header["type"],
                "active"    => '0',
                "createdby" => $this->session->userdata('id'),
                "createdon" => date("Y-m-d H:i:s")
            );

            $this->db->insert('sales_office', $headerdata);

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
    function delete_salesoffice($data) {
                        
        $arr = array(
            'active' => '2',
            'updatedon' => date("Y-m-d H:i:s"),
            'updatedby' => $this->session->userdata('id'),  
        );
        $this->db->where('id', $data);
        $this->db->update('sales_office', $arr);              
        
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