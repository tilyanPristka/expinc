<?php
include("inc.php");

$bError	= false;

if ($_POST['bSubmitted']) {
//	$iLanguage		= $_POST['Language'];

	if ($_POST["username"] == "" && $_POST["password"] == "") {
		$bError		= true;
	} else {
		$SQLCheck	= mysql_query("SELECT cp.CoID, cp.CP_ID, cp.CP_NickName, cp.CP_Fullname, cp.CP_User, cp.CP_LastLogin, cp.CP_Permission, co.CoLogo, co.CoFolder FROM tilyan_membersperson cp, tilyan_members co WHERE cp.CoID = co.CoID AND cp.CP_User = '".$_POST["username"]."' AND cp.CP_Pass = '".$_POST["password"]."' AND cp.CP_Enabled = '1'");
	
		if (mysql_num_rows($SQLCheck) == 0) {
			$bError	= true;
			//mysql_query("INSERT INTO $Tb_MemberLog (LogDate, CoID, LogStatus, IPAddress) VALUES(now(), 'Login Failed. Username = (".$_POST['username'].") and Password = (".$_POST['password'].")', '0', '".$_SERVER["REMOTE_ADDR"]."')") or die(mysql_errno()." : ".mysql_error());
		} else {
			$DataList		= mysql_fetch_object($SQLCheck);

			$MemberID		= $DataList->CoID;
			$PersonID		= $DataList->CP_ID;
			$MemberUser		= $DataList->CP_User;
			$MemberName		= $DataList->CP_Fullname;
			$NickName		= $DataList->CP_NickName;
			$FolderName		= $DataList->CoFolder;
			$Logo			= $DataList->CoLogo;
			$LastLogin		= $DataList->CP_LastLogin;
			$Permission		= $DataList->CP_Permission;
			if($Permission==1):
				$sPermissionText = "Data Entry";
			elseif($Permission==2):
				$sPermissionText = "Supervisor";
			elseif($Permission==3):
				$sPermissionText = "All";
			endif;
			
			//check if lookupcode3 is active
			$SQLCheckLUC3	= mysql_query("SELECT CoID, TableName FROM tilyan_memberstable WHERE CoID = ".$MemberID." AND TableName = 'tilyan_".$FolderName."_lookup_code3'");
			if (mysql_num_rows($SQLCheckLUC3) == 0) {
				$iLUC3Active = 0;
			} else {
				$iLUC3Active = 1;
			}
			//check set visible
			$sSQLVisible = mysql_query("SELECT * FROM tilyan_switch WHERE CoFolder = '".$FolderName."'");
			if (mysql_num_rows($sSQLVisible) != 0):
				$SetVisible	= mysql_fetch_object($sSQLVisible);
				
				$iDocFolder		= $SetVisible->DocFolder;
				$iDocNickName	= $SetVisible->DocNickName;
				$iDocTime		= $SetVisible->DocTime;
			else:
				$iDocFolder		= 0;
				$iDocNickName	= 0;
				$iDocTime		= 0;
			endif;
			

			@session_start();
			@session_id();
			@session_register('TLY__MemberID');
			$_SESSION['TLY__MemberID']						= $MemberID;
			@session_register('TLY__PersonID');
			$_SESSION['TLY__PersonID']						= $PersonID;
			@session_register('TLY__MemberUser');
			$_SESSION['TLY__MemberUser']					= $MemberUser;
			@session_register('TLY__MemberName');
			$_SESSION['TLY__MemberName']					= $MemberName;
			@session_register('TLY__MemberNickName');	
			$_SESSION['TLY__MemberNickName']				= $NickName;
			@session_register('TLY__MemberFolder');	
			$_SESSION['TLY__MemberFolder']					= $FolderName;
			@session_register('TLY__Logo');	
			$_SESSION['TLY__Logo']							= $Logo;
			@session_register('TLY__LastLogin');	
			$_SESSION['TLY__LastLogin']						= $LastLogin;
			@session_register('TLY__Permission');	
			$_SESSION['TLY__Permission']					= $Permission;
			@session_register('TLY__PermissionText');	
			$_SESSION['TLY__PermissionText']				= $sPermissionText;
			@session_register('TLY__LUC3Active');	
			$_SESSION['TLY__LUC3Active']					= $iLUC3Active;
			@session_register('TLY__VisibleFolder');	
			$_SESSION['TLY__VisibleFolder']					= $iDocFolder;
			@session_register('TLY__VisibleNickName');	
			$_SESSION['TLY__VisibleNickName']				= $iDocNickName;
			@session_register('TLY__VisibleTime');	
			$_SESSION['TLY__VisibleTime']					= $iDocTime;
			
			mysql_query("INSERT INTO tilyan_memberspersonlog (LogDate, CoID, CP_ID) VALUES(now(), ".$_SESSION['TLY__MemberID'].", ".$_SESSION['TLY__PersonID'].")") or die(mysql_errno()." : ".mysql_error());
			/* Update LastLogin */
			@mysql_query("UPDATE tilyan_membersperson SET CP_LastLogin = now() WHERE CP_ID = '".$_SESSION['TLY__PersonID']."'");

			unset($SQLCheck);

			echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?\">";
			exit();
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $Site_Name?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="scripts/global.js"></script>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
</head>

<body onLoad="document.frmLogin.username.focus();">
        <div id="main">
    
            <div class="main_logo" style="float:right; margin-right: 33px; margin-bottom:6px;">
            
            </div>
            <div class="basic" style="float:left; margin-left: 2em;" id="mylist">
                <a>Login Page</a>
                <div style="background-color:#FFF;">
                    <p>
                    <center>
					Welcome to <span class="tPtext">tilyanPristka</span> - BPO System Support For Accounting Environment.<br />
					Please login to your company's area and check the latest report.
                    </center>
                    
<center>
 			<form name="frmLogin" method="post" action="">
			<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
 			<table width="350" cellpadding="0" cellspacing="0" border="0" align="center">
				<?php
				if ($bError == true) {
				?>
				<tr valign="top">
					<td width="20"></td>
					<td style="padding-left:10px; color:#990000; font-size:12; font-weight:bold;" align="center">
						<p>[Authentication failed. Please try again.]</p>
					</td>
					<td width="10"></td>
				</tr>
				<?php
				}
				?>
				<tr valign="top">
					<td width="20"></td>
					<td style="padding-left:10px;" align="center">
						<br><strong>Username: </strong><input name="username" type="text" class="form" id="username" size="30"><br>
					</td>
					<td width="10"></td>
				</tr>
				<tr valign="top">
					<td width="20"></td>
					<td style="padding-left:10px;" align="center">
						<br><strong>Password: </strong><input name="password" type="password" class="form" id="password" size="30"><br>
					</td>
					<td width="10"></td>
				</tr>
				<tr valign="top">
					<td width="20"></td>
					<td style="padding-right:20px;" align="right"><br><input type="submit" name="bnSubmit" id="bnSubmit" value="Login" style="width:100px; border: 1px solid #000000;"></td>
					<td width="10"></td>
				</tr>
				<tr valign="top">
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
			</form>
</center>
                    </p>
                    <p align="center">forget your password? <a href="forgetpass.php?" class="normallink">click here</a></p>
                </div>
            </div>
    
        </div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="">
  <tr>
    <td>
    <center>
    <!-- GeoTrust QuickSSL [tm] Smart  Icon tag. Do not edit. -->
	<SCRIPT LANGUAGE="JavaScript"  TYPE="text/javascript"  
	SRC="//smarticon.geotrust.com/si.js"></SCRIPT>
	<!-- end  GeoTrust Smart Icon tag -->
	</center>
  </td>
  </tr>
</table>
<center>         

</center>
</body>
</html>