<?php
/************************************************************************************
File Name : func.global.php
Created by : Mohammad Syafiuddin - udhien (dev@dnet.net.id - http://www.udhien.net)
Date Modified : May 10, 2004
*************************************************************************************/

/*---------------------------------------------------------
function to convert month name into indonesian language

examples :
Month_Indo(date("d"), "longname"); -> output : Desember
Month_Indo(date("d"), "shortname"); -> output : Des
---------------------------------------------------------*/

function Month_Indo($month_int, $month_style) {
	if ($month_style == "shortname") {
		switch ($month_int) {
			case 1:
				$Bulan	= "Jan";
				break;
			case 2:
				$Bulan	= "Feb";
				break;
			case 3:
				$Bulan	= "Mar";
				break;
			case 4:
				$Bulan	= "Apr";
				break;
			case 5:
				$Bulan	= "Mei";
				break;
			case 6:
				$Bulan	= "Jun";
				break;
			case 7:
				$Bulan	= "Jul";
				break;
			case 8:
				$Bulan	= "Agu";
				break;
			case 9:
				$Bulan	= "Sep";
				break;
			case 10:
				$Bulan	= "Okt";
				break;
			case 11:
				$Bulan	= "Nov";
				break;
			case 12:
				$Bulan	= "Des";
				break;
		}
		
		return $Bulan;
	} elseif ($month_style == "longname") {
		switch ($month_int) {
			case 1:
				$Bulan	= "Januari";
				break;
			case 2:
				$Bulan	= "Februari";
				break;
			case 3:
				$Bulan	= "Maret";
				break;
			case 4:
				$Bulan	= "April";
				break;
			case 5:
				$Bulan	= "Mei";
				break;
			case 6:
				$Bulan	= "Juni";
				break;
			case 7:
				$Bulan	= "Juli";
				break;
			case 8:
				$Bulan	= "Agustus";
				break;
			case 9:
				$Bulan	= "September";
				break;
			case 10:
				$Bulan	= "Oktober";
				break;
			case 11:
				$Bulan	= "November";
				break;
			case 12:
				$Bulan	= "Desember";
				break;
		}
		
		return $Bulan;
	}
}


/*------------------------------------------------------------------------------
Create Date Drop Down List

format :
	Draw_Date_DropDownList ($variable, $value, $stylesheet);

example :
	Draw_Date_DropDownList("DateOfBirth", $DateOfBirth, "selectstyle");
-------------------------------------------------------------------------------*/

function Draw_Date_DropDownList ($datename, $datevalue = 0, $formstyle = "") {
	($datevalue == 0) ? $datevalue = intval(date("d")) : $datevalue = $datevalue;
	
	$date_dropdown	 = "<select name=\"".$datename."\" size=\"1\" class=\"".$formstyle."\">";
	//$date_dropdown	.= "<option value=\"\">DD</option>";

	for ($d = 1; $d <=31; $d++) {
		($datevalue == $d) ? $selected = "selected" : $selected = "";
		$date_dropdown	.= "<option value=\"".$d."\" ".$selected.">".$d."</option>\n";
	}

	$date_dropdown	.= "</select>";

	return $date_dropdown;
}

/*-------------------------------------------------------------------------------
Create Month Drop Down List

Depend :
	function Month_Indo()

format :
	Draw_Month_DropDownList ($variable, $value, $stylesheet);

example :
	Draw_Month_DropDownList("MonthOfBirth", $MonthOfBirth, "selectstyle");
--------------------------------------------------------------------------------*/

function Draw_Month_DropDownList($monthname, $monthvalue = 0, $formstyle = "") {
	($monthvalue == 0) ? $monthvalue = intval(date("m")) : $monthvalue = $monthvalue;

	$month_dropdown		 = "<select name=\"".$monthname."\" size=\"1\" class=\"".$formstyle."\">";
	//$month_dropdown		.= "<option value=\"\">MM</option>";

	for ($m = 1; $m <= 12; $m++) {
		($monthvalue == $m) ? $selected = "selected" : $selected = "";
		$month_dropdown		.= "<option value=\"".$m."\" ".$selected.">".Month_Indo($m, "longname")."</option>\n";
	}

	$month_dropdown	.= "</select>";

	return $month_dropdown;
}

/*-------------------------------------------------------------------------------------
Create Year Drop Down List

format :
	Draw_Year_DropDownList($variable, $value, $stylesheet, $startyearvalue);

example :
	Draw_Year_DropDownList("YearOfBirth", $YearOfBirth, "selectstyle", 1990);
-------------------------------------------------------------------------------------*/

function Draw_Year_DropDownList($yearname, $yearvalue = 0, $formstyle = "", $startyear = 1900) {
	$currentyear	= intval(date("Y"));

	($yearvalue == 0) ? $yearvalue = $currentyear : $yearvalue = $yearvalue;

	$year_dropdown		 = "<select name=\"".$yearname."\" size=\"1\" class=\"".$formstyle."\">";
	//$year_dropdown		.= "<option value=\"\">YY</option>";

	for ($y = $startyear; $y <= ($currentyear + 1); $y++) {
		($yearvalue == $y) ? $selected = "selected" : $selected = "";
		$year_dropdown		.= "<option value=\"".$y."\" ".$selected.">".$y."</option>\n";
	}

	$year_dropdown	.= "</select>";

	return $year_dropdown;
}

/*-----------------------------------------------------------------------------------
Create Hour Drop Down List

format :
	Draw_Hour_DropDownList($variable, $value, $stylesheet);

example :
	Draw_Hour_DropDownList("HourOfBirth", $HourOfBirth, "selectsytle");
-----------------------------------------------------------------------------------*/

function Draw_Hour_DropDownList($hourname, $hourvalue = "", $formstyle = "") {
	($hourvalue == "") ? $hourvalue = intval(date("H")) : $hourvalue = $hourvalue;

	$hour_dropdown		 = "<select name=\"".$hourname."\" size=\"1\" class=\"".$formstyle."\">";
	//$hour_dropdown		.= "<option value=\"\">HH</option>";

	for ($h = 0; $h <= 23; $h++) {
		($hourvalue == $h) ? $selected = "selected" : $selected = "";
		$hour_dropdown	 .= "<option value=\"".Pad_Digit($h)."\" ".$selected.">".Pad_Digit($h)."</option>\n";
	}

	$hour_dropdown	.= "</select>";

	return $hour_dropdown;
}

/*-----------------------------------------------------------------------------------
Create Minute Drop Down List

format :
	Draw_Minute_DropDownList($variable, $value, $stylesheet);

example :
	Draw_Minute_DropDownList("MinuteOfBirth", $MinuteOfBirth, "selectsytle");
-----------------------------------------------------------------------------------*/

function Draw_Minute_DropDownList($minutename, $minutevalue = "", $formstyle = "") {
	($minutevalue == "") ? $minutevalue = intval(date("i")) : $minutevalue = $minutevalue;

	$minute_dropdown		 = "<select name=\"".$minutename."\" size=\"1\" class=\"".$formstyle."\">";
	//$minute_dropdown		.= "<option value=\"\">MM</option>";

	for ($m = 0; $m <= 59; $m++) {
		($minutevalue == $m) ? $selected = "selected" : $selected = "";
		$minute_dropdown	 .= "<option value=\"".Pad_Digit($m)."\" ".$selected.">".Pad_Digit($m)."</option>\n";
	}

	$minute_dropdown	.= "</select>";

	return $minute_dropdown;
}

/*-----------------------------------------------------------------------------------
Create Second Drop Down List

format :
	Draw_Second_DropDownList($variable, $value, $stylesheet);

example :
	Draw_Second_DropDownList("SecondOfBirth", $SecondOfBirth, "selectsytle");
-----------------------------------------------------------------------------------*/

function Draw_Second_DropDownList($secondname, $secondvalue = "", $formstyle = "") {
	($secondvalue == "") ? $secondvalue = intval(date("s")) : $secondvalue = $secondvalue;

	$second_dropdown		 = "<select name=\"".$secondname."\" size=\"1\" class=\"".$formstyle."\">";
	//$second_dropdown		.= "<option value=\"\">SS</option>";

	for ($s = 0; $s <= 59; $s++) {
		($secondvalue == $s) ? $selected = "selected" : $selected = "";
		$second_dropdown	 .= "<option value=\"".Pad_Digit($s)."\" ".$selected.">".Pad_Digit($s)."</option>\n";
	}

	$second_dropdown	.= "</select>";

	return $second_dropdown;
}

function GetCountry($CountryID = "ID") {
	$aCountry = array('AF'=>'AFGHANISTAN', 'AL'=>'ALBANIA', 'DZ'=>'ALGERIA', 'AS'=>'AMERICAN SAMOA', 'AD'=>'ANDORRA', 'AO'=>'ANGOLA', 'AI'=>'ANGUILLA', 'AQ'=>'ANTARCTICA', 'AG'=>'ANTIGUA AND BARBUDA', 'AR'=>'ARGENTINA', 'AM'=>'ARMENIA', 'AW'=>'ARUBA', 'AU'=>'AUSTRALIA', 'AT'=>'AUSTRIA', 'AZ'=>'AZERBAIJAN', 'BS'=>'BAHAMAS', 'BH'=>'BAHRAIN', 'BD'=>'BANGLADESH', 'BB'=>'BARBADOS', 'BY'=>'BELARUS', 'BE'=>'BELGIUM', 'BZ'=>'BELIZE', 'BJ'=>'BENIN', 'BM'=>'BERMUDA', 'BT'=>'BHUTAN', 'BO'=>'BOLIVIA', 'BA'=>'BOSNIA AND HERZEGOVINA', 'BW'=>'BOTSWANA', 'BV'=>'BOUVET ISLAND', 'BR'=>'BRAZIL', 'IO'=>'BRITISH INDIAN OCEAN TERRITORY', 'BN'=>'BRUNEI DARUSSALAM', 'BG'=>'BULGARIA', 'BF'=>'BURKINA FASO', 'BI'=>'BURUNDI', 'KH'=>'CAMBODIA', 'CM'=>'CAMEROON', 'CA'=>'CANADA', 'CV'=>'CAPE VERDE', 'KY'=>'CAYMAN ISLANDS', 'CF'=>'CENTRAL AFRICAN REPUBLIC', 'TD'=>'CHAD', 'CL'=>'CHILE', 'CN'=>'CHINA', 'CX'=>'CHRISTMAS ISLAND', 'CC'=>'COCOS (KEELING) ISLANDS', 'CO'=>'COLOMBIA', 'KM'=>'COMOROS', 'CG'=>'CONGO', 'CD'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'CK'=>'COOK ISLANDS', 'CR'=>'COSTA RICA', 'CI'=>'COTE D IVOIRE', 'HR'=>'CROATIA', 'CU'=>'CUBA', 'CY'=>'CYPRUS', 'CZ'=>'CZECH REPUBLIC', 'DK'=>'DENMARK', 'DJ'=>'DJIBOUTI', 'DM'=>'DOMINICA', 'DO'=>'DOMINICAN REPUBLIC', 'TP'=>'EAST TIMOR', 'EC'=>'ECUADOR', 'EG'=>'EGYPT', 'SV'=>'EL SALVADOR', 'GQ'=>'EQUATORIAL GUINEA', 'ER'=>'ERITREA', 'EE'=>'ESTONIA', 'ET'=>'ETHIOPIA', 'FK'=>'FALKLAND ISLANDS (MALVINAS)', 'FO'=>'FAROE ISLANDS', 'FJ'=>'FIJI', 'FI'=>'FINLAND', 'FR'=>'FRANCE', 'GF'=>'FRENCH GUIANA', 'PF'=>'FRENCH POLYNESIA', 'TF'=>'FRENCH SOUTHERN TERRITORIES', 'GA'=>'GABON', 'GM'=>'GAMBIA', 'GE'=>'GEORGIA', 'DE'=>'GERMANY', 'GH'=>'GHANA', 'GI'=>'GIBRALTAR', 'GR'=>'GREECE', 'GL'=>'GREENLAND', 'GD'=>'GRENADA', 'GP'=>'GUADELOUPE', 'GU'=>'GUAM', 'GT'=>'GUATEMALA', 'GN'=>'GUINEA', 'GW'=>'GUINEA-BISSAU', 'GY'=>'GUYANA', 'HT'=>'HAITI', 'HM'=>'HEARD ISLAND AND MCDONALD ISLANDS', 'VA'=>'HOLY SEE (VATICAN CITY STATE)', 'HN'=>'HONDURAS', 'HK'=>'HONG KONG', 'HU'=>'HUNGARY', 'IS'=>'ICELAND', 'IN'=>'INDIA', 'ID'=>'INDONESIA', 'IR'=>'IRAN, ISLAMIC REPUBLIC OF', 'IQ'=>'IRAQ', 'IE'=>'IRELAND', 'IL'=>'ISRAEL', 'IT'=>'ITALY', 'JM'=>'JAMAICA', 'JP'=>'JAPAN', 'JO'=>'JORDAN', 'KZ'=>'KAZAKSTAN', 'KE'=>'KENYA', 'KI'=>'KIRIBATI', 'KP'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF', 'KR'=>'KOREA REPUBLIC OF', 'KW'=>'KUWAIT', 'KG'=>'KYRGYZSTAN', 'LA'=>'LAO PEOPLES DEMOCRATIC REPUBLIC', 'LV'=>'LATVIA', 'LB'=>'LEBANON', 'LS'=>'LESOTHO', 'LR'=>'LIBERIA', 'LY'=>'LIBYAN ARAB JAMAHIRIYA', 'LI'=>'LIECHTENSTEIN', 'LT'=>'LITHUANIA', 'LU'=>'LUXEMBOURG', 'MO'=>'MACAU', 'MK'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'MG'=>'MADAGASCAR', 'MW'=>'MALAWI', 'MY'=>'MALAYSIA', 'MV'=>'MALDIVES', 'ML'=>'MALI', 'MT'=>'MALTA', 'MH'=>'MARSHALL ISLANDS', 'MQ'=>'MARTINIQUE', 'MR'=>'MAURITANIA', 'MU'=>'MAURITIUS', 'YT'=>'MAYOTTE', 'MX'=>'MEXICO', 'FM'=>'MICRONESIA, FEDERATED STATES OF', 'MD'=>'MOLDOVA, REPUBLIC OF', 'MC'=>'MONACO', 'MN'=>'MONGOLIA', 'MS'=>'MONTSERRAT', 'MA'=>'MOROCCO', 'MZ'=>'MOZAMBIQUE', 'MM'=>'MYANMAR', 'NA'=>'NAMIBIA', 'NR'=>'NAURU', 'NP'=>'NEPAL', 'NL'=>'NETHERLANDS', 'AN'=>'NETHERLANDS ANTILLES', 'NC'=>'NEW CALEDONIA', 'NZ'=>'NEW ZEALAND', 'NI'=>'NICARAGUA', 'NE'=>'NIGER', 'NG'=>'NIGERIA', 'NU'=>'NIUE', 'NF'=>'NORFOLK ISLAND', 'MP'=>'NORTHERN MARIANA ISLANDS', 'NO'=>'NORWAY', 'OM'=>'OMAN', 'PK'=>'PAKISTAN', 'PW'=>'PALAU', 'PS'=>'PALESTINIAN TERRITORY, OCCUPIED', 'PA'=>'PANAMA', 'PG'=>'PAPUA NEW GUINEA', 'PY'=>'PARAGUAY', 'PE'=>'PERU', 'PH'=>'PHILIPPINES', 'PN'=>'PITCAIRN', 'PL'=>'POLAND', 'PT'=>'PORTUGAL', 'PR'=>'PUERTO RICO', 'QA'=>'QATAR', 'RE'=>'REUNION', 'RO'=>'ROMANIA', 'RU'=>'RUSSIAN FEDERATION', 'RW'=>'RWANDA', 'SH'=>'SAINT HELENA', 'KN'=>'SAINT KITTS AND NEVIS', 'LC'=>'SAINT LUCIA', 'PM'=>'SAINT PIERRE AND MIQUELON', 'VC'=>'SAINT VINCENT AND THE GRENADINES', 'WS'=>'SAMOA', 'SM'=>'SAN MARINO', 'ST'=>'SAO TOME AND PRINCIPE', 'SA'=>'SAUDI ARABIA', 'SN'=>'SENEGAL', 'SC'=>'SEYCHELLES', 'SL'=>'SIERRA LEONE', 'SG'=>'SINGAPORE', 'SK'=>'SLOVAKIA', 'SI'=>'SLOVENIA', 'SB'=>'SOLOMON ISLANDS', 'SO'=>'SOMALIA', 'ZA'=>'SOUTH AFRICA', 'GS'=>'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'ES'=>'SPAIN', 'LK'=>'SRI LANKA', 'SD'=>'SUDAN', 'SR'=>'SURINAME', 'SJ'=>'SVALBARD AND JAN MAYEN', 'SZ'=>'SWAZILAND', 'SE'=>'SWEDEN', 'CH'=>'SWITZERLAND', 'SY'=>'SYRIAN ARAB REPUBLIC', 'TW'=>'TAIWAN, PROVINCE OF CHINA', 'TJ'=>'TAJIKISTAN', 'TZ'=>'TANZANIA, UNITED REPUBLIC OF', 'TH'=>'THAILAND', 'TG'=>'TOGO', 'TK'=>'TOKELAU', 'TO'=>'TONGA', 'TT'=>'TRINIDAD AND TOBAGO', 'TN'=>'TUNISIA', 'TR'=>'TURKEY', 'TM'=>'TURKMENISTAN', 'TC'=>'TURKS AND CAICOS ISLANDS', 'TV'=>'TUVALU', 'UG'=>'UGANDA', 'UA'=>'UKRAINE', 'AE'=>'UNITED ARAB EMIRATES', 'GB'=>'UNITED KINGDOM', 'US'=>'UNITED STATES', 'UM'=>'UNITED STATES MINOR OUTLYING ISLANDS', 'UY'=>'URUGUAY', 'UZ'=>'UZBEKISTAN', 'VU'=>'VANUATU', 'VE'=>'VENEZUELA', 'VN'=>'VIET NAM', 'VG'=>'VIRGIN ISLANDS, BRITISH', 'VI'=>'VIRGIN ISLANDS, U.S.', 'WF'=>'WALLIS AND FUTUNA', 'EH'=>'WESTERN SAHARA', 'YE'=>'YEMEN', 'YU'=>'YUGOSLAVIA', 'ZM'=>'ZAMBIA', 'ZW'=>'ZIMBABWE', 'ZZ'=>'OTHER (NOT DISPLAYED)',);
	
	return ucwords(strtolower($aCountry[$iCountryID]));
}

function GetAdministratorName($iOperatorID) {
	global $Tb_Administrator;

	$SQLQuery	= mysql_query("SELECT FullName FROM $Tb_Administrator WHERE AdminID = '".$iOperatorID."'") or die(mysql_errno()." : ".mysql_error());

	if ($Query	= mysql_fetch_object($SQLQuery)) {
		$sOutput	= "<em>By : </em>".$Query->FullName;
	} else {
		$sOutput	= "";
	}

	return $sOutput;
}
?>