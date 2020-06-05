
<?php




		$conn = new mysqli('localhost', 'root', '', 'web2020');



		if($conn->connect_error){
			die("fail to connect!".$conn->connect_error);
		}
 

	if(isset($_POST['query'])){
		$inpText = $_POST['query'];

 
		$query = "SELECT fullname,userID FROM myuser WHERE fullname LIKE '%$inpText%'";
		$result =$conn->query($query);

		if($result->num_rows>0){
			while($row=$result->fetch_assoc()){
	
				echo "<a href='trang-ca-nhan.php?userID=".$row['userID']."' class='list-group-item list-group-item-action-border-1'>".$row['fullname']."</a>";
			}
		}
		else{
			echo "<p class='list-group-item border-1'>No Record</p>";
		}
			

	}

?>