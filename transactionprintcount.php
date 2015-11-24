<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

$iDocID		= base64_decode($_GET["doc"]);

$sSQLPrintCount	= mysql_query("SELECT DocPrinted FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document WHERE DocID = '".$iDocID."'") or die(mysql_errno()." : ".mysql_error());
if($oPrintCount = mysql_fetch_object($sSQLPrintCount)):
	$iPrinted	= $oPrintCount->DocPrinted;
	if(empty($iPrinted)):
		$iPrintCount = 1;
	else:
		$iPrintCount = $iPrinted+1;
	endif;
	mysql_query("UPDATE tilyan_".$_SESSION['TLY__MemberFolder']."_document SET DocPrinted = ".$iPrintCount." WHERE DocID = '".$iDocID."'") or die(mysql_errno()." : ".mysql_error());
endif;

echo "<meta http-equiv=\"refresh\" content=\"0;URL=transactionprint.php?doc=".base64_encode($iDocID)."\">";
exit();

?>
