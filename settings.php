<?php 
include("includes/header.php");
include("includes/form_handlers/settings_handler.php");
?>

<div class="main_column column">

	<h4>Account Settings</h4>
	<?php
	echo "<img src='" . $user['profile_pic'] ."' id='small_profile_pic'>";
	?>
	<br>
	<a href="upload.php">Upload new profile picture</a> <br><br><br>
<br>
	Modify the values and click 'Update Details'

	<?php
	$user_data_query = mysqli_query($con, "SELECT first_name, last_name, email, phone_number, institution, date_of_birth FROM reg_teach WHERE username='$userLoggedIn'");
	$row = mysqli_fetch_array($user_data_query);

	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$email = $row['email'];
	$phone = $row['phone_number'];
	$ist = $row['institution'];
	$birth = $row['date_of_birth'];
	?>

	<form action="settings.php" method="POST">
		First Name: <input type="text" name="first_name" value="<?php echo $first_name; ?>" id="settings_input" required min="2" max="25" autocomplete="off"><br>
		Last Name: <input type="text" name="last_name" value="<?php echo $last_name; ?>" id="settings_input" required min="1" max="25" autocomplete="off"><br>
		Email: <input type="email" name="email" value="<?php echo $email; ?>" id="settings_input" required autocomplete="off"><br>
        Phone Number: <input type="text" name="phone" value="<?php echo $phone; ?>" id="settings_input" required maxlength="12" autocomplete="off"><br>
        Date of Birth: <input type="date" name="birth" value="<?php echo $birth; ?>" id="settings_input" required min="1947-08-15" max="2010-01-01"><br>
        Institution: <input type="text" name="ist" value="<?php echo $ist; ?>" id="settings_input" required min="3" max="100" autocomplete="off"><br>

		<?php echo $message; ?>

		<input type="submit" name="update_details" id="save_details" value="Update Details" class="info settings_submit"><br>
	</form>

	<h4>Change Password</h4>
	<form action="settings.php" method="POST">
		Old Password: <input type="password" name="old_password" id="settings_input"><br>
		New Password: <input type="password" name="new_password_1" id="settings_input"><br>
		New Password Again: <input type="password" name="new_password_2" id="settings_input"><br>
		<?php echo $password_message; ?>
		<input type="submit" name="update_password" id="save_details" value="Update Password" class="info settings_submit"><br>
	</form>
	

	<h4>Close Account</h4>
	<form action="settings.php" method="POST">
		<input type="submit" name="close_account" id="close_account" value="Close Account" class="danger settings_submit">
	</form>
 

</div>