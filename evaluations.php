<?php
session_start();

require_once "includer.php";
require_once "includes/check_logged.php";
$evaluations = Evaluation::all();
?>
<html>
<head>
    <title>Evaluations</title>
    <?php
    include_once "includes/styles.php";
    ?>
</head>
<body>
<?php
if(is_admin()) {
    include_once "includes/admin_nav_logged_in.php";

} else if(is_hod()){
    include_once "includes/hod_logged_in.php";
}?>
<div class="col-md-8 offset-2 align-content-center center-small">
    <?php if(is_admin()){ ?>
    <div class="col-md-12">
        <div class="col-md-2 offset-10">
            <a href="startevaluation.php" class="btn btn-success btn-sm">Start evaluation &nbsp;&nbsp;<i class="fa fa-plus-circle"></i> </a>
        </div>
    </div>
    <?php } ?>
    <div class="clearfix"></div>
    <br><br>
    <div class="col-md-12">
    <?php
    if(zero($evaluations)){
        ?>
        <p class="font-weight-light text-center">There are currently no evaluations. Start one and it will appear here</strong></p>
        <?php
    } else{
        ?>
        <table class="table table-light table-hover">
            <thead>
            <tr class="bg-primary text-white">
                <th>ID</th>
                <th>Date started</th>
                <th>End date</th>
                <th>Status</th>
                <?php if(is_hod()){ ?>
                <th>Actions</th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>

            <?php $i = 1;
            foreach ($evaluations as $evaluation){ ?>
                <tr>
                    <td><?= $i ?></td>
                    <td><?= dater($evaluation->getStartDate()) ?></td>
                    <td><?= dater($evaluation->getEndDate()) ?></td>
                    <td><?php
                        if($evaluation->getStatus()){
                            ?>
                        <p class="badge badge-success">Open</p>
                        <?php
                        }else{
                        ?>
                            <p class="badge badge-danger">Closed</p>
                    <?php }?>
                    </td>
                    <?php if(is_hod()) { ?>
                    <td>
                        <a class="btn btn-outline-primary btn-sm" href="results.php?evaluation=<?= $evaluation->getId() ?>" title="View results"><i class="fa fa-history"></i> </a>
                    </td>
                    <?php } ?>
                </tr>
                <?php $i++; } ?>
            </tbody>
        </table>
    </div>
        <?php
    }
    ?>
</div>
<?php
include_once "includes/scripts.php";
?>
</body>
</html>
