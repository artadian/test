<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trial extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('mtrial');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_trial(){
        $data = array();
        $data['page_title'] = 'Trial';		
		
		$data['region'] = $this->mglobal->getRegion();
		array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));		
		
        $data['main_content'] = $this->load->view('admin/trial/v_trial', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

	public function get_list_trial()
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

        $list = $this->mtrial->getData($arr);

        $data = array();

        foreach($list->result() as $r) {

        	$data[] = array(					
            		$r->id,			
                    $r->trialdate,
                    $r->salesman,
                    $r->trialtype,
                    $r->location,
                    $r->name,
                    $r->material
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
        $ret = $this->mtrial->getSalesman($salesofficeid);
		array_unshift($ret,array('userid'=>'-', 'name'=>'--- Select Salesman ---'));		
        echo json_encode($ret);
    }

    function getMaterial(){
        $salesofficeid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getMaterial($salesofficeid);
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Material ---'));		
        echo json_encode($ret);
    }

    function getBrandBefore(){
    	$salesofficeid = $this->input->post('salesofficeid',TRUE);
    	$materialgroupid = $this->input->post('materialgroupid',TRUE);
        $ret = $this->mtrial->getBrandBefore($salesofficeid,$materialgroupid);
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Brand Before ---'));		
        echo json_encode($ret);
    }
	
	public function edit_trial($id){		
        $data = array();

		$data['data'] = $this->mtrial->getDetail($id);
		$data['region'] = $this->mglobal->getRegion();	
		if ($id == 0)
		{
			$data['mode'] = 'new';
			$data['page_title'] = 'Trial - New';
			$data['trialtype'] = $this->mtrial->getLookup('trial_type');
			array_unshift($data['trialtype'],array('id'=>'-', 'name'=>'--- Select Trial Type ---'));

			$data['knowproduct'] = $this->mtrial->getLookup('trial_knowing');
			array_unshift($data['knowproduct'],array('id'=>'-', 'name'=>'--- Select Know Product ---'));

			$data['packaging'] = $this->mtrial->getLookup('trial_packaging');
			array_unshift($data['packaging'],array('id'=>'-', 'name'=>'--- Select Packaging ---'));

			$data['taste'] = $this->mtrial->getLookup('trial_taste');
			array_unshift($data['taste'],array('id'=>'-', 'name'=>'--- Select Taste ---'));			
		}
		else
		{
			$data['mode'] = 'edit';
			$data['page_title'] = 'Trial - Edit';
			$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
			$data['salesman'] = $this->mtrial->getSalesman($data["data"]["header"]["salesofficeid"]);	
			$data['trialtype'] = $this->mtrial->getLookup('trial_type');
			$data['material'] = $this->mglobal->getMaterial($data["data"]["header"]["salesofficeid"]);
			$data['knowproduct'] = $this->mtrial->getLookup('trial_knowing');
			$data['taste'] = $this->mtrial->getLookup('trial_taste');
			$data['packaging'] = $this->mtrial->getLookup('trial_packaging');
			$materialgroupid = $this->mtrial->getMaterialGroup($data["data"]["header"]["materialid"]);
			$data['brandbefore'] = $this->mtrial->getBrandBefore($data["data"]["header"]["salesofficeid"],$materialgroupid[0]["value"]);		
		} 
        $data['main_content'] = $this->load->view('admin/trial/form_trial', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	function getPriceID(){
        $customerno = $this->input->post('id',TRUE);
        $ret = $this->mtrial->getPriceID($customerno);		
        echo json_encode($ret);
    }
	
	function getPrice(){
        $materialid = $this->input->post('materialid',TRUE);
		$priceid = $this->input->post('priceid',TRUE);
		$tgl = $this->input->post('tgl',TRUE);
        $ret = $this->mtrial->getPrice($materialid, $priceid, $tgl);		
        echo json_encode($ret);
    }

    function getMaterialGroup(){
    	$materialid = $this->input->post('materialid',TRUE);
        $ret = $this->mtrial->getMaterialGroup($materialid);	
        echo json_encode($ret); 
    }
	
	function getBalSlofPac(){
        $materialid = $this->input->post('materialid',TRUE);		
        $ret = $this->mtrial->getBalSlofPac($materialid);		
        echo json_encode($ret);
    }
	
	function getIntrodeal(){
        $materialid = $this->input->post('materialid',TRUE);		
		$salesofficeid = $this->input->post('salesofficeid',TRUE);	
		$tgl = $this->input->post('tgl',TRUE);	
        $ret = $this->mtrial->getIntrodeal($materialid, $salesofficeid, $tgl);		
        echo json_encode($ret);
    }
	
	function getCustIntrodeal(){
        $materialid = $this->input->post('materialid',TRUE);		
		$customerno = $this->input->post('customerno',TRUE);			
        $ret = $this->mtrial->getCustIntrodeal($materialid, $customerno);		
        echo json_encode($ret);
    }
	
	public function save() {
		$data = $this->input->post("data");
		
		$ret = $this->mtrial->save($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	public function delete_trial() {
		$id = $this->input->post("id");
		
		$ret = $this->mtrial->delete_trial($id);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data has been deleted");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	} 
	
	public function view_trial($id){		
        $data = array();
		$data['page_title'] = 'Trial - View';	
		$data['mode'] = 'view';			
		        
		$data["data"] = $this->mtrial->getDetail($id);
		$data['region'] = $this->mglobal->getRegion();	
		$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
		$data['salesman'] = $this->mtrial->getSalesman($data["data"]["header"]["salesofficeid"]);	
		$data['trialtype'] = $this->mtrial->getLookup('trial_type');
		$data['material'] = $this->mglobal->getMaterial($data["data"]["header"]["salesofficeid"]);
		$data['knowproduct'] = $this->mtrial->getLookup('trial_knowing');
		$data['taste'] = $this->mtrial->getLookup('trial_taste');
		$data['packaging'] = $this->mtrial->getLookup('trial_packaging');
		$data['brandbefore'] = $this->mtrial->getCompetitorBrand($data["data"]["header"]["competitorbrandid"]);
		
        $data['main_content'] = $this->load->view('admin/trial/form_trial', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
}