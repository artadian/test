<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('mcustomer');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_customer(){
        $data = array();
        $data['page_title'] = 'Customer';		
		
		$data['region'] = $this->mglobal->getRegion();
		array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));		
		
        $data['main_content'] = $this->load->view('admin/customer/v_customer', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

	public function get_list_customer()
    {
		$regionid = $this->input->post("regionid");		
		$salesofficeid = $this->input->post("salesofficeid");		
		$salesgroup = $this->input->post("salesgroup");	
		$salesdistrict = $this->input->post("salesditrict");
		$arr = array($regionid, $salesofficeid, $salesgroup, $salesdistrict);
				
    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mcustomer->getData($arr);

        $data = array();

        foreach($list->result() as $r) {

        	$data[] = array(					
            		$r->id,		
                    $r->customerno,
                    $r->name,
					$r->address,
					$r->custgroup,
					$r->regional,
					$r->salesoffice,
					$r->salesgroup,
					$r->salesdistrict
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
	
	function getSalesGroup(){
        $salesofficeid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getSalesGroup($salesofficeid);
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Sales Group ---'));		
        echo json_encode($ret);
	}
	
	function getSalesDistrict(){
        $salesgroupid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getSalesDistrict($salesgroupid);
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Sales District ---'));		
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

    function getMaterialGroup(){
        $salesofficeid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getMaterialGroup();
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Material Group ---'));		
        echo json_encode($ret);
	}
	
	function getWSPClass(){
        $salesofficeid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getWSPClass();
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select WSP Class ---'));		
        echo json_encode($ret);
    }

    function getPOSMType(){
        $salesofficeid = $this->input->post('salesofficeid',TRUE);
        $userid = $this->input->post('userid',TRUE);
        $userroleid = $this->mposm->getUserRole($userid);
        $ret = $this->mposm->getPosmType($salesofficeid,$userroleid[0]['userroleid']);
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select POSM Type ---'));	
        echo json_encode($ret);
    }

    function getLookup(){
        $lookupkey = $this->input->post('lookupkey',TRUE);
        $ret = $this->mposm->getLookup($lookupkey);	
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select ---'));		
        echo json_encode($ret);
    }
	
	public function edit_customer($id){		
		$data = array();
        $data["data"] = $this->mcustomer->getDetail($id);	
		if ($id == '0')
		{
			$data['page_title'] = 'Customer - New';		
			$data['mode'] = 'new';
			
			$data['region'] = $this->mglobal->getRegion();
			array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Please select region ---'));
			$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
			$data['price'] = $this->mglobal->getPrice();
			array_unshift($data['price'],array('id'=>'-', 'name'=>'--- Please select Price ---'));
			$data['role'] = $this->mcustomer->getRole();
			$data['customerGroup'] = $this->mcustomer->getCustomerGroup();
			array_unshift($data['customerGroup'],array('id'=>'-', 'name'=>'--- Please select customer group ---'));
		}
		else
		{
			$data['page_title'] = 'POSM - Edit';	
			$data['mode'] = 'edit';	

			$data['region'] = $this->mglobal->getRegion();
			array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Please select region ---'));
			$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
			$data['salesgroup'] = $this->mglobal->getSalesGroup($data["data"]["header"]["salesoffice_id"]);
			$data['salesdistrict'] = $this->mglobal->getSalesDistrict($data["data"]["header"]["salesgroup_id"]);
			$data['price'] = $this->mglobal->getPrice();
			array_unshift($data['price'],array('id'=>'-', 'name'=>'--- Please select Price ---'));
			$data['role'] = $this->mcustomer->getRole();
			$data['customerGroup'] = $this->mcustomer->getCustomerGroup();
			array_unshift($data['customerGroup'],array('id'=>'-', 'name'=>'--- Please select customer group ---'));		
		}   
		$data['main_content'] = $this->load->view('admin/customer/form_customer', $data, TRUE);
		$this->load->view('admin/index', $data);	     
	}
	
	public function wsp($customerno){		
		$data = array();
		$data["data"] = $this->mcustomer->getDetailWSP($customerno);
		$data['page_title'] = 'Customer WSP - View';
		$data['mode'] = 'new';
		
		$data['materialgroup'] = $this->mglobal->getMaterialGroup();
		array_unshift($data['materialgroup'],array('id'=>'-', 'name'=>'--- Please select materialgroup ---'));
		
		$data['wspclass'] = $this->mglobal->getWSPClass();
		array_unshift($data['wspclass'],array('id'=>'-', 'name'=>'--- Please select wsp class ---'));	
		
		$data['main_content'] = $this->load->view('admin/customer/form_customerWSP', $data, TRUE);
		$this->load->view('admin/index', $data);	     
    }
	
	public function save() {
		$data = $this->input->post("data");
		$ret = $this->mcustomer->save($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully \n Customerno ".$ret["customerno"]."");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}

	public function saveWSP() {
		$data = $this->input->post("data");
		$ret = $this->mcustomer->saveWSP($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	public function delete_customer() {
		$id = $this->input->post("id");
		
		$ret = $this->mcustomer->delete_customer($id);
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data has been deleted");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	} 
	
	public function view_customer($id){		
        $data = array();
		$data['page_title'] = 'Customer - View';	
		$data['mode'] = 'view';			
		        
		$data["data"] = $this->mcustomer->getDetail($id);	
		
		$data['region'] = $this->mglobal->getRegion();
		array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Please select region ---'));
		$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
		$data['salesgroup'] = $this->mglobal->getSalesGroup($data["data"]["header"]["salesoffice_id"]);
		$data['salesdistrict'] = $this->mglobal->getSalesDistrict($data["data"]["header"]["salesgroup_id"]);
		$data['price'] = $this->mglobal->getPrice();
		array_unshift($data['price'],array('id'=>'-', 'name'=>'--- Please select Price ---'));
		$data['role'] = $this->mcustomer->getRole();
		$data['customerGroup'] = $this->mcustomer->getCustomerGroup();
		array_unshift($data['customerGroup'],array('id'=>'-', 'name'=>'--- Please select customer group ---'));
		
        $data['main_content'] = $this->load->view('admin/customer/form_customer', $data, TRUE);
        $this->load->view('admin/index', $data);
	}
	
	public function upload_customer(){		
        $data = array();
		$data['page_title'] = 'Master Customer - Upload';	
		$data['main_content'] = $this->load->view('admin/customer/form_upload_customer', $data, TRUE);
        $this->load->view('admin/index', $data);
	}
	
	public function download_template(){       
        $this->load->helper('download');
		$data = file_get_contents(FCPATH."/dok/template_upload_customer.xlsx"); // Read the file's contents
        $name = "Template Upload Customer Salesman.xlsx";
        force_download($name, $data);
	}
	
	public function upload() {
		$data = $this->input->post("data");
		$ret = $this->mcustomer->upload($data);
		
		$message = isset($ret["message"])?$ret["message"]:"Save Failed";
		$res = $this->common_model->response("Success",$message."|".$ret['countsuccess']."|".$ret['countfailed']);
		
		echo json_encode($res);
	}
}