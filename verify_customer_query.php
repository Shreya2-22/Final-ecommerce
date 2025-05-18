<?php
include "includes/connect.php";

if(isset($_GET['token']) && isset($_GET['id']))
{
	$token=$_GET['token'];
	$id=$_GET['id'];
	$sql="Select * from PASSWORD_RESET where TOKEN='$token' and FK1_USER_ID=$id";
	// echo $sql;
	// die();
	$result=oci_parse($conn, $sql);
	oci_execute($result);
	if(!oci_fetch_assoc($result))
	{
		$_SESSION['failmessage']="Invalid token";
		header('Location: index.php');
	}
}
else
{
	header('Location: index.php');
	
}

$update_email = "UPDATE user_master SET STATUS = 'Verified' WHERE USER_ID = $id";
	$update_result = oci_parse($conn, $update_email);
	oci_execute($update_result);
	//echo $update_email;
	$_SESSION['passmessage']="Email verified successfully";
	header("Location: login.php");



include "includes/footer.php";
?>