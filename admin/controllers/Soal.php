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
		$this->load->model(['M_question','M_question_categories','M_choice']);
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
		$data['data_action']  	= base_url() .'soal/store';			
		$data['options_kategori_soal'] = $this->options_kategori_soal();

		$html= "
			<form action='javascript:void(0)' data-action='{$data['data_action']}' role='form' method='post' enctype='multipart/form-data'>
				<div class='form-group'>
					<label>Pertanyaan :</label>
					<textarea name='question' class='form-control mytextarea'>Masukan Pertanyaan disini ...</textarea>
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

	/**
	 * ==================== START : PROCESS DATA STORE url{soal/store/id}==================== 
	 * id = bersifat optional (jika terdapat id maka process update jika tidak, maka proses insert)
	 * */
	public function store()
	{
		if ( $this->uri->segment(3) ) { # update data
			// $this->M_pages->post= $this->input->post();
			// if ( $this->M_pages->store() ) {
			// 	$this->msg= [
			// 		'stats'=> 1,
			// 		'msg'=> 'Data Berhasil Diubah',
			// 	];
			// } else {
			// 	$this->msg= [
			// 		'stats'=> 0,
			// 		'msg'=> 'Data Gagal Diubah',
			// 	];
			// }
			// echo json_encode( $this->msg );
		} else { # insert data
			# create messsage store variable TRUE or FALSE : default is false
			$stats = FALSE;

			$this->M_question->post= $this->input->post();

			# get data kategori soal
			$row_question_categori = $this->M_question_categories->get_question_categories( $this->input->post('question_categori_id') )[0];

			if ( $row_question_categori->true_question=='same' ) { # jika sama dengan 'same' berati pilihan benar hanya ada satu dan jawaban benar point ambilkan dari colom true grade
				# get last insert id table questions kolom question_id
				$last_insert_question_id = $this->M_question->store();

				# get choices all
				$choices = $this->input->post('choices_answer');
				
				# get selected choice is true
				$choices_option = $this->input->post('choices_option');

				foreach ($choices as $key => $value) {
					$weight = ( $key==$choices_option ) ? $row_question_categori->true_grade : 0 ;
					$this->M_choice->post= [
						'question_id' => $last_insert_question_id,
						'question_code' => $key,
						'weight' => $weight,
						'choice' => $value,
					];

					# call store method: insert to choices table
					$this->M_choice->store();
				}
				$stats = TRUE;
			}

			if ( $row_question_categori->true_question=='different' ) {
				# get last insert id table questions kolom question_id
				$last_insert_question_id = $this->M_question->store();

				# get choices all
				$choices = $this->input->post('questions');

				foreach ($choices as $key => $value) {
					$this->M_choice->post= [
						'question_id' => $last_insert_question_id,
						'question_code' => $key,
						'weight' => $value['weight'],
						'choice' => $value['choice'],
					];

					# call store method: insert to choices table
					$this->M_choice->store();
				}
				$stats = TRUE;
			}
			
			if ( $stats ) {
				$this->msg= [
					'stats'=> 1,
					'msg'=> 'Data Berhasil Ditambahkan',
				];
			} else {
				$this->msg= [
					'stats'=> 0,
					'msg'=> 'Data Gagal Ditambahkan',
				];
			}
			echo json_encode( $this->msg );
		}
	}
	/* ==================== END : PROCESS DATA STORE ==================== */

	/* ==================== START : SELECT OPTIONS KATEGORI SOAL ==================== */
	protected function options_kategori_soal()
	{
		$data[] = "<option value='' selected disabled> -- Pilih kategori soal -- </option>"; 
		foreach ($this->M_question_categories->get_question_categories() as $key => $value) {
			$data[] = "<option value='{$value->question_categori_id}' data-count-of-choice='{$value->count_of_choices}' data-true-question='{$value->true_question}'>{$value->title}</option>";
		}
		$data = implode('',$data);
		$data = "
			<select name='question_categori_id' class='form-control' id='optionsKategoriSoal' required>{$data}</select>
		";

		return $data;
	}
	/* ==================== END : SELECT OPTIONS KATEGORI SOAL ==================== */




}
