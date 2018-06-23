<?php 
include("includes/header.php");
require 'includes/form_handlers/groups.php';

/*if (isset($_SESSION['username'])) {
  $userLoggedIn = $_SESSION['username'];
}*/

$num_friends = (substr_count($user['connection_array'], ",")) - 1;

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
    $post->submitPost($_POST['post_text'], 'none', $imageName);
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
             

             </div>
		</div>

      
       <div class="main_column">
       	
        <form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
       <input type="file" name="fileToUpload" id="fileToUpload" >

        	<textarea name="post_text" id="post_text" placeholder="Got something to share?"></textarea>
        	<input type="submit" name="post" id="post_button" value="Post">
        	<hr>
        	
        </form>

         <div class="posts_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif">
       </div>


<!-- Modal -->
<div class="modal fade" id="createGroup" tabindex="-1" role="dialog" aria-labelledby="postGroupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="postGroupModalLabel">Create New Group</h4>
      </div>

      <div class="modal-body">
        <form class="profile_post" action="includes/form_handlers/groups.php" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label for="grp_name">Group Name</label>
            <input type="text" class="form-control" id="grp_name" name="grp_name" required="required">
          </div>
           <div class="form-group">
            <label for="grp_info">Group Info</label>
            <input type="text" class="form-control" id="grp_info" name="grp_info" required="required">
          </div>
          <div class="form-group">
            <label for="grp_image">Image:</label>
            <input type="file" id="grp_image" name="grp_image" required="required">
          </div>
          <div class="form-group">
            <label for="grp_members">Members:</label>
            <input type="text" onkeyup="getSearchGrpUsers(this.value, '<?php echo $userLoggedIn; ?>')" class="form-control" id="select_grp_members" name="select_grp_members">
            <input type="hidden" name="grp_members" id="grp_members" value="">
          </div>
          <div class="form-group">            
            <label id="selectedMemebrs" style="display: none;"></label>
          </div>

          <div class="search_results_grp_members">
          </div>

          <button type="submit" name="create_group" id="create_group" class="btn btn-default">Submit</button>
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
 
           $.ajax({
               url: "includes/handlers/ajax_load_posts.php",
               type: "POST",
               data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
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

  
 
   </script>
 </div>
</body>
</html>