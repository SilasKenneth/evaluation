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
$lecturers = Lecturer::all();
?>
<html>
<head>
    <title>Lecturers</title>
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
    <?php if(!zero($lecturers)){
        ?>
        <h4 class="text-center text-secondary">Lecturers</h4>
        <?php if(is_admin()) {?>
            <a href="addlecturer.php" class="float-right btn btn-success btn-sm">Add lecturer <i class="fa fa-plus-circle"></i> </a>
        <?php } ?>
        <div class="clearfix"></div><br>
        <table class="table table-responsive-lg table-hover">
            <thead>
            <tr class="bg-primary text-white">
                <th>Number</th>
                <th>Legal Name</th>
                <?php if(is_admin()){ ?>
                    <th>Id Number</th>
                    <th>Phone</th>
                    <th>Email</th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; foreach ($lecturers as $lecturer){ ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $lecturer->getName() ?></td>
                    <?php if(is_admin()) { ?>
                        <td><?= $lecturer->getIdNumber()?></td>
                        <td><?= $lecturer->getPhone() ?></td>
                        <td><?= $lecturer->getEmail() ?></td>
                    <?php } ?>
                </tr>
                <?php $i++;} ?>
            </tbody>
        </table>
    <?php } else {?>
    <div class="col-mod-4 offset-2">
        <h2 class="text-warning text-center center">Sorry</h2>
        <p class="text-center"><small class="font-weight-light text-center font-italic">There are currently no Lecturers available</small></p>
        <?php
        if(is_admin()){
            ?>
            <a class="btn btn-primary btn-sm offset-5" href="addlecturer.php">Add some <i class="fa fa-plus-circle"></i> </a>
        <?php } }?>
    </div>
</div>
<?php
include_once "includes/scripts.php";
?>
</body>
</html>
