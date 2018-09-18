<?php
session_start();
require_once "includer.php";
require_once "includes/check_logged.php";
if(!is_admin()){
    redirect("adminlogin.php");
}
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="public/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="public/css/all.css" />
    <link rel="stylesheet" type="text/css" href="public/css/fontawesome.css" />
    <title>Admin</title>
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
<!--<a href="logout.php" class="float-right">Sign out</a>-->
<?php
include_once "includes/admin_nav_logged_in.php";
?>
<div class="clearfix"></div>
<div class="col-md-8 offset-3 center">
    <a class="btn btn-primary text-white p-2 rounded col-md-4 m-4" href="evaluations.php">
        <span><i class="fa fa-chalkboard-teacher fa-4x"></i></span>
        <br><br>
        <strong>Evaluations</strong>
    </a>
    <a class="btn btn-primary text-white p-2 rounded col-md-4" href="questions.php">
        <span><i class="fa fa-question-circle fa-4x"></i></span>
        <br><br>
        <strong>Questions Management</strong>
    </a>
    <br><br>
</div>
<?php
require_once "includes/scripts.php";
?>
</body>
</html>
