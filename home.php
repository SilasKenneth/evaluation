<?php
session_start();
require_once "includer.php";
require_once "includes/check_logged.php";
if(!is_student()){
  redirect("index.php");
}
$student = new Student();
$logged = $student->getById($_SESSION['id']);
if(!$logged){
 redirect("index.php");
}
$evaluation = Evaluation::getCurrentActive();
$my_units = $logged->getMyUnits();
$notdone = $logged->getEvaluationNotDone();
//print_r($notdone);
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Lecturer Evaluation - Student Portal</title>
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
include_once "includes/student_nav_logged_in.php";
?>

<div class="clearfix"></div>
<br><br>
<div class="col-md-8 offset-2">
    <?php
      if(zero($notdone) || zero($evaluation)) {
          ?>
          <h3 class="text-success text-center center">Holla!</h3>
          <p class="text-center">
              <small class="text-secondary">You are the fastest student in the world looks like you're done with your evaluations check on later. We really appreciate your effort towards helping us help you get better services</small>
          </p>
          <?php
      } else{
    ?>
    <p class="font-weight-light text-center"><span class="text-success"><i class="fa fa-info-circle"></i></span> To get started please select a unit for a given lecturer you have not assessed
             complete the form
         </p>
          <br>
          <div class="list-group">
              <?php foreach ($notdone as $item) { ?>
              <a href="evaluate.php?unit=<?= $item->getId() ?>" class="list-group-item list-group-item-action flex-column align-items-start bg-success text-white">
                  <div class="d-flex w-100 justify-content-between">
                      <h5 class="mb-1"><strong><?= $item->getCode() ?></strong>  <?= $item->getTitle() ?></h5>
                      <small><?= $item->getLecturer()->getName() ?></small>
                  </div>
<!--                  <p class="mb-1"><small class="float-right">Silas Kenneth</small></p>-->
                  <small class="text-muted"></small>
              </a>
              <?php } ?>
          </div>
    <?php } ?>
    </div>
<?php
require_once "includes/scripts.php";
?>
</body>
</html>
