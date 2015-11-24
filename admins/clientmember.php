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
	endif;
endif;

$iCP_ID		= $_GET["cpid"];
$sAct		= $_GET["act"];
if($sAct=="del" && !empty($iCP_ID)):
	//delete
	mysql_query("DELETE FROM tilyan_membersperson WHERE CP_ID = '".$iCP_ID."'") or die(mysql_error());
	mysql_query("optimize table tilyan_membersperson") or die(mysql_errno()." : ".mysql_error());
	
	echo "<meta http-equiv=\"refresh\" content=\"0;URL=clientmember.php?id=".$iCoID."\">";
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
function Delete(iID,iCPID) {
	if (confirm('You are about to delete one of the available Clients.\nAre you sure ?')) { document.location.href = 'clientmember.php?id='+ iID +'&cpid='+iCPID+'&act=del'; }
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
                            <p><button onclick="javascript:document.location.href = 'ClientMemberAdd.php?id=<?php echo $iCoID?>';">Add New Personel</button>&nbsp;&nbsp;<button onclick="javascript:document.location.href = 'index.php?';">Return To Index</button></p>
						</td>
					</tr>
				</table>
            </div>
            <a>Client's Personel</a>
            <div style="background-color:#FFF;">
			<?php
			/* Paginate */
			$Pg			= $_GET["pg"];
			$Limit		= 10;
	
			if(empty($Pg)) {
				$Pg = 0;
			}
	
			$sPaging		 = "SELECT CP_ID FROM tilyan_membersperson WHERE CoID = ".$iCoID."";
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
			$sList		 = "SELECT * FROM tilyan_membersperson WHERE CoID = ".$iCoID." LIMIT $Pg, $Limit";
	
			$SQLList	 = mysql_query($sList) or die(mysql_errno()." : ".mysql_error());
			?></p>
			<table width="100%" align="center" cellpadding="2" cellspacing="2" border="0">
				<thead>
				<tr>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">Fullname</th>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">NickName</th>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">Permission</th>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">Last Login</th>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">Username</th>
					<th style="background-color:#b7cae8; color:#000000; text-align:center;">Action</th>
				</tr>
				</thead>
				<?php
				if (mysql_num_rows($SQLList) == 0) {
				?>
				<tbody>
				<tr align="center">
					<td align="center" colspan="6"><strong>no records found</strong></td>
				</tr>
				</tbody>
				<?php
				} else {
				  	$i		= $Pg+1;
					$bgcolor = "#336699";

				  	while($oList = mysql_fetch_object($SQLList)) {
						if (empty($oList->CP_Enabled)) {
							$sBgColor	= "#6492A1";
							$sStatusWords = "not active";
						} else {
							$sBgColor	= "";
							$sStatusWords = "active";
						}
						if (empty($oList->CP_LastLogin)) {
							$sLastLogin = "have not logged in yet";
						} else {
							$sLastLogin = $oList->CP_LastLogin;
						}
						if($oList->CP_Permission==1):
							$sPermissionText = "Data Entry";
						elseif ($oList->CP_Permission==2):
							$sPermissionText = "Supervisor";
						else:
							$sPermissionText = "All";
						endif;
				?>
				<tbody>
				<tr>
					<td style="bgtext-align:center; border-bottom:1px solid #990000;"><?php echo $oList->CP_Fullname?></td>
					<td style="border-bottom:1px solid #990000;"><?php echo $oList->CP_NickName?></td>
					<td style="border-bottom:1px solid #990000;"><?php echo $sPermissionText?></td>
					<td style="text-align:center; border-bottom:1px solid #990000;"><?php echo $sLastLogin?></td>
					<td style="text-align:center; border-bottom:1px solid #990000;"><?php echo $oList->CP_User?></td>
					<td style="text-align:center; border-bottom:1px solid #990000;"><a href="clientmemberedit.php?id=<?php echo $oList->CoID?>&cpid=<?php echo $oList->CP_ID?>" class="normalbiglink" title="click to edit">edit</a> | <a href="javascript:Delete(<?php echo $oList->CoID?>,<?php echo $oList->CP_ID?>)" class="normalbiglink" title="delete this from listing">delete</a></td>
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
