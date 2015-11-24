<?php
include("inc.php");

$bError	= false;

if ($_POST['bSubmitted']) {
//	$iLanguage		= $_POST['Language'];
	$sErrorMsg = "";

	if ($_POST["emailadd"] == "") {
		$bError		= true;
		$sErrorMsg 	= "Please Enter Your Email Address";
	} else {
		$SQLCheck	= mysql_query("SELECT CoUser, CoPass, CoEmail FROM $Tb_Members WHERE CoEmail = '".$_POST["emailadd"]."'");

		if (mysql_num_rows($SQLCheck) == 0) {
			$bError	= true;
			$sErrorMsg	= "Sorry, We couldn't find your email address in our system. Enter the correct email address or contact our Administrator";
			//mysql_query("INSERT INTO $Tb_MemberLog (LogDate, CoID, LogStatus, IPAddress) VALUES(now(), 'Login Failed. Username = (".$_POST['username'].") and Password = (".$_POST['password'].")', '0', '".$_SERVER["REMOTE_ADDR"]."')") or die(mysql_errno()." : ".mysql_error());
		} else {
			$DataList		= mysql_fetch_object($SQLCheck);

			$MemberUser		= $DataList->CoUser;
			$MemberPass		= $DataList->CoPass;
			$MemberEmail	= $DataList->CoEmail;

			//Declarate the necessary variables
			$mail_to=$MemberEmail;
			$mail_from="no-reply@tpo.co.in";
			$mail_sub="Your Account at tpo.co.in";
			$mail_mesg="This is your password for your current account @ tpo.co.in\n\n";
			$mail_mesg.="Username: ".$MemberUser."\n";
			$mail_mesg.="Password: ".$MemberPass."\n\n";
			$mail_mesg.="Please change your password once you have successfully login to tpo.co.in.\n\n\n";
			$mail_mesg.="===============\n";
			$mail_mesg.="This is a system based email. Please do not reply this email.\n";

		//Check for success/failure of delivery
		if(mail($mail_to,$mail_sub,$mail_mesg,"From:$mail_from")):
			$sSuccessMsg = "Email has been sent successfully. Check your email.";
		else:
			$sSuccessMsg = "Failed to send the Email. Contact our Administrator";
		endif;

		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$Site_Name?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="scripts/global.js"></script>
</head>

<body onLoad="document.frmLogin.username.focus();">
        <div id="main">
    
            <div class="main_logo" style="float:right; margin-right: 33px; margin-bottom:6px;">
            
            </div>
            <div class="basic" style="float:left; margin-left: 2em;" id="mylist">
                <a>Forget Password</a>
                <div style="background-color:#FFF;">
                    <p>
                        You forget your password??<br />
                        Use the form below to retrieve your password. Just fill out your email address associated with us, and we will send your password straight to your email.
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
						<p>[<?=$sErrorMsg?>]</p>
					</td>
					<td width="10"></td>
				</tr>
				<?php
				}
				?>
				<?php
				if (!empty($sSuccessMsg)) {
				?>
				<tr valign="top">
					<td width="20"></td>
					<td style="padding-left:10px; color:#990000; font-size:12; font-weight:bold;" align="center">
						<p>[<?=$sSuccessMsg?>]</p>
					</td>
					<td width="10"></td>
				</tr>
				<?php
				}
				?>
				<tr valign="top">
					<td width="20"></td>
					<td style="padding-left:10px;" align="center">
						<br><strong>Email Address: </strong><input name="emailadd" type="text" class="form" id="emailadd" size="30"><br>
					</td>
					<td width="10"></td>
				</tr>
				<tr valign="top">
					<td width="20"></td>
					<td style="padding-right:20px;" align="right"><br><input type="submit" name="bnSubmit" id="bnSubmit" value="Send Password" style="width:120px; border: 1px solid #000000;"></td>
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
                    <p align="center"><a href="index.php?" class="normallink">return to main page</a></p>
                </div>
            </div>
    
        </div>
</body>
</html>