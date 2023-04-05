<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email extends BaseController {
    
    public function __construct() {
		
    }
    
    public function compose() {
    
        echo view('compose');
    
    }
    
    public function send_email() {
    
        $email          = $this->request->getPost('email');
        $subject        = $this->request->getPost('subject');
        $message        = $this->request->getPost('message');
        
        $mail = new PHPMailer(true);  
     
		try {
            // echo "<pre/>";
            // print_r($mail);
		    $mail->isSMTP();  
            // $mail->Mailer = "smtp";
		    $mail->Host         ="smtp.gmail.com";
		    $mail->SMTPAuth     = true;     
		    $mail->Username     = 'azharoce@gmail.com';
		    $mail->Password     = '#Azhar02021995';
			$mail->SMTPSecure   = 'ssl';  
			$mail->Port         = 587;  


			$mail->Subject      = $subject;
			$mail->Body         = $message;
			$mail->setFrom('azharoce@gmail.com', 'dasaads');
			
			$mail->addAddress($email);  
			$mail->isHTML(true);      
            $send = $mail->send();
			if(!$send ) {
                echo $send;
                echo "<br/>";
			    echo "Something went wrong. Please try again.";
			}
		    else {
			    echo "Email sent successfully.";
		    }

            echo "<pre>";
            echo $send ;
		    
		} catch (Exception $e) {
            echo "<pre>";
            echo $e;
		    echo "Something went wrong.dddd Please try again.";
		}
        
    }
    
}
