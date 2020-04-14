<?php

class User
{
	private $user;
	private $con;
	public function __construct($con , $user)
	{
		$this->con= $con;
		$user_details_query = mysqli_query($con,"select * from users where username='$user'");
		$this->user = mysqli_fetch_array($user_details_query );
	}

	
    public function getUsername()
    {
    	$username = $this->user['username'];
    	return $username;
     }

    public function isFriend($username_to_check){

        $username_check = "," . $username_to_check . ",";
        $username = $username_to_check;
        

        if(strstr($this->user['friend_array'], $username_check)||(  $username  == $this->user['username'])){
        return true; }
        else
          {  return false;}

    }

    public function didReceiveRequest($user_to){
    $user_from = $this->user['username'];
    $check_request_query = mysqli_query($this->con,"select * from friend_requests where user_to ='$user_to' and user_from ='$user_from'");
    if(mysqli_num_rows($check_request_query)>0)
    {
        return true;
    }
    else
    {
        return false;
    }
    }


    public function didSendRequest($user_from){
    $user_to = $this->user['username'];
    $check_request_query = mysqli_query($this->con,"select * from friend_requests where user_to ='$user_to' and user_from ='$user_from'");
    if(mysqli_num_rows($check_request_query)>0)
    {
        return true;
    }
    else {
        return false;
    }

    }


    public function removeFriend($user_to_remove){
        $logged_in_user = $this->user['username'];
        $query = mysqli_query($this->con, "select friend_array from users where username='$user_to_remove'" );
        $row = mysqli_fetch_array($query);
        $friend_array_username = $row['friend_array'];

        $new_friend_array = str_replace($user_to_remove . ",", "", $this->user['friend_array']);
        $remove_Friend = mysqli_query($this->con,"Update  users set friend_array = '$new_friend_array' where username='$logged_in_user'");

          $new_friend_array = str_replace($logged_in_user . ",", "", $friend_array_username);
        $remove_Friend = mysqli_query($this->con,"Update  users set friend_array = '$new_friend_array' where username='$user_to_remove'");
    }


    public function sendRequest($user_to)
    {
        $user_from = $this->user['username'];
        $query = mysqli_query($this->con,"insert into friend_requests values(NULL,'$user_to','$user_from')");

    }


    public function isClosed()
    {
        $username = $this->user['username'];
        $query = mysqli_query($this->con, "select * from users where username='$username'");
        $row = mysqli_fetch_array($query);
        if($row['user_closed'] == 'yes')
            return true;
        else
            return false;

    }

    public function getFirstAndLastName(){
    	$username = $this->user['username'];
    	$query = mysqli_query($this->con,"select first_name, last_name from users where username='$username'");
    	$row = mysqli_fetch_array($query);
    	return $row['first_name']." ".$row['last_name'];
    }


    public function getProfilepic(){
        $username = $this->user['username'];
        $query = mysqli_query($this->con,"select profile_pic from users where username ='$username'");
        $row = mysqli_fetch_array($query);
        return $row['profile_pic'];

    }


   
    public function getFriendArray(){
        $username = $this->user['username'];
        $query = mysqli_query($this->con,"select friend_array from users where username ='$username'");
        $row = mysqli_fetch_array($query);
        return $row['friend_array'];

    }

    public function getNumPosts()
    {
    	$username = $this->user['username'];
    	$query = mysqli_query($this->con,"select num_posts from users where username = '$username'");
    	$row = mysqli_fetch_array($query);
    	return $row['num_posts'];
    }

    public function getNumLikes()
    {
         $username = $this->user['username'];
         $query = mysqli_query($this->con,"select num_likes from users where username = '$username'");
    	 $row = mysqli_fetch_array($query);
    	 return $row['num_likes'];


    }


}


?>