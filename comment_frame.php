<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>

	<?php 
	require 'config/config.php';
	include("includes/classes/User.php");
    include("includes/classes/Post.php");


	if(isset($_SESSION['username'])){
		$userLoggedIn = $_SESSION['username'];
		$user_details_query = mysqli_query($con, "select * from users where username = '$userLoggedIn'");
		$users = mysqli_fetch_array($user_details_query);
	}
	else
		header("Location:register.php");
	?>

	<script >
	  function toggle(){
	  	var element = document.getElementById('comment_section');

	  if(element.style.display =="block")
	  	element.style.display = "none";
	  else
	  	element.style.display = "block";
	  }
	</script>

	
 <?php
     if(isset($_GET['post_id']))
     {
     	$post_id = $_GET['post_id'];
     }
     //information about the post 
     $user_query = mysqli_query($con,"select added_by, user_to from posts where id='$post_id'");
     $row = mysqli_fetch_array($user_query );
     $posted_to = $row['added_by'];
     //----------------------------------------


     if(isset($_POST['postComment' . $post_id])){
     	$post_body = $_POST['post_body'];
     	$date_time_now = date("Y-m-d  H:i:s");
     	$insert_post = mysqli_query($con,"insert into comments values(NULL,'$post_body','$$userLoggedIn','$posted_to','$date_time_now','no','$post_id')");
     	echo "<p>Comment Posted!</p>";
     }
 
 ?>


	<form action = "comment_frame.php?post_id=<?php echo $post_id; ?>" id="comment_form" name="postComment<?php echo $post_id;?>" method="POST">
		<textarea name="post_body" placeholder="comment here">
		</textarea>
		<input type="submit" name="postComment<?php echo $post_id; ?>" value="comment">
	</form>
    
    <?php
     $get_comments = mysqli_query($con, "select * from comments where post_id ='$post_id'");
     $count = mysqli_num_rows($get_comments);
     	if($count != 0)
     		{
     		 while ($comment = mysqli_fetch_array($get_comments)) {
     		 	$comment_body = $comment['post_body'];
     		 	$posted_to = $comment['posted_to'];
     		 	$posted_by = $comment['posted_by'];
     		 	$date_added = $comment['date_added'];
     		 	$removed = $comment['removed'];
          
               
                $date_time_now = date("Y-m-d H:i:s");
			    $start_date = new DateTime($date_added);// time of post 
			    $end_date = new DateTime($date_time_now); // current time
			    $interval = $start_date->diff($end_date);
                



                //years ago
                 if($interval->y >= 1){
			       if($interval == 1)
			          	 $time_message = $interval->y . "year ago";//1 year ago
			          else
			          	 $time_message = $interval->y . "years ago";
			        }
			    // months ago
			    else if($interval->m >= 1 ){
			        if($interval->d == 0){
			        		$days ="ago";}
			        else if($interval->d == 1){
			        		$days = $interval->d . "day ago";
			        	}
			        else{
			        		$days = $interval->d . "days ago";
			        	}
			        
			        if($interval->m ==1){
			        	$time_message =$interval->m . "month". $days;
			         }
			        else{
			        	$time_message = $interval->m . "month". $days;
			        }

				    }
				//days ago
				else if($interval->d >=1){
					if($interval->d == 1){
							$time_message =  "Yesterday";
						}
					else{
							$time_message = $interval->d . "days ago";
						}
					}
                // hours ago
				else if($interval->h >=1){
					if($interval->h == 1){
							$time_message =  $interval->h ."hour ago";
						}
					else{
							$time_message = $interval->h . "hours ago";
						}
					}

                // minutes ago
				else if($interval->i >=1){
					if($interval->i == 1){
							$time_message =  $interval->i ."minute ago";
						}
					else{
							$time_message = $interval->i . "minutes ago";
						}
					}
                 //seconds ago
				else if($interval->s >=1){
					if($interval->s == 1){
							$time_message =  $interval->s ."seconds ago";
						}
					else{
							$time_message = $interval->s . "seconds ago";
						}
					}


			   

     		 }

     			}

    ?>



    <div class="comment_section">

        

    </div>



</body>
</html>	