<?php  
include("includes/header.php");
$num_friends = (substr_count($user['connection_array'], ",")) - 1;

if(isset($_GET['id'])) {
	$id = $_GET['id'];
}
else {
	$id = 0;
}
?>

<div class="user_details column">
			<a href=" <?php echo $userLoggedIn; ?> "> <img src="<?php echo $user['profile_pic']; ?>" height="126" width="126">  </a>

             <div class="user_details_left_right"> 


            <a href=" <?php echo $userLoggedIn; ?> ">
            <?php 
            echo $user['first_name'] . " " . $user['last_name'] . "<br>"; ?>
            </a>
            
            
            <?php echo "Connections : " . $num_friends . "<br>"; ?>
             <?php echo "Institution : " . $user['institution'] ; ?>
             </div>
		</div>

	<div class="main_column column" id="main_column">

		<div class="posts_area">

			<?php 
				$post = new Post($con, $userLoggedIn);
				$post->getSinglePost($id);
			?>

		</div>

	</div>