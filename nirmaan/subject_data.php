<?php
include 'connect.php';
include 'functions.php';

if(isset($_GET['class'])&&isset($_GET['subject'])){
	$class=$_GET['class'];
	$subject=$_GET['subject'];

	
		$topics = array();
		$sql = "SELECT id,chapter_name,chapter_number FROM topics WHERE class = '$class' and subject = '$subject'";
		$result = mysqli_query($db,$sql);
		//$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
		//$active = $row['active'];
		//$count = mysqli_num_rows($result);

		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){

					//$row1['scheduled_visit']=strtotime($row1['scheduled_visit']) * 1000;
					array_push($topics,$row);
								
				}
		echo json_encode(array('topics'=>$topics));
		die();

		}elseif (isset($_GET['class'])) {
			$class=$_GET['class'];
			$subjects = array();
			$sql = "SELECT DISTINCT subject FROM topics WHERE class='$class'";
			$result = mysqli_query($db,$sql);
			while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){

					
					array_push($subjects,$row['subject']);
								
				}
			echo json_encode(array('subjects'=>$subjects));

		} else{
			echo 0;
		}

?>
