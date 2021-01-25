<?php
class mmaterialgroup extends CI_Model {

	function getData(){				
        $this->db->select('id as code, name , description ');        
		$this->db->from('material_group');
        $this->db->where('active','0');	
		$this->db->order_by('name','ASC');
        $query = $this->db->get();    
        return $query;
    } 
}