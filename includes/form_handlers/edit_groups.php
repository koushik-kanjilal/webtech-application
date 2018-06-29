<?php
error_reporting(0);
//require $_SERVER['DOCUMENT_ROOT'].'/Digital_learner/config/config_regteach.php';
include("../../config/config_regteach.php");

if(isset($_POST['edit_group']))
{

	$group_name = $_POST['grp_name'];
	$group_info = $_POST['grp_info'];
	$group_members = implode(",", $_POST['grp_members']);
	//echo implode(",", $_POST['grp_members']);die;
	
	
	if($_FILES['grp_image']['name'] != "") {
		$uploadOk = 1;
		$imageName = $_FILES['grp_image']['name'];

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
	$update_qry = "UPDATE `groups` SET `grp_name`='".$group_name."', `grp_info`='".$group_info."'";
	if($imageName!=""){
		$update_qry.=", `picture`='".$imageName."'";
	}
	$update_qry.=" WHERE `id`=".base64_decode($_GET['id']);
	//echo $update_qry;die;

	$myGrpQuery = mysqli_query($con, $update_qrys);
	//echo $myGrpQuery;die;

	$last_added_group_id = base64_decode($_GET['id']);
	mysqli_query($con, "DELETE FROM `group_members` WHERE `group_id`=".base64_decode($_GET['id']));
	if($group_members == '') {
		$group_members = $username;
	} else {
		$group_members = $group_members.','.$username;
	}
	//echo $group_members;die;

	$membersArray = explode(",",$group_members);
	if(!empty($membersArray)) {
		foreach($membersArray as $members) {
			$myGrpMembersQuery = mysqli_query($con, "INSERT INTO group_members VALUES (NULL, '$last_added_group_id', '$members', '$date')");
		}
	}

	header("Location: ../../index.php");
}

?>