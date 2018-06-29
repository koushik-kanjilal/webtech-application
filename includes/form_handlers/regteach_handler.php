<?php	

//declare variables to prevent errors
$fname = ""; //first name
$lname = ""; //last name
$em1 = ""; //email
$em2 = ""; //second email
$ist = ""; //institute name
$pw1 = ""; //password
$pw2 = ""; //password 2
$date = ""; //date
$error_array = array(); //error messages
$actcode= ""; //
$code = "";

if(isset($_POST['reg_button']))
{

   $code= $_POST['countryCode'];

		if (isset($_POST['gender']))
		$gender = $_POST['gender'];


		if (isset($_POST['bday']))
		$datebirth = $_POST['bday'];
			// resgistration form values

	//first name
	$fname = strip_tags($_POST['reg_fname']);// remove html tag
	$fname = str_replace(' ', '', $fname); // remove space
    $fname = ucfirst(strtolower($fname)); // upper case only first letter
    $_SESSION['reg_fname'] = $fname; //stores to session variable

	//last name
	$lname = strip_tags($_POST['reg_lname']);// remove html tag
	$lname = str_replace(' ', '', $lname); // remove space
    $lname = ucfirst(strtolower($lname)); // upper case only first letter
       $_SESSION['reg_lname'] = $lname; //stores to session variable

    	//email1
	$em1 = strip_tags($_POST['reg_em1']);// remove html tag
	$em1 = str_replace(' ', '', $em1); // remove space
    $em1 = ucfirst(strtolower($em1)); // upper case only first letter
       $_SESSION['reg_em1'] = $em1; //stores to session variable

        	//email2
	$em2 = strip_tags($_POST['reg_em2']);// remove html tag
	$em2 = str_replace(' ', '', $em2); // remove space
    $em2 = ucfirst(strtolower($em2)); // upper case only first letter
       $_SESSION['reg_em2'] = $em2; //stores to session variable
    
        // name of the institute
    	$ist = strip_tags($_POST['reg_ist']);// remove html tag
    $ist = ucfirst(strtolower($ist)); // upper case only first letter
       $_SESSION['reg_ist'] = $ist; //stores to session variable

        	//passwords
	$pw1 = strip_tags($_POST['reg_pw1']);// remove html tag
    $pw2 = strip_tags($_POST['reg_pw2']);// remove html tag
    
    $phone = $_POST['phone_no'];

	$date = date("Y-m-d"); // current date

	if($em1 == $em2){
		//check if email is in the valid format
		if (filter_var($em1,FILTER_VALIDATE_EMAIL)) {

			$em1 = filter_var($em1,FILTER_VALIDATE_EMAIL);

			//check if emails already exists
			$e_check = mysqli_query($con, "SELECT email FROM reg_teach WHERE email='$em1'");

			//count number of rows returned
			$num_rows = mysqli_num_rows($e_check);

			if($num_rows > 0){
				array_push($error_array,  "Email address already in use <br>");
			}

		}
		else { array_push($error_array, "Invalid format<br>"); }

	}
	else {
		array_push($error_array, "Emails don't match" );
	}

	if (strlen($fname) > 25 || strlen($fname) < 3) {
		array_push($error_array, "Your first name should be greater than 2 and less than 25 Charachters");
	}
    

	if($pw1 != $pw2)
	{
		array_push($error_array, "Your passwords donot match");
	}
   if (preg_match('/[^A-Za-z0-9]/', $pw1)) {
			array_push($error_array, "Your password can only contain english Charachters and numbers");
		}
	
    if(strlen($pw1) > 30 || strlen($pw1) < 6){
    array_push($error_array, "Your password must be greater than 5 and less than 30 Charachters"); }

  if (empty($error_array)) 
  {
  	$pw1 = md5($pw1);// encrypt password before swnting to database


  	//genrate user name by concatenating first and last name

   $username = strtolower($fname . "_" . $lname);

   $check_username_query = mysqli_query($con, "SELECT username FROM reg_teach WHERE username='$username'");
   $i=0;

     while (mysqli_num_rows($check_username_query) != 0) 
     {
   	 $i++;
    	$username = $username . "_" . $i;
   	 $check_username_query = mysqli_query($con, "SELECT username FROM reg_teach WHERE username='$username'");

    }

    //profile picture assignment
   $profile_pic1= "assets/images/profile_pics/defaults/teacher.png";

     	$actcode= md5(rand());

   $query = mysqli_query($con, "INSERT INTO reg_teach VALUES (NULL, '$fname', '$lname', '$username', '$em1', '$pw1', '$date', '$profile_pic1','$code' , '$phone', '$ist', '$gender', '$datebirth', ',', 'no', '0', '$actcode', 'no')");

  array_push($error_array, "<span style='color: #ff9933;'> You're all set!! Go ahead and Login </span>");

  

  //clear session variable

$_SESSION['reg_fname'] = "";
$_SESSION['reg_lname'] = "";
$_SESSION['reg_em1'] = "";
$_SESSION['reg_em2'] = "";
$_SESSION['reg_ist'] = "";
  }
}



?>