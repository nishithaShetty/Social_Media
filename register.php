<?php
require 'config/config.php';
require 'includes/form_handlers/register_handler.php';
require 'includes/form_handlers/login_handler.php';
?>



<!DOCTYPE html>
<html>
<head>
<title>Welcome to Swirlfeed </title>
<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script  src="assets/js/register.js"></script>
</head>

<body>

<?php
if(isset($_POST["register_button"]))
{

	echo '<script>
 $(document).ready(function(){
    $(".first").hide();
    $(".second").show();

 	});
	</script>';
}

?>
<div class="wrapper"> 

	  
	<div class="login_box">
		<div class="login_header">
     	 <h2>Swirlfeed</h2>
     	 Login or signup!
    </div>
    
    <div class="first">
		<form action ="register.php" method="post">

		   <input type="email" name="log_email" placeholder="email address" value="<?php
	         if(isset($_SESSION['log_email']))
	         {
	         	echo $_SESSION['log_email'];
	         }

			?>">
			<br>
		   <input type="password" name="log_password" placeholder="password"><br>
		   <input type="submit" name="login_button" value="Login"><br>
	        <?php
	         if(in_array("Invalid email or password", $error_array))
	         {
	         	echo "Invalid email or password";
	         }
	        ?>
	        <br>
	        <a href="#" id="signup" class="signup">Need an account, Register here</a>
		</form>
		<br>
    </div>
    <div class="second">
		<form action ="register.php" method="post">
			<input type="text" name="reg_fname" placeholder="first name" value="<?php 
	         if(isset($_SESSION['reg_fname']))
	         {
	         	echo $_SESSION['reg_fname'];
	         }
			  ?>">
			  <br>
			 <?php if(in_array("your first name must be between 2 and 25 characters",$error_array )) {echo "your first name must be between 2 and 25 characters <br>"; } ?>
			
			<input type="text" name="reg_lname" placeholder="last name" value="<?php
	         if(isset($_SESSION['reg_lname']))
	         {
	         	echo $_SESSION['reg_lname'];
	         }
			 ?>" >
	         <br>
			 <?php if(in_array("your last name must be between 2 and 25 characters",$error_array )) {echo "your last name must be between 2 and 25 characters <br>"; } ?>
			
	        <input type="email" name="reg_email" placeholder="email" value="<?php
	         if(isset($_SESSION['reg_email']))
	         {
	         	echo $_SESSION['reg_email'];
	         }
	         ?>">
	         <br>
	         <?php if(in_array("email already in use",$error_array )) {echo "email already in use <br>"; } 
	          else if(in_array("emails do not match", $error_array)) { echo "emails do not match <br>";}
	          ?>
			
			<input type="email" name="reg_email2" placeholder="confirm email" value="<?php
	         if(isset($_SESSION['reg_email2']))
	         {
	         	echo $_SESSION['reg_email2'];
	         }
			 ?>">
			<br>
			<input type="password" name="reg_password" placeholder="password" >
			<br>
			<?php if(in_array("your password can only contain english characters and numeric digits", $error_array)){ echo "your password can only contain english characters and numeric digits<br>";
		     } 


			 ?>
			<input type="password" name="reg_password2" placeholder="password1" >
			<br>
			<?php if(in_array("passwords dont match", $error_array)){echo"passwords dont match<br>";}?>
	        <input type="submit" name="register_button" value="Register" >
			<br>
			<?php if(in_array("REGISTRATION COMPLETE", $error_array)
			){echo "REGISTRATION COMPLETE";}
			?>
			<br>
			<a href="#" id="signin" class="signup">Already have an account? Sign in.</a>
	                


		</form>
</div>
</div>
</div>
</body>

</html>