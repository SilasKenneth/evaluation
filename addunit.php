<?php
session_start();
require_once "includer.php";
if(!is_hod()){
    redirect("hodlogin.php");
}
$title = post("title");
$code = post("code");
$year = post("year");
$semester = post("semester");
$lecturer = post("lecturer");
$hod = Hod::getById(session("id"));
$dept = $hod->getDepartment();
$courses = $dept->getCourses();
$lecturers = Lecturer::all();
function process(){
    if(!no_post("save")){
        $title = post("title");
        $code = post("code");
        $year = post("year");
        $semester = post("semester");
        $lecturer = post("lecturer");
        if(empty($title) || empty($code) || empty($year) || empty($semester) || empty($lecturer)){
            return "Please select a department and give the course name";
        }
        $course = get("course");
        $saved = Unit::save($title, $code, $year, $semester, $course, $lecturer);
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
    $success = "The unit was successfully saved.";
    $error = null;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Unit</title>
    <?php include_once "includes/styles.php"; ?>
    <style>
        .center{
            margin-top: 4vh;
        }
    </style>
</head>
<body>
<?php include_once "includes/hod_logged_in.php";?>
<div class="col-md-4 offset-4 center p-4">
    <h3 class="text-center">Add Unit</h3>
    <br>
    <?php if($error) {?>
        <p class="bg-danger text-white p-2"><?= $error ?></p>
    <?php } else if($success) {?>
        <p class="bg-success text-white p-2"><?= $success ?></p>
    <?php } ?>
    <form method="post">
        <input type="text" name="title" class="form-control" placeholder="Unit title" value="<?= $title ?>"><br>
        <input type="text" name="code" class="form-control" placeholder="Unit Code eg INF100" value="<?= $code ?>"><br>
        <input type="text" name="year" class="form-control" placeholder="Year" value="<?= $year ?>"><br>
        <input type="text" name="semester" class="form-control" placeholder="Semester" value="<?= $semester ?>"><br>
        <label>Lecturer(Optional)</label>
        <select class="custom-select" name="lecturer">
            <option value="">Select Lecturer</option>
            <?php if(!zero($lecturers)){ ?>
                <?php foreach ($lecturers as $lecturer){
                    ?>
                    <option value="<?= $lecturer->getId() ?>"><?= $lecturer->getName() ?></option>
                <?php } }?>
        </select>
        <br><br>
        <button class="btn btn-primary btn-block btn-sm" name="save" type="submit">Save unit</button>
    </form>
</div>
<?php include_once "includes/scripts.php"; ?>
</body>
</html>
