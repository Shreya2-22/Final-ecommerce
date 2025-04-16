<style>
  footer {
    background-color: #F4EAD5;
    padding: 40px 0 0 0; /* Removed bottom padding */
    font-family: 'Segoe UI', sans-serif;
  }

  footer a {
    color: #333 !important;
    text-decoration: none;
    transition: color 0.3s, text-decoration 0.3s;
  }

  footer a:hover {
    color: #006838 !important;
    text-decoration: underline;
  }

  .footer-logo {
    width: 150px;
  }

  .footer-bottom {
    background-color: #363636;
    padding: 10px 0;
    text-align: center;
    color: white;
    margin-bottom: 0; /* Ensure nothing comes after */
  }
</style>

<!-- ✅ Footer -->
<footer>
  <div class="container pb-4">
    <div class="row text-center text-md-start align-items-start">

      <!-- Logo -->
      <div class="col-md-3 mb-4 d-flex flex-column align-items-center align-items-md-start">
        <img src="images/logo.png" alt="Logo" class="footer-logo" />
      </div>

      <!-- Info Links -->
      <div class="col-md-3 mb-4">
        <ul class="list-unstyled">
          <li><a href="#">About Us</a></li>
          <li><a href="contactus.php">Contact Us</a></li>
          <li><a href="#">Terms and Conditions</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>

      <!-- Categories -->
      <div class="col-md-3 mb-4">
        <ul class="list-unstyled">
          <li><a href="#">Greengrocer</a></li>
          <li><a href="#">Butcher</a></li>
          <li><a href="#">Fishmonger</a></li>
          <li><a href="#">Bakery</a></li>
          <li><a href="#">Delicatessen</a></li>
        </ul>
      </div>

      <!-- Social -->
      <div class="col-md-3 mb-4">
        <h6 class="fw-semibold mb-3">Follow Us</h6>
        <a href="#" class="text-dark me-3 fs-5"><i class="fab fa-instagram"></i></a>
        <a href="#" class="text-dark me-3 fs-5"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="text-dark me-3 fs-5"><i class="fas fa-envelope"></i></a>
        <a href="#" class="text-dark fs-5"><i class="fab fa-whatsapp"></i></a>
      </div>

    </div>
  </div>

  <!-- Copyright -->
  <div class="footer-bottom">
    <small>&copy; 2025 <strong>Cleck-E-Mart</strong>. All rights reserved</small>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</footer>

