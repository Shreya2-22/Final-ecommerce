<!-- Customer Registration Page -->
<?php
include "includes/connect.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" type="text/css" href="css/alert.css">

	<style type="">
		
		.error{
			color: red;
			font-style: italic;
		}

		#customer_message{
			margin-top: 20px;
		}


	</style>
</head>
<body>

	<!------------------------------------------------------------------------------------------->
	<?php 
	if (isset($_POST['btnSubmit'])) 
	{
		$name=$_POST['Cname'];
		$email=$_POST['CEmail'];
		$phone=$_POST['CPhone'];
		$dob=$_POST['Cdob'];
		if (isset($_POST['CGender']))
		{
			$gender=$_POST['CGender'];
		}
		$username=$_POST['CUsername'];
		$password=$_POST['CPass'];
		$password_confirm=$_POST['CPassCon'];
		$role = "customer";
		$status = "Not Verified";
		$error = 0;

		if(strlen($name)<5)
		{
			$error_name =  "Fullname should be atleast six characters";
			$error++;
		}

		if($name == null) 
		{
			$error_name=  "Please enter your fullname first";
			$error++;
		}

		if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email))
		{
			$error_email= "Please enter a valid email, like yourname@abc.com";
			$error++;
		}

		if($email == "") 
		{
			$error_email=  "Please enter your email";
			$error++; 
		} 

		if(!preg_match('/^[0-9]{10}+$/', $phone)) 
		{
			$error_phone=  "Please enter valid mobile number";
			$error++; 
		} 

		if($phone == "") 
		{
			$error_phone=  "Please enter your mobile number";
			$error++; 
		} 

		if($dob == "") 
		{
			$error_dob=  "Please select your date of birth";
			$error++; 
		} 

		if(strlen($username)<5)
		{
			$error_username =  "Username should be atleast five characters";
			$error++;
		}

		if($username =="") 
		{
			$error_username=  "Please enter your username";
			$error++;
		}

		if(!isset($gender))
		{ 
			$error_gender = "No gender selected"; 
			$error++;
		}

		if(!preg_match('@[A-Z]@', $password)){
			$error_passwd=  "Password must include an uppercase character";
			$error++;
		}

		if(!preg_match('@[a-z]@', $password)){
			$error_passwd=  "Password must include a lowercase character";
			$error++;
		}

		if(!preg_match('@[0-9]@', $password)){
			$error_passwd=  "Password must include a number";
			$error++;
		}

		if(!preg_match('@[^\w]@', $password)){
			$error_passwd=  "Password must include special character";
			$error++;
		}

		if(strlen($password) < 6){
			$error_passwd=  "Password must be greater than six characters";
			$error++;
		}

		if($password == ""){
			$error_passwd=  "Please enter password";
			$error++;
		}

		if($password_confirm == ""){
			$error_passwdConfirm=  "No password given";
			$error++;
		}

		if($password != $password_confirm) {
			$error_passwdConfirm=  "Password does not match";
			$error++;
		}


		if ($error == 0) 
		{
			$password = password_hash($password,  
				PASSWORD_DEFAULT);
			

			//$query = "INSERT INTO Register_Customer(Customer_Name, Customer_Email, Customer_Phone, Customer_Age, Customer_Gender, Customer_Username, Customer_Pass, Customer_Role) VALUES ('$name', '$email', '$phone', '$dob', '$gender', '$username', '$password', '$role')";

			$query = "INSERT INTO user_master(Name, Email, Phone, DOB, Gender, Username, Password, Role, Status) VALUES ('$name', '$email', '$phone', '$dob', '$gender', '$username', '$password', '$role', '$status')";

			//mysqli_query($connect, $query);
			
			if ($result = oci_parse($conn, $query));
			{
				oci_execute($result);
				

				//$_SESSION['passmessage'] = "Account Registration Successful, click to <a href='login.php'>verify</a>";

				$select_email = "SELECT * FROM user_master where EMAIL = '$email'";
				$email_result = oci_parse($conn, $select_email);
				oci_execute($email_result);
			//echo $select_email;
			//die();

				if ($row = oci_fetch_assoc($email_result)) 
				{
					$token = openssl_random_pseudo_bytes(16);
					$userID = $row['USER_ID'];
					$token = bin2hex($token);

					$token_query = "INSERT INTO PASSWORD_RESET VALUES ('$token', '$userID')";
					$token_result = oci_parse($conn, $token_query);
					oci_execute($token_result);
					header("Location: customer_verify_email.php?token=$token&id=$userID&email=$email");
				}

				$name="";
				$email="";
				$phone="";
				$dob="";
				$gender="";
				$username="";
				$role = "";
				$_SESSION['passmessage'] = "Account Registration Successful";
			}
			//echo $query;
		}

	}

	include "includes/header.php";

	?>

<link rel="stylesheet" href="css/customer_registration.css" />
<div class="register-container">
    <div class="register-box">
        <h3>Create account</h3>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-2">
                <label class="form-label">Full Name </label>
                <input type="text" name="Cname" class="form-control" placeholder="Enter your full name" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Email Address </label>
                <input type="email" name="CEmail" class="form-control" placeholder="Xyz@gmail.com" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Date of Birth </label>
                <input type="date" name="Cdob" class="form-control" placeholder="Date of Birth" required>
            </div>

            <div class="mb-2">
                <label class="form-label d-block mb-1">Gender</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="CGender" id="genderMale" value="male" required>
                    <label class="form-check-label" for="genderMale">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="CGender" id="genderFemale" value="female">
                    <label class="form-check-label" for="genderFemale">Female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="CGender" id="genderOther" value="other">
                    <label class="form-check-label" for="genderOther">Other</label>
                </div>
            </div>


            <div class="mb-2">
                <label class="form-label">Mobile Number </label>
                <input type="tel" name="CPhone" class="form-control" placeholder="+977 98xxxxxxx" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Username </label>
                <input type="text" name="CUsername" class="form-control" placeholder="Username" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Password </label>
                <input type="password" name="CPass" class="form-control" placeholder="Password" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Confirm Password </label>
                <input type="password" name="CPassCon" class="form-control" placeholder="Confirm Password" required>
            </div>

            <!-- Terms and Submit -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                <label class="form-check-label" for="terms">
                    I agree to Cleck-E-Mart's <a href="#">Terms and Conditions</a>
                </label>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" name="btnSubmit" class="btn text-white" style="background-color: #C49A6C;">SIGN UP</button>
            </div>

            <div class="text-center">
                Already have an account? <a href="login.php">Sign in</a>
            </div>

        </form>
    </div>
</div>

<?php include("includes/footer.php"); ?>