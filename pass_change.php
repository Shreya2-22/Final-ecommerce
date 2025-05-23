<?php
include "includes/connect.php";

if (isset($_GET['token']) && isset($_GET['id'])) {
    $token = $_GET['token'];
    $id = $_GET['id'];
    $sql = "SELECT * FROM PASSWORD_RESET WHERE TOKEN='$token' AND FK1_USER_ID=$id";
    $result = oci_parse($conn, $sql);
    oci_execute($result);
    if (!oci_fetch_assoc($result)) {
        $_SESSION['failmessage'] = "Invalid token";
        header('Location: index.php');
    }
} else {
    header('Location: index.php');
}

if (isset($_POST['submit'])) {
    $newpass = $_POST['newpass'];
    $conpass = $_POST['conpass'];
    $error = 0;

    if ($newpass == null) {
        $error_newpass = "Please enter your new password";
        $error++;
    }
    if ($conpass != $newpass) {
        $error_conpass = "Password did not match";
        $error++;
    }

    if ($error == 0) {
        $newpass = password_hash($newpass, PASSWORD_DEFAULT);
        $pass_update_query = "UPDATE user_master SET PASSWORD='$newpass' WHERE USER_ID=$id";
        $passResult = oci_parse($conn, $pass_update_query);
        oci_execute($passResult);
        $_SESSION['passmessage'] = "Password changed successfully";
        header('Location: login.php');
    }
}
$pageTitle = "Change Password";
include "includes/header.php";
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="border rounded shadow bg-white p-4">
                <form method="POST" action="">
                    <h1 class="pb-3 text-center">Reset Password</h1>

                    <div class="form-group row align-items-center">
                        <label class="col-lg-4 col-form-label">New Password</label>
                        <div class="col-lg-8">
                            <input type="password" name="newpass" class="form-control" placeholder="Enter new password">
                            <?php if (isset($error_newpass)) echo '<div class="error mt-2">' . $error_newpass . '</div>'; ?>
                        </div>
                    </div>

                    <div class="form-group row align-items-center">
                        <label class="col-lg-4 col-form-label">Confirm Password</label>
                        <div class="col-lg-8">
                            <input type="password" name="conpass" class="form-control" placeholder="Confirm new password">
                            <?php if (isset($error_conpass)) echo '<div class="error mt-2">' . $error_conpass . '</div>'; ?>
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

<?php include "includes/footer.php" ?>

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
.error {
    color: red;
    font-style: italic;
}
</style>