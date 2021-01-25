<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customermapping extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('mcustomermapping');	
		$this->load->library('encrypt');		
    }

    public function index(){
        $data = array();
		
		
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_customermapping(){
        $data = array();
        $data['page_title'] = 'Customer Mapping';		
		$data['mode'] = 'new';
		
		$data['region'] = $this->mglobal->getRegion();
		array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));		
		$data['day'] = $this->mglobal->getDay();
		array_unshift($data['day'],array('id'=>'-', 'name'=>'--- Select Day ---'));
		$data['week'] = $this->mglobal->getweek();
		array_unshift($data['week'],array('id'=>'-', 'name'=>'--- Select Week ---'));

        $data['main_content'] = $this->load->view('admin/customermapping/form_customermapping', $data, TRUE);		
        $this->load->view('admin/index', $data);
	}
	
	public function upload_customermapping(){		
        $data = array();
		$data['page_title'] = 'Master Customer Mapping - Upload';	
		$data['main_content'] = $this->load->view('admin/customermapping/form_upload_customermapping', $data, TRUE);
        $this->load->view('admin/index', $data);
	}

	public function download_template(){       
        $this->load->helper('download');
		$data = file_get_contents(FCPATH."/dok/template_upload_customermapping.xlsx"); // Read the file's contents
        $name = "Template Upload Customer Mapping.xlsx";
        force_download($name, $data);
	}
	
	public function upload() {
		$data = $this->input->post("data");
		$ret = $this->mcustomermapping->upload($data);
		
		$message = isset($ret["message"])?$ret["message"]:"Save Failed";
		$res = $this->common_model->response("Success",$message."|".$ret['countsuccess']."|".$ret['countfailed']);
		
		echo json_encode($res);
	}

	public function get_list_customermapping()
    {
		$regionid = $this->input->post("regionid");		
		$salesofficeid = $this->input->post("salesofficeid");		
		$salesmanid = $this->input->post("salesmanid");	
		$day = $this->input->post("day");
		$week = $this->input->post("week");
		$arr = array($regionid, $salesofficeid, $salesmanid, $day, $week);
		// print_r($arr);exit;
    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mcustomermapping->getData($arr);
        $data = array();

        foreach($list->result() as $r) {

        	$data[] = array(					
            		$r->id,		
                    $r->customerno,
                    $r->customername,
					$r->visitweek,
					$r->week,
					$r->visitday,
					$r->day,
					$r->nourut
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
	
	function getSalesOffice(){
        $regionid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getSalesOffice($regionid);
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Sales Office ---'));		
        echo json_encode($ret);
    }
	
	function getSalesman(){
        $salesofficeid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getSalesman($salesofficeid);
		array_unshift($ret,array('userid'=>'-', 'name'=>'--- Select Salesman ---'));		
        echo json_encode($ret);
    }
	
	function getCustomer(){
        $salesmanid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getCustomer($salesmanid);
		array_unshift($ret,array('customerno'=>'-', 'name'=>'--- Select Customer ---'));		
        echo json_encode($ret);
	}
	
	function getDay(){
        $ret = $this->mglobal->getDay();
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Day ---'));		
        echo json_encode($ret);
    }

    // function getMaterialGroup(){
    //     $salesofficeid = $this->input->post('id',TRUE);
    //     $ret = $this->mposm->getMaterialGroup($salesofficeid);
	// 	array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Material ---'));		
    //     echo json_encode($ret);
    // }

    // function getPOSMType(){
    //     $salesofficeid = $this->input->post('salesofficeid',TRUE);
    //     $userid = $this->input->post('userid',TRUE);
    //     $userroleid = $this->mposm->getUserRole($userid);
    //     $ret = $this->mposm->getPosmType($salesofficeid,$userroleid[0]['userroleid']);
	// 	array_unshift($ret,array('id'=>'-', 'name'=>'--- Select POSM Type ---'));	
    //     echo json_encode($ret);
    // }

    function getLookup(){
        $lookupkey = $this->input->post('lookupkey',TRUE);
        $ret = $this->mposm->getLookup($lookupkey);	
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select ---'));		
        echo json_encode($ret);
    }
	
	public function edit_posm($id){		
        $data = array();
        $data["data"] = $this->mposm->getDetail($id);
        $data['region'] = $this->mglobal->getRegion();	
		if ($id == '0')
		{
			$data['page_title'] = 'POSM - New';		
			$data['mode'] = 'new';
			
			$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
			$data['salesman'] = $this->mglobal->getSalesman($data["data"]["header"]["salesofficeid"]);
			$data['customer'] = $this->mglobal->getCustomer($data["data"]["header"]["userid"]);
		}
		else
		{
			$data['page_title'] = 'POSM - Edit';	
			$data['mode'] = 'edit';	

			$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
			$data['salesman'] = $this->mglobal->getSalesman($data["data"]["header"]["salesofficeid"]);
			$data['customer'] = $this->mglobal->getCustomer($data["data"]["header"]["userid"]);	
			$userroleid = $this->mposm->getUserRole($data["data"]["header"]["userid"]);
			$data['posmtype'] = $this->mposm->getPosmType($data["data"]["header"]["salesofficeid"],$userroleid[0]['userroleid']);	
			$data['materialgroup'] = $this->mposm->getMaterialGroup($data["data"]["header"]["salesofficeid"]);	
			$data['status'] = $this->mposm->getLookup('posm_status');		
			$data['condition'] = $this->mposm->getLookup('posm_condition');		
		}   
		$data['main_content'] = $this->load->view('admin/posm/form_posm', $data, TRUE);
		$this->load->view('admin/index', $data);	     
    }
	
	public function save() {
		$data = $this->input->post("data");
		$ret = $this->mposm->save($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	public function delete_posm() {
		$id = $this->input->post("id");
		
		$ret = $this->mposm->delete_posm($id);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data has been deleted");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	} 
	
	public function view_posm($id){		
        $data = array();
		$data['page_title'] = 'POSM - View';	
		$data['mode'] = 'view';			
		        
		$data["data"] = $this->mposm->getDetail($id);
		
		$data['region'] = $this->mglobal->getRegion();		
		
		$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
		$data['salesman'] = $this->mglobal->getSalesman($data["data"]["header"]["salesofficeid"]);
		$data['customer'] = $this->mglobal->getCustomer($data["data"]["header"]["userid"]);		
		$data['material'] = $this->mglobal->getMaterial($data["data"]["header"]["salesofficeid"]);
		
        $data['main_content'] = $this->load->view('admin/posm/form_posm', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
}