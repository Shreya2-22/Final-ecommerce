<!-- Spacer Section -->
 <!-- Footer -->
 <?php
    function clearMsg()
    {
      $_SESSION['passmessage']=null;
      $_SESSION['failmessage']=null;  
    }  
      
?>
<div class="footer-spacer"></div>

<!-- FOOTER -->
<footer>
  <div class="footer-top">
    <div class="container text-center">
      <!-- Social Icons -->
      <div class="footer-icons mb-4 fs-3">
        <a href="https://www.instagram.com/cleck_emart/" target="_blank" class="footer-icon mx-3" aria-label="Instagram">
          <i class="fab fa-instagram"></i>
        </a>
        <a href="https://mail.google.com/mail/?view=cm&to=cleckemart@gmail.com" class="footer-icon mx-3" aria-label="Email">
          <i class="fas fa-envelope"></i>
        </a>
        <a href="https://www.facebook.com/profile.php?id=61576018097154" target="_blank" class="footer-icon mx-3" aria-label="Facebook">
          <i class="fab fa-facebook-f"></i>
        </a>
      </div>

      <!-- Footer Links -->
      <div class="footer-links fs-5">
        <a href="terms.php" class="text-dark text-decoration-none mx-2">Terms and Conditions</a> |
        <a href="privacy.php" class="text-dark text-decoration-none mx-2">Privacy Policy</a>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <div class="container py-2 text-center">
      <p class="mb-0 text-white small">&copy; 2025 Cleck-E-Mart. All rights reserved.</p>
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

    if (logoutLink) {
      logoutLink.addEventListener('click', () => {
        sidebarLinks.forEach(link => link.classList.remove('active'));
      });
    }

    if (cancelButton) {
      cancelButton.addEventListener('click', () => {
        // Keep current active link
      });
    }
  });

  // Auto-hide success alerts after 3s
  setTimeout(function () {
    const alert = document.getElementById('success-alert');
    if (alert) {
      alert.style.display = 'none';
    }
  }, 3000);
</script>


