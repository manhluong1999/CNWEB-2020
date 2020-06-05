<?php
ob_start(); // xóa kí tự lạ đầu file
	if (!isset($_SESSION['userID'])) {
  		header('Location: login.php');
  	}
  	else{
  		$currentUser = getCurrentUser();
  	}
ob_end_flush(); // xóa các kí tự lạ cuối file
?>