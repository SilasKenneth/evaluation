<?php
session_start();
require_once "includer.php";
require_once "includes/check_logged.php";
if(!is_hod_or_admin()){
    redirect("sudo.php");
}
if(is_admin()){

}
function process(){
}
//TODO: This is for both hod and admin but hod can only view courses in his department
?>
<?php
//print_r($_SESSION['user_type'] === "hod");
$courses = Course::all();
if(is_hod()){
    $hod = Hod::getById($_SESSION['id']);
//    $dp = new Hod();
    $courses = $hod->getCourses();
}
?>
<html>
<head>
    <title>Courses</title>
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
    <?php if(!zero($courses)){
        ?>
    <h4 class="text-center text-secondary">Courses</h4>
        <?php if(is_admin()) {?>
            <a href="addcourse.php" class="float-right btn btn-success btn-sm">Create course <i class="fa fa-plus-circle"></i> </a>
            <?php } ?>
        <div class="clearfix"></div><br>
    <table class="table table-responsive-lg table-hover">
        <thead>
          <tr class="bg-primary text-white">
              <th>Number</th>
              <th>Course name</th>
              <?php if(is_admin()){ ?>
              <th>School</th>
              <th>Department</th>
              <?php } ?>
              <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; foreach ($courses as $course){ ?>
              <tr>
                  <td><?= $i ?></td>
                  <td><?= $course->getName() ?></td>
                  <?php if(is_admin()) { ?>
                  <td><?= $course->getDepartment()->getSchool()->getName() ?></td>
                  <td><?= $course->getDepartment()->getName() ?></td>
                  <?php } ?>
                  <td class="flex-row">
                      <?php if(is_hod()) {?>
                          <a href="units.php?course=<?= $course->getId() ?>" class="btn btn-success btn-sm" title="View units"><i class="fa fa-school"></i> </a>
                      <?php } else if(is_admin()) {?>
                          <a href="editcourse.php?course=<?= $course->getId() ?>" class="btn btn-primary btn-sm" title="View units"><i class="fa fa-pen"></i> </a>
                          <a href="deletecourse.php?course=<?= $course->getId() ?>" class="btn btn-danger btn-sm" title="Delete unit"><i class="fa fa-trash"></i> </a>
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
