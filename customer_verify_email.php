<?php
include('smtp/PHPMailerAutoload.php');
$token = $_GET['token'];
$id = $_GET['id'];
$html='

<style>
	h1.heading{
		font-size: 20px;
		color: black;
	}
	p.parag1{
		font-size: 12px;
		color: red;
	}
</style>
<div class = "container">
	<h1 class="heading">Cleck-E-Mart</h1>
	<p class="parag1"><b><i>Click here to verify your account</i><b><p>
	<p><a href="http://localhost/Cleck-E-Mart/verify_customer_query.php?token='.$token.'&id='.$id.'">Here</a></p>
</div>

';


smtp_mailer($_GET['email'],'subject',$html);
function smtp_mailer($to,$subject, $msg){
	$mail = new PHPMailer(); 
	$mail->SMTPDebug  = 3;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "cleckemart@gmail.com";
	$mail->Password ="gtqnoxoosxfcdmxa";
	$mail->SetFrom("cleckemart@gmail.com");
	$mail->Subject = $subject;
	$mail->Body =$msg;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
		session_start();
		$_SESSION['passmessage']="Email verify link sent";
		header("Location: login.php");
	}
}
?>