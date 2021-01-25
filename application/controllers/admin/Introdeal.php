<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Introdeal extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('mintrodeal');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_introdeal(){
        $data = array();
        $data['page_title'] = 'Introdeal';	
        $data['region'] = $this->mglobal->getRegion();
		array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));	

        $data['materialgroup'] = $this->mglobal->getMaterialGroup();
        array_unshift($data['materialgroup'],array('id'=>'-', 'name'=>'--- Select Material Group ---'));			
        $data['main_content'] = $this->load->view('admin/introdeal/v_introdeal', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

	public function get_list_introdeal() 
	{		
		$regionid = $this->input->post("regionid");	
		$salesofficeid = $this->input->post("salesofficeid");	
		$arr = array($regionid, $salesofficeid);

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mintrodeal->getData($arr);
        $data = array();
        foreach($list->result() as $r) {
        	$data[] = array(					
            	$r->id,			
                $r->region,
                $r->salesoffice,
                $r->material,
                $r->qtyorder,
                $r->qtybonus,
                $r->startdate,
                $r->enddate,
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
	
	public function edit_introdeal($id){		
        $data = array();
        $data['data'] = $this->mintrodeal->getDetail($id);
        $data['region'] = $this->mglobal->getRegion();	
		
		if ($id == 0)
		{
			$data['mode'] = 'new';
			$data['page_title'] = 'Introdeal - New';	
			array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));
		}
		else
		{
			$data['mode'] = 'edit';
			$data['page_title'] = 'Introdeal - Edit';	
	        $data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
	        $data['material'] = $this->mglobal->getMaterial($data["data"]["header"]["salesofficeid"]);	
		} 
        $data['main_content'] = $this->load->view('admin/introdeal/form_introdeal', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function save() {
		$data = $this->input->post("data");
		
		$ret = $this->mintrodeal->save($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	public function delete_introdeal() {
		$id = $this->input->post("id");
		
		$ret = $this->mintrodeal->delete_introdeal($id);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data has been deleted");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	} 
	
	public function view_introdeal($id){		
        $data = array();
		$data['page_title'] = 'Introdeal - View';	
		$data['mode'] = 'view';			
		        
		$data["data"] = $this->mintrodeal->getDetail($id);
		$data['region'] = $this->mglobal->getRegion();		
	    $data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
	    $data['material'] = $this->mglobal->getMaterial($data["data"]["header"]["salesofficeid"]);	
        $data['main_content'] = $this->load->view('admin/introdeal/form_introdeal', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    function getSalesOffice(){
        $regionid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getSalesOffice($regionid);
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Sales Office ---'));		
        echo json_encode($ret);
    }

    function getMaterial(){
        $salesofficeid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getMaterial($salesofficeid);
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Material ---'));		
        echo json_encode($ret);
    }
	
}