<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Soal extends MY_Controller {

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
		$this->load->model(['M_question','M_question_categories']);
	}

	/* ==================== START : DAFTAR SOAL ==================== */
	public function index()
	{
		$data['rows'] = $this->M_question->get_question();
		$this->render_pages( 'question', $data );
	}
	/* ==================== END : DAFTAR SOAL ==================== */

	/* ==================== START : FORM TAMBAH SOAL ==================== */
	public function add()
	{
		$data['action'] = base_url();		
		$data['options_kategori_soal'] = $this->options_kategori_soal();

		$html= "
			<form action='admin/data-admin-store' role='form' id='addNew' method='post' enctype='multipart/form-data'>
				<div class='form-group'>
					<label>Pertanyaan :</label>
					<textarea name='question' class='form-control mytextarea'></textarea>
				</div>
				<div class='form-group'>
					<label>Kategori soal :</label>
					{$data['options_kategori_soal']}
				</div>
				<div id='fieldChoices'></div>
				<button type='submit' class='btn btn-primary'>Publish</button>
			</form>
        ";
		echo $html;

		/* for debug only : uncomment text below */
		$this->debugs( $data );
	}
	/* ==================== END : FORM TAMBAH SOAL ==================== */

	/* ==================== START : SELECT OPTIONS KATEGORI SOAL ==================== */
	protected function options_kategori_soal()
	{
		$data[] = "<option value='' selected disabled> -- Pilih kategori soal -- </option>"; 
		foreach ($this->M_question_categories->get_question_categories() as $key => $value) {
			$data[] = "<option value='{$value->question_categori_id}' data-count-of-choice='{$value->count_of_choices}'>{$value->title}</option>";
		}
		$data = implode('',$data);
		$data = "
			<select class='form-control' id='optionsKategoriSoal' required>{$data}</select>
		";

		return $data;
	}
	/* ==================== END : SELECT OPTIONS KATEGORI SOAL ==================== */




}
