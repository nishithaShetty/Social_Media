<?php
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");

if(isset($_GET['profile_username']))
{
	$username = $_GET['profile_username'];
	$user_detail_query = mysqli_query($con, "select * from users where username = '$username'");
	$user_array = mysqli_fetch_array($user_detail_query);
	$num_friends = (substr_count($user_array['friend_array'],","))-1;

}



if(isset($_POST['remove_friend']))
{
  $user = new User($con, $userLoggedIn);
  $user->removeFriend($username);
}


if(isset($_POST['add_friend']))
{
  $user = new User($con, $userLoggedIn);

  $user->sendRequest($username);
}

if(isset($_POST['respond_request']))
{
  header("Location: requests.php");
}


?>
<div class="profile_left">
  <img src="<?php echo $user_array['profile_pic']; ?>">
  <div class="profile_info">
  	 <p><?php echo "Posts: " . $user_array['num_posts']; ?></p><br>
  	 <p><?php echo "Likes: " . $user_array['num_likes']; ?></p><br>
  	 <p><?php echo "Friends: " . $num_friends ?></p>

  </div>
 
  <form action="<?php echo $username; ?>" method="post">
  <?php
  $profile_user_obj = new User($con,$username);
  if($profile_user_obj->isClosed()){
  	header('Location: user_closed.php');

  }
  $logged_in_user_obj = new User($con, $userLoggedIn);
  if($username != $userLoggedIn)
  {
  	if( $logged_in_user_obj->isFriend($username))
  	{
  		echo '<input type="submit" class="danger" name="remove_friend" value="REMOVE" >';
  	}
  	else if($logged_in_user_obj->didReceiveRequest($username)){
  		echo '<input type="submit" name="respond_request" class="warning" value="Request Received" class="btn-btn-danger">';
  	}
  	else if($logged_in_user_obj->didSendRequest($username)){
  		echo '<input type="submit" name="sent_request" class="default" value="Request sent" >';
  	}
  		else{
  		echo '<input type="submit" name="add_friend" class="success" value="Add friend" ">';
  	}
  }




  ?>  	


  </form>

</div>



	<div class="main_column column">
		
	</div>
	</div>
</body>

</html>