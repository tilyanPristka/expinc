<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

$bError		= false;
$sMessage	= "";

if ($_POST['bSubmitted']):
	$sCurrPass		= TrimString($_POST['sCurrPass']);
	$sNewPass		= TrimString($_POST['sNewPass']);
	$sNew2Pass		= TrimString($_POST['sNew2Pass']);
	
	if (empty($sCurrPass)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Current Password<br />";
	}
	//check if the current password is the correct one
	$SQLCheckPass	= mysql_query("SELECT CP_Pass FROM tilyan_membersperson WHERE CP_User = '".$_SESSION['TLY__MemberUser']."' AND CP_ID = '". $_SESSION['TLY__PersonID']."' AND CoID = '". $_SESSION['TLY__MemberID']."' AND CP_Pass = '". $sCurrPass."'") or die(mysql_errno()." : ".mysql_error());
	if(mysql_num_rows($SQLCheckPass)==0){
		$bError		 = true;
		$sMessage	.= ". Please provide Your Correct Current Password<br />";
	}

	if (empty($sNewPass)) {
		$bError		 = true;
		$sMessage	.= ". Please provide New Password<br />";
	}
	if (strlen($sNewPass)<4 || strlen($sNewPass)>10) {
		$bError		 = true;
		$sMessage	.= ". New Password must be between 4 to 10 characters<br />";
	}
	if (empty($sNew2Pass)) {
		$bError		 = true;
		$sMessage	.= ". Please Re-Type New Password<br />";
	}
	if (strlen($sNew2Pass)<4 || strlen($sNew2Pass)>10) {
		$bError		 = true;
		$sMessage	.= ". Re-Type New Password must be between 4 to 10 characters<br />";
	}
	if (strcmp($sNewPass,$sNew2Pass) != 0) {
		$bError		 = true;
		$sMessage	.= ". New Password and Re-Type New Password must be exactly the same.<br />";
	}
	
	if (!$bError) {
		mysql_query("UPDATE tilyan_membersperson SET CP_Pass = '".$sNewPass."' WHERE CP_ID = '".$_SESSION['TLY__PersonID']."'") or die(mysql_errno()." : ".mysql_error());

		echo "<meta http-equiv=\"refresh\" content=\"0;URL=account.php?done=1\">";
		exit();
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
	</head>

    <body>
    
        <div class="account_left" style="float:left; margin-bottom:6px;">
        	<h3>Last 10 Login Log</h3>
			<?php
			$SQLList	= mysql_query("SELECT ml.LogDate, cp.CP_FullName FROM tilyan_memberspersonlog ml, tilyan_membersperson cp WHERE ml.CP_ID = cp.CP_ID AND ml.CP_ID = ".$_SESSION['TLY__PersonID']." ORDER BY CP_LogID DESC LIMIT 0, 10") or die(mysql_error());
			?>

			<table width="100%" cellpadding="2" cellspacing="2" border="0" align="center">
				<!-- <tr align="center">
					<td align="right" colspan="3">
					</td>
				</tr> -->
				<thead>
				<tr>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">No</th>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">Login Date</th>
				</tr>
				</thead>
				<?php
				if (mysql_num_rows($SQLList) == 0) {
				?>
				<tbody>
				<tr align="center">
					<td align="center" colspan="2"><strong>no records found</strong></td>
				</tr>
				</tbody>
				<?php
				} else {
					$i	= 1;
					//$bgcolor = "#b7cae8";
					$bgcolor = "#336699";
					//$fontcolor = "#000000";
				
					while($oList = mysql_fetch_object($SQLList)) {
				?>
				<tbody>
				<tr style="height: 20px;">
					<td style="border-bottom:1px solid #990000; text-align:center;"><?php echo $i?></td>
					<td style="border-bottom:1px solid #990000; text-align:center;"><?php echo ViewDateTimeFormat($oList->LogDate, 3)?></td>
				</tr>
				</tbody>
				<?php
						if ($bgcolor == "#336699") { $bgcolor = "#85a6d3"; } else { $bgcolor = "#336699"; }
						//if ($fontcolor == "#000000") { $fontcolor = "#FFFFFF"; } else { $fontcolor = "#000000"; }
						$i++;
					}
				}
				?>
			</table>
        
        </div>
    
        <div class="account_right" style="float:left; margin-bottom:6px;">
        	<h3>Change Password</h3>
            <p>&nbsp;</p>
            <p style="text-indent:2em;">Please use the form below to change your current password</p>
            <p>&nbsp;</p>
            <p><center>
            <form name="ArticleFrm" id="ArticleFrm" action="<?php $_SERVER['PHP_SELF']."?"?>" method="post">
			<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
			<table width="95%" cellpadding="2" cellspacing="3" border="0" align="center" class="OSStyle">
				<?php	if ($bError) { ?>
				<tr>
					<td colspan="2"><font color="#FF0000"><strong><?php echo $sMessage?></strong></font></td>
				</tr>
				<?php	} ?>
				<?php	if ($_GET['done']==1) { ?>
				<tr>
					<td colspan="2"><font color="#FF0000"><strong>You have successfully change your password.<br />You should logout then login using your new password.<p>&nbsp;</p></strong></font></td>
				</tr>
				<?php	} ?>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sCurrPass"><strong>Current Password:</strong></label></td>
					<td><input type="password" name="sCurrPass" id="sCurrPass" size="35" value="<?php echo $sCurrPass?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sNewPass"><strong>New Password:</strong></label></td>
					<td><input type="password" name="sNewPass" id="sNewPass" size="35" value="<?php echo $sNewPass?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sNew2Pass"><strong>Re-Type New Password:</strong></label></td>
					<td><input type="password" name="sNew2Pass" id="sNew2Pass" size="35" value="<?php echo $sNew2Pass?>" /></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="bnSubmit" id="bnSubmit" value="Save">&nbsp;&nbsp;<input type="reset" name="bnReset" id="bnReset" value="Reset" /></td>
				</tr>
			</table>
			</form>
            </center></p>
            <p></p>
       
        </div>

    </body>
</html>
