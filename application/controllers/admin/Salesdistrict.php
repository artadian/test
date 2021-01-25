<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salesdistrict extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('mstock');
        $this->load->model('msalesdistrict');			
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Sales District';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	
    public function list_salesdistrict(){
        $data = array();
        $data['page_title'] = 'Sales District';		
		
		$data['region'] = $this->mglobal->getRegion();
		array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));		
		
        $data['main_content'] = $this->load->view('admin/salesdistrict/v_salesdistrict', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }
     public function get_list_salesdistrict() 
    {       
       

        $draw   = intval($this->input->post("draw"));
        $start  = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));


        $salesgroupid       = $this->input->post("salesgroupid");
        $salesofficeid      = $this->input->post("salesofficeid");
        $regionid           = $this->input->post("regionid");
        $arr                = array($salesgroupid,$salesofficeid,$regionid);

        $list = $this->msalesdistrict->getData($arr);
        $data = array();
        //var_dump($list);exit();
        foreach($list->result() as $r) {

            $data[] = array(            
                $r->id,           
                $r->region_nama,
                $r->slsof_nama,
                $r->slsgr_nama,
                $r->code,
                $r->name
            );
        }

        $output = array(
                "draw" => $draw,
                "recordsTotal" => $list->num_rows(),
                "recordsFiltered" => $list->num_rows(),
                "data" => $data
        );
        echo json_encode($output);
        exit();
    }
    public function edit_salesdistrict($id){
        $data = array();
        $data["data"] = $this->msalesdistrict->getDetail($id);   
        if ($id == '0')
        {
            $data['page_title']     = 'Sales District - New';     
            $data['mode']           = 'new';
            
            $data['region']         = $this->mglobal->getRegion();
            array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Please select region ---'));
        }
        else
        {
            $data['page_title'] = 'Sales District - Edit';    
            $data['mode'] = 'edit'; 

            $data['region'] = $this->mglobal->getRegion();      
        
            $data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
            $data['salesgroup'] = $this->mglobal->getSalesGroup($data["data"]["header"]["salesofficeid"]);
        }   
        $data['main_content'] = $this->load->view('admin/salesdistrict/form_salesdistrict', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
    function getSalesOffice(){
        $regionid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getSalesOffice($regionid);
        array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Sales Office ---'));        
        echo json_encode($ret);             
    }
    function getSalesGroup(){
        $salesoffice = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getSalesGroup($salesoffice);
        array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Sales Group ---'));        
        echo json_encode($ret);  
    }
    public function save() {
        $data = $this->input->post("data");
        //var_dump($data);exit();
        $ret = $this->msalesdistrict->save($data);

        
        if ($ret["status"]==1){
            $res = $this->common_model->response("success","Data saved successfully");          
        }else{  
            $message = isset($ret["message"])?$ret["message"]:"Save Failed";
            $res = $this->common_model->response("error",$message);
        }
        
        echo json_encode($res);
    } 
    public function delete_salesdistrict() {
        $id = $this->input->post("id");
        
        $ret = $this->msalesdistrict->delete_salesdistrict($id);
        
        if ($ret["status"]==1){
            $res = $this->common_model->response("success","Data has been deleted");            
        }else{  
            $message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
            $res = $this->common_model->response("error",$message);
        }
        
        echo json_encode($res);
    }  
    public function view_salesdistrict($id){       
        $data = array();
        $data['page_title'] = 'Competitor - View';  
        $data['mode'] = 'view';         
               
        $data['region']       = $this->mglobal->getRegion();   
        $data['data']         = $this->msalesdistrict->getDetail($id);
        $data['salesoffice']  = $this->msalesdistrict->getSalesOffice(); 
        $data['salesgroup']   = $this->msalesdistrict->getSalesGroup(); 
        $data['main_content'] = $this->load->view('admin/salesdistrict/form_salesdistrict', $data, TRUE);
        $this->load->view('admin/index', $data);
    } 
	
}