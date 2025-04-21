<?php include 'includes/header.php'; ?>

<div class="container my-5">
  <div class="row justify-content-center align-items-center">

    <div class="col-md-5 text-center text-md-start mb-4 mb-md-0">
        <img src="images/contact.jpg" alt="Support"
        class="img-fluid shadow-sm rounded-circle ms-md-n3"
        style="max-width: 475px;" />
    </div>

    <!-- Contact Form -->
    <div class="col-md-6">
      <div class="p-4 rounded-4 shadow-sm" style="background-color: #eeeeee; border-top: 5px solid #C49A6C;">
        <h3 class="fw-bold mb-4 text-center text-md-start"> Contact Us</h3>
        
        <form action="#" method="post">
          <div class="mb-3">
            <input type="text" class="form-control rounded-pill px-4 py-2" placeholder="Your Name" required>
          </div>
          <div class="mb-3">
            <input type="email" class="form-control rounded-pill px-4 py-2" placeholder="Your Email Address" required>
          </div>
          <div class="mb-3">
            <input type="text" class="form-control rounded-pill px-4 py-2" placeholder="Your Mobile No." required>
          </div>
          <div class="mb-3">
            <textarea class="form-control px-4 py-2 rounded-3" rows="4" placeholder="How can we help you?" required></textarea>
          </div>
          <div class="text-center">
            <button type="submit" class="btn px-4 py-2 text-white" style="background-color: #C49A6C; border-radius: 8px;">
              Submit
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
