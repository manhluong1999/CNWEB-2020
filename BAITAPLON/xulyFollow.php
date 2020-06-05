<?php
ob_start(); // xóa kí tự lạ đầu file
require_once 'init.php';
require_once 'functions.php';

?>

<?php 
  include 'check-before-login.php';
  include 'header.php';
?>		

<?php
	$userID = $_GET['userID'];

	// kiểm tra xem current có theo dõi id này chưa
	$check = checkFollow($userID, $currentUser['userID']);
	if ($check) {
		cancelFollow($userID, $currentUser['userID']);
	}
	else{
		sendFollow($userID, $currentUser['userID']);
	}
	header("Location: trang-ca-nhan.php?userID=$userID");
?>

<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>