<?php
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");
?>



<div class="main_column column" id="main_column">

<h2>Friend Requests</h2>

<?php

$query = mysqli_query($con, "select * from friend_requests where user_to='$userLoggedIn'");

if(mysqli_num_rows($query) == 0)
{
 echo "No friend request at this moment";
}
else
{

while($row = mysqli_fetch_array($query)){
$user_from = $row['user_from'];

$user_from_obj = new User($con, $user_from);

echo $user_from_obj->getFirstAndLastName() ." ". " sent you a friend request";
$user_from_friend_array = $user_from_obj->getFriendArray();



if(isset($_POST['accept_request' . $user_from]))
{
	$add_friend_query = mysqli_query($con,"update users set friend_array = CONCAT(friend_array,'$user_from,') where username ='$userLoggedIn'");
    $add_friend_query = mysqli_query($con,"update users set friend_array = CONCAT(friend_array,'$userLoggedIn,') where username ='$user_from'");
    $delete_friend = mysqli_query($con, "delete from friend_requests where user_to ='$userLoggedIn' and user_from = '$user_from'");


}

if(isset($_POST['ignore_request' . $user_from]))
{
	 $delete_friend = mysqli_query($con, "delete from friend_requests where user_to ='$userLoggedIn' and user_from = '$user_from'");
}

?>

<form action="requests.php" method="post">
	<input type="submit" name="accept_request<?php echo $user_from;?>" id ="accept_button" value="accept">
    <input type="submit" name="ignore_request<?php echo $user_from;?>" id ="ignore_button" value="ignore ">
    
		


</form>

<?php


}

}

?>



</div>



