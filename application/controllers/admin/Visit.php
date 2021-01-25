<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Visit extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('mvisit');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_visit(){
        $data = array();
        $data['page_title'] = 'Visit';		
		
		$data['region'] = $this->mglobal->getRegion();
		array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));		
		
        $data['main_content'] = $this->load->view('admin/visit/v_visit', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

	public function get_list_visit()
    {
		$regionid = $this->input->post("regionid");		
		$salesofficeid = $this->input->post("salesofficeid");		
		$salesmanid = $this->input->post("salesmanid");	
		$tglawal = $this->input->post("tglawal");	
		$tglakhir = $this->input->post("tglakhir");	
		$arr = array($regionid, $salesofficeid, $salesmanid, $tglawal, $tglakhir);
				
    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mvisit->getData($arr);

        $data = array();

        foreach($list->result() as $r) {

        	$data[] = array(					
            		$r->id,		
                    $r->visitdate,
                    $r->salesman,
					$r->customer,
					$r->not_buy_reason,
					$r->not_visit_reason
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
	
	function getCustomerByDate(){
		$salesmanid = $this->input->post('id',TRUE);
		$date = $this->input->post('date',TRUE);
        $ret = $this->mglobal->getCustomerByDate($salesmanid,$date);
		array_unshift($ret,array('customerno'=>'-', 'name'=>'--- Select Customer ---'));		
        echo json_encode($ret);
    }

    function getMaterialGroup(){
        $salesofficeid = $this->input->post('id',TRUE);
        $ret = $this->mposm->getMaterialGroup($salesofficeid);
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Material ---'));		
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
	
	public function edit_visit($id){		
        $data = array();
        $data["data"] = $this->mvisit->getDetail($id);
        $data['region'] = $this->mglobal->getRegion();	
		if ($id == '0')
		{
			$data['page_title'] = 'Visit - New';		
			$data['mode'] = 'new';
			
			$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
			$data['salesman'] = $this->mglobal->getSalesman($data["data"]["header"]["salesofficeid"]);
			$data['customer'] = $this->mglobal->getCustomer($data["data"]["header"]["userid"]);
			$data['not_visit_reason'] = $this->mglobal->getNotVisitReason();
			array_unshift($data['not_visit_reason'],array('id'=>'-', 'name'=>'--- Please select not visit reason ---'));
			$data['not_buy_reason'] = $this->mglobal->getNotBuyReason();
			array_unshift($data['not_buy_reason'],array('id'=>'-', 'name'=>'--- Please select not buy reason ---'));
		}
		else
		{
			$data['page_title'] = 'Visit - Edit';	
			$data['mode'] = 'edit';	

			$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
			$data['salesman'] = $this->mglobal->getSalesman($data["data"]["header"]["salesofficeid"]);
			$data['customer'] = $this->mglobal->getCustomer($data["data"]["header"]["userid"]);
			$data['not_visit_reason'] = $this->mglobal->getNotVisitReason();
			array_unshift($data['not_visit_reason'],array('id'=>'-', 'name'=>'--- Please select not visit reason ---'));
			$data['not_buy_reason'] = $this->mglobal->getNotBuyReason();
			array_unshift($data['not_buy_reason'],array('id'=>'-', 'name'=>'--- Please select not buy reason ---'));
		}   
		$data['main_content'] = $this->load->view('admin/visit/form_visit', $data, TRUE);
		$this->load->view('admin/index', $data);	     
    }
	
	public function save() {
		$data = $this->input->post("data");
		$ret = $this->mvisit->save($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	public function delete_visit() {
		$id = $this->input->post("id");
		
		$ret = $this->mvisit->delete_visit($id);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data has been deleted");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	} 
	
	public function view_visit($id){		
        $data = array();
		$data['page_title'] = 'Visit - View';	
		$data['mode'] = 'view';			
		        
		$data["data"] = $this->mvisit->getDetail($id);
		
		$data['region'] = $this->mglobal->getRegion();		
		
		$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
		$data['salesman'] = $this->mglobal->getSalesman($data["data"]["header"]["salesofficeid"]);
		$data['customer'] = $this->mglobal->getCustomer($data["data"]["header"]["userid"]);
		$data['not_visit_reason'] = $this->mglobal->getNotVisitReason();
		array_unshift($data['not_visit_reason'],array('id'=>'-', 'name'=>'--- Please select not visit reason ---'));
		$data['not_buy_reason'] = $this->mglobal->getNotBuyReason();
		array_unshift($data['not_buy_reason'],array('id'=>'-', 'name'=>'--- Please select not buy reason ---'));
		
        $data['main_content'] = $this->load->view('admin/visit/form_visit', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
}