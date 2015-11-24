<?php
@session_start();

include("inc.php");

$bSubmitted		= $_GET["bSubmitted"];

if($bSubmitted==1):
	$sMemberFolder	= $_GET["folder"];

	$sql = "ALTER TABLE `tilyan_".$sMemberFolder."_account` ADD `DocCode` VARCHAR(5) NULL AFTER `AccNo`, ADD `DocCode2` VARCHAR(5) NULL AFTER `DocCode`, ADD `DocCode3` VARCHAR(15) NULL AFTER `DocCode2`";
	mysql_query($sql) or die(mysql_error());

	$SQLList	= mysql_query("SELECT TransID, DocID, AccNo, AccName, Description, Amount FROM tilyan_".$sMemberFolder."_account ORDER BY TransID") or die(mysql_error());
	while($oList = mysql_fetch_object($SQLList)) {
//		echo "TransID = ".$oList->TransID."<br />";
//		echo "DocID = ".$oList->DocID."<br /><br />";
		
		$SQLList2	= mysql_query("SELECT DocCode, DocCode2 FROM tilyan_".$sMemberFolder."_document WHERE DocID = ".$oList->DocID."") or die(mysql_error());
		while($oList2 = mysql_fetch_object($SQLList2)) {
//			echo "DocCode = ".$oList2->DocCode."<br />";
//			echo "DocCode2 = ".$oList2->DocCode2."<br /><br />";
			
			//echo "UPDATE tilyan_".$sMemberFolder."_transaction SET DocCode = '".$oList2->DocCode."'";
			$sSQLUpdate = "UPDATE tilyan_".$sMemberFolder."_account SET DocCode = '".$oList2->DocCode."'";
			if($oList2->DocCode2!=""):
				//echo ", DocCode2 = '".$oList->DocCode2."'";
				$sSQLUpdate .= ", DocCode2 = '".$oList2->DocCode2."'";
			endif;
			$sSQLUpdate	.= " WHERE TransID = ".$oList->TransID."";
			
//			echo $sSQLUpdate."<br />";
//			echo "================================<br /><br />";
			mysql_query($sSQLUpdate) or die(mysql_error());
		}
	}

	echo "<meta http-equiv=\"refresh\" content=\"0;URL=move_data.php?folder=".$sMemberFolder."&done=1\">";
	exit();
			
endif;


?>
<html>
<body>
<?php
if($_GET["done"]==1):
	echo "<b>".$_GET["folder"]." - done</b><br />";
endif;
?>
<form name="frmFolder" action="move_data.php" method="get">
	<input type="hidden" name="bSubmitted" id="bSubmitted" value="1" />
	Member's Folder = <input type="text" name="folder" id="folder" value="<?php sMemberFolder; ?>" />&nbsp;&nbsp;<input type="submit" name="bnSubmit" id="bnSubmit" value="Move Data" />
</form>
</body>
</html>
