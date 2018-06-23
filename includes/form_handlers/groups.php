<?php
error_reporting(0);
//require $_SERVER['DOCUMENT_ROOT'].'/Digital_learner/config/config_regteach.php';
include("../../config/config_regteach.php");

if(isset($_POST['create_group']))
{
	$group_name = $_POST['grp_name'];
	$group_info = $_POST['grp_info'];
	$group_members = $_POST['grp_members'];
	
	$uploadOk = 1;
	$imageName = $_FILES['grp_image']['name'];
	
	if($imageName != "") {

		$uniqueId = uniqid();
		$group_image_name = "assets/images/group_cover_photos/". $uniqueId . basename($imageName);
		$targetDir = "../../assets/images/group_cover_photos/";
		$imageName = $targetDir . $uniqueId . basename($imageName);
		$imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

		if($_FILES["grp_image"]["size"] > 2048000) {
			$uploadOk = 0;
			$errorMessage = "Sorry your file is too large, images below 2Mb is possible to upload :) ";
		}

		if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg") {
				$errorMessage = "Sorry, only jpeg, jpg and png files are allowed";
				$uploadOk = 0;
		}

		if($uploadOk == 1) {
			if(move_uploaded_file($_FILES['grp_image']['tmp_name'], $imageName)) {
				//image uploaded okay
				$uploadOk = 1;
			}
			else {
				//image did not upload
				$uploadOk = 0;
			}
		}
	}

	$username = $_SESSION['username'];
	$date = date('Y-m-d H:i:s');

	$myGrpQuery = mysqli_query($con, "INSERT INTO groups VALUES (NULL, '$group_name', '$group_info', '$group_image_name', '$username', '1', 'date')");
	//echo $myGrpQuery;die;

	$last_added_group_id = mysqli_insert_id($con);

	$membersArray = explode(",",$group_members);
	if(!empty($membersArray)) {
		foreach($membersArray as $members) {
			$myGrpMembersQuery = mysqli_query($con, "INSERT INTO group_members VALUES (NULL, '$last_added_group_id', '$members', 'date')");
		}
	}

	header("Location: ../../index.php");
}

?>