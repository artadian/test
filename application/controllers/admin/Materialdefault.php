<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Materialdefault extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->model('common_model'); 
        $this->load->model('mglobal');  
        $this->load->model('mstock');
        $this->load->model('mmaterialdefault');           
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }  
    public function list_materialdefault(){
        $data = array();
        $data['page_title'] = 'Material Default';      
        
        $data['region'] = $this->mglobal->getRegion();
        array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));       
        
        $data['main_content'] = $this->load->view('admin/materialdefault/v_materialdefault', $data, TRUE);      
        $this->load->view('admin/index', $data);
    }
    
    function edit_materialdefault(){
        $data = array();
        $data['page_title'] = 'Material Default';

        $aregion         = $this->uri->segment(4);
        $asalesoffice    = $this->uri->segment(5);
        $arr             = array($asalesoffice);

        $data['getregionn']         = $aregion;
        $data['getsalesofficee']    = $asalesoffice;
        $data['region']             = $this->mglobal->getRegion();
        $data['salesoffice']        = $this->mmaterialdefault->getsalesoffice($aregion);

        $data['getmaterial']        = $this->mmaterialdefault->getmaterial();
        $data['getform']            = $this->mmaterialdefault->getform($arr);      

         //var_dump($data['getmaterial']);exit();
        $data['main_content'] = $this->load->view('admin/Materialdefault/form_materialdefault', $data, TRUE);
        $this->load->view('admin/index', $data);

    }

    function getSalesOffice(){
        $regionid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getSalesOffice($regionid);
        array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Sales Office ---'));        
        echo json_encode($ret);             
    }
    function getMaterial(){
        $ret    = $this->mmaterialdefault->getmaterial();
        array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Material ---'));        
        echo json_encode($ret);
    }
    function getMateralGroup(){
        $materialid = $this->input->post('materialid',TRUE);
        $ret = $this->mmaterialdefault->getMaterialGroup($materialid);    
        echo json_encode($ret);
    }
    public function save() {
        $data = $this->input->post("data");
        
        //var_dump($data);exit();
        $ret = $this->mmaterialdefault->save($data);
        //echo $ret;exit;
        if ($ret["status"]==1){
            $res = $this->common_model->response("success","Data saved successfully");          
        }else{  
            $message = isset($ret["message"])?$ret["message"]:"Save Failed";
            $res = $this->common_model->response("error",$message);
        }
        
        echo json_encode($res);
    }
    
}