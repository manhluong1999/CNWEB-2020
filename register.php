<?php
ob_start(); // xóa kí tự lạ đầu file
require_once 'init.php';
require_once 'functions.php';
// Xử lý logic ở đây
?>
<?php include "header.php"; ?>
    <h1 style{ align="center";}>Đăng ký</h1>
    <div style{ align="right";}>
        <form method="POST" action="register.php">
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-8">
                <input type="email" class="form-control" id="inputemail" name="email" placeholder="Email">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Mật khẩu</label>
            <div class="col-sm-7">
                <input type="password" class="form-control" id="inputPassword" name="password" onblur="checkPasswordState('inputPassword', 'lblPasswordState')">
            </div>
            <label id="lblPasswordState" style="align-self: left; font-weight: bold;">Trống</label>
        </div>
        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Nhập lại mật khẩu</label>
            <div class="col-sm-8">
                <input type="password" class="form-control" id="reInputPassword" name="rePassword" onchange="checkRePassword('inputPassword', 'reInputPassword')">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Tên người dùng</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputusername" name="username">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Họ tên đầy đủ</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputfullname" name="fullname">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-2 col-form-label">Số điện thoại</label>
            <div class="col-sm-8">
                <input type="tel" class="form-control" id="inputphonenumber" name="phonenumber">
            </div>
        </div>        
        <div class="form-group row">
            <div class="col-sm-3">
            <button type="submit" class="btn btn-primary">Đăng ký</button>
            </div>
        </div>
        </form>
    </div>
    <?php

    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['username']) && isset($_POST['fullname']) && isset($_POST['phonenumber'])): ?>
    <?php
        $email = $_POST['email'];
        $password = $_POST['password'];
        $username = $_POST['username'];
        $phonenumber = $_POST['phonenumber'];
        $fullname = $_POST['fullname'];
        $status = 1;
    ?>
    <?php
        // kiểm tra xem dữ liệu có bị trống hay không
        if ($email == '' || $password == '' || $username == '' || $phonenumber == '' || $fullname == '') :?>
        <div class="alert alert-danger" role="alert">
            Vui lòng nhập đầy đủ dữ liệu
        </div>   
    <?php exit(); ?> 
    <?php endif;?>
    <?php
        // kiểm tra email có người sử dụng chưa
        global $db;
        $stmt = $db->prepare("SELECT email FROM myuser WHERE email = ?");
        $stmt->execute(array($email));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
    <?php if ($row) :?>
        <div class="alert alert-danger" role="alert">
            Vui lòng chọn email khác, lỗi: Email đã tồn tại
        </div>
    <?php exit();?> 
    <?php endif;?>
    <?php 
        global $db;
        $stmt = $db->prepare("INSERT INTO myuser(email, password, username, fullname, phonenumber ,status,avatar) VALUES (?,?,?,?,?,1,'avatars/macdinh.jpg')");
        $stmt->execute(array($email, password_hash($password, PASSWORD_DEFAULT), $username, $fullname, $phonenumber));
        //$row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
        <div class="alert alert-primary" role="alert">
            <?php
                $code = getRandomStr();
                setCodeByEmail($email, $code);
            ?>
                Đăng kí thành công. 
            <a href="login.php"> Về trang đăng nhập</a>
        </div>
        <?php endif; ?>
<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>