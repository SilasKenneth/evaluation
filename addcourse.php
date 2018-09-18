<?php
session_start();
require_once "includer.php";
if(!is_admin()){
    redirect("adminlogin.php");
}
$name = post("name");
$department = post("department");
$departments = Department::all();
function process(){
    if(!no_post("save")){
        $department = post("department");
        $name = post("name");
        if(empty($name) || empty($department)){
            return "Please select a department and give the course name";
        }

        $saved = Course::save($name, $department);
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
    $success = "The course was successfully saved.";
    $error = null;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add course</title>
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
    <h3 class="text-center">Add course</h3>
    <br>
    <?php if($error) {?>
      <p class="bg-danger text-white p-2"><?= $error ?></p>
    <?php } else if($success) {?>
        <p class="bg-success text-white p-2"><?= $success ?></p>
    <?php } ?>
    <form method="post">
        <input type="text" name="name" class="form-control" placeholder="Course title" value="<?= $name ?>"><br>
        <label>Department</label>
        <select class="custom-select" name="department">
            <option value="">Select Department</option>
            <?php if(!zero($departments)){ ?>
                <?php foreach ($departments as $depart){
                    ?>
                    <option value="<?= $depart->getId() ?>"><?= $depart->getName() ?></option>
            <?php } }?>
        </select>
        <br><br>
        <button class="btn btn-primary btn-block btn-sm" name="save" type="submit">Save course</button>
    </form>
</div>
<?php include_once "includes/scripts.php"; ?>
</body>
</html>
