<?php
    ob_start();
    require_once 'init.php';
    require_once 'functions.php';
?>

<?php
    include 'check-before-login.php';
    include 'header.php';

?>

<?php 
	if (isset($_POST['content'])){
		$content = $_POST['content'][0];
		$privacy = $_POST['privacy'];
		if (strlen($content) == 0){
			echo "Không được để trống status";
		} else {
		    // lấy postID vừa mới insert vào    
	        $postID = insertPost($_SESSION['userID'], $content, $privacy);

	        if (($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_FILES['hinhanh']))) {

		        $folder = 'pictures';

		    	$files = $_FILES['hinhanh'];

		        $names      = $files['name'];
		        $types      = $files['type'];
		        $tmp_names  = $files['tmp_name'];
		        $errors     = $files['error'];
		        $sizes      = $files['size'];

		        $numitems = count($names);
		        $numfiles = 0;
		        $filesSize = 0;
		        for ($i = 0; $i < $numitems; $i ++) {
		            //Kiểm tra file thứ $i trong mảng file, up thành công không
		            if ($errors[$i] == 0)
		            {
		                $numfiles++;
		                echo "Bạn upload file thứ $numfiles:<br>";
		                echo "Tên file: $names[$i] <br>";
		                echo "Lưu tại: $tmp_names[$i] <br>";
		                echo "Cỡ file: $sizes[$i] <br><hr>";
		                $filesSize += $sizes[$i];
		                
		                // chuyển qua thư mục pictures sẵn đổi tên thành postID_i
		                $newFileName = $postID. '_' . $i . '.jpg';
		                $newPath = $folder . '/' . $newFileName;
		                move_uploaded_file($tmp_names[$i], $newPath);

      					global $db;
		                $stmt = $GLOBALS['db']->prepare("INSERT INTO post_picture(postID, picturePath) VALUES (?, ?)");
		                $stmt->execute(array($postID, $newPath));
		            }
		        }
		        echo "Tổng số file upload: " .$numfiles;
		        echo "Tổng dung lượng: " .$filesSize/(1024*1024) . "MB";
		        header('Location: index.php');
		    }
			else{
			    echo "Lỗi, dung lượng phải nhỏ hơn 20MB";
			}
		}
	}
?>
<?php
include "footer.php";
ob_end_flush(); // xóa các kí tự lạ cuối file
?>