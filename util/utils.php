<?php

function redirect($page){
    if(file_exists($page)){
        header("location: ".$page);
    }
}

function getMonthName($month){
    $month = intval($month);
    $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    if(!isset($months[$month - 1])){
        $month = 0;
    }
    return $months[$month - 1];
}

function suffix($number){
    $suffixes = ['th', "st", 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];
    $number = intval($number) % 10;
    return $suffixes[$number];
}

function dater($date){
    $d = date_parse($date);
    $ans = $d['day'].suffix($d['day'])." ".getMonthName($d['month']).' '.$d['year'];
    return $ans;
}

function is_student(){
    if(isset($_SESSION['user_type'])){
        if($_SESSION['user_type'] === "student"){
            return true;
        }
        return false;
    }
    return false;
}

function is_admin(){
    if(isset($_SESSION['user_type'])){
        if($_SESSION['user_type'] === "admin"){
//            print_r("YES");
            return true;
        }
        return false;
    }
    return false;
}

function is_hod(){
    if(isset($_SESSION['user_type'])){
        if($_SESSION['user_type'] === "hod"){
            return true;
        }
        return false;
    }
    return false;
}

function is_hod_or_admin(){
    return is_hod() or is_admin();
}


function no_get($value){
    return !isset($_GET[$value]);
}
function no_post($value){
    return !isset($_POST[$value]);
}
function no_session($value){
    return !isset($_SESSION[$value]);
}

function get($field){
    return isset($_GET[$field]) ? trim($_GET[$field]) : "";
}

function post($field){
    return isset($_POST[$field]) ? trim($_POST[$field]) : "";
}

function zero($field){
    return !$field;
}

function session($field){
    return isset($_SESSION[$field]) ? trim($_SESSION[$field]) : "";
}