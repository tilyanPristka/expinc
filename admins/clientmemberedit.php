<?php
@session_start();

include("inc.php");
//include("../spaw/spaw.inc.php");
//$spaw1 = new SpawEditor("spaw1");

CheckAuthentication();
CheckPermission('members');

$bError		= false;
$sMessage	= "";
$iCoID		= $_GET["id"];
$iCP_ID		= $_GET["cpid"];
if (!empty($_GET['id'])):
	$SQLEdit	= mysql_query("SELECT * FROM $Tb_Members WHERE CoID = '".$_GET['id']."'") or die(mysql_errno()." : ".mysql_error());

	if ($oEdit = mysql_fetch_object($SQLEdit)):
		$sCoName			= stripslashes($oEdit->CoName);
		$sCoAddress			= stripslashes($oEdit->CoAddress);
		$sLogo				= stripslashes($oEdit->CoLogo);
	endif;
endif;

if ($_POST['bSubmitted']) {
	$CP_Fullname		= TrimString($_POST['CP_Fullname']);
	$CP_Email			= TrimString($_POST['CP_Email']);
	$CP_NickName		= TrimString($_POST['CP_NickName']);
	$CP_User			= TrimString($_POST['CP_User']);
	$CP_Pass			= TrimString($_POST['CP_Pass']);
	$CP_Permission		= TrimString($_POST['CP_Permission']);
	$CP_Enabled			= $_POST['CP_Enabled'];
	
	if (empty($CP_User)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Username<br />";
	}

	/*if (empty($CP_Pass)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Password<br />";
	}*/

	if (empty($CP_Fullname)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Fullname<br />";
	}

	if (empty($CP_Email)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Email<br />";
	}

	if (empty($CP_NickName)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Nickname<br />";
	}

	if (!$bError) {
		if (empty($_GET['cpid'])) {
			/* INSERT */
			mysql_query("INSERT INTO tilyan_membersperson (CoID, CP_DateCreated, CP_User, CP_Pass, CP_Fullname, CP_Email, CP_NickName, CP_Enabled) VALUES (".$iCoID.", now(), '".$CP_User."', '".md5($CP_Pass)."', '".$CP_Fullname."', '".$CP_Email."', '".$CP_NickName."', '".$eEnabled."')") or die(mysql_errno()." : ".mysql_error());
		} else {
			/* UPDATE */
			if($CP_Pass==""):
				mysql_query("UPDATE tilyan_membersperson SET CP_User = '".$CP_User."', CP_NickName = '".$CP_NickName."', CP_Fullname = '".$CP_Fullname."', CP_Email = '".$CP_Email."', CP_Permission = '".$CP_Permission."', CP_Enabled = '".$CP_Enabled."' WHERE CP_ID = '".$_GET['cpid']."'") or die(mysql_errno()." : ".mysql_error());
			else:
				mysql_query("UPDATE tilyan_membersperson SET CP_User = '".$CP_User."', CP_Pass = '".$CP_Pass."', CP_NickName = '".$CP_NickName."', CP_Fullname = '".$CP_Fullname."', CP_Email = '".$CP_Email."', CP_Permission = '".$CP_Permission."', CP_Enabled = '".$CP_Enabled."' WHERE CP_ID = '".$_GET['cpid']."'") or die(mysql_errno()." : ".mysql_error());
			endif;
		}

		echo "<meta http-equiv=\"refresh\" content=\"0;URL=clientmember.php?id=".$iCoID."\">";
		exit();

	}
} else {
	if (!empty($_GET['cpid'])):
		$SQLEditPersonel	= mysql_query("SELECT * FROM tilyan_membersperson WHERE CP_ID = '".$_GET['cpid']."'") or die(mysql_errno()." : ".mysql_error());
	
		if ($oEditPersonel = mysql_fetch_object($SQLEditPersonel)):
			$CP_Fullname			= stripslashes($oEditPersonel->CP_Fullname);
			$CP_Email				= stripslashes($oEditPersonel->CP_Email);
			$CP_NickName			= stripslashes($oEditPersonel->CP_NickName);
			$CP_User				= stripslashes($oEditPersonel->CP_User);
			$CP_Pass				= stripslashes($oEditPersonel->CP_Pass);
			$CP_Permission			= stripslashes($oEditPersonel->CP_Permission);
			$CP_Enabled				= stripslashes($oEditPersonel->CP_Enabled);
		endif;
	endif;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $Site_Name?> :: Admin Site</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="scripts/global.js"></script>
<script type="text/javascript">
<!--	
function Delete(iID,iCPID) {
	if (confirm('You are about to delete one of the available Client.\nAre you sure ?')) { document.location.href = 'clientmember.php?id='+ iID +'&cpid='+ iCPID +'&act=del'; }
}
//-->
</script>
</head>

<body>
	<div id="main">

        <div class="admin_top" style="float:left; margin-left: 33px; margin-bottom:6px;">
        	<p>Welcome back, <strong><?php echo $_SESSION["TLY__AdminFullName"]?></strong></p>
            <p><?php if ($_SESSION["TLY__AdminLastLogin"]!="") { ?>Your Last Login : <?php echo $_SESSION["TLY__AdminLastLogin"]?><?php } else { ?>This is Your First Login<?php } ?></p>
            <p><a href="Logout.php?">logout</a>
        </div>
        <div class="main_logo" style="float:right; margin-right: 33px; margin-bottom:6px;">
        
        </div>
        <div class="basic" style="float:left; margin-left: 2em;" id="mylist">
            <a>Client's Member Add</a>
            <div style="background-color:#FFF;">
            	<table width="95%" cellpadding="2" cellspacing="2" border="0" class="OSStyle">
					<tr>
						<td width="250"><img src="../uploads/logo/<?php echo $sLogo?>" /></td>
						<td valign="top">
							<p><strong><?php echo $sCoName?></strong><br />
                            <?php echo nl2br($sCoAddress)?></p>
						</td>
					</tr>
				</table>

			<form name="ArticleFrm" id="ArticleFrm" action="<?php echo $_SERVER['PHP_SELF']."?id=".$_GET['id']."&cpid=".$_GET['cpid'].""?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
			<table width="95%" cellpadding="2" cellspacing="3" border="0" align="center" class="OSStyle">
				<?php	if ($bError) { ?>
				<tr>
					<td colspan="2"><font color="#FF0000"><strong><?php echo $sMessage?></strong></font></td>
				</tr>
				<?php	} ?>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="CP_User"><strong>Username:</strong></label></td>
					<td><input type="text" name="CP_User" id="CP_User" size="35" value="<?php echo $CP_User?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="CP_Pass"><strong>Password:</strong></label></td>
					<td><input type="text" name="CP_Pass" id="CP_Pass" size="35" value="<?php echo $CP_Pass?>" /> <font color="#990000"><strong> *) Don't enter any password if you don't want to change the current one.</strong></font></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="CP_Fullname"><strong>Fullname:</strong></label></td>
					<td><input type="text" name="CP_Fullname" id="CP_Fullname" size="35" value="<?php echo $CP_Fullname?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="CP_Email"><strong>Email:</strong></label></td>
					<td><input type="text" name="CP_Email" id="CP_Email" size="35" value="<?php echo $CP_Email?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="CP_NickName"><strong>Nickname:</strong></label></td>
					<td><input type="text" name="CP_NickName" id="CP_NickName" size="15" value="<?php echo $CP_NickName?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="CP_Permission"><strong>Permission:</strong></label></td>
					<td>
						<select name="CP_Permission" id="CP_Permission">
							<option value="1"<?php if($CP_Permission==1) { echo " selected"; } ?>>Data Entry</option>
							<option value="2"<?php if($CP_Permission==2) { echo " selected"; } ?>>Supervisor</option>
							<option value="3"<?php if($CP_Permission==3) { echo " selected"; } ?>>All</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="CP_Enabled"><strong>Active:</strong></label></td>
					<td><input type="checkbox" name="CP_Enabled" id="CP_Enabled" value="1" <?php echo ($CP_Enabled == 1) ? "checked" : ""?>></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="bnSubmit" id="bnSubmit" value="<?php echo (!empty($_GET['cpid']) ? "Update" : "Save")?>">&nbsp;&nbsp;<input type="button" name="bnCancel" id="bnCancel" value="Cancel" onClick="Cancel('clientmember.php?id=<?php echo $_GET["id"]?>');"><?php if (!empty($_GET['cpid'])) { ?>&nbsp;&nbsp;<input type="button" name="bnDelete" id="bnDelete" value="Delete" onClick="Delete(<?php echo $_GET['id']?>,<?php echo $_GET['cpid']?>)"><?php } ?></td>
				</tr>
			</table>
			</form>


            </div>
        </div>

        <div class="bottom" style="float:left; margin-right: 33px; margin-bottom:6px;"></div>
	</div>
</body>
</html>
