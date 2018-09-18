<?php
session_start();
require_once "includer.php";
if(!is_admin()){
    redirect("adminlogin.php");
}
$field = "evaluation";
$page = "evaluations.php";
if(no_get($field)){
    redirect($page);
}
$id = get($field);
$evaluation = Evaluation::getById($id);
if(zero($evaluation)){
    redirect($page);
}
if(!no_post("save")){
    print_r($_POST);
}
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Lecturer Evaluation - Extend Evaluation</title>
    <?php
    require_once "includes/styles.php";
    ?>
    <style>
        .center{
            margin-top: 20vh;
        }
        .navbar .dropdown-menu-right{
            left:auto;
            right:0;
        }
    </style>
</head>
<body>
<?php
include_once "includes/admin_nav_logged_in.php";
?>

<div class="clearfix"></div>
<br><br>
<div class="col-md-8 offset-2">

</div>
<?php
require_once "includes/scripts.php";
?>
</body>
</html>
