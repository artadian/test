<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sent extends CI_Controller {

    public function __construct(){
        parent::__construct();
        check_login_user();
		$this->load->model('common_model');		
		$this->load->model('msent');
		$this->load->library('pdf');
		$this->load->library('qrcod');
    }

    public function index(){
        $data = array();
        $data['page_title'] = 'Calender';
        $data['main_content'] = $this->load->view('admin/home', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
		
	public function list_sent(){
        $data = array();
        $data['page_title'] = 'Sent';		
        $data['main_content'] = $this->load->view('admin/sent/v_sent', $data, TRUE);
        $this->load->view('admin/index', $data);
    }
	
	public function get_list_sent()
    {

    	// Datatables Variables
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        $list = $this->msent->getData();

        $data = array();

        foreach($list->result() as $r) {

        	$data[] = array(					
            		$r->ID,					
                    $r->No,
					$r->Status,
                    $r->Tanggal,                    
                    $r->NextStop,
					$r->FinalStop,					
					$r->Keterangan,
					$r->Kurir,
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

	public function edit_sent($id){		
        $data = array();
        $data['page_title'] = 'Detail Sent Package';				
		$data["data"] = $this->msent->getDetail($id);	
				
        $data['main_content'] = $this->load->view('admin/sent/form_sent', $data, TRUE);
        $this->load->view('admin/index', $data);
    }	
	
	public function print_sent($id){		
		QRcode::png("1234567","test.png");
		$data = $this->msent->getPrint($id);	
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
		
		/*$start_awal=$pdf->GetX(); 
		$get_xxx = $pdf->GetX();
		$get_yyy = $pdf->GetY();
		
		$width_cell = 22;  
		$height_cell = 6;  
		$width_cell2 = 65;    
		$width_cell3 = 3;    
		
		$pdf->MultiCell($width_cell,$height_cell,'Package No',0); 
		$get_xxx+=$width_cell;                           
		$pdf->SetXY($get_xxx, $get_yyy);   
		
		$pdf->MultiCell($width_cell3,$height_cell,':',0); 
		$get_xxx+=$width_cell3;                           
		$pdf->SetXY($get_xxx, $get_yyy);               
		
		$pdf->MultiCell($width_cell2,$height_cell,$data['No'],0); 
		$get_xxx+=$width_cell2;                           
		 		
		$pdf->Ln();
		$get_xxx=$start_awal;                      
		$get_yyy+=$height_cell; 
		
		$pdf->SetXY($get_xxx, $get_yyy); 

		$pdf->MultiCell($width_cell,$height_cell,'Date',0); 
		$get_xxx+=$width_cell;                           
		$pdf->SetXY($get_xxx, $get_yyy);
		
		$pdf->MultiCell($width_cell3,$height_cell,':',0); 
		$get_xxx+=$width_cell3;                           
		$pdf->SetXY($get_xxx, $get_yyy);                   
		
		$pdf->MultiCell($width_cell2,$height_cell,$data['Tanggal'],0); 
		$get_xxx+=$width_cell2;                           
		$pdf->SetXY($get_xxx, $get_yyy);  
		
		$pdf->Ln();
		$get_xxx=$start_awal;                      
		$get_yyy+=$height_cell; 
		
		$pdf->SetXY($get_xxx, $get_yyy); 

		$pdf->MultiCell($width_cell,$height_cell,'To',0); 
		$get_xxx+=$width_cell;                           
		$pdf->SetXY($get_xxx, $get_yyy);       
		
		$pdf->MultiCell($width_cell3,$height_cell,':',0); 
		$get_xxx+=$width_cell3;                           
		$pdf->SetXY($get_xxx, $get_yyy);            
		
		$pdf->MultiCell($width_cell2,$height_cell,$data['NextStop'],0,'L'); 
		$get_xxx+=$width_cell2;                           
		$pdf->SetXY($get_xxx, $get_yyy); 
		
		$pdf->Ln();
		$get_xxx=$start_awal;                      
		$get_yyy+=$height_cell; 
		
		$pdf->SetXY($get_xxx, $get_yyy); 

		$pdf->MultiCell($width_cell,$height_cell,'From',0); 
		$get_xxx+=$width_cell;                           
		$pdf->SetXY($get_xxx, $get_yyy);    
		
		$pdf->MultiCell($width_cell3,$height_cell,':',0); 
		$get_xxx+=$width_cell3;                           
		$pdf->SetXY($get_xxx, $get_yyy);               
		
		$pdf->MultiCell($width_cell2,$height_cell,$data['Pengirim'],0,'L'); 
		$get_xxx+=$width_cell2;                           
		$pdf->SetXY($get_xxx, $get_yyy);   */
		
        /*$pdf->Cell(25,6,'Package No',0,0);
		$pdf->Cell(5,6,':',0,0);
        $pdf->Cell(85,6,$data['No'],0,1);		
		$pdf->Cell(40);
		$pdf->Cell(25,6,'Date',0,0);
		$pdf->Cell(5,6,':',0,0);
        $pdf->Cell(85,6,$data['Tanggal'],0,1);
		$pdf->Cell(40);
        $pdf->Cell(25,6,'To',0,0);
		$pdf->Cell(5,6,':',0,0);
        $pdf->MultiCell(85,6,$data['NextStop']);
		$pdf->Cell(40);
        $pdf->Cell(25,6,'From',0,0);
		$pdf->Cell(5,6,':',0,0);
        $pdf->MultiCell(85,6,$data['Pengirim']);*/
				        
        $pdf->Output();
    }	
	
	public function cancel() {
		$data = $this->input->post("data");
		
		$ret = $this->msent->cancel($data);
		
		if ($ret["status"]==1){
			$res = $this->common_model->response("success","Package has been cancelled and moved to Draft");			
		}else{	
			$message = isset($ret["message"])?$ret["message"]:"Save Failed";
			$res = $this->common_model->response("error",$message);
		}
		
		echo json_encode($res);
	}
	
	
}