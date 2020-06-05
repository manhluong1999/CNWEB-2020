<?php 
	require_once 'functions.php';
	session_start();
	$page = detectPage();

	$db = new PDO('mysql:host=localhost;dbname=web2020;charset=utf8', 'root', '');
	$stmt = $db->query("SELECT * FROM USER");
	// Lấy hết toàn bộ dữ liệu
	$data = null;
	//$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	// hoặc lấy từng dòng
	/*while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	  echo $row['field1'] . ' ' . $row['field2']; 
	}*/

    $row = null;

    $currentUser = null;

    /**
     * đối tượng bài post
     */
    class mypost 
    {
    	public 	$userID, 
    			$postID,
    			$content,
    			$timecreate;

    	function __construct($userID, $postID, $content, $timecreate)
    	{
    		$this->userID = $userID;
    		$this->postID = $postID;
    		$this->content = $content;
    		$this->timecreate = $timecreate;
    	}

    	public static function GetPostByID($id){
	        $stmt = $GLOBALS['db']->prepare("SELECT * FROM mypost WHERE postID = ?");
	        $stmt->execute(array($id));
	        $row = $stmt->fetch(PDO::FETCH_ASSOC);

	        if ($row == null) {
	        	return;
	        }
	        else{
		        $post = new mypost($row['userID'], $row['postID'], $row['content'], $row['timecreate']);
	    		return $post;
	        }
    	}
    }

    /**
     * đối tượng người dùng user
     */
    class myuser
    {
    	function __construct($userID, $status, $email, $password, $username, $fullname, $phonenumber, $avatar, $code)
    	{
			$this->userID = $userID;
			$this->status = $status;
			$this->email = $email;
			$this->password = $password;
			$this->username = $username;
			$this->fullname = $fullname;
			$this->phonenumber = $phonenumber;
			$this->avatar = $avatar;
			$this->code = $code;
    	}

		public static function getUserByID($id){
			$stmt = $GLOBALS['db']->prepare("SELECT * FROM myuser WHERE userID = ?");
			$stmt->execute(array($id));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			
			if ($row == null) {
				return;
			}
			else{
				return new myuser(
					$row['userID'],
					$row['status'],
					$row['email'],
					$row['password'],
					$row['username'],
					$row['fullname'],
					$row['phonenumber'],
					$row['avatar'],
					$row['code']);
			}
		}
    }
?>