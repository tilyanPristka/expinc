<?php
/********************************************************
*	FileName         : global.function.php				*
*	Author           : Abi Abraham (udhien)		*
*	Last Modified    : 28/12/2003						*
********************************************************/

/*
Function to check Email Validation

ex : ValidEmail($email);
*/
function ValidEmail($address) {
	if (ereg("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $address)) {
		return true;
	} else {
		return false;
	}
}

/*
Function Trim String
*/

function TrimString($string) {
	return trim($string);
}

/*
Function to Get UniqueID

*/
function GetUniqueID(){ 
	mt_srand ((double) microtime() * 1000000); 
	return $UniqueID = md5(uniqid(mt_rand(),1)); 
}

/*
Function to Send Email

*/
function SendEmail($email_from, $email_to, $email_subject, $email_body, $email_redirect = "") {
	$email_from		= trim(str_replace("\\'", "'", $email_from));
	$email_to		= trim(str_replace("\\'", "'", $email_to));
	$email_subject	= trim(str_replace("\\'", "'", $email_subject));
	$email_body		= trim(str_replace("\\'", "'", $email_body));

	@mail($email_to, $email_subject, $email_body, "From: $email_from\nX-Mailer: SendMail");

	if ($email_redirect <> "") {
		header("location: $email_redirect");
	}
}

/*
Function to Show Month Name

ex : echo getMonthName($entry->dateregister, "longdate", "in");
	 echo getMonthName($entry->dateregister, "longdate", "en");
*/
function GetMonthName($iMonth, $sType, $lang = "en") {
	if ($lang == "en") {
		if ($sType == "shortdate") {
			$MonthIndonesia = array ('01'=>'Jan', '02'=>'Feb', '03'=>'Mar', '04'=>'Apr', '05'=>'May', '06'=>'Jun', '07'=>'Jul', '08'=>'Aug', '09'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec');

			return $MonthIndonesia[$iMonth];
		} if ($sType == "longdate") {
			$MonthIndonesia = array ('01'=>'January', '02'=>'February', '03'=>'March', '04'=>'April', '05'=>'May', '06'=>'June', '07'=>'July', '08'=>'August', '09'=>'September', '10'=>'October', '11'=>'November', '12'=>'December');

			return $MonthIndonesia[$iMonth];
		}
	} else if ($lang == "in") {
		if ($sType == "shortdate") {
			$MonthIndonesia = array ('01'=>'Jan', '02'=>'Feb', '03'=>'Mar', '04'=>'Apr', '05'=>'May', '06'=>'Jun', '07'=>'Jul', '08'=>'Aug', '09'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dec');

			return $MonthIndonesia[$iMonth];
		} if ($sType == "longdate") {
			$MonthIndonesia = array ('01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');

			return $MonthIndonesia[$iMonth];
		}
	}
}

function GetCountryName($iCountryID) {
	$aCountry = array('AF'=>'AFGHANISTAN', 'AL'=>'ALBANIA', 'DZ'=>'ALGERIA', 'AS'=>'AMERICAN SAMOA', 'AD'=>'ANDORRA', 'AO'=>'ANGOLA', 'AI'=>'ANGUILLA', 'AQ'=>'ANTARCTICA', 'AG'=>'ANTIGUA AND BARBUDA', 'AR'=>'ARGENTINA', 'AM'=>'ARMENIA', 'AW'=>'ARUBA', 'AU'=>'AUSTRALIA', 'AT'=>'AUSTRIA', 'AZ'=>'AZERBAIJAN', 'BS'=>'BAHAMAS', 'BH'=>'BAHRAIN', 'BD'=>'BANGLADESH', 'BB'=>'BARBADOS', 'BY'=>'BELARUS', 'BE'=>'BELGIUM', 'BZ'=>'BELIZE', 'BJ'=>'BENIN', 'BM'=>'BERMUDA', 'BT'=>'BHUTAN', 'BO'=>'BOLIVIA', 'BA'=>'BOSNIA AND HERZEGOVINA', 'BW'=>'BOTSWANA', 'BV'=>'BOUVET ISLAND', 'BR'=>'BRAZIL', 'IO'=>'BRITISH INDIAN OCEAN TERRITORY', 'BN'=>'BRUNEI DARUSSALAM', 'BG'=>'BULGARIA', 'BF'=>'BURKINA FASO', 'BI'=>'BURUNDI', 'KH'=>'CAMBODIA', 'CM'=>'CAMEROON', 'CA'=>'CANADA', 'CV'=>'CAPE VERDE', 'KY'=>'CAYMAN ISLANDS', 'CF'=>'CENTRAL AFRICAN REPUBLIC', 'TD'=>'CHAD', 'CL'=>'CHILE', 'CN'=>'CHINA', 'CX'=>'CHRISTMAS ISLAND', 'CC'=>'COCOS (KEELING) ISLANDS', 'CO'=>'COLOMBIA', 'KM'=>'COMOROS', 'CG'=>'CONGO', 'CD'=>'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'CK'=>'COOK ISLANDS', 'CR'=>'COSTA RICA', 'CI'=>'COTE D IVOIRE', 'HR'=>'CROATIA', 'CU'=>'CUBA', 'CY'=>'CYPRUS', 'CZ'=>'CZECH REPUBLIC', 'DK'=>'DENMARK', 'DJ'=>'DJIBOUTI', 'DM'=>'DOMINICA', 'DO'=>'DOMINICAN REPUBLIC', 'TP'=>'EAST TIMOR', 'EC'=>'ECUADOR', 'EG'=>'EGYPT', 'SV'=>'EL SALVADOR', 'GQ'=>'EQUATORIAL GUINEA', 'ER'=>'ERITREA', 'EE'=>'ESTONIA', 'ET'=>'ETHIOPIA', 'FK'=>'FALKLAND ISLANDS (MALVINAS)', 'FO'=>'FAROE ISLANDS', 'FJ'=>'FIJI', 'FI'=>'FINLAND', 'FR'=>'FRANCE', 'GF'=>'FRENCH GUIANA', 'PF'=>'FRENCH POLYNESIA', 'TF'=>'FRENCH SOUTHERN TERRITORIES', 'GA'=>'GABON', 'GM'=>'GAMBIA', 'GE'=>'GEORGIA', 'DE'=>'GERMANY', 'GH'=>'GHANA', 'GI'=>'GIBRALTAR', 'GR'=>'GREECE', 'GL'=>'GREENLAND', 'GD'=>'GRENADA', 'GP'=>'GUADELOUPE', 'GU'=>'GUAM', 'GT'=>'GUATEMALA', 'GN'=>'GUINEA', 'GW'=>'GUINEA-BISSAU', 'GY'=>'GUYANA', 'HT'=>'HAITI', 'HM'=>'HEARD ISLAND AND MCDONALD ISLANDS', 'VA'=>'HOLY SEE (VATICAN CITY STATE)', 'HN'=>'HONDURAS', 'HK'=>'HONG KONG', 'HU'=>'HUNGARY', 'IS'=>'ICELAND', 'IN'=>'INDIA', 'ID'=>'INDONESIA', 'IR'=>'IRAN, ISLAMIC REPUBLIC OF', 'IQ'=>'IRAQ', 'IE'=>'IRELAND', 'IL'=>'ISRAEL', 'IT'=>'ITALY', 'JM'=>'JAMAICA', 'JP'=>'JAPAN', 'JO'=>'JORDAN', 'KZ'=>'KAZAKSTAN', 'KE'=>'KENYA', 'KI'=>'KIRIBATI', 'KP'=>'KOREA DEMOCRATIC PEOPLES REPUBLIC OF', 'KR'=>'KOREA REPUBLIC OF', 'KW'=>'KUWAIT', 'KG'=>'KYRGYZSTAN', 'LA'=>'LAO PEOPLES DEMOCRATIC REPUBLIC', 'LV'=>'LATVIA', 'LB'=>'LEBANON', 'LS'=>'LESOTHO', 'LR'=>'LIBERIA', 'LY'=>'LIBYAN ARAB JAMAHIRIYA', 'LI'=>'LIECHTENSTEIN', 'LT'=>'LITHUANIA', 'LU'=>'LUXEMBOURG', 'MO'=>'MACAU', 'MK'=>'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'MG'=>'MADAGASCAR', 'MW'=>'MALAWI', 'MY'=>'MALAYSIA', 'MV'=>'MALDIVES', 'ML'=>'MALI', 'MT'=>'MALTA', 'MH'=>'MARSHALL ISLANDS', 'MQ'=>'MARTINIQUE', 'MR'=>'MAURITANIA', 'MU'=>'MAURITIUS', 'YT'=>'MAYOTTE', 'MX'=>'MEXICO', 'FM'=>'MICRONESIA, FEDERATED STATES OF', 'MD'=>'MOLDOVA, REPUBLIC OF', 'MC'=>'MONACO', 'MN'=>'MONGOLIA', 'MS'=>'MONTSERRAT', 'MA'=>'MOROCCO', 'MZ'=>'MOZAMBIQUE', 'MM'=>'MYANMAR', 'NA'=>'NAMIBIA', 'NR'=>'NAURU', 'NP'=>'NEPAL', 'NL'=>'NETHERLANDS', 'AN'=>'NETHERLANDS ANTILLES', 'NC'=>'NEW CALEDONIA', 'NZ'=>'NEW ZEALAND', 'NI'=>'NICARAGUA', 'NE'=>'NIGER', 'NG'=>'NIGERIA', 'NU'=>'NIUE', 'NF'=>'NORFOLK ISLAND', 'MP'=>'NORTHERN MARIANA ISLANDS', 'NO'=>'NORWAY', 'OM'=>'OMAN', 'PK'=>'PAKISTAN', 'PW'=>'PALAU', 'PS'=>'PALESTINIAN TERRITORY, OCCUPIED', 'PA'=>'PANAMA', 'PG'=>'PAPUA NEW GUINEA', 'PY'=>'PARAGUAY', 'PE'=>'PERU', 'PH'=>'PHILIPPINES', 'PN'=>'PITCAIRN', 'PL'=>'POLAND', 'PT'=>'PORTUGAL', 'PR'=>'PUERTO RICO', 'QA'=>'QATAR', 'RE'=>'REUNION', 'RO'=>'ROMANIA', 'RU'=>'RUSSIAN FEDERATION', 'RW'=>'RWANDA', 'SH'=>'SAINT HELENA', 'KN'=>'SAINT KITTS AND NEVIS', 'LC'=>'SAINT LUCIA', 'PM'=>'SAINT PIERRE AND MIQUELON', 'VC'=>'SAINT VINCENT AND THE GRENADINES', 'WS'=>'SAMOA', 'SM'=>'SAN MARINO', 'ST'=>'SAO TOME AND PRINCIPE', 'SA'=>'SAUDI ARABIA', 'SN'=>'SENEGAL', 'SC'=>'SEYCHELLES', 'SL'=>'SIERRA LEONE', 'SG'=>'SINGAPORE', 'SK'=>'SLOVAKIA', 'SI'=>'SLOVENIA', 'SB'=>'SOLOMON ISLANDS', 'SO'=>'SOMALIA', 'ZA'=>'SOUTH AFRICA', 'GS'=>'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'ES'=>'SPAIN', 'LK'=>'SRI LANKA', 'SD'=>'SUDAN', 'SR'=>'SURINAME', 'SJ'=>'SVALBARD AND JAN MAYEN', 'SZ'=>'SWAZILAND', 'SE'=>'SWEDEN', 'CH'=>'SWITZERLAND', 'SY'=>'SYRIAN ARAB REPUBLIC', 'TW'=>'TAIWAN, PROVINCE OF CHINA', 'TJ'=>'TAJIKISTAN', 'TZ'=>'TANZANIA, UNITED REPUBLIC OF', 'TH'=>'THAILAND', 'TG'=>'TOGO', 'TK'=>'TOKELAU', 'TO'=>'TONGA', 'TT'=>'TRINIDAD AND TOBAGO', 'TN'=>'TUNISIA', 'TR'=>'TURKEY', 'TM'=>'TURKMENISTAN', 'TC'=>'TURKS AND CAICOS ISLANDS', 'TV'=>'TUVALU', 'UG'=>'UGANDA', 'UA'=>'UKRAINE', 'AE'=>'UNITED ARAB EMIRATES', 'GB'=>'UNITED KINGDOM', 'US'=>'UNITED STATES', 'UM'=>'UNITED STATES MINOR OUTLYING ISLANDS', 'UY'=>'URUGUAY', 'UZ'=>'UZBEKISTAN', 'VU'=>'VANUATU', 'VE'=>'VENEZUELA', 'VN'=>'VIET NAM', 'VG'=>'VIRGIN ISLANDS, BRITISH', 'VI'=>'VIRGIN ISLANDS, U.S.', 'WF'=>'WALLIS AND FUTUNA', 'EH'=>'WESTERN SAHARA', 'YE'=>'YEMEN', 'YU'=>'YUGOSLAVIA', 'ZM'=>'ZAMBIA', 'ZW'=>'ZIMBABWE', 'ZZ'=>'OTHER (NOT DISPLAYED)',);
	
	return ucwords(strtolower($aCountry[$iCountryID]));
}

function TanggalIndo($ddddmmyy){
$bulan=array(
           1 => "Jan",
           2 => "Feb",
           3 => "Mar",
           4 => "Apr",
           5 => "Mei",
           6 => "Jun",
           7 => "Jul",
           8 => "Aug",
           9 => "Sep",
           10 => "Oct",
           11 => "Nov",
           12 => "Des"
         );
  $buf=explode('-', $ddddmmyy);
  return $buf[2]." ".$bulan[$buf[1]+0]." ".$buf[0];
}


/*
Function to Convert GMT Time

ex : print date("G:i:s l, F jS Y", ConvertGMT(-7)); 
*/
function ConvertGMT($cgmt) {
	$now	= time(); 
	$sgmt	= date("Z"); 
	$sgmt	= $sgmt/3600; 
	$diffh	= $sgmt.$cgmt;

	if (is_int(strpos("-",$cgmt))) { 
		$diffh = eval($diffh); 
	} else { 
		$diffh = $sgmt - $cgmt; 
	}

	$realtime = $now - ($diffh*3600); 

	return $realtime; 
}

function CountTotalRecord($tablename = "", $where = "") {
	$SQLCount	= "SELECT COUNT(id) as TotalCount FROM ".$tablename;

	if ($where != "") {
		$SQLCount .= " WHERE ".$where;
	}

	$RecordCount	= mysql_fetch_object(mysql_query($SQLCount));

	return $RecordCount->TotalCount;
}

/*
format : TimeDifference("2004-03-23 09:13:55", +7);
*/
function TimeDifference($StringDate, $TimeDiff = +7) {
	$ConvertDateTime	= strtotime($StringDate) + (3600 * $TimeDiff);

	return $ConvertDateTime;
}

/*
format : ViewDateTimeFormat("2004-03-23 09:13:55", 1);
*/

function ViewDateTimeFormat($StringDate, $Mode = 1) {
	if ($StringDate == "") {
		return "-";
	} else {
		$aDate		= substr($StringDate, 8, 2);
		$aMonth		= substr($StringDate, 5, 2);
		$aYear		= substr($StringDate, 0, 4);
		$aHour		= substr($StringDate, 11, 2);
		$aMinute	= substr($StringDate, 14, 2);
		$aSecond	= substr($StringDate, 17, 2);

		switch ($Mode) {
			/* 23-03-2004 09:13:55 */
			case 1:
				return $aDate."-".$aMonth."-".$aYear." ".$aHour.":".$aMinute.":".$aSecond;
				break;
			/* 23 Mar 2004 09:13:55 */
			case 2:
				return $aDate." ".GetMonthName($aMonth, "shortdate", "in")." ".$aYear." ".$aHour.":".$aMinute.":".$aSecond;
				break;
			/* 23 March 09:13:55 */
			case 3:
				return $aDate." ".GetMonthName($aMonth, "longdate", "in")." ".$aYear." ".$aHour.":".$aMinute.":".$aSecond;
				break;
			/* 23/03/2004 09:13:55 */
			case 4:
				return $aDate."/".$aMonth."/".$aYear." ".$aHour.":".$aMinute.":".$aSecond;
				break;
			/* 23/03/2004 09:13:55 */
			case 5:
				return $aDate."/".$aMonth."/".$aYear;
				break;
			/* 23 March 2005 */
			case 6:
				return $aDate." ".GetMonthName($aMonth, "longdate", "en")." ".$aYear;
				break;
		}
	}
}


function ContentParser($Content) {
	//$Content	= stripslashes($Content);
	//$Content	= nl2br(strip_tags($Content));
	$Content	= preg_replace( "#<#", "&#60;", $Content );
	$Content	= preg_replace( "#>#", "&#62;", $Content );
	$Content	= preg_replace( "#\[b\](.+?)\[/b\]#is", "<strong>\\1</strong>", $Content);
	$Content	= preg_replace( "#\[i\](.+?)\[/i\]#is", "<em>\\1</em>", $Content);
	$Content	= preg_replace( "#\[u\](.+?)\[/u\]#is", "<u>\\1</u>", $Content);
	$Content	= preg_replace( "#\[s\](.+?)\[/s\]#is", "<s>\\1</s>", $Content);

	// email tags
	// [email]udhien@udhien.net[/email]   [email=udhien@udhien.net]Email me[/email]

	$Content	= preg_replace( "#\[email\](\S+?)\[/email\]#i", "<a href='mailto:\\1'>\\1</a>", $Content);
	$Content	= preg_replace( "#\[email\s*=\s*\&quot\;([\.\w\-]+\@[\.\w\-]+\.[\.\w\-]+)\s*\&quot\;\s*\](.*?)\[\/email\]#i"  , "<a href='mailto:\\1'>\\2</a>", $Content);
	$Content	= preg_replace( "#\[email\s*=\s*([\.\w\-]+\@[\.\w\-]+\.[\w\-]+)\s*\](.*?)\[\/email\]#i", "<a href='mailto:\\1'>\\2</a>", $Content);

	// url tags
	// [url]http://www.index.com[/url]   [url=http://www.index.com]ibforums![/url]

	$Content	= preg_replace( "#\[url\](\S+?)\[/url\]#ie", "RegexBuildURL(array('html' => '\\1', 'show' => '\\1'))", $Content);
	$Content	= preg_replace( "#\[url\s*=\s*\&quot\;\s*(\S+?)\s*\&quot\;\s*\](.*?)\[\/url\]#ie" , "RegexBuildURL(array('html' => '\\1', 'show' => '\\2'))", $Content);
	$Content	= preg_replace( "#\[url\s*=\s*(\S+?)\s*\](.*?)\[\/url\]#ie", "RegexBuildURL(array('html' => '\\1', 'show' => '\\2'))", $Content);
	$Content	= preg_replace( "#\[code\](.+?)\[/code\]#ies", "RegexCodeTag('\\1')", $Content);

	//img tags
	//[img]http://www.url.com[/img]
	$Content	= preg_replace( "#\[img\](.+?)\[/img\]#ie", "RegexCheckImage('\\1')", $Content );

	return $Content;
}

/**************************************************/
// RegexBuildURL: Checks, and builds the a href
// html
/**************************************************/

function RegexBuildURL($url=array()) {

	$skip_it = 0;
	
	// Make sure the last character isn't punctuation.. if it is, remove it and add it to the
	// end array
	
	if ( preg_match( "/([\.,\?]|&#33;)$/", $url['html'], $match) )
	{
		$url['end'] .= $match[1];
		$url['html'] = preg_replace( "/([\.,\?]|&#33;)$/", "", $url['html'] );
		$url['show'] = preg_replace( "/([\.,\?]|&#33;)$/", "", $url['show'] );
	}
	
	// Make sure it's not being used in a closing code/quote/html or sql block
	
	if (preg_match( "/\[\/(html|quote|code|sql)/i", $url['html']) )
	{
		return $url['html'];
	}
	
	// clean up the ampersands
	$url['html'] = preg_replace( "/&amp;/" , "&" , $url['html'] );
	
	// Make sure we don't have a JS link
	$url['html'] = preg_replace( "/javascript:/i", "java script&#58; ", $url['html'] );
	
	// Do we have http:// at the front?
	
	if ( ! preg_match("#^(http|news|https|ftp|aim)://#", $url['html'] ) )
	{
		$url['html'] = 'http://'.$url['html'];
	}
	
	//-------------------------
	// Tidy up the viewable URL
	//-------------------------

	if (preg_match( "/^<img src/i", $url['show'] )) $skip_it = 1;

	$url['show'] = preg_replace( "/&amp;/" , "&" , $url['show'] );
	$url['show'] = preg_replace( "/javascript:/i", "javascript&#58; ", $url['show'] );
	
	if (strlen($url['show']) < 55)  $skip_it = 1;
	
	// Make sure it's a "proper" url
	
	if (!preg_match( "/^(http|ftp|https|news):\/\//i", $url['show'] )) $skip_it = 1;
	
	$show     = $url['show'];
	
	if ($skip_it != 1) {
		$stripped = preg_replace( "#^(http|ftp|https|news)://(\S+)$#i", "\\2", $url['show'] );
		$uri_type = preg_replace( "#^(http|ftp|https|news)://(\S+)$#i", "\\1", $url['show'] );
		
		$show = $uri_type.'://'.substr( $stripped , 0, 35 ).'...'.substr( $stripped , -15   );
	}
	
	return $url['st'] . "<a href='".$url['html']."' target='_blank'>".$show."</a>" . $url['end'];
	
}

/**************************************************/
// RegexCodeTag: Builds this code tag HTML
// 
/**************************************************/

function RegexCodeTag($txt="") {
	global $ibforums;
	
	$default = "\[code\]$txt\[/code\]";
	
	if ($txt == "") return;
	
	// Too many embedded code/quote/html/sql tags can crash Opera and Moz
	
	if (preg_match( "/\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\].+?\[(quote|code|html|sql)\]/i", $txt) ) {
		return $default;
	}
	
	// Take a stab at removing most of the common
	// smilie characters.
	$txt = stripslashes($txt);
	$txt = preg_replace( "#<#"      , "&#60;", $txt );
	$txt = preg_replace( "#>#"      , "&#62;", $txt );
	$txt = preg_replace( "#&lt;#"   , "&#60;", $txt );
	$txt = preg_replace( "#&gt;#"   , "&#62;", $txt );
	$txt = preg_replace( "#&quot;#" , "&#34;", $txt );
	$txt = preg_replace( "#\s{1};#" , "&#59;", $txt );
	$txt = preg_replace( "#:#"      , "&#58;", $txt );
	$txt = preg_replace( "#\[#"     , "&#91;", $txt );
	$txt = preg_replace( "#\]#"     , "&#93;", $txt );
	$txt = preg_replace( "#\)#"     , "&#41;", $txt );
	$txt = preg_replace( "#\(#"     , "&#40;", $txt );
	//$txt = preg_replace( "#\r#"     , "<br>" , $txt );
	$txt = preg_replace( "#\n#"     , "<br>" , $txt );
	
	// Ensure that spacing is preserved
	
	$txt = preg_replace( "#\s{2}#", " &nbsp;", $txt );
	
	$html = WrapStyle( array( 'STYLE' => 'CODE' ) );
	
	return "<!--c1-->{$html['START']}<!--ec1-->$txt<!--c2-->{$html['END']}<!--ec2-->";
	
}

/**************************************************/
// wrap style:
// code and quote table HTML generator
/**************************************************/

function WrapStyle( $in=array() ) {
	global $ibforums;
	
	if (! isset($in['TYPE']) )  $in['TYPE']  = 'id';
	if (! isset($in['CSS']) )   $in['CSS']   = 'postcolor';
	if (! isset($in['STYLE']) ) $in['STYLE'] = 'QUOTE';
	
	//-----------------------------
	// This returns two array elements:
	//  START: Contains the HTML code for the start wrapper
	//  END  : Contains the HTML code for the end wrapper
	//-----------------------------
	
	$possible_use = array( 'CODE'  => array( 'CODE',  'CODE' ),
						   'QUOTE' => array( 'QUOTE', 'QUOTE'  ),
						   'SQL'   => array( 'CODE' , 'SQL'),
						   'HTML'  => array( 'CODE' , 'HTML'),
						   'PHP'   => array( 'CODE' , 'PHP')
						 );
						 
	return array( 'START' => "</span><table border='0' align='center' width='95%' cellpadding='3' cellspacing='1'><tr><td><b>{$possible_use[$in[STYLE]][1]}</b> {$in[EXTRA]}</td></tr><tr><td id='{$possible_use[ $in[STYLE] ][0]}'>",
				  'END'   => "</td></tr></table><span {$in[TYPE]}='{$in[CSS]}'>"
				);
}

/**************************************************/
// RegexCheckImage: Checks, and builds the <img>
// html.
/**************************************************/

function RegexCheckImage($url="") {
	global $ibforums;
	
	if (!$url) return;
	
	$url = trim($url);
	
	$default = "[img]".$url."[/img]";
	
	++$this->image_count;
	
	// Make sure we've not overriden the set image # limit
	
	if ($ibforums->vars['max_images'])
	{
		if ($this->image_count > $ibforums->vars['max_images'])
		{
			$this->error = 'too_many_img';
			return $default;
		}
	}
	
	// Are they attempting to post a dynamic image, or JS?
	
	if ($ibforums->vars['allow_dynamic_img'] != 1)
	{
		if (preg_match( "/[?&;]/", $url))
		{
			$this->error = 'no_dynamic';
			return $default;
		}
		if (preg_match( "/javascript(\:|\s)/i", $url ))
		{
			$this->error = 'no_dynamic';
			return $default;
		}
	}
	
	// Is the img extension allowed to be posted?
	
	if ($ibforums->vars['img_ext'])
	{
		$extension = preg_replace( "/^.*\.(\S+)$/", "\\1", $url );
		$extension = strtolower($extension);
		$ibforums->vars['img_ext'] = strtolower($ibforums->vars['img_ext']);
		if (!preg_match( "/$extension(\||$)/", $ibforums->vars['img_ext'] ))
		{
			$this->error = 'invalid_ext';
			return $default;
		}
	}
	
	// Is it a legitimate image?
	
	if (!preg_match( "/^(http|https|ftp):\/\//i", $url )) {
		$this->error = 'no_dynamic';
		return $default;
	}
	
	// If we are still here....
	
	return "<img src='$url' border='0' alt=''>";
}

/*
Source :
http://www.zend.com/codex.php?id=947&single=1
*/
function ConvertMoneyFormatIndo($string) {

   $Negative = 0;
      
   //check to see if number is negative
    if(preg_match("/^-/",$string))
    {
     //setflag
     $Negative = 1;
     //remove negative sign
     $string = preg_replace("|-|","",$string);
    }

   //look for commas in the string and remove them.    
   $string = preg_replace("|,|","",$string);
   
   // split the string into two parts First and Second
   // First is before decimal, second is after. format = First.Second
   $Full = split("[.]",$string);
  
   $Count = count($Full);
    
   if($Count > 1)
   {
    $First = $Full[0];
    $Second = $Full[1];
     $NumCents = strlen($Second);
      if($NumCents == 2)
       {
           //do nothing already at correct length
       }
      else if($NumCents < 2)
       {
           //add an extra zero to the end
           $Second = $Second . "0";
       }
      else if($NumCents > 2)
       {
           //either string off the end digits or round up
           // I say string everything but the first 3 digits and then round
        // since it is rare that anything after 3 digits effects the round
        // you can change if you need greater accurcy, I don't so I didn't
           // write that into the code.
           $Temp = substr($Second,0,3);
           $Rounded = round($Temp,-1);
           $Second = substr($Rounded,0,2);
           
       }  

   }
   else
   {
    //there was no decimal on the end so add to zeros    
    $First = $Full[0];    
    $Second = "00";
   }

  $length = strlen($First);

  if( $length <= 3 )
    {
     //To Short to add a comma
    //combine the first part and the second.
    $string = $First . "." . $Second;    

    if($Negative == 1)
     {    
      $string = "-" . $string;
     }

    return $string;
    }
  else
    {
    $loop_count = intval( ( $length / 3 ) );
    $section_length = -3;
    for( $i = 0; $i < $loop_count; $i++ )
      {
      $sections[$i] = substr( $First, $section_length, 3 );
      $section_length = $section_length - 3;
      }

    $stub = ( $length % 3 );    
    if( $stub != 0 )
      {
      $sections[$i] = substr( $First, 0, $stub );
      }
    $Done = implode( ".", array_reverse( $sections ) );
    $Done = $Done . "," . $Second;

    if($Negative == 1)
     {    
      $Done = "-" . $Done;
     }

    return  "Rp. ".$Done;
    }
  }

/*
Source :
http://www.zend.com/codex.php?id=947&single=1
*/
function ConvertUSMoneyFormat($string) {

   $Negative = 0;
      
   //check to see if number is negative
    if(preg_match("/^-/",$string))
    {
     //setflag
     $Negative = 1;
     //remove negative sign
     $string = preg_replace("|-|","",$string);
    }

   //look for commas in the string and remove them.    
   $string = preg_replace("|,|","",$string);
   
   // split the string into two parts First and Second
   // First is before decimal, second is after. format = First.Second
   $Full = split("[.]",$string);
  
   $Count = count($Full);
    
   if($Count > 1)
   {
    $First = $Full[0];
    $Second = $Full[1];
     $NumCents = strlen($Second);
      if($NumCents == 2)
       {
           //do nothing already at correct length
       }
      else if($NumCents < 2)
       {
           //add an extra zero to the end
           $Second = $Second . "0";
       }
      else if($NumCents > 2)
       {
           //either string off the end digits or round up
           // I say string everything but the first 3 digits and then round
        // since it is rare that anything after 3 digits effects the round
        // you can change if you need greater accurcy, I don't so I didn't
           // write that into the code.
           $Temp = substr($Second,0,3);
           $Rounded = round($Temp,-1);
           $Second = substr($Rounded,0,2);
           
       }  

   }
   else
   {
    //there was no decimal on the end so add to zeros    
    $First = $Full[0];    
    $Second = "00";
   }

  $length = strlen($First);

  if( $length <= 3 )
    {
     //To Short to add a comma
    //combine the first part and the second.
    $string = $First . "." . $Second;    

    if($Negative == 1)
     {    
      $string = "-" . $string;
     }

    return $string;
    }
  else
    {
    $loop_count = intval( ( $length / 3 ) );
    $section_length = -3;
    for( $i = 0; $i < $loop_count; $i++ )
      {
      $sections[$i] = substr( $First, $section_length, 3 );
      $section_length = $section_length - 3;
      }

    $stub = ( $length % 3 );    
    if( $stub != 0 )
      {
      $sections[$i] = substr( $First, 0, $stub );
      }
    $Done = implode( ",", array_reverse( $sections ) );
    $Done = $Done . "." . $Second;

    if($Negative == 1)
     {    
      $Done = "-" . $Done;
     }

    return  "US$ ".$Done;
    }
  }

  function Clickable($text) { // original function: phpBB, extended here for AIM & ICQ
    $ret = " " . $text;
    $ret = preg_replace("#([\n ])([a-z]+?)://([^, <>{}\n\r]+)#i", "\\1<a href=\"\\2://\\3\" target=\"_blank\">\\2://\\3</a>", $ret);
    $ret = preg_replace("#([\n ])aim:([^,< \n\r]+)#i", "\\1<a href=\"aim:goim?screenname=\\2\\3&message=Hello\">\\2\\3</a>", $ret);
    $ret = preg_replace("#([\n ])icq:([^,< \n\r]+)#i", "\\1<a href=\"http://wwp.icq.com/scripts/search.dll?to=\\2\\3\">\\2\\3</a>", $ret);
    $ret = preg_replace("#([\n ])www\.([a-z0-9\-]+)\.([a-z0-9\-.\~]+)((?:/[^,< \n\r]*)?)#i", "\\1<a href=\"http://www.\\2.\\3\\4\" target=\"_blank\">www.\\2.\\3\\4</a>", $ret);
    $ret = preg_replace("#([\n ])([a-z0-9\-_.]+?)@([^,< \n\r]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
    $ret = substr($ret, 1);
    return $ret;
  }

function dateDifference($date1, $date2)
{
    $d1 = (is_string($date1) ? strtotime($date1) : $date1);
    $d2 = (is_string($date2) ? strtotime($date2) : $date2);

    $diff_secs = abs($d1 - $d2);
    $base_year = min(date("Y", $d1), date("Y", $d2));

    $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);

    return array
    (
        "years"                 => abs(substr(date('Ymd', $d1) - date('Ymd', $d2), 0, -4)),
        "months_total"  => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
        "months"                => date("n", $diff) - 1,
        "days_total"    => floor($diff_secs / (3600 * 24)),
        "days"                  => date("j", $diff) - 1,
        "hours_total"   => floor($diff_secs / 3600),
        "hours"                 => date("G", $diff),
        "minutes_total" => floor($diff_secs / 60),
        "minutes"               => (int) date("i", $diff),
        "seconds_total" => $diff_secs,
        "seconds"               => (int) date("s", $diff)
    );
} 

/*-----------------------------------------------------------------------------------
Create Drop Down List

format :
	Draw_DropDownList($variable, $value, $stylesheet);

example :
	Draw_DropDownList("SecondOfBirth", $SecondOfBirth, "selectsytle");
-----------------------------------------------------------------------------------*/
function DrawCategory($FormName, $FormValue = "", $FormStyle) {
	global $Tb_LUCategory;

	$DropDown	 = "<select name=\"".$FormName."\" id=\"".$FormName."\" size=\"1\" class=\"".$FormStyle."\">\r\n";

	$SQL	= mysql_query("SELECT CategoryID, CategoryName FROM $Tb_LUCategory ORDER BY CategoryName ASC") or die(mysql_errno()." : ".mysql_error());

	while ($Query = mysql_fetch_object($SQL)) {
		($FormValue == $Query->CategoryID) ? $Selected = "selected" : $Selected = "";
		$DropDown	.= "<option value=\"".$Query->CategoryID."\" ".$Selected.">".$Query->CategoryName."</option>\n";
	}

	$DropDown	.= "</select>";

	unset($SQL);

	return $DropDown;
}

/*-----------------------------------------------------------------------------------
Add TotalDownline for Upline

format :
	AddTotalDownline($iRefID, $sMathOperator, $iLoopCount);

example :
	AddTotalDownline("1", "plus/minus", "0");
-----------------------------------------------------------------------------------*/
function AddTotalDownline($iTDRefID, $sMathOperator, $iLoopCount) {
	global $Tb_Member;

	//Get TotalDownline from Upline 
	$dataTD			= mysql_fetch_object(mysql_query("SELECT TotalDownline FROM $Tb_Member WHERE MemberID = '".$iTDRefID."'"));
	$iTotalDownline	= $dataTD->TotalDownline;
	

	if ($sMathOperator == "plus") {
		$iNewTotalDownline	= $iTotalDownline + 1;
	} else if ($sMathOperator == "minus") {
		$iNewTotalDownline	= $iTotalDownline - 1;
	}	

	mysql_query("UPDATE $Tb_Member SET TotalDownline = '".$iNewTotalDownline."' WHERE MemberID = '".$iTDRefID."'") or die(mysql_errno()." : ".mysql_error());
	
	//Get Upline MemberID 
	$dataMemberID		= mysql_fetch_object(mysql_query("SELECT RefID FROM $Tb_Member WHERE MemberID = '".$iTDRefID."'"));
	$iUplineMemberID	= $dataMemberID->RefID;
	if (!empty($iUplineMemberID)) {
		$iNewLoopCount	= $iLoopCount + 1;
		if ($iNewLoopCount != 4) {
			AddTotalDownline($iUplineMemberID, $sMathOperator, $iNewLoopCount);
		}
	}
}
/*-----------------------------------------------------------------------------------
Get All Upline Info New

format :
	GetAllUplineInfoNew($iRefID, $iLoopCount);

example :
	GetAllUplineInfoNew("1", "0");
-----------------------------------------------------------------------------------*/
function GetAllUplineInfoNew($iUIRefID, $iLoopCount) {
	global $Tb_Member;
	
	$sSQLNew	= "SELECT Username, FullName, DateCreated, LastLogin, BankAccount, Email FROM $Tb_Member WHERE Active = '1' AND MemberID IN ('".$iUIRefID."'";
	//upline level IV
	if (!empty($iUIRefID)) {
		$SQLUplineRefID		= mysql_query("SELECT RefID FROM $Tb_Member WHERE MemberID = '".$iUIRefID."'") or die(mysql_errno()." : ".mysql_error());
		if (mysql_num_rows($SQLUplineRefID) != 0) {
			if ($oUpline = mysql_fetch_object($SQLUplineRefID)) {
				$iUplineRefID			= $oUpline->RefID;
				$sSQLNew	.= ", '".$iUplineRefID."'";
				//upline level III
				if (!empty($iUplineRefID)) {
					$SQLUplineRefID2		= mysql_query("SELECT RefID FROM $Tb_Member WHERE MemberID = '".$iUplineRefID."'") or die(mysql_errno()." : ".mysql_error());
					if (mysql_num_rows($SQLUplineRefID2) != 0) {
						if ($oUpline2 = mysql_fetch_object($SQLUplineRefID2)) {
							$iUplineRefID2			= $oUpline2->RefID;
							$sSQLNew	.= ", '".$iUplineRefID2."'";
							//upline level II
							if (!empty($iUplineRefID2)) {
								$SQLUplineRefID3		= mysql_query("SELECT RefID FROM $Tb_Member WHERE MemberID = '".$iUplineRefID2."'") or die(mysql_errno()." : ".mysql_error());
								if (mysql_num_rows($SQLUplineRefID3) != 0) {
									if ($oUpline3 = mysql_fetch_object($SQLUplineRefID3)) {
										$iUplineRefID3			= $oUpline3->RefID;
										
										$sSQLNew	.= ", '".$iUplineRefID3."'";
										
										
									}
								}
							}
							//upline level II end
						}
					}
				}
				//upline level III end
			}
		}
	}
	//upline level IV end

	$sSQLNew	.= ") ORDER BY MemberID";
	$SQLUplineInfoNew	= mysql_query($sSQLNew) or die(mysql_errno()." : ".mysql_error());
	
	if (mysql_num_rows($SQLUplineInfoNew) != 0) {
		echo "<table width=\"100%\" cellpadding=\"1\" cellspacing=\"2\" border=\"0\">";
		echo "<tr><td class=\"FormTDRight\"><strong>Level</strong></td><td class=\"FormTDRight\"><strong>Nama</strong></td><td class=\"FormTDRight\"><strong>Rekening BCA</strong></td><td class=\"FormTDRight\"><strong>Email</strong></td></tr>";
		echo "<tr align=\"left\"><td align=\"center\" class=\"FormTDRight\">0</td><td class=\"FormTDRight\">A.Prastowo</td><td class=\"FormTDRight\">345 173 0655</td><td class=\"FormTDRight\">herry_groove@yahoo.com</td></tr>";
		$iLevel	= "1";
		while ($oUplineList = mysql_fetch_object($SQLUplineInfoNew)) {
			echo "<tr align=\"left\"><td align=\"center\" class=\"FormTDRight\">".$iLevel."</td><td class=\"FormTDRight\">".$oUplineList->FullName."</td><td class=\"FormTDRight\">". $oUplineList->BankAccount."</td><td class=\"FormTDRight\">". $oUplineList->Email."</td></tr>";
			$iLevel++;
		}
		echo "</table>";
	}
}
?>