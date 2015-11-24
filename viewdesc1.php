<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="Description" content="Tilyan">
        <meta name="Keywords" content="">
        <link rel="shortcut icon" href="images/favicon.ico">
        <title>tilyanPristka</title>
        <link rel="stylesheet" href="css/style.css" />
	</head>

    <body>
        <div class="other" style="margin-bottom:6px;">
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

$sCode1	= $_GET["val"];

$sSQLGetCode1	= mysql_query("SELECT CodeName, ContractNo, ContractValue, StartDate, EndDate FROM tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_code1 WHERE Status = '1' AND CodeName = '".$sCode1."'") or die(mysql_errno()." : ".mysql_error());

if(mysql_num_rows($sSQLGetCode1)!=0):
	while($oCode1 = mysql_fetch_object($sSQLGetCode1)) {
		$aDateDifferenceStart1	= dateDifference($oCode1->StartDate, $TahunHariIni."-".$BulanHariIni."-".$TanggalHariIni);
		$aDateDifferenceEnd1	= dateDifference($oCode1->EndDate, $TahunHariIni."-".$BulanHariIni."-".$TanggalHariIni);
		$StartDate1 			= strtotime($oCode1->StartDate); 
		$EndDate1 				= strtotime($oCode1->EndDate); 
		$CurrentDateLocal1		= strtotime($TahunHariIni."-".$BulanHariIni."-".$TanggalHariIni); 
		
		if ($StartDate1 > $CurrentDateLocal1) { 
			//StartDate is in the future
			$sDaysRemain1	= "Not Yet Started";
			$valid1 = "yes"; 
		} else { 
			//StartDate is in the past
			$valid1 = "no"; 
			if($EndDate1 > $CurrentDateLocal1) {
				//EndDate is in the future
				$aDateDifferenceEnd1	= dateDifference($oCode1->EndDate, $TahunHariIni."-".$BulanHariIni."-".$TanggalHariIni);
				$sDaysRemain1	= $aDateDifferenceEnd1[days_total]." day(s)";
				$valid1	= "e - yes";
			} else {
				//EndDate is in the past
				$sDaysRemain1	= "Already Overdue";
				$valid1	= "e - no";
			}
		}
		/*if($aDateDifferenceStart1<0):
			$sDayRemain = "Not Yet Begin";
		elseif($aDateDifferenceEnd1<):*/
?>
			<h3>Contract Detail for <?php echo $oCode1->CodeName?></h3>
            <div style="padding:8px; font-size:12px; line-height:18px;">
                <p><span style="padding-right:40px;">Contract No:</span> <?php echo $oCode1->ContractNo?></p>
                <p><span style="padding-right:23px;">Contract Value:</span> <?php echo $oCode1->ContractValue?></p>
                <p><span style="padding-right:50px;">Start Date:</span> <?php echo ViewDateTimeFormat($oCode1->StartDate,6)?></p>
                <p><span style="padding-right:56px;">End Date:</span> <?php echo ViewDateTimeFormat($oCode1->EndDate,6)?></p>
                <p><span style="padding-right:15px;">Days Remaining:</span> <?php echo $sDaysRemain1?></p>
			</div>
<?php
	}
else:
?>
			<h3>Contract Detail</h3>
            <div style="padding:8px; font-size:12px; line-height:18px;">
                <p>this type doesn't have any detail</p>
			</div>
<?php	
endif;
?>
		</div>
	</body>
</html>