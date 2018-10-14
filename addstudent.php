<?php
session_start();
require_once "includer.php";
if(!is_admin()){
    redirect("adminlogin.php");
}
$firstname = post("firstname");
$surname = post("surname");
$lastname = post("lastname");
$registration = post("reg");
$course = post("course");
$year = post("year");
$semester = post("sem");
$phone = post("phone");
$email = post("email");
$username = post("username");
$password = $registration;
$courses = Course::all();

function process(){
    if(!no_post("save")){
        $firstname = post("firstname");
        $surname = post("surname");
        $lastname = post("lastname");
        $registration = post("reg");
        $course = post("course");
        $year = post("year");
        $semester = post("sem");
        $phone = post("phone");
        $email = post("email");
        $username = post("username");
        $password = $registration;
        if(empty($firstname) || empty($lastname) || empty($surname) || empty($registration) || empty($course) || empty($year) ||
        empty($semester) || empty($phone) || empty($email) || empty($username)){
            return "All the fields are required";
        }

        $stud = new Student();
        $stud->create($firstname, $surname, $lastname, $registration, $course, $year, $semester, 1, $phone,
            $email, $username, $password);
        $saved = $stud->save();
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
    $success = "The student was successfully saved.";
    $error = null;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add new student</title>
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
    <h3 class="text-center">Add Student</h3>
    <p class="small">The default password will be set to the student's admission number</p>
    <br>
    <?php if($error) {?>
        <p class="bg-danger text-white p-2"><?= $error ?></p>
    <?php } else if($success) {?>
        <p class="bg-success text-white p-2"><?= $success ?></p>
    <?php } ?>
    <form method="post">
        <input type="text" name="firstname" class="form-control" placeholder="Firstname" value="<?= $firstname ?>" required><br>
        <input type="text" name="surname" class="form-control" placeholder="Surname" value="<?= $surname ?>" required><br>
        <input type="text" name="lastname" class="form-control" placeholder="Lastname" value="<?= $lastname ?>" required><br>
        <input type="text" name="reg" class="form-control" placeholder="Registration" value="<?= $registration ?>" required><br>
        <label>Course</label>
        <select name="course" class="custom-select" required>
            <?php if(!zero($courses)){
                foreach ($courses as $cours) {
                ?>
                    <option value="<?= $cours->getId() ?>"><?= $cours->getName() ?></option>
            <?php } }else { ?>
               <option value="">No courses available</option>
            <?php } ?>
        </select><br>
        <label>Year of study</label>
        <select name="year" class="custom-select" required>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
            <option value="4">Four</option>
            <option value="5">Five</option>
        </select><br>
        <label>Semester</label>
        <select name="sem" class="custom-select" required>
            <option value="1">First</option>
            <option value="2">Second</option>
            <option value="3">Third</option>
        </select><br><br>
        <input type="tel" name="phone" class="form-control" placeholder="Phone number" value="<?= $phone ?>" required><br>
        <input type="email" name="email" class="form-control" placeholder="Email address" value="<?= $email ?>" required><br>
        <input type="text" name="username" class="form-control" placeholder="Username" value="<?= $username ?>" required><br>
        <button class="btn btn-primary btn-block btn-sm" name="save" type="submit">Save record &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i> </button>
    </form>
</div>
<?php include_once "includes/scripts.php"; ?>
</body>
</html>
