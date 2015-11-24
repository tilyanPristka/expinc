<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

$TodayDate = getdate();
//for current date
$TanggalHariIni		= $TodayDate[mday];
if(strlen($TanggalHariIni)==1):
	$TanggalHariIni = "0".$TanggalHariIni;
endif;
$BulanHariIni		= $TodayDate[mon];
if(strlen($BulanHariIni)==1):
	$BulanHariIni = "0".$BulanHariIni;
endif;
$TahunHariIni		= $TodayDate[year];


$sHour		= $TodayDate[hours]-1;
if($sHour==-1):
	$sHour = 23;
endif;
$sMinute	= $TodayDate[minutes];
$sTime		= $sHour.$sMinute;

$bError		= false;
$PilihTanggal	= $_POST['d'];
$PilihBulan		= $_POST['m'];
$PilihTahun		= $_POST['y'];

if($PilihTanggal==""):
	$PilihTanggal = $TodayDate[mday];
else:
	$PilihTanggal = $_POST['d'];
endif;
if($PilihBulan==""):
	$PilihBulan = $TodayDate[mon];
else:
	$PilihBulan = $_POST['m'];
endif;
if($PilihTahun==""):
	$PilihTahun = $TodayDate[year];
else:
	$PilihTahun = $_POST['y'];
endif;
$sMessage	= "";

if ($_POST['bSubmitted']):
	$sType			= TrimString($_POST['sType']);
	$sInOut			= TrimString($_POST['sInOut']);
	/*$sCode		= TrimString($_POST['sCode']);
	if(empty($sCode)):
		$sCode	= "tP";
	endif;*/
	$sCode1			= TrimString($_POST['sCode1']);
	$sCode2			= TrimString($_POST['sCode2']);
	$sCode3			= TrimString($_POST['sCode3']);
	$sFolder		= $_SESSION['TLY__MemberFolder'];
	$sNickName		= $_SESSION['TLY__MemberNickName'];
	$dtDocRealDate	= TrimString($_POST['dtDocRealDate']);
	
	/*//check current doc no
	$sSQLCheck		= mysql_query("SELECT DocNo FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document WHERE DocMonth = ".$PilihBulan." AND DocYear = ".$PilihTahun." ORDER BY DocNo DESC LIMIT 0,1") or die(mysql_errno()." : ".mysql_error());;

	if($oCheck 	= mysql_fetch_object($sSQLCheck)):
		//$Row_Check 	= mysql_fetch_object($sSQLCheck);
		$iDocNo		= $oCheck->DocNo;
		
		$iNewDocNo	= $iDocNo+1;
	else:
		$iNewDocNo	= 1;	
	endif;
	
	//create DocNo as formated
	$iJmlDocNo	= strlen($iNewDocNo);
	if($iJmlDocNo==1):
		$iFormatedDocNo		= "000".$iNewDocNo."";
	elseif($iJmlDocNo==2):
		$iFormatedDocNo		= "00".$iNewDocNo."";
	elseif($iJmlDocNo==3):
		$iFormatedDocNo		= "0".$iNewDocNo."";
	elseif($iJmlDocNo==4):
		$iFormatedDocNo		= $iNewDocNo;
	endif; */

	//create Month as formated
	$iJmlMonth	= strlen($PilihBulan);
	if($iJmlMonth==1):
		$sFormatedMonth		= "0".$PilihBulan."";
	elseif($iJmlMonth==2):
		$sFormatedMonth		= $PilihBulan;
	endif;
	
	//create Date as formated
	$iJmlDate	= strlen($PilihTanggal);
	if($iJmlDate==1):
		$sFormatedDate		= "0".$PilihTanggal."";
	elseif($iJmlDate==2):
		$sFormatedDate		= $PilihTanggal;
	endif;
	
	/*//create Hour as formated
	$iJmlHour	= strlen($sHour);
	if($iJmlHour==1):
		$sFormatedHour		= "0".$sHour."";
	elseif($iJmlHour==2):
		$sFormatedHour		= $sHour;
	endif;
	
	//create Minute as formated
	$iJmlMinute	= strlen($sMinute);
	if($iJmlMinute==1):
		$sFormatedMinute	= "0".$sMinute."";
	elseif($iJmlMinute==2):
		$sFormatedMinute	= $sMinute;
	endif;
	$sTime		= $sFormatedHour.$sFormatedMinute;*/
	$sDocDate	= $PilihTahun."-".$sFormatedMonth."-".$sFormatedDate;
	
	//$sDocFullNo = strtoupper($sFolder).".".$sType.".".$sInOut.".".strtoupper($sNickName).".".$sCode.".".$PilihTahun.".".$sFormatedMonth.".".$sTime.".".$iFormatedDocNo;
	//$sDocFullNo = strtoupper($sFolder).".".$sType.".".$sInOut.".".strtoupper($sNickName).".".$sCode.".".$PilihTahun.".".$sFormatedMonth;
	$sDocFullNo = strtoupper($sFolder).".".$sType.".".$sInOut.".".strtoupper($sNickName).".".$sCode1."";
	if($sCode2!=""):
		$sDocFullNo = $sDocFullNo.".".$sCode2;
	endif;
	
	if($sCode3!=""):
		$sDocFullNo = $sDocFullNo.".".$sCode3.".".$PilihTahun.".".$sFormatedMonth;
	else:
		$sDocFullNo = $sDocFullNo.".".$PilihTahun.".".$sFormatedMonth;
	endif;
	
	//mysql_query("INSERT INTO tilyan_".$sFolder."_document (DocDate,DocFullNo,DocFolder,DocType,DocInOut,DocNickName,DocCode,DocYear,DocMonth,DocTime,DocNo) VALUES ('".$sDocDate."','".$sDocFullNo."','".$sFolder."','".$sType."','".$sInOut."','".$sNickName."','".$sCode."','".$PilihTahun."','".$PilihBulan."','".$sTime."','".$iNewDocNo."')") or die(mysql_errno()." : ".mysql_error());
	mysql_query("INSERT INTO tilyan_".$sFolder."_document (DocRealDate,DocDate,DocFullNo,DocFolder,DocType,DocInOut,DocNickName,DocCode,DocCode2,DocCode3,DocYear,DocMonth) VALUES ('".$dtDocRealDate."','".$sDocDate."','".$sDocFullNo."','".$sFolder."','".$sType."','".$sInOut."','".$sNickName."','".$sCode1."','".$sCode2."','".$sCode3."','".$PilihTahun."','".$PilihBulan."')") or die(mysql_errno()." : ".mysql_error());
	//get current doc id
	$sSQLGetID		= mysql_query("SELECT DocID, DocRealDate, DocDate, DocFullNo, DocYear, DocMonth FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document WHERE DocFullNo = '".$sDocFullNo."' LIMIT 0,1") or die(mysql_errno()." : ".mysql_error());;

	if($oGetID 	= mysql_fetch_object($sSQLGetID)):
		$iFwdDocID			= $oGetID->DocID;
		$sFwdDocRealDate	= $oGetID->DocRealDate;
		$sFwdDocDate		= $oGetID->DocDate;
		$sFwdDocFullNo		= $oGetID->DocFullNo;
		$iFwdTahun			= $oGetID->DocYear;
		$iFwdBulan			= $oGetID->DocMonth;
	endif;
	

	if($sType=="O"):
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=transactionaddother.php?id=".$iFwdDocID."&rdate=".$sFwdDocRealDate."&date=".$sFwdDocDate."&doc=".$sFwdDocFullNo."&y=".$iFwdTahun."&m=".$iFwdBulan."\">";
	else:
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=transactionadd.php?id=".$iFwdDocID."&rdate=".$sFwdDocRealDate."&date=".$sFwdDocDate."&doc=".$sFwdDocFullNo."&y=".$iFwdTahun."&m=".$iFwdBulan."\">";
	endif;
	exit();
	
endif;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="Description" content="Tilyan">
        <meta name="Keywords" content="">
        <link rel="shortcut icon" href="images/favicon.ico">
        <title>tilyanPristka</title>

        <script type="text/javascript">
			function ViewDesc1() {
				var f = document.ArticleFrm;
				code1 = eval('f.sCode1.value');
				window.open('viewdesc1.php?val=' + code1, "view_desc1", "width=250,height=150,top=100,left=100,scrollbars=no,resizable=no,status=no", false);
			}
			function ViewDesc2() {
				var f = document.ArticleFrm;
				code2 = eval('f.sCode2.value');
				window.open('viewdesc2.php?val=' + code2, "view_desc2", "width=250,height=150,top=100,left=100,scrollbars=no,resizable=no,status=no", false);
			}
			function ViewDesc3() {
				var f = document.ArticleFrm;
				code3 = eval('f.sCode3.value');
				window.open('viewdesc3.php?val=' + code3, "view_desc3", "width=250,height=150,top=100,left=100,scrollbars=no,resizable=no,status=no", false);
			}
		</script>
        <link rel="stylesheet" href="css/style.css" />
	</head>

    <body>
    
        <div class="other" style="margin-bottom:6px;">
        	<div id="one" class="jGrowl top-right2"></div>
        	<div id="two" class="jGrowl top-right3"></div>
        	<h3>Create New Document | <a href="documentlist.php" class="normaltitlelink">Document List</a></h3>
            <p>&nbsp;</p>
			<?php
			if($_SESSION["TLY__Permission"]==2):
			?>
			<p style="font-size:12px; font-weight:bold; color:#990000; padding-left:6px;">Sorry, <?php echo $_SESSION["TLY__MemberName"]?>. You don't have permission to Create Document.<br />Please <a href="documentlist.php?" style="text-decoration:none;">click here to view the Document List</a>. Thank You.</p>
            <?php
			else:
			?>
            <p><center>
            <form name="ArticleFrm" id="ArticleFrm" action="<?php echo $_SERVER['PHP_SELF']."?"?>" method="post">
			<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
			<table width="95%" cellpadding="2" cellspacing="3" border="0" align="center" class="OSStyle">
				<?php	if ($bError) { ?>
				<tr>
					<td colspan="2"><font color="#FF0000"><strong><?php echo $sMessage?></strong></font></td>
				</tr>
				<?php	} ?>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sType"><strong>Type:</strong></label></td>
					<td>
						<select name="sType" id="sType" class="SELECT">
							<option value="C">Cash</option>
							<option value="B">Bank</option>
							<option value="O">Other</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sInOut"><strong>In / Out:</strong></label></td>
					<td>
						<select name="sInOut" id="sInOut" class="SELECT">
							<option value="I">In</option>
							<option value="O">Out</option>
						</select>
					</td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sCode1"><strong>Code I:</strong></label></td>
					<td>
						<!-- <input type="text" name="sCode" id="sCode" size="4" value="<?php echo $sCode?>" /> <font color="#990000"><strong> *) Leave blank to get the default value (tP).</strong></font> //-->
                        <select onchange="GetPullDownValue1();" name="sCode1" id="sCode1" class="SELECT" style="width:53px;">
                        	<option value="tP"<?php if($sCode1 == "tP") { echo " selected"; }?>>tP</option>
						<?php
						$sSQLGetCode1	= mysql_query("SELECT CodeName, CodeDesc FROM tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_code1 WHERE Status = '1' ORDER BY CodeName") or die(mysql_errno()." : ".mysql_error());

						if(mysql_num_rows($sSQLGetCode1)!=0):
							while($oCode1 = mysql_fetch_object($sSQLGetCode1)) {
						?>
                            <option value="<?php echo $oCode1->CodeName?>"<?php if($sCode1 == $oCode1->CodeName) { echo " selected"; }?>><?php echo $oCode1->CodeName?> - <?php echo $oCode1->CodeDesc?></option>
						<?php
							}
						endif;
						?>
                        </select>&nbsp;&nbsp;<a href="javascript:ViewDesc1();"><strong>view contract detail</strong></a>
					</td>
				</tr>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sCode2"><strong>Code II:</strong></label></td>
					<td>
						<!-- <input type="text" name="sCode" id="sCode" size="4" value="<?php echo $sCode?>" /> <font color="#990000"><strong> *) Leave blank to get the default value (tP).</strong></font> //-->
                        <select onchange="GetPullDownValue2();" name="sCode2" id="sCode2" class="SELECT" style="width:53px;">
                            <option value=""<?php if($sCode2 == "") { echo " selected"; }?>></option>
						<?php
						$sSQLGetCode2	= mysql_query("SELECT CodeName, CodeDesc FROM tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_code2 WHERE Status = '1' ORDER BY CodeName") or die(mysql_errno()." : ".mysql_error());

						if(mysql_num_rows($sSQLGetCode2)!=0):
							while($oCode2 = mysql_fetch_object($sSQLGetCode2)) {
						?>
                            <option value="<?php echo $oCode2->CodeName?>"<?php if($sCode2 == $oCode2->CodeName) { echo " selected"; }?>><?php echo $oCode2->CodeName?> - <?php echo $oCode2->CodeDesc?></option>
						<?php
							}
						endif;
						?>
                        </select>&nbsp;&nbsp;<a href="javascript:ViewDesc2();"><strong>view contract detail</strong></a>
					</td>
				</tr>
                <?php
				if($_SESSION['TLY__LUC3Active']==1):
				?>
				<tr>
					<td style="width: 150px;" class="FormTD"><label for="sCode2"><strong>Code III:</strong></label></td>
					<td>
                        <select onchange="GetPullDownValue3();" name="sCode3" id="sCode3" class="SELECT" style="width:53px;">
                            <option value=""<?php if($sCode3 == "") { echo " selected"; }?>></option>
						<?php
						$sSQLGetCode3	= mysql_query("SELECT CodeName, CodeDesc FROM tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_code3 WHERE Status = '1' ORDER BY CodeName") or die(mysql_errno()." : ".mysql_error());

						if(mysql_num_rows($sSQLGetCode3)!=0):
							while($oCode3 = mysql_fetch_object($sSQLGetCode3)) {
						?>
                            <option value="<?php echo $oCode3->CodeName?>"<?php if($sCode3 == $oCode3->CodeName) { echo " selected"; }?>><?php echo $oCode3->CodeName?> - <?php echo $oCode3->CodeDesc?></option>
						<?php
							}
						endif;
						?>
                        </select>&nbsp;&nbsp;<a href="javascript:ViewDesc3();"><strong>view contract detail</strong></a>
					</td>
				</tr>
                <?php
				endif;
				?>
				<tr>
					<td style="width: 150px;" class="FormTD"><strong>Trans/Doc. Date:</strong></td>
					<td>
                        <select name="d" id="d" class="SELECT">
                            <option selected="selected">Day</option>
                            <?php
                            for ($day = 1; $day <= 31; $day++) {
                                if (strlen($day)==1):
                                    echo "<option value=0".$day." ";
                                else:
                                    echo "<option value=".$day." ";
                                endif;
                            
                                if ($PilihTanggal==$day) {echo " SELECTED";}
                                echo ">$day</option>\n";
                            }
                            ?>
                        </select> -  
                        <select name="m" id="m" class="SELECT">
                            <option selected="selected">Month</option>
                            <?php
                            for ($month = 1; $month <= 12; $month++) {
                                if (strlen($month)==1):
                                    echo "<option value=0".$month." ";
                                else:
                                    echo "<option value=".$month." ";
                                endif;
                            
                                if ($PilihBulan==$month) {echo " SELECTED";}
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
                        </select> - 
                        <select name="y" id="select3" class="SELECT">
                            <option selected="selected">Year</option>
                            <?php
                            $currentYear = date("y");
                            for ($year = 2000; $year <= $TodayDate[year]; $year++) {
                                echo "<option";
                                if ($PilihTahun==$year) {echo " SELECTED";}
                                echo ">$year</option>\n";
                            }
                            ?>
                        </select>&nbsp;
                        
					</td>
				</tr>
				<tr>
					<td style="width: 150px; height: 25px;" class="FormTD"><strong>Input Date:</strong></td>
					<td>
						<strong><?php echo ViewDateTimeFormat($TahunHariIni."-".$BulanHariIni."-".$TanggalHariIni, 6); ?></strong>
						<input type="hidden" name="dtDocRealDate" id="dtDocRealDate" value="<?php echo $TahunHariIni."-".$BulanHariIni."-".$TanggalHariIni?>"
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" name="bnSubmit" id="bnSubmit" value="Create Document">&nbsp;&nbsp;<input type="reset" name="bnReset" id="bnReset" value="Reset" /></td>
				</tr>
			</table>
			</form>
            </center></p>
			<?php
			endif;
			?>
            <p></p>
        
        </div>

    </body>
</html>
