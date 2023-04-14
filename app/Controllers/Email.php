<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use \App\Libraries\SendEmail;
use App\Models\EventModel;
use App\Models\EventHistoryModel;
use Config\Services;

class Email extends BaseController {
    
    public function __construct() {
        $this->request = Services::request();
		$this->mail = new SendEmail();  
        $this->eventModel = new EventModel($this->request);
        $this->eventHistoryModel = new EventHistoryModel($this->request);


    }
    
    public function compose() {
    
        echo view('compose');
    
    }
	/*
		status== 1 
			Waiting Approval
		status==  2 
			Approved
		status== 3 
			Rejected
		status== 4 
			Running
		status== 5 
			Done
		status== 0 
			Draft
		// tambahin validasi saat login check dia punya dealer atau gk klo gk jangan boleh masuk
	*/
	function checkRequestApprove($officeid,$eventid){
		$dataAtasan = $this->eventModel->getAtasan($officeid);

		$historyApproval = $this->eventHistoryModel->getApproval($eventid);

		print_r("history ");
		print_r($historyApproval);

		return $dataAtasan;
	}
	
    public function send_email() {
		$eventData = $this->eventModel->DataEventByID(72);
		// echo "<pre>";
		// print_r($eventData);
		// $data = array();
		$data['nama'] = $eventData['fullname'];
		
		$data['email'] = "azharoce@gmail.com";
		// $data['email'] = $eventData['email'];
		$data['nama'] = $eventData['fullname'];
		$data['event_name'] = $eventData['name'];
		$data['office_name'] = $eventData['office_name'];

	
		// echo "aa";
		$emailRecipient ="";
		$nameRecipient ="";
		if($eventData['status']==1){
			$data['title'] = "Request Approve ";
			$dataApproval = $this->checkRequestApprove($eventData['officeid'],$eventData['eventid']);
			$layout = view('email/request',$data);
		}elseif($eventData['status']==2){
			$data['title'] = "Approved ";
			$layout = view('email/approved',$data);
		}elseif($eventData['status']==3){
			$data['title'] = "Rejected ";
			$layout = view('email/rejected',$data);
		}
		$kirim = $this->mail->sendEmail($layout,$data);

		echo $kirim;
		// echo $layout;
		// echo "atasan";
		// $dataAtasan = $this->eventModel->getAtasan($eventData['officeid']);
		// print_r($dataAtasan);

		// die();
		
    
        // $email          = $this->request->getPost('email');
        // $subject        = $this->request->getPost('subject');
        // $message        = $this->request->getPost('message');
        
        // $mail = new PHPMailer(true);  
     
		// try {
		// 	//Server settings
		// 	// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		// 	$mail->isSMTP();                                            //Send using SMTP
		// 	// $mail->Host       = 'smtp.example.com';   
		//     $mail->Host         = 'smtp.gmail.com';
		// 	$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
		// 	// $mail->Username   = 'user@example.com';                     //SMTP username
		// 	// $mail->Password   = 'secret';    
		// 	$mail->Username     = 'kalbarastramotor@gmail.com';
		//     $mail->Password     = 'gxfwkzoctxqihqur';                           //SMTP password
		// 	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
		// 	$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
		
		// 	//Recipients
		// 	$mail->setFrom('no-replay@gmail.com', 'Mailer');
		// 	$mail->addAddress('azharoce@gmail.com', 'Joe User');     //Add a recipient
		// 	// $mail->addAddress('ellen@example.com');               //Name is optional
		// 	$mail->addReplyTo('replay@gmail.com', 'Information');
		// 	// $mail->addCC('cc@example.com');
		// 	// $mail->addBCC('bcc@example.com');
		
		// 	//Attachments
		// 	// $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
		// 	// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
		
		// 	//Content
		// 	$mail->isHTML(true);                                  //Set email format to HTML
		// 	$mail->Subject = 'Here is the subject';
		// 	$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
		// 	$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		
		// 	$send = $mail->send();
		// 	print_r($send);
		// 	die();
		// 	echo 'Message has been sent';
		// } catch (Exception $e) {
		// 	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		// }

		// try {
		//     $mail->isSMTP();  
		//     $mail->Host         = 'smtp.gmail.com';
		//     $mail->SMTPAuth     = true;     
		//     $mail->Username     = 'kalbarastramotor@gmail.com';
		//     $mail->Password     = 'Astramotorkalbar';
		// 	$mail->SMTPSecure   = 'ssl';  
		// 	$mail->Port         = 465;  
		// 	$mail->Subject      = $subject;
		// 	$mail->Body         = $message;
		// 	$mail->setFrom('kalbarastramotor@gmail.com', 'dasaads');
			
		// 	$mail->addAddress($email);  
		// 	$mail->isHTML(true);      
        //     $send = $mail->send();

		// 	print_r($send);
		// 	die();
		// 	if(!$send ) {
        //         echo $send;
        //         echo "<br/>";
		// 	    echo "Something went wrong. Please try again.";
		// 	}
		//     else {
		// 	    echo "Email sent successfully.";
		//     }

        //     echo "<pre>";
        //     echo $send ;
		    
		// } catch (Exception $e) {
        //     echo "<pre>";
        //     echo $e;
		//     echo "Something went wrong.dddd Please try again.";
		// }
        
    }
    
}
