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
	<div class="sidenav">
		<div class="card" style="width: 18rem;">
			<img src="<?php echo $getUser['avatar']?>" class="card-img-top" alt="...">
			<div class="card-body">
				<h5 class="card-title"><?php echo $getUser['fullname']?></h5>
				<p class="card-text"> Fboy</p>
				
				<?php if ($getUser['userID'] == $currentUser['userID']): ?>
					<a href="update-profile.php" class="btn btn-primary">Cập nhật thông tin</a>
				<?php else: ?>
					<?php $rela = checkRelationship($currentUser['userID'], $getUser['userID']); ?>

					<a href="xulyFriends.php?currentUserID=<?php echo $currentUser['userID']?>&userID=<?php echo $getUser['userID']?>&rela=<?php echo $rela?>" 
						class="btn btn-primary"
						id="btnAddFr">
						<?php 
							//var_dump($rela);
							switch ($rela) {
								case 'NotFriend':
									echo "Kết bạn";
									break;
								case 'Friend':
									echo "Bạn bè";
									break;
								case 'currentWaitingForAccept':
									echo "Đã gửi lời mời";
									break;
								case 'currentReciveFriendRequest':
									echo "Chấp nhận lời mời";
									break;
								default:
									echo "lỗi";
									break;
							}
						?>
					</a>				

							<!-- nếu như đang chờ kết bạn -->
					<?php if ($rela == "currentReciveFriendRequest"): ?>
						<a href="xulyFriends.php?currentUserID=<?php echo $currentUser['userID']?>&userID=<?php echo $getUser['userID']?>&rela=<?php echo $rela?>&deny=true" class="btn btn-primary" id="btnDeny">Từ chối</a>
					<?php else: ?>
						<a href="xulyFollow.php?userID=<?php echo $getUser['userID']?>" class="btn btn-primary" id="btnFollow">
							<?php
								if (checkFollow($getUser['userID'], $currentUser['userID'])) {
									echo "Đã theo dõi";
								}
								else{
									echo "Theo dõi";
								}
							?>
						</a>
					<?php endif; ?>

							<!-- nếu là bạn thì hiển thị nút nhắn tin -->
					<?php if ($rela == "Friend"): ?>
						<a href="messenger.php?userID=<?php echo $getUser['userID']?>" class="btn btn-outline-primary" id="btnMessenger">
							<img src="icon/messenger.png" style="width: 30px; height: 30px;">
						</a>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<div class="main">
		<?php 
		
			$rows = array();
			if ($getUser['userID'] != $currentUser['userID']) {
				$rows = getPost2($currentUser['userID'], $getUser['userID']);
			}
			else{
				$rows = getPost($getUser['userID']);
			}
			
			/// ---------------- phân trang --------------------
			$pageIndex = 0;
			if (isset($_GET['pageIndex']) && $_GET['pageIndex'] > 0) {
				$pageIndex = $_GET['pageIndex'];
			}
			$totalRow = count($rows);
			
			$rowPerPage = 10;	// 10 bài viết trong 1 trang

			$totalPage = $totalRow/$rowPerPage;
			if ($totalPage > floor($totalPage)) {
				$totalPage = floor($totalPage) + 1;
			}
			else {
				$totalPage = floor($totalPage);
			}

			if ($totalPage == 0) {
				$pageIndex = 0;
			}
			// nếu như chỉ số trang người ta cho lớn hơn tổng số trang thì chỉ số trang sẽ bằng trang cuối
			else if ($pageIndex > $totalPage - 1) {
				$pageIndex = $totalPage - 1;
			}

			$rowStartIndex = $pageIndex * $rowPerPage;
			$rowEndIndex = $rowStartIndex + $rowPerPage;

			if ($rowEndIndex > $totalRow) {
				$rowEndIndex = $totalRow;
			}
		?>

		<?php
			for ($i=$rowStartIndex; $i < $rowEndIndex; $i++):?>
			<?php
				$row = $rows[$i];

				$plikeID = (string)("plike" . $row['postID']); 
				$fcmtID = (string)("fcmt" . $row['postID']);	// form cmt
				$dcmtID = (string)("dcmt" . $row['postID']);	// thẻ div chứa danh sách các cmt
				$tcmtID = (string)("tcmt" . $row['postID']);	// ô text để nhập cmt
				$privacy = $row['privacy'];			// lấy quyền riêng tư của bài viết
				$follow = checkFollow($row['userID'], $currentUser['userID']);	// biến kiểm tra xem current có theo dõi người dùng đó ko
			?>
				<div class="card" style="margin-top: 10px; border: 2px solid grey; border-radius: 10px; height: auto;">
					 <div class="card-body">
					 	<div style="margin-bottom: 20px;">
						 	<img src="<?php echo $row['avatar']?>" alt="Avatar" class="avatar" style="float: left; border-radius: 20%; margin-right: 10px;">
							<a href="trang-ca-nhan.php?userID=<?php echo $row['userID'];?>">
								<h3><?php echo  $row['fullname']; ?></h3>
							</a>
							<p>Đăng lúc <?php echo date_format(date_create($row['timecreate']),"d/m/Y H:i:s"); ?></p>
							<select <?php 
										$cuaCurrent = checkPostOfUser($row['postID'], $currentUser['userID']);
										echo ($cuaCurrent == 'true' ? '' : 'disabled');
									?>
									onchange="privacyChanged(event,'<?php echo $row['postID'];?>')"
									onfocus="this.selectedIndex = '-1'; this.blur();">
								<option value="private" <?php echo ($privacy == 'private' ? 'selected' : ' ') ;?>>Riêng tư</option>
								<option value="friend" <?php echo ($privacy == 'friend' ? 'selected' : ' ') ;?>>Bạn bè</option>
								<option value="public" <?php echo ($privacy == 'public' ? 'selected' : ' ') ;?>>Công khai</option>
							</select>
					 	</div>
						<textarea class="form-control" rows="<?php echo getTotalLine($row['content']); ?>" readonly="readonly"><?php echo $row['content']; ?>
						</textarea>
						<?php echo inDSPicPostHTML($row['postID']); ?>
						<p style="margin-top: 10px;" id="<?php echo $plikeID;?>">
							<?php
								$tongLike = totalLike($row['postID']);	
								if ($tongLike == 0) {
									echo "Chưa có lượt thích";
								}
								else {
									$currentLike = checkLike($row['postID'], $currentUser['userID']);
									if ($currentLike) {
										if ($tongLike == 1) {
											echo "Bạn đã thích bài viết này";
										}
										else {
											echo "Bạn và " . (string)($tongLike - 1) . " người khác đã thích bài viết này";
										}
									}
									else {
										echo "Có " . $tongLike . " người đã thích bài viết này";
									}
								}								
							?>
						</p>
						<form id="<?php echo $fcmtID;?>">
							<div class="form-group">
								<div class="col-sm-2" style="float: left;">
									<button onclick="btnLike_Click(event)"
											class="<?php echo $plikeID;?> btn btn-outline-primary btn" 
											style="float: left;
													width: 100px;"
											type="button">
										<?php 
											if (checkLike($row['postID'], $currentUser['userID'])){
												echo "Bỏ thích";
											}
											else {
												echo "Thích";
											}
										?>					
									</button>
								</div>
								<div class="col-sm-7" style="float: left;">
									<textarea class="form-control" rows="1" style="width: 600px;float: left;" id="<?php echo $tcmtID ?>" name="cmtContent" placeholder="Bình luận"></textarea>
								</div>
								<div class="col-sm-1" style="float: left;">
									<button type="button" onclick="btnCmt_Click(event)" class="<?php echo $fcmtID;?> btn btn-primary">Đăng</button>
								</div>
								<div id="<?php echo $dcmtID; ?>" style="float: left;width: 100%; margin: 20px 0px 0px 200px">
									<?php 
										echo inDSCmtHTML($row['postID']);								
									?>
								</div>
							</div>
						</form>		
					 </div>
				</div>

		<?php endfor; ?>

		<?php if ($totalPage > 0): ?>
			<nav aria-label="..." style="margin-top: 10px;">
				<ul class="pagination ">
					<li class="page-item <?php echo ($pageIndex==0? 'disabled' : '')?>">
						<a class="page-link" href="trang-ca-nhan.php?userID=<?php echo $getUser['userID']?>&pageIndex=<?php echo $pageIndex-1?>" tabindex="-1">Previous</a>
					</li>
					<li class="page-item"><a class="page-link" href="trang-ca-nhan.php?userID=<?php echo $getUser['userID']?>&pageIndex=<?php echo $pageIndex-1?>"><?php echo ($pageIndex ==0 ? "#" : $pageIndex);?></a></li>
					<li class="page-item active">
						<a class="page-link" href="trang-ca-nhan.php?userID=<?php echo $getUser['userID']?>&pageIndex=<?php echo $pageIndex?>"><?php echo ($pageIndex + 1);?><span class="sr-only">(current)</span></a>
					</li>
					<li class="page-item"><a class="page-link" href="trang-ca-nhan.php?userID=<?php echo $getUser['userID']?>&pageIndex=<?php echo $pageIndex+1?>"><?php echo ($pageIndex == ($totalPage - 1) ? "#" : $pageIndex + 2);?></a></li>
					<li class="page-item <?php echo ($pageIndex==$totalPage-1? 'disabled' : '')?>" <?php echo ($pageIndex==0? 'disabled' : '')?>>
						<a class="page-link" href="trang-ca-nhan.php?userID=<?php echo $getUser['userID']?>&pageIndex=<?php echo $pageIndex+1?>">Next</a>
					</li>
				</ul>
			</nav>
		<?php else: ?>
			<span>Bạn không có bài viết nào</span>
		<?php endif; ?>

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