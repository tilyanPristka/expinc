<?php
@session_start();

include("inc.php");
CheckMemberAuthentication();

$bError		= false;
$TodayDate = getdate();

$db		= $_GET['db'];
$de		= $_GET['de'];
$b		= $_GET['b'];
//echo "b = ".$b."<br />";
$c		= $_GET['c'];
//echo "c = ".$c."<br />";
$oth	= $_GET['oth'];
//echo "oth = ".$oth."<br />";
$in		= $_GET['in'];
//echo "in = ".$in."<br />";
$out	= $_GET['out'];
//echo "out = ".$out."<br />";
$adjed	= $_GET['adjed'];
//echo "adjed = ".$adjed."<br />";
$adj	= $_GET['adj'];
//echo "adj = ".$adj."<br />";
$print	= $_GET['print'];
//echo "print = ".$print."<br />";
$desc	= $_GET['desc'];
//echo "desc = ".$desc."<br />";
$code1	= $_GET['code1'];
//echo "code1 = ".$code1."<br />";
$code2	= $_GET['code2'];
//echo "code2 = ".$code2."<br />";
$code3	= $_GET['code3'];
//echo "code3 = ".$code3."<br />";
$nick	= $_GET['nick'];
//echo "nick = ".$nick."<br />";
$accno	= $_GET['accno'];
//echo "accno = ".$accno."<br />";


//select for Cash/Bank
//Cash-In
if($c==1 && $in==1):
//	$sSQLCashIn = "SELECT SUM(a.Amount) AS JumlahCashIn FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocType = 'C' AND d.DocInOut = 'I' AND la.Type = 'Cash/Bank'";
	$sSQLCashIn = "SELECT SUM(a.Amount) AS JumlahCashIn FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocType = 'C' AND d.DocInOut = 'I'";
	if(!empty($db) && !empty($db)):
		$sSQLCashIn		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
	endif;
	if(!empty($desc)):
		$sSQLCashIn		.= " AND a.Description LIKE = '%".$desc."%'";
	endif;
	if(!empty($code1)):
		$sSQLCashIn		.= " AND d.DocCode = '".$code1."'";
	endif;
	if($code2=="kosong"):
		$sSQLCashIn		.= " AND d.DocCode2 IS NULL";
	elseif(!empty($code2)):
		$sSQLCashIn		.= " AND d.DocCode2 = '".$code2."'";
	endif;
	if($code3=="kosong"):
		$sSQLCashIn		.= " AND d.DocCode3 IS NULL";
	elseif(!empty($code3)):
		$sSQLCashIn		.= " AND d.DocCode3 = '".$code3."'";
	endif;
	if(!empty($nick)):
		$sSQLCashIn		.= " AND d.DocNickName = '".$nick."'";
	endif;
	if(!empty($accno)):
		$sSQLCashIn		.= " AND a.AccNo = '".$accno."'";
	endif;
//	echo "sSQLCashIn = ".$sSQLCashIn."<br />";
	$SQLCashIn	= mysql_query($sSQLCashIn) or die(mysql_errno()." : ".mysql_error());
	while($oCashIn = mysql_fetch_object($SQLCashIn)) {
		if(!empty($oCashIn->JumlahCashIn)):
			$iCashInTotal	= $oCashIn->JumlahCashIn;
		else:
			$iCashInTotal	= 0;
		endif;
	}
else:
	$iCashInTotal = 0;
endif;
//echo "iCashInTotal = ".$iCashInTotal."<br />";
//Bank-In
if($b==1 && $in==1):
//	$sSQLBankIn = "SELECT SUM(a.Amount) AS JumlahBankIn FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocType = 'B' AND d.DocInOut = 'I' AND la.Type = 'Cash/Bank'";
	$sSQLBankIn = "SELECT SUM(a.Amount) AS JumlahBankIn FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocType = 'B' AND d.DocInOut = 'I'";
	if(!empty($db) && !empty($db)):
		$sSQLBankIn		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
	endif;
	if(!empty($desc)):
		$sSQLBankIn		.= " AND a.Description LIKE = '%".$desc."%'";
	endif;
	if(!empty($code1)):
		$sSQLBankIn		.= " AND d.DocCode = '".$code1."'";
	endif;
	if($code2=="kosong"):
		$sSQLBankIn		.= " AND d.DocCode2 IS NULL";
	elseif(!empty($code2)):
		$sSQLBankIn		.= " AND d.DocCode2 = '".$code2."'";
	endif;
	if($code3=="kosong"):
		$sSQLBankIn		.= " AND d.DocCode3 IS NULL";
	elseif(!empty($code3)):
		$sSQLBankIn		.= " AND d.DocCode3 = '".$code3."'";
	endif;
	if(!empty($nick)):
		$sSQLBankIn		.= " AND d.DocNickName = '".$nick."'";
	endif;
	if(!empty($accno)):
		$sSQLBankIn		.= " AND a.AccNo = '".$accno."'";
	endif;
//	echo "sSQLBankIn = ".$sSQLBankIn."<br />";
	$SQLBankIn	= mysql_query($sSQLBankIn) or die(mysql_errno()." : ".mysql_error());
	while($oBankIn = mysql_fetch_object($SQLBankIn)) {
		if(!empty($oBankIn->JumlahBankIn)):
			$iBankInTotal	= $oBankIn->JumlahBankIn;
		else:
			$iBankInTotal	= 0;
		endif;
	}
else:
	$iBankInTotal = 0;
endif;
//echo "iBankInTotal = ".$iBankInTotal."<br />";
//Cash-Out
if($c==1 && $out==1):
//	$sSQLCashOut = "SELECT SUM(a.Amount) AS JumlahCashOut FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocType = 'C' AND d.DocInOut = 'O' AND la.Type = 'Cash/Bank'";
	$sSQLCashOut = "SELECT SUM(a.Amount) AS JumlahCashOut FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocType = 'C' AND d.DocInOut = 'O'";
	if(!empty($db) && !empty($db)):
		$sSQLCashOut		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
	endif;
	if(!empty($desc)):
		$sSQLCashOut		.= " AND a.Description LIKE = '%".$desc."%'";
	endif;
	if(!empty($code1)):
		$sSQLCashOut		.= " AND d.DocCode = '".$code1."'";
	endif;
	if($code2=="kosong"):
		$sSQLCashOut		.= " AND d.DocCode2 IS NULL";
	elseif(!empty($code2)):
		$sSQLCashOut		.= " AND d.DocCode2 = '".$code2."'";
	endif;
	if($code3=="kosong"):
		$sSQLCashOut		.= " AND d.DocCode3 IS NULL";
	elseif(!empty($code3)):
		$sSQLCashOut		.= " AND d.DocCode3 = '".$code3."'";
	endif;
	if(!empty($nick)):
		$sSQLCashOut		.= " AND d.DocNickName = '".$nick."'";
	endif;
	if(!empty($accno)):
		$sSQLCashOut		.= " AND a.AccNo = '".$accno."'";
	endif;
//	echo "sSQLCashOut = ".$sSQLCashOut."<br />";
	$SQLCashOut	= mysql_query($sSQLCashOut) or die(mysql_errno()." : ".mysql_error());
	while($oCashOut = mysql_fetch_object($SQLCashOut)) {
		if(!empty($oCashOut->JumlahCashOut)):
			$iCashOutTotal	= $oCashOut->JumlahCashOut;
		else:
			$iCashOutTotal	= 0;
		endif;
	}
else:
	$iCashOutTotal = 0;
endif;
//echo "iCashOutTotal = ".$iCashOutTotal."<br />";
//Bank-Out
if($b==1 && $out==1):
//	$sSQLBankOut = "SELECT SUM(a.Amount) AS JumlahBankOut FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocType = 'B' AND d.DocInOut = 'O' AND la.Type = 'Cash/Bank'";
	$sSQLBankOut = "SELECT SUM(a.Amount) AS JumlahBankOut FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocType = 'B' AND d.DocInOut = 'O'";
	if(!empty($db) && !empty($db)):
		$sSQLBankOut		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
	endif;
	if(!empty($desc)):
		$sSQLBankOut		.= " AND a.Description LIKE = '%".$desc."%'";
	endif;
	if(!empty($code1)):
		$sSQLBankOut		.= " AND d.DocCode = '".$code1."'";
	endif;
	if($code2=="kosong"):
		$sSQLBankOut		.= " AND d.DocCode2 IS NULL";
	elseif(!empty($code2)):
		$sSQLBankOut		.= " AND d.DocCode2 = '".$code2."'";
	endif;
	if($code3=="kosong"):
		$sSQLBankOut		.= " AND d.DocCode3 IS NULL";
	elseif(!empty($code3)):
		$sSQLBankOut		.= " AND d.DocCode3 = '".$code3."'";
	endif;
	if(!empty($nick)):
		$sSQLBankOut		.= " AND d.DocNickName = '".$nick."'";
	endif;
	if(!empty($accno)):
		$sSQLBankOut		.= " AND a.AccNo = '".$accno."'";
	endif;
//	echo "sSQLBankOut = ".$sSQLBankOut."<br />";
	$SQLBankOut	= mysql_query($sSQLBankOut) or die(mysql_errno()." : ".mysql_error());
	while($oBankOut = mysql_fetch_object($SQLBankOut)) {
		if(!empty($oBankOut->JumlahBankOut)):
			$iBankOutTotal	= $oBankOut->JumlahBankOut;
		else:
			$iBankOutTotal	= 0;
		endif;
	}
else:
	$iBankOutTotal = 0;
endif;
//echo "iBankOutTotal = ".$iBankOutTotal."<br />";
$iTotalCashBank = ($iCashInTotal+$iBankInTotal)-($iCashOutTotal+$iBankOutTotal);
//echo "iTotalCashBank = ".$iTotalCashBank."<br />";
$sSQLCashBankList = "SELECT d.DocDate, d.DocFullNo, d.DocNo, d.DocTime, d.DocMonth, d.DocYear, d.DocCode, d.DocCode2, d.DocCode3, d.DocNickName, d.DocInOut, d.DocType, d.DocADJ, d.DocFolder, a.AccNo, a.AccName, a.Description, a.Amount FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID";
if(!empty($db) && !empty($db)):
	$sSQLCashBankList		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
endif;
if($b==0 && $c==0 && $oth==0):
	$sSQLCashBankList	.= " AND d.DocType NOT IN('B','C','O')";
elseif($b==1 && $c==1 && $oth==1):
	$sSQLCashBankList	.= " AND d.DocType IN('B','C','O')";
elseif($b==1 && $c==1):
	$sSQLCashBankList	.= " AND d.DocType IN('B','C')";
elseif($b==0 && $oth==1):
	$sSQLCashBankList	.= " AND d.DocType IN('B','O')";
elseif($c==1 && $oth==1):
	$sSQLCashBankList	.= " AND d.DocType IN('C','O')";
elseif($b==1):
	$sSQLCashBankList	.= " AND d.DocType IN('B')";
elseif($c==1):
	$sSQLCashBankList	.= " AND d.DocType IN('C')";
elseif($oth==1):
	$sSQLCashBankList	.= " AND d.DocType IN('O')";
endif;
if($in==0 && $out==0):
	$sSQLCashBankList	.= " AND d.DocInOut NOT IN('I','O')";
elseif($in==1 && $out==1):
	$sSQLCashBankList	.= " AND d.DocInOut IN('I','O')";
elseif($in==1):
	$sSQLCashBankList	.= " AND d.DocInOut IN('I')";
elseif($out==1):
	$sSQLCashBankList	.= " AND d.DocInOut IN('O')";
endif;
if(!empty($desc)):
	$sSQLCashBankList		.= " AND a.Description LIKE = '%".$desc."%'";
endif;
if(!empty($code1)):
	$sSQLCashBankList		.= " AND d.DocCode = '".$code1."'";
endif;
if($code2=="kosong"):
	$sSQLCashBankList		.= " AND d.DocCode2 IS NULL";
elseif(!empty($code2)):
	$sSQLCashBankList		.= " AND d.DocCode2 = '".$code2."'";
endif;
if($code3=="kosong"):
	$sSQLCashBankList		.= " AND d.DocCode3 IS NULL";
elseif(!empty($code3)):
	$sSQLCashBankList		.= " AND d.DocCode3 = '".$code3."'";
endif;
if(!empty($nick)):
	$sSQLCashBankList		.= " AND d.DocNickName = '".$nick."'";
endif;
if(!empty($accno)):
	$sSQLCashBankList		.= " AND a.AccNo = '".$accno."'";
endif;
$sSQLCashBankList		.= " ORDER BY d.DocDate";

//echo "sSQLCashBankList = ".$sSQLCashBankList."<br />";

//select for Revenue
//All I
if($in==1):
	$sSQLRevenue = "SELECT SUM(a.Amount) AS JumlahRevenue FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocInOut = 'I' AND la.Type = 'Revenue'";
	if(!empty($db) && !empty($db)):
		$sSQLRevenue		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
	endif;
	if($b==0 && $c==0 && $oth==0):
		$sSQLRevenue	.= " AND d.DocType NOT IN('B','C','O')";
	elseif($b==1 && $c==1 && $oth==1):
		$sSQLRevenue	.= " AND d.DocType IN('B','C','O')";
	elseif($b==1 && $c==1):
		$sSQLRevenue	.= " AND d.DocType IN('B','C')";
	elseif($b==0 && $oth==1):
		$sSQLRevenue	.= " AND d.DocType IN('B','O')";
	elseif($c==1 && $oth==1):
		$sSQLRevenue	.= " AND d.DocType IN('C','O')";
	elseif($b==1):
		$sSQLRevenue	.= " AND d.DocType IN('B')";
	elseif($c==1):
		$sSQLRevenue	.= " AND d.DocType IN('C')";
	elseif($oth==1):
		$sSQLRevenue	.= " AND d.DocType IN('O')";
	endif;
	if(!empty($desc)):
		$sSQLRevenue		.= " AND a.Description LIKE = '%".$desc."%'";
	endif;
	if(!empty($code1)):
		$sSQLRevenue		.= " AND d.DocCode = '".$code1."'";
	endif;
	if($code2=="kosong"):
		$sSQLRevenue		.= " AND d.DocCode2 IS NULL";
	elseif(!empty($code2)):
		$sSQLRevenue		.= " AND d.DocCode2 = '".$code2."'";
	endif;
	if($code3=="kosong"):
		$sSQLRevenue		.= " AND d.DocCode3 IS NULL";
	elseif(!empty($code3)):
		$sSQLRevenue		.= " AND d.DocCode3 = '".$code3."'";
	endif;
	if(!empty($nick)):
		$sSQLRevenue		.= " AND d.DocNickName = '".$nick."'";
	endif;
	if(!empty($accno)):
		$sSQLRevenue		.= " AND a.AccNo = '".$accno."'";
	endif;
//	echo "sSQLRevenue = ".$sSQLRevenue."<br />";
	$SQLRevenue	= mysql_query($sSQLRevenue) or die(mysql_errno()." : ".mysql_error());
	while($oRevenue = mysql_fetch_object($SQLRevenue)) {
		if(!empty($oRevenue->JumlahRevenue)):
			$iRevenueTotal	= $oRevenue->JumlahRevenue;
		else:
			$iRevenueTotal	= 0;
		endif;
	}
	$iTotalRevenue = $iRevenueTotal;
else:
	$iTotalRevenue = 0;
endif;
//echo "iTotalRevenue = ".$iTotalRevenue."<br />";
$sSQLRevenueList = "SELECT d.DocDate, d.DocFullNo, d.DocNo, d.DocTime, d.DocMonth, d.DocYear, d.DocCode, d.DocCode2, d.DocCode3, d.DocNickName, d.DocInOut, d.DocType, d.DocADJ, d.DocFolder, a.AccNo, a.AccName, a.Description, a.Amount FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocInOut = 'I' AND la.Type = 'Revenue'";
if(!empty($db) && !empty($db)):
	$sSQLRevenueList		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
endif;
if($b==0 && $c==0 && $oth==0):
	$sSQLRevenueList	.= " AND d.DocType NOT IN('B','C','O')";
elseif($b==1 && $c==1 && $oth==1):
	$sSQLRevenueList	.= " AND d.DocType IN('B','C','O')";
elseif($b==1 && $c==1):
	$sSQLRevenueList	.= " AND d.DocType IN('B','C')";
elseif($b==0 && $oth==1):
	$sSQLRevenueList	.= " AND d.DocType IN('B','O')";
elseif($c==1 && $oth==1):
	$sSQLRevenueList	.= " AND d.DocType IN('C','O')";
elseif($b==1):
	$sSQLRevenueList	.= " AND d.DocType IN('B')";
elseif($c==1):
	$sSQLRevenueList	.= " AND d.DocType IN('C')";
elseif($oth==1):
	$sSQLRevenueList	.= " AND d.DocType IN('O')";
endif;
if(!empty($desc)):
	$sSQLRevenueList		.= " AND a.Description LIKE = '%".$desc."%'";
endif;
if(!empty($code1)):
	$sSQLRevenueList		.= " AND d.DocCode = '".$code1."'";
endif;
if($code2=="kosong"):
	$sSQLRevenueList		.= " AND d.DocCode2 IS NULL";
elseif(!empty($code2)):
	$sSQLRevenueList		.= " AND d.DocCode2 = '".$code2."'";
endif;
if($code3=="kosong"):
	$sSQLRevenueList		.= " AND d.DocCode3 IS NULL";
elseif(!empty($code3)):
	$sSQLRevenueList		.= " AND d.DocCode3 = '".$code3."'";
endif;
if(!empty($nick)):
	$sSQLRevenueList		.= " AND d.DocNickName = '".$nick."'";
endif;
if(!empty($accno)):
	$sSQLRevenueList		.= " AND a.AccNo = '".$accno."'";
endif;
$sSQLRevenueList		.= " ORDER BY d.DocDate";

//echo "sSQLRevenueList = ".$sSQLRevenueList."<br />";

//select for Cost of Goods Sold
//All O
if($out==1):
	$sSQLCGS = "SELECT SUM(a.Amount) AS JumlahCGS FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocInOut = 'O' AND la.Type = 'Cost of Goods Sold'";
	if(!empty($db) && !empty($db)):
		$sSQLCGS		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
	endif;
	if($b==0 && $c==0 && $oth==0):
		$sSQLCGS	.= " AND d.DocType NOT IN('B','C','O')";
	elseif($b==1 && $c==1 && $oth==1):
		$sSQLCGS	.= " AND d.DocType IN('B','C','O')";
	elseif($b==1 && $c==1):
		$sSQLCGS	.= " AND d.DocType IN('B','C')";
	elseif($b==0 && $oth==1):
		$sSQLCGS	.= " AND d.DocType IN('B','O')";
	elseif($c==1 && $oth==1):
		$sSQLCGS	.= " AND d.DocType IN('C','O')";
	elseif($b==1):
		$sSQLCGS	.= " AND d.DocType IN('B')";
	elseif($c==1):
		$sSQLCGS	.= " AND d.DocType IN('C')";
	elseif($oth==1):
		$sSQLCGS	.= " AND d.DocType IN('O')";
	endif;
	if(!empty($desc)):
		$sSQLCGS		.= " AND a.Description LIKE = '%".$desc."%'";
	endif;
	if(!empty($code1)):
		$sSQLCGS		.= " AND d.DocCode = '".$code1."'";
	endif;
	if($code2=="kosong"):
		$sSQLCGS		.= " AND d.DocCode2 IS NULL";
	elseif(!empty($code2)):
		$sSQLCGS		.= " AND d.DocCode2 = '".$code2."'";
	endif;
	if($code3=="kosong"):
		$sSQLCGS		.= " AND d.DocCode3 IS NULL";
	elseif(!empty($code3)):
		$sSQLCGS		.= " AND d.DocCode3 = '".$code3."'";
	endif;
	if(!empty($nick)):
		$sSQLCGS		.= " AND d.DocNickName = '".$nick."'";
	endif;
	if(!empty($accno)):
		$sSQLCGS		.= " AND a.AccNo = '".$accno."'";
	endif;
//	echo "sSQLCGS = ".$sSQLCGS."<br />";
	$SQLCGS	= mysql_query($sSQLCGS) or die(mysql_errno()." : ".mysql_error());
	while($oCGS = mysql_fetch_object($SQLCGS)) {
		if(!empty($oCGS->JumlahCGS)):
			$iCGSTotal	= $oCGS->JumlahCGS;
		else:
			$iCGSTotal	= 0;
		endif;
	}
	$iTotalCGS = $iCGSTotal;
else:
	$iTotalCGS = 0;
endif;
//echo "iTotalCGS = ".$iTotalCGS."<br />";
$sSQLCGSList = "SELECT d.DocDate, d.DocFullNo, d.DocNo, d.DocTime, d.DocMonth, d.DocYear, d.DocCode, d.DocCode2, d.DocCode3, d.DocNickName, d.DocInOut, d.DocType, d.DocADJ, d.DocFolder, a.AccNo, a.AccName, a.Description, a.Amount FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocInOut = 'O' AND la.Type = 'Cost of Goods Sold'";
if(!empty($db) && !empty($db)):
	$sSQLCGSList		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
endif;
if($b==0 && $c==0 && $oth==0):
	$sSQLCGSList	.= " AND d.DocType NOT IN('B','C','O')";
elseif($b==1 && $c==1 && $oth==1):
	$sSQLCGSList	.= " AND d.DocType IN('B','C','O')";
elseif($b==1 && $c==1):
	$sSQLCGSList	.= " AND d.DocType IN('B','C')";
elseif($b==0 && $oth==1):
	$sSQLCGSList	.= " AND d.DocType IN('B','O')";
elseif($c==1 && $oth==1):
	$sSQLCGSList	.= " AND d.DocType IN('C','O')";
elseif($b==1):
	$sSQLCGSList	.= " AND d.DocType IN('B')";
elseif($c==1):
	$sSQLCGSList	.= " AND d.DocType IN('C')";
elseif($oth==1):
	$sSQLCGSList	.= " AND d.DocType IN('O')";
endif;
if(!empty($desc)):
	$sSQLCGSList		.= " AND a.Description LIKE = '%".$desc."%'";
endif;
if(!empty($code1)):
	$sSQLCGSList		.= " AND d.DocCode = '".$code1."'";
endif;
if($code2=="kosong"):
	$sSQLCGSList		.= " AND d.DocCode2 IS NULL";
elseif(!empty($code2)):
	$sSQLCGSList		.= " AND d.DocCode2 = '".$code2."'";
endif;
if($code3=="kosong"):
	$sSQLCGSList		.= " AND d.DocCode3 IS NULL";
elseif(!empty($code3)):
	$sSQLCGSList		.= " AND d.DocCode3 = '".$code3."'";
endif;
if(!empty($nick)):
	$sSQLCGSList		.= " AND d.DocNickName = '".$nick."'";
endif;
if(!empty($accno)):
	$sSQLCGSList		.= " AND a.AccNo = '".$accno."'";
endif;
$sSQLCGSList		.= " ORDER BY d.DocDate";

//echo "sSQLCGSList = ".$sSQLCGSList."<br />";

//select for Expenses
//All O
if($out==1):
	$sSQLExpenses = "SELECT SUM(a.Amount) AS JumlahExpenses FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocInOut = 'O' AND la.Type = 'Expense'";
	if(!empty($db) && !empty($db)):
		$sSQLExpenses		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
	endif;
	if($b==0 && $c==0 && $oth==0):
		$sSQLExpenses	.= " AND d.DocType NOT IN('B','C','O')";
	elseif($b==1 && $c==1 && $oth==1):
		$sSQLExpenses	.= " AND d.DocType IN('B','C','O')";
	elseif($b==1 && $c==1):
		$sSQLExpenses	.= " AND d.DocType IN('B','C')";
	elseif($b==0 && $oth==1):
		$sSQLExpenses	.= " AND d.DocType IN('B','O')";
	elseif($c==1 && $oth==1):
		$sSQLExpenses	.= " AND d.DocType IN('C','O')";
	elseif($b==1):
		$sSQLExpenses	.= " AND d.DocType IN('B')";
	elseif($c==1):
		$sSQLExpenses	.= " AND d.DocType IN('C')";
	elseif($oth==1):
		$sSQLExpenses	.= " AND d.DocType IN('O')";
	endif;
	if(!empty($desc)):
		$sSQLExpenses		.= " AND a.Description LIKE = '%".$desc."%'";
	endif;
	if(!empty($code1)):
		$sSQLExpenses		.= " AND d.DocCode = '".$code1."'";
	endif;
	if($code2=="kosong"):
		$sSQLExpenses		.= " AND d.DocCode2 IS NULL";
	elseif(!empty($code2)):
		$sSQLExpenses		.= " AND d.DocCode2 = '".$code2."'";
	endif;
	if($code3=="kosong"):
		$sSQLExpenses		.= " AND d.DocCode3 IS NULL";
	elseif(!empty($code3)):
		$sSQLExpenses		.= " AND d.DocCode3 = '".$code3."'";
	endif;
	if(!empty($nick)):
		$sSQLExpenses		.= " AND d.DocNickName = '".$nick."'";
	endif;
	if(!empty($accno)):
		$sSQLExpenses		.= " AND a.AccNo = '".$accno."'";
	endif;
//	echo "sSQLExpenses = ".$sSQLExpenses."<br />";
	$SQLExpenses = mysql_query($sSQLExpenses) or die(mysql_errno()." : ".mysql_error());
	while($oExpenses = mysql_fetch_object($SQLExpenses)) {
		if(!empty($oExpenses->JumlahExpenses)):
			$iExpensesTotal	= $oExpenses->JumlahExpenses;
		else:
			$iExpensesTotal	= 0;
		endif;
	}
	$iTotalExpenses = $iExpensesTotal;
else:
	$iTotalExpenses = 0;
endif;
//echo "iTotalExpenses = ".$iTotalExpenses."<br />";
$sSQLExpensesList = "SELECT d.DocDate, d.DocFullNo, d.DocNo, d.DocTime, d.DocMonth, d.DocYear, d.DocCode, d.DocCode2, d.DocCode3, d.DocNickName, d.DocInOut, d.DocType, d.DocADJ, d.DocFolder, a.AccNo, a.AccName, a.Description, a.Amount FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocInOut = 'O' AND la.Type = 'Expense'";
if(!empty($db) && !empty($db)):
	$sSQLExpensesList		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
endif;
if($b==0 && $c==0 && $oth==0):
	$sSQLExpensesList	.= " AND d.DocType NOT IN('B','C','O')";
elseif($b==1 && $c==1 && $oth==1):
	$sSQLExpensesList	.= " AND d.DocType IN('B','C','O')";
elseif($b==1 && $c==1):
	$sSQLExpensesList	.= " AND d.DocType IN('B','C')";
elseif($b==0 && $oth==1):
	$sSQLExpensesList	.= " AND d.DocType IN('B','O')";
elseif($c==1 && $oth==1):
	$sSQLExpensesList	.= " AND d.DocType IN('C','O')";
elseif($b==1):
	$sSQLExpensesList	.= " AND d.DocType IN('B')";
elseif($c==1):
	$sSQLExpensesList	.= " AND d.DocType IN('C')";
elseif($oth==1):
	$sSQLExpensesList	.= " AND d.DocType IN('O')";
endif;
if(!empty($desc)):
	$sSQLExpensesList		.= " AND a.Description LIKE = '%".$desc."%'";
endif;
if(!empty($code1)):
	$sSQLExpensesList		.= " AND d.DocCode = '".$code1."'";
endif;
if($code2=="kosong"):
	$sSQLExpensesList		.= " AND d.DocCode2 IS NULL";
elseif(!empty($code2)):
	$sSQLExpensesList		.= " AND d.DocCode2 = '".$code2."'";
endif;
if($code3=="kosong"):
	$sSQLExpensesList		.= " AND d.DocCode3 IS NULL";
elseif(!empty($code3)):
	$sSQLExpensesList		.= " AND d.DocCode3 = '".$code3."'";
endif;
if(!empty($nick)):
	$sSQLExpensesList		.= " AND d.DocNickName = '".$nick."'";
endif;
if(!empty($accno)):
	$sSQLExpensesList		.= " AND a.AccNo = '".$accno."'";
endif;
$sSQLExpensesList		.= " ORDER BY d.DocDate";

//echo "sSQLExpensesList = ".$sSQLExpensesList."<br />";

//select for Other Income
//All I
if($in==1):
	$sSQLOtherIncome = "SELECT SUM(a.Amount) AS JumlahOtherIncome FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocInOut = 'I' AND la.Type = 'Other Income'";
	if(!empty($db) && !empty($db)):
		$sSQLOtherIncome		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
	endif;
	if($b==0 && $c==0 && $oth==0):
		$sSQLOtherIncome	.= " AND d.DocType NOT IN('B','C','O')";
	elseif($b==1 && $c==1 && $oth==1):
		$sSQLOtherIncome	.= " AND d.DocType IN('B','C','O')";
	elseif($b==1 && $c==1):
		$sSQLOtherIncome	.= " AND d.DocType IN('B','C')";
	elseif($b==0 && $oth==1):
		$sSQLOtherIncome	.= " AND d.DocType IN('B','O')";
	elseif($c==1 && $oth==1):
		$sSQLOtherIncome	.= " AND d.DocType IN('C','O')";
	elseif($b==1):
		$sSQLOtherIncome	.= " AND d.DocType IN('B')";
	elseif($c==1):
		$sSQLOtherIncome	.= " AND d.DocType IN('C')";
	elseif($oth==1):
		$sSQLOtherIncome	.= " AND d.DocType IN('O')";
	endif;
	if(!empty($desc)):
		$sSQLOtherIncome		.= " AND a.Description LIKE = '%".$desc."%'";
	endif;
	if(!empty($code1)):
		$sSQLOtherIncome		.= " AND d.DocCode = '".$code1."'";
	endif;
	if($code2=="kosong"):
		$sSQLOtherIncome		.= " AND d.DocCode2 IS NULL";
	elseif(!empty($code2)):
		$sSQLOtherIncome		.= " AND d.DocCode2 = '".$code2."'";
	endif;
	if($code3=="kosong"):
		$sSQLOtherIncome		.= " AND d.DocCode3 IS NULL";
	elseif(!empty($code3)):
		$sSQLOtherIncome		.= " AND d.DocCode3 = '".$code3."'";
	endif;
	if(!empty($nick)):
		$sSQLOtherIncome		.= " AND d.DocNickName = '".$nick."'";
	endif;
	if(!empty($accno)):
		$sSQLOtherIncome		.= " AND a.AccNo = '".$accno."'";
	endif;
//	echo "sSQLOtherIncome = ".$sSQLOtherIncome."<br />";
	$SQLOtherIncome	= mysql_query($sSQLOtherIncome) or die(mysql_errno()." : ".mysql_error());
	while($oOtherIncome = mysql_fetch_object($SQLOtherIncome)) {
		if(!empty($oOtherIncome->JumlahOtherIncome)):
			$iOtherIncomeTotal	= $oOtherIncome->JumlahOtherIncome;
		else:
			$iOtherIncomeTotal	= 0;
		endif;
	}
	$iTotalOtherIncome = $iOtherIncomeTotal;
else:
	$iTotalOtherIncome = 0;
endif;
//echo "iTotalOtherIncome = ".$iTotalOtherIncome."<br />";
$sSQLOtherIncomeList = "SELECT d.DocDate, d.DocFullNo, d.DocNo, d.DocTime, d.DocMonth, d.DocYear, d.DocCode, d.DocCode2, d.DocCode3, d.DocNickName, d.DocInOut, d.DocType, d.DocADJ, d.DocFolder, a.AccNo, a.AccName, a.Description, a.Amount FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocInOut = 'I' AND la.Type = 'Other Income'";
if(!empty($db) && !empty($db)):
	$sSQLOtherIncomeList		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
endif;
if($b==0 && $c==0 && $oth==0):
	$sSQLOtherIncomeList	.= " AND d.DocType NOT IN('B','C','O')";
elseif($b==1 && $c==1 && $oth==1):
	$sSQLOtherIncomeList	.= " AND d.DocType IN('B','C','O')";
elseif($b==1 && $c==1):
	$sSQLOtherIncomeList	.= " AND d.DocType IN('B','C')";
elseif($b==0 && $oth==1):
	$sSQLOtherIncomeList	.= " AND d.DocType IN('B','O')";
elseif($c==1 && $oth==1):
	$sSQLOtherIncomeList	.= " AND d.DocType IN('C','O')";
elseif($b==1):
	$sSQLOtherIncomeList	.= " AND d.DocType IN('B')";
elseif($c==1):
	$sSQLOtherIncomeList	.= " AND d.DocType IN('C')";
elseif($oth==1):
	$sSQLOtherIncomeList	.= " AND d.DocType IN('O')";
endif;
if(!empty($desc)):
	$sSQLOtherIncomeList		.= " AND a.Description LIKE = '%".$desc."%'";
endif;
if(!empty($code1)):
	$sSQLOtherIncomeList		.= " AND d.DocCode = '".$code1."'";
endif;
if($code2=="kosong"):
	$sSQLOtherIncomeList		.= " AND d.DocCode2 IS NULL";
elseif(!empty($code2)):
	$sSQLOtherIncomeList		.= " AND d.DocCode2 = '".$code2."'";
endif;
if($code3=="kosong"):
	$sSQLOtherIncomeList		.= " AND d.DocCode3 IS NULL";
elseif(!empty($code3)):
	$sSQLOtherIncomeList		.= " AND d.DocCode3 = '".$code3."'";
endif;
if(!empty($nick)):
	$sSQLOtherIncomeList		.= " AND d.DocNickName = '".$nick."'";
endif;
if(!empty($accno)):
	$sSQLOtherIncomeList		.= " AND a.AccNo = '".$accno."'";
endif;
$sSQLOtherIncomeList		.= " ORDER BY d.DocDate";

//echo "sSQLOtherIncomeList = ".$sSQLOtherIncomeList."<br />";

//select for Other Expenses
//All O
if($out==1):
	$sSQLOtherExpenses = "SELECT SUM(a.Amount) AS JumlahOtherExpenses FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocInOut = 'O' AND la.Type = 'Other Expense'";
	if(!empty($db) && !empty($db)):
		$sSQLOtherExpenses		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
	endif;
	if($b==0 && $c==0 && $oth==0):
		$sSQLOtherExpenses	.= " AND d.DocType NOT IN('B','C','O')";
	elseif($b==1 && $c==1 && $oth==1):
		$sSQLOtherExpenses	.= " AND d.DocType IN('B','C','O')";
	elseif($b==1 && $c==1):
		$sSQLOtherExpenses	.= " AND d.DocType IN('B','C')";
	elseif($b==0 && $oth==1):
		$sSQLOtherExpenses	.= " AND d.DocType IN('B','O')";
	elseif($c==1 && $oth==1):
		$sSQLOtherExpenses	.= " AND d.DocType IN('C','O')";
	elseif($b==1):
		$sSQLOtherExpenses	.= " AND d.DocType IN('B')";
	elseif($c==1):
		$sSQLOtherExpenses	.= " AND d.DocType IN('C')";
	elseif($oth==1):
		$sSQLOtherExpenses	.= " AND d.DocType IN('O')";
	endif;
	if(!empty($desc)):
		$sSQLOtherExpenses		.= " AND a.Description LIKE = '%".$desc."%'";
	endif;
	if(!empty($code1)):
		$sSQLOtherExpenses		.= " AND d.DocCode = '".$code1."'";
	endif;
	if($code2=="kosong"):
		$sSQLOtherExpenses		.= " AND d.DocCode2 IS NULL";
	elseif(!empty($code2)):
		$sSQLOtherExpenses		.= " AND d.DocCode2 = '".$code2."'";
	endif;
	if($code3=="kosong"):
		$sSQLOtherExpenses		.= " AND d.DocCode3 IS NULL";
	elseif(!empty($code3)):
		$sSQLOtherExpenses		.= " AND d.DocCode3 = '".$code3."'";
	endif;
	if(!empty($nick)):
		$sSQLOtherExpenses		.= " AND d.DocNickName = '".$nick."'";
	endif;
	if(!empty($accno)):
		$sSQLOtherExpenses		.= " AND a.AccNo = '".$accno."'";
	endif;
//	echo "sSQLOtherExpenses = ".$sSQLOtherExpenses."<br />";
	$SQLOtherExpenses	= mysql_query($sSQLOtherExpenses) or die(mysql_errno()." : ".mysql_error());
	while($oOtherExpenses = mysql_fetch_object($SQLOtherExpenses)) {
		if(!empty($oOtherExpenses->JumlahOtherExpenses)):
			$iOtherExpensesTotal	= $oOtherExpenses->JumlahOtherExpenses;
		else:
			$iOtherExpensesTotal	= 0;
		endif;
	}
	$iTotalOtherExpenses = $iOtherExpensesTotal;
else:
	$iTotalOtherExpenses = 0;
endif;
//echo "iTotalOtherExpenses = ".$iTotalOtherExpenses."<br />";
$sSQLOtherExpensesList = "SELECT d.DocDate, d.DocFullNo, d.DocNo, d.DocTime, d.DocMonth, d.DocYear, d.DocCode, d.DocCode2, d.DocCode3, d.DocNickName, d.DocInOut, d.DocType, d.DocADJ, d.DocFolder, a.AccNo, a.AccName, a.Description, a.Amount FROM tilyan_".$_SESSION['TLY__MemberFolder']."_document d, tilyan_".$_SESSION['TLY__MemberFolder']."_account a LEFT JOIN tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_account la ON a.AccNo = la.AccNo WHERE d.DocID = a.DocID AND d.DocInOut = 'O' AND la.Type = 'Other Expense'";
if(!empty($db) && !empty($db)):
	$sSQLOtherExpensesList		.= " AND d.DocDate <= '".$de."' AND d.DocDate >= '".$db."'";
endif;
if($b==0 && $c==0 && $oth==0):
	$sSQLOtherExpensesList	.= " AND d.DocType NOT IN('B','C','O')";
elseif($b==1 && $c==1 && $oth==1):
	$sSQLOtherExpensesList	.= " AND d.DocType IN('B','C','O')";
elseif($b==1 && $c==1):
	$sSQLOtherExpensesList	.= " AND d.DocType IN('B','C')";
elseif($b==0 && $oth==1):
	$sSQLOtherExpensesList	.= " AND d.DocType IN('B','O')";
elseif($c==1 && $oth==1):
	$sSQLOtherExpensesList	.= " AND d.DocType IN('C','O')";
elseif($b==1):
	$sSQLOtherExpensesList	.= " AND d.DocType IN('B')";
elseif($c==1):
	$sSQLOtherExpensesList	.= " AND d.DocType IN('C')";
elseif($oth==1):
	$sSQLOtherExpensesList	.= " AND d.DocType IN('O')";
endif;
if(!empty($desc)):
	$sSQLOtherExpensesList		.= " AND a.Description LIKE = '%".$desc."%'";
endif;
if(!empty($code1)):
	$sSQLOtherExpensesList		.= " AND d.DocCode = '".$code1."'";
endif;
if($code2=="kosong"):
	$sSQLOtherExpensesList		.= " AND d.DocCode2 IS NULL";
elseif(!empty($code2)):
	$sSQLOtherExpensesList		.= " AND d.DocCode2 = '".$code2."'";
endif;
if($code3=="kosong"):
	$sSQLOtherExpensesList		.= " AND d.DocCode3 IS NULL";
elseif(!empty($code3)):
	$sSQLOtherExpensesList		.= " AND d.DocCode3 = '".$code3."'";
endif;
if(!empty($nick)):
	$sSQLOtherExpensesList		.= " AND d.DocNickName = '".$nick."'";
endif;
if(!empty($accno)):
	$sSQLOtherExpensesList		.= " AND a.AccNo = '".$accno."'";
endif;
$sSQLOtherExpensesList		.= " ORDER BY d.DocDate";

//echo "sSQLOtherExpensesList = ".$sSQLOtherExpensesList."<br />";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="Description" content="Tilyan">
        <meta name="Keywords" content="">
        <link rel="shortcut icon" href="images/favicon.ico">
        <title>tilyanPristka</title>
		<script type="text/javascript" src="scripts/lib/jquery.min.js"></script>
        <script type="text/javascript" src="scripts/animatedcollapse.js">
        
        /***********************************************
        * Animated Collapsible DIV v2.4- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
        * This notice MUST stay intact for legal use
        * Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
        ***********************************************/
        
        </script>
        
        
        <script type="text/javascript">
        
        animatedcollapse.addDiv('cashbank', 'fade=1,hide=1');
        animatedcollapse.addDiv('revenue', 'fade=1,hide=1');
        animatedcollapse.addDiv('cgs', 'fade=1,hide=1');
        animatedcollapse.addDiv('expenses', 'fade=1,hide=1');
        animatedcollapse.addDiv('otherincome', 'fade=1,hide=1');
        animatedcollapse.addDiv('otherexpenses', 'fade=1,hide=1');
        
        animatedcollapse.ontoggle=function($, divobj, state){ //fires each time a DIV is expanded/contracted
            //$: Access to jQuery
            //divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
            //state: "block" or "none", depending on state
        };
        
        animatedcollapse.init();
        
        </script>
		<style type="text/css">
		.detail {
			padding-left:6px; 
			font-size:11px; 
			font-weight:normal;	
			height:20px;	
		}
		</style>
        <link rel="stylesheet" href="css/style.css" />
	</head>

    <body>
    
       <div class="other" style="margin-bottom:6px;">
        	<center>
            <table width="95%" cellpadding="2" cellspacing="3" border="0">
                <tr>
                    <td align="left"><?php if ($_SESSION["TLY__Logo"]!="") { ?><img src="uploads/logo/<?php echo $_SESSION['TLY__Logo']?>" width="192" style="float: left; padding-right: 13px;" /><?php } ?></td>
                    <td align="center">
                    	<div style="font-size:18px;">
                        	LAPORAN KEGIATAN<br />
                            <?php
							if(!empty($de) && !empty($db)):
								echo ViewDateTimeFormat($db,6) ." - ". ViewDateTimeFormat($de,6);
							endif;
							?>
                        </div>
                    </td>
                    <td valign="top" align="right"><img src="images/main_logo_small.png" /></td>
                </tr>
            </table><p>&nbsp;</p>
			<table width="95%" cellpadding="0" cellspacing="0" border="0">
                <tr style="height:25px; font-size:13px; font-weight:bold; background-color:#FF9933;" onclick="javascript:animatedcollapse.toggle('cashbank');" onmouseover="document.body.style.cursor='pointer';"  onmouseout="document.body.style.cursor='default';">
                    <td width="20%" style="padding-left:6px;"><a href="#" rel="toggle[cashbank]" data-openimage="images/collapse.gif" data-closedimage="images/expand.gif"><img src="images/expand.gif" width="15" border="0" align="absmiddle" /></a> Cash/Bank</td>
                    <td width="20%" style="padding-right:6px; text-align:right;"><?php echo ConvertMoneyFormatIndo2($iTotalCashBank);?></td>
                    <td width="20%" style="padding-left:6px;"></td>
                    <td width="20%" style="padding-left:6px;"></td>
                    <td width="20%" style="padding-left:6px;"></td>
                </tr>
			</table>
                <?php
				$SQLCashBankList	 = mysql_query($sSQLCashBankList) or die(mysql_errno()." : ".mysql_error());
				if (mysql_num_rows($SQLCashBankList) != 0):
				?>
                <div id="cashbank">
			<table width="95%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="5" align="center">
                        <table width="95%" cellpadding="2" cellspacing="0" border="0" style="border-bottom:1px dashed #990000;">
                        <?php
						while($oCashBankList = mysql_fetch_object($SQLCashBankList)) {

							//generate FullDocNo
							$sDocFullNo = "";
							if($_SESSION['TLY__VisibleFolder']==0):
								$sDocFullNo .= strtoupper($oCashBankList->DocFolder);
							else:
								$sDocFullNo .= "";
							endif;
							if(!empty($oCashBankList->DocADJ)):
								if(empty($sDocFullNo)):
									$sDocFullNo .= "ADJ";
								else:
									$sDocFullNo .= ".ADJ";
								endif;
							else:
								$sDocFullNo .= "";
							endif;
							if(empty($sDocFullNo)):
								$sDocFullNo .= $oCashBankList->DocType.".".$oCashBankList->DocInOut;
							else:
								$sDocFullNo .= ".".$oCashBankList->DocType.".".$oCashBankList->DocInOut;
							endif;
							if($_SESSION['TLY__VisibleNickName']==0):
								$sDocFullNo .= ".".strtoupper($oCashBankList->DocNickName);
							endif;
							if(strlen($oCashBankList->DocMonth)==1):
								$sFormatedMonth	= "0".$oCashBankList->DocMonth;
							elseif(strlen($oCashBankList->DocMonth)==2):
								$sFormatedMonth	= $oCashBankList->DocMonth;
							endif;
							$sDocFullNo .= ".".$oCashBankList->DocCode;
							if(!empty($oCashBankList->DocCode2)):
								$sDocFullNo .= ".".$oCashBankList->DocCode2;
							endif;
							if(!empty($oCashBankList->DocCode3)):
								$sDocFullNo .= ".".$oCashBankList->DocCode3;
							endif;
							$sDocFullNo .= ".".$oCashBankList->DocYear.".".$sFormatedMonth;
							if($_SESSION['TLY__VisibleTime']==0):
								$sDocFullNo .= ".".$oCashBankList->DocTime;
							endif;
							if(strlen($oCashBankList->DocNo)==1):
								$sFormatedNumber	= "000".$oCashBankList->DocNo;
							elseif(strlen($oCashBankList->DocNo)==2):
								$sFormatedNumber	= "00".$oCashBankList->DocNo;
							elseif(strlen($oCashBankList->DocNo)==3):
								$sFormatedNumber	= "0".$oCashBankList->DocNo;
							elseif(strlen($oCashBankList->DocNo)==4):
								$sFormatedNumber	= $oCashBankList->DocNo;
							endif;
							$sDocFullNo .= ".".$sFormatedNumber;
						?>
                            <tr>
                                <td width="10%" class="detail"><?php echo ViewDateTimeFormat($oCashBankList->DocDate,9)?></td>
                                <!-- <td width="30%" class="detail"><?php echo $oCashBankList->DocFullNo?></td> //-->
                                <td width="30%" class="detail"><?php echo $sDocFullNo?></td>
                                <td width="10%" class="detail"><?php echo $oCashBankList->AccNo?></td>
                                <td width="30%" class="detail"><?php echo $oCashBankList->Description?></td>
                                <td width="20%" align="right" class="detail"><?php if($oCashBankList->DocInOut=='O'){ echo "-"; }?><?php echo ConvertMoneyFormatIndo2($oCashBankList->Amount)?></td>
                            </tr>
                        <?php
						}
						?>
                        </table><p>&nbsp;</p>
                    </td>
                </tr>
			</table>
                </div>
                <?php
				endif;
				?>
			<table width="95%" cellpadding="0" cellspacing="0" border="0">
				<tr style="height:25px; font-size:13px; font-weight:bold; background-color:#EEEEEE;" onclick="javascript:animatedcollapse.toggle('revenue');" onmouseover="document.body.style.cursor='pointer';"  onmouseout="document.body.style.cursor='default';">
					<td width="20%" style="padding-left:6px;"><a href="#" rel="toggle[revenue]" data-openimage="images/collapse.gif" data-closedimage="images/expand.gif"><img src="images/expand.gif" width="15" border="0" align="absmiddle" /></a>  Revenue</td>
					<td width="20%" style="padding-left:6px;"></td>
					<td width="20%" style="padding-right:6px; text-align:right;"><?php echo ConvertMoneyFormatIndo2($iTotalRevenue);?></td>
					<td width="20%" style="padding-left:6px;"></td>
					<td width="20%" style="padding-left:6px;"></td>
                </tr>
			</table>
                <?php
				if($in==1):
					$SQLRevenueList	 = mysql_query($sSQLRevenueList) or die(mysql_errno()." : ".mysql_error());
					if (mysql_num_rows($SQLRevenueList) != 0):
				?>
                <div id="revenue">
			<table width="95%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="5" align="center">
                        <table width="95%" cellpadding="2" cellspacing="0" border="0" style="border-bottom:1px dashed #990000;">
                        <?php
							while($oRevenueList = mysql_fetch_object($SQLRevenueList)) {

							//generate FullDocNo
							$sDocFullNo = "";
							if($_SESSION['TLY__VisibleFolder']==0):
								$sDocFullNo .= strtoupper($oRevenueList->DocFolder);
							else:
								$sDocFullNo .= "";
							endif;
							if(!empty($oRevenueList->DocADJ)):
								if(empty($sDocFullNo)):
									$sDocFullNo .= "ADJ";
								else:
									$sDocFullNo .= ".ADJ";
								endif;
							else:
								$sDocFullNo .= "";
							endif;
							if(empty($sDocFullNo)):
								$sDocFullNo .= $oRevenueList->DocType.".".$oRevenueList->DocInOut;
							else:
								$sDocFullNo .= ".".$oRevenueList->DocType.".".$oRevenueList->DocInOut;
							endif;
							if($_SESSION['TLY__VisibleNickName']==0):
								$sDocFullNo .= ".".strtoupper($oRevenueList->DocNickName);
							endif;
							if(strlen($oRevenueList->DocMonth)==1):
								$sFormatedMonth	= "0".$oRevenueList->DocMonth;
							elseif(strlen($oRevenueList->DocMonth)==2):
								$sFormatedMonth	= $oRevenueList->DocMonth;
							endif;
							$sDocFullNo .= ".".$oRevenueList->DocCode;
							if(!empty($oRevenueList->DocCode2)):
								$sDocFullNo .= ".".$oRevenueList->DocCode2;
							endif;
							if(!empty($oRevenueList->DocCode3)):
								$sDocFullNo .= ".".$oRevenueList->DocCode3;
							endif;
							$sDocFullNo .= ".".$oRevenueList->DocYear.".".$sFormatedMonth;
							if($_SESSION['TLY__VisibleTime']==0):
								$sDocFullNo .= ".".$oRevenueList->DocTime;
							endif;
							if(strlen($oRevenueList->DocNo)==1):
								$sFormatedNumber	= "000".$oRevenueList->DocNo;
							elseif(strlen($oRevenueList->DocNo)==2):
								$sFormatedNumber	= "00".$oRevenueList->DocNo;
							elseif(strlen($oRevenueList->DocNo)==3):
								$sFormatedNumber	= "0".$oRevenueList->DocNo;
							elseif(strlen($oRevenueList->DocNo)==4):
								$sFormatedNumber	= $oRevenueList->DocNo;
							endif;
							$sDocFullNo .= ".".$sFormatedNumber;
						?>
                            <tr>
                                <td width="10%" class="detail"><?php echo ViewDateTimeFormat($oRevenueList->DocDate,9)?></td>
                                <!-- <td width="30%" class="detail"><?php echo $oRevenueList->DocFullNo?></td> //-->
                                <td width="30%" class="detail"><?php echo $sDocFullNo?></td>
                                <td width="10%" class="detail"><?php echo $oRevenueList->AccNo?></td>
                                <td width="30%" class="detail"><?php echo $oRevenueList->Description?></td>
                                <td width="20%" align="right" class="detail"><?php echo ConvertMoneyFormatIndo2($oRevenueList->Amount)?></td>
                            </tr>
                        <?php
							}
						?>
                        </table><p>&nbsp;</p>
                    </td>
                </tr>
			</table>
				</div>
                <?php
					endif;
				endif;
				?>
			<table width="95%" cellpadding="0" cellspacing="0" border="0">
				<tr style="height:25px; font-size:13px; font-weight:bold; background-color:#FFFF66;" onclick="javascript:animatedcollapse.toggle('cgs');" onmouseover="document.body.style.cursor='pointer';"  onmouseout="document.body.style.cursor='default';">
					<td width="20%" style="padding-left:6px;"><a href="#" rel="toggle[cgs]" data-openimage="images/collapse.gif" data-closedimage="images/expand.gif"><img src="images/expand.gif" width="15" border="0" align="absmiddle" /></a>  CoGS</td>
					<td width="20%" style="padding-left:6px;"></td>
					<td width="20%" style="padding-left:6px;"></td>
					<td width="20%" style="padding-right:6px; text-align:right;"><?php echo ConvertMoneyFormatIndo2(0-$iTotalCGS);?></td>
					<td width="20%" style="padding-left:6px;"></td>
                </tr>
			</table>
                <?php
				if($out==1):
					$SQLCGSList	 = mysql_query($sSQLCGSList) or die(mysql_errno()." : ".mysql_error());
					if (mysql_num_rows($SQLCGSList) != 0):
				?>
                <div id="cgs">
			<table width="95%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="5" align="center">
                        <table width="95%" cellpadding="2" cellspacing="0" border="0" style="border-bottom:1px dashed #990000;">
                        <?php
							while($oCGSList = mysql_fetch_object($SQLCGSList)) {

							//generate FullDocNo
							$sDocFullNo = "";
							if($_SESSION['TLY__VisibleFolder']==0):
								$sDocFullNo .= strtoupper($oCGSList->DocFolder);
							else:
								$sDocFullNo .= "";
							endif;
							if(!empty($oCGSList->DocADJ)):
								if(empty($sDocFullNo)):
									$sDocFullNo .= "ADJ";
								else:
									$sDocFullNo .= ".ADJ";
								endif;
							else:
								$sDocFullNo .= "";
							endif;
							if(empty($sDocFullNo)):
								$sDocFullNo .= $oCGSList->DocType.".".$oCGSList->DocInOut;
							else:
								$sDocFullNo .= ".".$oCGSList->DocType.".".$oCGSList->DocInOut;
							endif;
							if($_SESSION['TLY__VisibleNickName']==0):
								$sDocFullNo .= ".".strtoupper($oCGSList->DocNickName);
							endif;
							if(strlen($oCGSList->DocMonth)==1):
								$sFormatedMonth	= "0".$oCGSList->DocMonth;
							elseif(strlen($oCGSList->DocMonth)==2):
								$sFormatedMonth	= $oCGSList->DocMonth;
							endif;
							$sDocFullNo .= ".".$oCGSList->DocCode;
							if(!empty($oCGSList->DocCode2)):
								$sDocFullNo .= ".".$oCGSList->DocCode2;
							endif;
							if(!empty($oCGSList->DocCode3)):
								$sDocFullNo .= ".".$oCGSList->DocCode3;
							endif;
							$sDocFullNo .= ".".$oCGSList->DocYear.".".$sFormatedMonth;
							if($_SESSION['TLY__VisibleTime']==0):
								$sDocFullNo .= ".".$oCGSList->DocTime;
							endif;
							if(strlen($oCGSList->DocNo)==1):
								$sFormatedNumber	= "000".$oCGSList->DocNo;
							elseif(strlen($oCGSList->DocNo)==2):
								$sFormatedNumber	= "00".$oCGSList->DocNo;
							elseif(strlen($oCGSList->DocNo)==3):
								$sFormatedNumber	= "0".$oCGSList->DocNo;
							elseif(strlen($oCGSList->DocNo)==4):
								$sFormatedNumber	= $oCGSList->DocNo;
							endif;
							$sDocFullNo .= ".".$sFormatedNumber;
						?>
                            <tr>
                                <td width="10%" class="detail"><?php echo ViewDateTimeFormat($oCGSList->DocDate,9)?></td>
                                <!-- <td width="30%" class="detail"><?php echo $oCGSList->DocFullNo?></td> //-->
                                <td width="30%" class="detail"><?php echo $sDocFullNo?></td>
                                <td width="10%" class="detail"><?php echo $oCGSList->AccNo?></td>
                                <td width="30%" class="detail"><?php echo $oCGSList->Description?></td>
                                <td width="20%" align="right" class="detail"><?php echo ConvertMoneyFormatIndo2(0-$oCGSList->Amount)?></td>
                            </tr>
                        <?php
							}
						?>
                        </table><p>&nbsp;</p>
                    </td>
                </tr>
			</table>
				</div>
                <?php
					endif;
				endif;
				?>
			<table width="95%" cellpadding="0" cellspacing="0" border="0">
				<tr style="height:25px; font-size:13px; font-weight:bold; background-color:#EEEEEE" onclick="javascript:animatedcollapse.toggle('expenses');" onmouseover="document.body.style.cursor='pointer';"  onmouseout="document.body.style.cursor='default';">
					<td width="20%" style="padding-left:6px;"><a href="#" rel="toggle[expenses]" data-openimage="images/collapse.gif" data-closedimage="images/expand.gif"><img src="images/expand.gif" width="15" border="0" align="absmiddle" /></a>  Expenses</td>
					<td width="20%" style="padding-left:6px;"></td>
					<td width="20%" style="padding-left:6px;"></td>
					<td width="20%" style="padding-left:6px;"></td>
					<td width="20%" style="padding-right:6px; text-align:right;"><?php echo ConvertMoneyFormatIndo2(0-$iTotalExpenses);?></td>
                </tr>
			</table>
                <?php
				if($out==1):
					$SQLExpensesList	 = mysql_query($sSQLExpensesList) or die(mysql_errno()." : ".mysql_error());
					if (mysql_num_rows($SQLExpensesList) != 0):
				?>
                <div id="expenses">
			<table width="95%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="5" align="center">
                        <table width="95%" cellpadding="2" cellspacing="0" border="0" style="border-bottom:1px dashed #990000;">
                        <?php
							while($oExpensesList = mysql_fetch_object($SQLExpensesList)) {

							//generate FullDocNo
							$sDocFullNo = "";
							if($_SESSION['TLY__VisibleFolder']==0):
								$sDocFullNo .= strtoupper($oExpensesList->DocFolder);
							else:
								$sDocFullNo .= "";
							endif;
							if(!empty($oExpensesList->DocADJ)):
								if(empty($sDocFullNo)):
									$sDocFullNo .= "ADJ";
								else:
									$sDocFullNo .= ".ADJ";
								endif;
							else:
								$sDocFullNo .= "";
							endif;
							if(empty($sDocFullNo)):
								$sDocFullNo .= $oExpensesList->DocType.".".$oExpensesList->DocInOut;
							else:
								$sDocFullNo .= ".".$oExpensesList->DocType.".".$oExpensesList->DocInOut;
							endif;
							if($_SESSION['TLY__VisibleNickName']==0):
								$sDocFullNo .= ".".strtoupper($oExpensesList->DocNickName);
							endif;
							if(strlen($oExpensesList->DocMonth)==1):
								$sFormatedMonth	= "0".$oExpensesList->DocMonth;
							elseif(strlen($oExpensesList->DocMonth)==2):
								$sFormatedMonth	= $oExpensesList->DocMonth;
							endif;
							$sDocFullNo .= ".".$oExpensesList->DocCode;
							if(!empty($oExpensesList->DocCode2)):
								$sDocFullNo .= ".".$oExpensesList->DocCode2;
							endif;
							if(!empty($oExpensesList->DocCode3)):
								$sDocFullNo .= ".".$oExpensesList->DocCode3;
							endif;
							$sDocFullNo .= ".".$oExpensesList->DocYear.".".$sFormatedMonth;
							if($_SESSION['TLY__VisibleTime']==0):
								$sDocFullNo .= ".".$oExpensesList->DocTime;
							endif;
							if(strlen($oExpensesList->DocNo)==1):
								$sFormatedNumber	= "000".$oExpensesList->DocNo;
							elseif(strlen($oExpensesList->DocNo)==2):
								$sFormatedNumber	= "00".$oExpensesList->DocNo;
							elseif(strlen($oExpensesList->DocNo)==3):
								$sFormatedNumber	= "0".$oExpensesList->DocNo;
							elseif(strlen($oExpensesList->DocNo)==4):
								$sFormatedNumber	= $oExpensesList->DocNo;
							endif;
							$sDocFullNo .= ".".$sFormatedNumber;
						?>
                            <tr>
                                <td width="10%" class="detail"><?php echo ViewDateTimeFormat($oExpensesList->DocDate,9)?></td>
                                <!-- <td width="30%" class="detail"><?php echo $oExpensesList->DocFullNo?></td> //-->
                                <td width="30%" class="detail"><?php echo $sDocFullNo?></td>
                                <td width="10%" class="detail"><?php echo $oExpensesList->AccNo?></td>
                                <td width="30%" class="detail"><?php echo $oExpensesList->Description?></td>
                                <td width="20%" align="right" class="detail"><?php echo ConvertMoneyFormatIndo2(0-$oExpensesList->Amount)?></td>
                            </tr>
                        <?php
							}
						?>
                        </table><p>&nbsp;</p>
                    </td>
                </tr>
			</table>
				</div>
                <?php
					endif;
				endif;
				?>
			<table width="95%" cellpadding="0" cellspacing="0" border="0">
				<tr style="height:25px; font-size:13px; font-weight:bold; background-color:#FFFF66;" onclick="javascript:animatedcollapse.toggle('otherincome');" onmouseover="document.body.style.cursor='pointer';"  onmouseout="document.body.style.cursor='default';">
					<td width="20%" style="padding-left:6px;"><a href="#" rel="toggle[otherincome]" data-openimage="images/collapse.gif" data-closedimage="images/expand.gif"><img src="images/expand.gif" width="15" border="0" align="absmiddle" /></a> Oth. Income</td>
					<td width="20%" style="padding-left:6px;"></td>
					<td width="20%" style="padding-right:6px; text-align:right;"><?php echo ConvertMoneyFormatIndo2($iTotalOtherIncome);?></td>
					<td width="20%" style="padding-left:6px;"></td>
					<td width="20%" style="padding-left:6px;"></td>
                </tr>
			</table>
                <?php
				if($in==1):
					$SQLOtherIncomeList	 = mysql_query($sSQLOtherIncomeList) or die(mysql_errno()." : ".mysql_error());
					if (mysql_num_rows($SQLOtherIncomeList) != 0):
				?>
                <div id="otherincome">
			<table width="95%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="5" align="center">
                        <table width="95%" cellpadding="2" cellspacing="0" border="0" style="border-bottom:1px dashed #990000;">
                        <?php
							while($oOtherIncomeList = mysql_fetch_object($SQLOtherIncomeList)) {

							//generate FullDocNo
							$sDocFullNo = "";
							if($_SESSION['TLY__VisibleFolder']==0):
								$sDocFullNo .= strtoupper($oOtherIncomeList->DocFolder);
							else:
								$sDocFullNo .= "";
							endif;
							if(!empty($oOtherIncomeList->DocADJ)):
								if(empty($sDocFullNo)):
									$sDocFullNo .= "ADJ";
								else:
									$sDocFullNo .= ".ADJ";
								endif;
							else:
								$sDocFullNo .= "";
							endif;
							if(empty($sDocFullNo)):
								$sDocFullNo .= $oOtherIncomeList->DocType.".".$oOtherIncomeList->DocInOut;
							else:
								$sDocFullNo .= ".".$oOtherIncomeList->DocType.".".$oOtherIncomeList->DocInOut;
							endif;
							if($_SESSION['TLY__VisibleNickName']==0):
								$sDocFullNo .= ".".strtoupper($oOtherIncomeList->DocNickName);
							endif;
							if(strlen($oOtherIncomeList->DocMonth)==1):
								$sFormatedMonth	= "0".$oOtherIncomeList->DocMonth;
							elseif(strlen($oOtherIncomeList->DocMonth)==2):
								$sFormatedMonth	= $oOtherIncomeList->DocMonth;
							endif;
							$sDocFullNo .= ".".$oOtherIncomeList->DocCode;
							if(!empty($oOtherIncomeList->DocCode2)):
								$sDocFullNo .= ".".$oOtherIncomeList->DocCode2;
							endif;
							if(!empty($oOtherIncomeList->DocCode3)):
								$sDocFullNo .= ".".$oOtherIncomeList->DocCode3;
							endif;
							$sDocFullNo .= ".".$oOtherIncomeList->DocYear.".".$sFormatedMonth;
							if($_SESSION['TLY__VisibleTime']==0):
								$sDocFullNo .= ".".$oOtherIncomeList->DocTime;
							endif;
							if(strlen($oOtherIncomeList->DocNo)==1):
								$sFormatedNumber	= "000".$oOtherIncomeList->DocNo;
							elseif(strlen($oOtherIncomeList->DocNo)==2):
								$sFormatedNumber	= "00".$oOtherIncomeList->DocNo;
							elseif(strlen($oOtherIncomeList->DocNo)==3):
								$sFormatedNumber	= "0".$oOtherIncomeList->DocNo;
							elseif(strlen($oOtherIncomeList->DocNo)==4):
								$sFormatedNumber	= $oOtherIncomeList->DocNo;
							endif;
							$sDocFullNo .= ".".$sFormatedNumber;
						?>
                            <tr>
                                <td width="10%" class="detail"><?php echo ViewDateTimeFormat($oOtherIncomeList->DocDate,9)?></td>
                                <!-- <td width="30%" class="detail"><?php echo $oOtherIncomeList->DocFullNo?></td> //-->
                                <td width="30%" class="detail"><?php echo $sDocFullNo?></td>
                                <td width="10%" class="detail"><?php echo $oOtherIncomeList->AccNo?></td>
                                <td width="30%" class="detail"><?php echo $oOtherIncomeList->Description?></td>
                                <td width="20%" align="right" class="detail"><?php echo ConvertMoneyFormatIndo2($oOtherIncomeList->Amount)?></td>
                            </tr>
                        <?php
							}
						?>
                        </table><p>&nbsp;</p>
                    </td>
                </tr>
			</table>
				</div>
                <?php
					endif;
				endif;
				?>
			<table width="95%" cellpadding="0" cellspacing="0" border="0">
				<tr style="height:25px; font-size:13px; font-weight:bold; background-color:#EEEEEE" onclick="javascript:animatedcollapse.toggle('otherexpenses');" onmouseover="document.body.style.cursor='pointer';"  onmouseout="document.body.style.cursor='default';">
					<td width="20%" style="padding-left:6px;"><a href="#" rel="toggle[otherexpenses]" data-openimage="images/collapse.gif" data-closedimage="images/expand.gif"><img src="images/expand.gif" width="15" border="0" align="absmiddle" /></a> Oth. Expenses</td>
					<td width="20%" style="padding-left:6px;"></td>
					<td width="20%" style="padding-left:6px;"></td>
					<td width="20%" style="padding-left:6px;"></td>
					<td width="20%" style="padding-right:6px; text-align:right;"><?php echo ConvertMoneyFormatIndo2(0-$iTotalOtherExpenses);?></td>
                </tr>
			</table>
                <?php
				if($in==1):
					$SQLOtherExpensesList	 = mysql_query($sSQLOtherExpensesList) or die(mysql_errno()." : ".mysql_error());
					if (mysql_num_rows($SQLOtherExpensesList) != 0):
				?>
                <div id="otherexpenses">
			<table width="95%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td colspan="5" align="center">
                        <table width="95%" cellpadding="2" cellspacing="0" border="0" style="border-bottom:1px dashed #990000;">
                        <?php
							while($oOtherExpensesList = mysql_fetch_object($SQLOtherExpensesList)) {

							//generate FullDocNo
							$sDocFullNo = "";
							if($_SESSION['TLY__VisibleFolder']==0):
								$sDocFullNo .= strtoupper($oOtherExpensesList->DocFolder);
							else:
								$sDocFullNo .= "";
							endif;
							if(!empty($oOtherExpensesList->DocADJ)):
								if(empty($sDocFullNo)):
									$sDocFullNo .= "ADJ";
								else:
									$sDocFullNo .= ".ADJ";
								endif;
							else:
								$sDocFullNo .= "";
							endif;
							if(empty($sDocFullNo)):
								$sDocFullNo .= $oOtherExpensesList->DocType.".".$oOtherExpensesList->DocInOut;
							else:
								$sDocFullNo .= ".".$oOtherExpensesList->DocType.".".$oOtherExpensesList->DocInOut;
							endif;
							if($_SESSION['TLY__VisibleNickName']==0):
								$sDocFullNo .= ".".strtoupper($oOtherExpensesList->DocNickName);
							endif;
							if(strlen($oOtherExpensesList->DocMonth)==1):
								$sFormatedMonth	= "0".$oOtherExpensesList->DocMonth;
							elseif(strlen($oOtherExpensesList->DocMonth)==2):
								$sFormatedMonth	= $oOtherExpensesList->DocMonth;
							endif;
							$sDocFullNo .= ".".$oOtherExpensesList->DocCode;
							if(!empty($oOtherExpensesList->DocCode2)):
								$sDocFullNo .= ".".$oOtherExpensesList->DocCode2;
							endif;
							if(!empty($oOtherExpensesList->DocCode3)):
								$sDocFullNo .= ".".$oOtherExpensesList->DocCode3;
							endif;
							$sDocFullNo .= ".".$oOtherExpensesList->DocYear.".".$sFormatedMonth;
							if($_SESSION['TLY__VisibleTime']==0):
								$sDocFullNo .= ".".$oOtherExpensesList->DocTime;
							endif;
							if(strlen($oOtherExpensesList->DocNo)==1):
								$sFormatedNumber	= "000".$oOtherExpensesList->DocNo;
							elseif(strlen($oOtherExpensesList->DocNo)==2):
								$sFormatedNumber	= "00".$oOtherExpensesList->DocNo;
							elseif(strlen($oOtherExpensesList->DocNo)==3):
								$sFormatedNumber	= "0".$oOtherExpensesList->DocNo;
							elseif(strlen($oOtherExpensesList->DocNo)==4):
								$sFormatedNumber	= $oOtherExpensesList->DocNo;
							endif;
							$sDocFullNo .= ".".$sFormatedNumber;
						?>
                            <tr>
                                <td width="10%" class="detail"><?php echo ViewDateTimeFormat($oOtherExpensesList->DocDate,9)?></td>
                                <!-- <td width="30%" class="detail"><?php echo $oOtherExpensesList->DocFullNo?></td> //-->
                                <td width="30%" class="detail"><?php echo $sDocFullNo?></td>
                                <td width="10%" class="detail"><?php echo $oOtherExpensesList->AccNo?></td>
                                <td width="30%" class="detail"><?php echo $oOtherExpensesList->Description?></td>
                                <td width="20%" align="right" class="detail"><?php echo ConvertMoneyFormatIndo2(0-$oOtherExpensesList->Amount)?></td>
                            </tr>
                        <?php
							}
						?>
                        </table><p>&nbsp;</p>
                    </td>
                </tr>
			</table>
				</div>
                <?php
					endif;
				endif;
				?>
			<table width="95%" cellpadding="0" cellspacing="0" border="0">
				<tr style="height:25px; font-size:13px; font-weight:bold;">
					<td width="20%" style="padding-left:6px;"></td>
					<td width="20%" style="padding-left:6px;"></td>
					<td width="20%" style="padding-right:6px; text-align:right; border-top:2px solid #990000;"><?php echo ConvertMoneyFormatIndo2($iTotalRevenue+$iTotalOtherIncome);?></td>
					<td width="20%" style="padding-right:6px; text-align:right; border-top:2px solid #990000;"><?php echo ConvertMoneyFormatIndo2(0-$iTotalCGS);?></td>
					<td width="20%" style="padding-right:6px; text-align:right; border-top:2px solid #990000;"><?php echo ConvertMoneyFormatIndo2(0-($iTotalExpenses+$iTotalOtherExpenses));?></td>
                </tr>
            </table>
			</center>
		</div>

   </body>
</html>
