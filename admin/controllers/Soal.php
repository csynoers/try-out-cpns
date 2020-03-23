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
	protected $data; 
	protected $htmls; 
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['M_question','M_question_categories']);

		$this->data = [];
		$this->htmls = "";
	}

	/* ==================== START : DAFTAR SOAL ==================== */
	public function index()
	{
		$rows = $this->M_question->get_question();
		$this->content = [
			'rows' => $rows
		];
        $this->view = 'question';
        $this->render_pages();
        
	}
	/* ==================== END : DAFTAR SOAL ==================== */

	/* ==================== START : FORM TAMBAH SOAL ==================== */
	public function add()
	{
		$this->data['action'] = base_url();		
		$this->options_kategori_soal();

		$this->html= "
			<form action='admin/data-admin-store' role='form' id='addNew' method='post' enctype='multipart/form-data'>
				<div class='form-group'>
					<label>Pertanyaan :</label>
					<textarea name='question' class='form-control mytextarea'></textarea>
				</div>
				<div class='form-group'>
					<label>Kategori soal :</label>
					{$this->data['options_kategori_soal']}
				</div>
				<button type='submit' class='btn btn-primary'>Publish</button>
			</form>
        ";
		echo $this->html;

		/* for debug only : uncomment text below */
		$this->debugs();
	}
	/* ==================== END : FORM TAMBAH SOAL ==================== */

	/* ==================== START : SELECT OPTIONS KATEGORI SOAL ==================== */
	protected function options_kategori_soal()
	{
		$this->data['options_kategori_soal'][] = "<option value='' selected disabled> -- Pilih kategori soal -- </option>"; 
		foreach ($this->M_question_categories->get_question_categories() as $key => $value) {
			$this->data['options_kategori_soal'][] = "<option value='{$value->question_categori_id}'>{$value->title}</option>";
		}
		$this->data['options_kategori_soal'] = implode('',$this->data['options_kategori_soal']);
		$this->data['options_kategori_soal'] = "
			<select class='form-control' required>{$this->data['options_kategori_soal']}</select>
		";
	}
	/* ==================== END : SELECT OPTIONS KATEGORI SOAL ==================== */
	
	/* ==================== START : FOR DEBUG ONLY ==================== */
	protected function debugs()
	{
		echo '<pre>';
		echo strip_tags(json_encode($this->data,JSON_PRETTY_PRINT));
		echo '</pre>';
	}
	/* ==================== END : FOR DEBUG ONLY ==================== */




}
