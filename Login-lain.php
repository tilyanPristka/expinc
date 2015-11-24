<?php
include("inc.php");

$bError	= false;

if ($_POST['bSubmitted']) {
//	$iLanguage		= $_POST['Language'];

	if ($_POST["username"] == "" && $_POST["password"] == "") {
		$bError		= true;
	} else {
		$SQLCheck	= mysql_query("SELECT AdminID, Username, Password, FullName, LastLogin, Status FROM $Tb_Administrator WHERE Username = '".$_POST["username"]."' AND Password = md5('".$_POST["password"]."') AND active = '1'");

		if (mysql_num_rows($SQLCheck) == 0) {
			$bError	= true;
			mysql_query("INSERT INTO $Tb_AdminLog (DateModified, LogDescription, LogStatus, IPAddress) VALUES(now(), 'Login Failed. Username = (".$_POST['username'].") and Password = (".$_POST['password'].")', '0', '".$_SERVER["REMOTE_ADDR"]."')") or die(mysql_errno()." : ".mysql_error());
		} else {
			$DataList		= mysql_fetch_object($SQLCheck);

			$AdminID		= $DataList->AdminID;
			$AdminUsername	= $DataList->Username;
			$AdminFullName	= $DataList->FullName;
			$AdminLastLogin	= ViewDateTimeFormat($DataList->LastLogin, 2);
			$AdminStatus	= $DataList->Status;

			switch($AdminStatus) {
				case 1:
					$AdminStatusName = "Administrator";
					break;
				case 2:
					$AdminStatusName = "User";
					break;
				case 3:
					$AdminStatusName = "Others";
					break;
			}

/*			if ($iLanguage == 1) {
				$sLanguage = "ID";
			} else if ($iLanguage == 2) {
				$sLanguage = "EN";
			}
*/
			@session_start();
			@session_id();
			@session_register('TLY__AdminID');
			$_SESSION['TLY__AdminID']						= $AdminID;
			@session_register('TLY__AdminUsername');
			$_SESSION['TLY__AdminUsername']					= $AdminUsername;
			@session_register('TLY__AdminFullName');
			$_SESSION['TLY__AdminFullName']					= $AdminFullName;
			@session_register('TLY__AdminLastLogin');
			$_SESSION['TLY__AdminLastLogin']				= $AdminLastLogin;
			@session_register('TLY__AdminStatus');
			$_SESSION['TLY__AdminStatus']					= $AdminStatus;
			@session_register('TLY__AdminStatusName');	
			$_SESSION['TLY__AdminStatusName']				= $AdminStatusName;
/*			@session_register('MM__Language');
			$_SESSION['MM__Language']					= $sLanguage;
*/
			/* Get Permission */
			$SQLAdminPermission	= mysql_query("SELECT PermissionID FROM $Tb_AdminPermission WHERE AdminID = '".$AdminID."'") or die(mysql_errno()." : ".mysql_error());

			while ($oAdminPermission = mysql_fetch_object($SQLAdminPermission)) {
				$SQLPermission	= mysql_query("SELECT PermissionName FROM $Tb_Permission WHERE PermissionID = '".$oAdminPermission->PermissionID."'") or die(mysql_errno()." : ".mysql_error());

				if ($oPermission = mysql_fetch_object($SQLPermission)) {
					@session_register($oPermission->PermissionName);
					$_SESSION[$oPermission->PermissionName] = true;
				}
			}

			mysql_query("INSERT INTO $Tb_AdminLog (DateModified, LogDescription, LogStatus, IPAddress) VALUES(now(), 'Login Success. Username = (".$_POST['username'].")', '1', '".$_SERVER["REMOTE_ADDR"]."')") or die(mysql_errno()." : ".mysql_error());
			/* Update LastLogin */
			@mysql_query("UPDATE $Tb_Administrator SET LastLogin = now() WHERE AdminID = '".$AdminID."'");

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
<title><?=$Site_Name?> :: Admin Site</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="scripts/global.js"></script>
</head>

<body onLoad="document.frmLogin.username.focus();">
        <div id="main">
    
            <div class="main_logo" style="float:right; margin-right: 33px; margin-bottom:6px;">
            
            </div>
            <div class="basic" style="float:left; margin-left: 2em;" id="mylist">
                <a>Login Page</a>
                <div style="background-color:#FFF;">
                    <p>
                        Welcome to Tilyan Pristka's Member Site.<br />
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi laoreet nulla at turpis pulvinar sed laoreet arcu rutrum. Quisque sollicitudin, nibh quis congue dictum, dolor.
<center>
 			<form name="frmLogin" method="post" action="">
			<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
 			<table width="350" cellpadding="0" cellspacing="0" border="0" align="center">
				<?php
				if ($bError == true) {
				?>
				<tr valign="top">
					<td width="20"></td>
					<td style="padding-left:10px;" align="center">
						[Authentication failed. Please try again.]
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
                    <p></p>
                </div>
            </div>
    
        </div>
</body>
</html>