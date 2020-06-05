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
	if (isset($_GET['currentUserID']) && isset($_GET['userID']) && isset($_GET['rela'])) {
		$currentUserID = $_GET['currentUserID'];
		$userID = $_GET['userID'];
		$rela = $_GET['rela'];
		switch ($rela) {
			case 'Friend':
				cancelFriend($currentUserID, $userID);	// hủy không làm bạn nữa;
				break;
			case 'currentWaitingForAccept':
				cancelFriendRequest($currentUserID, $userID); // hủy, không gửi lời mời kết bạn cho người đó nữa
				break;
			case 'currentReciveFriendRequest':
				if (isset($_GET['deny']) && $_GET['deny'] = 'true') {	
					cancelFriendRequest($userID, $currentUserID);	// từ chối lời mời == hủy lời mời từ người bên kia
				}
				else {
					acceptFriendRequest($currentUserID, $userID);	// chấp nhận làm bạn
					sendFollow($currentUserID, $userID);
					sendFollow($userID, $currentUserID);			// khi chấp nhận thì sẽ đều theo dõi lẫn nhau
				}
				break;
			case 'NotFriend':
				sendFriendRequest($currentUserID, $userID);	// nếu chưa kết bạn thi khi bấm sẽ gửi lời mời cho người đó
				break;
			default:
				# code...
				break;
		}
		header("Location: trang-ca-nhan.php?userID=$userID");
	}
?>

<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>