<?php include("includes/header.php"); ?>

<!-- Login Form -->
<div class="container d-flex justify-content-center align-items-center" style="min-height: 75vh;">
  <div class="p-4 shadow-sm" style="background-color: #e0e0e0; width: 100%; max-width: 400px; border-radius: 16px;">
    <h3 class="fw-bold text-center mb-3" style="color: #2e2e2e;">Sign-In</h3>

    <form action="#" method="post">
      <div class="mb-2">
        <label for="username" class="form-label fst-italic small">Username</label>
        <input type="text" id="username" name="username" class="form-control form-control-sm px-3 py-2 rounded" required>
      </div>
      <div class="mb-2">
        <label for="password" class="form-label fst-italic small">Password</label>
        <input type="password" id="password" name="password" class="form-control form-control-sm px-3 py-2 rounded" required>
      </div>
      <div class="mb-3">
        <label for="role" class="form-label fst-italic small">Role</label>
        <select id="role" name="role" class="form-select form-select-sm px-3 py-2 rounded" required>
          <option selected disabled>Select your role</option>
          <option value="customer">Customer</option>
          <option value="admin">Admin</option>
          <option value="trader">Trader</option>
        </select>
      </div>
      <div class="d-grid">
        <button type="submit" class="btn text-white" style="background-color: #C49A6C;">SIGN IN</button>
      </div>
    </form>

    <div class="mt-3 text-center small">
      <div class="mb-1">
        Forgot password? <a href="#" class="text-decoration-none">Click here</a>
      </div>
      <div class="mb-1">
        Don’t have an account yet? <a href="customer_registration.php" class="text-decoration-none">Register here</a>
      </div>
      <div>
        Want to sell on Cleck-E-Mart? <a href="trader_registration.php" class="text-decoration-none">Register your shop</a>
      </div>
    </div>
  </div>
</div>

<?php include("includes/footer.php"); ?>
