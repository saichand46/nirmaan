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
			 	$schedule=array();
			 	$sql1 = "SELECT volunteer_schedule.topic_id,volunteer_schedule.scheduled_visit,topics.class,topics.subject,topics.chapter_number,topics.chapter_name,topics.reference FROM `volunteer_schedule`,`topics` WHERE volunteer_schedule.volunteer_id='$myusername' and volunteer_schedule.topic_id =topics.id  and volunteer_schedule.decision=1";
			 	$result1 = mysqli_query($db,$sql1);
				

				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){

					$row1['scheduled_visit']=strtotime($row1['scheduled_visit']) * 1000;
					array_push($schedule,$row1);
								
				}
				
				echo json_encode(array('schedule'=>$schedule));
			 }elseif ($row['user_type']=="student") {			
			 }elseif ($row['user_type']=="course_admin") {
			 	
			 }
					
		}



		}else {
					echo "0";
					
				}

?>
