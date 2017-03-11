<?php

include 'connect.php';
function volunteer_data($myusername){

					global $db;
					$sql="Select volunteer_id,topic_id,scheduled_visit,class,subject,chapter_number,chapter_name,reference 
							from volunteer_schedule,topics where volunteer_id= '$myusername' AND topic_id=topics.id";
					$result = mysqli_query($db,$sql);
					
					$jsondata=array();
					
					$mcqs=array();
					$blanks=array();
					$truefalse=array();
						
					while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
						
						$scheduled_visit=$row['scheduled_visit'];
						$sql1="SELECT * from mcq where topic_id='$row[topic_id]'";
						$result1 = mysqli_query($db,$sql1);
						while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
						$row1['scheduled_visit']=strtotime($scheduled_visit) * 1000;
						array_push($mcqs,$row1);
							
						}
						
						
						$sql2="Select * from blanks where topic_id='$row[topic_id]'";
						$result2 = mysqli_query($db,$sql2);
						while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
							$row2['scheduled_visit']=strtotime($scheduled_visit) * 1000;
							array_push($blanks,$row2);
						}
						
						
						$sql3="Select * from truefalse where topic_id='$row[topic_id]'";
						$result3 = mysqli_query($db,$sql3);
						while($row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC)){
							$row3['scheduled_visit']=strtotime($scheduled_visit) * 1000;
							array_push($truefalse,$row3);
						}
						

						
						
					}
					$data['mcqs']=$mcqs;
					$data['blanks']=$blanks;
					$data['truefalse']=$truefalse;
					array_push($jsondata,$data);
					
					return json_encode($data);
}



function student_data($name){
	global $db;
	$jsondata = array();

				 	$sql="Select user_id,name,class from `students` where user_id= '$name'";
						$result = mysqli_query($db,$sql);
						$topic_count=array();
						while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
							$class=$row['class'];	
							$material=array();
							$mcqs=array();
							$truefalse=array();
							$blanks=array();
							
							$sql1="SELECT * FROM `topics` WHERE class={$class}";
							$result1 = mysqli_query($db,$sql1);
							while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){

								
								array_push($material,$row1);
								$topic_id=$row1['id'];
								
								
								$sql2="SELECT mcq.id,mcq.topic_id,mcq.question,mcq.A,mcq.B,mcq.C,mcq.D,mcq.ans,topics.subject FROM `mcq`,`topics` WHERE mcq.topic_id=topics.id and mcq.topic_id={$topic_id}";
								$result2 = mysqli_query($db,$sql2);
								while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
									array_push($mcqs,$row2);
									
								}
								
								
								
								$sql3="SELECT truefalse.id,truefalse.topic_id,truefalse.question,truefalse.ans,topics.subject FROM `truefalse`,`topics` WHERE truefalse.topic_id=topics.id and truefalse.topic_id=${topic_id}";
									$result3 = mysqli_query($db,$sql3);
									while($row3 = mysqli_fetch_array($result3,MYSQLI_ASSOC)){
										array_push($truefalse,$row3);
										
								}
									
								
							$sql4="SELECT blanks.id,blanks.topic_id,blanks.question,blanks.ans,topics.subject FROM `blanks`,`topics` WHERE blanks.topic_id=topics.id and blanks.topic_id={$topic_id}";
									$result4 = mysqli_query($db,$sql4);
									while($row4 = mysqli_fetch_array($result4,MYSQLI_ASSOC)){
										array_push($blanks,$row4);
									}
							



									
									}	


									$sql5="SELECT COUNT(*) AS topics,subject FROM `topics` GROUP BY class,subject HAVING class={$class}";
									$result5 = mysqli_query($db,$sql5);
									while($row5 = mysqli_fetch_array($result5,MYSQLI_ASSOC)){
										array_push($topic_count,$row5);
									}
									$data['material']=$material;
									$data['mcqs']=$mcqs;
									$data['truefalse']=$truefalse;
									$data['blanks']=$blanks;
									$data['topic_count']=$topic_count;
									array_push($jsondata,$data);
									return json_encode($data);
									
						}


}


function admin_data(){
	global $db;

	$volunteer_details=array();

			 	$sql1="SELECT name,bits_id from `volunteers`";
			 	$result1 = mysqli_query($db,$sql1);
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
						$id=$row1['bits_id'];
						$data['name']=$row1['name'];
						$data['user_id']=$id;
						$data['visits']=array( );
						$sql2="SELECT scheduled_visit,decision from `volunteer_schedule` where volunteer_id='{$id}'";
			 			$result2 = mysqli_query($db,$sql2);
						while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
							$row2['scheduled_visit']=strtotime($row2['scheduled_visit']) * 1000;
							array_push($data['visits'],$row2);
						}
						array_push($volunteer_details, $data);
				}

				return json_encode(array('volunteers' => $volunteer_details ));
}

function volunteer_search($key){
	global $db;

	$volunteer_details=array();

			 	$sql1="SELECT name,bits_id from `volunteers` where name like '%$key%' or bits_id like '%$key%' ";
			 	$result1 = mysqli_query($db,$sql1);
				while($row1 = mysqli_fetch_array($result1,MYSQLI_ASSOC)){
						$id=$row1['bits_id'];
						$data['name']=$row1['name'];
						$data['user_id']=$id;
						$data['visits']=array( );
						$sql2="SELECT scheduled_visit,decision from `volunteer_schedule` where volunteer_id='{$id}'";
			 			$result2 = mysqli_query($db,$sql2);
						while($row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC)){
							$row2['scheduled_visit']=strtotime($row2['scheduled_visit']) * 1000;
							array_push($data['visits'],$row2);
						}
						array_push($volunteer_details, $data);
				}

				return json_encode(array('volunteers' => $volunteer_details ));
}

?>