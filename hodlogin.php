<?php
session_start();
require_once "includer.php";
$username = post("username");
$password = post("password");
function try_login(){
    if(isset($_POST['login'])){
        $username = post("username");
        $password = post("password");
        if(empty(trim($username)) || empty(trim($password))){
            return "Please provide a (username or email) and password";
        }
        $check = Hod::login($username, $password);
        if(!$check){
            return "Invalid login credentials. Try again.";
        }
        $_SESSION['user_type'] = "hod";
        $_SESSION['logged'] = true;
        $_SESSION["id"] = $check->getId();
        $_SESSION['user'] = $check;
        $page = "hod_home.php";
        redirect($page);
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
</head>
<body>
<?php include_once "includes/hodadminheader.php"; ?>
<div class="col-md-6 col-lg-6 col-sm-10 col-xl-4 offset-md-4 offset-sm-1 center">
    <form method="post">
        <p class="font-weight-light text-center text-dark"><strong>HOD</strong> <br>To continue please sign in using your (Username or password) and password</p>
        <br>
        <?php if($res != ""){?>
            <p class="bg-danger text-white p-2 rounded"><?php echo $res; ?></p>
        <?php }?>
        <input type="text" placeholder="Username or email address" class="form-control" name="username" value="<?= $username ?>"/><br>
        <input type="password" placeholder="Password" class="form-control" name="password"/><br>
        <button class="btn btn-primary btn-block" type="submit" name="login">Sign in&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right pull-right"></i> </button>
    </form>
</div>
<?php
require_once "includes/scripts.php";
?>
</body>
</html>
