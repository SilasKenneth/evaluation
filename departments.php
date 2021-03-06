<?php
session_start();
require_once "includer.php";
require_once "includes/check_logged.php";
if(!is_admin()){
    redirect("adminlogin.php");
}
function process(){
}
?>
<?php
//print_r($_SESSION['user_type'] === "hod");
$departments = Department::all();
?>
<html>
<head>
    <title>Departments</title>
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
if(is_admin()){
    include_once "includes/admin_nav_logged_in.php";
} else{
    include_once "includes/hod_logged_in.php";
}
?>
<div class="col-md-8 offset-2 mt-4">
    <?php if(!zero($departments)){
        ?>
        <h4 class="text-center text-secondary">Departments</h4>
        <?php if(is_admin()) {?>
            <a href="adddepartment.php" class="float-right btn btn-success btn-sm">Add department <i class="fa fa-plus-circle"></i> </a>
        <?php } ?>
        <div class="clearfix"></div><br>
        <table class="table table-responsive-lg table-hover">
            <thead>
            <tr class="bg-primary text-white">
                <th>Number</th>
                <th>Department name</th>
                <th>School</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; foreach ($departments as $department){ ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $department->getName() ?></td>
                    <?php if(is_admin()) { ?>
                        <td><?= $department->getSchool()->getName()?></td>
                    <?php } ?>
                </tr>
                <?php $i++;} ?>
            </tbody>
        </table>
    <?php } else {?>
    <div class="col-mod-4 offset-2">
        <h2 class="text-warning text-center center">Sorry</h2>
        <p class="text-center"><small class="font-weight-light text-center font-italic">There are currently no <strong>Departments</strong> available</small></p>
        <?php
        if(is_admin()){
            ?>
            <a class="btn btn-primary btn-sm offset-5" href="adddepartment.php">Add some <i class="fa fa-plus-circle"></i> </a>
        <?php } }?>
    </div>
</div>
<?php
include_once "includes/scripts.php";
?>
</body>
</html>
