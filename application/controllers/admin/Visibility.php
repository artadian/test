<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Visibility extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('mvisibility');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_visibility(){
        $data = array();
        $data['page_title'] = 'Visibility';	
        $data['region'] = $this->mglobal->getRegion();
		array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));	
			
        $data['main_content'] = $this->load->view('admin/visibility/v_visibility', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

	public function get_list_visibility() 
	{		
		$regionid = $this->input->post("regionid");	
		$salesofficeid = $this->input->post("salesofficeid");	
		$salesmanid = $this->input->post("salesmanid");	
		$tglawal = $this->input->post("tglawal");	
		$tglakhir = $this->input->post("tglakhir");	
		$arr = array($regionid, $salesofficeid, $salesmanid, $tglawal, $tglakhir);

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mvisibility->getData($arr);
        $data = array();
        foreach($list->result() as $r) {
        	$data[] = array(					
            	$r->id,			
                $r->visibilitydate,
                $r->salesman,
                $r->customer,
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
	
	public function edit_visibility($id){		
        $data = array();
        $data['data'] = $this->mvisibility->getDetail($id);
        $data['region'] = $this->mglobal->getRegion();	
		
		if ($id == 0)
		{
			$data['mode'] = 'new';
			$data['page_title'] = 'Visibility - New';	
			array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));
		}
		else
		{
			$data['mode'] = 'edit';
			$data['page_title'] = 'Visibility - Edit';
	        $data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
	        $data['salesman'] = $this->mglobal->getSalesman($data["data"]["header"]["salesofficeid"]);
	        $data['customer'] = $this->mglobal->getCustomerByDate($data["data"]["header"]["userid"],$data["data"]["header"]["visibilitydate"]);
	        $data['material'] = $this->mglobal->getMaterial($data["data"]["header"]["salesofficeid"]);	
	        $data['materialh'] = $this->mglobal->getMaterial($data["data"]["header"]["salesofficeid"]);	
		} 
        $data['main_content'] = $this->load->view('admin/visibility/form_visibility', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function save() {
		$data = $this->input->post("data");
		// print_r($data);exit;
		$ret = $this->mvisibility->save($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	public function delete_visibility() {
		$id = $this->input->post("id");
		
		$ret = $this->mvisibility->delete_visibility($id);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data has been deleted");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	} 
	
	public function view_visibility($id){		
        $data = array();
		$data['page_title'] = 'Visibility - View';	
		$data['mode'] = 'view';			
		$data["data"] = $this->mvisibility->getDetail($id);
		$data['region'] = $this->mglobal->getRegion();
	    $data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
	    $data['salesman'] = $this->mglobal->getSalesman($data["data"]["header"]["salesofficeid"]);
	    $data['customer'] = $this->mglobal->getCustomerByDate($data["data"]["header"]["userid"],$data["data"]["header"]["visibilitydate"]);
	    
	    $data['material'] = $this->mglobal->getMaterial($data["data"]["header"]["salesofficeid"]);	
        $data['main_content'] = $this->load->view('admin/visibility/form_visibility', $data, TRUE);
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
		// array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Material ---'));		
        echo json_encode($ret);
    }

    function getSalesman(){
        $salesofficeid = $this->input->post('id',TRUE);
        $ret = $this->mvisibility->getSalesman($salesofficeid);
		array_unshift($ret,array('userid'=>'-', 'name'=>'--- Select Salesman ---'));		
        echo json_encode($ret);
    }

    function getCustomerUser(){
        $userid = $this->input->post('userid',TRUE);
        $date = $this->input->post('date',TRUE);
        $ret = $this->mglobal->getCustomerByDate($userid,$date);
		array_unshift($ret,array('customerno'=>'-', 'name'=>'--- Select Customer ---'));		
        echo json_encode($ret);
    }

    function getPacMax(){
    	$customerno = $this->input->post('customerno',TRUE);
    	$materialid = $this->input->post('materialid',TRUE);
        $ret = $this->mvisibility->getPacMax($customerno,$materialid);	
        echo json_encode($ret); 
    }
	
}