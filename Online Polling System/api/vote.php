<?php
session_start();
include('connect.php');
$votes = (int)$_POST['gvotes'];
$total_votes = $votes + 1;
$gid = (int)$_POST['gid'];
$uid = (int)$_SESSION['userdata']['id']; 
$update_votes = mysqli_query($connect, "UPDATE user SET votes='$total_votes' WHERE id='$gid'");
$update_user_status = mysqli_query($connect, "UPDATE user SET status=1 WHERE id='$uid'");
if ($update_votes && $update_user_status) {
    $groups = mysqli_query($connect, "SELECT * FROM user WHERE role=2");
    $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);    
    $_SESSION['userdata']['status'] = 1;
    $_SESSION['groupsdata'] = $groupsdata;
    $_SESSION['success'] = "Voting successful!";
    header("Location: ../routes/dashboard.php");
    exit();
} else {
    $_SESSION['error'] = "Some error occurred while voting.";
    header("Location: ../routes/dashboard.php");
    exit();
}
?>