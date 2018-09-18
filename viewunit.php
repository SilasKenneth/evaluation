<?php
session_start();

require_once "includer.php";
require_once "includes/check_logged.php";

if(!isset($_GET['unit'])){
    redirect("units.php");
}
$id = trim($_GET['unit']);
if($id === ""){
    redirect("units.php");
}
$unit = Unit::getById($id);
//if(!is_hod()){
//    redirect("index.php");
//}
if(count($unit) === 0){
    redirect("units.php");
}
?>
<html>
<head>
    <title><?= $unit->getTitle() ?></title>
    <?php
    include_once "includes/styles.php";
    ?>
</head>
<body>
<div class="col-md-6 offset-3 align-content-center center-small">
    <?php
      print_r($unit);
    ?>
</div>
<?php
include_once "includes/scripts.php";
?>
</body>
</html>
