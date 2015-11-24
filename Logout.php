<?php
require("inc.php");

@session_start();

@session_unregister();
@session_unset();
@session_destroy();

echo "<meta http-equiv=\"refresh\" content=\"0;URL=login.php?\">";
exit();
?>