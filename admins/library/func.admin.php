<?php
/*
Check Authentication
*/
function CheckAuthentication() {
	if (!isset($_SESSION['TLY__AdminID'])) {
		echo '<meta http-equiv="refresh" content="0;URL=Login.php?">';
		exit();
	}
}

function CheckPermission($sPermission) {
	if (!$_SESSION[$sPermission]) {
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=unauthorized.php?\">";
		exit();
	}
}
?>