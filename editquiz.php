<?php
session_start();
require_once "includer.php";
require_once "includes/check_logged.php";
$is_ad = is_admin();
//Check if the currently logged in user is an admin
if(!$is_ad){
    redirect("adminlogin.php");
}
if(no_get("quiz")){
    redirect("questions.php");
}
$id = get("quiz");
$quiz = Question::getById($id);
if(zero($quiz)){
    redirect("questions.php");
}
$content = $quiz->getContent();
function process(){
    if(!no_post("save")){
        $quite_type = post("quiztype");
        $content = post("content");
        $id = get("quiz");
        $sql = "UPDATE questions SET content = ?, question_type = ? WHERE id = ?";
        $db = new Database();
        $conn = $db->connection();
        if(gettype($conn) !== "object"){
            return "There was a problem saving the edits. Try again";
        }
        $query = $conn->prepare($sql);
        if(!$query){
            return "There was a problem saving the edit";
        }
        $query->execute(array($content, $quite_type, $id));
            //return "There was a problem saving the question. Try again";
        return "Y";
    }
}
$success = null;
$res = process();
if($res === "Y"){
    $success = "The question was successfuly added";
    $res = null;
}

?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="public/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="public/css/all.css" />
    <link rel="stylesheet" type="text/css" href="public/css/fontawesome.css" />
    <?php
    require_once "includes/styles.php";
    ?>
    <style>
        .center{
            margin-top: 20vh;
        }
    </style>
</head>
<body>
<?php  include_once "includes/admin_nav_logged_in.php"; ?>
<div class="col-md-6 col-lg-6 col-sm-10 col-xl-4 offset-md-4 offset-sm-1 center">
    <h3 class="text-center">Edit Question</h3>
    <?php if($res) { ?>
        <p class="bg-danger p-2 text-white"><?= $res ?></p>
    <?php } else if($success) {?>
        <p class="bg-success p-2 text-white"><?= $success ?></p>
    <?php } ?>
    <form method="post">
        <br>
        <label class="font-weight-bold">Question type</label>
        <select name="quiztype" class="form-control">
            <option value="1">Multiple choice</option>
            <option value="2">Open ended</option>
        </select><br>
        <label class="font-weight-bold">Question content</label>
        <textarea class="form-control" name="content" rows="4" required><?= $content ?></textarea><br>
        <button class="btn btn-primary btn-block" type="submit" name="save">Save to database &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right pull-right"></i> </button>
    </form>
</div>
<?php
require_once "includes/scripts.php";
?>
</body>
</html>



