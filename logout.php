<?php
session_start();
session_destroy();
$_SESSION['loggued_on_user'] = "";
?><script type="text/javascript"> window.location = "./index.php"; </script><?php
?>
