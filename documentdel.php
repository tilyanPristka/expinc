<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

$iDocID		= $_GET["id"];
$iRefDocID	= $_GET["doc"];

if(!empty($iRefDocID)):
	mysql_query("UPDATE tilyan_".$_SESSION['TLY__MemberFolder']."_document SET DocAdjusted = NULL WHERE DocID = ".$iRefDocID."") or die(mysql_errno()." : ".mysql_error());
endif;

mysql_query("DELETE FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document WHERE DocID = ".$iDocID."") or die(mysql_errno()." : ".mysql_error());

echo "<meta http-equiv=\"refresh\" content=\"0;URL=documentlist.php?\">";
exit();
?>
