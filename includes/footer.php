<!-- Footer -->
 <!----------------------------------------footer------------------------------------------------>
<link rel="stylesheet" type="text/css" href="css/alert_fail.css">
<?php
  if (isset($_SESSION['failmessage'])) 
    {?>
      <div class="container-fluid" id="login_message_error">
          <div class="alertmessage">
              <div class="col-12">  
                  <div class="alert alert-fail-alt alert-dismissable">
                      <span class="glyphicon glyphicon-certificate"></span>
                      <button type="button" class="close ml-2" data-dismiss="alert" aria-hidden="true">
                          ×</button><?php echo $_SESSION['failmessage'];     
  }
?>
                  </div>
              </div>
          </div>
      </div>

<?php
  if (isset($_SESSION['passmessage'])) 
    {?>
      <div class="container-fluid" id="login_message_error">
          <div class="alertmessage">
              <div class="col-12">  
                  <div class="alert alert-success-alt alert-dismissable">
                      <span class="glyphicon glyphicon-certificate"></span>
                      <button type="button" class="close ml-2" data-dismiss="alert" aria-hidden="true">
                          ×</button><?php echo $_SESSION['passmessage'];     
  }
      
?>
<link rel="stylesheet" href="css/header_footer.css" />
<footer>
  <div class="container pb-4">
    <div class="row text-center text-md-start align-items-start">

      <!-- Logo -->
      <div class="col-md-3 mb-4 d-flex flex-column align-items-center align-items-md-start">
        <img src="images/logo.png" alt="Logo" class="footer-logo" />
      </div>
      
      <div class="col-md-3 mb-4">
        <ul class="list-unstyled">
          <li><a href="#">About Us</a></li>
          <li><a href="contactus.php">Contact Us</a></li>
          <li><a href="#">Terms and Conditions</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>

      <div class="col-md-3 mb-4">
        <ul class="list-unstyled">
          <li><a href="#">Greengrocer</a></li>
          <li><a href="#">Butcher</a></li>
          <li><a href="#">Fishmonger</a></li>
          <li><a href="#">Bakery</a></li>
          <li><a href="#">Delicatessen</a></li>
        </ul>
      </div>

      <div class="col-md-3 mb-4">
        <h6 class="fw-semibold mb-3">Follow Us</h6>
        <a href="#" class="text-dark me-3 fs-5"><i class="fab fa-instagram"></i></a>
        <a href="#" class="text-dark me-3 fs-5"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="text-dark me-3 fs-5"><i class="fas fa-envelope"></i></a>
        <a href="#" class="text-dark fs-5"><i class="fab fa-whatsapp"></i></a>
      </div>

    </div>
  </div>

  <div class="footer-bottom">
    <small>Copyright &copy; 2025 <strong>Cleck-E-Mart</strong>. All rights reserved</small>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</footer>

<?php
    function clearMsg()
    {
      $_SESSION['passmessage']=null;
      $_SESSION['failmessage']=null;  
    }  
      
?>