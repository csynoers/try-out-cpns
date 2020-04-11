<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception; 

class Siswa extends MY_Controller{
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
	function __construct(){
        parent::__construct();
		
		if( !$this->session->userdata('root') ){
			redirect(base_url('admin@ics'));
        }

		
		$this->load->model('M_users');
		
		$this->load->helper('rupiah_helper');

		# require php mailer
        require APPPATH.'libraries/phpmailer/src/Exception.php';
        require APPPATH.'libraries/phpmailer/src/PHPMailer.php';
		require APPPATH.'libraries/phpmailer/src/SMTP.php';
    }

    public function mendaftar()
    {
        $data['rows'] = $this->M_users->mendaftar();
		$this->render_pages( 'siswa/mendaftar', $data );
    }

    public function terdaftar()
    {
        $data['rows'] = $this->M_users->terdaftar();
		$this->render_pages( 'siswa/terdaftar', $data );
    }

    public function konfirmasi()
    {
		if ( $this->uri->segment(3) ) {
			# code...
			$row_user_configs = $this->M_users->mendaftar( $this->uri->segment(3) )[0];

			$data['action']   		= base_url();		
			$data['data_action']  	= base_url() .'siswa/konfirmasi_store/' .$row_user_configs->exam_user_config_id;		
			
			$controlBtnKOnfirmasi = NULL;
			if ( $this->uri->segment(4) ) {
				$controlBtnKOnfirmasi = 'hide';
			}
			$html= "
				<form action='javascript:void(0)' data-action='{$data['data_action']}' role='form' method='post' enctype='multipart/form-data'>
					<div class='input-group mb-3'>
						<div class='input-group-prepend'>
							<span class='input-group-text'>Sudah melakukan pembayaran sebesar</span>
						</div>
						<span class='form-control text-right'>Rp. ".rupiah($row_user_configs->total_payment)."</span>
						<div class='input-group-prepend'>
							<span class='input-group-text text-info'>(tidak kurang tidak lebih)</span>
						</div>
					</div>
					<div class='form-group'>
						<label>Bank transfer ke :</label>
						<span class='form-control'>{$row_user_configs->bank_transfer}</span>
					</div>
					<div class='form-group'>
						<label>Bukti pembayaran :</label>
						<img class='img-fluid mx-auto d-block' src='".base_url("../src/proof_payments/{$row_user_configs->proof_payment}")."' alt='Bukti Pembayaran'>
					</div>
					<input type='hidden' name='total_payment' value='{$row_user_configs->total_payment}'>
					<button type='submit' class='btn btn-primary btn-block {$controlBtnKOnfirmasi}'>Konfirmasi Pembayaran</button>
				</form>
			";
			echo $html;
		} else {
			# code...
			$data['rows'] = $this->M_users->konfirmasi();
			$this->render_pages( 'siswa/konfirmasi', $data );
		}
		
	}
	
	public function konfirmasi_store()
	{
		$this->M_users->post = $this->input->post();
		$this->M_users->post['token'] = (int) date('ymd').substr($this->input->post('total_payment'), -3);
		if ( $this->M_users->konfirmasi_store($this->uri->segment(3)) ) {
			# send notif email to user
			$user_config = $this->M_users->users_by_exam_id( $this->uri->segment(3) )[0];
			$user_config->imageSrc = base_url('src/proof_payments/'.$user_config->proof_payment);
			$html = "
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
								<h2 style='margin-top: 0px'>Hi {$user_config->fullname},</h2>
								Token anda : {$user_config->token}<br>
								<table style='width: 100%;border-spacing: unset;'>
									<tr>
										<td width='25%' style='padding: 10px 10px;border: 1px solid #ddd;'>NIK </td>
										<td style='padding: 10px 10px;border: 1px solid #ddd;'> {$user_config->nik} </td>
									</tr>
									<tr>
										<td width='25%' style='padding: 10px 10px;border: 1px solid #ddd;'>Nama Lengkap </td>
										<td style='padding: 10px 10px;border: 1px solid #ddd;'> {$user_config->fullname} </td>
									</tr>
									<tr>
										<td width='25%' style='padding: 10px 10px;border: 1px solid #ddd;'>Username </td>
										<td style='padding: 10px 10px;border: 1px solid #ddd;'> {$user_config->username} </td>
									</tr>
									<tr>
										<td width='25%' style='padding: 10px 10px;border: 1px solid #ddd;'>Email </td>
										<td style='padding: 10px 10px;border: 1px solid #ddd;'> <a href='mailto:{$user_config->email}' target='_blank'>{$user_config->email}</a> </td>
									</tr>
									<tr>
										<td width='25%' style='padding: 10px 10px;border: 1px solid #ddd;'>Telepon </td>
										<td style='padding: 10px 10px;border: 1px solid #ddd;'> {$user_config->telp} </td>
									</tr>
									<tr>
										<td width='25%' style='padding: 10px 10px;border: 1px solid #ddd;'>Bank Transfer </td>
										<td style='padding: 10px 10px;border: 1px solid #ddd;'> {$user_config->bank_transfer} </td>
									</tr>
									<tr>
										<td width='25%' style='padding: 10px 10px;border: 1px solid #ddd;'>Nominal Transfer </td>
										<td style='padding: 10px 10px;border: 1px solid #ddd;'>Rp. ".rupiah($user_config->total_payment)." </td>
									</tr>
									<tr>
										<td width='25%' style='padding: 10px 10px;border: 1px solid #ddd;'>Bukti Transfer </td>
										<td style='padding: 10px 10px;border: 1px solid #ddd;'>
											<img src='{$user_config->imageSrc}' title='Bukti Transfer'>
										</td>
									</tr>
								</table>
							</div>
							<div style='background:#007bff;padding: 1px 0px;text-align: center;color: white;border-radius: 0px 0px 15px 15px;'>
								<p><a href='".base_url()."' target='_blank' style='color: wheat;font-weight: bold;'>Try Out CAT CPNS Bimbel IC Surabaya © ".date('Y')."</a><br> Pusat Operasional : Jl. Mulyosari Mas C3 No 19 Surabaya</p>
							</div>
						</div>
					</body>
				</html>	
			";
			$this->send_email_smtp('Konfirmasi Pembayaran',$user_config->email,$html);

			$this->msg= [
				'stats'=> 1,
				'msg'=> 'Pembayaran berhasil dikonfirmasi',
			];
		} else {
			$this->msg= [
				'stats'=> 0,
				'msg'=> 'Pembayaran gagal dikonfirmasi',
			];
		}
		echo json_encode( $this->msg );

	}
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
}