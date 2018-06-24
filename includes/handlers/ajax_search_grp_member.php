<?php
include("../../config/config_regteach.php");
include("../../includes/classes/User.php");

$query = $_POST['query'];
$userLoggedIn = $_POST['userLoggedIn'];

$names = explode(" ", $query);

//If query contains an underscore, assume user is searching for usernames
if(strpos($query, '_') !== false) 
	$usersReturnedQuery = mysqli_query($con, "SELECT * FROM reg_teach WHERE username LIKE '$query%' AND user_closed='no' LIMIT 8");
//If there are two words, assume they are first and last names respectively
else if(count($names) == 2)
	$usersReturnedQuery = mysqli_query($con, "SELECT * FROM reg_teach WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%') AND user_closed='no' LIMIT 8");
//If query has one word only, search first names or last names 
else 
	$usersReturnedQuery = mysqli_query($con, "SELECT * FROM reg_teach WHERE (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') AND user_closed='no' LIMIT 8");


if($query != ""){

	while($row = mysqli_fetch_array($usersReturnedQuery)) {
		$user = new User($con, $userLoggedIn);

		if($row['username'] != $userLoggedIn)
			$mutual_friends = $user->getMutualFriends($row['username']) . " friends in common";
		else 
			$mutual_friends = "";

		echo "<div class='resultDisplay'>
				<a href='javascript:void(0)' style='color: #1485BD'>
					<div class='liveSearchProfilePic'>
						<img src='" . $row['profile_pic'] ."'>
					</div>

					<div class='liveSearchText'>
					<input type='checkbox' name='selectGrpMem' class='selectGrpMem' value='" . $row['username'] ."' />
						" . $row['first_name'] . " " . $row['last_name'] . "
						<p>" . $row['username'] ."</p>
						<p id='grey'>" . $mutual_friends ."</p>
					</div>
				</a>
				</div>";

	}

}

?>

<script type="text/javascript">
	$(document).ready(function() {
	var arr = [];
    $('.selectGrpMem').change(function() {
        if($(this).is(":checked")) {
           arr.push($(this).val());
        } else {
        	arr.pop($(this).val());
        }
        $("#grp_members").val(arr);
        var append_html = "You selected : "+arr;
        $("#selectedMemebrs").html(append_html).fadeIn('slow');
    });
  });
</script>