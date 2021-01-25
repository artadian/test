<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Createnew extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');
		$this->load->model('mcreate_new');
    }

    // public function index(){
    //     $data = array();
    //     $data['page_title'] = 'Calender';
    //     $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
    //     $this->load->view('admin/index', $data);
    // }
	
	 public function index(){		
		$id=0;
        $data = array();
        $data['page_title'] = 'Create New';
		// $data['type'] = $this->mcreate_new->select('jenis');
		// array_unshift($data['type'],array('ID'=>'-', 'Nama'=>'--- Please select Type ---'));
		
		// $data['userFinalStop'] = $this->mcreate_new->getUserStop();
		// array_unshift($data['userFinalStop'],array('ID'=>'-', 'Nama'=>'--- Please select Final Stop ---'));
		
		// $data['userNextStop'] = $this->mcreate_new->getUserStop();
		// array_unshift($data['userNextStop'],array('ID'=>'-', 'Nama'=>'--- Please select Next Stop ---'));
						
		// //$data['courier'] = $this->mcreate_new->select('kurir');
		// $data['courier'] = $this->mcreate_new->getCourier();
		// array_unshift($data['courier'],array('ID'=>'-', 'Nama'=>'--- Please select Courier ---'));
		
		// $data['doc'] = $this->mcreate_new->getDocument();
		// array_unshift($data['doc'],array('ID'=>'-', 'Nama'=>'New Document'));
		
		// $data['template'] = $this->mcreate_new->select('template');
		// array_unshift($data['template'],array('ID'=>'-', 'Nama'=>'--- Please select Template ---'));
		
		// if ($id > 0)
		// {
		// 	$data["data"] = $this->mcreate_new->getDetail($id);	
		// 	$data['userRoute'] = $this->mcreate_new->getUserRoute($data["data"]["header"]['Route']);
		// }
		// else
		// {
		// 	$data['userRoute'] = $this->mcreate_new->getUserRoute('');
		// }
		
		// $data["defaultRoute"] = $this->mcreate_new->getDefaultRoute();			
		
        $data['main_content'] = $this->load->view('admin/create/form_create_new', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function send() {
		$data = $this->input->post("data");
		
		$ret = $this->mcreate_new->send($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Package sent successfully \r\n Package no: ".$ret["paketno"]);			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}

	public function getNoDocument() {
		$data = $this->input->post("no");
		//$paketno = substr($data,0,10);
		//$pengirim = $this->mcreate_new->getPengirim($paketno);
				
		$ret = $this->mcreate_new->getNoDocument($data);
		
		//cek jika mau mengirimkan kembali dokumen yang pernah dibuat sebelumnya, maka no revisi ditambah 1
		/*if ($pengirim[0]['Pengirim'] == $this->session->userdata('id'))
		{
			
			$ret[0]['Revisi'] = $ret[0]['Revisi'] + 1;
			$ret[0]['Revisi'] = str_pad($ret[0]['Revisi'],2,'0',STR_PAD_LEFT);
		}*/
		//print_r($ret); exit;
		echo json_encode($ret);
	}
	
	public function get_list_stop()
    {
    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->mcreate_new->getDataStop();

        $data = array();

        foreach($list->result() as $r) {

        	$data[] = array(					            		
                    $r->No,
					$r->No,
                    $r->TglTerima,
                    $r->NoPaket,
                    $r->Dari,
					$r->Jenis,
					$r->Deskripsi,
					$r->Jumlah,
					$r->Nominal,
					$r->JenisID,
					$r->Keterangan,
					$r->Revisi
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

    public function draft() {
		$data = $this->input->post("data");
		
		$ret = $this->mcreate_new->draft($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Package saved successfully \r\n Package no: ".$ret["paketno"]);			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}

	public function getTemplate() {
		$data = $this->input->post("data");
		
		$ret = $this->mcreate_new->getTemplate($data);
		
		echo json_encode($ret); 
	}

}