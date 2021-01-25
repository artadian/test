<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sob extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('msob');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_sob(){
        $data = array();
        $data['page_title'] = 'SOB';	
        $data['region'] = $this->mglobal->getRegion();
		array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));	

        $data['materialgroup'] = $this->mglobal->getMaterialGroup();
        array_unshift($data['materialgroup'],array('id'=>'-', 'name'=>'--- Select Material Group ---'));			
        $data['main_content'] = $this->load->view('admin/sob/v_sob', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

	public function get_list_sob() 
	{		
		$regionid = $this->input->post("regionid");	
		$salesofficeid = $this->input->post("salesofficeid");	
		$materialgroupid = $this->input->post("materialgroupid");	
		$arr = array($regionid, $salesofficeid, $materialgroupid);

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->msob->getData($arr);
        $data = array();
        foreach($list->result() as $r) {
        	$data[] = array(					
            	$r->id,			
                $r->salesoffice,
                $r->materialgroup,
                $r->competitorbrand,
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
	
	public function edit_sob($id){		
        $data = array();
        $data['data'] = $this->msob->getDetail($id);
        $data['region'] = $this->mglobal->getRegion();	
		
		if ($id == 0)
		{
			$data['mode'] = 'new';
			$data['page_title'] = 'SOB - New';	
			
			array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));
	        
	        $data['materialgroup'] = $this->mglobal->getMaterialGroup();
	        array_unshift($data['materialgroup'],array('id'=>'-', 'name'=>'--- Select Material Group ---'));

	        $data['competitorbrand'] = $this->mglobal->getCompetitorBrand();
	        array_unshift($data['competitorbrand'],array('id'=>'-', 'name'=>'--- Select Brand Competitor ---'));
		}
		else
		{
			$data['mode'] = 'edit';
			$data['page_title'] = 'SOB - Edit';	
	        $data['materialgroup'] = $this->mglobal->getMaterialGroup();	
	        $data['competitorbrand'] = $this->mglobal->getCompetitorBrand();	
	        $data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
		} 
        $data['main_content'] = $this->load->view('admin/sob/form_sob', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function save() {
		$data = $this->input->post("data");
		
		$ret = $this->msob->save($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	public function delete_sob() {
		$id = $this->input->post("id");
		
		$ret = $this->msob->delete_sob($id);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data has been deleted");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	} 
	
	public function view_sob($id){		
        $data = array();
		$data['page_title'] = 'SOB - View';	
		$data['mode'] = 'view';			
		        
		$data['data'] = $this->msob->getDetail($id);
		$data['region'] = $this->mglobal->getRegion();	
		$data['materialgroup'] = $this->mglobal->getMaterialGroup();	
	    $data['competitorbrand'] = $this->mglobal->getCompetitorBrand();	
	    $data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
        $data['main_content'] = $this->load->view('admin/sob/form_sob', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    function getSalesOffice(){
        $regionid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getSalesOffice($regionid);
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Sales Office ---'));		
        echo json_encode($ret);
    }
	
}