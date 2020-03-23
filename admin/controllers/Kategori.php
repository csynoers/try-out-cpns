<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends MY_Controller {

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
    }
    
    /* ==================== START : KATEGORI SOAL  ==================== */
	public function soal()
	{
        # load question_categories Model
        $this->load->model('M_question_categories');

        switch ( empty($this->uri->segment(3)) ? NULL : $this->uri->segment(3) ) {
            case 'add':
				# code...
				$this->soal_add();
				break;
				
            case 'edit':
				# code...
				$this->soal_edit();
				break;
				
            case 'store':
				$this->soal_store();
				break;
				
            case 'delete':
				# code...
				$this->soal_delete;
                break;
            
            default:
                # code...
                $rows = $this->M_question_categories->get_question_categories();
                $this->content = [
                    'rows' => $rows
                ];
                $this->view = 'question_categories';
                $this->render_pages();
                break;
        }
        
	}
	public function soal_add()
	{
		$this->data['data_action']  = base_url() .'kategori/soal/store';
		$this->html= "
			<form action='javascript:void(0)' data-action='{$this->data['data_action']}' role='form' method='post' enctype='multipart/form-data'>
				<div class='form-group'>
					<label>Nama kategori soal</label>
					<input type='text' name='title' class='form-control' placeholder='Ketikan nama kategori soal disini ...' required=''>
				</div>
				<button type='submit' class='btn btn-primary'>Publish</button>
			</form>
        ";
		echo $this->html;

		/* for debug only : uncomment text below */
		$this->debugs();
	}
	/* ==================== START : FORM EDIT KATEGORI SOAL url{kategori/soal/edit/id} ==================== */
	public function soal_edit()
	{
		$this->data['rows']			= $this->M_question_categories->get_question_categories( $this->uri->segment(4) );
		foreach ($this->data['rows'] as $key => $value) {		
			$this->data['data_action']  = base_url().'kategori/soal/store/'.$this->uri->segment(4);		
			$this->html= "
				<form action='javascript:void(0)' data-action='{$this->data['data_action']}' role='form' id='addNew' method='post' enctype='multipart/form-data'>
					<div class='form-group'>
						<label>Title</label>
						<input value='{$value->title}' type='text' name='title' class='form-control' placeholder='Type the title page here ...' required=''>
					</div>
					<button type='submit' class='btn btn-primary'>Publish</button>
				</form>
			";
		}
		echo $this->html;

		/* for debug only : uncomment text below */
		$this->debugs();
	}
	/* ==================== END : FORM EDIT KATEGORI SOAL ==================== */

	/**
	 * ==================== START : PROCESS DATA KATEGORI SOAL STORE url{kategori/soal/store/id}==================== 
	 * id = bersifat optional (jika terdapat id maka process update jika tidak, maka proses insert)
	 * */
	public function soal_store()
	{
		if ( $this->uri->segment(4) ) { # update data
			$this->M_question_categories->post= $this->input->post();
			if ( $this->M_question_categories->store() ) {
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
			$this->M_question_categories->post= $this->input->post();
			if ( $this->M_question_categories->store() ) {
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
	/* ==================== END : PROCESS DATA KATEGORI SOAL STORE ==================== */

	public function soal_delete()
	{
		echo 'delete kategori soal baru';
	}
	/* ==================== END : KATEGORI SOAL  ==================== */
}
