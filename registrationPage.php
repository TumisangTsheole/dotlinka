<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>commerce.za — Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: #f8f7f4;
      margin: 0;
      padding: 0;
    }

    /* Navbar */
    nav {
      background: #fff;
      border-bottom: 1px solid #e8e6e1;
      padding: 1rem 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    nav h2 { margin: 0; font-size: 22px; }
    .animated-gradient-text {
      background: linear-gradient(270deg,#00ff00,#7928ca,#abaaac,#48bb78,#ed8936,#ff0000);
      background-size: 200% 200%;
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      animation: flowAndGlow 8s ease infinite;
      display: inline-block;
    }
    @keyframes flowAndGlow {
      0% {background-position:0% 50%;filter:drop-shadow(0 0 5px rgba(255,255,255,.2));}
      50% {background-position:100% 50%;filter:drop-shadow(0 0 15px rgba(255,255,255,.6));}
      100% {background-position:0% 50%;filter:drop-shadow(0 0 5px rgba(255,255,255,.2));}
    }

    /* Registration wrapper */
    .register-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 80vh;
    }
    .register-card {
      background: #fff;
      border: 1px solid #e8e6e1;
      border-radius: 14px;
      padding: 2rem;
      width: 100%;
      max-width: 450px;
      box-shadow: 0 2px 6px rgba(0,0,0,.05);
    }
    .register-card h1 {
      font-size: 22px;
      margin-bottom: 1.5rem;
      text-align: center;
      color: #1a1a1a;
    }
    .form-group {
      margin-bottom: 1rem;
    }
    label {
      font-size: 13px;
      font-weight: 600;
      color: #333;
      display: block;
      margin-bottom: .4rem;
    }
    input {
      width: 100%;
      padding: .6rem .75rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }
    input:focus {
      border-color: #D85A30;
      outline: none;
      box-shadow: 0 0 0 2px rgba(216,90,48,.2);
    }
    .btn-primary {
      background: #D85A30;
      color: #fff;
      border: none;
      padding: .7rem 1.5rem;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
      width: 100%;
      margin-top: 1rem;
    }
    .btn-primary:hover { background:#993C1D; }
    .register-footer {
      text-align: center;
      margin-top: 1rem;
      font-size: 13px;
      color: #666;
    }
    .register-footer a {
      color: #D85A30;
      text-decoration: none;
    }
    .register-footer a:hover { text-decoration: underline; }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav>
    <h2><span>commerce</span><span class="animated-gradient-text">.za</span></h2>
    <div>
      <a href="#">Marketplace</a>
      <a href="#" style="margin-left:1rem;">Verified Sellers</a>
      <a href="#" style="margin-left:1rem;">About</a>
    </div>
  </nav>

  <!-- Registration Form -->
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
          <input type="date" id="dateOfBirth" name="dateOfBirth" placeholder="2003-07-17" required>
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

        <!-- write javascript to confirm password match -->
        <div class="form-group">
          <label for="confirm-password">Confirm Password *</label>
          <input type="password" id="confirm-password" name="confirm-password" placeholder="••••••••" required>
        </div>
        <div class="mb-3">
          <label for="idCardImages" class="form-label">Upload images of your ID card *</label>
          <input class="form-control" type="file" id="idCardImages" name="idCardImages" multiple>
        </div>
        <div class="mb-3">
          <label for="userImages" class="form-label">Please upload 3 different images of yourself *</label>
          <input class="form-control" type="file" id="userImages" name="userImages" multiple>
        </div>
        
        
        <button type="submit" class="btn-primary">Register</button>
      </form>
      <div class="register-footer">
        <p>Already have an account? <a href="login.php">Login here</a></p>
      </div>
    </div>
  </div>

</body>
</html>
