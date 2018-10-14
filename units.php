<?php
session_start();

require_once "includer.php";
require_once "includes/check_logged.php";

if(!isset($_GET['course'])){
    redirect("courses.php");
}
$id = trim($_GET['course']);
if($id === ""){
    redirect("courses.php");
}
$course = Course::getById($id);
//if(!is_hod()){
//    redirect("index.php");
//}
if(zero($course)){
    redirect("courses.php");
}
$units = $course->getUnits();
?>
<html>
<head>
    <title>Informatics units</title>
    <?php
    include_once "includes/styles.php";
    ?>
</head>
<body>
<?php include_once "includes/hod_logged_in.php"; ?>
<div class="col-md-9 offset-2 align-content-center center-small">
    <a href="addunit.php?course=<?= $id ?>" class="btn btn-success btn-sm">Create unit&nbsp;&nbsp;&nbsp;<i class="fa fa-plus-circle"></i> </a>
    <div class="clearfix"></div>
    <br><br>
    <?php
      if(count($units) === 0){
          ?>
          <p class="font-weight-light text-center">There are currently no units for <strong class="font-italic"><?= $course->getName() ?> </strong></p>
          <?php
      } else{
          ?>
          <table class="table table-responsive-lg table-responsive table-light table-hover">
              <thead>
                <tr class="bg-primary text-white">
                    <th>ID</th>
                    <th>Unit Code</th>
                    <th>Unit Title</th>
                    <th>Year of study</th>
                    <th>Semester</th>
                    <th>Actions</th>
                </tr>
              </thead>
              <tbody>

              <?php $i = 1;
              foreach ($units as $unit){ ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= $unit->getCode() ?></td>
                    <td><?= $unit->getTitle() ?></td>
                    <td><?= $unit->getYearOfStudy() ?></td>
                    <td><?= $unit->getSemester() ?></td>
                    <td>
<!--                        <div class="btn-group btn-group-sm text-white">-->
                            <a class="btn btn-outline-primary btn-sm" href="editunit.php?unit=<?= $unit->getId() ?>"><i class="fa fa-edit"></i> </a>
                            <a class="btn btn-outline-danger btn-sm" href="deleteunit.php?unit=<?= $unit->getId() ?>"><i class="fa fa-trash"></i> </a>
<!--                        </div>-->
                    </td>
                </tr>
              <?php $i++; } ?>
              </tbody>
          </table>
          <?php
      }
    ?>
</div>
<?php
include_once "includes/scripts.php";
?>
</body>
</html>
