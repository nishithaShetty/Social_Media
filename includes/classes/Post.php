<?php

class Post {
 private $user_obj; 
 private $con;

public function __construct($con,$user)
 {
 	$this->con = $con;
 	$this->user_obj = new User($con,$user);

 }

public function submitPost($body, $user_to)
 {
 	$body=strip_tags($body);
 	$body = str_replace('\r\n', '\n', $body);
 	$body= nl2br($body);
 	$date_added = date("Y-m-d h:i:s");
 	$added_by = $this->user_obj->getUsername();


 	if($user_to == $added_by )
 	{
 		$user_to="none";

 	}

   $insert_query = mysqli_query($this->con,"insert into posts values(NULL,'$body','$added_by','$user_to','$date_added','no','no','0')");

 	$returned_id = mysqli_insert_id($this->con);

 	$num_posts = $this->user_obj->getNumPosts();
 	$num_posts++;
 	$update_query= mysqli_query($this->con,"update users set num_posts ='$num_posts' where username = '$added_by'");
 }



public function loadPostsFriends()
{
	$userLoggedIn = $this->user_obj->getUsername();
	$str = "";
	$data = mysqli_query($this->con, "select * from posts where deleted ='no' order by id desc");

	while($row= mysqli_fetch_array($data))
	{
		$id = $row['id'];
		$body = $row['body'];
		$added_by = $row['added_by'];
		$date_added = $row['date_added'];


		if($row['user_to'] == "none")
		{
			$user_to ="";
		}

		else
		{
			$user_to_obj = new User($con,$row['user_to']);
			$user_to_name = $user_to_obj->getFirstAndLastName();
			$user_to = "to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
		}


		$added_by_obj = new User($this->con, $added_by);
		if($added_by_obj->isClosed())
		{
			continue;

		}
		$user_logged_obj = new User($this->con,$userLoggedIn);
        if($user_logged_obj->isFriend($added_by)){



					$user_details_query = mysqli_query($this->con,"Select * from users where  username='$added_by'");
					$user_row = mysqli_fetch_array($user_details_query);
					$first_name = $user_row['first_name'];
					$last_name = $user_row['last_name'];
					$profile_pic = $user_row['profile_pic'];



					?>

             <script>
             	function toggle<?php echo $id;?>()
		             {
		             	var element = document.getElementById("toggleComment<?php echo $id; ?>");
		             	if(element.style.display == "block")
		             	{
		             		element.style.display = "none";
		             	}
		             	else
		             		element.style.display ="block";
		             }
             </script>



					<?php

			        //Timeframe
			        $date_time_now = date("Y-m-d H:i:s");
			        $start_date = new DateTime($date_added);// time of post 
			        $end_date = new DateTime($date_time_now); // current time
			        $interval = $start_date->diff($end_date);

			        if($interval->y >= 1){
			          if($interval == 1)
			          	 $time_message = $interval->y . "year ago";//1 year ago
			          else
			          	 $time_message = $interval->y . "years ago";
			        }

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

					else if($interval->d >=1){
						if($interval->d == 1){
							$time_message =  "Yesterday";
						}
						else{
							$time_message = $interval->d . "days ago";
						}
					}

					else if($interval->h >=1){
						if($interval->h == 1){
							$time_message =  $interval->h ."hour ago";
						}
						else{
							$time_message = $interval->h . "hours ago";
						}
					}

					else if($interval->i >=1){
						if($interval->i == 1){
							$time_message =  $interval->i ."minute ago";
						}
						else{
							$time_message = $interval->i . "minutes ago";
						}
					}

					else if($interval->s >=1){
						if($interval->s == 1){
							$time_message =  $interval->s ."seconds ago";
						}
						else{
							$time_message = $interval->s . "seconds ago";
						}
					}

			    $str.="<div class='status_post' onClick='javascript:toggle$id()'>
			    			<div class='post_profile_pic'>
			    			   <img src = '$profile_pic' width='50'>
			    			</div> 
			    			<div class='posted_by'>
			    			   <a href='$added_by'>$first_name $last_name</a>$user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
			    			</div>
			    			<div id='post_body'>
			    			  $body
			    			  <br>

			    			</div>
			          </div>
			          <div name='post_comment' id ='toggleComment$id' style = 'display:block;' >
			             <iframe src='comment_frame.php?post_id=$id' id='comment_iframe'></iframe>	
			          </div>
			          <hr>" ;
            }
}


echo $str;

}



}
?>