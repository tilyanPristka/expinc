<?php
/**************************************************************************
 *
 * File:				func.content.php
 * Author:				Mohammad Syafiuddin / Udhien <udhien@udhien.net>
 * Email :				udhien@udhien.net / udhien@mediamaya.com
 * Date:				2004-12-31
 * Last change:			2004-01-02
 * Copyright:			(c) 2004 Udhien - http://www.udhien.net
 *						Part of Mediamaya.com - eBusiness Development
 *						http://www.mediamaya.com
 * 
 **************************************************************************/

class ContentExchange {
	function GetTitleExchange($id, $lang) {
		$this->id		= $id;
		$this->language	= $lang;
		
		$Query	= mysql_query("SELECT Title, TitleEnglish FROM mm_contentexchange WHERE ContentID = '".$this->id."'") or die(mysql_errno." : ".mysql_error());

		if ($oQuery = mysql_fetch_object($Query)) {
			if ($this->language == "ID") {
				$this->output	= $oQuery->Title;
			} else if ($this->language == "EN") {
				$this->output	= $oQuery->TitleEnglish;
			} else {
				$this->output	= "No Data Found";
			}
		}

		return $this->output;
	}

	function GetContentExchange($id, $lang) {
		$this->id		= $id;
		$this->language	= $lang;

		$Query	= mysql_query("SELECT Content, ContentEnglish FROM mm_contentexchange WHERE ContentID = '".$this->id."'") or die(mysql_errno." : ".mysql_error());

		if ($oQuery = mysql_fetch_object($Query)) {
			if ($this->language == "ID") {
				$this->output	= $oQuery->Content;
			} else if ($this->language == "EN") {
				$this->output	= $oQuery->ContentEnglish;
			} else {
				$this->output	= "No Data Found";
			}
		}

		return $this->output;
	}
}

/* C O N T E N T */
function CheckQueryStringContent($iMenuID, $iContentID) {
	if (empty($iMenuID) || empty($iContentID)) {
		echo "<meta http-equiv=\"refresh\" content=\"0;URL=index.php?\">";
		exit();
	}
}

function GetBreadCrumb($iMenuID = 0, $sLanguage = 'ID') {
	global $Tb_Menu;
	$sString = "";

	if ($sLanguage == "ID") {
		$SQLSubMenu	= mysql_query("SELECT Name, ParentMenuID FROM $Tb_Menu WHERE MenuID = '".$iMenuID."' AND Enabled = '1'") or die(mysql_errno()." : ".mysql_error());

		if ($oSubMenu = mysql_fetch_object($SQLSubMenu)) {
			$sSubMenuString	= $oSubMenu->Name;

			$SQLMenu	= mysql_query("SELECT Name FROM $Tb_Menu WHERE MenuID = '".$oSubMenu->ParentMenuID."'") or die(mysql_errno()." : ".mysql_error());

			if ($oMenu = mysql_fetch_object($SQLMenu)) {
				$sMenuString	= $oMenu->Name;
			} else {
				$sMenuString	= "";
			}
		} else {
			$sSubMenuString	= "";
		}
	} else if ($sLanguage == "EN") {
		$SQLSubMenu	= mysql_query("SELECT NameEnglish, ParentMenuID FROM $Tb_Menu WHERE MenuID = '".$iMenuID."' AND Enabled = '1'") or die(mysql_errno()." : ".mysql_error());

		if ($oSubMenu = mysql_fetch_object($SQLSubMenu)) {
			$sSubMenuString	= $oSubMenu->NameEnglish;

			$SQLMenu	= mysql_query("SELECT NameEnglish FROM $Tb_Menu WHERE MenuID = '".$oSubMenu->ParentMenuID."'") or die(mysql_errno()." : ".mysql_error());

			if ($oMenu = mysql_fetch_object($SQLMenu)) {
				$sMenuString	= $oMenu->NameEnglish;
			} else {
				$sMenuString	= "";
			}
		} else {
			$sSubMenuString	= "";
		}
	}

	return "<strong>Direktorat KESWAN</strong> &raquo; ".$sMenuString." &raquo; ".$sSubMenuString."";
}

function GetTitleContent($iMenuID = 0, $iContentID = 0, $sLanguage = 'ID') {
	global $Tb_Content;
	$sString = "";

	$SQLQuery	= mysql_query("SELECT Title FROM $Tb_Content WHERE ContentID = '".$iContentID."' AND MenuID = '".$iMenuID."' AND Language = '".$sLanguage."' AND Status = '1'") or die(mysql_errno()." : ".mysql_error());

	if ($oQuery = mysql_fetch_object($SQLQuery)) {
		$sString	.= $oQuery->Title;
	} else {
		$sString	.= "";
	}

	return $sString;
}

function GetContent($iMenuID, $iContentID, $sLanguage = 'ID') {
	global $Tb_Content;
	$sString = "";

	$SQLQuery	= mysql_query("SELECT Content FROM $Tb_Content WHERE ContentID = '".$iContentID."' AND MenuID = '".$iMenuID."' AND Language = '".$sLanguage."' AND Status = '1'") or die(mysql_errno()." : ".mysql_error());

	if ($oQuery = mysql_fetch_object($SQLQuery)) {
		$sString	.= $oQuery->Content;
	} else {
		$sString	.= "";
	}

	return $sString;
}
?>