<?php
class mmaterialdefault extends CI_Model {

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
        $this->db->select('a.id,a.materialid,b.name as material_name,b.materialgroupid,CONCAT(c.name," - ",c.description) as materialgroup_name ');  
        $this->db->from('material_default a');
        $this->db->join('material b','a.materialid=b.id','LEFT');
        $this->db->join('material_group c','b.materialgroupid=c.id','LEFT');
        $this->db->where('a.active','0');
        if ($arr[0] <> "-" && $arr[0] <> "") //salesofficeid
        {
            $this->db->where('a.salesofficeid',$arr[0]);    
        }
        $this->db->order_by('a.id','ASC');    
        $query = $this->db->get();   
        $query = $query->result_array(); 
        return $query;
    }
    function getmaterial(){
        $this->db->select('id,CONCAT(id," - ",name) name');        
        $this->db->from('material');       
        $this->db->where('active','0'); 
        $this->db->order_by('name','ASC');        
        $query = $this->db->get();
        $query = $query->result_array();  
        return $query;
    }
    function getMaterialGroup($materialid){     
        $this->db->select('CONCAT(b.name," - ",b.description) as materialgroup_name');        
        $this->db->from('material a'); 
        $this->db->join('material_group b','a.materialgroupid=b.id','LEFT');                     
        $this->db->where('a.active','0');
        $this->db->where('a.id',$materialid);  
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
            $this->db->update('material_default', $hapus_data); 


            foreach ($detail as $row) { 
                if ($row['id'] == '0') //insert
                {
                    $detaildata = array(
                        "salesofficeid" => $header['salesoffice'],
                        "materialid" => $row["materialid"],
                        "active" => 0,
                        "createdby" => $this->session->userdata('id'),
                        "createdon" => date("Y-m-d H:i:s")                                  
                    );
                    $this->db->insert('material_default', $detaildata);
                }
                else //update
                {
                    $detaildata = array(                            
                        "salesofficeid" => $header['salesoffice'],
                        "materialid" => $row["materialid"],
                        "active" => 0,
                        "updatedby" => $this->session->userdata('id'),
                        "updatedon" => date("Y-m-d H:i:s")                                  
                    );

                    $this->db->where('id', $row['id']);
                    $this->db->update('material_default', $detaildata);     
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
            var_dump($data["del"]);exit();
        }   
       
            
        return $ret;
    }
        
}