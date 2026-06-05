<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>dotlinka — Page Not Found</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/style.css">
  <style>
    body { background: #f8f7f4; display: flex; flex-direction: column; min-height: 100vh; }
    .not-found-wrap {
      flex: 1; display: flex; flex-direction: column;
      align-items: center; justify-content: center; text-align: center; padding: 3rem 1rem;
    }
    .not-found-code {
      font-size: 7rem; font-weight: 900; line-height: 1;
      background: linear-gradient(270deg,#00ff00,#7928ca,#ed8936,#ff0000);
      background-size: 300% 300%;
      -webkit-background-clip: text; background-clip: text; color: transparent;
      animation: dlFlow 6s ease infinite;
    }
    @keyframes dlFlow {
      0%  { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100%{ background-position: 0% 50%; }
    }
    .not-found-title { font-size: 1.6rem; font-weight: 700; color: #1a1a1a; margin: .5rem 0; }
    .not-found-sub   { color: #666; font-size: 1rem; margin-bottom: 2rem; }
    .btn-home {
      background: #D85A30; color: #fff; border: none; padding: .75rem 2rem;
      border-radius: 30px; font-size: 1rem; text-decoration: none; font-weight: 600;
      transition: background .2s;
    }
    .btn-home:hover { background: #993C1D; color: #fff; }
  </style>
</head>
<body>
  <?php include 'components/loading.php'; ?>
  <?php include 'components/navbar.php'; ?>

  <div class="not-found-wrap">
    <div class="not-found-code">404</div>
    <div class="not-found-title">Page not found</div>
    <p class="not-found-sub">The page you're looking for doesn't exist or has been moved.</p>
    <a href="/dashboard.php" class="btn-home">Back to Marketplace</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
