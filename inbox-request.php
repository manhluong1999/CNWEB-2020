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

			$messages = array();
			$messages = getAllFriendNewMessage($currentUser['userID']);
			if (sizeof($messages) == 0) {
				die("Bạn không có tin nhắn nào");
			}
		?>
		<div class="container">
			<?php foreach ($messages as $message): ?>
				<?php 
					$actionStr = "";	// biến hiển thị làm gì ? (Xem, Trả lời)
					// nếu như tin nhắn này, người gửi là current
					if ($message['fromUserID'] == $currentUser['userID']) {
						$partner = getUserByID($message["toUserID"]);
						$actionStr = "Xem";
					}
					else {
						$partner = getUserByID($message["fromUserID"]);
						$actionStr = "Trả lời";
					}
				?>
					<div 	class="card"
							id="<?php echo ("hienThiTinNhan" . $message['messageID']) ?>" 
							style="	margin: 10px 50px 0px 100px;
									 border: 2px solid grey; 
									 border-radius: 10px; 
									 height: auto; 
									 width: 500px;
									 background-color: <?php echo $message['hasRead']=='no' && $message['toUserID']==$currentUser['userID'] ? '#d2d5d9' : 'white';?>;">
						 <div class="card-body">
						 	<div style="margin-bottom: 20px;">
							 	<img src="<?php echo $partner['avatar']?>" alt="Avatar" class="avatar" style="float: left; border-radius: 20%; margin-right: 10px;">
								<a href="trang-ca-nhan.php?userID=<?php echo $partner['userID'];?>">
									<h3><?php echo  $partner['fullname']; ?></h3>
								</a>
								<a id="<?php echo ("actionStr-" . $message['messageID']) ?>"
										onclick="actionStr_Click(event, '<?php echo $message['messageID']?>')" 
										style="float: right;"
										href="messenger.php?userID=<?php echo $partner['userID'];?>" >
										<?php echo $actionStr;?>
								</a>
								<span><?php echo date_format(date_create($message['timecreate']),"d/m/Y H:i:s"); ?></span>
							</div>
							<div style="background-color: #d9a250;">
								<?php echo $message['content'];  ?>
							</div>
						</div>
					</div>
			<?php endforeach; ?>
		</div>
	<?php else: ?>
		<?php 
			header("Location: login.php");
		?>
	<?php endif; ?>
<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>