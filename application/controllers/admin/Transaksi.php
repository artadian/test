<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('mmasterdata');	
		$this->load->model('mtransaksi');
		$this->load->library('encrypt');		
    }

    public function index(){
        $data = array();
		
		
        $data['page_title'] = 'Purchase Order';
        $data['main_content'] = $this->load->view('admin/PO/v_PO', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function GoodsReceipt(){
        $data = array();
        $data['page_title'] = 'Goods Receipt';		
		
		// $data['region'] = $this->mglobal->getRegion();
		// array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));		
		
        $data['main_content'] = $this->load->view('admin/GR/v_GoodReceipt', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

    public function list_barang(){
        $data = array();
        $data['page_title'] = 'Barang';		
		
		// $data['region'] = $this->mglobal->getRegion();
		// array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));		
		
        $data['main_content'] = $this->load->view('admin/barang/v_masterbarang', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

    public function list_supplier(){
        $data = array();
        $data['page_title'] = 'Supplier';		
		
		// $data['region'] = $this->mglobal->getRegion();
		// array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));		
		
        $data['main_content'] = $this->load->view('admin/supplier/v_mastersupplier', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

    public function list_PO(){
        $data = array();
        $data['page_title'] = 'Purchase Order';		
		
		// $data['region'] = $this->mglobal->getRegion();
		// array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));		
		
        $data['main_content'] = $this->load->view('admin/PO/v_PO', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

	public function get_list_barang()
    {
			
		$arr = array("1");
				
    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mmasterdata->getData($arr);
        // var_dump($list);exit();

        $data = array();

        foreach($list->result() as $r) {

        	$data[] = array(					
            		$r->kode,
            		$r->tipe,
                    $r->nama,
                    $r->merk
            );
        }

		$output = array(
              	"draw" => $draw,
                 "recordsTotal" => $list->num_rows(),
                 "recordsFiltered" => $list->num_rows(),
                 "data" => $data
       	);
       	// var_dump($data);exit();
        echo json_encode($output);
        exit();
    }

    public function get_list_PO()
    {
			
		$arr = array("1");
				
    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mtransaksi->getDataPO($arr);
        // var_dump($list);exit();

        $data = array();

        foreach($list->result() as $r) {

        	$data[] = array(					
            		$r->orderdate,
            		$r->nama,
            		$r->status
                    
            );
        }

		$output = array(
              	"draw" => $draw,
                 "recordsTotal" => $list->num_rows(),
                 "recordsFiltered" => $list->num_rows(),
                 "data" => $data
       	);
       	// var_dump($data);exit();
        echo json_encode($output);
        exit();
    }

    function getMaterial(){
        $supplierid = $this->input->post('id',TRUE);
        $ret = $this->mtransaksi->getMaterial($supplierid);
        // var_dump($ret->result());exit();	
		array_unshift($ret,array('id'=>'-', 'nama'=>'--- Select Material ---'));		
        echo json_encode($ret);
    }
	function getMaterialDetail(){
        $idbarang = $this->input->post('idbarang',TRUE);
        $ret = $this->mtransaksi->getMaterialDetail($idbarang);
        // var_dump($ret);exit();	
		// array_unshift($ret,array('id'=>'-', 'nama'=>'--- Select Material ---'));		
        echo json_encode($ret);
    }
	function getTipe(){
        // $regionid = $this->input->post('id',TRUE);
        $ret = $this->mmasterdata->getTipe();
		array_unshift($ret,array('id'=>'-', 'nama'=>'--- Select Tipe ---'));		
        echo json_encode($ret);
    }

    function getSupplier(){
        // $regionid = $this->input->post('id',TRUE);
        $ret = $this->mmasterdata->getSupplier();
		array_unshift($ret,array('id'=>'-', 'nama'=>'--- Select Tipe ---'));		
        echo json_encode($ret);
    }

    function getUOM(){
        // $regionid = $this->input->post('id',TRUE);
        $ret = $this->mmasterdata->getUOM();
		array_unshift($ret,array('id'=>'-', 'nama'=>'--- Select Tipe ---'));		
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
	
	public function newPO($id){		
        $data = array();
        $data["data"] = $this->mtransaksi->getDetail($id);
        $data["supplier"] = $this->mmasterdata->getSupplier();
        // var_dump($data['supplier']);exit();
        array_unshift($data['supplier'],array('kodesupplier'=>'-', 'nama'=>'--- Select Supplier ---'));
		if ($id == '0')
		{
			$data['page_title'] = 'New Purchase Order';		
			$data['mode'] = 'new';
			
		}
		
		$data['main_content'] = $this->load->view('admin/PO/form_PO', $data, TRUE);
		$this->load->view('admin/index', $data);	     
    }

    public function edit_supplier($id){		
        $data = array();
        $data["data"] = $this->mmasterdata->getDetail($id);
        $data['Tipe'] = $this->mmasterdata->getTipe();
        // $data['region'] = $this->mglobal->getRegion();	
		if ($id == '0')
		{
			$data['page_title'] = 'Supplier - New';		
			$data['mode'] = 'new';
			
		}
		
		$data['main_content'] = $this->load->view('admin/supplier/form_supplier', $data, TRUE);
		$this->load->view('admin/index', $data);	     
    }
	
	public function savePO() {
		$data = $this->input->post("data");
		// print_r($data);exit;
		$ret = $this->mtransaksi->savePO($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}

	public function savebarang() {
		$data = $this->input->post("data");
		// print_r($data);exit;
		$ret = $this->mmasterdata->savebarang($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}

	public function savesupplier() {
		$data = $this->input->post("data");
		// print_r($data);exit;
		$ret = $this->mmasterdata->savesupplier($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	function getCustomerByDate(){
		$salesmanid = $this->input->post('id',TRUE);
		$date = $this->input->post('date',TRUE);
        $ret = $this->mglobal->getCustomerByDate($salesmanid,$date);
		array_unshift($ret,array('customerno'=>'-', 'name'=>'--- Select Customer ---'));		
        echo json_encode($ret);
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