<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

$sDesc		= $_GET["desc"];
$iLoopRec	= $_GET["no"];

$sMessage	= "";

$SQLLookUp	= mysql_query("SELECT AccNo, AccName FROM tilyan_".$_SESSION['TLY__MemberFolder']."_account WHERE Description = '".$sDesc."' ORDER BY TransID DESC LIMIT 0, 4") or die(mysql_error());
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
		function updateAcct(LoopRec, ListNo) {
			var f = document.LookUpFrm;
			AccNo = eval('f.AccNo' + ListNo + '.value');
			AccName = eval('f.AccName' + ListNo + '.value');
			//var AccNo = document.LookUpFrm.ActualAccNo.value;
			//var AccName = document.LookUpFrm.ActualAccName.value;
			//confirm(''+AccNo+' and '+AccName+'');
			eval('window.opener.document.ArticleFrm.sAccNo' + LoopRec + '.value = AccNo');
			eval('window.opener.document.ArticleFrm.sAccName' + LoopRec + '.value = AccName');
			window.close();
		}
		
		//-->
        </script>
	</head>

    <body>
    
        <div class="other" style="margin-bottom:6px;">
        	<h3>Acct. # Look Up</h3>
            <p><center>
			<table width="95%" cellpadding="2" cellspacing="3" border="0" align="center" class="OSStyle">
				<tr>
					<td style="border-bottom: solid 1px #990000;">&nbsp;</td>
				</tr>
				<tr>
					<td style="background-color:#CCCCCC; height:22px; width:25%; padding-left:6px;"><strong>Description</strong></td>
				</tr>
				<tr>
					<td align="center" style="height:22px;"><em><strong><?php echo $sDesc?></strong></em></td>
				</tr>
				<tr>
					<td style="height:22px;">note: below are the top four Acct. # and Acct. Name that used the above description.</td>
				</tr>
			</table>
            <form name="LookUpFrm" id="LookUpFrm" action="" method="post" enctype="multipart/form-data">
			<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
			<table width="95%" cellpadding="2" cellspacing="3" border="0" align="center" class="OSStyle">
				<tr>
					<td style="border-bottom: solid 1px #990000;" colspan="3">&nbsp;</td>
				</tr>
				<tr>
					<td style="background-color:#CCCCCC; height:22px; width:25%; padding-left:6px;"><strong>Acct. #</strong></td>
					<td style="background-color:#CCCCCC; height:22px; width:60%; padding-left:6px;"><strong>Acct. Name</strong></td>
					<td style="background-color:#CCCCCC; height:22px; width:15%; padding-left:6px;"><strong>Action</strong></td>
				</tr>
						<?php
	if (mysql_num_rows($SQLLookUp) != 0) {
		$iListNo = 1;
		while($oLookUp = mysql_fetch_object($SQLLookUp)) {
						?>
				<tr>
					<td style="height:22px;"><strong><input type="text" name="AccNo<?php echo $iListNo?>" id="AccNo<?php echo $iListNo?>" size="10" value="<?php echo $oLookUp->AccNo?>" disabled="disabled" /></strong></td>
					<td style="height:22px;"><strong><input type="text" name="AccName<?php echo $iListNo?>" id="AccName<?php echo $iListNo?>" size="45" value="<?php echo $oLookUp->AccName?>" disabled="disabled" /></strong></td>
					<td align="center" style="height:22px;"><a href="javascript:updateAcct('<?php echo $iLoopRec?>','<?php echo $iListNo?>')"><img src="images/icon_insert.png" border="0" align="absmiddle" title="insert" /></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:window.close();"><img src="images/icon_close.png" border="0" align="absmiddle" title="close" /></a></td>
				</tr>
						<?php
			$iListNo = $iListNo+1;
		}
	}
						?>
			</table>
			</form>
            </center></p>
            <p></p>
        
        </div>

    </body>
</html>
