<?php namespace App\Libraries;

//use \OAuth2\Storage\Pdo;
use \App\Libraries\CustomOauthStorage;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SendEmail{


  public function sendEmail($layout,$data){
    
    $mail = new PHPMailer(true);  
    // print_r($data);
	// die();
    try {

      	$mail->isSMTP();                                            //Send using SMTP
      	$mail->Host         = 'smtp.gmail.com';
		$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		$mail->Username     = 'kalbarastramotor@gmail.com';
		$mail->Password     = 'gxfwkzoctxqihqur';                           //SMTP password
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		$mail->setFrom('no-replay@damkar.id', 'Damkar.id');
		$mail->addAddress($data['email'],$data['nama']);     //Add a recipient
		$mail->addReplyTo('replay@gmail.com', 'Information');

		// $mail->addCC('cc@example.com');
		// $mail->addBCC('bcc@example.com');
	
		//Attachments
		// $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
		// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
	
		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = 'Pegajuan event '.$data['event_name'];
		$mail->Body    = $layout;
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	
		$send = $mail->send();
		print_r($send);
		die();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
  }
}
