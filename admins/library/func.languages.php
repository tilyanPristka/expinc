<?php
if (!empty($_SESSION['MM__Language'])) {
	include ("lang/lang.".strtolower($_SESSION['MM__Language']).".php");
} else {
	/* Default Language */
	include ("lang/lang.id.php");
}
?>