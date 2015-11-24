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
$iLID		= $_GET["lid"];
if (!empty($_GET['id'])):
	$SQLEdit	= mysql_query("SELECT * FROM $Tb_Members WHERE CoID = '".$_GET['id']."'") or die(mysql_errno()." : ".mysql_error());

	if ($oEdit = mysql_fetch_object($SQLEdit)):
		$sCoName			= stripslashes($oEdit->CoName);
		$sCoAddress			= stripslashes($oEdit->CoAddress);
		$sLogo				= stripslashes($oEdit->CoLogo);
		$sFolder			= stripslashes($oEdit->CoFolder);
	endif;
endif;

if ($_POST['bSubmitted']) {
	$AccNo		= TrimString($_POST['AccNo']);
	$AccName	= TrimString($_POST['AccName']);
	$Type		= TrimString($_POST['Type']);
	$Status		= $_POST['Status'];
	
	if (empty($AccNo)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Acct. #<br />";
	}

	if (empty($AccName)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Acct. Name<br />";
	}

	if (empty($Type)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Type<br />";
	}

	if (!$bError) {
		/* UPDATE */
		mysql_query("UPDATE tilyan_".$sFolder."_lookup_account SET AccNo = '".$AccNo."', AccName = '".$AccName."', Type = '".$Type."', Status = '".$Status."' WHERE ID = '".$_GET['lid']."'") or die(mysql_errno()." : ".mysql_error());

		echo "<meta http-equiv=\"refresh\" content=\"0;URL=lookupacctlist.php?id=".$iCoID."\">";
		exit();

	}
} else {
	if (!empty($_GET['lid'])):
		$SQLEditLookUp	= mysql_query("SELECT * FROM tilyan_".$sFolder."_lookup_account WHERE ID = '".$_GET['lid']."'") or die(mysql_errno()." : ".mysql_error());
	
		if ($oEditLookUp = mysql_fetch_object($SQLEditLookUp)):
			$AccNo			= stripslashes($oEditLookUp->AccNo);
			$AccName		= stripslashes($oEditLookUp->AccName);
			$Type			= stripslashes($oEditLookUp->Type);
			$Status			= stripslashes($oEditLookUp->Status);
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
function Delete(iID,iLID) {
	if (confirm('You are about to delete one of the available Look Up.\nAre you sure ?')) { document.location.href = 'lookupacctlist.php?id='+ iID +'&lid='+ iLID +'&act=del'; }
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
            <a>Client's Detail</a>
            <div style="background-color:#FFF; margin-bottom:15px; margin-top:15px;">
            	<table width="95%" cellpadding="2" cellspacing="2" border="0" class="OSStyle">
					<tr>
						<td width="250"><img src="../uploads/logo/<?php echo $sLogo?>" /></td>
						<td valign="top">
							<p><strong><?php echo $sCoName?></strong><br />
                            <?php echo nl2br($sCoAddress)?></p>
						</td>
					</tr>
				</table>
			</div>
			<a>Client's Look Up Account Edit</a>
			<div style="background-color:#FFF; margin-bottom:15px; margin-top:15px;">
			<form name="ArticleFrm" id="ArticleFrm" action="<?php echo $_SERVER['PHP_SELF']."?id=".$_GET['id']."&lid=".$_GET['lid'].""?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
			<table width="95%" cellpadding="2" cellspacing="3" border="0" align="center" class="OSStyle">
				<?php	if ($bError) { ?>
				<tr>
					<td colspan="2"><font color="#FF0000"><strong><?php echo $sMessage?></strong></font></td>
				</tr>
				<?php	} ?>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="AccNo"><strong>Acct. #:</strong></label></td>
					<td><input type="text" name="AccNo" id="AccNo" size="10" value="<?php echo $AccNo?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="AccName"><strong>Acct. Name:</strong></label></td>
					<td><input type="text" name="AccName" id="AccName" size="35" value="<?php echo $AccName?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="Type"><strong>Type:</strong></label></td>
					<td><input type="text" name="Type" id="Type" size="50" value="<?php echo $Type?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="Status"><strong>Status:</strong></label></td>
					<td><input type="checkbox" name="Status" id="Status" value="1" <?php echo ($Status == 1) ? "checked" : ""?>></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="bnSubmit" id="bnSubmit" value="<?php echo (!empty($_GET['lid']) ? "Update" : "Save")?>">&nbsp;&nbsp;<input type="button" name="bnCancel" id="bnCancel" value="Cancel" onClick="Cancel('lookupacctlist.php?id=<?php echo $_GET["id"]?>');"><?php if (!empty($_GET['lid'])) { ?>&nbsp;&nbsp;<input type="button" name="bnDelete" id="bnDelete" value="Delete" onClick="Delete(<?php echo $_GET['id']?>,<?php echo $_GET['lid']?>)"><?php } ?></td>
				</tr>
			</table>
			</form>


            </div>
        </div>

        <div class="bottom" style="float:left; margin-right: 33px; margin-bottom:6px;"></div>
	</div>
</body>
</html>
