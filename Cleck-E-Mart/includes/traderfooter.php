<!-- Spacer Section -->
<div class="footer-spacer"></div>

<!-- FOOTER -->
<footer>
  <!-- First Box: Social Icons + Links -->
  <div class="footer-top">
    <div class="container text-center">
      <!-- Social Icons -->
  <div class="footer-icons mb-4 fs-3">
  <a href="https://www.instagram.com/cleck_emart/" target="_blank" class="text-dark mx-3" aria-label="Instagram">
    <i class="fab fa-instagram"></i>
  </a>
  <a href="https://www.facebook.com/profile.php?id=61576018097154" target="_blank" class="text-dark mx-3" aria-label="Facebook">
    <i class="fab fa-facebook-f"></i>
  </a>
  <a href="https://mail.google.com/mail/?view=cm&to=cleckemart@gmail.com" target="_blank"  class="text-dark mx-3"  rel="noopener noreferrer">
  <i class="fas fa-envelope"></i>
</a>

</div>



      <!-- Links -->
      <div class="footer-links fs-5">
        <a href="/trader-interface/pages/terms.php" class="text-dark text-decoration-none mx-2">Terms and Conditions</a> |
        <a href="/trader-interface/pages/privacy.php" class="text-dark text-decoration-none mx-2">Privacy Policy</a>
      </div>
    </div>
  </div>

  <!-- Second Box: Copyright -->
  <div class="footer-bottom">
    <div class="container py-2 text-center">
      <p class="mb-0 text-white small">&copy; 2025 Cleck-E-Mart. All rights reserved.</p>
    </div>
  </div>


 <!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0">
      <div class="modal-header text-dark" style="background-color: #C49A6C;">
        <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        Dear <strong><?php echo htmlspecialchars($traderName); ?></strong>, do you want to logout?
      </div>
      <div class="modal-footer justify-content-center">
        <a href="../pages/traderlogout.php" class="btn btn-danger px-4">Logout</a>
        <button type="button" class="btn btn-secondary px-4" id="cancelLogout" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>


 <!-- Change Password Modal --> 
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-primary">
      <!-- Custom Header Color -->
      <div class="modal-header text-white" style="background-color: #C49A6C;">
        <h5 class="modal-title" id="changePasswordModalLabel">Change Your Password</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="changePasswordForm" method="POST" action="handlechangepassword.php">
        <div class="modal-body">
          <!-- Current Password -->
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Current Password</label>
            <input type="password" class="form-control border border-dark bg-light" id="currentPassword" name="current_password" required>
          </div>

          <!-- New Password -->
          <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" class="form-control border border-dark bg-light" id="newPassword" name="new_password" required>
            <div class="form-text text-muted">
              Must be at least 8 characters, include 4 of &@_$, and contain letters and numbers.
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control border border-dark bg-light" id="confirmPassword" name="confirm_password" required>
            <div class="invalid-feedback">Passwords do not match.</div>
          </div>

          <!-- Used Password Alert -->
          <div class="alert alert-danger d-none" id="passwordUsedAlert">
            This password has already been used. Please choose a different one.
          </div>
        </div>

        <!-- Footer Buttons -->
        <div class="modal-footer">
          <button type="submit"  class="btn btn-danger">Save Password</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div> 
</div>



  <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</footer>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const logoutLink = document.getElementById('logoutSidebarLink');
    const cancelButton = document.getElementById('cancelLogout');
    const sidebarLinks = document.querySelectorAll('.nav-link');

    logoutLink.addEventListener('click', () => {
      // Remove 'active' class from all sidebar links
      sidebarLinks.forEach(link => link.classList.remove('active'));
    });

    cancelButton.addEventListener('click', () => {
      // Do nothing: we intentionally leave it blank so no active state returns
    });
  });
</script>


<script>
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
  const newPassword = document.getElementById('newPassword').value;
  const confirmPassword = document.getElementById('confirmPassword').value;
  const passwordUsedAlert = document.getElementById('passwordUsedAlert');
  const confirmInput = document.getElementById('confirmPassword');

  // Reset states
  passwordUsedAlert.classList.add('d-none');
  confirmInput.classList.remove('is-invalid');

  // Password match check
  if (newPassword !== confirmPassword) {
    e.preventDefault();
    confirmInput.classList.add('is-invalid');
    return;
  }

  // Basic rule validation
  const specialCharCount = (newPassword.match(/[&@_$]/g) || []).length;
  const hasLetter = /[a-zA-Z]/.test(newPassword);
  const hasNumber = /\d/.test(newPassword);

  if (
    newPassword.length < 8 ||
    specialCharCount < 4 ||
    !hasLetter || !hasNumber
  ) {
    e.preventDefault();
    alert("Password must meet the required criteria.");
    return;
  }

  // Simulated check for reused password (this will be handled server-side in reality)
  const reusedPasswords = ['Test@1234$', 'Demo_2023@']; // Simulate with past values
  if (reusedPasswords.includes(newPassword)) {
    e.preventDefault();
    passwordUsedAlert.classList.remove('d-none');
  }
});
</script>


