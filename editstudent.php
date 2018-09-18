<?php
session_start();
require_once "includer.php";
require_once "includes/check_logged.php";
if(!is_admin()){
    redirect("adminlogin.php");
}
function process(){
}
//TODO: This is for both hod and admin but hod can only view courses in his department
?>
<?php
//print_r($_SESSION['user_type'] === "hod");
$students = Student::all();
?>
<html>
<head>
    <title>Students</title>
    <?php
    include_once "includes/styles.php";
    ?>
    <style type="text/css">
        .center{
            margin-top: 23vh;
        }
    </style>
</head>
<body>
<?php
include_once "includes/admin_nav_logged_in.php";
?>
<div class="col-md-8 offset-2 mt-4">
</div>
<?php
include_once "includes/scripts.php";
?>
</body>
</html>
