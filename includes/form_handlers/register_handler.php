<?php
//declaring variables to prevent errors

$fname = "";
$lname ="";
$em = "";
$em2 = "";
$password ="";
$password2 = "";
$date ="";
$error_array =array();
//array initilization


if(isset($_POST['register_button']))
{

$fname = strip_tags($_POST['reg_fname']);
$fname = str_replace(' ','',$fname);
$fname = ucfirst(strtolower($fname));
$_SESSION['reg_fname'] = $fname; 

$lname = strip_tags($_POST['reg_lname']);
$lname = str_replace(' ', '', $lname);
$lname = ucfirst(strtolower($lname));
$_SESSION['reg_lname'] = $lname;

$em = strip_tags($_POST['reg_email']);
$em = str_replace(' ','',$em);
$em = ucfirst(strtolower($em));
$_SESSION['reg_email'] = $em;

$em2 = strip_tags($_POST['reg_email2']);
$em2 = str_replace(' ','',$em2);
$em2 = ucfirst(strtolower($em2));
$_SESSION['reg_email2'] = $em2;

$password = strip_tags($_POST['reg_password']);

$password2 = strip_tags($_POST['reg_password2']);

$date = date("Y-m-d");


if(strlen($fname)>25 || strlen($fname)<2)
{
	array_push($error_array,"your first name must be between 2 and 25 characters" );
}
if(strlen($lname)>25|| strlen($lname)<2)
{

	array_push($error_array,"your last name must be between 2 and 25 characters" );
	
}

if($em == $em2)
{
if(filter_var($em,FILTER_VALIDATE_EMAIL))
{
 
 $e_check = mysqli_query($con,"select email from users where email='$em'" );
 $num_rows = mysqli_num_rows($e_check);
 if($num_rows >0)
 {  
    //array_push(array, var)
 	array_push($error_array, "email already in use");
 	
 }
}
else
{
	array_push($error_array,"invalid format");
	
}
}
else
{
	array_push($error_array, "emails do not match");

}

if($password != $password2)
{
    array_push($error_array, "passwords dont match");

}

else
{
	if(preg_match('/[^A-Za-z0-9]/', $password))
	{
		array_push($error_array, "your password can only contain english characters and numeric digits");
		
	}
}


if(empty($error_array))
{   // encryting the password
	$password = md5($password);
    
    // automatically creating the username
    $username = strtolower($fname ."_". $lname);
    $check_username_query = mysqli_query($con,"select username from users where username ='$username'");
    
    $i = 0;
    while(mysqli_num_rows($check_username_query)!=0)
    {
    $i++;
    $username = $username . "_" . $i;
    $check_username_query = mysqli_query($con,"select username from users where username ='$username'");
   
    }

// random assignment profile picture

$rand = rand(1,2);

if($rand == 1)
{

	$profile_pic = "assets/images/profile_pics/defaults/superman.png";
}

else if($rand ==2)
{
	$profile_pic = "assets/images/profile_pics/defaults/bat.png";
}


//$username = strtolower($fname ."_". $lname);
$query = mysqli_query($con,"insert into users values(NULL,'$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','no',',')");

array_push($error_array,"REGISTRATION COMPLETE" );
$_SESSION['reg_fname'] = "";
$_SESSION['reg_lname'] = "";
$_SESSION['reg_email'] = "";
$_SESSION['reg_email2'] = "";
$_SESSION['reg_password'] = "";
$_SESSION['reg_password2'] = "";

}

}


?>