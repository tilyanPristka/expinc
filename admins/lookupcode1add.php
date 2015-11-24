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
	$CodeName	= TrimString($_POST['CodeName']);
	$CodeDesc	= TrimString($_POST['CodeDesc']);
	$ContractNo			= TrimString($_POST['ContractNo']);
	$ContractValue		= TrimString($_POST['ContractValue']);
	$StartDateTanggal	= TrimString($_POST['startTanggal']);
	$StartDateBulan		= TrimString($_POST['startBulan']);
	$StartDateTahun		= TrimString($_POST['startTahun']);
	$EndDateTanggal		= TrimString($_POST['endTanggal']);
	$EndDateBulan		= TrimString($_POST['endBulan']);
	$EndDateTahun		= TrimString($_POST['endTahun']);
	$Status		= $_POST['Status'];
	
	if (empty($CodeName)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Code's Name<br />";
	}

	if (empty($CodeDesc)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Description<br />";
	}

	if (empty($ContractValue)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Contract Value<br />";
	}

	if (empty($StartDateTanggal) || empty($StartDateBulan) || empty($StartDateTahun)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Start Date<br />";
	} else {
		$StartDate = $StartDateTahun."-".$StartDateBulan."-".$StartDateTanggal;
	}

	if (empty($EndDateTanggal) || empty($EndDateBulan) || empty($EndDateTahun)) {
		$bError		 = true;
		$sMessage	.= ". Please provide End Date<br />";
	} else {
		$EndDate = $EndDateTahun."-".$EndDateBulan."-".$EndDateTanggal;
	}

	if (empty($Status)) {
		$Status		= 0;
	}

	if (!$bError) {
		/* INSERT */
		mysql_query("INSERT INTO tilyan_".$sFolder."_lookup_code1 (CodeName, CodeDesc, ContractNo, ContractValue, StartDate, EndDate, Status) VALUES ('".$CodeName."', '".$CodeDesc."', '".$ContractNo."', '".$ContractValue."', '".$StartDate."', '".$EndDate."', '".$Status."')") or die(mysql_errno()." : ".mysql_error());

		echo "<meta http-equiv=\"refresh\" content=\"0;URL=lookupcode1list.php?id=".$iCoID."\">";
		exit();

	}
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
            <div style="background-color:#FFF; margin-top:15px; margin-bottom:15px;">
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
            <a>Client's Look Up Code I Add</a>
            <div style="background-color:#FFF;">
			<form name="ArticleFrm" id="ArticleFrm" action="<?php echo $_SERVER['PHP_SELF']."?id=".$_GET['id'].""?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
			<table width="95%" cellpadding="2" cellspacing="3" border="0" align="center" class="OSStyle">
				<?php	if ($bError) { ?>
				<tr>
					<td colspan="2"><font color="#FF0000"><strong><?php echo $sMessage?></strong></font></td>
				</tr>
				<?php	} ?>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="CodeName"><strong>Code's Name:</strong></label></td>
					<td><input type="text" name="CodeName" id="CodeName" size="5" value="<?php echo $CodeName?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="CodeDesc"><strong>Description:</strong></label></td>
					<td><input type="text" name="CodeDesc" id="CodeDesc" size="35" value="<?php echo $CodeDesc?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="ContractNo"><strong>Contract No:</strong></label></td>
					<td><input type="text" name="ContractNo" id="ContractNo" size="35" value="<?php echo $ContractNo?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="ContractValue"><strong>Contract Value:</strong></label></td>
					<td><input type="text" name="ContractValue" id="ContractValue" size="35" value="<?php echo $ContractValue?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><strong>Start Date:</strong></label></td>
					<td>
                        <select name="startTanggal" id="startTanggal" class="SELECT">
                            <option value="" selected="selected">Day</option>
                            <?php
                            for ($day = 1; $day <= 31; $day++) {
                                if (strlen($day)==1):
                                    echo "<option value=0".$day." ";
                                else:
                                    echo "<option value=".$day." ";
                                endif;
                            
                                if ($StartDateTanggal==$day) {echo " SELECTED";}
                                echo ">$day</option>\n";
                            }
                            ?>
                        </select> : 
                        <select name="startBulan" id="startBulan" class="SELECT">
                            <option value="" selected="selected">Month</option>
                            <?php
                            for ($month = 1; $month <= 12; $month++) {
                                if (strlen($month)==1):
                                    echo "<option value=0".$month." ";
                                else:
                                    echo "<option value=".$month." ";
                                endif;
                            
                                if ($StartDateBulan==$month) {echo " SELECTED";}
                                echo ">";
                            
                                if ($month=="1"):
                                    echo "Januari";
                                elseif ($month=="2"):
                                    echo "Februari";
                                elseif ($month=="3"):
                                    echo "Maret";
                                elseif ($month=="4"):
                                    echo "April";
                                elseif ($month=="5"):
                                    echo "Mei";
                                elseif ($month=="6"):
                                    echo "Juni";
                                elseif ($month=="7"):
                                    echo "Juli";
                                elseif ($month=="8"):
                                    echo "Agustus";
                                elseif ($month=="9"):
                                    echo "September";
                                elseif ($month=="10"):
                                    echo "Oktober";
                                elseif ($month=="11"):
                                    echo "November";
                                elseif ($month=="12"):
                                    echo "Desember";
                                endif;
                                
                                echo"</option>\n";
                            }
                            ?>
                        </select> : 
                        <select name="startTahun" id="startTahun" class="SELECT">
                            <option value="" selected="selected">Year</option>
                            <?php
                            $currentYear = date("y");
                            for ($year = 2000; $year <= date(Y); $year++) {
                                echo "<option";
                                if ($StartDateTahun==$year) {echo " SELECTED";}
                                echo ">$year</option>\n";
                            }
                            ?>
                        </select>&nbsp;
					</td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><strong>End Date:</strong></label></td>
					<td>
                        <select name="endTanggal" id="endTanggal" class="SELECT">
                            <option value="" selected="selected">Day</option>
                            <?php
                            for ($day = 1; $day <= 31; $day++) {
                                if (strlen($day)==1):
                                    echo "<option value=0".$day." ";
                                else:
                                    echo "<option value=".$day." ";
                                endif;
                            
                                if ($EndDateTanggal==$day) {echo " SELECTED";}
                                echo ">$day</option>\n";
                            }
                            ?>
                        </select> : 
                        <select name="endBulan" id="endBulan" class="SELECT">
                            <option value="" selected="selected">Month</option>
                            <?php
                            for ($month = 1; $month <= 12; $month++) {
                                if (strlen($month)==1):
                                    echo "<option value=0".$month." ";
                                else:
                                    echo "<option value=".$month." ";
                                endif;
                            
                                if ($EndDateBulan==$month) {echo " SELECTED";}
                                echo ">";
                            
                                if ($month=="1"):
                                    echo "Januari";
                                elseif ($month=="2"):
                                    echo "Februari";
                                elseif ($month=="3"):
                                    echo "Maret";
                                elseif ($month=="4"):
                                    echo "April";
                                elseif ($month=="5"):
                                    echo "Mei";
                                elseif ($month=="6"):
                                    echo "Juni";
                                elseif ($month=="7"):
                                    echo "Juli";
                                elseif ($month=="8"):
                                    echo "Agustus";
                                elseif ($month=="9"):
                                    echo "September";
                                elseif ($month=="10"):
                                    echo "Oktober";
                                elseif ($month=="11"):
                                    echo "November";
                                elseif ($month=="12"):
                                    echo "Desember";
                                endif;
                                
                                echo"</option>\n";
                            }
                            ?>
                        </select> : 
                        <select name="endTahun" id="endTahun" class="SELECT">
                            <option value="" selected="selected">Year</option>
                            <?php
                            $currentYear = date("y");
                            for ($year = 2000; $year <= date(Y); $year++) {
                                echo "<option";
                                if ($EndDateTahun==$year) {echo " SELECTED";}
                                echo ">$year</option>\n";
                            }
                            ?>
                        </select>&nbsp;
					</td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="Status"><strong>Status:</strong></label></td>
					<td><input type="checkbox" name="Status" id="Status" value="1" <?php echo ($Status == 1) ? "checked" : ""?>></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="bnSubmit" id="bnSubmit" value="<?php echo (!empty($_GET['lid']) ? "Update" : "Save")?>">&nbsp;&nbsp;<input type="button" name="bnCancel" id="bnCancel" value="Cancel" onClick="Cancel('lookupcode1list.php?id=<?php echo $iCoID?>');"><?php if (!empty($_GET['lid'])) { ?>&nbsp;&nbsp;<input type="button" name="bnDelete" id="bnDelete" value="Delete" onClick="Delete(<?php echo $_GET['lid']?>)"><?php } ?></td>
				</tr>
			</table>
			</form>


            </div>
        </div>

        <div class="bottom" style="float:left; margin-right: 33px; margin-bottom:6px;"></div>
	</div>
</body>
</html>
