<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends MY_Controller {

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
		$this->load->model('M_pages');
	}
	/* ==================== START : DEFAULT PAGE url{pages/index}==================== */
	public function index()
	{
		$rows = $this->M_pages->get_pages();
		$this->content = [
			'rows' => $rows
		];
        $this->view = 'pages';
        $this->render_pages();
        
	}
	/* ==================== END : DEFAULT PAGE ==================== */

	/* ==================== START : FORM ADD PAGES url{pages/add}==================== */
	public function add()
	{
		$this->data['action']   	= base_url();		
		$this->data['data_action']  = base_url() .'pages/store';		
		$this->data['slug']			= "{$_SERVER['SERVER_NAME']}/pages/";
		$this->html= "
			<form action='javascript:void(0)' data-action='{$this->data['data_action']}' role='form' method='post' enctype='multipart/form-data'>
				<div class='form-group'>
					<label>Title</label>
					<input type='text' name='title' class='form-control' placeholder='Type the title page here ...' required=''>
				</div>
				<div class='form-group'>
					<label>Slug <small class='text-info'>*)digunakan untuk seo format penulisan huruf kecil semua gunakan tanda '-' untuk memisahkan kata </small></label>
					<div class='input-group mb-3'>
						<div class='input-group-prepend'>
							<span class='input-group-text'><i class='fa fa-link'></i></span>
						</div>
						<div class='input-group-prepend'>
							<span class='input-group-text'>{$this->data['slug']}</span>
						</div>
						<input type='text' name='slug' class='form-control' placeholder='ex: title-page' required=''>
					</div>
				</div>
				<div class='form-group'>
					<label>Deskripsi</label>
					<textarea name='description' class='form-control mytextarea'></textarea>
				</div>
				<button type='submit' class='btn btn-primary'>Publish</button>
			</form>
        ";
		echo $this->html;

		/* for debug only : uncomment text below */
		$this->debugs();
	}
	/* ==================== END : FORM ADD PAGES ==================== */

	/* ==================== START : FORM EDIT PAGES url{pages/edit}==================== */
	public function edit()
	{
		$this->data['rows']			= $this->M_pages->get_pages( $this->uri->segment(3) );
		foreach ($this->data['rows'] as $key => $value) {
			$this->data['action']   	= base_url();		
			$this->data['data_action']  = base_url().'pages/store/'.$this->uri->segment(3);		
			$this->data['slug']			= "{$_SERVER['SERVER_NAME']}/pages/";
			$this->html= "
				<form action='javascript:void(0)' data-action='{$this->data['data_action']}' role='form' id='addNew' method='post' enctype='multipart/form-data'>
					<div class='form-group'>
						<label>Title</label>
						<input value='{$value->title}' type='text' name='title' class='form-control' placeholder='Type the title page here ...' required=''>
					</div>
					<div class='form-group'>
						<label>Slug <small class='text-info'>*)digunakan untuk seo format penulisan huruf kecil semua gunakan tanda '-' untuk memisahkan kata </small></label>
						<div class='input-group mb-3'>
							<div class='input-group-prepend'>
								<span class='input-group-text'><i class='fa fa-link'></i></span>
							</div>
							<div class='input-group-prepend'>
								<span class='input-group-text'>{$this->data['slug']}</span>
							</div>
							<input value='{$value->slug}' type='text' name='slug' class='form-control' placeholder='ex: title-page' required=''>
						</div>
					</div>
					<div class='form-group'>
						<label>Deskripsi</label>
						<textarea name='description' class='form-control mytextarea'>{$value->description}</textarea>
					</div>
					<button type='submit' class='btn btn-primary'>Publish</button>
				</form>
			";
		}
		echo $this->html;

		/* for debug only : uncomment text below */
		$this->debugs();
	}
	/* ==================== END : FORM EDIT PAGES ==================== */

	/**
	 * ==================== START : PROCESS DATA STORE url{pages/store/id}==================== 
	 * id = bersifat optional (jika terdapat id maka process update jika tidak, maka proses insert)
	 * */
	public function store()
	{
		if ( $this->uri->segment(3) ) { # update data
			$this->M_pages->post= $this->input->post();
			if ( $this->M_pages->store() ) {
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
			$this->M_pages->post= $this->input->post();
			if ( $this->M_pages->store() ) {
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
}
