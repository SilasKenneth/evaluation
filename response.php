<?php
session_start();
require_once "includer.php";
require_once "includes/check_logged.php";
if(!is_hod()){
    redirect("hodlogin.php");
}
if(no_get("evaluation") || no_get("unit") || no_get("lecturer")){
    redirect("evaluations.php");
}
$unit_id = get("unit");
$eval_id = get("evaluation");
$lec_id = get("lecturer");
function process(){
}
$evaluation = Evaluation::getById($eval_id);
$unit = Unit::getById($unit_id);
$lecturer = Lecturer::getById($lec_id);
if(zero($evaluation) || zero($unit) || zero($lecturer)){
    redirect("evaluations.php");
}
$responses = Response::getByEvalAndLecturerAndUnit($unit_id, $lec_id, $eval_id);
$normalize = array();
$norm = array(1 => "silas");
foreach ($responses as $response) {
    $quiz = $response->getQuestion();
    $q_id = $quiz->getId();
    if(array_key_exists($q_id, $normalize)){
        array_push($normalize[$q_id], $response);
    } else{
//        $r = array($q_id, $response);
        $normalize[$q_id] = array($response);
    }
}
$results = $normalize;
//$results = [];
?>
<?php
$schools  = [];
//print_r($_SESSION['user_type'] === "hod");
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
    <h5>Response for <?= Lecturer::getById($lec_id)->getName() ?> for the unit <?= Unit::getById($unit_id)->getTitle() ?></h5>
    <hr>
    <?php
      if(zero($results)){
    ?>
      <h3 class="center text-center text-warning">Sorry for that</h3>
          <p class="text-center font-weight-light font-italic"><small>We are sorry there are no responses currently in our database</small></p>
    <?php } else{
          $i = 1;
          foreach ($results as $key => $result){
          ?>
              <h5 class="text-secondary font-italic"><?= $i.". ". Question::getById($key)->getContent() ?></h5>
              <?php if(zero($result)) { ?>
                  <p class="text-center text-warning">There are no responses for this question</p>
    <?php } else {
                  foreach ($result as $item){
                  ?>
                      <p> <?= $item->getValue() ?> </p>
    <?php
              }} $i++; } }?>
</div>
<?php
include_once "includes/scripts.php";
?>
</body>
</html>