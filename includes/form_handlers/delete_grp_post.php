<?php 
require '../../config/config_regteach.php';
	echo "h";die();
	if(isset($_GET['post_id']))
		echo $post_id = $_GET['post_id'];die;

	if(isset($_POST['result'])) {
		if($_POST['result'] == 'true')
			$query = mysqli_query($con, "UPDATE grp_posts SET deleted='yes' WHERE id='$post_id'");
	}

?>