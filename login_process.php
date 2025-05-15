<?php 
session_start();  
include "includes/connect.php";
if (isset($_POST['submit'])) 
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$role = $_POST['role'];
		$error = 0;


		if ($error == 0) 

		{

				$query = "Select * from user_master where Username = '".$username."' and Role = '".$role."'";
				
			//$query = "Select * from Register_Customer where Customer_Username = '".$username."'";
			//echo $query;
			//die();
			$result = oci_parse($conn,$query);
	 		oci_execute($result);

			if($row = oci_fetch_assoc($result))
			{
				if (password_verify($password, $row['PASSWORD']) && $row['STATUS']=='Verified') 
				{
					$_SESSION['username'] = $username;
					$_SESSION['role'] = $row['ROLE'];
					$_SESSION['id'] = $row['USER_ID'];
					$_SESSION['passmessage']="Logged in Successfully";
 					header("Location: index.php");		
				}
				elseif ($row['STATUS']!='Verified') {
					$_SESSION['failmessage']="Your account is not verified yet";
					header("Location: login.php");
				}
				else 
				{
					$_SESSION['failmessage']="Authentication failed! Wrong Credentials entered";
					header("Location: login.php");
				}

				
			}
			else 
				{
					$_SESSION['failmessage']="Authentication failed! Wrong Credentials entered";
					header("Location: login.php");
					
				}

		
		}

	}

?>