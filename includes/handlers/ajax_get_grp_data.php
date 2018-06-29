<?php
include("../../config/config_regteach.php");
include("../../includes/classes/User.php");

$query = mysqli_query($con, "SELECT * FROM `groups` JOIN `group_members` ON `groups`.`id`=`group_members`.`group_id` WHERE `groups`.`id`=".$_POST['group_id']." AND `group_members`.`user_name`<>'".$_SESSION['username']."'");

$data = mysqli_fetch_all($query, MYSQLI_ASSOC);
$arr = array();
$arr['grp_name']=$data[0]['grp_name'];
$arr['grp_info']=$data[0]['grp_info'];
$arr['group_id']=$data[0]['group_id'];
foreach ($data as $key => $value) {
	$arr['members'][] = $value['user_name'];
}
echo json_encode($arr);