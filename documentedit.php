<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

$iDocID		= $_GET["doc"];

$sMessage	= "";

if ($_POST['bSubmitted']):
	//needed variable
	$sType		= TrimString($_POST['sType']);
	$sInOut		= TrimString($_POST['sInOut']);
	$sNickName	= TrimString($_POST['sNickName']);
	$iYear		= TrimString($_POST['iYear']);
	$iMonth		= TrimString($_POST['iMonth']);
	$sTime		= TrimString($_POST['sTime']);
	$sNo		= TrimString($_POST['sNo']);
	
	//change variable
	$sCode		= TrimString($_POST['sCode']);
	if(empty($sCode)):
		$sCode	= "tP";
	endif;
	$sFolder	= $_SESSION['TLY__MemberFolder'];
	//$sNickName	= $_SESSION['TLY__MemberNickName'];
	
	$sNewDocFullNo	= strtoupper($sFolder).".".$sType.".".$sInOut.".".strtoupper($sNickName).".".$sCode.".".$iYear.".".$iMonth.".".$sTime.".".$sNo;
	mysql_query("UPDATE tilyan_".$sFolder."_document SET DocFullNo = '".$sNewDocFullNo."',DocCode = '".$sCode."' WHERE DocID = ".$iDocID."") or die(mysql_errno()." : ".mysql_error());
	
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=documentlist.php?\">";
	exit();
else:
	$sSQLGetNeededVar	= mysql_query("SELECT DocFullNo, DocFolder, DocType, DocInOut, DocNickName, DocCode, DocYear, DocMonth, DocTime, DocNo FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document WHERE DocID = '".$iDocID."'") or die(mysql_errno()." : ".mysql_error());
	//echo "SELECT DocFullNo, DocFolder, DocType, DocInOut, DocNickName, DocYear, DocMonth, DocTime, DocNo FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document WHERE DocID = ".$iDocID."";
	if($oGetNeededVar = mysql_fetch_object($sSQLGetNeededVar)):
		$sDocFullNoOld		= $oGetNeededVar->DocFullNo;
		$sType				= $oGetNeededVar->DocType;
		$sInOut				= $oGetNeededVar->DocInOut;
		$sNickName			= $oGetNeededVar->DocNickName;
		$sCode				= $oGetNeededVar->DocCode;
		$iYear				= $oGetNeededVar->DocYear;
		$iMonth				= $oGetNeededVar->DocMonth;
		$sTime				= $oGetNeededVar->DocTime;
		$sNo				= $oGetNeededVar->DocNo;
		
		//create Month as formated
		$iJmlMonth	= strlen($iMonth);
		if($iJmlMonth==1):
			$iMonth		= "0".$iMonth."";
		elseif($iJmlMonth==2):
			$iMonth		= $iMonth;
		endif;

		//create DocNo as formated
		$iJmlDocNo	= strlen($sNo);
		if($iJmlDocNo==1):
			$sNo		= "000".$sNo."";
		elseif($iJmlDocNo==2):
			$sNo		= "00".$sNo."";
		elseif($iJmlDocNo==3):
			$sNo		= "0".$sNo."";
		elseif($iJmlDocNo==4):
			$sNo		= $sNo;
		endif;
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
	</head>

    <body>
    
        <div class="other" style="margin-bottom:6px;">
        	<h3><a href="documentadd.php" class="normaltitlelink">Create New Document</a> | <a href="documentlist.php" class="normaltitlelink">Document List</a></h3>
            <p>&nbsp;</p>
            <p><center>
            <form name="ArticleFrm" id="ArticleFrm" action="<?php echo $_SERVER['PHP_SELF']."?doc=".$iDocID.""?>" method="post">
			<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
			<input type="hidden" name="sType" id="sType" value="<?php echo $sType?>">
			<input type="hidden" name="sInOut" id="sInOut" value="<?php echo $sInOut?>">
			<input type="hidden" name="sNickName" id="sNickName" value="<?php echo $sNickName?>">
			<input type="hidden" name="iYear" id="iYear" value="<?php echo $iYear?>">
			<input type="hidden" name="iMonth" id="iMonth" value="<?php echo $iMonth?>">
			<input type="hidden" name="sTime" id="sTime" value="<?php echo $sTime?>">
			<input type="hidden" name="sNo" id="sNo" value="<?php echo $sNo?>">
			<table width="95%" cellpadding="2" cellspacing="3" border="0" align="center" class="OSStyle">
				<tr>
					<td colspan="2" class="FormTD">Use the field below to change Document #'s Code (<?php echo $sDocFullNoOld?>)</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sCode"><strong>Document #:</strong></label></td>
					<td><?php echo strtoupper($_SESSION['TLY__MemberFolder'])?>.<?php echo $sType?>.<?php echo $sInOut?>.<?php echo strtoupper($sNickName)?>.<input type="text" name="sCode" id="sCode" size="4" value="<?php echo $sCode?>" />.<?php echo $iYear?>.<?php echo $iMonth?>.<?php echo $sTime?>.<?php echo $sNo?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#990000"><strong> *) Leave blank to get the default value (tP).</strong></font></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="bnSubmit" id="bnSubmit" value="Change Document #">&nbsp;&nbsp;<input type="reset" name="bnReset" id="bnReset" value="Reset" />&nbsp;&nbsp;<input type="button" name="bnCancel" id="bnCancel" value="Cancel" onclick="Cancel('documentlist.php');"></td>
				</tr>
			</table>
			</form>
            </center></p>
            <p></p>
        
        </div>

    </body>
</html>
