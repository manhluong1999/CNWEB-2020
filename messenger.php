<?php
ob_start(); // xóa kí tự lạ đầu file
require_once 'init.php';
require_once 'functions.php';

?>

<?php 
  include 'check-before-login.php';
  include 'header.php';
?>		

<?php if (isset($_GET['userID'])):?>
		<?php 
			$getUser=getUserByID($_GET['userID']); 
		?>
		<div>
			<div class="auto" id="divChat">
				<?php echo loadMessageToHTML($currentUser['userID'], $getUser['userID'])?>
			</div>
			<p>Bạn đang chat với <?php echo $getUser['fullname'];?></p>
			<form method="post" action="xulyMessage.php" style="position: fixed;margin-left: 300px;bottom: 10px;width: 700px;">
				<input type="input" name="content" id="inputMessage" style="width: 600px;" placeholder="Nhập tin nhắn ...">
				<input type="input" name="userID" value='<?php echo $getUser['userID'];?>' style="display: none;">
				<input type="submit" name="btnsubmit">
			</form>
		</div>
<?php else: ?>
    <div class="alert alert-danger" role="alert">
        Đường dẫn bị lỗi
    </div>		
<?php endif; ?>

<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>