<html><head>
	<title>Social Media</title>
	<link rel="icon" type="image/png" href="icon/facebook.png"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script type="text/javascript">
  	
		function privacyChanged(event, postID){
			var selectPrivacy = event.target;
			var privacy = selectPrivacy.value;
	        $.ajax({
	            url : "update-post.php", // gửi ajax đến file result.php
	            type : "get", // chọn phương thức gửi là get
	            dateType:"text", // dữ liệu trả về dạng text
	            data : { // Danh sách các thuộc tính sẽ gửi đi
	                 postID: postID,
	                 privacy: privacy
	            },
	            success : function (){
            		alert('Thay đổi thành công');
	            }
	        });			
		}
		function actionStr_Click(event, messageID){

	        $.ajax({
	            url : "set-HasRead.php", // gửi ajax đến file result.php
	            type : "get", // chọn phương thức gửi là get
	            dateType:"html", // dữ liệu trả về dạng text
	            data : { // Danh sách các thuộc tính sẽ gửi đi
	            	messageID: messageID,
	            	hasRead: "yes"
	            },
	            success : function (result){

	            }
	        });
		}

				// xử lý việc người dùng nhấn nút like
		function btnLike_Click(event){
			var btnLike = event.target;
			console.log(btnLike);
			// xử lý lấy được cái class của thằng p (hiển thị lượt thích ) tương ứng
			var plikeID = btnLike.className.split(" ")[0];
			var likeValue = 'false';

			if (btnLike.innerHTML == "Bỏ thích") {
				btnLike.innerHTML = "Thích";
				likeValue = 'false';
			}
			else{
				btnLike.innerHTML = "Bỏ thích";
				likeValue = 'true';
			}

	        $.ajax({
	            url : "xulyLikes.php", // gửi ajax đến file result.php
	            type : "get", // chọn phương thức gửi là get
	            dateType:"text", // dữ liệu trả về dạng text
	            data : { // Danh sách các thuộc tính sẽ gửi đi
	                 plikeID: plikeID,
	                 likeValue: likeValue
	            },
	            success : function (result){
	                $('#' + plikeID).html(result);
	            }
	        });

	        return false;
		} 


		// xử lý việc người dùng comment
		function btnCmt_Click(event){

			var btnCmt = event.target;
			var fcmtID = btnCmt.className.split(" ")[0];
			var dcmtID = fcmtID.replace('f', 'd');
			var tcmtID = fcmtID.replace('f', 't');

			var data = $('#' + tcmtID).val();

	        $.ajax({
	            url : "xulyCmt.php", // gửi ajax đến file result.php
	            type : "get", // chọn phương thức gửi là get
	            dateType:"text", // dữ liệu trả về dạng text
	            data : {
	            	content : data,
	            	postID : fcmtID.replace("fcmt", "")	
	            },
	            success : function (result){
	                $('#' + dcmtID).html(result);
	            }
	        });
	        return false;
		} 


  </script>
	<style type="text/css">
		h1 {
			text-align: center;
		}
		body {
			margin-top: 70px;
		}
		.container {
			margin-bottom: 60px;
		}
		.avatar {
			vertical-align: middle;
			width: 40px;
			height: 40px;
			border-radius: 50%;
		}

		/* ---------------- TIN NHẮN --------------------*/
		/* width */
	      .scroll{
            display:block;
            border: 1px solid red;
            padding:5px;
            margin-top:5px;
            width:300px;
            height:50px;
            overflow:scroll;
         }
         .auto{
            display:block;
            border: none;
            margin-left: 300px;
            margin-top: 70px;
            margin-bottom: 0px;
            width:50%;
            height:500px;
            overflow-y:auto;
            overflow-x:hidden;
            background-color: #f5e7e6;
         }
         .toMessage{
         	width: 90%;
         	float: left;
         	text-align: left;
         }
         .toMessage p {
         	background-color: #e3dcd5;
         	border-radius: 5%; 
         	float: left; 
         	text-align: left;
		}

         .fromMessage{
         	width: 90%; 
         	float: right;
         	text-align: right;
         }
         .fromMessage p {
         	background-color: #ed93b3;
         	border-radius: 5%; 
         	float: right; 
         	text-align: right;
         }
		/*----------------- TIN NHẮN ---------------------*/


		.sidenav {
			width: 18rem;
			position: fixed;
			z-index: 1;
			top: 60px;
			left: 10px;
			background: #eee;
			overflow-x: hidden;
			padding: 8px 0;
		}

		.main {
			margin-left: 18rem; /* Same width as the sidebar + left position in px */
			margin-bottom: 60px;
			padding: 0px 10px;
		}

		@media screen and (max-height: 450px) {
			.sidenav {padding-top: 15px;}
			.sidenav a {font-size: 18px;}
		}
	</style>
</head>
<body class="container-fluid">
	<div>
		<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
		  <a  class="nav-link" href="index.php">
		        	<img style="float: left;" src="icon/facebook.png" alt="Avatar" class="avatar">
		        </a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
		      <li class="nav-item <?php echo $page=='index' ? 'active' : '' ?>" >
		        
		      </li>
		      <?php if (!isset($_SESSION['userID'])): ?>
			  <li class="nav-item <?php echo $page=='login' ? 'active' : '' ?>">
		        <a class="nav-link" href="login.php">Đăng nhập</a>
		      </li>
		      <?php else: ?>
		   	  <li class="nav-item <?php echo $page=='trang-ca-nhan' ? 'active' : '' ?>" style="margin-left: 10px;">
		        <a class="nav-link" href="trang-ca-nhan.php?userID=<?php echo $currentUser['userID'];?>">
		        	<img src="<?php echo $currentUser['avatar']?>" alt="Avatar" class="avatar">
					<?php echo $currentUser['fullname']?>
		        </a>
		   	  </li>
		      <li class="nav-item <?php echo $page=='friend-request' ? 'active' : '' ?>" style="margin-left: 10px; width: 80px;">
		        <?php
	        		$sl = totalFriendRequest($currentUser['userID']);
		        ?>
		        <a class="nav-link" href="friend-request.php" <?php echo ($sl > 0 ? "style='color: red;'" : "") ?>>
		        	<img style="float: left;" src="icon/friend-request.png" alt="Avatar" class="avatar">
		        	<div id="totalFriendRequest" >
			        	<?php echo "(" . $sl . ")"; ?>
		        	</div>
		        </a>	
		      </li>
		      <li class="nav-item <?php echo $page=='inbox-request' ? 'active' : '' ?>" style="margin-left: 10px; width: 80px;">
		        <?php
	        		$sl = totalInboxRequest($currentUser['userID']);
		        ?>
		        <a  class="nav-link" href="inbox-request.php" <?php echo ($sl > 0 ? "style='color: red;'" : "") ?>>
		        	<img style="float: left;" src="icon/messenger.png" alt="Avatar" class="avatar">
		        	<div id="totalInbox" >
			        	<?php echo "(" . $sl . ")"; ?>
		        	</div>
		        </a>	
		      </li>
		      <li style="margin-left: 10px; margin-top: 8px;">
		     		

				<input type="text" name="timkiem" id="timkiem" class="form-control" placeholder="Search..." >
				

				<div  id="show-list"  style="display: block; position: absolute;"> 
				</div>
		      </li>
		      <li class="nav-item <?php echo $page=='change-password' ? 'active' : '' ?>"  style="margin-left: 10px; margin-top: 8px;">
		        <a class="nav-link" href="change-password.php">Đổi mật khẩu</a>
		      </li>
		   	  <li class="nav-item <?php echo $page=='logout' ? 'active' : '' ?>"  style="margin-left: 10px; margin-top: 8px;">
		        <a class="nav-link" href="logout.php">Đăng xuất</a>
		      </li>

		  	<?php endif; ?>
<!-- 			  <li class="nav-item">
		        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Đăng nhập</a>
		      </li> -->
		    </ul>
		  </div>
		</nav>
	</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#timkiem").keyup(function(){
			var searchText=$(this).val();
			if(searchText!=''){
				$.ajax({
					url:'search.php',
					method:'post',
					data:{query:searchText},
					success:function(response){
						$("#show-list").html(response);
					}
				});
			}
			else{
				$("#show-list").html('');
			}
		});
		$(document).on('click','a',function(){
			$("#timkiem").val($(this).text());
			$("#show-list").html('');
		});
	});
</script>