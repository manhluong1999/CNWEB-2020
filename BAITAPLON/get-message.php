<?php
ob_start(); // xóa kí tự lạ đầu file
require_once 'init.php';
require_once 'functions.php';

?>

<?php 
  include 'check-before-login.php';
?>

<?php 
	if (isset($_GET['userID'])) {
		$userID = $_GET['userID'];

		// lấy tin nhắn mới nhất mà current nhận được từ userID
		$result = getNewMessageHTML($currentUser['userID'], $userID);
	}

	echo $result;
 ?>

<?php
ob_end_flush(); // xóa các kí tự lạ cuối file
?>