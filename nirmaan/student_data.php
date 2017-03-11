<?php
include 'connect.php';
include 'functions.php';
//$data=$_POST['jsonstring'];
//$data_array=json_decode($data);
//$username=$data_array['username'];


if(isset($_GET['name'])&&isset($_GET['password'])){
	$name=$_GET['name'];
	$pass=$_GET['password'];

	$myusername = mysqli_real_escape_string($db,$name);
		$mypassword = mysqli_real_escape_string($db,$pass);

		$sql = "SELECT * FROM user_login WHERE Username = '$myusername' and Password = '$mypassword'";
		$result = mysqli_query($db,$sql);
		$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		//$active = $row['active'];
		$count = mysqli_num_rows($result);

		if($count == 1) {

			 
			 if ($row['user_type']=="volunteer") {
			 
			 	//echo volunteer_data($name);
			 }elseif ($row['user_type']=="student") {
			 	
			 	echo student_data($name);
			
						
			 }elseif ($row['user_type']=="course_admin") {
			 	
			 }
					
		}



		}else {
					echo "0";
					
				}

?>
