<?php
ob_start(); // xóa kí tự lạ đầu file
require_once 'init.php';
require_once 'functions.php';
?>
<?php include "header.php"; ?>

    <h1>Đăng nhập</h1>
    <div  style{ align="right";}>

    <form method="POST" action="login.php">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-8">
            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Mật khẩu</label>
            <div class="col-sm-8">
            <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Mật khẩu">
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-3">
            <button type="submit" class="btn btn-primary">Đăng nhập</button>
            <p>Chưa có tài khoản ? <a href="register.php">Đăng ký</a></p>
            <!-- <p>Quên mật khẩu ? <a href="forgot-password.php">Đặt lại mật khẩu</a></p> -->
            </div>
        </div>
    </form>

    </div>
    <?php if (isset($_POST['email']) && isset($_POST['password'])): ?>
    <?php
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $GLOBALS['db']->prepare("SELECT * FROM myuser WHERE email = ?");
        $stmt->execute(array($email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
        <?php if (1): ?>    
            <?php if (password_verify($password, $row['password'])): ?>
            <?php
                    //var_dump($row);
                    $_SESSION['userID'] = $row['userID'];
                    header('Location: index.php');
            ?>
            <?php else: ?> 
                <div class="alert alert-danger" role="alert">
                    Đăng nhập thất bại
                </div>
            <?php endif; ?>
        <!-- <?php else: ?>
            <div class="alert alert-danger" role="alert">
                Bạn chưa kích hoạt tài khoản<br>Vui lòng kiểm tra email và làm theo hướng dẫn
            </div> -->
        <?php endif; ?>
    <?php endif; ?>
<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>