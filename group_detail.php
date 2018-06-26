<?php 
include("includes/header.php");

$query = "SELECT * FROM `groups` WHERE `id`=".base64_decode($_GET['id']);
$sql = mysqli_query($con, $query);
$result = mysqli_fetch_array($sql,MYSQLI_ASSOC);

?>

		<div class="user_details">
			<a href=" <?php echo $userLoggedIn; ?> "> <img src="<?php echo $user['profile_pic']; ?>">  </a>

             <div class="user_details_left_right"> 


            <a href=" <?php echo $userLoggedIn; ?> "> <br><b>
            <?php 
            echo $user['first_name'] . " " . $user['last_name'] . "<br> <br>"; ?>
            </a></b>
            
            
            <?php echo "Connections : " . $num_friends . "<br> <br>"; ?>
             <?php echo "Institution : " . $user['institution'] . "<br> <br>"; ?> 

             
              <a href="javascript:void(0)" data-toggle="modal" data-target="#createGroup">Create Group</a>

              <?php $query = "SELECT `groups`.`id`, `groups`.`grp_name` FROM `group_members` JOIN `groups` ON `group_members`.`group_id`=`groups`.`id` WHERE `group_members`.`user_name` = '$userLoggedIn'";
              $sql = mysqli_query($con, $query); ?>

              <div class="dropdown show">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="yourGroupNames" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Your Groups
                </a>

                <div class="dropdown-menu" aria-labelledby="yourGroupNames">
                  <?php 
                  if(mysqli_num_rows($sql)!=0) {
                      foreach (mysqli_fetch_all($sql, MYSQLI_ASSOC) as $key => $value) { ?>
                        <a class="dropdown-item" href="group_detail.php?id=<?php echo base64_encode($value['id']) ?>"><?php echo $value['grp_name'] ?></a><br>
                      <?php }
                  } ?>
                  
                </div>
              </div>
             

             </div>
		</div>

		<div class="main_column">
			<div class="row">
				<div class="col-md-12">
					<img src="<?php echo $result['picture'] ?>" style="width: 100%;">
					<h4><?php echo $result['grp_name'] ?></h4>
					<p><?php echo $result['grp_info'] ?></p>
				</div>
			</div>
		</div>