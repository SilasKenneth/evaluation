<?php
session_start();
require_once "includer.php";
$username = isset($_POST['username']) ? $_POST['username'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";
function try_login(){
  if(isset($_POST['login'])){
      $username = isset($_POST['username']) ? $_POST['username'] : "";
      $password = isset($_POST['password']) ? $_POST['password'] : "";
      if(empty(trim($username)) || empty(trim($password))){
          return "Please provide a Registration number/email and password";
      }
      $check = Student::login($username, $password);
      if(!$check){
          return "Invalid login credentials. Try again.";
      }
      $_SESSION['user_type'] = "student";
      $_SESSION['logged'] = true;
      $_SESSION["id"] = $check->getId();
      $_SESSION['user'] = $check;
      header("Location: home.php");
  }
}
$res = "";
$res = try_login();
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="public/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="public/css/all.css" />
    <link rel="stylesheet" type="text/css" href="public/css/fontawesome.css" />
    <?php
     require_once "includes/styles.php";
    ?>
    <style>
        .center{
            margin-top: 20vh;
        }
    </style>
    <title>Lecturer Evaluation Student Login</title>
</head>
<body>
<?php include_once  "includes/header.php"; ?>
   <div class="col-md-6 col-lg-6 col-sm-10 col-xl-4 offset-md-4 offset-sm-1 center">
       <form method="post">
           <p class="font-weight-light text-center text-dark">To continue please sign in using your username or email and password</p>
           <br>
           <?php if($res != ""){?>
               <p class="bg-danger text-white p-2 rounded"><?php echo $res; ?></p>
           <?php }?>
           <input type="text" placeholder="Registration or Email" class="form-control" name="username" value="<?= $username ?>"/><br>
           <input type="password" placeholder="Password" class="form-control" name="password"/><br>
           <button class="btn btn-primary btn-block" type="submit" name="login">Sign in&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right pull-right"></i> </button>
       </form>
   </div>
   <?php
   require_once "includes/scripts.php";
   ?>
</body>
</html>
