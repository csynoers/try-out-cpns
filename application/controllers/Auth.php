<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

        # require php mailer
        require APPPATH.'libraries/phpmailer/src/Exception.php';
        require APPPATH.'libraries/phpmailer/src/PHPMailer.php';
        require APPPATH.'libraries/phpmailer/src/SMTP.php';

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
            $this->session->set_flashdata('msg', 'Maaf! data nik/username/email/telp sudah pernah digunakan silahkan coba lagi! atau silahkan klik link <a href="'.base_url('forget-password').'">Saya lupa password</a> ');
            // redirect(base_url('auth/register'));

        } else {
            # jika belum ada jalankan proses store data
            $this->M_auth->store();
            
            $data['pesan'] = "
                <html>
                    <head>
                        <title>Try Out CPNS</title>
                    </head>
                    <body style='background: #eee;'>
                        <div style='padding: 50px;'>
                            <div style='background:#007bff;padding: 1px 0px;text-align: center;color: white;border-radius: 15px 15px 0px 0px;'>
                                <h1>Try Out CAT CPNS</h1>
                            </div>
                            <div style='background: #fff;padding: 30px 30px;'>
                                <h2 style='margin-top: 0px'>Hi {$post['fullname']},</h2>
                                <p>Username Try Out kamu adalah : {$post['nik']} / {$post['username']} / <a href='mailto:{$post['email']}' target='_blank'>{$post['email']}</a> / {$post['telp']} (pilih salah satu saja)</p>
                                <a href='".base_url('email-confirmation?token='. $this->encryption->encrypt($post['email']))."' target='_blank' style='background-color: #39a300;color: #fff;padding: 10px 12px;text-decoration: none;'>Klik disini untuk melakukan konfirmasi email</a>
                            </div>
                            <div style='background:#007bff;padding: 1px 0px;text-align: center;color: white;border-radius: 0px 0px 15px 15px;'>
                                <p><a href='".base_url()."' target='_blank' style='color: wheat;font-weight: bold;'>Try Out CAT CPNS Bimbel IC Surabaya © ".date('Y')."</a><br> Pusat Operasional : Jl. Mulyosari Mas C3 No 19 Surabaya</p>
                            </div>
                        </div>
                    </body>
                </html>	
            ";

            $this->send_email_smtp('Konfirmasi email ',$post['email'],$data['pesan']);
            echo ("<script>window.alert('Terimakasih telah mendaftar, data berhasil dikirim. Silahkan buka email anda dan klik tautan yang kami kirimkan');window.location.href='".base_url()."';</script>");
        }
        
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
                    if ( $row->last_login ) {
                        # update last login
                        $this->M_auth->update_last_login( $row->username );
                        $row  = $this->M_auth->check_already_exist()->row();
    
                        $row->nominal_transfer = 100000+rand ( 1 , 999 );
                        $this->session->set_userdata([ "{$row->level}" => $row ]);
                        redirect( base_url() );
                    } else {
                        $this->session->set_flashdata('msg', 'Maaf anda belum melakukan konfirmasi email, silahkan buka email kamu terlebih dahulu dan klik tautan konfirmasi email.');
                        redirect( base_url('auth') );
                    }
                    
                }

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
            $row      = $cek_users->row();
            // $this->debugs($row);
            $data['pesan'] = "
                <html>
                    <head>
                        <title>Try Out CPNS</title>
                    </head>
                    <body style='background: #eee;'>
                        <div style='padding: 50px;'>
                            <div style='background:#007bff;padding: 1px 0px;text-align: center;color: white;border-radius: 15px 15px 0px 0px;'>
                                <h1>Try Out CAT CPNS</h1>
                            </div>
                            <div style='background: #fff;padding: 30px 30px;'>
                                <h2 style='margin-top: 0px'>Hi {$row->fullname},</h2>
                                <p>Username Try Out kamu adalah : <a href='mailto:{$row->email}' target='_blank'>{$row->email}</a></p>
                                <a href='".base_url('reset-password?token='. $this->encryption->encrypt($row->username))."' target='_blank' style='background-color: #39a300;color: #fff;padding: 10px 12px;text-decoration: none;'>Klik disini untuk mengganti password</a>
                                <p style='margin-bottom: 0px'>Jika Anda mengetahui kata sandi untuk akun ini, Anda dapat masuk dengan nama pengguna di atas.</p>
                            </div>
                            <div style='background:#007bff;padding: 1px 0px;text-align: center;color: white;border-radius: 0px 0px 15px 15px;'>
                                <p><a href='".base_url()."' target='_blank' style='color: wheat;font-weight: bold;'>Try Out CAT CPNS Bimbel IC Surabaya © ".date('Y')."</a><br> Pusat Operasional : Jl. Mulyosari Mas C3 No 19 Surabaya</p>
                            </div>
                        </div>
                    </body>
                </html>	
            ";

            // echo $data['pesan'];
            // echo $this->encryption->decrypt( '8a12e43cd69b8b7472c2318fe954e5eabf9f7033082b752b0e67390cac2f01c71fa2b58036bb833926b6de50db255a4e06ebfa88f5589337f1557f3e19fd98222JQGclF5DUB9lEnoMRcUEIpBlcvE' );
            if ( $this->send_email_smtp('Reset Password',$post['email'],$data['pesan']) ) {
                # code...
                echo ("<script>window.alert('Permintaan reset password berhasil dikirim, Silahkan buka email {$post['email']} untuk mendapatkan link reset password');window.location.href='".base_url()."';</script>");
            } else {
                $this->session->set_flashdata('msg', 'Maaf! link gagal dikirimkan ke email : '.$post['email']);
                redirect(base_url('forget-password'));
            };
            /* ==================== END :: SEND EMAIL ==================== */
        } else {
            $this->session->set_flashdata('msg', 'Maaf! User dengan Email: '.$post['email'].' tidak ditemukan');
            redirect(base_url('forget-password'));
        }
        
        // $this->debugs();
    }
    /*  */

    protected function send_email_smtp($subject,$to,$html)
    {
        /* ==================== START :: SEND EMAIL ==================== */

        // PHPMailer object
        $response = false;
        $mail = new PHPMailer();                     
            
        // SMTP configuration
        $mail->isSMTP();

        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;

        $mail->Host     = 'smtp.gmail.com'; //sesuaikan sesuai nama domain hosting/server yang digunakan
        $mail->SMTPAuth = true;
        $mail->Username = 'jogjasitesinur@gmail.com'; // user email
        $mail->Password = 'Sinur12345'; // password email
        $mail->SMTPSecure = 'tls';
        $mail->Port     = 587; // GMail - 465/587/995/993

        $mail->setFrom('pinsus2017surabaya@gmail.com', 'Try Out CAT CPNS'); // user email
        $mail->addReplyTo('pinsus2017surabaya@gmail.com', ''); //user email

        // Add a recipient
        $mail->addAddress($to); //email tujuan pengiriman email

        // Email subject
        $mail->Subject = $subject; //subject email

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = $html; // isi email
        $mail->Body = $mailContent;

        // Send email
        if(!$mail->send()){
            // echo 'Message could not be sent.';
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
            $response = FALSE;
        }else{
            // echo 'Message has been sent';
            $response = TRUE;
        }
        /* ==================== END :: SEND EMAIL ==================== */
        return $response;
    }

    public function reset_password()
    {
        if ( $this->input->get('token') ) {
            $data['token'] = $this->input->get('token');
            $this->load->view('reset_password',$data);
        } else {
            echo ("<script>window.alert('Maaf anda belum melakukan permintaan lupa password');window.location.href='".base_url('forget-password')."';</script>");
        }
    }
    public function process_reset_password()
    {
        $post = $this->input->post();
        $post['username'] = $this->encryption->decrypt( $post['token'] );
        $post['password'] = $this->encryption->encrypt( $post['password'] );
        
        # send to model
        $this->M_auth->post = $post;

        if ( $this->M_auth->reset_password() ) {
            # code...
            echo ("<script>window.alert('Password baru berhasil dibuat silahkan melakukan login untuk mencobanya');window.location.href='".base_url('auth')."';</script>");
        } else {
            echo ("<script>window.alert('Maaf! password gagal diubah silahkan kirim ulang permintaan lupa password');window.location.href='".base_url('forget-password')."';</script>");
        };

    }
}