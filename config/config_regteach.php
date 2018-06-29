<?php

@ob_start(); //turns output buffering

$timezone = date_default_timezone_set("Asia/Kolkata");

if(!isset($_SESSION)) 
{ 
    session_start(); 
}

$con = mysqli_connect("localhost","root","","digilearner"); //connection variable

if(mysqli_connect_errno())
  {
	echo "failed to connect: " . mysqli_connect_errno();
  }
  ?>