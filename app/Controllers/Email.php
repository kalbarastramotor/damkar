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
		    $mail->isSMTP();  
		    $mail->Host         = 'smtp.gmail.com';
		    $mail->SMTPAuth     = true;     
		    $mail->Username     = 'kalbarastramotor@gmail.com';
		    $mail->Password     = 'Astramotorkalbar';
			$mail->SMTPSecure   = 'ssl';  
			$mail->Port         = 465;  
			$mail->Subject      = $subject;
			$mail->Body         = $message;
			$mail->setFrom('azharoce@gmail.com', 'dasaads');
			
			$mail->addAddress($email);  
			$mail->isHTML(true);      
            $send = $mail->send();

			print_r($send);
			die();
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
