<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

$iDocID		= $_GET["doc"];

//get data Document (date, docfullno)
$sSQLGetDocInfo		= mysql_query("SELECT DocRealDate, DocDate, DocFullNo, DocYear, DocMonth, RefDocID FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document WHERE DocID = '".$iDocID."' LIMIT 0,1") or die(mysql_errno()." : ".mysql_error());;
if($oGetDocInfo 	= mysql_fetch_object($sSQLGetDocInfo)):
	$dtDocRealDate	= $oGetDocInfo->DocRealDate;
	$sDocDate		= $oGetDocInfo->DocDate;
	$sDocFullNo		= $oGetDocInfo->DocFullNo;
	$iTahun			= $oGetDocInfo->DocYear;
	$iBulan			= $oGetDocInfo->DocMonth;
	$iRefDocID		= $oGetDocInfo->RefDocID;
	
	if(!empty($iRefDocID)):
		$sSQLGetDocFullNo	= mysql_query("SELECT DocFullNo FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document WHERE DocID = '".$iRefDocID."'") or die(mysql_errno()." : ".mysql_error());
		if($oGetDocFullNo = mysql_fetch_object($sSQLGetDocFullNo)):
			$sRefDocFullNo		= $oGetDocFullNo->DocFullNo;
		endif;
	endif;
endif;

//get transaction record count based on the doc id
$sSQLTrans			= mysql_query("SELECT TransID FROM tilyan_".$_SESSION['TLY__MemberFolder']."_account WHERE DocID = '".$iDocID."'") or die(mysql_errno()." : ".mysql_error());;
$iTransRecCount		= mysql_num_rows($sSQLTrans);

/*
echo "iDocID = ".$iDocID."<br />";
echo "iTransID = ".$iTransID."<br />";
echo "sDocDate = ".$sDocDate."<br />";
echo "sDocFullNo = ".$sDocFullNo."<br />";
echo "iTahun = ".$iTahun."<br />";
echo "iBulan = ".$iBulan."<br />";
echo "iTransRecCount = ".$iTransRecCount."<br />";
exit();
*/

$iRecNo		= $_POST["recno"];
//$iRecNo		= 3;
if(empty($iRecNo) || $iRecNo==0):
	$iRecNo	= $iTransRecCount;
endif;
$iChoice	= $_POST["choice"];
$sMessage	= "";

if ($_POST['bSubmitted']):

	for ($iLoopRec = 1; $iLoopRec <= $iRecNo; $iLoopRec++) {
		$iTransID[$iLoopRec]	= TrimString($_POST['iTransID'.$iLoopRec.'']);
		$sAccNo[$iLoopRec]		= TrimString($_POST['sAccNo'.$iLoopRec.'']);
		$sAccName[$iLoopRec]	= TrimString($_POST['sAccName'.$iLoopRec.'']);
		$sDesc[$iLoopRec]		= TrimString($_POST['sDesc'.$iLoopRec.'']);
		$iAmount[$iLoopRec]		= TrimString($_POST['iAmount'.$iLoopRec.'']);

		/*
		echo "TransID[".$iLoopRec."] = ".$iTransID[$iLoopRec]."<br />";
		echo "AccNo[".$iLoopRec."] = ".$sAccNo[$iLoopRec]."<br />";
		echo "AccName[".$iLoopRec."] = ".$sAccName[$iLoopRec]."<br />";
		echo "Desc[".$iLoopRec."] = ".$sDesc[$iLoopRec]."<br />";
		echo "Amount[".$iLoopRec."] = ".$iAmount[$iLoopRec]."<br /><br /><br />";
		*/
	}

	if($iChoice=="1"):
		$iRecNo = $iRecNo+1;
	elseif($iChoice=="2"):
		for ($iLoopRec = 1; $iLoopRec <= $iRecNo; $iLoopRec++) {
			if(!empty($sDesc[$iLoopRec])):
				if(!empty($iTransID[$iLoopRec])):
					/* UPDATE */
					mysql_query("UPDATE tilyan_".$_SESSION['TLY__MemberFolder']."_account SET DocID = ".$iDocID.",AccNo = '".$sAccNo[$iLoopRec]."',AccName = '".$sAccName[$iLoopRec]."',Description = '".$sDesc[$iLoopRec]."',Amount = ".$iAmount[$iLoopRec]." WHERE TransID = ".$iTransID[$iLoopRec]."") or die(mysql_errno()." : ".mysql_error());
					//echo "UPDATE tilyan_".$_SESSION['TLY__MemberFolder']."_account SET DocID = ".$iDocID.",AccNo = '".$sAccNo[$iLoopRec]."',AccName = '".$sAccName[$iLoopRec]."',Description = '".$sDesc[$iLoopRec]."',Amount = ".$iAmount[$iLoopRec]." WHERE TransID = ".$iTransID[$iLoopRec]."<br /><br />";
				else:
					/* INSERT */
					mysql_query("INSERT INTO tilyan_".$_SESSION['TLY__MemberFolder']."_account (DocID,AccNo,AccName,Description,Amount) VALUES (".$iDocID.", '".$sAccNo[$iLoopRec]."', '".$sAccName[$iLoopRec]."', '".$sDesc[$iLoopRec]."', ".$iAmount[$iLoopRec].")") or die(mysql_errno()." : ".mysql_error());
					//echo "INSERT INTO tilyan_".$_SESSION['TLY__MemberFolder']."_transaction (DocID,AccNo,AccName,Description,Amount) VALUES (".$iDocID.",'".$sAccNo[$iLoopRec]."','".$sAccName[$iLoopRec]."','".$sDesc[$iLoopRec]."',".$iAmount[$iLoopRec].")<br /><br />";
				endif;
			endif;
	
		}

		//echo "<meta http-equiv=\"refresh\" content=\"0;URL=transactionprint.php?id=".$iDocID."\">";
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=documentlist.php?\">";
		//exit();
	endif;
else:
	/* get transaction records */
	$SQLList	= mysql_query("SELECT TransID, AccNo, AccName, Description, Amount FROM tilyan_".$_SESSION['TLY__MemberFolder']."_account WHERE DocID = ".$iDocID." ORDER BY TransID") or die(mysql_error());
	$iListCount	= 1;
	while($oList = mysql_fetch_object($SQLList)) {
		$iTransID[$iListCount]	= $oList->TransID;				
		$sAccNo[$iListCount]	= $oList->AccNo;
		$sAccName[$iListCount]	= $oList->AccName;
		$sDesc[$iListCount]		= $oList->Description;
		$iAmount[$iListCount]	= $oList->Amount;
		
		$iListCount = $iListCount+1;
	}
endif;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="Description" content="Tilyan">
        <meta name="Keywords" content="">
        <link rel="shortcut icon" href="images/favicon.ico">
        <title>Tilyan Pristka</title>

        <link rel="stylesheet" href="css/style.css" />
		<script type="text/javascript" src="scripts/global.js"></script>
		<script type="text/javascript">
        <!--	
		function ReStart(sRedir) {
			if (confirm('Are You Sure To Start All Over Again?')) { document.location.href = sRedir}
		}
		function TransDel(sRedir) {
			if (confirm('Are You Sure To Delete This Record?\nYou Will Not Be Able To Undo It.')) { document.location.href = sRedir}
		}
		function ViewLookUp(SortOrder) {
			var f = document.ArticleFrm;
			AccNo = eval('f.sAccNo' + SortOrder + '.value');
			window.open('viewlookup.php?accno=' + AccNo + '&no=' + SortOrder, "view_lookup", "width=600,height=300,top=100,left=100,scrollbars=yes,resizable=yes,status=yes", false);
		}
		function ViewDescLookUp(SortOrder) {
			var f = document.ArticleFrm;
			Descript = eval('f.sDesc' + SortOrder + '.value');
			window.open('viewlookup2.php?desc=' + Descript + '&no=' + SortOrder, "view_lookup2", "width=600,height=300,top=100,left=100,scrollbars=yes,resizable=yes,status=yes", false);
		}
		//-->
        </script>
		<script type="text/javascript" src="scripts/lib/ajax.js"></script>
        <script type="text/javascript" src="scripts/lib/ajax-dynamic-list.js"></script>
	</head>

    <body>
    
        <div class="other" style="margin-bottom:6px;">
        	<h3><a href="documentadd.php" class="normaltitlelink">Create New Document</a> | <a href="documentlist.php" class="normaltitlelink">Document List</a></h3>
            <p>&nbsp;</p>
            <p><center>
            <form name="ArticleFrm" id="ArticleFrm" action="<?php echo $_SERVER['PHP_SELF']."?doc=".$iDocID.""?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
			<input type="hidden" name="recno" id="recno" value="<?php echo $iRecNo?>">
			<table width="95%" cellpadding="2" cellspacing="3" border="0" align="center" class="OSStyle">
				<?php
				if(!empty($iRefDocID)):
				?>
                <tr>
					<td style="font-size:12px; font-weight:bold; height:25px;">Ref. Doc #:</td>
					<td colspan="3" style="font-size:12px; font-weight:bold;"><?php echo $sRefDocFullNo; ?></td>
				</tr>
                <?php
				endif;
				?>
				<tr>
					<td><strong>Doc #:</strong></td>
					<td colspan="4"><strong><?php echo $sDocFullNo ?></strong></td>
				</tr>
				<tr>
					<td><strong>Trans/Doc. Date:</strong></td>
					<td><?php echo ViewDateTimeFormat($sDocDate,6);?></td>
                    <td colspan="3"></td>
				</tr>
				<tr>
					<td><strong>Input Date:</strong></td>
					<td><?php echo ViewDateTimeFormat($dtDocRealDate,6);?></td>
                    <td colspan="3"></td>
				</tr>
				<tr>
					<td style="border-bottom: solid 1px #990000;" colspan="5">&nbsp;</td>
				</tr>
				<tr>
					<td style="background-color:#CCCCCC; height:22px; padding-left:6px;"><strong>Acct #</strong></td>
					<td style="background-color:#CCCCCC; height:22px; padding-left:6px;"><strong>Account Name</strong></td>
					<td style="background-color:#CCCCCC; height:22px; padding-left:6px;"><strong>Description</strong></td>
					<td style="background-color:#CCCCCC; height:22px; padding-left:6px;"><strong>Amount</strong></td>
					<td style="background-color:#CCCCCC; height:22px; padding-left:6px;"></td>
				</tr>
                <?php
				for ($iRecLoop = 1; $iRecLoop <= $iRecNo; $iRecLoop++) {
				?>
				<tr>
					<td align="center"><input type="hidden" name="iTransID<?php echo $iRecLoop?>" id="iTransID<?php echo $iRecLoop?>" value="<?php echo $iTransID[$iRecLoop]?>"><input type="text" name="sAccNo<?php echo $iRecLoop?>" id="sAccNo<?php echo $iRecLoop?>" size="10" value="<?php echo $sAccNo[$iRecLoop]?>" />&nbsp;&nbsp;<a href="javascript:ViewLookUp('<?php echo $iRecLoop?>')"><img src="images/icon_lookup.png" border="0" align="absmiddle" /></a></td>
					<td align="center"><input type="text" name="sAccName<?php echo $iRecLoop?>" id="sAccName<?php echo $iRecLoop?>" size="35" value="<?php echo $sAccName[$iRecLoop]?>" /></td>
					<td align="center"><input type="text" name="sDesc<?php echo $iRecLoop?>" id="sDesc<?php echo $iRecLoop?>" autocomplete="off" size="68" value="<?php echo $sDesc[$iRecLoop]?>" onkeyup="ajax_showOptions(this,'getDescByLetters',event)" />&nbsp;&nbsp;<a href="javascript:ViewDescLookUp('<?php echo $iRecLoop?>')"><img src="images/icon_lookup.png" border="0" align="absmiddle" /></a></td>
					<td align="center"><input type="text" name="iAmount<?php echo $iRecLoop?>" id="iAmount<?php echo $iRecLoop?>" size="14" value="<?php echo $iAmount[$iRecLoop]?>" /></td>
					<td align="center"><?php if(!empty($iTransID[$iRecLoop])): ?><a href="javascript:TransDel('transactiondel.php?doc=<?php echo $iDocID?>&trans=<?php echo $iTransID[$iRecLoop]?>');"><img src="images/icon_delete.png" border="0" height="20" title="delete" /></a><?php endif; ?></td>
				</tr>
                <?php
				}
				?>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2"><select name="choice" id="choice"><option value="1">Add New Record</option><option value="2">Done and Save</option></select>&nbsp;&nbsp;<input type="submit" name="bnSubmit" id="bnSubmit" value="Next">&nbsp;&nbsp;<input type="button" name="bnStartOver" id="bnStartOver" value="Start Over" onClick="ReStart('transactionedit.php?doc=<?php echo $iDocID?>');"><!-- &nbsp;&nbsp;<input type="button" name="bnCancel" id="bnCancel" value="Cancel" onClick="Cancel('documentlist.php');"> //--></td>
                    <td></td>
				</tr>
			</table>
			</form>
            </center></p>
            <p></p>
        
        </div>

    </body>
</html>
