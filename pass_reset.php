<?php
include "includes/connect.php";

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    $sql = "SELECT * FROM user_master WHERE EMAIL = '$email'";
    $result = oci_parse($conn, $sql);
    oci_execute($result);
    if ($row = oci_fetch_assoc($result)) {
        $token = openssl_random_pseudo_bytes(16);
        $userID = $row['USER_ID'];
        $token = bin2hex($token);

        $token_query = "INSERT INTO PASSWORD_RESET VALUES ('$token', '$userID')";
        $token_result = oci_parse($conn, $token_query);
        oci_execute($token_result);
        header("Location: pass_reset_email.php?token=$token&id=$userID&email=$email");
    } else {
        $_SESSION['failmessage'] = "Email does not exist";
    }
}
$pageTitle = "reset password";
include "includes/header.php";
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="border rounded shadow bg-white p-4">
                <form method="POST" action="">
                    <h1 class="pb-3 text-center">Forgot Password?</h1>

                    <div class="form-group row align-items-center">
                        <label for="staticEmail" class="col-lg-3 col-form-label">Email</label>
                        <div class="col-lg-9">
                            <input type="email" name="email" class="form-control" placeholder="Enter your email address" required>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" name="submit" class="btn btn-success px-4">SUBMIT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.php";
clearMsg();
?>

<style>
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
}
body {
    display: flex;
    flex-direction: column;
}
.container {
    flex: 1;
}
footer {
    margin-top: auto;
}
</style>
