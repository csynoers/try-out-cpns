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
        $cek_users  = $this->M_auth->check_already_exist()->num_rows();
        
        if ( $cek_users > 0 ) {
            $this->session->set_flashdata('msg', 'Maaf! data nik/username/email/telp sudah pernah digunakan silahkan coba lagi! atau silahkan klik link <a href="#">Saya lupa password</a> ');
            redirect(base_url('auth/register'));

        } else {
            # jika belum ada jalankan proses store data
            $this->debugs( $this->M_auth->store() );
            $this->session->set_flashdata('msg', 'Terimakasih telah mendaftar, data berhasil dikirim. Silahkan buka email anda dan klik tautan yang kami kirimkan untuk aktivasi pendaftaran akun anda');
            redirect( base_url() );
        }
        

        $this->debugs($this->M_auth);
    }

    function process(){
        # filter xss clean before send to model
        $post = array(
            'nik' => $this->security->xss_clean($this->input->post('username')),
            'email' => $this->security->xss_clean($this->input->post('username')),
            'telp' => $this->security->xss_clean($this->input->post('username')),
            'username' => $this->security->xss_clean($this->input->post('username')),
            'password' => $this->input->post('password'),
            // 'password' => $this->encryption->encrypt($this->input->post('password')),
        );

        # send $post variable to model
        $this->M_auth->post = $post;

        # cek apakah user sudah dengan nik/username/email/telp sudah ada sebelumnya
        $cek_users  = $this->M_auth->check_already_exist();
        if ( $cek_users->num_rows() > 0 ) {
            # code...
            $password = $post['password'];
            $row      = $cek_users->row();

            # if decrypt row->password same as $password
            if ( $this->encryption->decrypt( $row->password ) == $password ) {
                # set session user
                if ( $row->level=='root' ) {
                    # code...level ADMIN
                    $this->session->set_userdata([ "{$row->level}" => $row ]);
                    redirect( base_url('admin@ics') );
                } else {
                    # code...level USER
                    $row->nominal_transfer = 100000+rand ( 1 , 999 );
                    $this->session->set_userdata([ "{$row->level}" => $row ]);
                    redirect( base_url() );
                }
                // if ( $row->level=='user' ) {
                //     # code...level USER
                //     $row->nominal_transfer = 100000+rand ( 1 , 999 );
                //     $this->session->set_userdata([ "{$row->level}" => $row ]);
                //     redirect( base_url() );
                // } else {
                //     $this->session->set_flashdata('msg', 'username or password does not exist.');
                //     redirect(base_url('auth'));
                // }

            }

            # if decrypt row->password different with $password
            else {
                # code...
                $this->session->set_flashdata('msg', 'username or password does not exist.');
                redirect(base_url('auth'));
            }
            
        }
        
        else{
            
            $this->session->set_flashdata('msg', 'username or password does not exist.');
            redirect(base_url('auth'));
        }
        // die();
        
        // if ( $cek_users > 0 ) {
        //     # code...
        //     $row  = $this->M_auth->check_auth("users",$where_users)->row();
        //     $data_session = array(
        //         'username'  => $username,
        //         'password'  => $password,
        //         'level'     => $row->level,
        //         'status'     => 'login',
        //     );
            
        //     $this->session->set_userdata($data_session);
        //     $url=[
        //         'admin' => 'admin',
        //         'guru' => 'guru',
        //         'guru_kep_lab' => 'guru-kep-lab',
        //         'siswa' => 'siswa',
        //     ];
        //     redirect(base_url( $url[$this->session->userdata('level')] ));
        // }
        
        // else{
            
        //     $this->session->set_flashdata('msg', 'Maaf! Username atau Password anda salah!');
        //     redirect(base_url('auth'));
        // }
    }

    function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }

    /*  */
    public function forget_password()
    {
        $this->load->view('forget_password');
    }
    /*  */

    /*  */
    public function send_reset_password()
    {
        $post = array(
            'nik' => $this->security->xss_clean($this->input->post('email')),
            'email' => $this->security->xss_clean($this->input->post('email')),
            'telp' => $this->security->xss_clean($this->input->post('email')),
            'username' => $this->security->xss_clean($this->input->post('email')),
        );

        # send post to model
        $this->M_auth->post = $post;

        # cek apakah user sudah dengan nik/username/email/telp sudah ada sebelumnya
        $cek_users  = $this->M_auth->check_already_exist(); 

        if ( $cek_users->num_rows() > 0 ) {
            /* ==================== START :: SEND EMAIL ==================== */
            $data = [];
            $data['mail']['email'] = $post['email'];
            $data['mail']['link_konfirmasi'] = 'https://locdownstore.com/index.php?konfirmasi_email=' . base64_encode($post['email']);
            $data['mail']['subjek'] = "Konfirmasi Email";
            $data['mail']['pesan'] = "
                <html>
                    <head>
                        <title>TOKO LOCDOWN STORE</title>
                    </head>
                    <body>
                        <div style='
                            margin: 10% 20%;
                            background: #ddd;
                            padding: 20px;
                        '>
                            <b>Selamat anda telah terdaftar sebagai member silahkan :</b><br>
                            <a href='{$data['mail']['link_konfirmasi']}'>Login</a>
                        </div>
                    </body>
                </html>	
            ";
    
            // Always set content-type when sending HTML email
            $data['mail']['dari'] = "MIME-Version: 1.0" . "\r\n";
            $data['mail']['dari'] .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
            // More headers
            $data['mail']['dari'] .= 'From: <support@locdownstore.com>' . "\r\n";
            // mail($data['mail']['email'],$data['mail']['subjek'],$data['mail']['pesan'],$data['mail']['dari']);
            /* ==================== END :: SEND EMAIL ==================== */
            echo $data['mail']['pesan'];
            
            $this->debugs($data['mail']);
        } else {
            $this->session->set_flashdata('msg', 'Maaf! User dengan Email: '.$post['email'].' tidak ditemukan');
            redirect(base_url('forget-password'));
        }
        
        // $this->debugs();
    }
    /*  */
}