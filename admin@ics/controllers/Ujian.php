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
		$this->load->model('M_exam_configs');
	}
	/* ==================== START : PAGE KONFIGURASI UJIAN url{ujian/konfigurasi}==================== */
	public function konfigurasi()
	{
		if ( $this->uri->segment(3) ) {
			# jika segment ke-3 tidak kosong cek nilai segment ke-3 get atau post
			if ( $this->uri->segment(3)=='get' ) {
				# jika nilai segment ke-3 sama dengan get maka panggil proses edit konfigurasi
				if ( $this->uri->segment(4) ) {
					$this->konfigurasi_edit( $this->uri->segment(4) );
				}
			}

			if ( $this->uri->segment(3)=='post' ) {
				# jika nilai segment ke-3 sama dengan get maka panggil proses store konfigurasi
				if ( $this->uri->segment(4) ) {
					$this->konfigurasi_store( $this->uri->segment(4) );
				}
			}

		} else {
			# jika segment ke-3 kosong
			$data['rows'] = $this->M_exam_configs->get();
			// $this->debugs($data);
			$this->render_pages( 'konfigurasi_ujian', $data );

		}
        
	}
	/* ==================== END : PAGE KONFIGURASI UJIAN url{ujian/konfigurasi}==================== */
	
	/* ==================== START : PAGE KONFIGURASI UJIAN url{ujian/konfigurasi/get/$id}==================== */
	public function konfigurasi_edit($id)
	{
		$data['rows'] = $this->M_exam_configs->get($id);

		foreach ($data['rows'] as $key => $value) {
			$data['action']   		= base_url();		
			$data['data_action']  	= base_url().'ujian/konfigurasi/post/'.$this->uri->segment(4);		

			$jenis_penilaian= ($value->true_question=='same'? 'Bobot nilai jawaban salah 0 dan jawaban benar 5' : 'Bobot nilai setiap jawaban berbeda' ) ;

			$html= "
				<form action='javascript:void(0)' data-action='{$data['data_action']}' role='form' id='addNew' method='post' enctype='multipart/form-data'>
					<div class='form-group'>
						<label>Title</label>
						<span class='form-control font-weight-normal'>{$value->title}</span>
					</div>
					<div class='form-group'>
						<label>Jenis penilaian jawaban</label>
						<span class='form-control font-weight-normal'>{$jenis_penilaian}</span>
					</div>
					<div class='form-group'>
						<label><small class='text-info'>*) Masukan batas waktu menegerjakan dan Jumlah soal dibawah ini :</small></label>
						<div class='input-group mb-3'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>Batas waktu pengerjaan</span>
							</div>
							<input min='1' value='{$value->exam_limit}' type='number' name='exam_limit' class='form-control' placeholder='Masukan batas waktu pengerjaan disini type number...' required=''>
							<div class='input-group-prepend'>
								<span class='input-group-text'>Menit</span>
							</div>
						</div>
						<div class='input-group mb-3'>
							<div class='input-group-prepend'>
								<span class='input-group-text'>Jumlah soal</span>
							</div>
							<input min='1' max='{$value->count_of_question}' value='{$value->number_of_questions}' type='number' name='number_of_questions' class='form-control' placeholder='Masukan jumlah soal disini type number...' required=''>
						</div>
					</div>
					<button type='submit' class='btn btn-primary'>Save</button>
				</form>
			";
		}
		echo $html;
		// $this->debugs($data);
	} 
	/* ==================== END : PAGE KONFIGURASI UJIAN url{ujian/konfigurasi/get/$id}==================== */

	/* ==================== START : PAGE KONFIGURASI UJIAN url{ujian/konfigurasi/post/$id}==================== */
	public function konfigurasi_store()
	{
		$this->M_exam_configs->post= $this->input->post();
		
		if ( $this->M_exam_configs->store() ) {
			$this->msg= [
				'stats'=> 1,
				'msg'=> 'Konfigurasi ujian berhasil diubah',
			];
		} else {
			$this->msg= [
				'stats'=> 0,
				'msg'=> 'Konfigurasi ujian gagal diubah',
			];
		}
		echo json_encode( $this->msg );
	}
	/* ==================== END : PAGE KONFIGURASI UJIAN url{ujian/konfigurasi/post/$id}==================== */

	/* ==================== START : PROCESS DELETE DATA ==================== */
	public function delete()
	{
		if ( $this->M_pages->delete( $this->uri->segment(3) ) ) {
			$this->msg= [
				'stats'=>1,
				'msg'=>'Data Berhasil Dihapus',
			];
		} else {
			$this->msg= [
			'stats'=>0,
				'msg'=>'Maaf Data Gagal Dihapus',
			];
		}
		echo json_encode($this->msg);
	}
	/* ==================== END : PROCESS DELETE DATA ==================== */
}
