<?php

	require 'mail/PHPMailer.php';
	require 'mail/SMTP.php';
	require 'mail/Exception.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->Host = "smtp.gmail.com";
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "tls";
	$mail->Port = "587";
	$mail->Username = "savcimu@gmail.com";
	$mail->Password = "zzmfmutuxdbeadck";
	$mail->Subject = "Verification Code";
	$mail->setFrom($email);
	$mail->isHTML(true);

	$mail->Body = "<h1>".$randomNumber."</h1>";
	$mail->addAddress($email);
	if ( $mail->send() ) {
	}else{
		echo $mail->ErrorInfo;
	}
	$mail->smtpClose();
