<?php
class mmaterial extends CI_Model {

	function getData(){				
        $this->db->select('m.id as material, m.name as material_desc , mg.id as material_group, mg.name as material_group_desc, m.bal, m.slof, m.pac ');        
		$this->db->from('material m');
		$this->db->join('material_group mg','mg.id = m.materialgroupid','LEFT');
        $this->db->where('m.active','0');	
		$this->db->order_by('m.name','ASC');
        $query = $this->db->get();    
        return $query;
    } 
}