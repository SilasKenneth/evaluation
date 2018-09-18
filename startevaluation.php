<?php
session_start();
require_once "includer.php";
if(!is_admin()){
    redirect("adminlogin.php");
}
$datee = post("enddate");
$note = post("note");
function process(){
    if(!no_post("start")){
        $date = date("Y-m-d");
        $dateend = post("enddate");
        $notes= post("note");
        if($dateend < $date){
            return "Please select a valid date. Try the date today or a date after today";
        }
        $created = Evaluation::create($dateend, $notes);
        if($created){
            Evaluation::closeAll();
        }
        return "Y";
    }
}
$error = process();
$success = null;
if($error === "Y"){
    $success = "Evaluation was successfully started";
    $error = null;
}
?>
<html>
  <head>
      <title>Start evaluation</title>
      <?php
        include_once "includes/styles.php";
      ?>
      <style>
          .center{
              margin-top: 18vh;
          }
      </style>
  </head>
  <body>
  <?php include_once  "includes/admin_nav_logged_in.php"; ?>
    <div class="col-md-4 offset-4 center">
        <h3 class="text-center">Start evaluation</h3>
        <?php if(isset($error)){

        ?>
            <p class="bg-danger text-white p-2"><?= $error ?></p>
            <?php

        } if(isset($success)) { ?>
            <p class="bg-success text-white p-2"><?= $success ?></p>
            <?php
        }
        ?>
        <form method="post">
            <p><strong>End date</strong></p>
            <input type="date" class="form-control" name="enddate" min="today" value="<?= $datee ?>" required/><br>
            <p><strong>Add some notes</strong></p>
            <textarea class="form-control" name="note" required><?= $note ?></textarea><br>
            <button class="btn btn-primary btn-block" name="start">Start evaluation &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i> </button>
        </form>
    </div>
    <?php
      include_once "includes/scripts.php";
    ?>
  </body>
</html>
