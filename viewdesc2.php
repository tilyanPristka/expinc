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

$sCode2	= $_GET["val"];

$sSQLGetCode2	= mysql_query("SELECT CodeName, ContractNo, ContractValue, StartDate, EndDate FROM tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_code2 WHERE Status = '1' AND CodeName = '".$sCode2."'") or die(mysql_errno()." : ".mysql_error());

if(mysql_num_rows($sSQLGetCode2)!=0):
	while($oCode2 = mysql_fetch_object($sSQLGetCode2)) {
		$aDateDifferenceStart2	= dateDifference($oCode2->StartDate, $TahunHariIni."-".$BulanHariIni."-".$TanggalHariIni);
		$aDateDifferenceEnd2	= dateDifference($oCode2->EndDate, $TahunHariIni."-".$BulanHariIni."-".$TanggalHariIni);
		$StartDate2 			= strtotime($oCode1->StartDate); 
		$EndDate2 				= strtotime($oCode1->EndDate); 
		$CurrentDateLocal2		= strtotime($TahunHariIni."-".$BulanHariIni."-".$TanggalHariIni); 
		
		if ($StartDate2 > $CurrentDateLocal2) { 
			//StartDate is in the future
			$sDaysRemain2	= "Not Yet Started";
			$valid1 = "yes"; 
		} else { 
			//StartDate is in the past
			$valid2 = "no"; 
			if($EndDate2 > $CurrentDateLocal2) {
				//EndDate is in the future
				$aDateDifferenceEnd2	= dateDifference($oCode2->EndDate, $TahunHariIni."-".$BulanHariIni."-".$TanggalHariIni);
				$sDaysRemain2	= $aDateDifferenceEnd2[days_total]." day(s)";
				$valid2	= "e - yes";
			} else {
				//EndDate is in the past
				$sDaysRemain2	= "Already Overdue";
				$valid2	= "e - no";
			}
		}
		/*if($aDateDifferenceStart1<0):
			$sDayRemain = "Not Yet Begin";
		elseif($aDateDifferenceEnd1<):*/
?>
			<h3>Contract Detail for <?php echo $oCode2->CodeName?></h3>
            <div style="padding:8px; font-size:12px; line-height:18px;">
                <p><span style="padding-right:40px;">Contract No:</span> <?php echo $oCode2->ContractNo?></p>
                <p><span style="padding-right:23px;">Contract Value:</span> <?php echo $oCode2->ContractValue?></p>
                <p><span style="padding-right:50px;">Start Date:</span> <?php echo ViewDateTimeFormat($oCode2->StartDate,6)?></p>
                <p><span style="padding-right:56px;">End Date:</span> <?php echo ViewDateTimeFormat($oCode2->EndDate,6)?></p>
                <p><span style="padding-right:15px;">Days Remaining:</span> <?php echo $sDaysRemain2?></p>
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