<?php
session_start();
require_once "includer.php";
if(!is_admin()){
    redirect("adminlogin.php");
}
$name = post("name");
function process(){
    if(!no_post("save")){
        $name = post("name");
        if(empty($name)){
            return "Please provide a name for the school";
        }

        $saved = School::save($name);
        if(!$saved){
            return "There was problem saving the record. Try again later";
        }
        return "Y";
    }
    return null;
}
$error = process();
$success = null;
if($error === "Y"){
    $success = "The school was successfully saved.";
    $error = null;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Department</title>
    <?php include_once "includes/styles.php"; ?>
    <style>
        .center{
            margin-top: 12vh;
        }
    </style>
</head>
<body>
<?php include_once "includes/admin_nav_logged_in.php";?>
<div class="col-md-4 offset-4 center p-4">
    <h3 class="text-center">Add department</h3>
    <br>
    <?php if($error) {?>
        <p class="bg-danger text-white p-3"><?= $error ?></p>
    <?php } else if($success) {?>
        <p class="bg-success text-white p-3"><?= $success ?></p>
    <?php } ?>
    <form method="post">
        <input type="text" name="name" class="form-control" placeholder="School name" value="<?= $name ?>"><br>
        <button class="btn btn-primary btn-block btn-sm" name="save" type="submit">Save course</button>
    </form>
</div>
<?php include_once "includes/scripts.php"; ?>
</body>
</html>
