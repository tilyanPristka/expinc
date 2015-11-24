<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

$iDocID		= $_GET["doc"];

//get data Document (date, docfullno)
$sSQLGetDocInfo			= mysql_query("SELECT DocRealDate, DocDate, DocFullNo, DocType, DocYear, DocMonth, DocNotes, DocClear, DocClearDate, RefDocID FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document WHERE DocID = '".$iDocID."' LIMIT 0,1") or die(mysql_errno()." : ".mysql_error());;
if($oGetDocInfo 		= mysql_fetch_object($sSQLGetDocInfo)):
	$dtDocRealDate		= $oGetDocInfo->DocRealDate;
	$sDocDate			= $oGetDocInfo->DocDate;
	$sDocFullNo			= $oGetDocInfo->DocFullNo;
	$sDocType			= $oGetDocInfo->DocType;
	$iTahun				= $oGetDocInfo->DocYear;
	$iBulan				= $oGetDocInfo->DocMonth;
	$sDocNotes			= $oGetDocInfo->DocNotes;
	$iDocClear			= $oGetDocInfo->DocClear;
	$dtDocClearDate		= $oGetDocInfo->DocClearDate;
	$iRefDocID			= $oGetDocInfo->RefDocID;
	
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

	$sDocNotes			= TrimString($_POST['DocNotes']);
	$iDocClear			= TrimString($_POST['DocClear']);
	$iDocClearDateSet	= TrimString($_POST['DocClearDateSet']);
	if(empty($iDocClear)):
		$iDocClear	= 0;
	else:
		//for current date
		$TodayDate = getdate();
		$TanggalHariIni		= $TodayDate[mday];
		if(strlen($TanggalHariIni)==1):
			$TanggalHariIni = "0".$TanggalHariIni;
		endif;
		$BulanHariIni		= $TodayDate[mon];
		if(strlen($BulanHariIni)==1):
			$BulanHariIni = "0".$BulanHariIni;
		endif;
		$TahunHariIni		= $TodayDate[year];
		
		$dtDocClearDate	= $TahunHariIni."-".$BulanHariIni."-".$TanggalHariIni;
	endif;
	
	/* UPDATE */
	$sSQLUpdateQuery	= "UPDATE tilyan_".$_SESSION['TLY__MemberFolder']."_document SET DocNotes = '".$sDocNotes."', DocClear = ".$iDocClear."";
	if(!empty($dtDocClearDate) && empty($iDocClearDateSet)):
		$sSQLUpdateQuery	.= ", DocClearDate = '".$dtDocClearDate."'";
	endif;
	$sSQLUpdateQuery	.= " WHERE DocID = ".$iDocID."";
	mysql_query($sSQLUpdateQuery) or die(mysql_errno()." : ".mysql_error());
	//mysql_query("UPDATE tilyan_".$_SESSION['TLY__MemberFolder']."_document SET DocNotes = '".$sDocNotes."', DocClear = ".$iDocClear.", DocClearDate = '".$dtDocClearDate."' WHERE DocID = ".$iDocID."") or die(mysql_errno()." : ".mysql_error());

	//echo "<meta http-equiv=\"refresh\" content=\"0;URL=transactionprint.php?id=".$iDocID."\">";
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=documentlist.php?\">";
	//exit();
else:
	/* get transaction records */
	$SQLList	= mysql_query("SELECT TransID, AccNo, AccName, Description, Amount, DRCR FROM tilyan_".$_SESSION['TLY__MemberFolder']."_account WHERE DocID = ".$iDocID." ORDER BY TransID") or die(mysql_error());
	$iListCount	= 1;
	while($oList = mysql_fetch_object($SQLList)) {
		$iTransID[$iListCount]	= $oList->TransID;				
		$sAccNo[$iListCount]	= $oList->AccNo;
		$sAccName[$iListCount]	= $oList->AccName;
		$sDesc[$iListCount]		= $oList->Description;
		$iAmount[$iListCount]	= $oList->Amount;
		$bDRCR[$iListCount]		= $oList->DRCR;
		
		$iListCount = $iListCount+1;
	}

	/* get transaction total */
	if($sDocType=="O"):
		$iAmountTotal = 0;
	else:
		$SQLTotal	= mysql_query("SELECT SUM(Amount) AS Total FROM tilyan_".$_SESSION['TLY__MemberFolder']."_account WHERE DocID = ".$iDocID." ORDER BY TransID") or die(mysql_error());
		while($oTotal = mysql_fetch_object($SQLTotal)) {
			$iAmountTotal	= $oTotal->Total;
		}
	endif;
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
		function Cancel(sRedir) {
			if (confirm('Cancel and lose all changes?')) { document.location.href = sRedir}
		}
		//-->
        </script>
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
                    <td colspan="4" style="font-size:12px; font-weight:bold;"><strong><?php echo $sRefDocFullNo; ?></strong></td>
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
					<td width="15%" style="background-color:#CCCCCC; height:22px; padding-left:6px;"><strong>Acct #</strong></td>
					<td style="background-color:#CCCCCC; height:22px; padding-left:6px;"><strong>Account Name</strong></td>
					<td style="background-color:#CCCCCC; height:22px; padding-left:6px;"><strong>Description</strong></td>
					<td style="background-color:#CCCCCC; height:22px; padding-left:6px;"><strong>Amount</strong></td>
				</tr>
                <?php
				for ($iRecLoop = 1; $iRecLoop <= $iRecNo; $iRecLoop++) {
				?>
				<tr>
					<td align="center" style="border-bottom: 1px solid #990000; padding:5px;"><?php echo $sAccNo[$iRecLoop]?></td>
					<td align="left" style="border-bottom: 1px solid #990000; padding:5px;"><?php echo $sAccName[$iRecLoop]?></td>
					<td align="left" style="border-bottom: 1px solid #990000; padding:5px;"><?php echo $sDesc[$iRecLoop]?></td>
					<td align="right" style="border-bottom: 1px solid #990000; padding:5px;"><?php echo ConvertMoneyFormatIndo2($iAmount[$iRecLoop])?><?php if($bDRCR[$iRecLoop]!="") { echo " <font style=\"font-weight: bold; color: #990000;\">(".$bDRCR[$iRecLoop].")</font>"; }; ?></td>
				</tr>
                <?php
				}
				?>
				<tr>
					<td colspan="3" align="right" style="padding:5px;"><strong>TOTAL</strong></td>
					<td align="right" style="border-bottom: 1px solid #990000; padding:5px;"><?php echo ConvertMoneyFormatIndo2($iAmountTotal)?></td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td align="right" valign="top" style="padding:5px; font-size:12px;"><strong>Comment:</strong></td>
					<!-- <td colspan="3" align="left" style="padding:5px; font-size:12px;"><?php if($iDocClear==1) { ?><?php echo nl2br($sDocNotes); ?><?php } else { ?><textarea name="DocNotes" id="DocNotes" rows="3" style="width:100%;"><?php echo $sDocNotes ?></textarea><?php } ?></td> //-->
					<td colspan="3" align="left" style="padding:5px; font-size:12px;"><textarea name="DocNotes" id="DocNotes" rows="3" style="width:100%;"><?php echo $sDocNotes ?></textarea></td>
				</tr>
				<tr>
					<td align="right" valign="top" style="padding:5px; font-size:12px;"><strong>Set To Print:</strong></td>
					<td colspan="3" align="left" style="padding:5px; font-size:12px;"><?php if($iDocClear==1) { ?><span style="font-weight:bold; color:#006633;">This Document is Ready To Print.<?php if(!empty($dtDocClearDate)) { echo " Set on <span style=\"color:#990000;\">". ViewDateTimeFormat($dtDocClearDate,6) ."</span>"; }; ?></span><input type="hidden" name="DocClear" id="DocClear" value="1" /><input type="hidden" name="DocClearDateSet" id="DocClearDateSet" value="1" /><?php } else { ?><input type="checkbox" name="DocClear" id="DocClear" value="1" /><?php } ?></td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<!-- <td colspan="2"><?php if($iDocClear==1) { ?><input type="button" name="bnExit" id="bnExit" value="Done" onClick="javascript:document.location.href='documentlist.php';"><?php } else { ?><input type="submit" name="bnSubmit" id="bnSubmit" value="Save">&nbsp;&nbsp;<input type="button" name="bnCancel" id="bnCancel" value="Cancel" onClick="Cancel('documentlist.php');"><?php }?></td> //-->
					<td colspan="2"><input type="submit" name="bnSubmit" id="bnSubmit" value="Save">&nbsp;&nbsp;<input type="button" name="bnCancel" id="bnCancel" value="Cancel" onClick="Cancel('documentlist.php');"></td>
                    <td></td>
				</tr>
			</table>
			</form>
            </center></p>
            <p></p>
        
        </div>

    </body>
</html>
