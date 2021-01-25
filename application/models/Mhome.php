<?php
class mhome extends CI_Model {
	function getSumSellin(){
        $salesofficeid = $this->session->userdata('salesofficeid');
        
        $this->db->select('sum(s.amount) as total');        
        $this->db->from('sellin s');
        if($salesofficeid != 0){
            $this->db->where('s.salesofficeid',$this->session->userdata('salesofficeid'));
        }	
		$this->db->where('s.active',0);
        $query = $this->db->get()->result_array();
        //$query = $query->result_array();  
        return $query;
    } 

    function getCountData(){
        $salesofficeid = $this->session->userdata('salesofficeid');
        
        $this->db->select('s.*');        
        $this->db->from('sellin s');
        if($salesofficeid != 0){
            $this->db->where('s.salesofficeid',$this->session->userdata('salesofficeid'));
        }	
		$this->db->where('s.active',0);
        $query = $this->db->get();
        //$query = $query->result_array();  
        return $query->num_rows();
    } 
}