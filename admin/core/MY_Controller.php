<?php
class MY_Controller extends CI_Controller{
	function __construct(){
		parent::__construct();
    }
    function render_pages()
    {
        $this->load->view('header');
        $this->load->view('nav');
        $this->load->view($this->view, (empty($this->content)? [] : $this->content ) );
        $this->load->view('footer');
    }

    /* ==================== START : FOR DEBUG ONLY ==================== */
	public function debugs()
	{
		echo '<pre>';
		echo strip_tags(json_encode($this->data,JSON_PRETTY_PRINT));
		echo '</pre>';
	}
	/* ==================== END : FOR DEBUG ONLY ==================== */
}