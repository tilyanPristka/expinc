<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

$iDocID			= $_GET["id"];
$iRefDocID		= $_GET["ref"];
$dtDocRealDate	= $_GET["rdate"];
$sDocDate		= $_GET["date"];
$sDocFullNo		= $_GET["doc"];
$iTahun			= $_GET["y"];
$iBulan			= $_GET["m"];
$iRecNo			= $_POST["recno"];
//$iRecNo		= 3;
if(empty($iRecNo) || $iRecNo==0):
	$iRecNo	= 1;
endif;
$iChoice	= $_POST["choice"];
$sMessage	= "";

if(!empty($iRefDocID)):
	$sSQLGetDocFullNo	= mysql_query("SELECT DocFullNo FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document WHERE DocID = '".$iRefDocID."'") or die(mysql_errno()." : ".mysql_error());
	if($oGetDocFullNo = mysql_fetch_object($sSQLGetDocFullNo)):
		$sRefDocFullNo		= $oGetDocFullNo->DocFullNo;
	endif;
endif;

if ($_POST['bSubmitted']):

	for ($iLoopRec = 1; $iLoopRec <= $iRecNo; $iLoopRec++) {
		$sAccNo[$iLoopRec]		= TrimString($_POST['sAccNo'.$iLoopRec.'']);
		$sAccName[$iLoopRec]	= TrimString($_POST['sAccName'.$iLoopRec.'']);
		$sDesc[$iLoopRec]		= TrimString($_POST['sDesc'.$iLoopRec.'']);
		$iAmount[$iLoopRec]		= TrimString($_POST['iAmount'.$iLoopRec.'']);

		/*echo "AccNo[".$iLoopRec."] = ".$sAccNo[$iLoopRec]."<br />";
		echo "AccName[".$iLoopRec."] = ".$sAccName[$iLoopRec]."<br />";
		echo "Desc[".$iLoopRec."] = ".$sDesc[$iLoopRec]."<br />";
		echo "Amount[".$iLoopRec."] = ".$iAmount[$iLoopRec]."<br /><br /><br />";*/

	}
	
	if($iChoice=="1"):
		$iRecNo = $iRecNo+1;
	elseif($iChoice=="2"):
		for ($iLoopRec = 1; $iLoopRec <= $iRecNo; $iLoopRec++) {
			/*echo "AccNo[".$iLoopRec."] = ".$sAccNo[$iLoopRec]."<br />";
			echo "AccName[".$iLoopRec."] = ".$sAccName[$iLoopRec]."<br />";
			echo "Desc[".$iLoopRec."] = ".$sDesc[$iLoopRec]."<br />";
			echo "Amount[".$iLoopRec."] = ".$iAmount[$iLoopRec]."<br /><br /><br />";*/
			
			if(!empty($sDesc[$iLoopRec])):
				/* INSERT */
				mysql_query("INSERT INTO tilyan_".$_SESSION['TLY__MemberFolder']."_account (DocID,AccNo,AccName,Description,Amount) VALUES (".$iDocID.", '".$sAccNo[$iLoopRec]."', '".$sAccName[$iLoopRec]."', '".$sDesc[$iLoopRec]."', ".$iAmount[$iLoopRec].")") or die(mysql_errno()." : ".mysql_error());
				//echo "INSERT INTO tilyan_".$_SESSION['TLY__MemberFolder']."_transaction (DocID,AccNo,AccName,Description,Amount) VALUES (".$iDocID.",'".$sAccNo[$iLoopRec]."','".$sAccName[$iLoopRec]."','".$sDesc[$iLoopRec]."',".$iAmount[$iLoopRec].")<br /><br />";
			endif;
	
		}
		
		/* get additional data for DocFullNo */
		$TodayDate = getdate();
		$sHour		= $TodayDate[hours]-1;
		if($sHour==-1):
			$sHour = 23;
		endif;
		$sMinute	= $TodayDate[minutes];

		//create Hour as formated
		$iJmlHour	= strlen($sHour);
		if($iJmlHour==1):
			$sFormatedHour		= "0".$sHour."";
		elseif($iJmlHour==2):
			$sFormatedHour		= $sHour;
		endif;
		
		//create Minute as formated
		$iJmlMinute	= strlen($sMinute);
		if($iJmlMinute==1):
			$sFormatedMinute	= "0".$sMinute."";
		elseif($iJmlMinute==2):
			$sFormatedMinute	= $sMinute;
		endif;
		$sTime		= $sFormatedHour.$sFormatedMinute;
		
		
		//check current doc no
		$sSQLCheck		= mysql_query("SELECT DocNo FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document WHERE DocMonth = ".$iBulan." AND DocYear = ".$iTahun." ORDER BY DocNo DESC LIMIT 0,1") or die(mysql_errno()." : ".mysql_error());;
	
		if($oCheck 	= mysql_fetch_object($sSQLCheck)):
			$iDocNo		= $oCheck->DocNo;
			
			$iNewDocNo	= $iDocNo+1;
		else:
			$iNewDocNo	= 1;	
		endif;
		
		//create DocNo as formated
		$iJmlDocNo	= strlen($iNewDocNo);
		if($iJmlDocNo==1):
			$iFormatedDocNo		= "000".$iNewDocNo."";
		elseif($iJmlDocNo==2):
			$iFormatedDocNo		= "00".$iNewDocNo."";
		elseif($iJmlDocNo==3):
			$iFormatedDocNo		= "0".$iNewDocNo."";
		elseif($iJmlDocNo==4):
			$iFormatedDocNo		= $iNewDocNo;
		endif;
		
		$sNewDocFullNo	= $sDocFullNo.".".$sTime.".".$iFormatedDocNo;
	
		/* UPDATE DocFullNo */
		mysql_query("UPDATE tilyan_".$_SESSION['TLY__MemberFolder']."_document SET DocTime = '".$sTime."', DocNo = ".$iNewDocNo.", DocFullNo = '".$sNewDocFullNo."' WHERE DocID = ".$iDocID."") or die(mysql_errno()." : ".mysql_error());		
		//echo "UPDATE tilyan_".$_SESSION['TLY__MemberFolder']."_document SET DocTime = '".$sTime."', DocNo = ".$iNewDocNo.", DocFullNo = '".$sNewDocFullNo."' WHERE DocID = ".$iDocID."";		

		//echo "<meta http-equiv=\"refresh\" content=\"0;URL=transactionprint.php?id=".$iDocID."\">";
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=documentlist.php?\">";
		exit();
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
		function ReStart(sRedir) {
			if (confirm('Are You Sure To Start All Over Again?')) { document.location.href = sRedir}
		}
		function DocDel(sRedir) {
			if (confirm('You Are About To Cancel Entering This Document. Are You Sure?')) { document.location.href = sRedir}
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
        	<h3>Create New Document | <a href="documentlist.php" class="normaltitlelink">Document List</a></h3>
            <p>&nbsp;</p>
            <p><center>
            <form name="ArticleFrm" id="ArticleFrm" action="<?php echo $_SERVER['PHP_SELF']."?ref=".$iRefDocID."&id=".$iDocID."&rdate=".$dtDocRealDate."&date=".$sDocDate."&doc=".$sDocFullNo."&y=".$iTahun."&m=".$iBulan.""?>" method="post" enctype="multipart/form-data">
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
					<td><strong><?php echo $sDocFullNo ?>.<font color="#990000">TIME</font>.<font color="#990000">XXXX</font></strong></td>
					<td colspan="2"> <font color="#990000"><strong> *) TIME and XXXX will be filled automatically when you're done with this document.</strong></font></td>
				</tr>
				<tr>
					<td><strong>Trans/Doc. Date:</strong></td>
					<td><?php echo $sDocDate?></td>
                    <td colspan="2"></td>
				</tr>
				<tr>
					<td><strong>Input Date:</strong></td>
					<td><?php echo $dtDocRealDate?></td>
                    <td colspan="2"></td>
				</tr>
				<tr>
					<td style="border-bottom: solid 1px #990000;" colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td style="background-color:#CCCCCC; height:22px; padding-left:6px;"><strong>Acct #</strong></td>
					<td style="background-color:#CCCCCC; height:22px; padding-left:6px;"><strong>Account Name</strong></td>
					<td style="background-color:#CCCCCC; height:22px; padding-left:6px;"><strong>Description</strong></td>
					<td style="background-color:#CCCCCC; height:22px; padding-left:6px;"><strong>Amount</strong></td>
				</tr>
                <?php
				for ($iRecLoop = 1; $iRecLoop <= $iRecNo; $iRecLoop++) {
				?>
				<tr>
					<td align="center"><input type="text" name="sAccNo<?php echo $iRecLoop?>" id="sAccNo<?php echo $iRecLoop?>" size="10" value="<?php echo $sAccNo[$iRecLoop]?>" />&nbsp;&nbsp;<a href="javascript:ViewLookUp('<?php echo $iRecLoop?>')"><img src="images/icon_lookup.png" border="0" align="absmiddle" /></a></td>
					<td align="center"><input type="text" name="sAccName<?php echo $iRecLoop?>" id="sAccName<?php echo $iRecLoop?>" size="35" value="<?php echo $sAccName[$iRecLoop]?>" /></td>
					<td align="center"><input type="text" name="sDesc<?php echo $iRecLoop?>" id="sDesc<?php echo $iRecLoop?>" autocomplete="off" size="68" value="<?php echo $sDesc[$iRecLoop]?>" onkeyup="ajax_showOptions(this,'getDescByLetters',event)" />&nbsp;&nbsp;<a href="javascript:ViewDescLookUp('<?php echo $iRecLoop?>')"><img src="images/icon_lookup.png" border="0" align="absmiddle" /></a></td>
					<td align="center"><input type="text" name="iAmount<?php echo $iRecLoop?>" id="iAmount<?php echo $iRecLoop?>" size="14" value="<?php echo $iAmount[$iRecLoop]?>" /></td>
				</tr>
                <?php
				}
				?>
				<tr>
					<td colspan="4">&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<td colspan="2"><select name="choice" id="choice"><option value="1">Add New Record</option><option value="2">Done and Save</option></select>&nbsp;&nbsp;<input type="submit" name="bnSubmit" id="bnSubmit" value="Next">&nbsp;&nbsp;<input type="button" name="bnStartOver" id="bnStartOver" value="Start Over" onClick="ReStart('transactionadd.php?id=<?php echo $iDocID?>&rdate=<?php echo $dtDocRealDate?>&date=<?php echo $sDocDate?>&doc=<?php echo $sDocFullNo?>&y=<?php echo $iTahun?>&m=<?php echo $iBulan?>');">&nbsp;&nbsp;<input type="button" name="bnCancel" id="bnCancel" value="Cancel" onClick="DocDel('documentdel.php?id=<?php echo $iDocID?>&doc=<?php echo $iRefDocID?>');"></td>
                    <td></td>
				</tr>
			</table>
			</form>
            </center></p>
            <p></p>
        
        </div>

    </body>
</html>
