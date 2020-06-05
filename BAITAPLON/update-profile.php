<?php
ob_start(); // xóa kí tự lạ đầu file
require_once 'init.php';
require_once 'functions.php';

?>

<?php 
  include 'check-before-login.php';
  include 'header.php';
?>
    <?php
    if (isset($_POST['username']) && isset($_POST['fullname']) && isset($_POST['phonenumber']) && isset($_FILES["avatar"])): ?>
    <?php
        $username = $_POST['username'];
        $phonenumber = $_POST['phonenumber'];
        $fullname = $_POST['fullname'];
    ?>
    <?php
        // kiểm tra xem dữ liệu có bị trống hay không
        if ($username == '' || $phonenumber == '' || $fullname == '') :?>
        <div class="alert alert-danger" role="alert">
            Vui lòng nhập đầy đủ dữ liệu
        </div>    
    <?php exit(); endif;?>
    <?php 
        global $db; 
        $stmt = $db->prepare("UPDATE myuser SET username = ?, fullname = ?, phonenumber = ? WHERE userID = ?");
        $stmt->execute(array($username, $fullname, $phonenumber, $currentUser['userID']));

//---------------------- XỬ LÝ ẢNH NGƯỜI DÙNG UP LÊN ----------------------------
        $result = moveFile('avatar', 'avatars', 'image/jpeg');
        if ($result == 'true'){
            $newfile = renameAvatar($_SESSION['userID'], 'avatars/' . $_FILES['avatar']['name']);
    
            // nếu không tìm thấy chuỗi 'Error' tức là đổi tên thành công và chuỗi trả về sẽ là một đường dẫn file mới
            if (strpos($newfile, 'Error') == false) {
                global $db;
                $stmt = $GLOBALS['db']->prepare("UPDATE myuser SET avatar = ? WHERE userID = ?");
                $stmt->execute(array($newfile, $currentUser['userID']));
                setcookie('avatar',  $currentUser['avatar'] , time()+3600);
            }
            else{
                var_dump($newfile);
            }
        }
        //$row = $stmt->fetch(PDO::FETCH_ASSOC);
        //header("Refresh:0");
        // hmm, ngộ ta, anh không biết nó lấy hình ở đâu
        // ... Em chịu. Hay anh thử với file code đầu đi. Nhỡ may em bị ấn nhầm đâu đó
        // file code nào em ?
        // file tải trên web về ấy anh.
        // đợi anh cái, em đi đâu đi, anh đi ăn cái .mới về nhà . Oke anh.
    ?>
        <div class="alert alert-primary" role="alert">
            Cập nhật thành công. <a href="index.php">Về trang chủ</a>
        </div>
    <?php else: ?>
    <h1 style{ align="center";}>Cập nhật thông tin cá nhân</h1>
    <div style{ align="right";}>
        <form method="POST" action="update-profile.php" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Tên người dùng</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputusername" name="username" value=<?php echo $currentUser['username']?>>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Họ tên đầy đủ</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputfullname" name="fullname" value="<?php echo $currentUser['fullname'];?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Số điện thoại</label>
                <div class="col-sm-8">
                    <input type="tel" class="form-control" id="inputphonenumber" name="phonenumber" value=<?php echo $currentUser['phonenumber']?>>
                </div>
            </div>
            <div class="form-group row">
                <label for="avatar" class="col-sm-2 col-form-label">Ảnh đại diện</label>
                <div class="col-sm-3">
                    <div class="card" style="width: 28rem;">
                        <img class="card-img-top" src="<?php echo $currentUser['avatar']?>" alt="Card image cap">
                        <div class="card-body">
                            <p class="card-text">
                                <input type="file" id="avatar" name="avatar">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                <button type="submit" class="btn btn-primary" onclick="Location.reload();">Cập nhật</button>
                </div>
            </div>
        </form>
    </div>
    <?php endif; ?>
<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>