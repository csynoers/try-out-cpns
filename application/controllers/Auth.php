<?php
class Auth extends MY_Controller{
 
    function __construct(){
        parent::__construct();
        /**
         * LOAD MODEL:
         * 1. M_auth (get data from users table)
         */		
        $this->load->model('M_auth');

        # load encrypt library
        $this->load->library('encryption');
        $this->encryption->initialize(
            array(
                'cipher' => 'aes-256',
                'mode' => 'ctr',
                'key' => '3s0c9m7@gmail.com'
            )
        );

    }

    /* ==================== START : LOGIN PAGE url{auth/index} ==================== */
    public function index(){
        $csrf = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash()
        );

        $this->load->view('login',$csrf);
    }
    /* ==================== END : LOGIN PAGE url{auth/index} ==================== */

    /* ==================== START : REGISTER PAGE url{auth/register} ==================== */
    public function register(){
        $csrf = array(
            'csrf_name' => $this->security->get_csrf_token_name(),
            'csrf_hash' => $this->security->get_csrf_hash()
        );

        $this->load->view('register',$csrf);
    }
    /* ==================== END : REGISTER PAGE url{auth/register} ==================== */

    public function store()
    {
        # filter xss clean before send to model
        $post = array(
            'nik' => $this->security->xss_clean($this->input->post('nik')),
            'fullname' => $this->security->xss_clean($this->input->post('fullname')),
            'email' => $this->security->xss_clean($this->input->post('email')),
            'telp' => $this->security->xss_clean($this->input->post('telp')),
            'username' => $this->security->xss_clean($this->input->post('username')),
            'password' => $this->encryption->encrypt($this->input->post('password')),
        );

        # send $post variable to model
        $this->M_auth->post = $post;

        # cek apakah user sudah dengan nik/username/email/telp sudah ada sebelumnya
        if ( $this->M_auth->check_already_exist() > 0 ) {
            $this->session->set_flashdata('msg', 'Maaf! data nik/username/email/telp sudah pernah digunakan silahkan coba lagi! atau silahkan klik link <a href="#">Saya lupa password</a> ');
            redirect(base_url('auth/register'));

        } else {
            # jika belum ada jalankan proses store data
            $this->debugs( $this->M_auth->store() );
            
        }
        

        $this->debugs($this->M_auth);
    }

    function process(){
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
        
        $where_users = array(
            'username' => $username,
            'password' => $password
        );
        
        $cek_users  = $this->M_auth->check_auth("users",$where_users)->num_rows();
        // print_r($cek_users);
        // die();
        
        if ( $cek_users > 0 ) {
            # code...
            $row  = $this->M_auth->check_auth("users",$where_users)->row();
            $data_session = array(
                'username'  => $username,
                'password'  => $password,
                'level'     => $row->level,
                'status'     => 'login',
            );
            
            $this->session->set_userdata($data_session);
            $url=[
                'admin' => 'admin',
                'guru' => 'guru',
                'guru_kep_lab' => 'guru-kep-lab',
                'siswa' => 'siswa',
            ];
            redirect(base_url( $url[$this->session->userdata('level')] ));
        }
        
        else{
            
            $this->session->set_flashdata('msg', 'Maaf! Username atau Password anda salah!');
            redirect(base_url('auth'));
        }
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url('auth'));
    }
}