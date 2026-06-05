<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>dotlinka — Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/style.css">
  <style>
    body { font-family: 'Inter', sans-serif; background: #f8f7f4; margin: 0; padding: 0; }
    .register-wrapper { display: flex; justify-content: center; align-items: center; min-height: 80vh; padding: 2rem 0; }
    .register-card {
      background: #fff; border: 1px solid #e8e6e1; border-radius: 14px;
      padding: 2rem; width: 100%; max-width: 450px; box-shadow: 0 2px 6px rgba(0,0,0,.05);
    }
    .register-card h1 { font-size: 22px; margin-bottom: 1.5rem; text-align: center; color: #1a1a1a; }
    .form-group { margin-bottom: 1rem; }
    label { font-size: 13px; font-weight: 600; color: #333; display: block; margin-bottom: .4rem; }
    input { width: 100%; padding: .6rem .75rem; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; }
    input:focus { border-color: #D85A30; outline: none; box-shadow: 0 0 0 2px rgba(216,90,48,.2); }
    .btn-register {
      background: #D85A30; color: #fff; border: none; padding: .7rem 1.5rem;
      border-radius: 6px; font-size: 14px; cursor: pointer; width: 100%; margin-top: 1rem;
    }
    .btn-register:hover { background: #993C1D; }
    .register-footer { text-align: center; margin-top: 1rem; font-size: 13px; color: #666; }
    .register-footer a { color: #D85A30; text-decoration: none; }
    .register-footer a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <?php include 'components/loading.php'; ?>

  <?php include 'components/navbar.php'; ?>

  <div class="register-wrapper">
    <div class="register-card">
      <h1>Create Your Account</h1>
      <form method="post" action="formHandlers/registerUser.php" enctype="multipart/form-data">
        <div class="form-group">
          <label for="firstName">First Name *</label>
          <input type="text" id="firstName" name="firstName" placeholder="Laylah" required>
        </div>
        <div class="form-group">
          <label for="middleNames">Middle Name(s)</label>
          <input type="text" id="middleNames" name="middleNames" placeholder="Sallie Perry">
        </div>
        <div class="form-group">
          <label for="lastName">Last Name *</label>
          <input type="text" id="lastName" name="lastName" placeholder="Johnson" required>
        </div>
        <div class="form-group">
          <label for="dateOfBirth">Date Of Birth *</label>
          <input type="date" id="dateOfBirth" name="dateOfBirth" required>
        </div>
        <div class="form-group">
          <label for="email">Email Address *</label>
          <input type="email" id="email" name="email" placeholder="you@example.com" required>
        </div>
        <div class="form-group">
          <label for="physicalAddress">Physical Address *</label>
          <input type="text" id="physicalAddress" name="physicalAddress" placeholder="44 Glen Austin AH, Midrand, Gauteng" required>
        </div>
        <div class="form-group">
          <label for="idNumber">South African ID Number *</label>
          <input type="text" id="idNumber" name="idNumber" placeholder="0123456789" required>
        </div>
        <div class="form-group">
          <label for="cellNumber">Cell Number *</label>
          <input type="tel" id="cellNumber" name="cellNumber" placeholder="+27 82 123 4567" required>
        </div>
        <div class="form-group">
          <label for="password">Password *</label>
          <input type="password" id="password" name="password" placeholder="••••••••" required>
        </div>
        <div class="form-group">
          <label for="confirm-password">Confirm Password *</label>
          <input type="password" id="confirm-password" name="confirm-password" placeholder="••••••••" required>
        </div>
        </div>
        <button type="submit" class="btn-register">Register</button>
      </form>
      <div class="register-footer">
        <p>Already have an account? <a href="loginPage.php">Login here</a></p>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/smooth-scrollbar/8.8.4/smooth-scrollbar.js"></script>
  <script src="utils/script.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
