<?php
 ob_start(); // xóa kí tự lạ đầu file
  require_once ('init.php');
  require_once ('functions.php');
?>

<?php 
  include 'check-before-login.php';
  include 'header.php';
?>

<?php 
	$rows = array();
	$rows = getNewFeed($currentUser['userID']);

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

	// nếu như chỉ số trang người ta cho lớn hơn tổng số trang thì chỉ số trang sẽ bằng trang cuối
	if ($pageIndex > $totalPage - 1) {
		$pageIndex = $totalPage - 1;
	}

	$rowStartIndex = $pageIndex * $rowPerPage;
	$rowEndIndex = $rowStartIndex + $rowPerPage;

	if ($rowEndIndex > $totalRow) {
		$rowEndIndex = $totalRow;
	}
?>

	<div class="container">
		<h1>Chào mừng <?php echo $currentUser['fullname'] ?> đã quay trở lại</h1>
		<form method="POST" action="create-post.php" enctype="multipart/form-data">
			<div class="form-group">
				<textarea style="width: 80%;" class="form-control" rows="3" id="post" name="content[]" placeholder="Bạn đang nghĩ gì ?"></textarea>
				<div class="custom-file">
					<input type='file' id="i_file" name='hinhanh[]' multiple>
				</div>
				<div>
					<label for="selectPrivacy">Chế độ: </label>	
					<select id="selectPrivacy" name="privacy">
						<option value="private" >Riêng tư</option>
						<option value="friend" >Bạn bè</option>
						<option value="public" selected>Công khai</option>
					</select>
				</div>
				<div>
					<button name="submit" type="submit" class="btn btn-primary">Đăng bài viết</button>
				</div>
			</div>
		</form>
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
												echo "Bỏ Thích";
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

		<nav aria-label="..." style="margin-top: 10px;">
			<ul class="pagination ">
				<li class="page-item <?php echo ($pageIndex==0? 'disabled' : '')?>">
					<a class="page-link" href="index.php?pageIndex=<?php echo $pageIndex-1?>" tabindex="-1">Previous</a>
				</li>
				<li class="page-item"><a class="page-link" href="index.php?pageIndex=<?php echo $pageIndex-1?>"><?php echo ($pageIndex ==0 ? "#" : $pageIndex);?></a></li>
				<li class="page-item active">
					<a class="page-link" href="index.php?pageIndex=<?php echo $pageIndex?>"><?php echo ($pageIndex + 1);?><span class="sr-only">(current)</span></a>
				</li>
				<li class="page-item"><a class="page-link" href="index.php?pageIndex=<?php echo $pageIndex+1?>"><?php echo ($pageIndex == ($totalPage - 1) ? "#" : $pageIndex + 2);?></a></li>
				<li class="page-item <?php echo ($pageIndex==$totalPage-1? 'disabled' : '')?>" <?php echo ($pageIndex==0? 'disabled' : '')?>>
					<a class="page-link" href="index.php?pageIndex=<?php echo $pageIndex+1?>">Next</a>
				</li>
			</ul>
		</nav>		
	</div>
<?php include 'footer.php'; ?>