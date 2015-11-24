<?php
/*
Check Authentication
*/
function CheckMemberAuthentication() {
	if (!isset($_SESSION['TLY__MemberID'])) {
		echo '<meta http-equiv="refresh" content="0;URL=login.php?">';
		exit();
	}
}

function CheckMemberFolder($sFolder) {
	if ($_SESSION['TLY__MemberFolder']!=$sFolder) {
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=unauthorized.php?\">";
		exit();
	}
}
?>