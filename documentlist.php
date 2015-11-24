<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

$bError		= false;

$TodayDate = getdate();
$sReport	= "report.php?ok=1";
$sExcel		= "excel.php?ok=1";
$sSpreadsheet = "tp_rep_index.php?ok=1";

if ($_GET['bSubmitted']):

	$PilihTanggalb	= $_GET["db"];
	$PilihBulanb	= $_GET["mb"];
	if(strlen($PilihBulanb)==1):
		$PilihBulanb = "0".$PilihBulanb;
	endif;
	$PilihTahunb	= $_GET["yb"];
	if(empty($PilihTanggalb)):
		$bError	= 1;
	elseif(empty($PilihBulanb)):
		$bError	= 1;
	elseif(empty($PilihTahunb)):
		$bError	= 1;
	endif;
	
	$PilihTanggale	= $_GET["de"];
	$PilihBulane	= $_GET["me"];
	if(strlen($PilihBulane)==1):
		$PilihBulane = "0".$PilihBulane;
	endif;
	$PilihTahune	= $_GET["ye"];
	if(empty($PilihTanggale)):
		$bError	= 1;
	elseif(empty($PilihBulane)):
		$bError	= 1;
	elseif(empty($PilihTahune)):
		$bError	= 1;
	endif;
	
	$iBank	= $_GET["iBank"];
	$iCash	= $_GET["iCash"];
	$iOther	= $_GET["iOther"];
	
	$iIn	= $_GET["iIn"];
	$iOut	= $_GET["iOut"];
	 
	$iAdjed	= $_GET["iAdjed"];
	$iAdj	= $_GET["iAdj"];
	 
	$iPrint	= $_GET["iPrint"];

	$sDesc	= $_GET["sDesc"];
	 
	$sCode1	= $_GET["sCode1"];
	$sCode2	= $_GET["sCode2"];
	 
	$sDocNickName	= $_GET["sDocNickName"];

	$sAccType	= $_GET["sAccType"];

	$sAccNo	= $_GET["sAccNo"];
	
	$sPaging	= "SELECT d.DocFullNo, d.DocDate, d.DocClear, d.DocNotes, d.DocAdjusted, d.DocPrinted, d.DocNo, d.DocTime, d.DocMonth, d.DocYear, d.DocCode, d.DocCode2, d.DocCode3, d.DocNickName, d.DocInOut, d.DocType, d.DocADJ, d.DocFolder, a.AccNo, a.AccName, a.Description, a.Amount, la.Type FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID  = a.DocID";
	if($bError!=1):
		$sPaging	= $sPaging." AND d.DocDate <= '".$PilihTahune."-".$PilihBulane."-".$PilihTanggale."' AND d.DocDate >= '".$PilihTahunb."-".$PilihBulanb."-".$PilihTanggalb."'";
	endif;
	
	if(empty($iBank) && empty($iCash) && empty($iOther)):
		$sPaging	= $sPaging." AND d.DocType NOT IN('B','C','O')";
	elseif(!empty($iBank) && !empty($iCash) && !empty($iOther)):
		$sPaging	= $sPaging." AND d.DocType IN('B','C','O')";
	elseif(!empty($iBank) && !empty($iCash)):
		$sPaging	= $sPaging." AND d.DocType IN('B','C')";
	elseif(!empty($iBank) && !empty($iOther)):
		$sPaging	= $sPaging." AND d.DocType IN('B','O')";
	elseif(!empty($iCash) && !empty($iOther)):
		$sPaging	= $sPaging." AND d.DocType IN('C','O')";
	elseif(!empty($iBank)):
		$sPaging	= $sPaging." AND d.DocType IN('B')";
	elseif(!empty($iCash)):
		$sPaging	= $sPaging." AND d.DocType IN('C')";
	elseif(!empty($iOther)):
		$sPaging	= $sPaging." AND d.DocType IN('O')";
	endif;
	
	if(empty($iIn) && empty($iOut)):
		$sPaging	= $sPaging." AND d.DocInOut NOT IN('I','O')";
	elseif(!empty($iIn) && !empty($iOut)):
		$sPaging	= $sPaging." AND d.DocInOut IN('I','O')";
	elseif(!empty($iIn)):
		$sPaging	= $sPaging." AND d.DocInOut IN('I')";
	elseif(!empty($iOut)):
		$sPaging	= $sPaging." AND d.DocInOut IN('O')";
	endif;

	if(!empty($iAdjed) && empty($iAdj)):
		$sPaging	= $sPaging." AND d.DocAdjusted IS NOT NULL";
	elseif(empty($iAdjed) && !empty($iAdj)):
		$sPaging	= $sPaging." AND d.DocADJ IS NOT NULL";
	elseif(!empty($iAdjed) && !empty($iAdj)):
		$sPaging	= $sPaging." AND (d.DocAdjusted IS NOT NULL OR d.DocADJ IS NOT NULL)";
	endif;
	
	if(!empty($iPrint)):
		$sPaging	= $sPaging." AND d.DocClear = 1";
	endif;

	if($sCode1!="pilih"):
		$sPaging	= $sPaging." AND d.DocCode = '".$sCode1."'";
	endif;

	if($sCode2!="pilih"):
		if($sCode2!="NULL"):
			$sPaging	= $sPaging." AND d.DocCode2 = '".$sCode2."'";
		else:
			$sPaging	= $sPaging." AND d.DocCode2 IS NULL";
		endif;
	endif;

	if($sCode3!="pilih"):
		if($sCode3!="NULL"):
			$sPaging	= $sPaging." AND d.DocCode3 = '".$sCode3."'";
		else:
			$sPaging	= $sPaging." AND d.DocCode3 IS NULL";
		endif;
	endif;

	if(!empty($sDesc)):
		$sPaging	= $sPaging." AND a.Description LIKE '%".$sDesc."%'";
	endif;

	if($sDocNickName!="pilih"):
		$sPaging	= $sPaging." AND d.DocNickName = '".$sDocNickName."'";
	endif;

	if($sAccType!="pilih"):
		$sPaging	= $sPaging." AND la.Type = '".$sAccType."'";
	endif;

	if($sAccNo!="pilih"):
		$sPaging	= $sPaging." AND a.AccNo = '".$sAccNo."'";
	endif;

	//echo "sPaging = ".$sPaging."<br />";
	

	$sList		= "SELECT d.DocID, d.DocFullNo, d.DocClear, d.DocNotes, d.DocAdjusted, d.DocDate, d.DocPrinted, d.DocNo, d.DocTime, d.DocMonth, d.DocYear, d.DocCode, d.DocCode2, d.DocCode3, d.DocNickName, d.DocInOut, d.DocType, d.DocADJ, d.DocFolder, a.TransID, a.AccNo, a.AccName, a.Description, a.Amount, la.Type FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID  = a.DocID";
	if($bError!=1):
		$sList	= $sList." AND d.DocDate <= '".$PilihTahune."-".$PilihBulane."-".$PilihTanggale."' AND d.DocDate >= '".$PilihTahunb."-".$PilihBulanb."-".$PilihTanggalb."'";
		$sReport .= "&de=".$PilihTahune."-".$PilihBulane."-".$PilihTanggale."&db=".$PilihTahunb."-".$PilihBulanb."-".$PilihTanggalb."";
		$sExcel .= "&de=".$PilihTahune."-".$PilihBulane."-".$PilihTanggale."&db=".$PilihTahunb."-".$PilihBulanb."-".$PilihTanggalb."";
	endif;
	
	if(empty($iBank) && empty($iCash) && empty($iOther)):
		$sList	= $sList." AND d.DocType NOT IN('B','C','O')";
		$sReport	.= "&b=0&c=0&oth=0";
		$sExcel	.= "&b=0&c=0&oth=0";
	elseif(!empty($iBank) && !empty($iCash) && !empty($iOther)):
		$sList	= $sList." AND d.DocType IN('B','C','O')";
		$sReport	.= "&b=1&c=1&oth=1";
		$sExcel	.= "&b=1&c=1&oth=1";
	elseif(!empty($iBank) && !empty($iCash)):
		$sList	= $sList." AND d.DocType IN('B','C')";
		$sReport	.= "&b=1&c=1&oth=0";
		$sExcel	.= "&b=1&c=1&oth=0";
	elseif(!empty($iBank) && !empty($iOther)):
		$sList	= $sList." AND d.DocType IN('B','O')";
		$sReport	.= "&b=1&c=0&oth=1";
		$sExcel	.= "&b=1&c=0&oth=1";
	elseif(!empty($iCash) && !empty($iOther)):
		$sList	= $sList." AND d.DocType IN('C','O')";
		$sReport	.= "&b=0&c=1&oth=1";
		$sExcel	.= "&b=0&c=1&oth=1";
	elseif(!empty($iBank)):
		$sList	= $sList." AND d.DocType IN('B')";
		$sReport	.= "&b=1&c=0&oth=0";
		$sExcel	.= "&b=1&c=0&oth=0";
	elseif(!empty($iCash)):
		$sList	= $sList." AND d.DocType IN('C')";
		$sReport	.= "&b=0&c=1&oth=0";
		$sExcel	.= "&b=0&c=1&oth=0";
	elseif(!empty($iOther)):
		$sList	= $sList." AND d.DocType IN('O')";
		$sReport	.= "&b=0&c=0&oth=1";
		$sExcel	.= "&b=0&c=0&oth=1";
	endif;
	
	if(empty($iIn) && empty($iOut)):
		$sList	= $sList." AND d.DocInOut NOT IN('I','O')";
		$sReport	.= "&in=0&out=0";
		$sExcel	.= "&in=0&out=0";
	elseif(!empty($iIn) && !empty($iOut)):
		$sList	= $sList." AND d.DocInOut IN('I','O')";
		$sReport	.= "&in=1&out=1";
		$sExcel	.= "&in=1&out=1";
	elseif(!empty($iIn)):
		$sList	= $sList." AND d.DocInOut IN('I')";
		$sReport	.= "&in=1&out=0";
		$sExcel	.= "&in=1&out=0";
	elseif(!empty($iOut)):
		$sList	= $sList." AND d.DocInOut IN('O')";
		$sReport	.= "&in=0&out=1";
		$sExcel	.= "&in=0&out=1";
	endif;
	
	if(!empty($iAdjed) && empty($iAdj)):
		$sList	= $sList." AND d.DocAdjusted IS NOT NULL";
		$sReport	.= "&adjed=1&adj=0";
		$sExcel	.= "&adjed=1&adj=0";
	elseif(empty($iAdjed) && !empty($iAdj)):
		$sList	= $sList." AND d.DocADJ IS NOT NULL";
		$sReport	.= "&adjed=0&adj=1";
		$sExcel	.= "&adjed=0&adj=1";
	elseif(!empty($iAdjed) && !empty($iAdj)):
		$sList	= $sList." AND (d.DocAdjusted IS NOT NULL OR d.DocADJ IS NOT NULL)";
		$sReport	.= "&adjed=1&adj=1";
		$sExcel	.= "&adjed=1&adj=1";
	endif;

	if(!empty($iPrint)):
		$sList	= $sList." AND d.DocClear = 1";
		$sReport	.= "&print=1";
		$sExcel	.= "&print=1";
	endif;

	if(!empty($sDesc)):
		$sList	= $sList." AND a.Description LIKE '%".$sDesc."%'";
		$sReport	.= "&desc=".$sDesc."";
		$sExcel	.= "&desc=".$sDesc."";
	endif;

	if($sCode1!="pilih"):
		$sList	= $sList." AND d.DocCode = '".$sCode1."'";
		$sReport	.= "&code1=".$sCode1."";
		$sExcel	.= "&code1=".$sCode1."";
	endif;

	if($sCode2!="pilih"):
		if($sCode2!="NULL"):
			$sList	= $sList." AND d.DocCode2 = '".$sCode2."'";
			$sReport	.= "&code2=".$sCode2."";
			$sExcel	.= "&code2=".$sCode2."";
		else:
			$sList	= $sList." AND d.DocCode2 IS NULL";
			$sReport	.= "&code2=kosong";
			$sExcel	.= "&code2=kosong";
		endif;
	endif;

	if($sCode3!="pilih"):
		if($sCode3!="NULL"):
			$sList	= $sList." AND d.DocCode3 = '".$sCode3."'";
			$sReport	.= "&code3=".$sCode3."";
			$sExcel	.= "&code3=".$sCode3."";
		else:
			$sList	= $sList." AND d.DocCode3 IS NULL";
			$sReport	.= "&code3=kosong";
			$sExcel	.= "&code3=kosong";
		endif;
	endif;

	if($sDocNickName!="pilih"):
		$sList	= $sList." AND d.DocNickName = '".$sDocNickName."'";
		$sReport	.= "&nick=".$sDocNickName."";
		$sExcel	.= "&nick=".$sDocNickName."";
	endif;

	if($sAccType!="pilih"):
		$sList	= $sList." AND la.Type = '".$sAccType."'";
	endif;

	if($sAccNo!="pilih"):
		$sList	= $sList." AND a.AccNo = '".$sAccNo."'";
		$sReport	.= "&accno=".$sAccNo."";
		$sExcel	.= "&accno=".$sAccNo."";
	endif;

	//echo "sList = ".$sList."<br />";

else:

	$PilihBulan	= 0;
	$PilihTahun	= 0;
	
	$iBank	= 1;
	$iCash	= 1;
	$iOther	= 1;
	
	$iIn	= 1;
	$iOut	= 1;
	
	$iAdjed	= 0;
	$iAdj	= 0;
	
	$iPrint	= 0;
	 
	$sPaging	= "SELECT d.DocFullNo, d.DocDate, d.DocClear, d.DocNotes, d.DocAdjusted, d.DocPrinted, d.DocNo, d.DocTime, d.DocMonth, d.DocYear, d.DocCode, d.DocCode2, d.DocCode3, d.DocNickName, d.DocInOut, d.DocType, d.DocADJ, d.DocFolder, a.AccNo, a.AccName, a.Description, a.Amount, la.Type FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID  = a.DocID";

	$sList		= "SELECT d.DocID, d.DocFullNo, d.DocDate, d.DocClear, d.DocNotes, d.DocAdjusted, d.DocPrinted, d.DocNo, d.DocTime, d.DocMonth, d.DocYear, d.DocCode, d.DocCode2, d.DocCode3, d.DocNickName, d.DocInOut, d.DocType, d.DocADJ, d.DocFolder, a.TransID, a.AccNo, a.AccName, a.Description, a.Amount, la.Type FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID  = a.DocID";

	$sReport	.= "&b=1&c=1&oth=1";
	$sReport	.= "&in=1&out=1";
	$sExcel		.= "&b=1&c=1&oth=1";
	$sExcel		.= "&in=1&out=1";

endif;
$sMessage	= "";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="Description" content="Tilyan">
        <meta name="Keywords" content="">
        <link rel="shortcut icon" href="images/favicon.ico">
        <title>tilyanPristka</title>
		<script type="text/javascript" src="scripts/lib/jquery.min.js"></script>
		<script type="text/javascript" src="scripts/lib/jquery.colorbox.js"></script>
		<script>
			$(document).ready(function(){
				//Examples of how to assign the ColorBox event to elements
				$(".example8").colorbox({width:"750px", inline:true, href:"#inline_example1"});
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>
		<script type="text/javascript" src="scripts/tooltips.js"></script>
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/tooltips.css" />
		<link media="screen" rel="stylesheet" href="css/colorbox.css" />
	</head>

    <body>
    
        <div class="other" style="margin-bottom:6px;">
        	<h3><a href="documentadd.php" class="normaltitlelink">Create New Document</a> | Document List</h3>
            <div style="float:left; margin-bottom:6px; width:85%; font-size:12px;">
            <form name="FilterFrm" id="FilterFrm" action="<?php echo $_SERVER['PHP_SELF']."?"?>" method="get">
			<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
			<table width="100%" cellpadding="2" cellspacing="3" border="0" align="center" class="OSStyle">
				<tr>
					<td style="border-bottom: solid 1px #990000;">&nbsp;</td>
				</tr>
				<tr>
					<td style="background-color:#CCCCCC; height:22px; padding-left:6px;"><strong>&nbsp;</strong></td>
				</tr>
				<tr align="right">
					<td style="height:22px; padding-right:14px;" nowrap="nowrap">
					<input type="button" name="bnReport" id="bnReport" value="Download Report from Current List" onclick="javascript:window.open('<?php echo $sExcel?>');" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="bnReport" id="bnReport" value="Generate Report from Current List" onclick="javascript:window.open('<?php echo $sReport?>');" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="bnFilter" id="bnFilter" class="example8" value="Filter Option" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="bnClear" id="bnClear" value="Clear Filter" onClick="javascript:document.location.href = '<?php echo $_SERVER['PHP_SELF']."?"?>';"></td>
				</tr>
			</table>
			</form>
            </div>
            <div style="float:right; margin-bottom:6px; width:15%; font-size:12px;">
			<?php
			/* Paginate */
			$Pg			= $_GET["pg"];
			$Limit		= 20;
	
			if(empty($Pg)) {
				$Pg = 0;
			}
	
			//$sPaging		 = "SELECT d.DocFullNo, d.DocDate, a.AccNo, a.AccName, a.Description, a.Amount FROM tilyan_micom_document d, tilyan_micom_account a WHERE d.DocID  = a.DocID";
			$sPaging	.= " ORDER BY d.DocYear DESC, d.DocMonth DESC, d.DocNo DESC, a.TransID DESC";
			$SQLPaging		 = mysql_query($sPaging) or die(mysql_errno()." : ".mysql_error());
			$TotalRecord	 = mysql_num_rows($SQLPaging);
			?>
			<?php
			$Hal = intval($TotalRecord/$Limit);
			if($TotalRecord%$Limit) {
				$Hal++;
			}
	
			//echo "Total : <strong>".$TotalRecord."</strong> record(s) :: ";
			echo "<table width=\"100%\" border=\"0\">";
			echo "<tr><td style=\"border-bottom: solid 1px #990000;\">&nbsp;</td></tr>";
			echo "<tr><td style=\"background-color:#CCCCCC; height:22px; padding-left:6px;\">&nbsp;</td></tr>";
			echo "<tr>";
			echo "<td align=\"right\" style=\"padding-right:14px;\">";
//			echo "Page : ";
			echo "<form name=\"frmPaging\" id=\"frmPaging\" method=\"get\" action=\"documentlist.php\">";
			if($_GET["bSubmitted"]):
			echo "<input type=\"hidden\" name=\"bSubmitted\" id=\"bSubmitted\" value=\"1\">";
			echo "<input type=\"hidden\" name=\"db\" id=\"db\" value=\"".$PilihTanggalb."\">";
			echo "<input type=\"hidden\" name=\"mb\" id=\"mb\" value=\"".$PilihBulanb."\">";
			echo "<input type=\"hidden\" name=\"yb\" id=\"yb\" value=\"".$PilihTahunb."\">";
			echo "<input type=\"hidden\" name=\"de\" id=\"de\" value=\"".$PilihTanggale."\">";
			echo "<input type=\"hidden\" name=\"me\" id=\"me\" value=\"".$PilihBulane."\">";
			echo "<input type=\"hidden\" name=\"ye\" id=\"ye\" value=\"".$PilihTahune."\">";
			echo "<input type=\"hidden\" name=\"iBank\" id=\"iBank\" value=\"".$iBank."\">";
			echo "<input type=\"hidden\" name=\"iCash\" id=\"iCash\" value=\"".$iCash."\">";
			echo "<input type=\"hidden\" name=\"iOther\" id=\"iOther\" value=\"".$iOther."\">";
			echo "<input type=\"hidden\" name=\"iIn\" id=\"iIn\" value=\"".$iIn."\">";
			echo "<input type=\"hidden\" name=\"iOut\" id=\"iOut\" value=\"".$iOut."\">";
			echo "<input type=\"hidden\" name=\"iAdjed\" id=\"iAdjed\" value=\"".$iAdjed."\">";
			echo "<input type=\"hidden\" name=\"iAdj\" id=\"iAdj\" value=\"".$iAdj."\">";
			echo "<input type=\"hidden\" name=\"iPrint\" id=\"iPrint\" value=\"".$iPrint."\">";
			echo "<input type=\"hidden\" name=\"sDesc\" id=\"sDesc\" value=\"".$sDesc."\">";
			echo "<input type=\"hidden\" name=\"sCode1\" id=\"sCode1\" value=\"".$sCode1."\">";
			echo "<input type=\"hidden\" name=\"sCode2\" id=\"sCode2\" value=\"".$sCode2."\">";
			echo "<input type=\"hidden\" name=\"sDocNickName\" id=\"sDocNickName\" value=\"".$sDocNickName."\">";
			echo "<input type=\"hidden\" name=\"sAccType\" id=\"sAccType\" value=\"".$sAccType."\">";
			echo "<input type=\"hidden\" name=\"sAccNo\" id=\"sAccNo\" value=\"".$sAccNo."\">";
			endif;
			echo "Page: <select name=\"pg\">";
	
			for ($k = 1;$k <= $Hal;$k++) {
				$newpg = $Limit*($k-1);
				if($Pg != $newpg) {
//					print " <a href=\"?pg=".$newpg."\" title=\"page ".$k."\" class=\"normallink\">".$k."</a> \n";
					echo "<option value=\"".$newpg."\">".$k."</option>";
				} else {
//					print " <strong>[$k]</strong> ";
					echo "<option value=\"".$newpg."\" selected>".$k."</option>";
				}
			}
			echo "</select>";
			echo "&nbsp;<input type=\"submit\" name=\"bnSubmit\" id=\"bnSubmit\" value=\"Go\">&nbsp;";
			echo "</form>";
			echo "</td>";
			echo "</tr>";
			echo "</table>";
			?>
            </div>
			<?php
			//$sList		 = "SELECT d.DocID, d.DocFullNo, d.DocDate, a.TransID, a.AccNo, a.AccName, a.Description, a.Amount FROM tilyan_micom_document d, tilyan_micom_account a WHERE d.DocID  = a.DocID";
			$sList		.= " ORDER BY d.DocYear DESC, d.DocMonth DESC, d.DocNo DESC, a.TransID DESC LIMIT $Pg, $Limit";
	
			$SQLList	 = mysql_query($sList) or die(mysql_errno()." : ".mysql_error());
			?></p>
			<table width="100%" cellpadding="2" cellspacing="3" border="0" align="center" class="OSStyle">
				<tr>
					<td style="border-bottom: solid 1px #990000;" colspan="7">&nbsp;</td>
				</tr>
				<tr>
					<td style="background-color:#CCCCCC; height:22px; width:25%; padding-left:6px;"><strong>Doc #</strong></td>
					<td style="background-color:#CCCCCC; height:22px; width:8%; padding-left:6px;"><strong>Date</strong></td>
					<td style="background-color:#CCCCCC; height:22px; width:6%; padding-left:6px;"><strong>Acct #</strong></td>
					<td style="background-color:#CCCCCC; height:22px; width:12%; padding-left:6px;"><strong>Account Name</strong></td>
					<td style="background-color:#CCCCCC; height:22px; width:30%; padding-left:6px;"><strong>Description</strong></td>
					<td style="background-color:#CCCCCC; height:22px; width:10%; padding-left:6px;"><strong>Amount</strong></td>
					<td style="background-color:#CCCCCC; height:22px; width:9%; padding-left:6px;"><strong>&nbsp;</strong></td>
				</tr>
				<?php
				if (mysql_num_rows($SQLList) == 0):
				?>
				<tr>
					<td align="center" colspan="7"><font color="#FF0000"><strong>There's no record at the moment.</strong></font></td>
				</tr>
				<?php
				else:
				  	$i		= $Pg+1;
				  	while($oList = mysql_fetch_object($SQLList)) {
						if(empty($oList->DocPrinted)):
							$iPrinted = 0;
						else:
							$iPrinted = $oList->DocPrinted;
						endif;
						
						//generate FullDocNo
						$sDocFullNo = "";
						if($_SESSION['TLY__VisibleFolder']==0):
							$sDocFullNo .= strtoupper($oList->DocFolder);
						else:
							$sDocFullNo .= "";
						endif;
						if(!empty($oList->DocADJ)):
							if(empty($sDocFullNo)):
								$sDocFullNo .= "ADJ";
							else:
								$sDocFullNo .= ".ADJ";
							endif;
						else:
							$sDocFullNo .= "";
						endif;
						if(empty($sDocFullNo)):
							$sDocFullNo .= $oList->DocType.".".$oList->DocInOut;
						else:
							$sDocFullNo .= ".".$oList->DocType.".".$oList->DocInOut;
						endif;
						if($_SESSION['TLY__VisibleNickName']==0):
							$sDocFullNo .= ".".strtoupper($oList->DocNickName);
						endif;
						if(strlen($oList->DocMonth)==1):
							$sFormatedMonth	= "0".$oList->DocMonth;
						elseif(strlen($oList->DocMonth)==2):
							$sFormatedMonth	= $oList->DocMonth;
						endif;
						$sDocFullNo .= ".".$oList->DocCode;
						if(!empty($oList->DocCode2)):
							$sDocFullNo .= ".".$oList->DocCode2;
						endif;
						if(!empty($oList->DocCode3)):
							$sDocFullNo .= ".".$oList->DocCode3;
						endif;
						$sDocFullNo .= ".".$oList->DocYear.".".$sFormatedMonth;
						if($_SESSION['TLY__VisibleTime']==0):
							$sDocFullNo .= ".".$oList->DocTime;
						endif;
						if(strlen($oList->DocNo)==1):
							$sFormatedNumber	= "000".$oList->DocNo;
						elseif(strlen($oList->DocNo)==2):
							$sFormatedNumber	= "00".$oList->DocNo;
						elseif(strlen($oList->DocNo)==3):
							$sFormatedNumber	= "0".$oList->DocNo;
						elseif(strlen($oList->DocNo)==4):
							$sFormatedNumber	= $oList->DocNo;
						endif;
						$sDocFullNo .= ".".$sFormatedNumber;

				?>
				<tr>
                    <td valign="top" align="left" style="border-bottom: solid 1px #990000; height:22px;" nowrap="nowrap">
						<?php 
							if(!empty($oList->DocNotes) && $oList->DocClear!=1) { 
						?>
                        	<!-- <span class="hotspot" onmouseover="tooltip.show('<?php echo nl2br($oList->DocNotes);?>');" onmouseout="tooltip.hide();"><?php echo $oList->DocFullNo?></span> //-->
                        	<span class="hotspot" onmouseover="tooltip.show('<?php echo nl2br($oList->DocNotes);?>');" onmouseout="tooltip.hide();"><?php echo $sDocFullNo?></span>
						<?php 
							} else { 
								if($oList->DocClear==1) { 
									echo "<span style=\"color: #009933;\">";
								}
						?>
							<!-- <?php echo $oList->DocFullNo?> //-->
							<?php echo $sDocFullNo; ?>
						<?php 
								if($oList->DocClear==1) { 
									echo "</span>"; 
								} 
							} 
						?><!-- &nbsp;&nbsp;<a href="documentedit.php?doc=<?php echo $oList->DocID?>"><img src="images/icon_edit.gif" border="0" height="20" title="edit" align="absmiddle" /></a> //-->
					</td>
					<td valign="top" align="center" style="border-bottom: solid 1px #990000; height:22px;"><?php echo ViewDateTimeFormat($oList->DocDate,5)?></td>
					<td valign="top" align="right" style="border-bottom: solid 1px #990000; height:22px; padding-right:6px;"><?php echo $oList->AccNo?></td>
					<td valign="top" align="left" style="border-bottom: solid 1px #990000; height:22px;" nowrap="nowrap"><?php echo $oList->AccName?></td>
					<td valign="top" align="left" style="border-bottom: solid 1px #990000; height:22px; padding-left:6px;"><?php echo $oList->Description?></td>
					<td valign="top" align="right" style="border-bottom: solid 1px #990000; height:22px; padding-right:6px;"><?php echo ConvertMoneyFormatIndo2($oList->Amount)?></td>
					<td valign="top" align="center" style="border-bottom: solid 1px #990000; height:22px;" nowrap="nowrap">
						<?php
						if($_SESSION["TLY__Permission"]!=1):
						?>
                        <a href="transactioncomment.php?doc=<?php echo $oList->DocID?>"><img src="images/icon_comment.png" border="0" height="20" title="add comment" /></a>
                        <?php
						endif;
						if($_SESSION["TLY__Permission"]!=2):
                            if($oList->DocClear==1):
                                if($oList->DocAdjusted==1):
						?>
                            &nbsp;&nbsp;<img src="images/icon_adj_done.png" border="0" height="20" title="adjustment created" />
						<?php
                                else:
						?>
                            &nbsp;&nbsp;<a href="documentadj.php?doc=<?php echo $oList->DocID?>"><img src="images/icon_adj.png" border="0" height="20" title="create adjustment" /></a>
						<?php
                                endif;
							endif;
						endif;
						if($oList->DocClear==1):
						?>
                            &nbsp;&nbsp;<a href="transactionprintpreview.php?doc=<?php echo base64_encode($oList->DocID)?>" target="_blank"><img src="images/icon_print.png" border="0" height="20" title="print preview" /></a><sub><?php echo $iPrinted ?></sub>
						<?php
                        else:
							if($_SESSION["TLY__Permission"]!=2):
								if($oList->DocType=="O"):
						?>
                            &nbsp;&nbsp;<a href="transactioneditother.php?doc=<?php echo $oList->DocID?>"><img src="images/icon_edit.gif" border="0" height="20" title="edit" /></a>
						<?php
								else:
						?>
                            &nbsp;&nbsp;<a href="transactionedit.php?doc=<?php echo $oList->DocID?>"><img src="images/icon_edit.gif" border="0" height="20" title="edit" /></a>
                        <?php
								endif;
                            endif;
						endif;
						?>
					</td>
				</tr>
				<?php
						$i++;
				  	}
				endif;
				?>
			</table>
            <p>&nbsp;</p>
        
        </div>
		<!-- This contains the hidden content for inline calls -->
		<div style='display:none'>
			<div id='inline_example1' style='padding:10px; background:#fff;'>
            <form name="FilterFrm" id="FilterFrm" action="<?php echo $_SERVER['PHP_SELF']."?"?>" method="get">
			<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
			<table width="100%" cellpadding="2" cellspacing="3" align="center" class="OSStyle">
				<!--<tr>
					<td style="border-bottom: solid 1px #990000;" colspan="7">&nbsp;</td>
				</tr> -->
				<tr>
					<td style="background-color:#CCCCCC; height:22px; padding-left:6px; padding-top:4px; border-top: 1px solid #99000;" colspan="7"><strong>Filter Option</strong></td>
				</tr>
				<tr>
					<td style="height:22px; padding-left:6px;" nowrap="nowrap"><strong>Select Date Begin: </strong></td>
					<td style="height:22px; padding-left:6px;" nowrap="nowrap">
                        <select name="db" id="db" class="SELECT">
                            <option value="0" selected="selected">Day</option>
                            <?php
                            for ($dayb = 1; $dayb <= 31; $dayb++) {
                                if (strlen($dayb)==1):
                                    echo "<option value=0".$dayb." ";
                                else:
                                    echo "<option value=".$dayb." ";
                                endif;
                            
                                if ($PilihTanggalb==$dayb) {echo " SELECTED";}
                                echo ">$dayb</option>\n";
                            }
                            ?>
                        </select>&nbsp;&nbsp;
                        <select name="mb" id="mb" class="SELECT">
                            <option value="0" selected="selected">Month</option>
                            <?php
                            for ($monthb = 1; $monthb <= 12; $monthb++) {
                                //if (strlen($month)==1):
                                //    echo "<option value=0".$month." ";
                                //else:
                                    echo "<option value=".$monthb." ";
                                //endif;
                            
                                if ($PilihBulanb==$monthb) {echo " SELECTED";}
                                echo ">";
                            
                                if ($monthb=="1"):
                                    echo "Januari";
                                elseif ($monthb=="2"):
                                    echo "Februari";
                                elseif ($monthb=="3"):
                                    echo "Maret";
                                elseif ($monthb=="4"):
                                    echo "April";
                                elseif ($monthb=="5"):
                                    echo "Mei";
                                elseif ($monthb=="6"):
                                    echo "Juni";
                                elseif ($monthb=="7"):
                                    echo "Juli";
                                elseif ($monthb=="8"):
                                    echo "Agustus";
                                elseif ($monthb=="9"):
                                    echo "September";
                                elseif ($monthb=="10"):
                                    echo "Oktober";
                                elseif ($monthb=="11"):
                                    echo "November";
                                elseif ($monthb=="12"):
                                    echo "Desember";
                                endif;
                                
                                echo"</option>\n";
                            }
                            ?>
                        </select>&nbsp;&nbsp;
                        <select name="yb" id="yb" class="SELECT">
                            <option value="0" selected="selected">Year</option>
                            <?php
                            $currentYearb = date("y");
                            for ($yearb = 2000; $yearb <= $TodayDate[year]; $yearb++) {
                                echo "<option";
                                if ($PilihTahunb==$yearb) {echo " SELECTED";}
                                echo ">$yearb</option>\n";
                            }
                            ?>
                        </select>&nbsp;&nbsp;
                    </td>
					<td style="height:22px; padding-left:6px;" nowrap="nowrap"><strong>Select Date End: </strong></td>
					<td style="height:22px; padding-left:6px;" nowrap="nowrap">
                        <select name="de" id="de" class="SELECT">
                            <option value="0" selected="selected">Day</option>
                            <?php
                            for ($daye = 1; $daye <= 31; $daye++) {
                                if (strlen($daye)==1):
                                    echo "<option value=0".$daye." ";
                                else:
                                    echo "<option value=".$daye." ";
                                endif;
                            
                                if ($PilihTanggale==$daye) {echo " SELECTED";}
                                echo ">$daye</option>\n";
                            }
                            ?>
                        </select>&nbsp;&nbsp;
                        <select name="me" id="me" class="SELECT">
                            <option value="0" selected="selected">Month</option>
                            <?php
                            for ($monthe = 1; $monthe <= 12; $monthe++) {
                                //if (strlen($month)==1):
                                //    echo "<option value=0".$month." ";
                                //else:
                                    echo "<option value=".$monthe." ";
                                //endif;
                            
                                if ($PilihBulane==$monthe) {echo " SELECTED";}
                                echo ">";
                            
                                if ($monthe=="1"):
                                    echo "Januari";
                                elseif ($monthe=="2"):
                                    echo "Februari";
                                elseif ($monthe=="3"):
                                    echo "Maret";
                                elseif ($monthe=="4"):
                                    echo "April";
                                elseif ($monthe=="5"):
                                    echo "Mei";
                                elseif ($monthe=="6"):
                                    echo "Juni";
                                elseif ($monthe=="7"):
                                    echo "Juli";
                                elseif ($monthe=="8"):
                                    echo "Agustus";
                                elseif ($monthe=="9"):
                                    echo "September";
                                elseif ($monthe=="10"):
                                    echo "Oktober";
                                elseif ($monthe=="11"):
                                    echo "November";
                                elseif ($monthe=="12"):
                                    echo "Desember";
                                endif;
                                
                                echo"</option>\n";
                            }
                            ?>
                        </select>&nbsp;&nbsp;
                        <select name="ye" id="ye" class="SELECT">
                            <option value="0" selected="selected">Year</option>
                            <?php
                            $currentYeare = date("y");
                            for ($yeare = 2000; $yeare <= $TodayDate[year]; $yeare++) {
                                echo "<option";
                                if ($PilihTahune==$yeare) {echo " SELECTED";}
                                echo ">$yeare</option>\n";
                            }
                            ?>
                        </select>&nbsp;&nbsp;
                    </td>
				</tr>
                <tr>
					<td style="height:22px; padding-left:6px;"><strong>Select Type: </strong></td>
					<td style="height:22px; padding-left:6px;"><input type="checkbox" name="iBank" id="iBank" value="1"<?php if($iBank==1){ echo " checked"; }?> />&nbsp;Bank&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="iCash" id="iCash" value="1"<?php if($iCash==1){ echo " checked"; }?> />&nbsp;Cash&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="iOther" id="iOther" value="1"<?php if($iOther==1){ echo " checked"; }?> />&nbsp;Other&nbsp;&nbsp;</td>
                    <td style="height:22px; padding-left:6px;"><strong>Select In / Out: </strong></td>
					<td style="height:22px; padding-left:6px;"><strong><input type="checkbox" name="iIn" id="iIn" value="1"<?php if($iIn==1){ echo " checked"; }?> />&nbsp;In&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="iOut" id="iOut" value="1"<?php if($iOut==1){ echo " checked"; }?> />&nbsp;Out&nbsp;&nbsp;</strong></td>
				</tr>
                <tr>
					<td style="height:22px; padding-left:6px;" colspan="4"><strong>Code I: </strong>&nbsp;&nbsp;&nbsp;
                        <select name="sCode1" id="sCode1" class="SELECT">
                            <option value="pilih">Choose</option>
                            <option value="tP"<?php if($sCode1 == "tP") { echo " selected"; }?>>tP</option>
							<?php
                            $sSQLGetCode1	= mysql_query("SELECT CodeName FROM tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_code1 WHERE Status = '1' ORDER BY CodeName") or die(mysql_errno()." : ".mysql_error());
                            
                            if(mysql_num_rows($sSQLGetCode1)!=0):
                                while($oCode1 = mysql_fetch_object($sSQLGetCode1)) {
                            ?>
                            <option value="<?php echo $oCode1->CodeName?>"<?php if($sCode1 == $oCode1->CodeName) { echo " selected"; }?>><?php echo $oCode1->CodeName?></option>
							<?php
                                }
                            endif;
                            ?>
                        </select>&nbsp;&nbsp;&nbsp;<strong>Code II: </strong>&nbsp;&nbsp;&nbsp;
                        <select name="sCode2" id="sCode2" class="SELECT">
                            <option value="pilih">Choose</option>
                            <option value="NULL"<?php if($sCode2 == "NULL") { echo " selected"; }?>></option>
						<?php
						$sSQLGetCode2	= mysql_query("SELECT CodeName FROM tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_code2 WHERE Status = '1' ORDER BY CodeName") or die(mysql_errno()." : ".mysql_error());

						if(mysql_num_rows($sSQLGetCode2)!=0):
							while($oCode2 = mysql_fetch_object($sSQLGetCode2)) {
						?>
                            <option value="<?php echo $oCode2->CodeName?>"<?php if($sCode2 == $oCode2->CodeName) { echo " selected"; }?>><?php echo $oCode2->CodeName?></option>
						<?php
							}
						endif;
						?>
                        </select>
						<?php
							if($_SESSION['TLY__LUC3Active']==1):
						?>
                        &nbsp;&nbsp;&nbsp;<strong>Code III: </strong>&nbsp;&nbsp;&nbsp;
                        <select name="sCode3" id="sCode3" class="SELECT">
                            <option value="pilih">Choose</option>
                            <option value="NULL"<?php if($sCode3 == "NULL") { echo " selected"; }?>></option>
						<?php
						$sSQLGetCode3	= mysql_query("SELECT CodeName FROM tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_code3 WHERE Status = '1' ORDER BY CodeName") or die(mysql_errno()." : ".mysql_error());

						if(mysql_num_rows($sSQLGetCode3)!=0):
							while($oCode3 = mysql_fetch_object($sSQLGetCode3)) {
						?>
                            <option value="<?php echo $oCode3->CodeName?>"<?php if($sCode3 == $oCode3->CodeName) { echo " selected"; }?>><?php echo $oCode3->CodeName?></option>
						<?php
							}
						endif;
						?>
                        </select>
						<?php
							endif;
						?>
                    </td>
				</tr>
                <tr>
					<td style="height:22px; padding-left:6px;" colspan="4"><strong>Acc. #:</strong>&nbsp;&nbsp;&nbsp;
                        <select name="sAccNo" id="sAccNo" class="SELECT">
                            <option value="pilih">Choose</option>
							<?php
                            $sSQLGetAccNo	= mysql_query("SELECT AccNo FROM tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account ORDER BY AccNo") or die(mysql_errno()." : ".mysql_error());
                            
                            if(mysql_num_rows($sSQLGetAccNo)!=0):
                                while($oAccNo = mysql_fetch_object($sSQLGetAccNo)) {
                            ?>
                            <option value="<?php echo $oAccNo->AccNo?>"<?php if($sAccNo == $oAccNo->AccNo) { echo " selected"; }?>><?php echo $oAccNo->AccNo?></option>
							<?php
                                }
                            endif;
                            ?>
                        </select>&nbsp;&nbsp;&nbsp;<strong>Entry By:</strong>&nbsp;&nbsp;&nbsp;
                        <select name="sDocNickName" id="sDocNickName" class="SELECT">
                            <option value="pilih">Choose</option>
							<?php
                            $sSQLGetEntry	= mysql_query("SELECT CP_Fullname, CP_NickName FROM tilyan_membersperson WHERE CoID = ".$_SESSION['TLY__MemberID']."") or die(mysql_errno()." : ".mysql_error());
                            echo "SELECT CP_Fullname, CP_NickName FROM tilyan_".$_SESSION['TLY__MemberFolder']."_membersperson";
                            
                            if(mysql_num_rows($sSQLGetEntry)!=0):
                                while($oTheEntry = mysql_fetch_object($sSQLGetEntry)) {
                            ?>
                            <option value="<?php echo $oTheEntry->CP_NickName?>"<?php if($sDocNickName == $oTheEntry->CP_NickName) { echo " selected"; }?>><?php echo $oTheEntry->CP_Fullname?></option>
							<?php
                                }
                            endif;
                            ?>
                        </select>&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
                <tr>
					<td style="height:22px; padding-left:6px;" colspan="4"><strong>Description: </strong>&nbsp;&nbsp;&nbsp;<input type="text" name="sDesc" id="sDec" value="<?php echo $sDesc?>" size="35" />&nbsp;&nbsp;&nbsp;<strong>Account Type: </strong>&nbsp;&nbsp;&nbsp;
                        <select name="sAccType" id="sAccType" class="SELECT">
                            <option value="pilih">Choose</option>
							<?php
                            $sSQLGetAccType	= mysql_query("SELECT Type FROM tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account GROUP BY Type ORDER BY Type") or die(mysql_errno()." : ".mysql_error());
                            
                            if(mysql_num_rows($sSQLGetAccType)!=0):
                                while($oAccType = mysql_fetch_object($sSQLGetAccType)) {
                            ?>
                            <option value="<?php echo $oAccType->Type?>"<?php if($sAccType == $oAccType->Type) { echo " selected"; }?>><?php echo $oAccType->Type?></option>
							<?php
                                }
                            endif;
                            ?>
                        </select>&nbsp;&nbsp;&nbsp;
					</td>
				</tr>
                <tr>
					<td style="height:22px; padding-left:6px;" colspan="4">
						<strong>Adjusted Only:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="iAdjed" id="iAdjed" value="1"<?php if($iAdjed==1){ echo " checked"; }?> />&nbsp;&nbsp;&nbsp;Adjustment Only:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="iAdj" id="iAdj" value="1"<?php if($iAdj==1){ echo " checked"; }?> />&nbsp;&nbsp;&nbsp;Print Ready Only:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="iPrint" id="iPrint" value="1"<?php if($iPrint==1){ echo " checked"; }?> /></strong>
					</td>
				</tr>
				<tr>
					<td style="height:22px; padding-left:6px;" colspan="3">&nbsp;</td>
					<td style="height:22px; padding-left:6px; text-align:right;"><input type="submit" name="bnSubmit" id="bnSubmit" value="Filter List" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="bnReset" id="bnReset" value="Reset"></td>
				</tr>
			</table>
			</form>
			</div>
		</div>

    </body>
</html>
