<?php
 ob_start(); // xóa kí tự lạ đầu file
  require_once ('init.php');
  require_once ('functions.php');
?>

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
						$rela = isFriend($currentUser['userID'], $getUser['userID']);
					?>
					<?php if ($rela == true): ?>
					<div class="card" style="width: 300px; float: top;">
						<img src="<?php echo $getUser['avatar']?>" class="card-img-top" style="width: 299px ; height: 250px; " alt="...">
						<div class="card-body">
							<a class="card-title" href="trang-ca-nhan.php?userID=<?php echo $getUser['userID']; ?>"><h5><?php echo $getUser['fullname']?></h5></a>
							<?php if ($getUser['userID'] == $currentUser['userID']): ?>
								<a href="update-profile.php" class="btn btn-primary">Cập nhật thông tin</a>
							<?php else: ?>
							
										<!-- nếu là bạn thì hiển thị nút nhắn tin -->
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
			<span>Bạn không có người bạn</span>
		<?php endif; ?>
	<?php else: ?>
		<?php 
			header("Location: login.php");
		?>
	<?php endif; ?>

?>

<?php include 'footer.php'; ?>
