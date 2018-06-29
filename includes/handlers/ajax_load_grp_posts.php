<?php  
include("../../config/config_regteach.php");
include("../classes/User.php");
include("../classes/Post.php");

$limit = 10; //Number of posts to be loaded per call
//echo "<pre>";print_r($_REQUEST);die;
$posts = new Post($con, $_REQUEST['userLoggedIn']);
$posts->loadGrpPostsFriends($_REQUEST, $limit);
?>