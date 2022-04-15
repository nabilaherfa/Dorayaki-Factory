<?php
// set the expiration date to one hour ago
setcookie("user", "", time() - 3600);
setcookie("admin", "", time() - 3600);
header("location: login.php");
?>
