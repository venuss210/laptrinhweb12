<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.80.0">
  <title>Adminstration Login</title>

  <!-- Bootstrap core CSS -->
  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">



  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>


  <!-- Custom styles for this template -->
  <link href="signin.css" rel="stylesheet">
</head>

<?php
include "../includes/database.php";
include "../includes/users.php";
$database = new database();
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $db = $database->connect();
  $new_user = new user($db);
  $new_user->v_email = $_POST['email'];
  $new_user->v_password = md5($_POST['password']);
  if($result = $new_user->login()){
    session_start();
    $num = $result->rowCount();
    $row = $result->fetch();
    if ($num > 0) {
      $_SESSION['user_id'] = $row['n_user_id'];
      header("location:../index.php");
    } else {
      $flag = "Login failed";
    }
  }
}

?>

<body class="text-center">

  <form class="form-signin" method="POST" action="">
    <img class="mb-4" src="assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <?php
    if (isset($flag)) {
    ?>
      <div class="alert alert-danger">
        <strong><?php echo $flag ?><strong>
      </div>
    <?php
    }
    ?>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2021-2022</p>
  </form>



</body>

</html>