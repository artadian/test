<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Posmdefault extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('mposm');		
        $this->load->model('mcustomer'); 
        $this->load->model('mposmdefault'); 
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'POSM Default';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_posm_default(){
        $data = array();
        $data['page_title'] = 'POSM Default';		
		
		$data['region'] = $this->mglobal->getRegion();
        $data['role']   = $this->mposmdefault->getRole();
		array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));	
        array_unshift($data['role'],array('id'=>'-', 'name'=>'--- Select Role ---'));	
		
        $data['main_content'] = $this->load->view('admin/posmdefault/v_posmdefault', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }
    function edit_posmdefault(){
        $data = array();
        $data['page_title'] = 'POSM';

        $aregion         = $this->uri->segment(4);
        $asalesoffice    = $this->uri->segment(5);
        $arole           = $this->uri->segment(6);
        $arr             = array($asalesoffice, $arole);

        $data['getregionn']         = $aregion;
        $data['getsalesofficee']    = $asalesoffice;
        $data['getrolee']           = $arole;
        $data['region']             = $this->mglobal->getRegion();
        $data['salesoffice']        = $this->mposmdefault->getsalesoffice($aregion);
        $data['role']               = $this->mposmdefault->getRole();

        $data['getposmtype']        = $this->mposmdefault->getposmtype();
        $data['getform']            = $this->mposmdefault->getform($arr);      

         //var_dump($data['getform']);exit();
        $data['main_content'] = $this->load->view('admin/posmdefault/form_posmdefault', $data, TRUE);
        $this->load->view('admin/index', $data);

    }
    function getSalesOffice(){
        $regionid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getSalesOffice($regionid);
        array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Sales Office ---'));        
        echo json_encode($ret);
    }   
    function getPrice(){
        $materialid = $this->input->post('materialid',TRUE);
        $priceid = $this->input->post('priceid',TRUE);
        $tgl = $this->input->post('tgl',TRUE);
        $ret = $this->mstock->getPrice($materialid, $priceid, $tgl);        
        echo json_encode($ret);
    }
    function getIntrodeal(){
        $materialid = $this->input->post('materialid',TRUE);        
        $salesofficeid = $this->input->post('salesofficeid',TRUE);  
        $tgl = $this->input->post('tgl',TRUE);  
        $ret = $this->mstock->getIntrodeal($materialid, $salesofficeid, $tgl);      
        echo json_encode($ret);
    }
    function getRole(){
        $ret    = $this->mcustomer->getRole();
        array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Role ---'));        
        echo json_encode($ret);
    }

    function getPosmType(){
        $ret    = $this->mposmdefault->getposmtype();
        array_unshift($ret,array('id'=>'-', 'name'=>'--- Select POSM Type ---'));        
        echo json_encode($ret);
    }
    public function save() {
        $data = $this->input->post("data");
        
        $ret = $this->mposmdefault->save($data);
       // var_dump($ret);exit;
        if ($ret["status"]==1){
            $res = $this->common_model->response("success","Data saved successfully");          
        }else{  
            $message = isset($ret["message"])?$ret["message"]:"Save Failed";
            $res = $this->common_model->response("error",$message);
        }
        
        echo json_encode($res);
    }
   
	
}