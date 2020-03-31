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
		 * LOAD MODEL :
		 * 1. 
		 */
		$this->load->model(['M_exam_configs','M_banks','M_exam_user_configs']);
	}

	public function index()
	{
		$data['rows'] = $this->M_exam_configs->get();

		$data['token'] = array(
			'href' => base_url('ujian/get-token'),
			'title' => 'Dapatkan Token',
			'label' => 'Dapatkan Token',
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

}
