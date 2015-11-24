<?php
@session_start();

include("inc.php");

CheckAuthentication();
CheckPermission('members');

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

$iLookUpAcctID		= $_GET["lid"];
$sAct		= $_GET["act"];
if($sAct=="del" && !empty($iLookUpAcctID)):
	//delete
	mysql_query("DELETE FROM tilyan_".$sFolder."_lookup_code3 WHERE ID = '".$iLookUpAcctID."'") or die(mysql_error());
	mysql_query("optimize table tilyan_".$sFolder."_lookup_code3") or die(mysql_errno()." : ".mysql_error());
	
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=lookupcode3list.php?id=".$iCoID."\">";
	exit();
endif;
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
	if (confirm('You are about to delete one of the available Look Up Code III.\nAre you sure ?')) { document.location.href = 'lookupcode3list.php?id='+ iID +'&lid='+iLID+'&act=del'; }
}
//-->
</script>
</head>

<body>
	<div id="main">

        <div class="admin_top" style="float:left; margin-left: 33px; margin-bottom:6px;">
        	<p>Welcome back, <strong><?php echo $_SESSION["TLY__AdminFullName"]?></strong></p>
            <p><?php if ($_SESSION["TLY__AdminLastLogin"]!="") { ?>Your Last Login : <?php echo $_SESSION['TLY__AdminLastLogin']?><?php } else { ?>This is Your First Login<?php } ?></p>
            <p><a href="Logout.php?">logout</a>
        </div>
        <div class="main_logo" style="float:right; margin-right: 33px; margin-bottom:6px;">
        
        </div>
        <div class="basic" style="float:left; margin-left: 2em;" id="mylist">
            <a>Client's Detail</a>
            <div style="background-color:#FFF;">
            	<table width="95%" cellpadding="2" cellspacing="2" border="0" class="OSStyle">
					<tr>
						<td width="250"><img src="../uploads/logo/<?php echo $sLogo?>" /></td>
						<td valign="top">
							<p><strong><?php echo $sCoName?></strong><br />
                            <?php echo nl2br($sCoAddress)?></p>
                            <p><button onclick="javascript:document.location.href = 'lookupcode3add.php?id=<?php echo $iCoID?>';">Add New Look Up</button>&nbsp;&nbsp;<button onclick="javascript:document.location.href = 'ClientEdit.php?id=<?php echo $iCoID?>';">Return To Client Edit</button></p>
						</td>
					</tr>
				</table>
            </div>
            <a>Client's Look Up Code III</a>
            <div style="background-color:#FFF;">
			<?php
			/* Paginate */
			$Pg			= $_GET["pg"];
			$Limit		= 10;
	
			if(empty($Pg)) {
				$Pg = 0;
			}
	
			$sPaging		 = "SELECT ID FROM tilyan_".$sFolder."_lookup_code3";
			$SQLPaging		 = mysql_query($sPaging) or die(mysql_errno()." : ".mysql_error());
			$TotalRecord	 = mysql_num_rows($SQLPaging);
			?>
			<?php
			$Hal = intval($TotalRecord/$Limit);
			if($TotalRecord%$Limit) {
				$Hal++;
			}
	
			echo "Total : <strong>".$TotalRecord."</strong> record(s) :: ";
			echo "Page : ";
	
			for ($k = 1;$k <= $Hal;$k++) {
				$newpg = $Limit*($k-1);
				if($Pg != $newpg) {
					print " <a href=\"?pg=".$newpg."\" title=\"page ".$k."\" class=\"normallink\">".$k."</a> \n";
				} else {
					print " <strong>[$k]</strong> ";
				}
			}
			?>
			<?php
			$sList		 = "SELECT * FROM tilyan_".$sFolder."_lookup_code3 ORDER BY CodeName LIMIT $Pg, $Limit";
	
			$SQLList	 = mysql_query($sList) or die(mysql_errno()." : ".mysql_error());
			?></p>
			<table width="100%" align="center" cellpadding="2" cellspacing="2" border="0">
				<thead>
				<tr>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">Code Name</th>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">Description</th>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">Contract No</th>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">Contract Value</th>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">Start Date</th>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">End Date</th>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">Status</th>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">Action</th>
				</tr>
				</thead>
				<?php
				if (mysql_num_rows($SQLList) == 0) {
				?>
				<tbody>
				<tr align="center">
					<td align="center" colspan="8"><strong>no records found</strong></td>
				</tr>
				</tbody>
				<?php
				} else {
				  	$i		= $Pg+1;
					$bgcolor = "#336699";

				  	while($oList = mysql_fetch_object($SQLList)) {
						if (empty($oList->Status)) {
							$sBgColor	= "#6492A1";
							$sStatusWords = "not active";
						} else {
							$sBgColor	= "";
							$sStatusWords = "active";
						}
				?>
				<tbody>
				<tr>
					<td style="bgtext-align:center; border-bottom:1px solid #990000;"><?php echo $oList->CodeName?></td>
					<td style="border-bottom:1px solid #990000;"><?php echo nl2br($oList->CodeDesc)?></td>
					<td style="text-align:center; border-bottom:1px solid #990000;"><?php echo $oList->ContractNo?></td>
					<td style="text-align:center; border-bottom:1px solid #990000;"><?php echo $oList->ContractValue?></td>
					<td style="text-align:right; border-bottom:1px solid #990000;"><?php echo ViewDateTimeFormat($oList->StartDate, 6); ?></td>
					<td style="text-align:right; border-bottom:1px solid #990000;"><?php echo ViewDateTimeFormat($oList->EndDate, 6); ?><!-- - <?php echo $aDateDifference[days_total]; ?>//--></td>
					<td style="text-align:center; border-bottom:1px solid #990000;"><?php echo $sStatusWords?></td>
					<td style="text-align:center; border-bottom:1px solid #990000;"><a href="lookupcode3edit.php?lid=<?php echo $oList->ID?>&id=<?php echo $iCoID?>" class="normalbiglink" title="click to edit">edit</a> | <a href="javascript:Delete(<?php echo $iCoID?>,<?php echo $oList->ID?>)" class="normalbiglink" title="delete this from listing">delete</a></td>
				</tr>
				</tbody>
				<?php
						if ($bgcolor == "#336699") { $bgcolor = "#85a6d3"; } else { $bgcolor = "#336699"; }
						$i++;
				  	}
				}
				?>
			</table>
            <p></p>
            </div>
        </div>

        <div class="bottom" style="float:left; margin-right: 33px; margin-bottom:6px;"></div>
	</div>
</body>
</html>
