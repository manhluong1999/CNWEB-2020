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
	if (isset($_POST['content']) && isset($_POST['userID'])) {
		$content = $_POST['content'];
		$toUserID = $_POST['userID'];

		if ($content == '') {
			header("Location: messenger.php?userID=$toUserID");
		}

		insertMessage($currentUser['userID'], $toUserID, $content);
		header("Location: messenger.php?userID=$toUserID");
	}
	else {
		echo "Không có dữ liệu";
	}
 ?>

<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>