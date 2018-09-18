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
$schools = School::all();
?>
<html>
<head>
    <title>Schools</title>
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
    <?php if(!zero($schools)){
        ?>
        <h4 class="text-center text-secondary">Schools</h4>
        <?php if(is_admin()) {?>
            <a href="addschool.php" class="float-right btn btn-success btn-sm">Add school <i class="fa fa-plus-circle"></i> </a>
        <?php } ?>
        <div class="clearfix"></div><br>
        <table class="table table-responsive-lg table-hover">
            <thead>
            <tr class="bg-primary text-white">
                <th>Number</th>
                <th>School name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; foreach ($schools as $school){ ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $school->getName() ?></td>
                    <td class="flex-row">
                        <?php if(is_hod()) {?>
                        <?php } else if(is_admin()) {?>
                            <a href="editschool.php?school=<?= $school->getId() ?>" class="btn btn-success btn-sm" title="View school"><i class="fa fa-pen"></i> </a>
                            <a href="deleteschool.php?school=<?= $school->getId() ?>" class="btn btn-danger btn-sm" title="Delete school"><i class="fa fa-trash"></i> </a>
                        <?php } ?>
                    </td>
                </tr>
                <?php $i++;} ?>
            </tbody>
        </table>
    <?php } else {?>
    <div class="col-mod-4 offset-2">
        <h2 class="text-warning text-center center">Sorry</h2>
        <p class="text-center"><small class="font-weight-light text-center font-italic">There are currently no courses available</small></p>
        <?php
        if(is_admin()){
            ?>
            <a class="btn btn-primary btn-sm offset-5" href="addcourse.php">Add some <i class="fa fa-plus-circle"></i> </a>
        <?php } }?>
    </div>
</div>
<?php
include_once "includes/scripts.php";
?>
</body>
</html>
