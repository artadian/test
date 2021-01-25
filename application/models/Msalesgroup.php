<?php
class msalesgroup extends CI_Model {

	function getData($arr){                
        $this->db->select('a.id,c.id as regionid,a.salesofficeid,c.name as region_name,b.name as sales_office_name,a.code, a.name ');  
        $this->db->from('sales_group a');
		$this->db->join('sales_office b','a.salesofficeid = b.id','LEFT');
		$this->db->join('region c','b.regionid = c.id','LEFT');	
        $this->db->where('a.active','0');
        if ($arr[0] <> "-" && $arr[0] <> "") //regionid
        {
            $this->db->where('a.salesofficeid',$arr[0]); 
        }
        $this->db->order_by('b.name','ASC');
        $query = $this->db->get();    
        return $query;
    } 
    function getDetail($id){
        $this->db->select('a.id,c.id as regionid,a.salesofficeid,c.name as region_name,b.name as sales_office_name,a.code, a.name ');  
        $this->db->from('sales_group a');
        $this->db->join('sales_office b','a.salesofficeid = b.id','LEFT');
        $this->db->join('region c','b.regionid = c.id','LEFT'); 
        $this->db->where('a.active','0');
        $this->db->where('a.id',$id); 
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
                "code"              => $header["code"],
                "name"              => $header["name"],
                "salesofficeid"     => $header["salesoffice"],
                "active"    => '0',   
                "updatedby" => $this->session->userdata('id'),
                "updatedon" => date("Y-m-d H:i:s")                          
            );
            
            $this->db->where('id', $header['id']);
            $this->db->update('sales_group', $headerdata);   
            
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
                "code"              => $header["code"],
                "name"              => $header["name"],
                "salesofficeid"     => $header["salesoffice"],
                "active"    => '0',
                "createdby" => $this->session->userdata('id'),
                "createdon" => date("Y-m-d H:i:s")
            );

            $this->db->insert('sales_group', $headerdata);

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
    function delete_salesgroup($data) {
                        
        $arr = array(
            'active' => '2',
            'updatedon' => date("Y-m-d H:i:s"),
            'updatedby' => $this->session->userdata('id'),  
        );
        $this->db->where('id', $data);
        $this->db->update('sales_group', $arr);              
        
        if ($this->db->trans_status() === TRUE){    
            $ret["status"] = 1;                                                         
            $this->db->trans_commit();
        }else{
            $ret["status"] = 0;
            $this->db->trans_rollback();                        
        }
        
        return $ret;    
    }  
    function getSalesOffice(){
        $this->db->select('r.id, r.name');        
        $this->db->from('sales_office r');       
        $this->db->where('r.active','0');   
        if ($this->session->userdata('salesofficeid') <> '0')
        {
            $this->db->where('r.id in ('.$this->session->userdata('salesofficeid').')',NULL,FALSE);
        }
        $this->db->order_by('r.name','ASC');        
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    
    }

}