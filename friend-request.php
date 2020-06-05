<?php
 ob_start(); // xóa kí tự lạ đầu file
  require_once ('init.php');
  require_once ('functions.php');
?>
<body style="font-family: serif;background-image: url(pictures/background.jpg); ">
<?php 
  include 'check-before-login.php';
  include 'header.php';
?>

<?php
	if (isset($currentUser)) :?>
		<?php 
			$rows = totalUserRela($currentUser['userID']);
		?>
		<?php if (count($rows) > 0) :?>
			<div class="container">
				<?php foreach ($rows as $row): ?>
					<?php 
						$getUser=getUserByID($row); 
						$rela = checkRelationship($currentUser['userID'], $getUser['userID']);
					?>
					<div class="card" style="width: 300px; float: top;">
						<img src="<?php echo $getUser['avatar']?>" class="card-img-top" style="width: 299px ; height: 250px; " alt="...">
						<div class="card-body">
							<a class="card-title" href="trang-ca-nhan.php?userID=<?php echo $getUser['userID']; ?>"><h5><?php echo $getUser['fullname']?></h5></a>
							<?php if ($getUser['userID'] == $currentUser['userID']): ?>
								<a href="update-profile.php" class="btn btn-primary">Cập nhật thông tin</a>
							<?php else: ?>
								<?php $rela = checkRelationship($currentUser['userID'], $getUser['userID']); ?>

								<a href="xulyFriends.php?currentUserID=<?php echo $currentUser['userID']?>&userID=<?php echo $getUser['userID']?>&rela=<?php echo $rela?>" 
									class="btn btn-primary"
									id="btnAddFr">
									<?php 
										//var_dump($rela);
										switch ($rela) {
											case 'NotFriend':
												echo "Kết bạn";
												break;
											case 'Friend':
												echo "Bạn bè";
												break;
											case 'currentWaitingForAccept':
												echo "Đã gửi lời mời";
												break;
											case 'currentReciveFriendRequest':
												echo "Chấp nhận lời mời";
												break;
											default:
												echo "lỗi";
												break;
										}
									?>
								</a>				

										<!-- nếu như đang chờ kết bạn -->
								<?php if ($rela == "currentReciveFriendRequest"): ?>
									<a href="trang-ca-nhan.php?currentUserID=<?php echo $currentUser['userID']?>&userID=<?php echo $getUser['userID']?>&rela=<?php echo $rela?>&deny=true" class="btn btn-primary" id="btnDeny">Từ chối</a>
								<?php else: ?>
									<a href="xulyFollow.php?userID=<?php echo $getUser['userID']?>" class="btn btn-primary" id="btnFollow">
										<?php
											if (checkFollow($getUser['userID'], $currentUser['userID'])) {
												echo "Đã theo dõi";
											}
											else{
												echo "Theo dõi";
											}
										?>
									</a>
								<?php endif; ?>

										<!-- nếu là bạn thì hiển thị nút nhắn tin -->
								<?php if ($rela == "Friend"): ?>
									<a href="messenger.php?userID=<?php echo $getUser['userID']?>" class="btn btn-outline-primary" id="btnMessenger">
										<img src="icon/messenger.png" style="width: 30px; height: 30px;">
									</a>
								<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>				
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<span>Bạn không có người bạn, hoặc lời mời kết bạn nào</span>
		<?php endif; ?>
	<?php else: ?>
		<?php 
			header("Location: login.php");
		?>
	<?php endif; ?>
<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>
</body>