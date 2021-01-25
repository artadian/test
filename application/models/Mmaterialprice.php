<?php
class mmaterialprice extends CI_Model {

	function getData($arr){				
        $this->db->select('mp.materialid as material, m.name as material_desc, mp.priceid as price, mp.value, mp.validfrom, mp.validto ');        
		$this->db->from('material_price mp');
		$this->db->join('material m','m.id = mp.materialid','LEFT');
		$this->db->join('price p','p.id = mp.priceid','LEFT');
        $this->db->where('mp.active','0');	
        if ($arr[0] <> "-" && $arr[0] <> "") //price
		{
			$this->db->where('p.id',$arr[0]);	
		}
		$this->db->order_by('mp.id','ASC');
        $query = $this->db->get();    
        return $query;
    }  
}