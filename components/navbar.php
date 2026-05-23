<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

</head>

<style>
  .anchor-underline {
    background-image: linear-gradient(#5fca66 0 0);
    background-position: bottom left; 
    background-size: 20% 2px; 
    background-repeat: no-repeat;
    
    font-weight: unset;
    
    transition: all-size 0.5s ease-in-out;
  }
  
  .anchor-underline:hover {
    background-size: 50% 2px;
    font-weight: bold;
  }
  
  .anchor-underline:active {
    background-size: 100% 5px;
  }
  .nav-button {
    background-color: transparent;
    color: rgb(33, 37, 41);
    display: inline-block;
    transition: all 0.2s ease-in-out;
  }

  .nav-button:hover {
    /* background-color: rgb(197, 192, 231); */
    color: rgb(0, 0, 0);
  }

  .nav-button:active {
    font-weight: bolder;
  }
</style>

<body class="fs-5">
    
    <nav class="bg-transparent py-3 mt-3">
      <div class="d-flex align-items-center justify-content-between px-4">
        <!-- Logo -->
        <h2 class="text-black mb-0 me-5" style="font-size:22px;">
          <a href="#"><span class="border border-4"><strong>.</strong></span><span class="animated-gradient-text border-3"><strong>LINKA</strong></span></a>
        </h2>
    
        
        <!-- Page navigation -->
        <div class="d-flex align-items-center rounded-pill ">
          <a href="#featured" class="nav-button ms-5 me-4 text-decoration-none anchor-underline">Latest</a>
          <a href="#safety" class="nav-button me-4 text-decoration-none anchor-underline">Safety</a>
          <a href="#how-it-works" class="nav-button text-decoration-none anchor-underline">How It Works</a>
        </div>

        <!-- Login section -->
        <div class="d-flex align-items-center">
    
          <div class="d-flex ms-4">

            <button type="button" class="btn btn-outline-secondary border rounded-pill">
              <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="26" height="26" viewBox="0 0 24 24" style="color: rgb(28, 32, 51);">
                <g fill="currentColor">
                  <path fill-rule="evenodd" d="M16 7a4 4 0 1 1-8 0a4 4 0 0 1 8 0m-2 0a2 2 0 1 1-4 0a2 2 0 0 1 4 0" clip-rule="evenodd"></path>
                  <path d="M16 15a1 1 0 0 0-1-1H9a1 1 0 0 0-1 1v6H6v-6a3 3 0 0 1 3-3h6a3 3 0 0 1 3 3v6h-2z"></path>
                </g>
              </svg>
            </button>
            <button type="button" class="btn btn-outline-secondary border rounded-pill ms-3">
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" width="35" height="35" viewBox="0 0 24 24"><g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="2"><path d="M5 7h13.79a2 2 0 0 1 1.99 2.199l-.6 6A2 2 0 0 1 18.19 17H8.64a2 2 0 0 1-1.962-1.608z"></path><path stroke-linecap="round" d="m5 7l-.81-3.243A1 1 0 0 0 3.22 3H2m6 18h2m6 0h2"></path></g></svg>
            </button>
            <a href="/loginPage.php" class="d-flex align-items-center btn btn-primary border rounded-pill px-2 ms-2">
              <span class="ms-2">Sign In</span>
              <div class="border rounded-circle bg-light ms-2 p-1">
                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="22" height="22" viewBox="0 0 24 24" style="color: rgb(28, 32, 51);">
                  <path fill="currentColor" d="M17.452 6H6.547a.548.548 0 0 0 0 1.096h9.585l-9.97 9.97a.545.545 0 1 0 .772.772l9.97-9.971v9.586a.548.548 0 0 0 1.096 0V6.546A.55.55 0 0 0 17.452 6"></path>
                </svg>
              </div>
            </a>
          </div>
        </div>
      </div>
    </nav>
</body>
</html>


