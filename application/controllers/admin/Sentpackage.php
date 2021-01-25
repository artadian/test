<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sentpackage extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');		
		$this->load->model('msent_package');
		$this->load->library('pdf');
		$this->load->library('qrcod');		
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	

    public function sent_package(){
        $data = array();
        $data['page_title'] = 'Sent Package';		
        $data['main_content'] = $this->load->view('admin/sentpackage/v_sent_package', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

	public function get_list_sent()
    {

    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->msent_package->getData();

        $data = array();

        foreach($list->result() as $r) {

        	$data[] = array(					
            		$r->ID,					
                    $r->No,
					$r->Status,	
                    $r->Tanggal,
                    $r->Dari,
                    $r->Pengirim,
					$r->FinalStop,					
					$r->Keterangan,
					$r->StatusHistory
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
	
	public function edit_sent_package($id){		
        $data = array();
        $data['page_title'] = 'Detail Sent Package';				
		$data["data"] = $this->msent_package->getDetail($id);
						
        $data['main_content'] = $this->load->view('admin/sentpackage/form_sent_package', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function cancel() {
		$data = $this->input->post("data");
		
		$ret = $this->msent_package->cancel($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Package has been cancelled and moved to On Progress - Send Package");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	public function print_sentpackage($id){		
		QRcode::png("1234567","test.png");
		$data = $this->msent_package->getPrint($id);	
        $pdf = new PDF_MC_Table('P','mm','A5');
        // membuat halaman baru
        $pdf->AddPage();
		$pdf->Rect(5, 5, 138, 57, 'D'); //For A4
        // setting jenis font yang akan digunakan    		
        $pdf->SetFont('Arial','',10);		
		$pdf->Cell(50,6,$pdf->Image("test.png", $pdf->GetX(), $pdf->GetY(), 40, 40, "png"),0,1);		
				
		$pdf->SetWidths(Array(22,3,65));
		$pdf->SetLineHeight(6);
		$pdf->SetAligns(Array('','C',''));
		
		$pdf->SetY(15);
		$pdf->Cell(40);		
		$pdf->Row(Array('Package No',':',$data['No']));
		$pdf->Cell(40);
		$pdf->Row(Array('Date',':',$data['Tanggal']));
		$pdf->Cell(40);
		$pdf->Row(Array('To',':',$data['NextStop']));
		$pdf->Cell(40);
		$pdf->Row(Array('From',':',$data['Pengirim']));
		
		$pdf->SetDrawColor(0,0,0); 
		$pdf->Line(0,75,150,75);
		
		$pdf->Rect(5, 88, 138, 77, 'D'); //For A4
		$pdf->Cell(50,6,$pdf->Image("test.png", 10, 93, 40, 40, "png"),0,1);		
		
		$pdf->Rect(15, 138, 30, 20, 'D');
		$pdf->SetY(139);
		$pdf->Cell(8);	
		$pdf->Cell(25,6,'Received By :',0,0);
				
		$pdf->SetY(98);
		$pdf->Cell(40);	
		$pdf->Row(Array('Package No',':',$data['No']));
		$pdf->Cell(40);
		$pdf->Row(Array('Date',':',$data['Tanggal']));
		$pdf->Cell(40);
		$pdf->Row(Array('To',':',$data['NextStop']));
		$pdf->Cell(40);
		$pdf->Row(Array('From',':',$data['Pengirim']));			
				        
        $pdf->Output();
    }	
	
	
}