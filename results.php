<?php
session_start();
require_once "includer.php";
require_once "includes/check_logged.php";
if(!is_hod()){
    redirect("hodlogin.php");
}
if(no_get("evaluation")){
    redirect("evaluations.php");
}
$id = get("evaluation");
function process(){
}
//TODO: This is for both hod and admin but hod can only view courses in his department
?>
<?php
$schools  = [];
//print_r($_SESSION['user_type'] === "hod");
$depa = Department::getById(Hod::getById(session("id"))->getDepartment()->getId());
//print_r($depa);
$results = $depa->getResults($id);
?>
<html>
<head>
    <title>Results</title>
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
include_once "includes/hod_logged_in.php";
?>
<div class="col-md-8 offset-2 mt-4">
    <?php if(!zero($results)){
        ?>
        <h4 class="text-center text-secondary">Results</h4>
        <?php if(is_admin()) {?>
            <a href="addschool.php" class="float-right btn btn-success btn-sm">Add school <i class="fa fa-plus-circle"></i> </a>
        <?php } ?>
        <div class="clearfix"></div><br>
        <table class="table table-responsive-lg table-hover">
            <thead>
            <tr class="bg-primary text-white">
                <th>Number</th>
                <th>Unit Code</th>
                <th>Lecturer</th>
                <th>Score</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 1; foreach ($results as $res){ ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $res->getUnit()->getCode() ?></td>
                    <td><?= $res->getLecturer()->getName() ?></td>
                    <td><?= $res->getAverage() ?></td>
                    <td class="flex-row">
                        <a href="response.php?lecturer=<?= $res->getLecturer()->getId() ?>&unit=<?= $res->getUnit()->getId() ?>&evaluation=<?= $id ?>" class="btn btn-success btn-sm" title="View school"><i class="fa fa-pen"></i> </a>
                    </td>
                </tr>
                <?php $i++;} ?>
            </tbody>
        </table>
    <?php } else {?>
    <div class="col-mod-4 offset-2">
        <h2 class="text-warning text-center center">Sorry</h2>
        <p class="text-center"><small class="font-weight-light text-center font-italic">There are no results to show please check on later</small></p>
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
