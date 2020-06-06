<?php
ob_start(); // xóa kí tự lạ đầu file
require_once 'init.php';
require_once 'functions.php';
// Xử lý logic ở đây

?>
<body style="font-family: serif;background-image: url(pictures/background.jpg); ">
<?php 
    include "check-before-login.php";
    include "header.php";
?>
<?php 	if(isset($_POST['newPass']) && isset($_POST['reNewPass']) && isset($_POST['oldPass'])):?>
<?php 	
		$newPass = $_POST['newPass'];
		$oldPass = $_POST['oldPass']; 
?>
	<?php	if (checkPass($oldPass)):?>
	<?php 	setPassword($currentUser['userID'], $newPass); ?>
		    <div class="alert alert-primary" role="alert">
		        Cập nhật thành công
		    </div>
	<?php	else:?>
		    <div class="alert alert-danger" role="alert">
		        Sai mật khẩu
		    </div>
	<?php 	endif;?>
<?php 	endif;?>
    <h1 style{ align="center";}>Đổi mật khẩu</h1>
    <div  style{ align="right";}>
        <form method="POST" action="change-password.php">
        <div class="form-group row">
            <label for="oldPass" class="col-sm-2 col-form-label">Mật khẩu cũ</label>
            <div class="col-sm-8">
            <input type="password" class="form-control" id="oldPass" name="oldPass">
            </div>
        </div>
        <div class="form-group row">
            <label for="newPass" class="col-sm-2 col-form-label">Mật khẩu mới</label>
            <div class="col-sm-8">
            <input type="password" class="form-control" id="newPass" name="newPass" onblur="checkPasswordState('newPass', 'lblPasswordState')">
            </div>
            <label id="lblPasswordState" style="align-self: left; font-weight: bold;">Trống</label>
        </div>
        <div class="form-group row">
            <label for="reNewPass" class="col-sm-2 col-form-label">Nhập lại mật khẩu mới</label>
            <div class="col-sm-8">
            <input type="password" class="form-control" id="reNewPass" name="reNewPass" onchange="checkRePassword('newPass', 'reNewPass')">
            </div>
        </div>        
        <div class="form-group row">
            <div class="col-sm-3">
            <button type="submit" class="btn btn-primary"">Đổi mật khẩu</button>
            </div>
        </div>
        </form>
    </div>
<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>
</body>