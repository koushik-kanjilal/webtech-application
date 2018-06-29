<?php 
require 'config/config_regteach.php';
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");
include("includes/classes/Notification.php");
 
 if (isset($_SESSION['username'])) {
 	$userLoggedIn = $_SESSION['username'];
 	$user_details_query = mysqli_query($con, "SELECT * FROM reg_teach WHERE username='$userLoggedIn'");
 	$user = mysqli_fetch_array($user_details_query);
 }
else{
	header("Location: teacher_corner.php");
}


 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Digital Learner</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- javascript -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
    <script src="assets/js/bootbox.min.js"></script>
    <script src="assets/js/digital_learner.js"></script>
  <script src="assets/js/jquery.jcrop.js"></script>
  <script src="assets/js/jcrop_bits.js"></script>


	<!-- css -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
  <link rel="stylesheet" media="screen and (min-width: 900px)" href="assets/css/style.css">
  <link rel="stylesheet" media="screen and (max-width: 899.9px) and (min-width: 400.1px)" href="assets/css/styleabove400below900.css">
  <link rel="stylesheet" media="screen and (max-width: 400px)" href="assets/css/stylebelow400.css">

    <link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />
</head>
<body>
  <?php $usersReturnedQuery = mysqli_query($con, "SELECT * FROM reg_teach WHERE user_closed='no' AND `username` <> '".$userLoggedIn."'");
$membrs=mysqli_fetch_all($usersReturnedQuery,MYSQLI_ASSOC); ?>

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
            <input type="text" class="form-control " id="grp_name" name="grp_name" required="required">
          </div>
           <div class="form-group">
            <label for="grp_info">Group Info</label>
            <input type="text" class="form-control" id="grp_info" name="grp_info" required="required">
          </div>
          <div class="form-group">
            <label for="grp_image">Image:</label>
            <input type="file" id="grp_image" name="grp_image" required="required">
          </div>
          <!-- <div class="form-group">
            <label for="grp_members">Members:</label>
            <input type="text" onkeyup="getSearchGrpUsers(this.value, '<?php echo $userLoggedIn; ?>')" class="form-control" id="select_grp_members" name="select_grp_members">
            <input type="hidden" name="grp_members" id="grp_members" value="">
          </div>
          <div class="form-group">            
            <label id="selectedMemebrs" style="display: none;"></label>
          </div>

          <div class="search_results_grp_members">
          </div> -->

          <div class="form-group">
            <label for="grp_members">Members:</label>
            <!-- <input type="text" onkeyup="getSearchGrpUsers(this.value, '<?php echo $userLoggedIn; ?>')" class="form-control" id="select_grp_members" name="select_grp_members">
            <input type="hidden" name="grp_members" id="grp_members" value=""> -->
            <select class="select2" width="100%" multiple="" name="grp_members[]" style="width: 100%">
              <option>Select</option>
              <?php foreach ($usersReturnedQuery as $key => $value) { ?>
                <option value="<?php echo $value['username']; ?>"><?php echo $value['first_name']." ".$value['last_name']; ?></option>
              <?php } ?>
            </select>
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
	<div class="top_bar">
		
       <div class="logo">
       	<a href="index.php">Digital Learner</a>
       </div>
       <div class="search">
         
     <form action="search.php" method="GET" name="search_form">
       
      <input type="text" onkeyup="getLiveSearchUsers(this.value, '<?php echo $userLoggedIn; ?>')" name="q" placeholder="Search here...." autocomplete="off" id="search_text_input">

      <div class="button_holder">
        <img src="assets/images/icons/search-icon.png">
      </div>

     </form>

     <div class="search_results">
      </div>
      <div class="search_results_footer_empty">
      </div>

       </div>
      <nav>

        <?php 
        //unread messages
        $messages = new Message($con, $userLoggedIn);
        $num_messages = $messages->getUnreadNumber();
         //unread Notification
        $notifications = new Notification($con, $userLoggedIn);
        $num_notifications = $notifications->getUnreadNumber();
        //unread friendrequest
        $user_obj = new user($con, $userLoggedIn);
        $num_requests = $user_obj->getNumberOfFriendRequests();
         ?>


      		<a href=" <?php echo $userLoggedIn; ?> ">
      		<?php echo $user['first_name']; ?>
      	</a>
      	<a href="index.php">
      		<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
      	</a>
      	<a href="javascript:(0); onclick=getDropdownData('<?php echo $userLoggedIn; ?>', 'message')">
      		<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
          <?php 
          if($num_messages > 0)
          echo '<span class="notification_badge" id="unread_message">' . $num_messages . '</span>';
          ?>
      	</a>
      	<a href="javascript:(0); onclick=getDropdownData('<?php echo $userLoggedIn; ?>', 'notification')">
      		<span class="glyphicon glyphicon-bell" aria-hidden="true"></span>
           <?php 
          if($num_notifications > 0)
          echo '<span class="notification_badge" id="unread_notifications">' . $num_notifications . '</span>';
          ?>
      	</a>
      	<a href="requests.php">
      		<i class="fas fa-users"></i>
           <?php 
          if($num_requests > 0)
          echo '<span class="notification_badge" id="unread_requests">' . $num_requests . '</span>';
          ?>
      	</a>
         <a href="settings.php">
      	<i class="fas fa-cogs"></i>
      	</a>
            <a href="includes/handlers/logout.php">
            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>


            </nav>

      <div class="dropdown_data_window" style="height: 0px;"> </div>
      <input type="hidden" id="dropdown_data_type" value="">

	</div>



   
<script>
    $(function(){
 
        var userLoggedIn = '<?php echo $userLoggedIn; ?>';
        var dropdownInProgress = false;
 
        $(".dropdown_data_window").scroll(function() {
            var bottomElement = $(".dropdown_data_window a").last();
            var noMoreData = $('.dropdown_data_window').find('.noMoreDropdownData').val();
 
            // isElementInViewport uses getBoundingClientRect(), which requires the HTML DOM object, not the jQuery object. The jQuery equivalent is using [0] as shown below.
            if (isElementInView(bottomElement[0]) && noMoreData == 'false') {
                loadPosts();
            }
        });
 
        function loadPosts() {
            if(dropdownInProgress) { //If it is already in the process of loading some posts, just return
                return;
            }
            
            dropdownInProgress = true;
 
            var page = $('.dropdown_data_window').find('.nextPageDropdownData').val() || 1; //If .nextPage couldn't be found, it must not be on the page yet (it must be the first time loading posts), so use the value '1'
 
            var pageName; //Holds name of page to send ajax request to
            var type = $('#dropdown_data_type').val();
 
            if(type == 'notification')
                pageName = "ajax_load_notifications.php";
            else if(type == 'message')
                pageName = "ajax_load_messages.php";
 
            $.ajax({
                url: "includes/handlers/" + pageName,
                type: "POST",
                data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
                cache:false,
 
                success: function(response) {
 
                    $('.dropdown_data_window').find('.nextPageDropdownData').remove(); //Removes current .nextpage 
                    $('.dropdown_data_window').find('.noMoreDropdownData').remove();
 
                    $('.dropdown_data_window').append(response);
 
                    dropdownInProgress = false;
                }
            });
        }
 
        //Check if the element is in view
        function isElementInView (el) {
            var rect = el.getBoundingClientRect();
 
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) && //* or $(window).height()
                rect.right <= (window.innerWidth || document.documentElement.clientWidth) //* or $(window).width()
            );
        }
    });
 
    </script>

	<div class="wrapper">