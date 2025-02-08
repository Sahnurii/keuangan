<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Login</title>

  <!-- Custom fonts for this template-->
  <link href="<?= BASEURL; ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?= BASEURL; ?>/css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASEURL ?>/css/style.css">
  <style>
    .bg-img {
      background: url('<?= BASEURL; ?>/img/POLIBALI.png');
      height: 100vh;
      background-size: cover;
      background-position: center;
    }
  </style>
</head>

<body>
  <?php
  $flashData = Flasher::flash();
  ?>
  <div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
  <div class="bg-img">
    <div class="content">
      <img src="<?= BASEURL; ?>/img/POLITEKNIK BATULICIN.png" alt="Logo" class="logo">
      <header>BIRO PELAPORAN KEUANGAN</header>
      <form action="<?= BASEURL; ?>/auth/process" method="POST" class="user">
        <div class="field">
          <span class="fa fa-user"></span>
          <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username/Email">
        </div>
        <div class="field space">
          <span class="fa fa-lock"></span>
          <input type="password" class="form-control form-control-user" name="password" placeholder="Password">
        </div>
        <div class="pass"><br>
        </div>
        <div class="field">
          <input type="submit" value="LOGIN">
        </div>
      </form>
    </div>
  </div>

  <script>
    const pass_field = document.querySelector('.pass-key');
    const showBtn = document.querySelector('.show');
    showBtn.addEventListener('click', function() {
      if (pass_field.type === "password") {
        pass_field.type = "text";
        showBtn.textContent = "HIDE";
        showBtn.style.color = "#3498db";
      } else {
        pass_field.type = "password";
        showBtn.textContent = "SHOW";
        showBtn.style.color = "#222";
      }
    });
  </script>

  <!-- Bootstrap core JavaScript-->
  <script src="<?= BASEURL; ?>/vendor/jquery/jquery.min.js"></script>
  <script src="<?= BASEURL; ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= BASEURL; ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= BASEURL; ?>/js/sb-admin-2.min.js"></script>
  <script src="<?= BASEURL; ?>/js/dist/sweetalert2.all.min.js"></script>
  <script src="<?= BASEURL; ?>/js/script.js"></script>

</body>

</html>