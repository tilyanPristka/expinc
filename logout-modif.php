<?php
require("inc.php");

@session_start();

@session_unregister();
@session_unset();
@session_destroy();

echo "<meta http-equiv=\"refresh\" content=\"0; URL=https://tilyanpristka.co.id/login.php?\">";
exit();
?>