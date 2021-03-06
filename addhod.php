<?php
session_start();
require_once "includer.php";
if(!is_admin()){
    redirect("adminlogin.php");
}
$name = post("name");
$phone = post("phone");
$idnumber = post("idnumber");
$email = post("email");
$department = post("department");
$password = post("password");
$username = post("username");
$departments = Department::all();
function process(){
    if(!no_post("save")){
        $name = post("name");
        $phone = post("phone");
        $idnumber = post("idnumber");
        $email = post("email");
        $department = post("department");
        $password = post("password");
        $username = post("username");
//        print_r($_POST);
        if(empty($name) || empty($phone) || empty($idnumber) || empty($email) || empty($password) || empty($username) || empty($department)){
            return "All the fields are required";
        }
        $password = hash("SHA512", $password);
        $saved = Hod::save($name, $email, $phone, $idnumber, $department, $username, $password);
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
    $success = "The HOD was successfully saved.";
    $error = null;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add HOD</title>
    <?php include_once "includes/styles.php"; ?>
    <style>
        .center{
            margin-top: .1vh;
        }
    </style>
</head>
<body>
<?php include_once "includes/admin_nav_logged_in.php";?>
<div class="col-md-4 offset-4 center p-4">
    <h3 class="text-center">Add head of Department</h3>
    <br>
    <?php if($error) {?>
        <p class="bg-danger text-white p-2"><?= $error ?></p>
    <?php } else if($success) {?>
        <p class="bg-success text-white p-2"><?= $success ?></p>
    <?php } ?>
    <form method="post">
        <input type="text" name="name" class="form-control" placeholder="Legal names" value="<?= $name ?>" required><br>
        <input type="email" name="email" class="form-control" placeholder="Email address" value="<?= $email ?>" required><br>
        <input type="text" name="username" class="form-control" placeholder="Username" value="<?= $username ?>" required><br>
        <input type="tel" name="phone" class="form-control" placeholder="Phone number" value="<?= $phone ?>" required><br>
        <input type="number" name="idnumber" class="form-control" placeholder="ID or Passport" value="<?= $idnumber ?>"  min="10000000" max="40000000" required><br>
        <label>Department</label>
        <select class="custom-select" name="department" required>
            <option value="">Select Department</option>
            <?php if(!zero($departments)){ ?>
                <?php foreach ($departments as $department){ ?>
                    <option value="<?= $department->getId() ?>"><?= $department->getName() ?></option>
            <?php }}?>
        </select>
        <br><br>
        <input type="password" name="password" placeholder="Password" class="form-control" required>
        <br>
        <button class="btn btn-primary btn-block btn-sm" name="save" type="submit">Save record &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i> </button>
    </form>
</div>
<?php include_once "includes/scripts.php"; ?>
</body>
</html>
