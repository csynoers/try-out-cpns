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
		// $this->debugs( $data );
	}
	/* ==================== END : FORM TAMBAH SOAL ==================== */

	/* ==================== START : FORM EDIT SOAL url{soal/edit}==================== */
	public function edit()
	{
		$data['rows']			= $this->M_question->get_question( $this->uri->segment(3) );

		// $this->debugs($data);
		foreach ($data['rows'] as $key => $value) {
			$data['action']   		= base_url();		
			$data['data_action']  	= base_url().'soal/store/'.$this->uri->segment(3);
			
			if ( $value->true_question=='same' ) {
				$value->title_jawaban = '<hr><label>Silahkan Masukan Jawaban dan pilih Jawaban Benar</label>';

				# get rows data choice where question_id
				$choices = $this->M_choice->get( $value->question_id );
				$value->choices = NULL;
				foreach ($choices as $keyChoices => $valueChoices) {
					$valueChoices->checked = ( $valueChoices->weight != 0 ) ? "checked=''" : NULL;
					$value->choices .= "
						<div class='form-check'>
							<input class='form-check-input' type='radio' name='choices_option' id='exampleRadios1' value='{$valueChoices->question_code}' required='' {$valueChoices->checked}>
							<label class='form-check-label' for='exampleRadios1'>Jawaban {$valueChoices->question_code}:</label>
							<textarea name='questions[{$valueChoices->question_code}][choice]' class='form-control mytextarea'>{$valueChoices->choice}</textarea>
						</div>
						<input type='hidden' name='questions[{$valueChoices->question_code}][choice_id]' value='{$valueChoices->choice_id}' >
						<hr>
					"; 
				}
				$value->choices .= "<input type='hidden' name='true_grade' value='{$value->true_grade}' >";
			}

			if ( $value->true_question=='different' ) {
				$value->title_jawaban = '<hr><label>Silahkan Masukan Nilai Bobot Pada Setiap Jawaban Yang Anda Masukan</label>';

				# get rows data choice where question_id
				$choices = $this->M_choice->get( $value->question_id );
				$value->choices = NULL;
				foreach ($choices as $keyChoices => $valueChoices) {
					$value->choices .= "
					<div class='form-check'>
					<div class='input-group mb-3'>
					  <div class='input-group-prepend'>
						<span class='input-group-text' id='basic-addon1'>
						  <label class='form-check-label' for='exampleRadios1'>
							<b>Jawaban {$valueChoices->question_code}:</b>
						  </label>
						</span>
					  </div>
					  <input value='{$valueChoices->weight}' type='number' name='questions[{$valueChoices->question_code}][weight]' class='form-control' placeholder='masukan bobot Jawaban {$valueChoices->question_code} disini ...' aria-label='Username' aria-describedby='basic-addon1' required=''>
					</div>
	
					<textarea name='questions[{$valueChoices->question_code}][choice]' class='form-control mytextarea'>{$valueChoices->choice}</textarea>
				  </div>
				  <input type='hidden' name='questions[{$valueChoices->question_code}][choice_id]' value='{$valueChoices->choice_id}' >
				  <hr>
					"; 
				}
			}


			$html= "
				<form action='javascript:void(0)' data-action='{$data['data_action']}' role='form' method='post' enctype='multipart/form-data'>
					<div class='form-group'>
						<label>Pertanyaan :</label>
						<textarea name='question' class='form-control mytextarea'>{$value->question}</textarea>
					</div>
					<div class='form-group'>
						<label>Kategori soal :</label>
						<input type='text' class='form-control' value='{$value->title}' readonly=''>
					</div>
					<div id='fieldChoices'>
						{$value->title_jawaban}
						{$value->choices}
					</div>
					<input type='hidden' name='true_question' value='{$value->true_question}' >
					<button type='submit' class='btn btn-primary'>Publish</button>
				</form>
			";
		}
		echo $html;
	}
	/* ==================== END : FORM EDIT SOAL ==================== */

	/**
	 * ==================== START : PROCESS DATA STORE url{soal/store/id}==================== 
	 * id = bersifat optional (jika terdapat id maka process update jika tidak, maka proses insert)
	 * */
	public function store()
	{
		if ( $this->uri->segment(3) ) { # update data
			# create messsage store variable TRUE or FALSE : default is false
			$stats = FALSE;

			# send data to class M_question Model post variable
			$this->M_question->post= $this->input->post();

			// $this->debugs($this->M_question);

			if ( $this->input->post('true_question')=='same' ) {
				# yang mempunyai bobot lebih dari 0 hanya pilihan yang benar saja
				# update table questions where question_id = $this->uri->segment(3)
				$this->M_question->store();

				# get choices all
				$choices = $this->input->post('questions');
				
				# get selected choice is true
				$choices_option = $this->input->post('choices_option');

				foreach ($choices as $keyChoices => $valueChoices) {
					$weight = ( $keyChoices==$choices_option ) ? $this->input->post('true_grade') : 0 ;
					$this->M_choice->post= [
						'choice_id' => $valueChoices['choice_id'],
						'question_code' => $keyChoices,
						'weight' => $weight,
						'choice' => $valueChoices['choice'],
					];

					# call store method: update to choices table
					$this->M_choice->store();
				}
				$stats = TRUE;
			}

			if ( $this->input->post('true_question')=='different' ) {
				# bobot berbeda setiap jawaban
				# update table questions where question_id = $this->uri->segment(3)
				$this->M_question->store();

				# get choices all
				$choices = $this->input->post('questions');

				foreach ($choices as $keyChoices => $valueChoices) {
					$this->M_choice->post= [
						'choice_id' => $valueChoices['choice_id'],
						'question_code' => $keyChoices,
						'weight' => $valueChoices['weight'],
						'choice' => $valueChoices['choice'],
					];

					# call store method: update to choices table
					$this->M_choice->store();
				}
				$stats = TRUE;
			}

			if ( $stats ) {
				$this->msg= [
					'stats'=> 1,
					'msg'=> 'Data Berhasil Diubah',
				];
			} else {
				$this->msg= [
					'stats'=> 0,
					'msg'=> 'Data Gagal Diubah',
				];
			}
			echo json_encode( $this->msg );
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
