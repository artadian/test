<?php
class mposmdefault extends CI_Model {
    function getsalesoffice($regionid){
        $this->db->select('so.id, so.name');        
        $this->db->from('sales_office so');       
        $this->db->where('so.active','0');	
        $this->db->where('so.regionid',$regionid); 
		$this->db->order_by('so.name','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    function getform($arr){
    	$this->db->select('a.id,a.posmtypeid,b.id as posmid,b.lookupdesc');        
		$this->db->from('posm_default a');
        $this->db->join('lookup b','a.posmtypeid=b.lookupvalue','LEFT');
        $this->db->where('b.lookupkey','posm_type');   		       
        $this->db->where('a.active','0');	
		if ($arr[0] <> "-" && $arr[0] <> "") //salesofficeid
		{
			$this->db->where('a.salesofficeid',$arr[0]);	
		}
		if ($arr[1] <> "-" && $arr[1] <> "") //role
		{
			$this->db->where('a.userroleid',$arr[1]);	
		}
		$this->db->order_by('b.lookupdesc','ASC');
        $query = $this->db->get();
         $query = $query->result_array();  
        return $query;
    }
    function getposmtype(){
    	$this->db->select('lookupvalue as id,CONCAT(lookupvalue," - ",lookupdesc) name');        
        $this->db->from('lookup');       
        $this->db->where('active','0');	
        $this->db->where('lookupkey','posm_type');
		$this->db->order_by('CAST(lookupvalue AS INT)','ASC');		
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    function getRole(){
        $this->db->select('r.id, r.name');        
        $this->db->from('user_role r');       
        $this->db->where('r.active','0');
        $this->db->where('r.id in (1,2)'); 
        if ($this->session->userdata('regionid') <> '0')
        {
            $this->db->where('r.id in ('.$this->session->userdata('regionid').')',NULL,FALSE);
        }
        $this->db->order_by('r.name','ASC');        
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    } 
    function save($data) {
        $data = json_decode($data,true);
        
        $detail = $data["detail"];
        $detail = json_decode($detail,true);

        
        $header = $data["header"];
        $header = json_decode($header,true);
        
        
        if (count($data) > 0){
            $hapus_data = array(
                    "active" => "2",                                                                                                    
                    "updatedby" => $this->session->userdata('id'),
                    "updatedon" => date("Y-m-d H:i:s")                          
            );  
            $this->db->where('salesofficeid', $header['salesoffice']);
            $this->db->where('userroleid', $header['role']);
            $this->db->update('posm_default', $hapus_data); 

            //var_dump($data);exit();
            foreach ($detail as $row) { 
                if ($row['id'] == '0') //insert
                {
                    $detaildata = array(
                        "salesofficeid" => $header['salesoffice'],
                        "userroleid" => $header['role'],
                        "posmtypeid" => $row['posmtypeid'],
                        "active" => 0,
                        "createdby" => $this->session->userdata('id'),
                        "createdon" => date("Y-m-d H:i:s")                                  
                    );
                    $this->db->insert('posm_default', $detaildata);
                }
                else //update
                {
                    $detaildata = array(                            
                       "salesofficeid" => $header['salesoffice'],
                        "userroleid" => $header['role'],    
                        "posmtypeid" => $row['posmtypeid'],
                        "active" => 0,
                        "updatedby" => $this->session->userdata('id'),
                        "updatedon" => date("Y-m-d H:i:s")                                  
                    );

                    $this->db->where('id', $row['id']);
                    $this->db->update('posm_default', $detaildata);     
                } 
            }
            
            if ($this->db->trans_status() === TRUE){    
                $ret["status"] = 1;                                                                 
                $this->db->trans_commit();
            }else{
                $ret["status"] = 0;
                $this->db->trans_rollback();                        
            }
        }else{
            var_dump($data["detail"]);exit();
        }   
       
            
        return $ret;
    }

}