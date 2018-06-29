<?php 
include("includes/header.php");

$num_friends = (substr_count($user['connection_array'], ",")) - 1;

$query = "SELECT * FROM `groups` WHERE `id`=".base64_decode($_GET['id']);
$sql = mysqli_query($con, $query);
$result = mysqli_fetch_array($sql,MYSQLI_ASSOC);

if(isset($_POST['post'])){

  $uploadOk = 1;
  $imageName = $_FILES['fileToUpload']['name'];
    $errorMessage = "Sorry your file is too large, images below 2Mb is possible to upload :) ";

  if($imageName != "") {
    $targetDir = "assets/images/posts/";
    $imageName = $targetDir . uniqid() . basename($imageName);
    $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

    if($_FILES["fileToUpload"]["size"] > 2048000) {
      $uploadOk = 0;
    }

    if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg") {
        $errorMessage = "Sorry, only jpeg, jpg and png files are allowed";
        $uploadOk = 0;
    }

    if($uploadOk) {
      if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)) {
        //image uploaded okay

      }
      else {
        //image did not upload
        $uploadOk = 0;
      }
    }

  }

  if($uploadOk) {
    $post = new Post($con, $userLoggedIn);
    $post->submitGrpPost($_POST['post_text'], $_POST['group_id'], 'none', $imageName);
  }
  else {
    echo "<div style='text-align:center;' class='alert alert-danger'>
        $errorMessage
      </div>";
  }

}
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
					<h4>
						<?php echo $result['grp_name'] ?>
						<?php if($userLoggedIn==$result['created_by']){ ?>
							<a href="javascript:void(0)" class="grp_edit" data-val="<?php echo base64_decode($_GET['id']) ?>"><i class="fa fa-edit"></i></a>
						<?php } ?>
						</h4>
					<p><?php echo $result['grp_info'] ?></p>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<form class="post_form" action="" method="POST" enctype="multipart/form-data">
						<input type="file" name="fileToUpload" id="fileToUpload" >
						<input type="hidden" name="group_id" value="<?php echo base64_decode($_GET['id']) ?>">
						<textarea name="post_text" id="post_text" placeholder="Got something to share?"></textarea>
						<input type="submit" name="post" id="post_button" value="Post">
						<hr>

					</form>

			        <div class="posts_area"></div>
					<img id="loading" src="assets/images/icons/loading.gif">
				</div>
			</div>
		</div>

<?php $grp_membr_qry = mysqli_query($con, "SELECT `user_name` FROM `group_members` WHERE `group_id`=".base64_decode($_GET['id'])." AND `user_name` <> '".$userLoggedIn."'");

$grpMembrs=array_column(mysqli_fetch_all($grp_membr_qry,MYSQLI_ASSOC), "user_name");
//echo "<pre>"; print_r($grpMembrs);die; ?>
<div class="modal fade" id="editGroup" tabindex="-1" role="dialog" aria-labelledby="postGroupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="postGroupModalLabel">Create New Group</h4>
      </div>

      <div class="modal-body">
        <form class="profile_post" action="includes/form_handlers/edit_groups.php?id=<?php echo $_GET['id'] ?>" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="grp_name">Group Name</label>
            <input type="text" class="form-control" id="grp_name" name="grp_name" value="<?php echo $result['grp_name'] ?>" required="required">
          </div>
           <div class="form-group">
            <label for="grp_info">Group Info</label>
            <input type="text" class="form-control" id="grp_info" value="<?php echo $result['grp_info'] ?>" name="grp_info" required="required">
          </div>
          <div class="form-group">
            <label for="grp_image">Image:</label>
            <input type="file" id="grp_image" name="grp_image">
          </div>
          <div class="form-group">
            <label for="grp_members">Members:</label>
            <!-- <input type="text" onkeyup="getSearchGrpUsers(this.value, '<?php echo $userLoggedIn; ?>')" class="form-control" id="select_grp_members" name="select_grp_members">
            <input type="hidden" name="grp_members" id="grp_members" value=""> -->
            <select class="select2" width="100%" multiple="" name="grp_members[]" style="width: 100%">
              <option>Select</option>
              <?php foreach ($usersReturnedQuery as $key => $value) { ?>
                <option value="<?php echo $value['username']; ?>" <?php echo (in_array($value['username'], $grpMembrs)?"selected":"") ?>><?php echo $value['first_name']." ".$value['last_name']; ?></option>
              <?php } ?>
            </select>
          </div>

          <button type="submit" name="edit_group" id="create_group" class="btn btn-default">Submit</button>
        </form>
      </div>


      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

		<script>
   $(function(){
 
       var userLoggedIn = '<?php echo $userLoggedIn; ?>';
       var inProgress = false;
 
       loadPosts(); //Load first posts
 
       $(window).scroll(function() {
           var bottomElement = $(".status_post").last();
           var noMorePosts = $('.posts_area').find('.noMorePosts').val();
 
           // isElementInViewport uses getBoundingClientRect(), which requires the HTML DOM object, not the jQuery object. The jQuery equivalent is using [0] as shown below.
           if (isElementInView(bottomElement[0]) && noMorePosts == 'false') {
               loadPosts();
           }
       });
 
       function loadPosts() {
           if(inProgress) { //If it is already in the process of loading some posts, just return
               return;
           }
          
           inProgress = true;
           $('#loading').show();
 
           var page = $('.posts_area').find('.nextPage').val() || 1; //If .nextPage couldn't be found, it must not be on the page yet (it must be the first time loading posts), so use the value '1'
 			var group_id = $("input[name='group_id']").val();
           $.ajax({
               url: "includes/handlers/ajax_load_grp_posts.php",
               type: "POST",
               data: "page=" + page + "&group_id="+group_id+"&userLoggedIn=" + userLoggedIn,
               cache:false,
 
               success: function(response) {
                   $('.posts_area').find('.nextPage').remove(); //Removes current .nextpage
                   $('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage
                   $('.posts_area').find('.noMorePostsText').remove(); //Removes current .nextpage
 
                   $('#loading').hide();
                   $(".posts_area").append(response);
 
                   inProgress = false;
               }
           });
       }
 
       //Check if the element is in view
       function isElementInView (el) {
             if(el == null) {
                return;
            }
 
           var rect = el.getBoundingClientRect();
 
           return (
               rect.top >= 0 &&
               rect.left >= 0 &&
               rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && //* or $(window).height()
               rect.right <= (window.innerWidth || document.documentElement.clientWidth) //* or $(window).width()
           );
       }
   });


  function getSearchGrpUsers(value, user) {

      $.post("includes/handlers/ajax_search_grp_member.php", {query:value, userLoggedIn: user}, function(data) {

        $('.search_results_grp_members').html(data);

      });
  }

  $('.select2').select2({
    placeholder: "Select Members",
    allowClear: true,
    closeOnSelect: false
  });

  $(".grp_edit").click(function(){
  	$("#editGroup").modal("show");
  });
  
</script>

