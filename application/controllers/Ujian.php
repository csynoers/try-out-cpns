<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		/**
		 * # Check authentication 
		 * # LOAD MODEL :
		 * 1. 
		 */

		# Check authentication 
        if( ! $this->session->userdata('user') ){
            redirect(base_url());
		}
		
		# load model
		$this->load->model(['M_exam_configs','M_banks','M_exam_user_configs']);
	}

	public function index()
	{
		$data['rows'] = $this->M_exam_configs->get();

		$data['token'] = array(
			'href' => base_url('ujian/get-token'),
			'title' => 'Dapatkan Token',
			'label' => 'Dapatkan Token',
			'info' => NULL,
		);

		$row_user_configs = $this->M_exam_user_configs->get( $this->session->userdata('user')->username );
		if ( $row_user_configs ) {
			if ( $row_user_configs->exam_user_config_id ) {
				# code...
				$data['token'] = array(
					'href' => base_url("ujian/get-token/{$row_user_configs->exam_user_config_id}"),
					'title' => 'Konfirmasi Pembayaran',
					'label' => 'Konfirmasi Pembayaran',
				);
			}

			if ( $row_user_configs->proof_payment ) {
				# code...
				$data['token'] = array(
					'href' => base_url("ujian/detail-pembayaran/{$row_user_configs->exam_user_config_id}"),
					'title' => 'Detail Pembayaran untuk mendapatkan Token',
					'label' => 'Detail Pembayaran',
				);
			}

			if ( $row_user_configs->token ) {
				# code...
				$data['token']['info'] = "
					<div class='border border-warning input-group mb-3 p-1'>
						<div class='input-group-prepend'>
							<span class='input-group-text'>Token anda</span>
						</div>
						<input id='token' type='text' class='form-control text-center' value='{$row_user_configs->token}'>
						<div class='input-group-prepend'>
							<span class='input-group-text btn' title='Copy Token' onclick='copy_token()'>Copy Clipboard</span>
						</div>
					</div>
				";
			}
		}

		$this->render_pages( 'try_out',$data );
	}

	public function get_token()
	{
		$this->load->helper('rupiah_helper');
		if ( $this->uri->segment(3) ) {
			# code...
			$row_user_configs = $this->M_exam_user_configs->get( $this->session->userdata('user')->username );

			$data['action']   		= base_url();		
			$data['data_action']  	= base_url() .'ujian/store/' .$row_user_configs->exam_user_config_id;		
			
			
			$html= "
				<form action='javascript:void(0)' data-action='{$data['data_action']}' role='form' method='post' enctype='multipart/form-data'>
					<div class='input-group mb-3'>
						<div class='input-group-prepend'>
							<span class='input-group-text'>Sudah melakukan pembayaran sebesar</span>
						</div>
						<span class='form-control text-right'>Rp. ".rupiah($row_user_configs->total_payment)."</span>
						<div class='input-group-prepend'>
							<span class='input-group-text text-info'>(tidak kurang tidak lebih)</span>
						</div>
					</div>
					<div class='form-group'>
						<label>Bank transfer ke :</label>
						<span class='form-control'>{$row_user_configs->bank_transfer}</span>
					</div>
					<div class='form-group'>
						<label>Upload bukti pembayaran :</label>
						<input type='file' name='fupload' class='form-control' required=''>
					</div>
					<button type='submit' class='btn btn-primary'>Konfirmasi</button>
				</form>
			";
		} else {
			# code...
			$data['action']   		= base_url();		
			$data['data_action']  	= base_url() .'ujian/store';		
			
			foreach ($this->M_banks->get() as $key => $value) {
				$data['optradio'][] = "
					<div class='form-check'>
						<label class='form-check-label'>
							<input type='radio' class='form-check-input' name='bank' value='({$value->bank_type}) {$value->bank_number} {$value->bank_title}' required=''>({$value->bank_type}) {$value->bank_number} {$value->bank_title}
						</label>
					</div>
				";
			}
			# implode $data['optradio']
			$data['optradio'] = implode('',$data['optradio']);
			
			$html= "
				<form action='javascript:void(0)' data-action='{$data['data_action']}' role='form' method='post' enctype='multipart/form-data'>
					<div class='input-group mb-3'>
						<div class='input-group-prepend'>
							<span class='input-group-text'>Lakukan pembayaran sebesar</span>
						</div>
						<span class='form-control text-right'>Rp. ".rupiah($this->session->userdata('user')->nominal_transfer)."</span>
						<div class='input-group-prepend'>
							<span class='input-group-text text-info'>(tidak kurang tidak lebih)</span>
						</div>
					</div>
					<div class='form-group'>
						<label>Pilih Bank TRANSFER :</label>
						{$data['optradio']}
					</div>
					<button type='submit' class='btn btn-primary'>Kirim Permintaan</button>
				</form>
			";
		}

		echo $html;
	}

	public function store()
	{
		if ( $this->uri->segment(3) ) {
			# proses konfirmasi pembayaran
            # code...with upload file
            $config['upload_path']          = './src/proof_payments/';
            $config['allowed_types']        = 'jpg|png';

            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('fupload'))
            {
                $this->msg= [
                    'stats'=>0,
                    'msg'=> $this->upload->display_errors(),
                ];
            }
            else
            {
                $this->M_exam_user_configs->post= $this->input->post();
                $this->M_exam_user_configs->post['gambar']= $this->upload->data()['file_name'];

                /* start image resize */
                $this->load->helper('img');
                $this->load->library('image_lib');
                $sizes = [768,320,128];
                foreach ($sizes as $size) {
                    $this->image_lib->clear();
                    $this->image_lib->initialize( resize($size, $config['upload_path'], $this->M_exam_user_configs->post['gambar']) );
                    $this->image_lib->resize();
                }
                /* end image resize */

                if ( $this->M_exam_user_configs->store( $this->uri->segment(3) ) ) {
                    $this->msg= [
                        'stats'=>1,
                        'msg'=> 'Bukti pembayaran berhasil dikirim',
                    ];
                    
                } else {
                    $this->msg= [
                        'stats'=>0,
                        'msg'=> 'Bukti pembayaran gagal dikirim',
                    ];
                }
                
            }
			echo json_encode($this->msg);
		
		} else {
			# proses kirim permintaan
			$this->M_exam_user_configs->post = [];
			$this->M_exam_user_configs->post['bank_transfer'] = $this->input->post('bank');
			$this->M_exam_user_configs->post['username'] = $this->session->userdata('user')->username;
			$this->M_exam_user_configs->post['total_payment'] = $this->session->userdata('user')->nominal_transfer;
	
			if ( $this->M_exam_user_configs->store() ) {
				$this->msg= [
					'stats'=> 1,
					'msg'=> 'Permintaan token berhasil dikirim silahkan buka email anda dan lakukan pembayaran sesuai dengan nominal yang tertera, jika tidak masuk di menu Inbox(kotak masuk) silahkan cek di menu Spam, Terimakasih',
				];
			} else {
				$this->msg= [
					'stats'=> 0,
					'msg'=> 'Permintaan token gagal dibuat',
				];
			}
			echo json_encode( $this->msg );
		}
		
		
	}

	public function detail_pembayaran()
	{
		# code...
		$this->load->helper('rupiah_helper');
		$row_user_configs = $this->M_exam_user_configs->get( $this->session->userdata('user')->username );

		$data['action']   		= base_url();		
		$data['data_action']  	= base_url() .'ujian/store/' .$row_user_configs->exam_user_config_id;		
		
		
		$html= "
			<form action='javascript:void(0)' data-action='{$data['data_action']}' role='form' method='post' enctype='multipart/form-data'>
				<div class='input-group mb-3'>
					<div class='input-group-prepend'>
						<span class='input-group-text'>Sudah melakukan pembayaran sebesar</span>
					</div>
					<span class='form-control text-right'>Rp. ".rupiah($row_user_configs->total_payment)."</span>
					<div class='input-group-prepend'>
						<span class='input-group-text text-info'>(tidak kurang tidak lebih)</span>
					</div>
				</div>
				<div class='form-group'>
					<label>Bank transfer ke :</label>
					<span class='form-control'>{$row_user_configs->bank_transfer}</span>
				</div>
				<div class='form-group'>
					<label>Bukti pembayaran :</label>
					<img class='img-fluid mx-auto d-block' src='".base_url("src/proof_payments/{$row_user_configs->proof_payment}")."' alt='Bukti Pembayaran'>
				</div>
			</form>
		";
		echo $html;
	}

	/* ==================== START : PROSES UJIAN ==================== */
	public function proses()
	{
		if ( $this->uri->segment( 3 ) ) {
			$token = $this->uri->segment( 3 );

			$row_user_configs = $this->M_exam_user_configs->get( $this->session->userdata('user')->username );
			if ( $token == $row_user_configs->token ) {
				# code...
				$this->proses_ujian( $token );

			} else {
				# code...
				echo 'Hayoo mau ngapain :v';
			}

		} else {
			echo 'Maaf token tidak boleh kosong';
		}
	}
	protected function proses_ujian( $token )
	{		
		if ( empty($this->session->userdata('user')->examination_process) ) {
			$exam_limit_total = 0;
			$count_of_question_total = 0;
			foreach ($this->M_exam_configs->get() as $key => $value) {
				$exam_limit_total += (int) $value->exam_limit;
				$count_of_question_total += (int) $value->number_of_questions_mod;
	
				$questions = $this->M_exam_configs->proses_sql_rand($token,$value->question_categori_id,$value->number_of_questions_mod);
				foreach ($questions as $keyQuestion => $valueQuestion) {
					$choices = $this->M_exam_configs->get_choices($valueQuestion->question_id);
					foreach ($choices as $keyChoice => $valueChoice) {
						$valueQuestion->choices[] = $valueChoice;
					}
					/**
					 * if question_status same as:
					 * 0 = default Or unanswered
					 * 1 = answered
					 */
					$valueQuestion->no_soal = $keyQuestion+1;
					$valueQuestion->rules_answer = ($value->true_question=='same' ? 'Jika jawaban salah nilainya 0 dan benar 5' : 'Nilai setiap jawaban berbeda 1-5' );
					$valueQuestion->question_status = 0;
					$valueQuestion->question_weight = 0;
					$valueQuestion->question_answer_key = 0;
	
					$value->questions[] = $valueQuestion;
				}
	
				$data['rows'][] = $value;
			}
			$_SESSION['user']->examination_process = TRUE;
			$_SESSION['user']->exam_limit_total = $exam_limit_total;
			$_SESSION['user']->count_of_question_total = $count_of_question_total;

			# save $data variable to session
			$_SESSION['user']->rows = $data['rows'];
			$_SESSION['user']->token = $token;
			$_SESSION['user']->exam_start = date('Y-m-d H:i:s');
			$_SESSION['user']->exam_end = date('Y-m-d H:i:s',strtotime("+{$_SESSION['user']->exam_limit_total} minutes", strtotime($_SESSION['user']->exam_start)));
		}
		// $this->debugs($_SESSION);
		// die();

		$li = [];
		foreach ($this->session->userdata('user')->rows as $key => $value) {
			$value->active = ($key==0) ? 'active' : NULL ;
			$value->aria_selected = ($key==0) ? 'true' : false;
			$li[] = "
				<li class='nav-item'>
					<a class='nav-link {$value->active}' id='nav{$value->exam_config_id}-tab' data-toggle='tab' href='#nav{$value->exam_config_id}' role='tab' aria-controls='nav{$value->exam_config_id}' aria-selected='{$value->aria_selected}'>{$value->title}</a>
				</li>
			";
		}
		$li= implode('',$li);
		
		$tab = [];
		foreach ($this->session->userdata('user')->rows as $key => $value) {
			$value->active = ($key==0) ? 'show active' : NULL ;

			$value->navQuestion = [];
			$value->tabQuestion = [];
			foreach ($value->questions as $keyQuestion => $valueQuestion) {
				$valueQuestion->active = ($keyQuestion==0) ? 'active' : NULL ;

				$valueQuestionAnswered = NULL;
				if ( $valueQuestion->question_status == 1 ) {
					$valueQuestionAnswered = 'border border-info rounded';
				}

				$value->navQuestion[] = "
						<li class='nav-item m-1 {$valueQuestionAnswered}'>
							<a class='nav-link {$valueQuestion->active}' href='#nav{$key}{$keyQuestion}tab-pill' data-toggle='pill'>$valueQuestion->no_soal</a>
						</li>
				";

				$valueQuestion->choices_html = [];
				foreach ($valueQuestion->choices as $keyChoice => $valueChoice) {
					$valueQuestion->checked = NULL;
					if ( $valueQuestion->question_status == 1 ) {
						if ( $valueQuestion->question_answer_key == $keyChoice ) {
							$valueQuestion->checked = 'checked';
						}
					}
					$valueQuestion->choices_html[] = "
						<tr>
							<td class='row'>
							<div class=''>
								{$valueChoice->question_code}.&nbsp 
							</div>
							<div class=''>
								<div class='form-check'>
									<label class='form-check-label'>
										<input type='radio' class='form-check-input choices' name='choices[{$key}/{$keyQuestion}]' value='{$key}/{$keyQuestion}/{$keyChoice}' {$valueQuestion->checked}>{$valueChoice->choice}
									</label>
								</div>
							</div>
							</td>
						</tr>
					"; 
					
				}
				$valueQuestion->choices_html = implode('',$valueQuestion->choices_html);
				if ( $keyQuestion==0 ) {
					$valueQuestion->submitNavigation = "
					<ul class='nav nav-fill nav-pills' role='tablist'>
						<li class='nav-item'>
							<a class='nav-link {$valueQuestion->active}' href='#nav{$key}{$valueQuestion->no_soal}tab-pill' data-toggle='pill'>Lanjut</a>
						</li>
					</ul>
					";
				} else {
					$valueQuestion->submitNavigation = "
						<ul class='nav nav-fill nav-pills' role='tablist'>
							<li class='nav-item'>
								<a class='nav-link {$valueQuestion->active}' href='#nav{$key}".($keyQuestion-1)."tab-pill' data-toggle='pill'>Kembali</a>
							</li>
							<li class='nav-item'>
								<a class='nav-link {$valueQuestion->active}' href='#nav{$key}{$valueQuestion->no_soal}tab-pill' data-toggle='pill'>Lanjut</a>
							</li>
						</ul>
					";
				}
				$value->tabQuestion[] = "
						<div id='nav{$key}{$keyQuestion}tab-pill' class='container tab-pane {$valueQuestion->active}'>
							<hr>
							<label class='font-weight-normal text-muted'>
								Soal ke <b>{$valueQuestion->no_soal}</b> dari <b>{$value->number_of_questions}</b>
							</label>
							<label class='float-right font-italic font-weight-light text-muted'>
								<b>{$valueQuestion->rules_answer}</b>
							</label><br>
							<label>{$valueQuestion->no_soal}. Soal</label><br>
							<label class='text-black-50 text-muted'>
								Kategori: {$value->title}
							</label><br>
							<div class='text-justify font-weight-normal'>
								{$valueQuestion->question}
								<div class='card mt-3'>
									<div class='card-body'>
										<table class='table table-borderless table-hover'>
											<tbody>
												{$valueQuestion->choices_html}
											</tbody>
										</table>
									</div>
								</div>
							</div>
							{$valueQuestion->submitNavigation}
						</div>
				";
			}
			$value->navQuestion = implode('',$value->navQuestion);
			$value->tabQuestion = implode('',$value->tabQuestion);

			$tab[] = "
				<div class='tab-pane fade {$value->active}' id='nav{$value->exam_config_id}' role='tabpanel' aria-labelledby='nav{$value->exam_config_id}-tab'>
					<!-- Nav pills -->
					<ul class='mt-3 nav nav-pills' role='tablist'>
						{$value->navQuestion}
					</ul>
					<!-- Tab panes -->
					<div class='tab-content'>
						{$value->tabQuestion}
					</div>
				</div>
			";
		}
		$tab= implode('',$tab);
		
		$data['nav']['ul'] = "
			<ul class='nav nav-tabs' id='myTab' role='tablist'>
				{$li}
			</ul>
		";

		$data['nav']['tab'] = "
			<div class='tab-content' id='myTabContent'>
				{$tab}
			</div>
		";

		$data['navtab'] = implode('',$data['nav']); 

		$data['html'] = "
			<table class='table table-bordered font-weight-normal'>
				<tbody>
					<tr>
						<td class='w-50'>Total Soal</td>
						<td>".$this->session->userdata('user')->count_of_question_total." Soal</td>
					</tr>
					<tr>
						<td>Batas Waktu Pengerjaan</td>
						<td>".$this->session->userdata('user')->exam_limit_total." Menit (<span id='examLimit'>0</span>)</td>
					</tr>
					<tr>
						<td>Sisa Waktu</td>
						<td><span id='countDown' data-start='".$this->session->userdata('user')->exam_start."' data-end='".$this->session->userdata('user')->exam_end."'>0</span></td>
					</tr>
				</tbody>
			</table>
			{$data['navtab']}
		";

		echo $data['html'];
		// print_r($data);
		// $this->debugs( $data );
		// $this->debugs( $this->M_exam_configs->proses_sql_rand($token,$kategori) );
	}
	/* ==================== END : PROSES UJIAN ==================== */

	public function update_session(){
		$data['question_status'] = 1;
		$data['question_weight'] = $_SESSION['user']->rows[$this->uri->segment(3)]->questions[$this->uri->segment(4)]->choices[$this->uri->segment(5)]->weight;
		$data['question_answer_key'] = $this->uri->segment(5);

		# update questions sessions = question_status
		$_SESSION['user']->rows[$this->uri->segment(3)]->questions[$this->uri->segment(4)]->question_status = $data['question_status'];

		# update questions sessions = question_weight
		$_SESSION['user']->rows[$this->uri->segment(3)]->questions[$this->uri->segment(4)]->question_weight = $data['question_weight'];

		# update questions sessions = question_answer_key
		$_SESSION['user']->rows[$this->uri->segment(3)]->questions[$this->uri->segment(4)]->question_answer_key = $data['question_answer_key'];

		// print_r($data);
		print_r($_SESSION);
	}
}
