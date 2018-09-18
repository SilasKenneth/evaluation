<?php
session_start();
require_once "includer.php";
require_once "includes/check_logged.php";
if(!is_admin()){
    redirect("adminlogin.php");
}
if(no_get("course")){
    redirect("courses.php");
}
$id = get("course");
if(zero($id)){
    redirect("courses.php");
}
$course = Course::getById($id);
//print_r($unit);
//print_r($course);
if(zero($course)){
    redirect("courses.php");
}

$department = $course->getDepartment();
//print_r(session("id"));
$course_handler = new Course();
$res = $course_handler->delete($course->getId());
redirect("courses.php");

