<?php
ob_start(); // xóa kí tự lạ đầu file
require_once 'init.php';
require_once 'functions.php';
// Xử lý logic ở đây
?>

<?php 
  include 'header.php';
?>
    <?php
    if (isset($_POST['email'])): ?>
    <?php
        $email = $_POST['email'];
    ?>
        <?php
        // kiểm tra xem dữ liệu có bị trống hay không
        if ($email == '') :?>
            <div class="alert alert-danger" role="alert">
                Vui lòng nhập đầy đủ dữ liệu
            </div>    
            <?php exit();?>
        <?php else:?>
            <div class="alert alert-primary" role="alert">
                Hướng dẫn khôi phục mật khẩu đã được gửi đến <strong><?php echo $email;?></strong>. Vui lòng kiểm tra email.
            </div>
            <?php
                $code = getRandomStr();
                setCodeByEmail($email, $code);
                $htmlContent = 'Để đổi mật khẩu, nhấp vào http://localhost:1403/reset-password.php?code=' . $code; 
                sendMail($email, 'Hướng dẫn đổi mật khẩu', $htmlContent);
            ?>
        <?php endif;?>
    <?php else: ?>
    <h1 style{ align="center";}>Reset mật khẩu</h1>
    <div style{ align="right";}>
        <form method="POST" action="forgot-password.php?action=reg">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-8">
                <input type="email" class="form-control" id="inputemail" name="email" placeholder="Email">
            </div>
        </div> 
        <div class="form-group row">
            <div class="col-sm-3">
            <button type="submit" class="btn btn-primary">Đặt lại mật khẩu</button>
            </div>
        </div>
        </form>
    </div>
    <?php endif; ?>
<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>