<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sellin extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('msellin');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_sellin(){
        $data = array();
        $data['page_title'] = 'Sellin';		
		
		$data['region'] = $this->mglobal->getRegion();
		array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));		
		
        $data['main_content'] = $this->load->view('admin/sellin/v_sellin', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

	public function get_list_sellin()
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

        $list = $this->msellin->getData($arr);

        $data = array();

        foreach($list->result() as $r) {

        	$data[] = array(					
            		$r->id,					
                    $r->sellinno,
                    $r->sellindate,
                    $r->salesman,
                    $r->customer,
					number_format($r->amount)
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

    function getMaterial(){
        $salesofficeid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getMaterial($salesofficeid);
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Material ---'));		
        echo json_encode($ret);
    }
	
	public function edit_sellin($id){		
        $data = array();
		if ($id == '0')
		{
			$data['page_title'] = 'Sellin - New';					
		}
		else
		{
			$data['page_title'] = 'Sellin - Edit';				
		}        
		$data['mode'] = 'edit';
		$data["data"] = $this->msellin->getDetail($id);
		
		$data['region'] = $this->mglobal->getRegion();		
		
		$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
		$data['salesman'] = $this->mglobal->getSalesman($data["data"]["header"]["salesofficeid"]);
		$data['customer'] = $this->mglobal->getCustomerByDate($data["data"]["header"]["userid"],$data["data"]["header"]["sellindate"]);		
		$data['material'] = $this->mglobal->getMaterial($data["data"]["header"]["salesofficeid"]);
		
        $data['main_content'] = $this->load->view('admin/sellin/form_sellin', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	function getPriceID(){
        $customerno = $this->input->post('id',TRUE);
        $ret = $this->msellin->getPriceID($customerno);		
        echo json_encode($ret);
    }
	
	function getPrice(){
        $materialid = $this->input->post('materialid',TRUE);
		$priceid = $this->input->post('priceid',TRUE);
		$tgl = $this->input->post('tgl',TRUE);
        $ret = $this->msellin->getPrice($materialid, $priceid, $tgl);		
        echo json_encode($ret);
    }
	
	function getBalSlofPac(){
        $materialid = $this->input->post('materialid',TRUE);		
        $ret = $this->msellin->getBalSlofPac($materialid);		
        echo json_encode($ret);
    }
	
	function getIntrodeal(){
        $materialid = $this->input->post('materialid',TRUE);		
		$salesofficeid = $this->input->post('salesofficeid',TRUE);	
		$tgl = $this->input->post('tgl',TRUE);	
        $ret = $this->msellin->getIntrodeal($materialid, $salesofficeid, $tgl);		
        echo json_encode($ret);
    }
	
	function getCustIntrodeal(){
        $materialid = $this->input->post('materialid',TRUE);		
		$customerno = $this->input->post('customerno',TRUE);			
        $ret = $this->msellin->getCustIntrodeal($materialid, $customerno);		
        echo json_encode($ret);
    }
	
	public function save() {
		$data = $this->input->post("data");
		
		$ret = $this->msellin->save($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	public function delete_sellin() {
		$id = $this->input->post("id");
		
		$ret = $this->msellin->delete_sellin($id);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data has been deleted");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	} 
	
	public function view_sellin($id){		
        $data = array();
		$data['page_title'] = 'Sellin - View';	
		$data['mode'] = 'view';			
		        
		$data["data"] = $this->msellin->getDetail($id);
		
		$data['region'] = $this->mglobal->getRegion();		
		
		$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
		$data['salesman'] = $this->mglobal->getSalesman($data["data"]["header"]["salesofficeid"]);
		$data['customer'] = $this->mglobal->getCustomer($data["data"]["header"]["userid"]);		
		$data['material'] = $this->mglobal->getMaterial($data["data"]["header"]["salesofficeid"]);
		
        $data['main_content'] = $this->load->view('admin/sellin/form_sellin', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
}