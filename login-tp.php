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

			echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://tilyanpristka.co.id/tp/index.php?\">";
			exit();
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>tilyanPristka - Financial and Accounting Payroll Tax Business Process Outsourcing Company</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="css/stylelog.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="scripts/global.js"></script>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/scripts.js"></script> 
<script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
</head>
<body onLoad="document.frmLogin.username.focus();">
<!--[if IE]>
<center>For your convienience and in order to get the maximum result, it is better if you use Mozilla Firefox or Safari browser. Thank you.</center>
<![endif]-->

<div id="main">
	<div id="bahasa">Choose your language:<img alt="" src="images/spacer.gif" width="8" height="1"><img src="images/eng.gif" alt="" width="13" height="8" border="0" ><img alt="" src="images/spacer.gif" width="4" height="1"><img alt="" src="images/spacer.gif" width="4" height="1"><a href="index-ind.php"><img src="images/ind.gif" alt="" width="13" height="8" border="0" ></a></div>
  <div id="header">
	<div id="logo"></div>
    <div id="tuv"></div>
  </div>
  <!-- end div#header -->
   <div id="header_gallery">
   
      	  <ul id="MenuBar1" class="MenuBarHorizontal">
    	  <li><a class="active" href="index.php"><h1>home</h1></a>   	    </li>
   	    
        <li><a href="#" class="MenuBarItemSubmenu">
   	    <h1>about us</h1></a>
   	      <ul>
            <li><a href="tp_company.php">company</a></li>
            <li><a href="tp_accuracy.php">accuracy &amp; reliability</a></li>
            <li><a href="tp_benefits.php">benefits</a></li>
            <li><a href="tp_whyus.php">why tP</a></li>
   	      </ul>
   	    </li>
        
        <li><a class="MenuBarItemSubmenu" href="#">
    	  <h1>download</h1></a>
    	    <ul>
    	      <li><a href="download/tP_CompanyProfile.pdf">company profile</a></li>
    	      <li><a href="download/tP_ServicesDetail.pdf">services detail</a></li>
              <li><a href="download/tP_ClientSetupForm-CompanyDetail.pdf">company detail form</a></li>
              <li><a href="download/tP_ClientSetupForm-EmployeeDetail.pdf">employee detail form</a></li>
    	    </ul>
  	    </li>
        
          <li><a href="tp_contact.php"><h1>contact us</h1></a></li>
          <li><a href=""><h1>client area</h1></a></li>
   	  </ul></div>

  <div id="page">
  
  <div id="banner"></div>

  	
    	<div id="sidebar">
        <iframe src="http://www.facebook.com/plugins/likebox.php?id=127341393972741&amp;width=200&amp;stream=true&amp;header=true&amp;height=447" scrolling="yes" frameborder="0" style="border:none; overflow:hidden; width:200px; height:460px;" allowTransparency="true"></iframe>
      </div>
      <!-- end div#sidebar -->
    
      <div id="content_index">
        <div class="post">
          <div class="rightcontent_index">LOGIN PAGE</div>

            <div class="basic" style="float:left; margin-left: 2em;" id="mylist">
                
                    <p>
                    <center>
					Welcome to <span class="tPtext">tilyanPristka</span> - BPO System Support For Accounting Environment.<br />
					Please login to your company's area and check the latest report.
                    </center>
                    
<center>
 			<form name="frmLogin" method="post" action="">
			  <input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
			</p>
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
					<td style="padding-left:10px; font-size:11px" align="center">
					<br><strong>Username: </strong><input name="username" type="text" class="form" id="username" size="30"><br />
					</td>
					<td width="10"></td>
				</tr>
				<tr valign="top">
					<td width="20"></td>
					<td style="padding-left:10px; font-size:11px" align="center">
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
                    <p align="center">forget your password? <a href="forgetpass1.php?" class="normallink">click here</a></p>
        <p align="center">           
    
               
            </div>
                 <div id="geo">
    <!-- GeoTrust QuickSSL [tm] Smart  Icon tag. Do not edit. -->
	<SCRIPT LANGUAGE="JavaScript"  TYPE="text/javascript"  
	SRC="//smarticon.geotrust.com/si.js"></SCRIPT>
	<!-- end  GeoTrust Smart Icon tag -->
	</div>
        </div>



    </div>

      <div id="news">
<script src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'search',
  search: 'business process outsourcing OR bpo OR accounting OR tax OR payroll OR finance OR alih OR daya OR pajak OR from:PajakMania OR from:infopp',
  interval: 4000,
  title: '',
  subject: 'tilyanPristka',
  width: 204,
  height: 355,
  theme: {
    shell: {
      background: '#333333',
      color: '#ffffff'
    },
    tweets: {
      background: '#cccccc',
      color: '#333333',
      links: '#92013b'
    }
  },
  features: {
    scrollbar: false,
    loop: true,
    live: true,
    hashtags: true,
    timestamp: true,
    avatars: true,
    toptweets: true,
    behavior: 'default'
  }
}).render().start();
</script>
</div>
</div>
      <!-- end div#content -->
      
      <div style="clear: both; height: 1px"></div>
  </div>
<div id="clear"></div>
  <!-- end div#page -->
  <div id="footer1">
    Copyright 2007-2012 PT.Tilyanpristka</div>
  <!-- end div#footer -->
<!-- end div#main -->
<!-- end div#wrapper -->
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>