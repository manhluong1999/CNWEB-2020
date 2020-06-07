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
			<div class="container" style="margin-left: 500px;">
				<?php foreach ($rows as $row): ?>
					<?php 
						$getUser=getUserByID($row); 
						$rela = isFriend($currentUser['userID'], $getUser['userID']);
					?>
					<?php if ($rela == true): ?>
					<div class="card" style="width: 300px; float: top;">
						<div class="row">

							<div class="col-2">
								<img src="<?php echo $getUser['avatar']?>" class="Avatar " alt="...">
							</div>
		
							<div class="col-6">
								<a class="card-title" href="trang-ca-nhan.php?userID=<?php echo $getUser['userID']; ?>">
									<h5><?php echo $getUser['fullname']?></h5>
							</a>
							</div>
							<div class="col-2">
								<a href="messenger.php?userID=<?php echo $getUser['userID']?>" class="btn btn-outline-primary" id="btnMessenger">
										<img src="icon/messenger.png" style="width: 25px; height: 25px;">
							</a>
							</div>
						</div>
							

									
						<?php endif; ?>
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
