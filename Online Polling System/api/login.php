<?php

session_start();
include("connect.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$mobile = $_POST['mobile'];
$password = $_POST['password'];
$role = $_POST['role'];

$check = mysqli_query($connect, "SELECT * FROM user WHERE mobile='$mobile' AND password='$password' AND role='$role'");

if ($check && mysqli_num_rows($check) > 0) {
    $userdata = mysqli_fetch_array($check, MYSQLI_ASSOC);
    $groups = mysqli_query($connect, "SELECT * FROM user WHERE role=2");
    $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

    $_SESSION['userdata'] = $userdata;
    $_SESSION['groupsdata'] = $groupsdata;

    header("Location: ../routes/dashboard.php");
    exit();
} else {
    $_SESSION['error'] = "Invalid Credentials or User not found";
    header("Location: ../");
    exit();
}
?>