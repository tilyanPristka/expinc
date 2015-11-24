<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

$iDocID		= $_GET["doc"];
$iTransID	= $_GET["trans"];

mysql_query("DELETE FROM tilyan_".$_SESSION['TLY__MemberFolder']."_account WHERE TransID = ".$iTransID."") or die(mysql_errno()." : ".mysql_error());

echo "<meta http-equiv=\"refresh\" content=\"0;URL=transactionedit.php?doc=".$iDocID."\">";
exit();
?>
