<?php
include("../../config/config_regteach.php");
include("../classes/User.php");
include("../classes/Notification.php");

$limit = 7; //Number of messages to load

$notification = new Notification($con, $_REQUEST['userLoggedIn']);
echo $notification->getNotifications($_REQUEST, $limit);

?>