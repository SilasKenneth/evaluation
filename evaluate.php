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
if(no_get("unit")){
    redirect("home.php");
}
$id = get("unit");
$unit = Unit::getById($id);
if(zero($unit)){
    redirect("home.php");
}
$mine = $logged->isMyUnit($unit->getId());
if(!$mine){
    redirect("home.php");
}

$evaluation = Evaluation::getCurrentActive();
if(zero($evaluation)){
    redirect("home.php");
}
//print_r($evaluation);
$questions = $evaluation->getQuestions();

function process($uni, $evalu){
//    print_r($_POST);
    if(!no_post("submit")){
        $keys = array_keys($_POST);
        $multiples = array();
        $oneanswer = array();
        foreach ($keys as $key){
            $needed = explode("_", $key);
            if($needed[0] === "quiz"){
               if(intval($needed[2]) === 1){
                   array_push($multiples, $_POST[$key]);
               } else if(intval($needed[2]) === 2){
                   array_push ($oneanswer, [$needed[1], $_POST[$key]]);
               }
            }
        }
        $average = 0;
        if(count($multiples) !== 0) {
            $average = array_reduce($multiples, function ($a, $b) {
                    return $a + $b;
                }) / count($multiples);
        }
        $respone = Evaluation::castVote(session("id"), $uni->getId(), $uni->getLecturer()->getId(), $average, $evalu->getId(), $oneanswer);
        redirect("home.php");
    }
}
process($unit, $evaluation);

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
<div class="col-md-5 offset-3">

    <?php  if(zero($questions)){?>
        <h3 class="center text-warning text-center">Sorry for that</h3>
        <p class="text-secondary text-center">We are sorry but we ask for your patient. It's not your mistake its ours, we are yet to add questions. Check back later</p>
    <?php }  else{?>
      <h3><?= $unit->getLecturer()->getName() ?> - <span class="font-weight-light"><?= $unit->getTitle() ?></span> </h3>
    <br>
        <form method="post">
    <?php
      $i = 1;
      foreach ($questions as $question){
    ?>
         <?php  $str = 'quiz_' . $i . '_' . $question->getQuestionType(); ?>
          <p class="text-dark font-italic"><strong><?= $i ?>. </strong><?= $question->getContent() ?></p>
          <?php if(intval($question->getQuestionType()) === 1){

              ?>
               <p><input type="radio" name="<?=$str ?>" id="<?= $str.'_'.($i+1) ?>" value="5" class="radio radio-danger" required><label for="<?= $str.'_'.($i+1) ?>"> Excellent</label>
               <input type="radio" name="<?=$str ?>" id="<?= $str.'_'.($i+2) ?>" value="4" required> <label for="<?= $str.'_'.($i+2) ?>"> Very Good</label>
               <input type="radio" name="<?=$str ?>" id="<?= $str.'_'.($i+3) ?>" value="3" required> <label for="<?= $str.'_'.($i+3) ?>">Good</label>
                <input type="radio" name="<?=$str ?>" id="<?= $str.'_'.($i+4) ?>" value="2" required> <label for="<?= $str.'_'.($i+4) ?>">Average</label>
                   <input type="radio" name="<?=$str ?>" id="<?= $str.'_'.($i+5) ?>" value="1" required> <label for="<?= $str.'_'.($i+5) ?>">Poor</label> </p>
              <?php
          } else {
              ?>
                  <textarea name="<?= $str ?>" class="form-control"  required></textarea>
              <?php
          }
              ?>
          <br>
          <?php $i++; } ?>
            <button class="btn btn-success btn-block" type="submit" name="submit" value="1">Submit evaluation &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <i class="fa fa-arrow-circle-right"></i> </button>
            <?php } ?>
            <br>
        </form>
</div>
<?php
require_once "includes/scripts.php";
?>
</body>
</html>
