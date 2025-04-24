<!-- Customer Registration Page -->
<?php include("includes/header.php"); ?>
<link rel="stylesheet" href="css/customer_registration.css" />
<div class="register-container">
    <div class="register-box">
        <h3>Create account</h3>
        <form action="register_trader_process.php" method="POST" enctype="multipart/form-data">
            <div class="mb-2">
                <label class="form-label">Full Name </label>
                <input type="text" name="full_name" class="form-control" placeholder="Enter your full name" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Email Address </label>
                <input type="email" name="email" class="form-control" placeholder="Xyz@gmail.com" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Date of Birth </label>
                <input type="date" name="dob" class="form-control" placeholder="Date of Birth" required>
            </div>

            <div class="mb-2">
                <label class="form-label d-block mb-1">Gender</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="genderMale" value="male" required>
                    <label class="form-check-label" for="genderMale">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="female">
                    <label class="form-check-label" for="genderFemale">Female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="genderOther" value="other">
                    <label class="form-check-label" for="genderOther">Other</label>
                </div>
            </div>


            <div class="mb-2">
                <label class="form-label">Mobile Number </label>
                <input type="tel" name="mobile" class="form-control" placeholder="+977 98xxxxxxx" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Username </label>
                <input type="text" name="username" class="form-control" placeholder="Username" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Password </label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="mb-2">
                <label class="form-label">Confirm Password </label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
            </div>

            <!-- Terms and Submit -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                <label class="form-check-label" for="terms">
                    I agree to Cleck-E-Mart's <a href="#">Terms and Conditions</a>
                </label>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn text-white" style="background-color: #C49A6C;">SIGN UP</button>
            </div>

            <div class="text-center">
                Already have an account? <a href="login.php">Sign in</a>
            </div>

        </form>
    </div>
</div>

<?php include("includes/footer.php"); ?>