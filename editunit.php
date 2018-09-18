<?php
session_start();
require_once "includer.php";
if(!is_hod()){
    redirect("hodlogin.php");
}
if(no_get("unit")){
    redirect("courses.php");
}
$id = get("unit");
if(empty($id)){
    redirect("courses.php");
}
$unit = Unit::getById($id);
if(zero($unit)){
    redirect("courses.php");
}

$title = $unit->getTitle();
$code = $unit->getCode();
$year = $unit->getYearOfStudy();
$semester = $unit->getSemester();
$course_id = $unit->getCourse();
$lecturer = $unit->getLecturer();
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
        $course = post("course");
        $lecturer = post("lecturer");
        if(empty($title) || empty($course) || empty($code) || empty($year) || empty($semester) || empty($lecturer)){
            return "Please select a department and give the course name";
        }

        $unit = Unit::getById(get("unit"));
//        print_r($unit);
        $saved = $unit->updates($title, $code, $year, $semester, $course, $lecturer);
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
    <title>Edit Unit</title>
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
    <h3 class="text-center">Edit Unit</h3>
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
        <label>Course</label>
        <select class="custom-select" name="course">
            <option value="">Select Course</option>
            <?php if(!zero($courses)){ ?>
                <?php foreach ($courses as $course){
                    ?>
                    <option value="<?= $course->getId() ?>"><?= $course->getName() ?></option>
                <?php } }?>
        </select><br><br>
        <label>Lecturer(Optional)</label>
        <select class="custom-select" name="lecturer">
            <option value="0">Select Lecturer</option>
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
