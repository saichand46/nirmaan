<?php
include 'connect.php';
//$data=$_POST['jsonstring'];
//$data_array=json_decode($data);
//$name=$data_array['name'];
//$pass=$data_array['password'];
$data=array();
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

		// If result matched $myusername and $mypassword, table row must be 1 row

		if($count == 1) {

			 $success=1;
			 if ($row['user_type']=="volunteer") {
			 	$privilege=1;
			 }elseif ($row['user_type']=="student") {
			 	$privilege=2;
			 }elseif ($row['user_type']=="course_admin") {
			 	$privilege=0;
			 }
			 
			/*session_start();
			$_SESSION['login_user'] = $myusername;
			$_SESSION['Privilege']= $row['Privilege'];
			header("location:welcome.php");*/
		}else {
			$success=0;
			/*session_start();
			$_SESSION['errMsg'] = "Invalid username or password";*/
			//header("location:index.php" );
		}
}
else{
	echo "Check Parameters";
}
array_push($data, array('success' => $success ));
array_push($data, array('privilege' => $privilege ));
echo json_encode(array('success'=>$success,'privilege' => $privilege),JSON_FORCE_OBJECT);

?>