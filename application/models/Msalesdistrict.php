<?php
class msalesdistrict extends CI_Model {

	function getData($arr){                
        $this->db->select('a.id,b.id as salesgroupid,c.id as salesofficeid,d.id as regionid,d.name as region_nama,c.name as slsof_nama,b.name as slsgr_nama,a.code,a.name ');  
        $this->db->from('sales_district a');
		$this->db->join('sales_group b','a.salesgroupid = b.id','LEFT');
		$this->db->join('sales_office c','b.salesofficeid = c.id','LEFT');
		$this->db->join('region d','c.regionid = d.id','LEFT');	
        $this->db->where('a.active','0');
        if ($arr[0] <> "-" && $arr[0] <> "") //regionid
        {
            $this->db->where('salesgroupid',$arr[0]); 
        }
        if ($arr[1] <> "-" && $arr[1] <> "") //salesofficeid
        {
            $this->db->where('salesofficeid',$arr[1]);    
        }           
        if ($arr[2] <> "-" && $arr[2] <> "") //salesmanid
        {
            $this->db->where('regionid',$arr[2]);   
        }
		$this->db->order_by('a.name','ASC');
        $query = $this->db->get();    
        return $query;
    } 
    function getDetail($id){
        $this->db->select('a.id,b.id as salesgroupid,c.id as salesofficeid,d.id as regionid,d.name as region_nama,c.name as slsof_nama,b.name as slsgr_nama,a.code,a.name ');  
        $this->db->from('sales_district a');
        $this->db->join('sales_group b','a.salesgroupid = b.id','LEFT');
        $this->db->join('sales_office c','b.salesofficeid = c.id','LEFT');
        $this->db->join('region d','c.regionid = d.id','LEFT'); 
        $this->db->where('a.active','0');
        $this->db->where('a.id',$id); 
        $this->db->order_by('a.name','ASC');
        $query = $this->db->get();
            
        if ($query->num_rows()==0){
            return false;
        }else{
            $data['header'] = $query->row_array();                          
            return $data;         
        }
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
    function getSalesGroup(){
        $this->db->select('r.id, r.name');        
        $this->db->from('sales_group r');       
        $this->db->where('r.active','0');   
        if ($this->session->userdata('salesgroupid') <> '0')
        {
            $this->db->where('r.id in ('.$this->session->userdata('salesgroupid').')',NULL,FALSE);
        }
        $this->db->order_by('r.name','ASC');        
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    
    }
    function save($data) {
        $data = json_decode($data,true);
        
        $header = $data["header"];
        $header = json_decode($header,true);

        if ($header['id'] > 0) //edit
        {
            $headerdata = array(
                "salesgroupid"  => $header["salesgroup"],
                "code"      => $header["code"],
                "name"      => $header["name"],
                "active"    => '0',   
                "updatedby" => $this->session->userdata('id'),
                "updatedon" => date("Y-m-d H:i:s")                          
            );
            
            $this->db->where('id', $header['id']);
            $this->db->update('sales_district', $headerdata);   
            
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
                "salesgroupid"  => $header["salesgroup"],
                "code"      => $header["code"],
                "name"      => $header["name"],
                "active"    => '0',
                "createdby" => $this->session->userdata('id'),
                "createdon" => date("Y-m-d H:i:s")
            );

            $this->db->insert('sales_district', $headerdata);

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
    function delete_salesdistrict($data) {
                        
        $arr = array(
            'active' => '2',
            'updatedon' => date("Y-m-d H:i:s"),
            'updatedby' => $this->session->userdata('id'),  
        );
        $this->db->where('id', $data);
        $this->db->update('sales_district', $arr);              
        
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