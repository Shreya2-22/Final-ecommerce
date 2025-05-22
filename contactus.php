<?php include 'includes/header.php'; ?>

<?php
if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $mobile = htmlspecialchars($_POST['mobile']);
    $message = htmlspecialchars($_POST['message']);

    $to = 'cleckemart@gmail.com';
    $subject = 'New Contact Form Submission';
    $email_message = "Name: $name\nEmail: $email\nMobile: $mobile\nMessage: $message";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    if (mail($to, $subject, $email_message, $headers)) {
        echo '<div class="alert alert-success text-center" id="success-alert">Message sent successfully!</div>';
    } else {
        echo '<div class="alert alert-danger text-center" id="success-alert">Failed to send message. Please try again.</div>';
    }
}
?>

<script>
  setTimeout(function() {
    var alert = document.getElementById('success-alert');
    if(alert) {
      alert.style.display = 'none';
    }
  }, 3000);
</script>

<div class="container my-5">
  <div class="row justify-content-center align-items-center">

    <div class="col-md-5 text-center text-md-start mb-4 mb-md-0">
      <img src="images/contact.jpg" alt="Support"
        class="img-fluid shadow-sm rounded-circle ms-md-n3"
        style="max-width: 475px;" />
    </div>

    <div class="col-md-6">
      <div class="p-4 rounded-4 shadow-sm" style="background-color: #eeeeee; border-top: 5px solid #C49A6C;">
        <h3 class="fw-bold mb-4 text-center text-md-start">Contact Us</h3>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
          <div class="mb-3">
            <input type="text" class="form-control rounded-pill px-4 py-2" placeholder="Your Name" name="name" required>
          </div>
          <div class="mb-3">
            <input type="email" class="form-control rounded-pill px-4 py-2" placeholder="Your Email Address" name="email" required>
          </div>
          <div class="mb-3">
            <input type="text" class="form-control rounded-pill px-4 py-2" placeholder="Your Mobile No." name="mobile" required>
          </div>
          <div class="mb-3">
            <textarea class="form-control px-4 py-2 rounded-3" rows="4" placeholder="How can we help you?" name="message" required></textarea>
          </div>
          <div class="text-center">
            <button type="submit" name="submit" class="btn px-4 py-2 text-white" style="background-color: #C49A6C; border-radius: 8px;">
              Submit
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>