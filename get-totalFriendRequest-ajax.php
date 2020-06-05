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

		// lấy số lượng thông báo và số lượng inbox
		$fr = totalFriendRequest($userID);
		$ib = totalInboxRequest($userID);
		$tach = "-";

		if ($fr > 0) {
			$result = "<p style='color: red;'>" . "(" . $fr . ")" . "</p>";
		}
		else{
			$result = "<p>" . "(" . $fr . ")" . "</p>";
		}

		if ($ib > 0) {
			$result .= $tach . "<p style='color: red;'>" . "(" . $ib . ")" . "</p>";
		}
		else{
			$result .= $tach . "<p>" . "(" . $ib . ")" . "</p>";
		}

	}

	echo $result;
 ?>

<?php
ob_end_flush(); // xóa các kí tự lạ cuối file
?>