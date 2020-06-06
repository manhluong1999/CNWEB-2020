<?php
 ob_start(); // xóa kí tự lạ đầu file
  require_once ('init.php');
  require_once ('functions.php');
?>
<?php
$rows = loadFriendForUser(3);
foreach ($rows as $row) {
		$fr=$row['fri'];
		echo $fr;
	}
?>

<?php include 'footer.php'; ?>
</body>