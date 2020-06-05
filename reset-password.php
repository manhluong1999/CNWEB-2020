<?php
ob_start(); // xóa kí tự lạ đầu file
require_once 'init.php';
require_once 'functions.php';
// Xử lý logic ở đây

?>
<?php 
    include "header.php";
?>

<?php if (isset($_GET['code'])) :?>
    <?php 
        $code = $_GET['code'];
        setUserStatus($code, 2);
        global $currentUser;
        $currentUser = getCurrentUserByCode($code);
        var_dump($currentUser);
    ?>
<?php endif;?>

<?php   if(isset($_POST['newPass']) && isset($_POST['reNewPass'])):?>
<?php   
        $newPass = $_POST['newPass'];
        $reNewPass = $_POST['reNewPass'];
?>
            <?php resetPassword($newPass);?>
            <div class="alert alert-primary" role="alert">
                Đã cập nhật thành công
            </div>
<?php   endif;?>
    <h1 style{ align="center";}>Đặt lại mật khẩu</h1>
    <div  style{ align="right";}>
        <form method="POST" action="reset-password.php">
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
            <button type="submit" class="btn btn-primary"">Cập nhật mật khẩu mới</button>
            </div>
        </div>
        </form>
    </div>
<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>