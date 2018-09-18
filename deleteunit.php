<?php
session_start();
require_once "includer.php";
require_once "includes/check_logged.php";
if(no_get("unit")){
    redirect("courses.php");
}
if(!is_hod()){
    //redirect("index.php");
}
$id = get("unit");
if(empty($id)){
    redirect("courses.php");
}
$unit = Unit::getById($id);
//print_r($unit);
if(zero($unit)){
    redirect("courses.php");
}
$course = $unit->getCourse();
$department = $course->getDepartment();
//print_r(session("id"));
$logged = Hod::getById(session("id"));
if(zero($logged)){
    redirect("index.php");
}
//print_r($logged1);
$logged_department = $logged->getDepartment();
if(zero($logged_department)){
    redirect("courses.php");
} else{
    if($logged_department->getId() !== $department->getId()){
        redirect("courses.php");
    }
    else{
        $unit_handler = new Unit();
        $res = $unit_handler->delete($unit->getId());
//        $url = "units.php?course=".$course->getId();
//        $url = urlencode($url);
//        print_r($url);
        header("location: units.php?course=".$course->getId());
//        redirect($url);
    }
}
redirect("units.php?course=".$course->getId());

