<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Target extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');	
		$this->load->model('mglobal');	
		$this->load->model('mtarget');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function list_target(){
        $data = array();
        $data['page_title'] = 'Target Salesman';		
		
		$data['region'] = $this->mglobal->getRegion();
		array_unshift($data['region'],array('id'=>'-', 'name'=>'--- Select Region ---'));	
		
		$data['year'] = $this->mtarget->getYear();
		array_unshift($data['year'],array('id'=>'-', 'name'=>'--- Select Year ---'));		
		
        $data['main_content'] = $this->load->view('admin/target/v_target', $data, TRUE);		
        $this->load->view('admin/index', $data);
    }

	public function get_list_target()
    {
		$regionid = $this->input->post("regionid");		
		$salesofficeid = $this->input->post("salesofficeid");		
		$salesmanid = $this->input->post("salesmanid");	
		$year = $this->input->post("year");	
		$cycle = $this->input->post("cycle");	
		$arr = array($regionid, $salesofficeid, $salesmanid, $year, $cycle);
				
    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mtarget->getData($arr);

        $data = array();

        foreach($list->result() as $r) {

        	$data[] = array(					
            		$r->id,					
                    $r->year,
                    $r->cycle,
                    $r->salesman,
                    $r->materialgroup,
					$r->call,
                    $r->effectivecall,
					$r->nota,
                    number_format($r->volume),					
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
	
	function getMaterialGroup(){
        $salesofficeid = $this->input->post('id',TRUE);
        $ret = $this->mglobal->getMaterialGroupDefault($salesofficeid);
		array_unshift($ret,array('id'=>'-', 'name'=>'--- Select Material Group ---'));		
        echo json_encode($ret);
    }
	
	public function edit_target($id){		
        $data = array();
		if ($id == '0')
		{
			$data['page_title'] = 'Target Salesman - New';					
		}
		else
		{
			$data['page_title'] = 'Target Salesman - Edit';				
		}        
		$data['mode'] = 'edit';
		$data["data"] = $this->mtarget->getDetail($id);
				
		$data['year'] = $this->mtarget->getYearInput();	
		array_unshift($data['year'],array('id'=>'-', 'name'=>'--- Select Year ---'));		
			
		$data['region'] = $this->mglobal->getRegion();		
		
		$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
		$data['salesman'] = $this->mglobal->getSalesman($data["data"]["header"]["salesofficeid"]);
		
		$data['materialgroup'] = $this->mglobal->getMaterialGroupDefault($data["data"]["header"]["salesofficeid"]);
		
        $data['main_content'] = $this->load->view('admin/target/form_target', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function save() {
		$data = $this->input->post("data");
		
		$ret = $this->mtarget->save($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data saved successfully");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	public function delete_target() {
		$id = $this->input->post("id");
		
		$ret = $this->mtarget->delete_target($id);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Data has been deleted");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Deleted Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	} 
	
	public function view_target($id){		
        $data = array();
		$data['page_title'] = 'Target Salesman - View';	
		$data['mode'] = 'view';			
		        
		$data["data"] = $this->mtarget->getDetail($id);
		
		$data['year'] = $this->mtarget->getYearInput();	
		array_unshift($data['year'],array('id'=>'-', 'name'=>'--- Select Year ---'));		
			
		$data['region'] = $this->mglobal->getRegion();		
		
		$data['salesoffice'] = $this->mglobal->getSalesOffice($data["data"]["header"]["regionid"]);
		$data['salesman'] = $this->mglobal->getSalesman($data["data"]["header"]["salesofficeid"]);
		
		$data['materialgroup'] = $this->mglobal->getMaterialGroupDefault($data["data"]["header"]["salesofficeid"]);
		
        $data['main_content'] = $this->load->view('admin/target/form_target', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function upload_target(){		
        $data = array();
		$data['page_title'] = 'Target Salesman - Upload';	
		$data['main_content'] = $this->load->view('admin/target/form_upload_target', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function download_template(){       
        $this->load->helper('download');
		$data = file_get_contents(FCPATH."/dok/template_upload_target.xlsx"); // Read the file's contents
        $name = "Template Upload Target Salesman.xlsx";
        force_download($name, $data);
    }
	
	public function upload() {
		$data = $this->input->post("data");
		
		$ret = $this->mtarget->upload($data);
		
		$message = isset($ret["message"])?$ret["message"]:"Save Failed";
		$res = $this->common_model->response("Success",$message."|".$ret['countsuccess']."|".$ret['countfailed']);
		
		echo json_encode($res);
	}
	
}