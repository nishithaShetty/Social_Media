<?php
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");



if(isset($_POST['post']))
{

	$post = new Post($con, $userLoggedIn);
	$post->submitPost($_POST['post_text'],'none');
	header("Location: index.php");
}
?>
	<div class="user-details column">
		<a href="<?php echo $userLoggedIn; ?>"><img src="<?php echo $user['profile_pic'];?>"></a>
        <div class="user-details_left_right">
		<a href="<?php echo $userLoggedIn; ?>">
        <?php
        echo $user['first_name']." ".$user['last_name']; 
        ?>
		</a>
		<?php echo "Posts:".$user['num_posts']."<br>";?>
		<?php echo "Likes:".$user['num_likes']."<br>";?>
	    </div>
	</div>
		<div class="main_column column">
		<form class="post_form" action="index.php" method="post">
			<textarea name="post_text" id="post_text" placeholder="post something..."></textarea>
			<input type="submit" name="post" id="post_button" value="Post">
			<hr>
		</form>
<?php
	
	$post = new Post($con, $userLoggedIn);
	$post->loadPostsFriends();
	
?>
	</div>
</div>
</body>

</html>