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
	$postID = $_GET['plikeID'];
	$postID = ltrim($postID, 'plike');
	$likeValue = $_GET['likeValue'];
	setLikeForPost($postID, $currentUser['userID'], $likeValue);
	$tongLike = totalLike($postID);
	if ($tongLike == 0) {
		echo "Chưa có lượt thích";
	}
	else {
		$currentLike = checkLike($postID, $currentUser['userID']);
		if ($currentLike) {
			if ($tongLike == 1) {
				echo "Bạn đã thích bài viết này";
			}
			else {
				echo "Bạn và " . (string)($tongLike - 1) . " người khác đã thích bài viết này";
			}
		}
		else {
			echo "Có " . $tongLike . " người đã thích bài viết này";
		}
	}
?>

<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>