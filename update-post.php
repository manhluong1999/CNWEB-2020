<?php
ob_start(); // xóa kí tự lạ đầu file
require_once 'init.php';
require_once 'functions.php';

?>

<?php
	if (isset($_GET['postID']) && isset($_GET['privacy'])) {
		$postID = $_GET['postID'];
		$privacy = $_GET['privacy'];

		global $db;
		$stmt = $db->prepare("UPDATE mypost SET privacy=? WHERE postID=?");
		$stmt->execute(array($privacy, $postID));
	}
?>

<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>