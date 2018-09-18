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
$hods = Hod::all();
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
    <?php if(!zero($hods)){
        ?>
        <h4 class="text-center text-secondary">Head of Departments</h4>
        <?php if(is_admin()) {?>
            <a href="addhod.php" class="float-right btn btn-success btn-sm">Add Head Of Department <i class="fa fa-plus-circle"></i> </a>
        <?php } ?>
        <div class="clearfix"></div><br>
        <table class="table table-responsive-lg table-hover">
            <thead>
            <tr class="bg-primary text-white">
                <th>Number</th>
                <th>Full name</th>
                <th>Department name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; foreach ($hods as $hod){
                ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $hod->getFullname() ?></td>
                    <?php if(is_admin()) { ?>
                        <td><?= !zero($hod->getDepartment()) ? $hod->getDepartment()->getName() : "N/A" ?></td>
                    <?php } ?>
                    <td class="flex-row">
                        <?php if(is_hod()) {?>
                            <a href="units.php?course=<?= $hod->getId() ?>" class="btn btn-success btn-sm" title="View units"><i class="fa fa-school"></i> </a>
                        <?php } else if(is_admin()) {?>
                            <a href="editlecturer.php?course=<?= $hod->getId() ?>" class="btn btn-primary btn-sm" title="Edit lecturer"><i class="fa fa-edit"></i> </a>
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
