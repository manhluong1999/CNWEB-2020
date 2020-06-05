<?php
ob_start(); // xóa kí tự lạ đầu file
require_once 'init.php';
require_once 'functions.php';

?>

<?php 
  include 'check-before-login.php';
?>

<?php 
	if (isset($_GET['messageID']) && isset($_GET['hasRead'])) {
		$messageID = $_GET['messageID'];
		$hasRead = $_GET['hasRead'];

		// lấy tin nhắn mới nhất mà current nhận được từ userID
		setHasReadMessage($messageID, $hasRead);
	}

	echo $messageID . " " . $hasRead;
 ?>

<?php
ob_end_flush(); // xóa các kí tự lạ cuối file
?>