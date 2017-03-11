<?php
include 'connect.php';
include 'functions.php';

if(isset($_GET['name'])&&isset($_GET['password'])&&isset($_GET['decision'])&&isset($_GET['id'])){
	$name=$_GET['name'];
	$pass=$_GET['password'];
	$decision=$_GET['decision'];
	$id=$_GET['id'];
	$myusername = mysqli_real_escape_string($db,$name);
		$mypassword = mysqli_real_escape_string($db,$pass);

		$sql = "SELECT * FROM user_login WHERE Username = '$myusername' and Password = '$mypassword'";
		$result = mysqli_query($db,$sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		//$active = $row['active'];
		$count = mysqli_num_rows($result);

		if($count == 1) {

			 
			 if ($row['user_type']=="volunteer") {
			 	$sql = "UPDATE volunteer_schedule SET decision='$decision' where id=$id";
			 	$result = mysqli_query($db,$sql);
			 	if ($result) {
			 		echo 1;
			 	}else{
			 		echo 0;
			 	}
			 }elseif ($row['user_type']=="student") {			
			 }elseif ($row['user_type']=="course_admin") {
			 	
			 }
					
		}



		}else {
					echo "0";
					
				}

?>