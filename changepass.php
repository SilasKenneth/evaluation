<?php
session_start();
require_once "includer.php";
function any_empty($array){
    if(gettype($array) !== "array"){
        return true;
    }
    foreach($array as $item){
        if(gettype($item) !== "string"){
            return true;
        }
        if(empty(trim($item))){
            return true;
        }
    }
    return false;
}
function try_change(){
    $error = null;
    if(isset($_POST["submit"])){
        $currpass = isset($_POST["currpass"]) ? $_POST["currpass"] : "";
        $newpass = isset($_POST["newpass"]) ? $_POST["newpass"] : "";
        $passconf = isset($_POST["passconf"]) ? $_POST["passconf"] : "";
        if(any_empty(array($currpass, $newpass, $passconf))){
            $error = "All the fields are required. Try again";
        } else{
            $currpass = hash("SHA512", $currpass);
            $newpass = hash("SHA512", $newpass);
            $passconf = hash("SHA512", $passconf);
            $curruser = $_SESSION["id"];
            $curruser = Admin::getById($curruser);
            if($curruser->getPassword() !== $currpass){
                $error = "The current password is wrong. Retry";
            } else{
                if($newpass !== $passconf){
                    $error = "The new password and confirmation dont match";
                }else{
                    try{
                        $db = new Database();
                        $conn = $db->connection();
                        if(gettype($conn) !== "object"){
                            $error = "Something went wrong. Try again later";
                        }
                        $sql = "UPDATE admins SET password = ? WHERE id=?";
                        $query = $conn->prepare($sql);
                        $query->execute(array($newpass, $curruser->getId()));
                        return null;
                    }catch(Exception $ex){
                        $error = "Something went wrong. Try again later";
                    }
                }
            }
        }

    }
    return $error;
}
$res = try_change();
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="public/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="public/css/all.css" />
    <link rel="stylesheet" type="text/css" href="public/css/fontawesome.css" />
    <?php
    require_once "includes/styles.php";
    ?>
    <style>
        .center{
            margin-top: 18vh;
        }
    </style>
</head>
<body>
<?php
require_once "includes/admin_nav_logged_in.php";
?>
<br>
<div class="col-md-6 col-lg-6 col-sm-10 col-xl-4 offset-md-4 offset-sm-1 center">
    <form method="post">
        <p class="font-weight-light text-center">Enter your current password and new password to
            complete the password change request
        </p>
        <?php
        if(gettype($res) !== "NULL"){
            ?>
            <p class="bg-danger text-white p-2"><?php echo $res ?></p>
            <?php
        }
        ?>
        <p class="form-group">
            <input type="password" class="form-control" placeholder="Current password" name="currpass" required="required" />
        </p>
        <p class="form-group">
            <input type="password" class="form-control" placeholder="New password" name="newpass" required="required" />
        </p>
        <p class="form-group">
            <input type="password" class="form-control" placeholder="Confirm new password" name="passconf" required="required" />
        </p>
        <button class="btn btn-success btn-block" name="submit">Confirm password change &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-arrow-circle-right"></i> </button>
    </form>
</div>
<?php
require_once "includes/scripts.php";
?>
</body>
</html>
