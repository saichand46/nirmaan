<?php
include 'connect.php';
include 'functions.php';
if(isset($_POST['name'])&&isset($_POST['topic_id'])&&isset($_POST['datetime'])){
	$mil = $_POST['datetime'];

$seconds = $mil / 1000;
$date=date("Y/m/d H:i:s", $seconds);
$date1=date("Y/m/d H:i:s", $seconds+3600*24);
$date2=date("Y/m/d H:i:s", $seconds-3600*24);
	$sql= "SELECT * from volunteer_schedule where volunteer_id='$_POST[name]' and scheduled_visit between '$date2' and '$date1'";
	$result = mysqli_query($db,$sql);
		
		//$active = $row['active'];
		$count = mysqli_num_rows($result);
		if($count==0)
		{
			$success=1;
			$sql1="INSERT INTO `volunteer_schedule`( `volunteer_id`, `topic_id`, `scheduled_visit`, `decision`) VALUES ('$_POST[name]','$_POST[topic_id]','$date',0)";
			$result = mysqli_query($db,$sql1);
			if ($result) {
				echo 1;
			}
		}else{
			echo 0;
		}

}

?>