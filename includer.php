<?php
require_once "./vendor/autoload.php";
require_once "./util/utils.php";
require_once "./util/Database.php";
require_once "./includes/School.php";
require_once "./includes/Department.php";
require_once "./includes/Course.php";
require_once "./includes/Unit.php";
require_once "./includes/Hod.php";
require_once "./includes/Admin.php";
require_once "./includes/Student.php";
require_once "./includes/Lecturer.php";
require_once "./includes/Evaluation_Log.php";
require_once "./includes/Evaluation.php";
require_once "./includes/Question.php";
require_once "./includes/Result.php";
require_once "./includes/Response.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
