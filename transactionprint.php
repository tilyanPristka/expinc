<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

$iDocID		= base64_decode($_GET["doc"]);

//get data Document (date, docfullno)
$sSQLGetDocInfo		= mysql_query("SELECT DocRealDate, DocDate, DocFullNo, DocType, DocYear, DocMonth, DocInOut, RefDocID, DocClearDate FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document WHERE DocID = '".$iDocID."' LIMIT 0,1") or die(mysql_errno()." : ".mysql_error());;
if($oGetDocInfo 	= mysql_fetch_object($sSQLGetDocInfo)):
	$dtDocRealDate	= $oGetDocInfo->DocRealDate;
	$sDocDate		= $oGetDocInfo->DocDate;
	$sDocFullNo		= $oGetDocInfo->DocFullNo;
	$sDocType		= $oGetDocInfo->DocType;
	$iTahun			= $oGetDocInfo->DocYear;
	$iBulan			= $oGetDocInfo->DocMonth;
	$sDocInOut		= $oGetDocInfo->DocInOut;
	$dtDocClearDate	= $oGetDocInfo->DocClearDate;
	if($sDocInOut=="I"):
		$sInOutText	= "RECEIPT VOUCHER";
	elseif($sDocInOut=="O"):
		$sInOutText	= "PAYMENT VOUCHER";
	endif;
	$iRefDocID	= $oGetDocInfo->RefDocID;

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

$iRecNo		= $_POST["recno"];
//$iRecNo		= 3;
if(empty($iRecNo) || $iRecNo==0):
	$iRecNo	= $iTransRecCount;
endif;
$iChoice	= $_POST["choice"];
$sMessage	= "";


/* get transaction records */
$SQLList	= mysql_query("SELECT TransID, AccNo, AccName, Description, Amount, DRCR FROM tilyan_".$_SESSION['TLY__MemberFolder']."_account WHERE DocID = ".$iDocID." ORDER BY TransID") or die(mysql_error());
$iListCount		= 1;
while($oList = mysql_fetch_object($SQLList)) {
	$iTransID[$iListCount]	= $oList->TransID;				
	$sAccNo[$iListCount]	= $oList->AccNo;
	$sAccName[$iListCount]	= $oList->AccName;
	$sDesc[$iListCount]		= $oList->Description;
	$iAmount[$iListCount]	= $oList->Amount;
	$bDRCR[$iListCount]		= $oList->DRCR;
	
	$iListCount 	= $iListCount+1;
}

/* get transaction total */
if($sDocType=="O"):
	$iAmountTotal	= 0;
else:
	$SQLTotal	= mysql_query("SELECT SUM(Amount) AS Total FROM tilyan_".$_SESSION['TLY__MemberFolder']."_account WHERE DocID = ".$iDocID." ORDER BY TransID") or die(mysql_error());
	while($oTotal = mysql_fetch_object($SQLTotal)) {
		$iAmountTotal	= $oTotal->Total;
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
        <title>tilyanPristka</title>

        <link rel="stylesheet" href="css/style.css" />
		<script type="text/javascript" src="scripts/global.js"></script>
		<script type="text/javascript">
        <!--	
		function ReStart(sRedir) {
			if (confirm('Are You Sure To Start All Over Again?')) { document.location.href = sRedir}
		}
        //-->
        </script>
	</head>

    <body>
        <div class="other" style="margin-bottom:6px;">
            <p>&nbsp;</p>
            <p><center>
            <form name="ArticleFrm" id="ArticleFrm" action="<?php echo $_SERVER['PHP_SELF']."?doc=".$iDocID."&trans=".$iTID.""?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
			<input type="hidden" name="recno" id="recno" value="<?php echo $iRecNo?>">
            <table width="95%" cellpadding="2" cellspacing="3" border="0">
                <tr>
                    <td align="left"><?php if ($_SESSION["TLY__Logo"]!="") { ?><img src="uploads/logo/<?php echo $_SESSION['TLY__Logo']?>" width="192" style="float: left; padding-right: 13px;" /><?php } ?></td>
                    <td valign="top" align="right"><img src="images/main_logo_small.png" /></td>
                </tr>
                <tr>
                    <td align="left" colspan="2"><div style="font-size:18px; font-weight:bold;"><?php echo $sInOutText?></div></td>
                </tr>
                <tr>
                    <td align="left" colspan="2"><div style="line-height:1.5; font-size:11px;">Jika terdapat tanda tangan pada baris <span style="text-decoration:underline;">di bawah "RECEIVED BY"</span>, dapat digunakan sebagai <br />bukti penyerahan uang, sejumlah dengan yang tertera pada baris <span style="text-decoration:underline;">diatas "RECEIVED BY"</span></div></td>
                </tr>
            </table>
			<table width="95%" cellpadding="2" cellspacing="3" border="0" align="center" class="OSStyle">
				<tr>
					<td><strong>Doc #:</strong></td>
					<td colspan="3"><div style="font-size:14px; font-weight:bold;"><?php echo $sDocFullNo ?></div></td>
				</tr>
				<?php if(!empty($sRefDocFullNo)){ ?>
                <tr>
					<td><strong>Ref. Doc #:</strong></td>
					<td colspan="3"><div style="font-size:14px; font-weight:bold;"><?php echo $sRefDocFullNo ?></div></td>
				</tr>
				<?php } ?>
                <tr>
					<td><strong>Trans/Doc. Date:</strong></td>
					<td><div style="font-size:14px; font-weight:bold;"><?php echo ViewDateTimeFormat($sDocDate,6);?></div></td>
                    <td colspan="2"></td>
				</tr>
				<tr>
					<td style="border-bottom: solid 1px #990000;" colspan="4">&nbsp;</td>
				</tr>
				<tr style="border-bottom: solid 1px #990000;">
					<td width="10%" style="height:22px; padding-left:6px; font-size:larger;"><strong>Acct #</strong></td>
					<td width="25%" style="height:22px; padding-left:6px; font-size:larger;"><strong>Account Name</strong></td>
					<td width="50%" style="height:22px; padding-left:6px; font-size:larger;"><strong>Description</strong></td>
					<td width="15%" style="height:22px; padding-left:6px; font-size:larger;"><strong>Amount</strong></td>
				</tr>
				<tr>
					<td style="border-top: solid 1px #990000; height:2px;" colspan="4"></td>
				</tr>
                <?php
				for ($iRecLoop = 1; $iRecLoop <= $iRecNo; $iRecLoop++) {
				?>
				<tr valign="top">
					<td align="right" style="border-bottom: solid 1px #990000; height:22px; padding-right:6px;"><?php echo $sAccNo[$iRecLoop]?></td>
					<td align="left" style="border-bottom: solid 1px #990000; height:22px; padding-left:6px;"><?php echo $sAccName[$iRecLoop]?></td>
					<td align="left" style="border-bottom: solid 1px #990000; height:22px; padding-left:6px;"><?php echo $sDesc[$iRecLoop]?></td>
					<td align="right" style="border-bottom: solid 1px #990000; height:22px; padding-right:6px;"><?php echo ConvertMoneyFormatIndo2($iAmount[$iRecLoop])?><?php if($bDRCR[$iRecLoop]!="") { echo " <font style=\"font-weight: bold; color: #990000;\">(".$bDRCR[$iRecLoop].")</font>"; }; ?></td>
				</tr>
                <?php
				}
				?>
				<tr>
					<td colspan="3" align="right" style="height:22px; padding-right:6px; font-size:larger; font-weight:bold;">TOTAL</td>
					<td align="right" style="border-bottom: solid 1px #990000; height:22px; padding-right:6px; font-size:larger; font-weight:bold;"><?php echo ConvertMoneyFormatIndo2($iAmountTotal)?></td>
				</tr>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
			</table>
			<table width="95%" cellpadding="0" cellspacing="0" border="0" align="center" class="OSStyle">
				<tr>
					<td align="center" width="20%" style="border: solid 2px #990000; height:22px; padding-left:6px; font-size:larger;"><strong>GIRO / CHEQUE NO.</strong></td>
					<td align="center" width="20%" style="border: solid 2px #990000; border-left:none; height:22px; padding-left:6px; font-size:larger;"><strong>PREPARED BY</strong></td>
					<td align="center" width="20%" style="border: solid 2px #990000; border-left:none; height:22px; padding-left:6px; font-size:larger;"><strong>POSTED BY</strong></td>
					<td align="center" width="20%" style="border: solid 2px #990000; border-left:none; height:22px; padding-left:6px; font-size:larger;"><strong>REVIEWED BY</strong></td>
					<td align="center" width="20%" style="border: solid 2px #990000; border-left:none; height:22px; padding-left:6px; font-size:larger;"><strong>RECEIVED BY</strong></td>
				</tr>
				<tr>
					<td align="center" width="20%" style="border: solid 2px #990000; border-top:none; height:86px; padding-left:6px; font-size:larger;"></td>
					<td align="center" width="20%" style="border: solid 2px #990000; border-left:none; border-top:none; height:86px; padding-left:6px; font-size:larger;"></td>
					<td align="center" width="20%" style="border: solid 2px #990000; border-left:none; border-top:none; height:86px; padding-left:6px; font-size:small; vertical-align:bottom;"><?php if(!empty($dtDocRealDate)) { echo ViewDateTimeFormat($dtDocRealDate,6); }; ?></td>
					<td align="center" width="20%" style="border: solid 2px #990000; border-left:none; border-top:none; height:86px; padding-left:6px; font-size:small; vertical-align:bottom;"><?php if(!empty($dtDocClearDate)) { echo ViewDateTimeFormat($dtDocClearDate,6); }; ?></td>
					<td align="center" width="20%" style="border: solid 2px #990000; border-left:none; border-top:none; height:86px; padding-left:6px; font-size:larger;"></td>
				</tr>
			</table>
            </form>
            </center></p>
            <p></p>
        
        </div>

    </body>
</html>
