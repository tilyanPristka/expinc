<?php
@session_start();

include("inc.php");
//include("../spaw/spaw.inc.php");
//$spaw1 = new SpawEditor("spaw1");

CheckAuthentication();
CheckPermission('members');

$bError		= false;
$sMessage	= "";

if ($_POST['bSubmitted']) {
	$sCoName					= TrimString($_POST['sCoName']);
	$sCoAddress					= TrimString($_POST['sCoAddress']);
	$sCoUser					= TrimString($_POST['sCoUser']);
	$sCoPass					= TrimString($_POST['sCoPass']);
	$eEnabled					= $_POST['eEnabled'];
	$sFolder					= TrimString($_POST['sFolder']);
	$sCoEmail					= TrimString($_POST['sCoEmail']);
	
	$gmblogo=$HTTP_POST_FILES["sLogo"]["name"];
	$tmpgmblogo=$HTTP_POST_FILES["sLogo"]["tmp_name"];
	$gmblogosize=$HTTP_POST_VARS["sLogo"]["size"];
	$gmblogotype=$HTTP_POST_VARS["sLogo"]["type"];	
	$logo_old=$_POST["logo_old"];
	
	if (empty($sCoName)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Company Name<br />";
	}

	if (empty($sCoAddress)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Company Address<br />";
	}

	if (empty($sCoUser)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Username<br />";
	}

	if (empty($sCoPass)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Password<br />";
	}

	if (empty($sFolder)) {
		$bError		 = true;
		$sMessage	.= ". Please provide Folder<br />";
	}

	if (!$bError) {
		if (empty($_GET['id'])) {
			/* INSERT */
			mysql_query("INSERT INTO $Tb_Members (CoName, CoAddress, CoUser, CoPass, CoEnabled, CoFolder, CoEmail) VALUES ('".$sCoName."', '".$sCoAddress."', '".$sCoUser."', '".$sCoPass."', '".$eEnabled."', '".$sFolder."', '".$sCoEmail."')") or die(mysql_errno()." : ".mysql_error());
		} else {
			/* UPDATE */
			mysql_query("UPDATE $Tb_Members SET CoName = '".$sCoName."', CoAddress = '".$sCoAddress."', CoUser = '".$sCoUser."', CoPass = '".$sCoPass."', CoEnabled = '".$eEnabled."', CoFolder = '".$sFolder."', CoEmail = '".$sCoEmail."' WHERE CoID = '".$_GET['id']."'") or die(mysql_errno()." : ".mysql_error());
		}

		$SQLGetID	= mysql_query("SELECT * FROM $Tb_Members WHERE CoUser = '".$_POST['sCoUser']."' AND CoName = '". $_POST['sCoName']."'") or die(mysql_errno()." : ".mysql_error());
	
		if ($oGetID = mysql_fetch_object($SQLGetID)) {
			$iNewID		= $oGetID->CoID;
		} else {
			$iNewID		= 0;
		}

		//$filedir = 'pics/'; // the directory for the original image
		//$thumbdir = 'pics/'; // the directory for the thumbnail image
		//$prefix = 'small_'; // the prefix to be added to the original name
		
		$maxfile = '50000000';
		$mode = '0666';
		
		if ($gmblogo==""):
			$gmblogonya="";
		else:
			$gmblogonya="".str_replace(" ","_",$sCoName)."_".$gmblogo;
			$gmblogonya = str_replace(" ","_",$gmblogonya);
		endif;

		if ($gmblogo !="") {
			//copy ($tmpgmbthumb, "../../collections/".$gmbthumbnya) or die("Could not copy thumbnail image file");
			//copy ($tmpgmbthumb, "users/".$HTTP_COOKIE_VARS["YMMLthewebsite_MemberID"]."/".base64_decode($HTTP_GET_VARS["cg"])."/".$gmbthumbnya) or die("Could not copy thumbnail image file");
			//copy ($tmpgmbthumb, "users/".$HTTP_COOKIE_VARS["YMMLthewebsite_MemberID"]."/".$gmbthumbnya) or die("Could not copy thumbnail image file");
		
			//start resizing high
			//$prod_img = $filedir.$userfile_name;
			$prod_img = "../uploads/originals/logo/".$gmblogonya;
		
			//$prod_img_thumb = $thumbdir.$prefix.$userfile_name;
			$prod_img_high= "../uploads/logo/".$gmblogonya;
			//move_uploaded_file($userfile_tmp, $prod_img);
			move_uploaded_file($tmpgmblogo, $prod_img);
			chmod ($prod_img, octdec($mode));
			
			$sizes = getimagesize($prod_img);
			$oriwidth = $sizes[0];
			$oriheight = $sizes[1];
			
			if($oriwidth>$oriheight){
				//image is landscape
				if($oriheight>=75){
					$startresize=1;
					$newheight=75;
				} else {
					$startresize=0;
					$newheight=oriheight;

				}
			} elseif($oriwidth<$oriheight) {
				//image is potrait
				if($oriheight>=192){
					$startresize=1;
					$newheight=192;
				} else {
					$startresize=0;
					$newheight=$oriheight;
				}
			}
			/*echo "temp=".$tmpgmbthumb."<br />";
			echo "prod=".$prod_img."<br />";
			echo "ori width=".$oriwidth."<br />";
			echo "ori height=".$oriheight."<br />";
			echo "startresize=".$startresize."<br />";
			echo "new width=".$newheight."<br />";
			echo "=============================<br />";*/
			//exit();
		
			if($startresize==1){
				$aspect_ratio = $sizes[1]/$sizes[0]; 
			
				//if ($sizes[1] <= $size)
				//{
				//	$new_width = $sizes[0];
				//	$new_height = $sizes[1];
				//}else{
					$new_height = $newheight;
					$new_width = abs($new_height/$aspect_ratio);
				//}
			
				$destimg=ImageCreateTrueColor($new_width,$new_height)
					or die('Problem In Creating image');
				$srcimg=ImageCreateFromJPEG($prod_img)
					or die('Problem In opening Source Image');
				if(function_exists('imagecopyresampled'))
				{
					imagecopyresampled($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg))
					or die('Problem In resizing');
				}else{
					Imagecopyresized($destimg,$srcimg,0,0,0,0,$new_width,$new_height,ImageSX($srcimg),ImageSY($srcimg))
					or die('Problem In resizing');
				}
				ImageJPEG($destimg,$prod_img_high,90)
					or die('Problem In saving');
				imagedestroy($destimg);
				//end resizing high
			} else {
				rename($prod_img, "../uploads/logo/".$gmblogonya);
				//move_uploaded_file ($tmpgmbthumb, "users/".$HTTP_COOKIE_VARS["YMMLthewebsite_MemberID"]."/".$NewGalleryCatID."/".$gmbthumbnya);
			}

		}			
		unlink($prod_img);

		if($gmblogonya!=""){
			$logo_old = $gmblogonya;
		}

		mysql_query("UPDATE $Tb_Members SET CoLogo = '".$logo_old."' WHERE CoID = '".$iNewID."'") or die(mysql_errno()." : ".mysql_error());

		echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php\">";
		exit();

	}
} else {
	if (!empty($_GET['id'])) {
		$SQLEdit	= mysql_query("SELECT * FROM $Tb_Members WHERE CoID = '".$_GET['id']."'") or die(mysql_errno()." : ".mysql_error());
	
		if ($oEdit = mysql_fetch_object($SQLEdit)) {
			$sCoName			= stripslashes($oEdit->CoName);
			$sCoAddress			= stripslashes($oEdit->CoAddress);
			$sCoUser			= stripslashes($oEdit->CoUser);
			$sCoPass			= stripslashes($oEdit->CoPass);
			$sFolder			= stripslashes($oEdit->CoFolder);
			$sCoEmail			= stripslashes($oEdit->CoEmail);
			$eEnabled			= stripslashes($oEdit->CoEnabled);
			$sLogo				= stripslashes($oEdit->CoLogo);
		}
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
function Delete(iID) {
	if (confirm('You are about to delete one of the available Client.\nAre you sure ?')) { document.location.href = 'index.php?id='+ iID +'&act=del'; }
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
            <a>Client's Edit</a>
            <div style="background-color:#FFF;">

			<form name="ArticleFrm" id="ArticleFrm" action="<?php echo $_SERVER['PHP_SELF']."?id=".$_GET['id'].""?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
			<table width="95%" cellpadding="2" cellspacing="3" border="0" align="center" class="OSStyle">
				<?	if ($bError) { ?>
				<tr>
					<td colspan="2"><font color="#FF0000"><strong><?php echo $sMessage?></strong></font></td>
				</tr>
				<?	} ?>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sCoUser"><strong>Username:</strong></label></td>
					<td><input type="text" name="sCoUser" id="sCoUser" size="35" value="<?php echo $sCoUser?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sCoPass"><strong>Password:</strong></label></td>
					<td><input type="text" name="sCoPass" id="sCoPass" size="35" value="<?php echo $sCoPass?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sFolder"><strong>Folder:</strong></label></td>
					<td><input type="text" name="sFolder" id="sFolder" size="35" value="<?php echo $sFolder?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sCoEmail"><strong>Email:</strong></label></td>
					<td><input type="text" name="sCoEmail" id="sCoEmail" size="35" value="<?php echo $sCoEmail?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sCoName"><strong>Company Name:</strong></label></td>
					<td><input type="text" name="sCoName" id="sCoName" size="35" value="<?php echo $sCoName?>" /></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sCoAddress"><strong>Company Address:</strong></label></td>
					<td><textarea name="sCoAddress" id="sCoAddress" style="width:95%;" rows="5"><?php echo $sCoAddress?></textarea></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD" valign="top"><label for="sLogo"><strong>Logo:</strong></label></td>
					<td>
						<input type="file" name="sLogo" />
						<?php
							if (!empty($_GET['id'])) { 
								if ($sLogo == "") {
									echo "<p><strong>No Image Uploaded!</strong></p>";
								} else {
						?>
							<p><img src="../uploads/logo/<?php echo $sLogo?>" /><br />
							<input type="hidden" name="logo_old" id="logo_old" value="<?php echo $sLogo?>"></p>
						<?php
								}
							}
						?>
					</td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="eStatus"><strong>Active:</strong></label></td>
					<td><input type="checkbox" name="eEnabled" id="eEnabled" value="1" <?php echo ($eEnabled == 1) ? "checked" : ""?>></td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="eStatus"><strong>Client's Table:</strong></label></td>
					<td>
                    	<ul>
						<?php
							$Row_Document 	= mysql_query("SELECT * FROM tilyan_memberstable WHERE CoID = '".$_GET['id']."' AND TableName = 'tilyan_".$sFolder."_document'");
							$iDocCount		= mysql_num_rows($Row_Document);
							if($iDocCount==0):
								echo "<li>&raquo;&nbsp;<a href=\"createtabledocument.php?id=".$_GET["id"]."&nm=".$sFolder."\" class=\"normalbiglink\">Create Table Document</a></li>";
							else:
								echo "<li><strong>Table Document has been created</strong></li>";
							endif;
						?>
						<?php
							$Row_Account 	= mysql_query("SELECT * FROM tilyan_memberstable WHERE CoID = '".$_GET['id']."' AND TableName = 'tilyan_".$sFolder."_account'");
							$iAccCount		= mysql_num_rows($Row_Account);
							if($iAccCount==0):
								echo "<li>&raquo;&nbsp;<a href=\"createtableaccount.php?id=".$_GET["id"]."&nm=".$sFolder."\" class=\"normalbiglink\">Create Table Account</a></li>";
							else:
								echo "<li><strong>Table Account has been created</strong></li>";
							endif;
						?>
						<?php
							$Row_Account 	= mysql_query("SELECT * FROM tilyan_memberstable WHERE CoID = '".$_GET['id']."' AND TableName = 'tilyan_".$sFolder."_lookup_account'");
							$iAccCount		= mysql_num_rows($Row_Account);
							if($iAccCount==0):
								echo "<li>&raquo;&nbsp;<a href=\"createtbllookupacct.php?id=".$_GET["id"]."&nm=".$sFolder."\" class=\"normalbiglink\">Create Table LookUp Account</a></li>";
							else:
								echo "<li><a href=\"lookupacctlist.php?id=".$_GET["id"]."\" class=\"normalbiglink\">Add Entry For Table LookUp Account</a></li>";
							endif;
						?>
						<?php
							$Row_Account 	= mysql_query("SELECT * FROM tilyan_memberstable WHERE CoID = '".$_GET['id']."' AND TableName = 'tilyan_".$sFolder."_lookup_code1'");
							$iAccCount		= mysql_num_rows($Row_Account);
							if($iAccCount==0):
								echo "<li>&raquo;&nbsp;<a href=\"createtbllookupcode1.php?id=".$_GET["id"]."&nm=".$sFolder."\" class=\"normalbiglink\">Create Table LookUp Code I</a></li>";
							else:
								echo "<li><a href=\"lookupcode1list.php?id=".$_GET["id"]."\" class=\"normalbiglink\">Add Entry For Table LookUp Code I</a></li>";
							endif;
						?>
						<?php
							$Row_Account 	= mysql_query("SELECT * FROM tilyan_memberstable WHERE CoID = '".$_GET['id']."' AND TableName = 'tilyan_".$sFolder."_lookup_code2'");
							$iAccCount		= mysql_num_rows($Row_Account);
							if($iAccCount==0):
								echo "<li>&raquo;&nbsp;<a href=\"createtbllookupcode2.php?id=".$_GET["id"]."&nm=".$sFolder."\" class=\"normalbiglink\">Create Table LookUp Code II</a></li>";
							else:
								echo "<li><a href=\"lookupcode2list.php?id=".$_GET["id"]."\" class=\"normalbiglink\">Add Entry For Table LookUp Code II</a></li>";
							endif;
						?>
                        </ul>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="bnSubmit" id="bnSubmit" value="<?php echo (!empty($_GET['id']) ? "Update" : "Save")?>">&nbsp;&nbsp;<input type="button" name="bnCancel" id="bnCancel" value="Cancel" onClick="Cancel('index.php?');"><?php if (!empty($_GET['id'])) { ?>&nbsp;&nbsp;<input type="button" name="bnDelete" id="bnDelete" value="Delete" onClick="Delete(<?php echo $_GET['id']?>)"><?php } ?></td>
				</tr>
			</table>
			</form>


            </div>
        </div>

        <div class="bottom" style="float:left; margin-right: 33px; margin-bottom:6px;"></div>
	</div>
</body>
</html>
