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
	$postID = $_GET['postID'];
	$content = $_GET['content'];

	insertCmtForPost($postID, $currentUser['userID'], $content);
	$result = inDSCmtHTML($postID);
?>

<?php 
	echo $result;
?>

<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>