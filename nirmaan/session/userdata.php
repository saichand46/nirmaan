<?php
include 'connect.php';
//$data=$_POST['jsonstring'];
//$data_array=json_decode($data);
//$username=$data_array['username'];
session_start();

$username=$_SESSION['username'];


$sql="Select user_type from user_login where username= '$username'";
$result = mysqli_query($db,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
if($row['user_type']=='volunteer'){
	$sql="Select volunteer_id,topic_id,scheduled_visit,class,subject,chapter_number,chapter_name,reference 
			from volunteer_schedule,topics where volunteer_id= '$username' AND topic_id=topics.id";
	$result = mysqli_query($db,$sql);
	
	$jsondata=array();
	
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		$mcqs=array();
		$blanks=array();
		
		$sql1="Select * from mcq where topic_id='$row[topic_id]'";
		$result1 = mysqli_query($db,$sql1);
		while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
			array_push($mcqs,$row1);
		}
		$row['mcqs']=$mcqs;
		
		$sql2="Select * from blanks where topic_id='$row[topic_id]'";
		$result2 = mysqli_query($db,$sql2);
		while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
			array_push($blanks,$row2);
		}
		$row['blanks']=$blanks;
		
		array_push($jsondata,$row);
		
	}
	
	echo json_encode($jsondata);
	
}
?>
