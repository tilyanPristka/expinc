<?php
@session_start();

include("inc.php");
CheckMemberAuthentication();
ob_start();
?>
<?php include "phprptinc/tp_rep_ewrcfg4.php"; ?>
<?php include "phprptinc/tp_rep_ewmysql.php"; ?>
<?php include "phprptinc/tp_rep_ewrfn4.php"; ?>
<?php include "phprptinc/tp_rep_ewrusrfn.php"; ?>
<?php

// Global variable for table object
$Transaction = NULL;

//
// Table class for Transaction
//
class crTransaction {
	var $TableVar = 'Transaction';
	var $TableName = 'Transaction';
	var $TableType = 'CUSTOMVIEW';
	var $ShowCurrentFilter = EWRPT_SHOW_CURRENT_FILTER;
	var $FilterPanelOption = EWRPT_FILTER_PANEL_OPTION;
	var $CurrentOrder; // Current order
	var $CurrentOrderType; // Current order type

	// Table caption
	function TableCaption() {
		global $ReportLanguage;
		return $ReportLanguage->TablePhrase($this->TableVar, "TblCaption");
	}

	// Session Group Per Page
	function getGroupPerPage() {
		return @$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_grpperpage"];
	}

	function setGroupPerPage($v) {
		@$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_grpperpage"] = $v;
	}

	// Session Start Group
	function getStartGroup() {
		return @$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_start"];
	}

	function setStartGroup($v) {
		@$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_start"] = $v;
	}

	// Session Order By
	function getOrderBy() {
		return @$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_orderby"];
	}

	function setOrderBy($v) {
		@$_SESSION[EWRPT_PROJECT_VAR . "_" . $this->TableVar . "_orderby"] = $v;
	}

//	var $SelectLimit = TRUE;
	var $DocID;
	var $DocDate;
	var $DocFullNo;
	var $AccNo;
	var $Type;
	var $AccName;
	var $Description;
	var $Amount;
	var $RefDocID;
	var $DocType;
	var $DocInOut;
	var $DocCode;
	var $DocNotes;
	var $fields = array();
	var $Export; // Export
	var $ExportAll = TRUE;
	var $UseTokenInUrl = EWRPT_USE_TOKEN_IN_URL;
	var $RowType; // Row type
	var $RowTotalType; // Row total type
	var $RowTotalSubType; // Row total subtype
	var $RowGroupLevel; // Row group level
	var $RowAttrs = array(); // Row attributes

	// Reset CSS styles for table object
	function ResetCSS() {
    	$this->RowAttrs["style"] = "";
		$this->RowAttrs["class"] = "";
		foreach ($this->fields as $fld) {
			$fld->ResetCSS();
		}
	}

	//
	// Table class constructor
	//
	function crTransaction() {
		global $ReportLanguage;

		// DocID
		$this->DocID = new crField('Transaction', 'Transaction', 'x_DocID', 'DocID', 'tilyan_bjk_account.DocID', 20, EWRPT_DATATYPE_NUMBER, -1);
		$this->DocID->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['DocID'] =& $this->DocID;
		$this->DocID->DateFilter = "";
		$this->DocID->SqlSelect = "";
		$this->DocID->SqlOrderBy = "";

		// DocDate
		$this->DocDate = new crField('Transaction', 'Transaction', 'x_DocDate', 'DocDate', 'tilyan_bjk_document.DocDate', 133, EWRPT_DATATYPE_DATE, 7);
		$this->DocDate->FldDefaultErrMsg = str_replace("%s", "/", $ReportLanguage->Phrase("IncorrectDateDMY"));
		$this->fields['DocDate'] =& $this->DocDate;
		$this->DocDate->DateFilter = "";
		$this->DocDate->SqlSelect = "";
		$this->DocDate->SqlOrderBy = "";
		$this->DocDate->AdvancedFilters = array(); // Popup filter for DocDate
		$this->DocDate->AdvancedFilters[0][0] = "@@1";
		$this->DocDate->AdvancedFilters[0][1] = $ReportLanguage->Phrase("LastTwoWeeks");
		$this->DocDate->AdvancedFilters[0][2] = ewrpt_IsLast2Weeks(); // Return sql part
		$this->DocDate->AdvancedFilters[1][0] = "@@2";
		$this->DocDate->AdvancedFilters[1][1] = $ReportLanguage->Phrase("LastWeek");
		$this->DocDate->AdvancedFilters[1][2] = ewrpt_IsLastWeek(); // Return sql part
		$this->DocDate->AdvancedFilters[2][0] = "@@3";
		$this->DocDate->AdvancedFilters[2][1] = $ReportLanguage->Phrase("ThisWeek");
		$this->DocDate->AdvancedFilters[2][2] = ewrpt_IsThisWeek(); // Return sql part
		$this->DocDate->AdvancedFilters[3][0] = "@@4";
		$this->DocDate->AdvancedFilters[3][1] = $ReportLanguage->Phrase("NextWeek");
		$this->DocDate->AdvancedFilters[3][2] = ewrpt_IsNextWeek(); // Return sql part
		$this->DocDate->AdvancedFilters[4][0] = "@@5";
		$this->DocDate->AdvancedFilters[4][1] = $ReportLanguage->Phrase("NextTwoWeeks");
		$this->DocDate->AdvancedFilters[4][2] = ewrpt_IsNext2Weeks(); // Return sql part

		// DocFullNo
		$this->DocFullNo = new crField('Transaction', 'Transaction', 'x_DocFullNo', 'DocFullNo', 'tilyan_bjk_document.DocFullNo', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['DocFullNo'] =& $this->DocFullNo;
		$this->DocFullNo->DateFilter = "";
		$this->DocFullNo->SqlSelect = "";
		$this->DocFullNo->SqlOrderBy = "";

		// AccNo
		$this->AccNo = new crField('Transaction', 'Transaction', 'x_AccNo', 'AccNo', 'tilyan_bjk_account.AccNo', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['AccNo'] =& $this->AccNo;
		$this->AccNo->DateFilter = "";
		$this->AccNo->SqlSelect = "";
		$this->AccNo->SqlOrderBy = "";

		// Type
		$this->Type = new crField('Transaction', 'Transaction', 'x_Type', 'Type', 'tilyan_bjk_lookup_account.Type', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['Type'] =& $this->Type;
		$this->Type->DateFilter = "";
		$this->Type->SqlSelect = "";
		$this->Type->SqlOrderBy = "";

		// AccName
		$this->AccName = new crField('Transaction', 'Transaction', 'x_AccName', 'AccName', 'tilyan_bjk_account.AccName', 201, EWRPT_DATATYPE_MEMO, -1);
		$this->fields['AccName'] =& $this->AccName;
		$this->AccName->DateFilter = "";
		$this->AccName->SqlSelect = "";
		$this->AccName->SqlOrderBy = "";

		// Description
		$this->Description = new crField('Transaction', 'Transaction', 'x_Description', 'Description', 'tilyan_bjk_account.Description', 201, EWRPT_DATATYPE_MEMO, -1);
		$this->fields['Description'] =& $this->Description;
		$this->Description->DateFilter = "";
		$this->Description->SqlSelect = "";
		$this->Description->SqlOrderBy = "";

		// Amount
		$this->Amount = new crField('Transaction', 'Transaction', 'x_Amount', 'Amount', 'tilyan_bjk_account.Amount', 131, EWRPT_DATATYPE_NUMBER, -1);
		$this->Amount->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectFloat");
		$this->fields['Amount'] =& $this->Amount;
		$this->Amount->DateFilter = "";
		$this->Amount->SqlSelect = "";
		$this->Amount->SqlOrderBy = "";

		// RefDocID
		$this->RefDocID = new crField('Transaction', 'Transaction', 'x_RefDocID', 'RefDocID', 'tilyan_bjk_document.RefDocID', 20, EWRPT_DATATYPE_NUMBER, -1);
		$this->RefDocID->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['RefDocID'] =& $this->RefDocID;
		$this->RefDocID->DateFilter = "";
		$this->RefDocID->SqlSelect = "";
		$this->RefDocID->SqlOrderBy = "";

		// DocType
		$this->DocType = new crField('Transaction', 'Transaction', 'x_DocType', 'DocType', 'tilyan_bjk_document.DocType', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['DocType'] =& $this->DocType;
		$this->DocType->DateFilter = "";
		$this->DocType->SqlSelect = "";
		$this->DocType->SqlOrderBy = "";

		// DocInOut
		$this->DocInOut = new crField('Transaction', 'Transaction', 'x_DocInOut', 'DocInOut', 'tilyan_bjk_document.DocInOut', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['DocInOut'] =& $this->DocInOut;
		$this->DocInOut->DateFilter = "";
		$this->DocInOut->SqlSelect = "";
		$this->DocInOut->SqlOrderBy = "";

		// DocCode
		$this->DocCode = new crField('Transaction', 'Transaction', 'x_DocCode', 'DocCode', 'tilyan_bjk_document.DocCode', 200, EWRPT_DATATYPE_STRING, -1);
		$this->fields['DocCode'] =& $this->DocCode;
		$this->DocCode->DateFilter = "";
		$this->DocCode->SqlSelect = "";
		$this->DocCode->SqlOrderBy = "";

		// DocNotes
		$this->DocNotes = new crField('Transaction', 'Transaction', 'x_DocNotes', 'DocNotes', 'tilyan_bjk_document.DocNotes', 201, EWRPT_DATATYPE_MEMO, -1);
		$this->fields['DocNotes'] =& $this->DocNotes;
		$this->DocNotes->DateFilter = "";
		$this->DocNotes->SqlSelect = "";
		$this->DocNotes->SqlOrderBy = "";
	}

	// Multiple column sort
	function UpdateSort(&$ofld, $ctrl) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
		} else {
			if ($ofld->GroupingFieldId == 0 && !$ctrl) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = "";
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fld->FldExpression, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fld->FldExpression . " " . $fld->getSort();
				} else {
					if ($sDtlSortSql <> "") $sDtlSortSql .= ", ";
					$sDtlSortSql .= $fld->FldExpression . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ",";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "tilyan_bjk_account Inner Join tilyan_bjk_document On tilyan_bjk_account.DocID = tilyan_bjk_document.DocID Inner Join tilyan_bjk_lookup_account On tilyan_bjk_account.AccNo = tilyan_bjk_lookup_account.AccNo";
	}

	function SqlSelect() { // Select
		return "SELECT High_Priority Straight_Join tilyan_bjk_account.DocID, tilyan_bjk_account.AccNo, tilyan_bjk_account.AccName, tilyan_bjk_account.Description, tilyan_bjk_account.Amount, tilyan_bjk_document.RefDocID, tilyan_bjk_document.DocDate, tilyan_bjk_document.DocFullNo, tilyan_bjk_document.DocType, tilyan_bjk_document.DocInOut, tilyan_bjk_document.DocCode, tilyan_bjk_document.DocNotes, tilyan_bjk_lookup_account.Type FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		return "";
	}

	function SqlGroupBy() { // Group By
		return "tilyan_bjk_account.DocID, tilyan_bjk_account.AccNo, tilyan_bjk_account.AccName, tilyan_bjk_account.Description, tilyan_bjk_account.Amount, tilyan_bjk_document.RefDocID, tilyan_bjk_document.DocDate, tilyan_bjk_document.DocFullNo, tilyan_bjk_document.DocType, tilyan_bjk_document.DocInOut, tilyan_bjk_document.DocCode, tilyan_bjk_document.DocNotes, tilyan_bjk_lookup_account.Type";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "";
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = "order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort();
			return ewrpt_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Row attributes
	function RowAttributes() {
		$sAtt = "";
		foreach ($this->RowAttrs as $k => $v) {
			if (trim($v) <> "")
				$sAtt .= " " . $k . "=\"" . trim($v) . "\"";
		}
		return $sAtt;
	}

	// Field object by fldvar
	function &fields($fldvar) {
		return $this->fields[$fldvar];
	}

	// Table level events
	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// Load Custom Filters event
	function CustomFilters_Load() {

		// Enter your code here	
		// ewrpt_RegisterCustomFilter($this-><Field>, 'LastMonth', 'Last Month', 'GetLastMonthFilter'); // Date example
		// ewrpt_RegisterCustomFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // String example

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//global $MyTable;
		//$MyTable->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Chart Rendering event
	function Chart_Rendering(&$chart) {

		// var_dump($chart);
	}

	// Chart Rendered event
	function Chart_Rendered($chart, &$chartxml) {

		//var_dump($chart);
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}
}
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php

// Create page object
$Transaction_rpt = new crTransaction_rpt();
$Page =& $Transaction_rpt;

// Page init
$Transaction_rpt->Page_Init();

// Page main
$Transaction_rpt->Page_Main();
?>
<?php include "phprptinc/tp_rep_header.php"; ?>
<?php if ($Transaction->Export == "") { ?>
<script type="text/javascript">

// Create page object
var Transaction_rpt = new ewrpt_Page("Transaction_rpt");

// page properties
Transaction_rpt.PageID = "rpt"; // page ID
Transaction_rpt.FormID = "fTransactionrptfilter"; // form ID
var EWRPT_PAGE_ID = Transaction_rpt.PageID;

// extend page with ValidateForm function
Transaction_rpt.ValidateForm = function(fobj) {
	if (!this.ValidateRequired)
		return true; // ignore validation
	var elm = fobj.sv1_DocDate;
	if (elm && !ewrpt_CheckEuroDate(elm.value)) {
		if (!ewrpt_OnError(elm, "<?php echo ewrpt_JsEncode2($Transaction->DocDate->FldErrMsg()) ?>"))
			return false;
	}
	var elm = fobj.sv2_DocDate;
	if (elm && !ewrpt_CheckEuroDate(elm.value)) {
		if (!ewrpt_OnError(elm, "<?php echo ewrpt_JsEncode2($Transaction->DocDate->FldErrMsg()) ?>"))
			return false;
	}

	// Call Form Custom Validate event
	if (!this.Form_CustomValidate(fobj)) return false;
	return true;
}

// extend page with Form_CustomValidate function
Transaction_rpt.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }
<?php if (EWRPT_CLIENT_VALIDATE) { ?>
Transaction_rpt.ValidateRequired = true; // uses JavaScript validation
<?php } else { ?>
Transaction_rpt.ValidateRequired = false; // no JavaScript validation
<?php } ?>
</script>
<link rel="stylesheet" type="text/css" media="all" href="jscalendar/calendar-win2k-1.css" title="win2k-1" />
<script type="text/javascript" src="jscalendar/calendar.js"></script>
<script type="text/javascript" src="jscalendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="jscalendar/calendar-setup.js"></script>
<script language="JavaScript" type="text/javascript">
<!--

// Write your client script here, no need to add script tags.
// To include another .js script, use:
// ew_ClientScriptInclude("my_javascript.js"); 
//-->

</script>
<?php } ?>
<?php $Transaction_rpt->ShowPageHeader(); ?>
<?php if (EWRPT_DEBUG_ENABLED) echo ewrpt_DebugMsg(); ?>
<?php $Transaction_rpt->ShowMessage(); ?>
<?php if ($Transaction->Export == "" || $Transaction->Export == "print" || $Transaction->Export == "email") { ?>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<?php } ?>
<?php if ($Transaction->Export == "") { ?>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script type="text/javascript">

// popup fields
</script>
<?php } ?>
<?php if ($Transaction->Export == "") { ?>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<?php } ?>
<?php if ($Transaction->Export == "" || $Transaction->Export == "print" || $Transaction->Export == "email") { ?>
<?php } ?>
<?php echo $Transaction->TableCaption() ?>
<?php if ($Transaction->Export == "") { ?>
&nbsp;&nbsp;<a href="<?php echo $Transaction_rpt->ExportExcelUrl ?>"><img src="../tp/images/exportxls.gif" /></a>
&nbsp;&nbsp;<a href="<?php echo $Transaction_rpt->ExportWordUrl ?>"><img src="../tp/images/exportdoc.gif" /></a>
&nbsp;&nbsp;<a name="emf_Transaction" id="emf_Transaction" href="javascript:void(0);" onclick="ewrpt_EmailDialogShow({lnk:'emf_Transaction',hdr:ewLanguage.Phrase('ExportToEmail')});"><img src="../tp/images/exportemail.gif" /></a>
<?php if ($Transaction_rpt->FilterApplied) { ?>
&nbsp;&nbsp;<a href="tp_rep_Transactionrpt.php?cmd=reset"><?php echo $ReportLanguage->Phrase("ResetAllFilter") ?></a>
<?php } ?>
<?php } ?>
<br /><br />
<?php if ($Transaction->Export == "") { ?>
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
<?php } ?>
<?php if ($Transaction->Export == "" || $Transaction->Export == "print" || $Transaction->Export == "email") { ?>
<?php } ?>
<?php if ($Transaction->Export == "") { ?>
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td style="vertical-align: top;" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<?php } ?>
<!-- summary report starts -->
<div id="report_summary">
<?php if ($Transaction->Export == "") { ?>
<?php
if ($Transaction->FilterPanelOption == 2 || ($Transaction->FilterPanelOption == 3 && $Transaction_rpt->FilterApplied) || $Transaction_rpt->Filter == "0=101") {
	$sButtonImage = "phprptimages/collapse.gif";
	$sDivDisplay = "";
} else {
	$sButtonImage = "phprptimages/expand.gif";
	$sDivDisplay = " style=\"display: none;\"";
}
?>
<a href="javascript:ewrpt_ToggleFilterPanel();" style="text-decoration: none;"><img id="ewrptToggleFilterImg" src="<?php echo $sButtonImage ?>" alt="" width="9" height="9" border="0"></a><span class="phpreportmaker">&nbsp;<?php echo $ReportLanguage->Phrase("Filters") ?></span><br /><br />
<div id="ewrptExtFilterPanel"<?php echo $sDivDisplay ?>>
<!-- Search form (begin) -->
<form name="fTransactionrptfilter" id="fTransactionrptfilter" action="tp_rep_Transactionrpt.php" class="ewForm" onsubmit="return Transaction_rpt.ValidateForm(this);">
<table class="ewRptExtFilter">
	<tr>
		<td><span class="phpreportmaker"><?php echo $Transaction->DocDate->FldCaption() ?></span></td>
		<td><span class="ewRptSearchOpr"><?php echo $ReportLanguage->Phrase("BETWEEN"); ?><input type="hidden" name="so1_DocDate" id="so1_DocDate" value="BETWEEN"></span></td>
		<td>
			<table cellspacing="0" class="ewItemTable"><tr>
				<td><span class="phpreportmaker">
<input type="text" name="sv1_DocDate" id="sv1_DocDate" value="<?php echo ewrpt_HtmlEncode($Transaction->DocDate->SearchValue) ?>"<?php echo ($Transaction_rpt->ClearExtFilter == 'Transaction_DocDate') ? " class=\"ewInputCleared\"" : "" ?>>
<img src="phprptimages/calendar.png" id="csv1_DocDate" alt="<?php echo $ReportLanguage->Phrase("PickDate"); ?>" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "sv1_DocDate", // ID of the input field
	ifFormat : "%d/%m/%Y", // the date format
	button : "csv1_DocDate" // ID of the button
})
</script>
</span></td>
				<td><span class="ewRptSearchOpr" id="btw1_DocDate" name="btw1_DocDate">&nbsp;<?php echo $ReportLanguage->Phrase("AND") ?>&nbsp;</span></td>
				<td><span class="phpreportmaker" id="btw1_DocDate" name="btw1_DocDate">
<input type="text" name="sv2_DocDate" id="sv2_DocDate" value="<?php echo ewrpt_HtmlEncode($Transaction->DocDate->SearchValue2) ?>"<?php echo ($Transaction_rpt->ClearExtFilter == 'Transaction_DocDate') ? " class=\"ewInputCleared\"" : "" ?>>
<img src="phprptimages/calendar.png" id="csv2_DocDate" alt="<?php echo $ReportLanguage->Phrase("PickDate"); ?>" style="cursor:pointer;cursor:hand;">
<script type="text/javascript">
Calendar.setup({
	inputField : "sv2_DocDate", // ID of the input field
	ifFormat : "%d/%m/%Y", // the date format
	button : "csv2_DocDate" // ID of the button
})
</script>
</span></td>
			</tr></table>			
		</td>
	</tr>
	<tr>
		<td><span class="phpreportmaker"><?php echo $Transaction->Type->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_Type" id="sv_Type"<?php echo ($Transaction_rpt->ClearExtFilter == 'Transaction_Type') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($Transaction->Type->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($Transaction->Type->CustomFilters) ? count($Transaction->Type->CustomFilters) : 0;
$cntd = is_array($Transaction->Type->DropDownList) ? count($Transaction->Type->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	for ($i = 0; $i < $cntf; $i++) {
		if ($Transaction->Type->CustomFilters[$i]->FldName == 'Type') {
?>
		<option value="<?php echo "@@" . $Transaction->Type->CustomFilters[$i]->FilterName ?>"<?php if (ewrpt_MatchedFilterValue($Transaction->Type->DropDownValue, "@@" . $Transaction->Type->CustomFilters[$i]->FilterName)) echo " selected=\"selected\"" ?>><?php echo $Transaction->Type->CustomFilters[$i]->DisplayName ?></option>
<?php
		}
		$wrkcnt += 1;
	}

//}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $Transaction->Type->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($Transaction->Type->DropDownValue, $Transaction->Type->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($Transaction->Type->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}

//}
?>
		</select>
		</span></td>
	</tr>
	<tr>
		<td><span class="phpreportmaker"><?php echo $Transaction->DocType->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_DocType" id="sv_DocType"<?php echo ($Transaction_rpt->ClearExtFilter == 'Transaction_DocType') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($Transaction->DocType->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($Transaction->DocType->CustomFilters) ? count($Transaction->DocType->CustomFilters) : 0;
$cntd = is_array($Transaction->DocType->DropDownList) ? count($Transaction->DocType->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	for ($i = 0; $i < $cntf; $i++) {
		if ($Transaction->DocType->CustomFilters[$i]->FldName == 'DocType') {
?>
		<option value="<?php echo "@@" . $Transaction->DocType->CustomFilters[$i]->FilterName ?>"<?php if (ewrpt_MatchedFilterValue($Transaction->DocType->DropDownValue, "@@" . $Transaction->DocType->CustomFilters[$i]->FilterName)) echo " selected=\"selected\"" ?>><?php echo $Transaction->DocType->CustomFilters[$i]->DisplayName ?></option>
<?php
		}
		$wrkcnt += 1;
	}

//}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $Transaction->DocType->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($Transaction->DocType->DropDownValue, $Transaction->DocType->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($Transaction->DocType->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}

//}
?>
		</select>
		</span></td>
	</tr>
	<tr>
		<td><span class="phpreportmaker"><?php echo $Transaction->DocInOut->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
<?php

// Popup filter
$cntf = is_array($Transaction->DocInOut->CustomFilters) ? count($Transaction->DocInOut->CustomFilters) : 0;
$cntd = is_array($Transaction->DocInOut->DropDownList) ? count($Transaction->DocInOut->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	for ($i = 0; $i < $cntf; $i++) {
		if ($Transaction->DocInOut->CustomFilters[$i]->FldName == 'DocInOut') {
?>
		<?php echo ewrpt_RepeatColumnTable($totcnt, $wrkcnt, 5, 1) ?>
<label><input type="radio" name="$Transaction->DocInOut->DropDownValue" id="$Transaction->DocInOut->DropDownValue" value="<?php echo "@@" . $Transaction->DocInOut->CustomFilters[$i]->FilterName ?>"<?php if (ewrpt_MatchedFilterValue($Transaction->DocInOut->DropDownValue, "@@" . $Transaction->DocInOut->CustomFilters[$i]->FilterName)) echo " checked=\"checked\"" ?>><?php echo $Transaction->DocInOut->CustomFilters[$i]->DisplayName ?></label>
<?php echo ewrpt_RepeatColumnTable($totcnt, $wrkcnt, 5, 2) ?>
<?php
		}
		$wrkcnt += 1;
	}

//}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<?php echo ewrpt_RepeatColumnTable($totcnt, $wrkcnt, 5, 1) ?>
<label><input type="radio" name="sv_DocInOut" id="sv_DocInOut" value="<?php echo $Transaction->DocInOut->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($Transaction->DocInOut->DropDownValue, $Transaction->DocInOut->DropDownList[$i])) echo " checked=\"checked\"" ?>><?php echo ewrpt_DropDownDisplayValue($Transaction->DocInOut->DropDownList[$i], "", 0) ?></label>
<?php echo ewrpt_RepeatColumnTable($totcnt, $wrkcnt, 5, 2) ?>
<?php
		$wrkcnt += 1;
	}

//}
?>
		</span></td>
	</tr>
	<tr>
		<td><span class="phpreportmaker"><?php echo $Transaction->DocCode->FldCaption() ?></span></td>
		<td></td>
		<td colspan="4"><span class="ewRptSearchOpr">
		<select name="sv_DocCode" id="sv_DocCode"<?php echo ($Transaction_rpt->ClearExtFilter == 'Transaction_DocCode') ? " class=\"ewInputCleared\"" : "" ?>>
		<option value="<?php echo EWRPT_ALL_VALUE; ?>"<?php if (ewrpt_MatchedFilterValue($Transaction->DocCode->DropDownValue, EWRPT_ALL_VALUE)) echo " selected=\"selected\""; ?>><?php echo $ReportLanguage->Phrase("PleaseSelect"); ?></option>
<?php

// Popup filter
$cntf = is_array($Transaction->DocCode->CustomFilters) ? count($Transaction->DocCode->CustomFilters) : 0;
$cntd = is_array($Transaction->DocCode->DropDownList) ? count($Transaction->DocCode->DropDownList) : 0;
$totcnt = $cntf + $cntd;
$wrkcnt = 0;
	for ($i = 0; $i < $cntf; $i++) {
		if ($Transaction->DocCode->CustomFilters[$i]->FldName == 'DocCode') {
?>
		<option value="<?php echo "@@" . $Transaction->DocCode->CustomFilters[$i]->FilterName ?>"<?php if (ewrpt_MatchedFilterValue($Transaction->DocCode->DropDownValue, "@@" . $Transaction->DocCode->CustomFilters[$i]->FilterName)) echo " selected=\"selected\"" ?>><?php echo $Transaction->DocCode->CustomFilters[$i]->DisplayName ?></option>
<?php
		}
		$wrkcnt += 1;
	}

//}
	for ($i = 0; $i < $cntd; $i++) {
?>
		<option value="<?php echo $Transaction->DocCode->DropDownList[$i] ?>"<?php if (ewrpt_MatchedFilterValue($Transaction->DocCode->DropDownValue, $Transaction->DocCode->DropDownList[$i])) echo " selected=\"selected\"" ?>><?php echo ewrpt_DropDownDisplayValue($Transaction->DocCode->DropDownList[$i], "", 0) ?></option>
<?php
		$wrkcnt += 1;
	}

//}
?>
		</select>
		</span></td>
	</tr>
</table>
<table class="ewRptExtFilter">
	<tr>
		<td><span class="phpreportmaker">
			<input type="Submit" name="Submit" id="Submit" value="<?php echo $ReportLanguage->Phrase("Search") ?>">&nbsp;
			<input type="Reset" name="Reset" id="Reset" value="<?php echo $ReportLanguage->Phrase("Reset") ?>">&nbsp;
		</span></td>
	</tr>
</table>
</form>
<!-- Search form (end) -->
</div>
<br />
<?php } ?>
<?php if ($Transaction->ShowCurrentFilter) { ?>
<div id="ewrptFilterList">
<?php $Transaction_rpt->ShowFilterList() ?>
</div>
<br />
<?php } ?>
<table class="ewGrid" cellspacing="0"><tr>
	<td class="ewGridContent">
<?php if ($Transaction->Export == "") { ?>
<div class="ewGridUpperPanel">
<form action="tp_rep_Transactionrpt.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Transaction_rpt->StartGrp, $Transaction_rpt->DisplayGrps, $Transaction_rpt->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="tp_rep_Transactionrpt.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="tp_rep_Transactionrpt.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="tp_rep_Transactionrpt.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="tp_rep_Transactionrpt.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/lastdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;<?php echo $ReportLanguage->Phrase("of") ?> <?php echo $Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Record") ?> <?php echo $Pager->FromIndex ?> <?php echo $ReportLanguage->Phrase("To") ?> <?php echo $Pager->ToIndex ?> <?php echo $ReportLanguage->Phrase("Of") ?> <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Transaction_rpt->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Transaction_rpt->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("RecordsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="10"<?php if ($Transaction_rpt->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Transaction_rpt->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Transaction_rpt->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Transaction->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
</div>
<?php } ?>
<!-- Report Grid (Begin) -->
<div class="ewGridMiddlePanel">
<table class="ewTable ewTableSeparate" cellspacing="0">
<?php

// Set the last group to display if not export all
if ($Transaction->ExportAll && $Transaction->Export <> "") {
	$Transaction_rpt->StopGrp = $Transaction_rpt->TotalGrps;
} else {
	$Transaction_rpt->StopGrp = $Transaction_rpt->StartGrp + $Transaction_rpt->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Transaction_rpt->StopGrp) > intval($Transaction_rpt->TotalGrps))
	$Transaction_rpt->StopGrp = $Transaction_rpt->TotalGrps;
$Transaction_rpt->RecCount = 0;

// Get first row
if ($Transaction_rpt->TotalGrps > 0) {
	$Transaction_rpt->GetRow(1);
	$Transaction_rpt->GrpCount = 1;
}
while (($rs && !$rs->EOF && $Transaction_rpt->GrpCount <= $Transaction_rpt->DisplayGrps) || $Transaction_rpt->ShowFirstHeader) {

	// Show header
	if ($Transaction_rpt->ShowFirstHeader) {
?>
	<thead>
	<tr>
<td class="ewTableHeader">
	<table cellspacing="0" class="ewTableHeaderBtn" style="width: 90px; white-space: nowrap;"><tr>
<?php if ($Transaction->SortUrl($Transaction->DocDate) == "") { ?>
		<td style="vertical-align: bottom;" style="width: 90px; white-space: nowrap;"><?php echo $Transaction->DocDate->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Transaction->SortUrl($Transaction->DocDate) ?>',2);"><?php echo $Transaction->DocDate->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Transaction->DocDate->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Transaction->DocDate->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
</td>
<td class="ewTableHeader">
	<table cellspacing="0" class="ewTableHeaderBtn" style="width: 250px; white-space: nowrap;"><tr>
<?php if ($Transaction->SortUrl($Transaction->DocFullNo) == "") { ?>
		<td style="vertical-align: bottom;" style="width: 250px; white-space: nowrap;"><?php echo $Transaction->DocFullNo->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Transaction->SortUrl($Transaction->DocFullNo) ?>',2);"><?php echo $Transaction->DocFullNo->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Transaction->DocFullNo->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Transaction->DocFullNo->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
</td>
<td class="ewTableHeader">
	<table cellspacing="0" class="ewTableHeaderBtn" style="width: 65px; white-space: nowrap;"><tr>
<?php if ($Transaction->SortUrl($Transaction->AccNo) == "") { ?>
		<td style="vertical-align: bottom;" style="width: 65px; white-space: nowrap;"><?php echo $Transaction->AccNo->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Transaction->SortUrl($Transaction->AccNo) ?>',2);"><?php echo $Transaction->AccNo->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Transaction->AccNo->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Transaction->AccNo->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
</td>
<td class="ewTableHeader">
	<table cellspacing="0" class="ewTableHeaderBtn" style="width: 250px; white-space: nowrap;"><tr>
<?php if ($Transaction->SortUrl($Transaction->AccName) == "") { ?>
		<td style="vertical-align: bottom;" style="width: 250px; white-space: nowrap;"><?php echo $Transaction->AccName->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Transaction->SortUrl($Transaction->AccName) ?>',2);"><?php echo $Transaction->AccName->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Transaction->AccName->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Transaction->AccName->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
</td>
<td class="ewTableHeader">
	<table cellspacing="0" class="ewTableHeaderBtn" style="width: 300px; white-space: nowrap;"><tr>
<?php if ($Transaction->SortUrl($Transaction->Description) == "") { ?>
		<td style="vertical-align: bottom;" style="width: 300px; white-space: nowrap;"><?php echo $Transaction->Description->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Transaction->SortUrl($Transaction->Description) ?>',2);"><?php echo $Transaction->Description->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Transaction->Description->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Transaction->Description->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
</td>
<td class="ewTableHeader">
	<table cellspacing="0" class="ewTableHeaderBtn" style="white-space: nowrap;"><tr>
<?php if ($Transaction->SortUrl($Transaction->Amount) == "") { ?>
		<td style="vertical-align: bottom;" style="white-space: nowrap;"><?php echo $Transaction->Amount->FldCaption() ?></td>
<?php } else { ?>
		<td class="ewPointer" onmousedown="ewrpt_Sort(event,'<?php echo $Transaction->SortUrl($Transaction->Amount) ?>',2);"><?php echo $Transaction->Amount->FldCaption() ?></td><td style="width: 10px;">
		<?php if ($Transaction->Amount->getSort() == "ASC") { ?><img src="phprptimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($Transaction->Amount->getSort() == "DESC") { ?><img src="phprptimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td>
<?php } ?>
	</tr></table>
</td>
	</tr>
	</thead>
	<tbody>
<?php
		$Transaction_rpt->ShowFirstHeader = FALSE;
	}
	$Transaction_rpt->RecCount++;

		// Render detail row
		$Transaction->ResetCSS();
		$Transaction->RowType = EWRPT_ROWTYPE_DETAIL;
		$Transaction_rpt->RenderRow();
?>
	<tr<?php echo $Transaction->RowAttributes(); ?>>
		<td<?php echo $Transaction->DocDate->CellAttributes() ?>>
<div<?php echo $Transaction->DocDate->ViewAttributes(); ?>><?php echo $Transaction->DocDate->ListViewValue(); ?></div>
</td>
		<td<?php echo $Transaction->DocFullNo->CellAttributes() ?>>
<div<?php echo $Transaction->DocFullNo->ViewAttributes(); ?>><?php echo $Transaction->DocFullNo->ListViewValue(); ?></div>
</td>
		<td<?php echo $Transaction->AccNo->CellAttributes() ?>>
<div<?php echo $Transaction->AccNo->ViewAttributes(); ?>><?php echo $Transaction->AccNo->ListViewValue(); ?></div>
</td>
		<td<?php echo $Transaction->AccName->CellAttributes() ?>>
<div<?php echo $Transaction->AccName->ViewAttributes(); ?>><?php echo $Transaction->AccName->ListViewValue(); ?></div>
</td>
		<td<?php echo $Transaction->Description->CellAttributes() ?>>
<div<?php echo $Transaction->Description->ViewAttributes(); ?>><?php echo $Transaction->Description->ListViewValue(); ?></div>
</td>
		<td<?php echo $Transaction->Amount->CellAttributes() ?>>
<div<?php echo $Transaction->Amount->ViewAttributes(); ?>><?php echo $Transaction->Amount->ListViewValue(); ?></div>
</td>
	</tr>
<?php

		// Accumulate page summary
		$Transaction_rpt->AccumulateSummary();

		// Get next record
		$Transaction_rpt->GetRow(2);
	$Transaction_rpt->GrpCount++;
} // End while
?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
</div>
<?php if ($Transaction_rpt->TotalGrps > 0) { ?>
<?php if ($Transaction->Export == "") { ?>
<div class="ewGridLowerPanel">
<form action="tp_rep_Transactionrpt.php" name="ewpagerform" id="ewpagerform" class="ewForm">
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="white-space: nowrap;">
<?php if (!isset($Pager)) $Pager = new crPrevNextPager($Transaction_rpt->StartGrp, $Transaction_rpt->DisplayGrps, $Transaction_rpt->TotalGrps) ?>
<?php if ($Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($Pager->FirstButton->Enabled) { ?>
	<td><a href="tp_rep_Transactionrpt.php?start=<?php echo $Pager->FirstButton->Start ?>"><img src="phprptimages/first.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/firstdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($Pager->PrevButton->Enabled) { ?>
	<td><a href="tp_rep_Transactionrpt.php?start=<?php echo $Pager->PrevButton->Start ?>"><img src="phprptimages/prev.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phprptimages/prevdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="pageno" id="pageno" value="<?php echo $Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($Pager->NextButton->Enabled) { ?>
	<td><a href="tp_rep_Transactionrpt.php?start=<?php echo $Pager->NextButton->Start ?>"><img src="phprptimages/next.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/nextdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($Pager->LastButton->Enabled) { ?>
	<td><a href="tp_rep_Transactionrpt.php?start=<?php echo $Pager->LastButton->Start ?>"><img src="phprptimages/last.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phprptimages/lastdisab.gif" alt="<?php echo $ReportLanguage->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpreportmaker">&nbsp;<?php echo $ReportLanguage->Phrase("of") ?> <?php echo $Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("Record") ?> <?php echo $Pager->FromIndex ?> <?php echo $ReportLanguage->Phrase("To") ?> <?php echo $Pager->ToIndex ?> <?php echo $ReportLanguage->Phrase("Of") ?> <?php echo $Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($Transaction_rpt->Filter == "0=101") { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
<?php if ($Transaction_rpt->TotalGrps > 0) { ?>
		<td style="white-space: nowrap;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
		<td align="right" style="vertical-align: top; white-space: nowrap;"><span class="phpreportmaker"><?php echo $ReportLanguage->Phrase("RecordsPerPage"); ?>&nbsp;
<select name="<?php echo EWRPT_TABLE_GROUP_PER_PAGE; ?>" onchange="this.form.submit();">
<option value="10"<?php if ($Transaction_rpt->DisplayGrps == 10) echo " selected=\"selected\"" ?>>10</option>
<option value="20"<?php if ($Transaction_rpt->DisplayGrps == 20) echo " selected=\"selected\"" ?>>20</option>
<option value="50"<?php if ($Transaction_rpt->DisplayGrps == 50) echo " selected=\"selected\"" ?>>50</option>
<option value="ALL"<?php if ($Transaction->getGroupPerPage() == -1) echo " selected=\"selected\"" ?>><?php echo $ReportLanguage->Phrase("AllRecords") ?></option>
</select>
		</span></td>
<?php } ?>
	</tr>
</table>
</form>
</div>
<?php } ?>
<?php } ?>
</td></tr></table>
</div>
<!-- Summary Report Ends -->
<?php if ($Transaction->Export == "") { ?>
	</div><br /></td>
	<!-- Center Container - Report (End) -->
	<!-- Right Container (Begin) -->
	<td style="vertical-align: top;"><div id="ewRight" class="phpreportmaker">
	<!-- Right slot -->
<?php } ?>
<?php if ($Transaction->Export == "" || $Transaction->Export == "print" || $Transaction->Export == "email") { ?>
<?php } ?>
<?php if ($Transaction->Export == "") { ?>
	</div></td>
	<!-- Right Container (End) -->
</tr>
<!-- Bottom Container (Begin) -->
<tr><td colspan="3"><div id="ewBottom" class="phpreportmaker">
	<!-- Bottom slot -->
<?php } ?>
<?php if ($Transaction->Export == "" || $Transaction->Export == "print" || $Transaction->Export == "email") { ?>
<?php } ?>
<?php if ($Transaction->Export == "") { ?>
	</div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php } ?>
<?php $Transaction_rpt->ShowPageFooter(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if ($Transaction->Export == "") { ?>
<script language="JavaScript" type="text/javascript">
<!--

// Write your table-specific startup script here
// document.write("page loaded");
//-->

</script>
<?php } ?>
<?php include "phprptinc/tp_rep_footer.php"; ?>
<?php
$Transaction_rpt->Page_Terminate();
?>
<?php

//
// Page class
//
class crTransaction_rpt {

	// Page ID
	var $PageID = 'rpt';

	// Table name
	var $TableName = 'Transaction';

	// Page object name
	var $PageObjName = 'Transaction_rpt';

	// Page name
	function PageName() {
		return ewrpt_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewrpt_CurrentPage() . "?";
		global $Transaction;
		if ($Transaction->UseTokenInUrl) $PageUrl .= "t=" . $Transaction->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Export URLs
	var $ExportPrintUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;

	// Message
	function getMessage() {
		return @$_SESSION[EWRPT_SESSION_MESSAGE];
	}

	function setMessage($v) {
		if (@$_SESSION[EWRPT_SESSION_MESSAGE] <> "") { // Append
			$_SESSION[EWRPT_SESSION_MESSAGE] .= "<br />" . $v;
		} else {
			$_SESSION[EWRPT_SESSION_MESSAGE] = $v;
		}
	}

	// Show message
	function ShowMessage() {
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage);
		if ($sMessage <> "") { // Message in Session, display
			echo "<p><span class=\"ewMessage\">" . $sMessage . "</span></p>";
			$_SESSION[EWRPT_SESSION_MESSAGE] = ""; // Clear message in Session
		}
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p><span class=\"phpreportmaker\">" . $sHeader . "</span></p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Fotoer exists, display
			echo "<p><span class=\"phpreportmaker\">" . $sFooter . "</span></p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $Transaction;
		if ($Transaction->UseTokenInUrl) {
			if (ewrpt_IsHttpPost())
				return ($Transaction->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($Transaction->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function crTransaction_rpt() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Table object (Transaction)
		$GLOBALS["Transaction"] = new crTransaction();

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";

		// Page ID
		if (!defined("EWRPT_PAGE_ID"))
			define("EWRPT_PAGE_ID", 'rpt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWRPT_TABLE_NAME"))
			define("EWRPT_TABLE_NAME", 'Transaction', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new crTimer();

		// Open connection
		$conn = ewrpt_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $ReportLanguage, $Security;
		global $Transaction;

	// Get export parameters
	if (@$_GET["export"] <> "") {
		$Transaction->Export = $_GET["export"];
	}
	$gsExport = $Transaction->Export; // Get export parameter, used in header
	$gsExportFile = $Transaction->TableVar; // Get export file, used in header
	if ($Transaction->Export == "excel") {
		header('Content-Type: application/vnd.ms-excel;charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $gsExportFile .'.xls');
	}
	if ($Transaction->Export == "word") {
		header('Content-Type: application/vnd.ms-word;charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $gsExportFile .'.doc');
	}

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;
		global $ReportLanguage;
		global $Transaction;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export to Email (use ob_file_contents for PHP)
		if ($Transaction->Export == "email") {
			$sContent = ob_get_contents();
			$this->ExportEmail($sContent);
			ob_end_clean();

			 // Close connection
			$conn->Close();
			header("Location: " . ewrpt_CurrentPage());
			exit();
		}

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EWRPT_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Initialize common variables
	// Paging variables

	var $RecCount = 0; // Record count
	var $StartGrp = 0; // Start group
	var $StopGrp = 0; // Stop group
	var $TotalGrps = 0; // Total groups
	var $GrpCount = 0; // Group count
	var $DisplayGrps = 20; // Groups per page
	var $GrpRange = 10;
	var $Sort = "";
	var $Filter = "";
	var $UserIDFilter = "";

	// Clear field for ext filter
	var $ClearExtFilter = "";
	var $FilterApplied;
	var $ShowFirstHeader;
	var $Cnt, $Col, $Val, $Smry, $Mn, $Mx, $GrandSmry, $GrandMn, $GrandMx;
	var $TotCount;

	//
	// Page main
	//
	function Page_Main() {
		global $Transaction;
		global $rs;
		global $rsgrp;
		global $gsFormError;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 7;
		$nGrps = 1;
		$this->Val = ewrpt_InitArray($nDtls, 0);
		$this->Cnt = ewrpt_Init2DArray($nGrps, $nDtls, 0);
		$this->Smry = ewrpt_Init2DArray($nGrps, $nDtls, 0);
		$this->Mn = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
		$this->Mx = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
		$this->GrandSmry = ewrpt_InitArray($nDtls, 0);
		$this->GrandMn = ewrpt_InitArray($nDtls, NULL);
		$this->GrandMx = ewrpt_InitArray($nDtls, NULL);

		// Set up if accumulation required
		$this->Col = array(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE);

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Load default filter values
		$this->LoadDefaultFilters();

		// Set up popup filter
		$this->SetupPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Get dropdown values
		$this->GetExtendedFilterValues();

		// Load custom filters
		$Transaction->CustomFilters_Load();

		// Build extended filter
		$sExtendedFilter = $this->GetExtendedFilter();
		if ($sExtendedFilter <> "") {
			if ($this->Filter <> "")
  				$this->Filter = "($this->Filter) AND ($sExtendedFilter)";
			else
				$this->Filter = $sExtendedFilter;
		}

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewrpt_SetDebugMsg("popup filter: " . $sPopupFilter);
		if ($sPopupFilter <> "") {
			if ($this->Filter <> "")
				$this->Filter = "($this->Filter) AND ($sPopupFilter)";
			else
				$this->Filter = $sPopupFilter;
		}

		// Check if filter applied
		$this->FilterApplied = $this->CheckFilter();

		// Get sort
		$this->Sort = $this->GetSort();

		// Get total count
		$sSql = ewrpt_BuildReportSql($Transaction->SqlSelect(), $Transaction->SqlWhere(), $Transaction->SqlGroupBy(), $Transaction->SqlHaving(), $Transaction->SqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowFirstHeader = ($this->TotalGrps > 0);

		//$this->ShowFirstHeader = TRUE; // Uncomment to always show header
		// Set up start position if not export all

		if ($Transaction->ExportAll && $Transaction->Export <> "")
		    $this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup(); 

		// Get current page records
		$rs = $this->GetRs($sSql, $this->StartGrp, $this->DisplayGrps);
	}

	// Accummulate summary
	function AccumulateSummary() {
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy]++;
				if ($this->Col[$iy]) {
					$valwrk = $this->Val[$iy];
					if (is_null($valwrk) || !is_numeric($valwrk)) {

						// skip
					} else {
						$this->Smry[$ix][$iy] += $valwrk;
						if (is_null($this->Mn[$ix][$iy])) {
							$this->Mn[$ix][$iy] = $valwrk;
							$this->Mx[$ix][$iy] = $valwrk;
						} else {
							if ($this->Mn[$ix][$iy] > $valwrk) $this->Mn[$ix][$iy] = $valwrk;
							if ($this->Mx[$ix][$iy] < $valwrk) $this->Mx[$ix][$iy] = $valwrk;
						}
					}
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = 1; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0]++;
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy] = 0;
				if ($this->Col[$iy]) {
					$this->Smry[$ix][$iy] = 0;
					$this->Mn[$ix][$iy] = NULL;
					$this->Mx[$ix][$iy] = NULL;
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0] = 0;
		}

		// Reset record count
		$this->RecCount = 0;
	}

	// Accummulate grand summary
	function AccumulateGrandSummary() {
		$this->Cnt[0][0]++;
		$cntgs = count($this->GrandSmry);
		for ($iy = 1; $iy < $cntgs; $iy++) {
			if ($this->Col[$iy]) {
				$valwrk = $this->Val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {

					// skip
				} else {
					$this->GrandSmry[$iy] += $valwrk;
					if (is_null($this->GrandMn[$iy])) {
						$this->GrandMn[$iy] = $valwrk;
						$this->GrandMx[$iy] = $valwrk;
					} else {
						if ($this->GrandMn[$iy] > $valwrk) $this->GrandMn[$iy] = $valwrk;
						if ($this->GrandMx[$iy] < $valwrk) $this->GrandMx[$iy] = $valwrk;
					}
				}
			}
		}
	}

	// Get count
	function GetCnt($sql) {
		global $conn;
		$rscnt = $conn->Execute($sql);
		$cnt = ($rscnt) ? $rscnt->RecordCount() : 0;
		if ($rscnt) $rscnt->Close();
		return $cnt;
	}

	// Get rs
	function GetRs($sql, $start, $grps) {
		global $conn;
		$wrksql = $sql;
		if ($start > 0 && $grps > -1)
			$wrksql .= " LIMIT " . ($start-1) . ", " . ($grps);
		$rswrk = $conn->Execute($wrksql);
		return $rswrk;
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		global $Transaction;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$Transaction->DocID->setDbValue($rs->fields('DocID'));
			$Transaction->DocDate->setDbValue($rs->fields('DocDate'));
			$Transaction->DocFullNo->setDbValue($rs->fields('DocFullNo'));
			$Transaction->AccNo->setDbValue($rs->fields('AccNo'));
			$Transaction->Type->setDbValue($rs->fields('Type'));
			$Transaction->AccName->setDbValue($rs->fields('AccName'));
			$Transaction->Description->setDbValue($rs->fields('Description'));
			$Transaction->Amount->setDbValue($rs->fields('Amount'));
			$Transaction->RefDocID->setDbValue($rs->fields('RefDocID'));
			$Transaction->DocType->setDbValue($rs->fields('DocType'));
			$Transaction->DocInOut->setDbValue($rs->fields('DocInOut'));
			$Transaction->DocCode->setDbValue($rs->fields('DocCode'));
			$Transaction->DocNotes->setDbValue($rs->fields('DocNotes'));
			$this->Val[1] = $Transaction->DocDate->CurrentValue;
			$this->Val[2] = $Transaction->DocFullNo->CurrentValue;
			$this->Val[3] = $Transaction->AccNo->CurrentValue;
			$this->Val[4] = $Transaction->AccName->CurrentValue;
			$this->Val[5] = $Transaction->Description->CurrentValue;
			$this->Val[6] = $Transaction->Amount->CurrentValue;
		} else {
			$Transaction->DocID->setDbValue("");
			$Transaction->DocDate->setDbValue("");
			$Transaction->DocFullNo->setDbValue("");
			$Transaction->AccNo->setDbValue("");
			$Transaction->Type->setDbValue("");
			$Transaction->AccName->setDbValue("");
			$Transaction->Description->setDbValue("");
			$Transaction->Amount->setDbValue("");
			$Transaction->RefDocID->setDbValue("");
			$Transaction->DocType->setDbValue("");
			$Transaction->DocInOut->setDbValue("");
			$Transaction->DocCode->setDbValue("");
			$Transaction->DocNotes->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {
		global $Transaction;

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWRPT_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWRPT_TABLE_START_GROUP];
			$Transaction->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$Transaction->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $Transaction->getStartGroup();
			}
		} else {
			$this->StartGrp = $Transaction->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$Transaction->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$Transaction->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$Transaction->setStartGroup($this->StartGrp);
		}
	}

	// Set up popup
	function SetupPopup() {
		global $conn, $ReportLanguage;
		global $Transaction;

		// Initialize popup
		// Process post back form

		if (ewrpt_IsHttpPost()) {
			$sName = @$_POST["popup"]; // Get popup form name
			if ($sName <> "") {
				$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
				if ($cntValues > 0) {
					$arValues = ewrpt_StripSlashes($_POST["sel_$sName"]);
					if (trim($arValues[0]) == "") // Select all
						$arValues = EWRPT_INIT_VALUE;
					if (!ewrpt_MatchedArray($arValues, $_SESSION["sel_$sName"])) {
						if ($this->HasSessionFilterValues($sName))
							$this->ClearExtFilter = $sName; // Clear extended filter for this field
					}
					$_SESSION["sel_$sName"] = $arValues;
					$_SESSION["rf_$sName"] = ewrpt_StripSlashes(@$_POST["rf_$sName"]);
					$_SESSION["rt_$sName"] = ewrpt_StripSlashes(@$_POST["rt_$sName"]);
					$this->ResetPager();
				}
			}

		// Get 'reset' command
		} elseif (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];
			if (strtolower($sCmd) == "reset") {
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		global $Transaction;
		$this->StartGrp = 1;
		$Transaction->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		global $Transaction;
		$sWrk = @$_GET[EWRPT_TABLE_GROUP_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayGrps = intval($sWrk);
			} else {
				if (strtoupper($sWrk) == "ALL") { // display all groups
					$this->DisplayGrps = -1;
				} else {
					$this->DisplayGrps = 20; // Non-numeric, load default
				}
			}
			$Transaction->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$Transaction->setStartGroup($this->StartGrp);
		} else {
			if ($Transaction->getGroupPerPage() <> "") {
				$this->DisplayGrps = $Transaction->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 20; // Load default
			}
		}
	}

	function RenderRow() {
		global $conn, $Security;
		global $Transaction;
		if ($Transaction->RowTotalType == EWRPT_ROWTOTAL_GRAND) { // Grand total

			// Get total count from sql directly
			$sSql = ewrpt_BuildReportSql($Transaction->SqlSelectCount(), $Transaction->SqlWhere(), $Transaction->SqlGroupBy(), $Transaction->SqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
			} else {
				$this->TotCount = 0;
			}

			// Get total from sql directly
			$sSql = ewrpt_BuildReportSql($Transaction->SqlSelectAgg(), $Transaction->SqlWhere(), $Transaction->SqlGroupBy(), $Transaction->SqlHaving(), "", $this->Filter, "");
			$sSql = $Transaction->SqlAggPfx() . $sSql . $Transaction->SqlAggSfx();
			$rsagg = $conn->Execute($sSql);
			if ($rsagg) {
				$this->GrandSmry[6] = $rsagg->fields("sum_amount");
				$this->GrandMx[6] = $rsagg->fields("max_amount");
				$rsagg->Close();
			} else {

				// Accumulate grand summary from detail records
				$sSql = ewrpt_BuildReportSql($Transaction->SqlSelect(), $Transaction->SqlWhere(), $Transaction->SqlGroupBy(), $Transaction->SqlHaving(), "", $this->Filter, "");
				$rs = $conn->Execute($sSql);
				if ($rs) {
					$this->GetRow(1);
					while (!$rs->EOF) {
						$this->AccumulateGrandSummary();
						$this->GetRow(2);
					}
					$rs->Close();
				}
			}
		}

		// Call Row_Rendering event
		$Transaction->Row_Rendering();

		/* --------------------
		'  Render view codes
		' --------------------- */
		if ($Transaction->RowType == EWRPT_ROWTYPE_TOTAL) { // Summary row

			// DocDate
			$Transaction->DocDate->ViewValue = $Transaction->DocDate->Summary;
			$Transaction->DocDate->ViewValue = ewrpt_FormatDateTime($Transaction->DocDate->ViewValue, 7);
			$Transaction->DocDate->CellAttrs["style"] = "width: 90px; white-space: nowrap;";

			// DocFullNo
			$Transaction->DocFullNo->ViewValue = $Transaction->DocFullNo->Summary;
			$Transaction->DocFullNo->CellAttrs["style"] = "width: 250px; white-space: nowrap;";

			// AccNo
			$Transaction->AccNo->ViewValue = $Transaction->AccNo->Summary;
			$Transaction->AccNo->CellAttrs["style"] = "width: 65px; white-space: nowrap;";

			// AccName
			$Transaction->AccName->ViewValue = $Transaction->AccName->Summary;
			$Transaction->AccName->CellAttrs["style"] = "width: 250px; white-space: nowrap;";

			// Description
			$Transaction->Description->ViewValue = $Transaction->Description->Summary;
			$Transaction->Description->CellAttrs["style"] = "width: 300px; white-space: nowrap;";

			// Amount
			$Transaction->Amount->ViewValue = $Transaction->Amount->Summary;
			$Transaction->Amount->ViewValue = ewrpt_FormatNumber($Transaction->Amount->ViewValue, 2, -1, -1, -1);
			$Transaction->Amount->ViewAttrs["style"] = "text-align:right;";
			$Transaction->Amount->CellAttrs["style"] = "white-space: nowrap;";
		} else {

			// DocDate
			$Transaction->DocDate->ViewValue = $Transaction->DocDate->CurrentValue;
			$Transaction->DocDate->ViewValue = ewrpt_FormatDateTime($Transaction->DocDate->ViewValue, 7);
			$Transaction->DocDate->CellAttrs["style"] = "width: 90px; white-space: nowrap;";
			$Transaction->DocDate->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// DocFullNo
			$Transaction->DocFullNo->ViewValue = $Transaction->DocFullNo->CurrentValue;
			$Transaction->DocFullNo->CellAttrs["style"] = "width: 250px; white-space: nowrap;";
			$Transaction->DocFullNo->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// AccNo
			$Transaction->AccNo->ViewValue = $Transaction->AccNo->CurrentValue;
			$Transaction->AccNo->CellAttrs["style"] = "width: 65px; white-space: nowrap;";
			$Transaction->AccNo->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// AccName
			$Transaction->AccName->ViewValue = $Transaction->AccName->CurrentValue;
			$Transaction->AccName->CellAttrs["style"] = "width: 250px; white-space: nowrap;";
			$Transaction->AccName->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Description
			$Transaction->Description->ViewValue = $Transaction->Description->CurrentValue;
			$Transaction->Description->CellAttrs["style"] = "width: 300px; white-space: nowrap;";
			$Transaction->Description->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// Amount
			$Transaction->Amount->ViewValue = $Transaction->Amount->CurrentValue;
			$Transaction->Amount->ViewValue = ewrpt_FormatNumber($Transaction->Amount->ViewValue, 2, -1, -1, -1);
			$Transaction->Amount->ViewAttrs["style"] = "text-align:right;";
			$Transaction->Amount->CellAttrs["style"] = "white-space: nowrap;";
			$Transaction->Amount->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";
		}

		// DocDate
		$Transaction->DocDate->HrefValue = "";

		// DocFullNo
		$Transaction->DocFullNo->HrefValue = "";

		// AccNo
		$Transaction->AccNo->HrefValue = "";

		// AccName
		$Transaction->AccName->HrefValue = "";

		// Description
		$Transaction->Description->HrefValue = "";

		// Amount
		$Transaction->Amount->HrefValue = "";

		// Call Row_Rendered event
		$Transaction->Row_Rendered();
	}

	// Get extended filter values
	function GetExtendedFilterValues() {
		global $Transaction;

		// Field Type
		$sSelect = "SELECT DISTINCT tilyan_bjk_lookup_account.Type FROM " . $Transaction->SqlFrom();
		$sOrderBy = "tilyan_bjk_lookup_account.Type ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $Transaction->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$Transaction->Type->DropDownList = ewrpt_GetDistinctValues("", $wrkSql);

		// Field DocType
		$sSelect = "SELECT DISTINCT tilyan_bjk_document.DocType FROM " . $Transaction->SqlFrom();
		$sOrderBy = "tilyan_bjk_document.DocType ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $Transaction->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$Transaction->DocType->DropDownList = ewrpt_GetDistinctValues("", $wrkSql);

		// Field DocInOut
		$sSelect = "SELECT DISTINCT tilyan_bjk_document.DocInOut FROM " . $Transaction->SqlFrom();
		$sOrderBy = "tilyan_bjk_document.DocInOut ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $Transaction->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$Transaction->DocInOut->DropDownList = ewrpt_GetDistinctValues("", $wrkSql);

		// Field DocCode
		$sSelect = "SELECT DISTINCT tilyan_bjk_document.DocCode FROM " . $Transaction->SqlFrom();
		$sOrderBy = "tilyan_bjk_document.DocCode ASC";
		$wrkSql = ewrpt_BuildReportSql($sSelect, $Transaction->SqlWhere(), "", "", $sOrderBy, $this->UserIDFilter, "");
		$Transaction->DocCode->DropDownList = ewrpt_GetDistinctValues("", $wrkSql);
	}

	// Return extended filter
	function GetExtendedFilter() {
		global $Transaction;
		global $gsFormError;
		$sFilter = "";
		$bPostBack = ewrpt_IsHttpPost();
		$bRestoreSession = TRUE;
		$bSetupFilter = FALSE;

		// Reset extended filter if filter changed
		if ($bPostBack) {

		// Reset search command
		} elseif (@$_GET["cmd"] == "reset") {

			// Load default values
			// Field DocDate

			$this->SetSessionFilterValues($Transaction->DocDate->SearchValue, $Transaction->DocDate->SearchOperator, $Transaction->DocDate->SearchCondition, $Transaction->DocDate->SearchValue2, $Transaction->DocDate->SearchOperator2, 'DocDate');

			// Field Type
			$this->SetSessionDropDownValue($Transaction->Type->DropDownValue, 'Type');

			// Field DocType
			$this->SetSessionDropDownValue($Transaction->DocType->DropDownValue, 'DocType');

			// Field DocInOut
			$this->SetSessionDropDownValue($Transaction->DocInOut->DropDownValue, 'DocInOut');

			// Field DocCode
			$this->SetSessionDropDownValue($Transaction->DocCode->DropDownValue, 'DocCode');
			$bSetupFilter = TRUE;
		} else {

			// Field DocDate
			if ($this->GetFilterValues($Transaction->DocDate)) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			}

			// Field Type
			if ($this->GetDropDownValue($Transaction->Type->DropDownValue, 'Type')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($Transaction->Type->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_Transaction->Type'])) {
				$bSetupFilter = TRUE;
			}

			// Field DocType
			if ($this->GetDropDownValue($Transaction->DocType->DropDownValue, 'DocType')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($Transaction->DocType->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_Transaction->DocType'])) {
				$bSetupFilter = TRUE;
			}

			// Field DocInOut
			if ($this->GetDropDownValue($Transaction->DocInOut->DropDownValue, 'DocInOut')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($Transaction->DocInOut->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_Transaction->DocInOut'])) {
				$bSetupFilter = TRUE;
			}

			// Field DocCode
			if ($this->GetDropDownValue($Transaction->DocCode->DropDownValue, 'DocCode')) {
				$bSetupFilter = TRUE;
				$bRestoreSession = FALSE;
			} elseif ($Transaction->DocCode->DropDownValue <> EWRPT_INIT_VALUE && !isset($_SESSION['sv_Transaction->DocCode'])) {
				$bSetupFilter = TRUE;
			}
			if (!$this->ValidateForm()) {
				$this->setMessage($gsFormError);
				return $sFilter;
			}
		}

		// Restore session
		if ($bRestoreSession) {

			// Field DocDate
			$this->GetSessionFilterValues($Transaction->DocDate);

			// Field Type
			$this->GetSessionDropDownValue($Transaction->Type);

			// Field DocType
			$this->GetSessionDropDownValue($Transaction->DocType);

			// Field DocInOut
			$this->GetSessionDropDownValue($Transaction->DocInOut);

			// Field DocCode
			$this->GetSessionDropDownValue($Transaction->DocCode);
		}

		// Call page filter validated event
		$Transaction->Page_FilterValidated();

		// Build SQL
		// Field DocDate

		$this->BuildExtendedFilter($Transaction->DocDate, $sFilter);

		// Field Type
		$this->BuildDropDownFilter($Transaction->Type, $sFilter, "");

		// Field DocType
		$this->BuildDropDownFilter($Transaction->DocType, $sFilter, "");

		// Field DocInOut
		$this->BuildDropDownFilter($Transaction->DocInOut, $sFilter, "");

		// Field DocCode
		$this->BuildDropDownFilter($Transaction->DocCode, $sFilter, "");

		// Save parms to session
		// Field DocDate

		$this->SetSessionFilterValues($Transaction->DocDate->SearchValue, $Transaction->DocDate->SearchOperator, $Transaction->DocDate->SearchCondition, $Transaction->DocDate->SearchValue2, $Transaction->DocDate->SearchOperator2, 'DocDate');

		// Field Type
		$this->SetSessionDropDownValue($Transaction->Type->DropDownValue, 'Type');

		// Field DocType
		$this->SetSessionDropDownValue($Transaction->DocType->DropDownValue, 'DocType');

		// Field DocInOut
		$this->SetSessionDropDownValue($Transaction->DocInOut->DropDownValue, 'DocInOut');

		// Field DocCode
		$this->SetSessionDropDownValue($Transaction->DocCode->DropDownValue, 'DocCode');

		// Setup filter
		if ($bSetupFilter) {
		}
		return $sFilter;
	}

	// Get drop down value from querystring
	function GetDropDownValue(&$sv, $parm) {
		if (ewrpt_IsHttpPost())
			return FALSE; // Skip post back
		if (isset($_GET["sv_$parm"])) {
			$sv = ewrpt_StripSlashes($_GET["sv_$parm"]);
			return TRUE;
		}
		return FALSE;
	}

	// Get filter values from querystring
	function GetFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		if (ewrpt_IsHttpPost())
			return; // Skip post back
		$got = FALSE;
		if (isset($_GET["sv1_$parm"])) {
			$fld->SearchValue = ewrpt_StripSlashes($_GET["sv1_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["so1_$parm"])) {
			$fld->SearchOperator = ewrpt_StripSlashes($_GET["so1_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["sc_$parm"])) {
			$fld->SearchCondition = ewrpt_StripSlashes($_GET["sc_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["sv2_$parm"])) {
			$fld->SearchValue2 = ewrpt_StripSlashes($_GET["sv2_$parm"]);
			$got = TRUE;
		}
		if (isset($_GET["so2_$parm"])) {
			$fld->SearchOperator2 = ewrpt_StripSlashes($_GET["so2_$parm"]);
			$got = TRUE;
		}
		return $got;
	}

	// Set default ext filter
	function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2) {
		$fld->DefaultSearchValue = $sv1; // Default ext filter value 1
		$fld->DefaultSearchValue2 = $sv2; // Default ext filter value 2 (if operator 2 is enabled)
		$fld->DefaultSearchOperator = $so1; // Default search operator 1
		$fld->DefaultSearchOperator2 = $so2; // Default search operator 2 (if operator 2 is enabled)
		$fld->DefaultSearchCondition = $sc; // Default search condition (if operator 2 is enabled)
	}

	// Apply default ext filter
	function ApplyDefaultExtFilter(&$fld) {
		$fld->SearchValue = $fld->DefaultSearchValue;
		$fld->SearchValue2 = $fld->DefaultSearchValue2;
		$fld->SearchOperator = $fld->DefaultSearchOperator;
		$fld->SearchOperator2 = $fld->DefaultSearchOperator2;
		$fld->SearchCondition = $fld->DefaultSearchCondition;
	}

	// Check if Text Filter applied
	function TextFilterApplied(&$fld) {
		return (strval($fld->SearchValue) <> strval($fld->DefaultSearchValue) ||
			strval($fld->SearchValue2) <> strval($fld->DefaultSearchValue2) ||
			(strval($fld->SearchValue) <> "" &&
				strval($fld->SearchOperator) <> strval($fld->DefaultSearchOperator)) ||
			(strval($fld->SearchValue2) <> "" &&
				strval($fld->SearchOperator2) <> strval($fld->DefaultSearchOperator2)) ||
			strval($fld->SearchCondition) <> strval($fld->DefaultSearchCondition));
	}

	// Check if Non-Text Filter applied
	function NonTextFilterApplied(&$fld) {
		if (is_array($fld->DefaultDropDownValue) && is_array($fld->DropDownValue)) {
			if (count($fld->DefaultDropDownValue) <> count($fld->DropDownValue))
				return TRUE;
			else
				return (count(array_diff($fld->DefaultDropDownValue, $fld->DropDownValue)) <> 0);
		}
		else {
			$v1 = strval($fld->DefaultDropDownValue);
			if ($v1 == EWRPT_INIT_VALUE)
				$v1 = "";
			$v2 = strval($fld->DropDownValue);
			if ($v2 == EWRPT_INIT_VALUE || $v2 == EWRPT_ALL_VALUE)
				$v2 = "";
			return ($v1 <> $v2);
		}
	}

	// Load selection from a filter clause
	function LoadSelectionFromFilter(&$fld, $filter, &$sel) {
		$sel = "";
		if ($filter <> "") {
			$sSql = ewrpt_BuildReportSql($fld->SqlSelect, "", "", "", $fld->SqlOrderBy, $filter, "");
			ewrpt_LoadArrayFromSql($sSql, $sel);
		}
	}

	// Get dropdown value from session
	function GetSessionDropDownValue(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->DropDownValue, 'sv_Transaction_' . $parm);
	}

	// Get filter values from session
	function GetSessionFilterValues(&$fld) {
		$parm = substr($fld->FldVar, 2);
		$this->GetSessionValue($fld->SearchValue, 'sv1_Transaction_' . $parm);
		$this->GetSessionValue($fld->SearchOperator, 'so1_Transaction_' . $parm);
		$this->GetSessionValue($fld->SearchCondition, 'sc_Transaction_' . $parm);
		$this->GetSessionValue($fld->SearchValue2, 'sv2_Transaction_' . $parm);
		$this->GetSessionValue($fld->SearchOperator2, 'so2_Transaction_' . $parm);
	}

	// Get value from session
	function GetSessionValue(&$sv, $sn) {
		if (isset($_SESSION[$sn]))
			$sv = $_SESSION[$sn];
	}

	// Set dropdown value to session
	function SetSessionDropDownValue($sv, $parm) {
		$_SESSION['sv_Transaction_' . $parm] = $sv;
	}

	// Set filter values to session
	function SetSessionFilterValues($sv1, $so1, $sc, $sv2, $so2, $parm) {
		$_SESSION['sv1_Transaction_' . $parm] = $sv1;
		$_SESSION['so1_Transaction_' . $parm] = $so1;
		$_SESSION['sc_Transaction_' . $parm] = $sc;
		$_SESSION['sv2_Transaction_' . $parm] = $sv2;
		$_SESSION['so2_Transaction_' . $parm] = $so2;
	}

	// Check if has Session filter values
	function HasSessionFilterValues($parm) {
		return ((@$_SESSION['sv_' . $parm] <> "" && @$_SESSION['sv_' . $parm] <> EWRPT_INIT_VALUE) ||
			(@$_SESSION['sv1_' . $parm] <> "" && @$_SESSION['sv1_' . $parm] <> EWRPT_INIT_VALUE) ||
			(@$_SESSION['sv2_' . $parm] <> "" && @$_SESSION['sv2_' . $parm] <> EWRPT_INIT_VALUE));
	}

	// Dropdown filter exist
	function DropDownFilterExist(&$fld, $FldOpr) {
		$sWrk = "";
		$this->BuildDropDownFilter($fld, $sWrk, $FldOpr);
		return ($sWrk <> "");
	}

	// Build dropdown filter
	function BuildDropDownFilter(&$fld, &$FilterClause, $FldOpr) {
		$FldVal = $fld->DropDownValue;
		$sSql = "";
		if (is_array($FldVal)) {
			foreach ($FldVal as $val) {
				$sWrk = $this->GetDropDownfilter($fld, $val, $FldOpr);
				if ($sWrk <> "") {
					if ($sSql <> "")
						$sSql .= " OR " . $sWrk;
					else
						$sSql = $sWrk;
				}
			}
		} else {
			$sSql = $this->GetDropDownfilter($fld, $FldVal, $FldOpr);
		}
		if ($sSql <> "") {
			if ($FilterClause <> "") $FilterClause = "(" . $FilterClause . ") AND ";
			$FilterClause .= "(" . $sSql . ")";
		}
	}

	function GetDropDownfilter(&$fld, $FldVal, $FldOpr) {
		$FldName = $fld->FldName;
		$FldExpression = $fld->FldExpression;
		$FldDataType = $fld->FldDataType;
		$sWrk = "";
		if ($FldVal == EWRPT_NULL_VALUE) {
			$sWrk = $FldExpression . " IS NULL";
		} elseif ($FldVal == EWRPT_EMPTY_VALUE) {
			$sWrk = $FldExpression . " = ''";
		} else {
			if (substr($FldVal, 0, 2) == "@@") {
				$sWrk = ewrpt_getCustomFilter($fld, $FldVal);
			} else {
				if ($FldVal <> "" && $FldVal <> EWRPT_INIT_VALUE && $FldVal <> EWRPT_ALL_VALUE) {
					if ($FldDataType == EWRPT_DATATYPE_DATE && $FldOpr <> "") {
						$sWrk = $this->DateFilterString($FldOpr, $FldVal, $FldDataType);
					} else {
						$sWrk = $this->FilterString("=", $FldVal, $FldDataType);
					}
				}
				if ($sWrk <> "") $sWrk = $FldExpression . $sWrk;
			}
		}
		return $sWrk;
	}

	// Extended filter exist
	function ExtendedFilterExist(&$fld) {
		$sExtWrk = "";
		$this->BuildExtendedFilter($fld, $sExtWrk);
		return ($sExtWrk <> "");
	}

	// Build extended filter
	function BuildExtendedFilter(&$fld, &$FilterClause) {
		$FldName = $fld->FldName;
		$FldExpression = $fld->FldExpression;
		$FldDataType = $fld->FldDataType;
		$FldDateTimeFormat = $fld->FldDateTimeFormat;
		$FldVal1 = $fld->SearchValue;
		$FldOpr1 = $fld->SearchOperator;
		$FldCond = $fld->SearchCondition;
		$FldVal2 = $fld->SearchValue2;
		$FldOpr2 = $fld->SearchOperator2;
		$sWrk = "";
		$FldOpr1 = strtoupper(trim($FldOpr1));
		if ($FldOpr1 == "") $FldOpr1 = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		$wrkFldVal1 = $FldVal1;
		$wrkFldVal2 = $FldVal2;
		if ($FldDataType == EWRPT_DATATYPE_BOOLEAN) {
			if ($wrkFldVal1 <> "") $wrkFldVal1 = ($wrkFldVal1 == "1") ? EWRPT_TRUE_STRING : EWRPT_FALSE_STRING;
			if ($wrkFldVal2 <> "") $wrkFldVal2 = ($wrkFldVal2 == "1") ? EWRPT_TRUE_STRING : EWRPT_FALSE_STRING;
		} elseif ($FldDataType == EWRPT_DATATYPE_DATE) {
			if ($wrkFldVal1 <> "") $wrkFldVal1 = ewrpt_UnFormatDateTime($wrkFldVal1, $FldDateTimeFormat);
			if ($wrkFldVal2 <> "") $wrkFldVal2 = ewrpt_UnFormatDateTime($wrkFldVal2, $FldDateTimeFormat);
		}
		if ($FldOpr1 == "BETWEEN") {
			$IsValidValue = ($FldDataType <> EWRPT_DATATYPE_NUMBER ||
				($FldDataType == EWRPT_DATATYPE_NUMBER && is_numeric($wrkFldVal1) && is_numeric($wrkFldVal2)));
			if ($wrkFldVal1 <> "" && $wrkFldVal2 <> "" && $IsValidValue)
				$sWrk = $FldExpression . " BETWEEN " . ewrpt_QuotedValue($wrkFldVal1, $FldDataType) .
					" AND " . ewrpt_QuotedValue($wrkFldVal2, $FldDataType);
		} elseif ($FldOpr1 == "IS NULL" || $FldOpr1 == "IS NOT NULL") {
			$sWrk = $FldExpression . " " . $wrkFldVal1;
		} else {
			$IsValidValue = ($FldDataType <> EWRPT_DATATYPE_NUMBER ||
				($FldDataType == EWRPT_DATATYPE_NUMBER && is_numeric($wrkFldVal1)));
			if ($wrkFldVal1 <> "" && $IsValidValue && ewrpt_IsValidOpr($FldOpr1, $FldDataType))
				$sWrk = $FldExpression . $this->FilterString($FldOpr1, $wrkFldVal1, $FldDataType);
			$IsValidValue = ($FldDataType <> EWRPT_DATATYPE_NUMBER ||
				($FldDataType == EWRPT_DATATYPE_NUMBER && is_numeric($wrkFldVal2)));
			if ($wrkFldVal2 <> "" && $IsValidValue && ewrpt_IsValidOpr($FldOpr2, $FldDataType)) {
				if ($sWrk <> "")
					$sWrk .= " " . (($FldCond == "OR") ? "OR" : "AND") . " ";
				$sWrk .= $FldExpression . $this->FilterString($FldOpr2, $wrkFldVal2, $FldDataType);
			}
		}
		if ($sWrk <> "") {
			if ($FilterClause <> "") $FilterClause .= " AND ";
			$FilterClause .= "(" . $sWrk . ")";
		}
	}

	// Validate form
	function ValidateForm() {
		global $ReportLanguage, $gsFormError, $Transaction;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EWRPT_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ewrpt_CheckEuroDate($Transaction->DocDate->SearchValue)) {
			if ($gsFormError <> "") $gsFormError .= "<br />";
			$gsFormError .= $Transaction->DocDate->FldErrMsg();
		}
		if (!ewrpt_CheckEuroDate($Transaction->DocDate->SearchValue2)) {
			if ($gsFormError <> "") $gsFormError .= "<br />";
			$gsFormError .= $Transaction->DocDate->FldErrMsg();
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			$gsFormError .= ($gsFormError <> "") ? "<br />" : "";
			$gsFormError .= $sFormCustomError;
		}
		return $ValidateForm;
	}

	// Return filter string
	function FilterString($FldOpr, $FldVal, $FldType) {
		if ($FldOpr == "LIKE" || $FldOpr == "NOT LIKE") {
			return " " . $FldOpr . " " . ewrpt_QuotedValue("%$FldVal%", $FldType);
		} elseif ($FldOpr == "STARTS WITH") {
			return " LIKE " . ewrpt_QuotedValue("$FldVal%", $FldType);
		} else {
			return " $FldOpr " . ewrpt_QuotedValue($FldVal, $FldType);
		}
	}

	// Return date search string
	function DateFilterString($FldOpr, $FldVal, $FldType) {
		$wrkVal1 = ewrpt_DateVal($FldOpr, $FldVal, 1);
		$wrkVal2 = ewrpt_DateVal($FldOpr, $FldVal, 2);
		if ($wrkVal1 <> "" && $wrkVal2 <> "") {
			return " BETWEEN " . ewrpt_QuotedValue($wrkVal1, $FldType) . " AND " . ewrpt_QuotedValue($wrkVal2, $FldType);
		} else {
			return "";
		}
	}

	// Clear selection stored in session
	function ClearSessionSelection($parm) {
		$_SESSION["sel_Transaction_$parm"] = "";
		$_SESSION["rf_Transaction_$parm"] = "";
		$_SESSION["rt_Transaction_$parm"] = "";
	}

	// Load selection from session
	function LoadSelectionFromSession($parm) {
		global $Transaction;
		$fld =& $Transaction->fields($parm);
		$fld->SelectionList = @$_SESSION["sel_Transaction_$parm"];
		$fld->RangeFrom = @$_SESSION["rf_Transaction_$parm"];
		$fld->RangeTo = @$_SESSION["rt_Transaction_$parm"];
	}

	// Load default value for filters
	function LoadDefaultFilters() {
		global $Transaction;

		/**
		* Set up default values for non Text filters
		*/

		// Field Type
		$Transaction->Type->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$Transaction->Type->DropDownValue = $Transaction->Type->DefaultDropDownValue;

		// Field DocType
		$Transaction->DocType->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$Transaction->DocType->DropDownValue = $Transaction->DocType->DefaultDropDownValue;

		// Field DocInOut
		$Transaction->DocInOut->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$Transaction->DocInOut->DropDownValue = $Transaction->DocInOut->DefaultDropDownValue;

		// Field DocCode
		$Transaction->DocCode->DefaultDropDownValue = EWRPT_INIT_VALUE;
		$Transaction->DocCode->DropDownValue = $Transaction->DocCode->DefaultDropDownValue;

		/**
		* Set up default values for extended filters
		* function SetDefaultExtFilter(&$fld, $so1, $sv1, $sc, $so2, $sv2)
		* Parameters:
		* $fld - Field object
		* $so1 - Default search operator 1
		* $sv1 - Default ext filter value 1
		* $sc - Default search condition (if operator 2 is enabled)
		* $so2 - Default search operator 2 (if operator 2 is enabled)
		* $sv2 - Default ext filter value 2 (if operator 2 is enabled)
		*/

		// Field DocDate
		$this->SetDefaultExtFilter($Transaction->DocDate, "BETWEEN", NULL, 'AND', "=", NULL);
		$this->ApplyDefaultExtFilter($Transaction->DocDate);

		/**
		* Set up default values for popup filters
		* NOTE: if extended filter is enabled, use default values in extended filter instead
		*/
	}

	// Check if filter applied
	function CheckFilter() {
		global $Transaction;

		// Check DocDate text filter
		if ($this->TextFilterApplied($Transaction->DocDate))
			return TRUE;

		// Check Type extended filter
		if ($this->NonTextFilterApplied($Transaction->Type))
			return TRUE;

		// Check DocType extended filter
		if ($this->NonTextFilterApplied($Transaction->DocType))
			return TRUE;

		// Check DocInOut extended filter
		if ($this->NonTextFilterApplied($Transaction->DocInOut))
			return TRUE;

		// Check DocCode extended filter
		if ($this->NonTextFilterApplied($Transaction->DocCode))
			return TRUE;
		return FALSE;
	}

	// Show list of filters
	function ShowFilterList() {
		global $Transaction;
		global $ReportLanguage;

		// Initialize
		$sFilterList = "";

		// Field DocDate
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildExtendedFilter($Transaction->DocDate, $sExtWrk);
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $Transaction->DocDate->FldCaption() . "<br />";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

		// Field Type
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($Transaction->Type, $sExtWrk, "");
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $Transaction->Type->FldCaption() . "<br />";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

		// Field DocType
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($Transaction->DocType, $sExtWrk, "");
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $Transaction->DocType->FldCaption() . "<br />";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

		// Field DocInOut
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($Transaction->DocInOut, $sExtWrk, "");
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $Transaction->DocInOut->FldCaption() . "<br />";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

		// Field DocCode
		$sExtWrk = "";
		$sWrk = "";
		$this->BuildDropDownFilter($Transaction->DocCode, $sExtWrk, "");
		if ($sExtWrk <> "" || $sWrk <> "")
			$sFilterList .= $Transaction->DocCode->FldCaption() . "<br />";
		if ($sExtWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sExtWrk<br />";
		if ($sWrk <> "")
			$sFilterList .= "&nbsp;&nbsp;$sWrk<br />";

		// Show Filters
		if ($sFilterList <> "")
			echo $ReportLanguage->Phrase("CurrentFilters") . "<br />$sFilterList";
	}

	// Return poup filter
	function GetPopupFilter() {
		global $Transaction;
		$sWrk = "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWRPT_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		global $Transaction;

		// Check for Ctrl pressed
		$bCtrl = (@$_GET["ctrl"] <> "");

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$Transaction->setOrderBy("");
				$Transaction->setStartGroup(1);
				$Transaction->DocDate->setSort("");
				$Transaction->DocFullNo->setSort("");
				$Transaction->AccNo->setSort("");
				$Transaction->AccName->setSort("");
				$Transaction->Description->setSort("");
				$Transaction->Amount->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$Transaction->CurrentOrder = ewrpt_StripSlashes(@$_GET["order"]);
			$Transaction->CurrentOrderType = @$_GET["ordertype"];
			$Transaction->UpdateSort($Transaction->DocDate, $bCtrl); // DocDate
			$Transaction->UpdateSort($Transaction->DocFullNo, $bCtrl); // DocFullNo
			$Transaction->UpdateSort($Transaction->AccNo, $bCtrl); // AccNo
			$Transaction->UpdateSort($Transaction->AccName, $bCtrl); // AccName
			$Transaction->UpdateSort($Transaction->Description, $bCtrl); // Description
			$Transaction->UpdateSort($Transaction->Amount, $bCtrl); // Amount
			$sSortSql = $Transaction->SortSql();
			$Transaction->setOrderBy($sSortSql);
			$Transaction->setStartGroup(1);
		}
		return $Transaction->getOrderBy();
	}

	// Export email
	function ExportEmail($EmailContent) {
		global $ReportLanguage, $Transaction;
		$sSender = @$_GET["sender"];
		$sRecipient = @$_GET["recipient"];
		$sCc = @$_GET["cc"];
		$sBcc = @$_GET["bcc"];
		$sContentType = @$_GET["contenttype"];

		// Subject
		$sSubject = ewrpt_StripSlashes(@$_GET["subject"]);
		$sEmailSubject = $sSubject;

		// Message
		$sContent = ewrpt_StripSlashes(@$_GET["message"]);
		$sEmailMessage = $sContent;

		// Check sender
		if ($sSender == "") {
			$this->setMessage($ReportLanguage->Phrase("EnterSenderEmail"));
			return;
		}
		if (!ewrpt_CheckEmail($sSender)) {
			$this->setMessage($ReportLanguage->Phrase("EnterProperSenderEmail"));
			return;
		}

		// Check recipient
		if (!ewrpt_CheckEmailList($sRecipient, EWRPT_MAX_EMAIL_RECIPIENT)) {
			$this->setMessage($ReportLanguage->Phrase("EnterProperRecipientEmail"));
			return;
		}

		// Check cc
		if (!ewrpt_CheckEmailList($sCc, EWRPT_MAX_EMAIL_RECIPIENT)) {
			$this->setMessage($ReportLanguage->Phrase("EnterProperCcEmail"));
			return;
		}

		// Check bcc
		if (!ewrpt_CheckEmailList($sBcc, EWRPT_MAX_EMAIL_RECIPIENT)) {
			$this->setMessage($ReportLanguage->Phrase("EnterProperBccEmail"));
			return;
		}

		// Check email sent count
		$emailcount = ewrpt_LoadEmailCount();
		if (intval($emailcount) >= EWRPT_MAX_EMAIL_SENT_COUNT) {
			$this->setMessage($ReportLanguage->Phrase("ExceedMaxEmailExport"));
			return;
		}
		if ($sEmailMessage <> "") {
			if (EWRPT_REMOVE_XSS) $sEmailMessage = ewrpt_RemoveXSS($sEmailMessage);
			$sEmailMessage .= ($sContentType == "url") ? "\r\n\r\n" : "<br><br>";
		}
		$sAttachmentContent = $EmailContent;
		$sAppPath = ewrpt_FullUrl();
		$sAppPath = substr($sAppPath, 0, strrpos($sAppPath, "/")+1);
		if (strpos($sAttachmentContent, "<head>") !== FALSE)
			$sAttachmentContent = str_replace("<head>", "<head><base href=\"" . $sAppPath . "\" />", $sAttachmentContent); // Add <base href> statement inside the header
		else
			$sAttachmentContent = "<base href=\"" . $sAppPath . "\" />" . $sAttachmentContent; // Add <base href> statement as the first statement

		//$sAttachmentFile = $Transaction->TableVar . "_" . Date("YmdHis") . ".html";
		$sAttachmentFile = $Transaction->TableVar . "_" . Date("YmdHis") . "_" . ewrpt_Random() . ".html";
		if ($sContentType == "url") {
			ewrpt_SaveFile(EWRPT_UPLOAD_DEST_PATH, $sAttachmentFile, $sAttachmentContent);
			$sAttachmentFile = EWRPT_UPLOAD_DEST_PATH . $sAttachmentFile;
			$sUrl = $sAppPath . $sAttachmentFile;
			$sEmailMessage .= $sUrl; // send URL only
			$sAttachmentFile = "";
			$sAttachmentContent = "";
		}

		// Send email
		$Email = new crEmail();
		$Email->Sender = $sSender; // Sender
		$Email->Recipient = $sRecipient; // Recipient
		$Email->Cc = $sCc; // Cc
		$Email->Bcc = $sBcc; // Bcc
		$Email->Subject = $sEmailSubject; // Subject
		$Email->Content = $sEmailMessage; // Content
		$Email->AttachmentContent = $sAttachmentContent; // Attachment
		$Email->AttachmentFileName = $sAttachmentFile; // Attachment file name
		$Email->Format = ($sContentType == "url") ? "text" : "html";
		$Email->Charset = EWRPT_EMAIL_CHARSET;
		$EventArgs = array();
		$bEmailSent = FALSE;
		if ($Transaction->Email_Sending($Email, $EventArgs))
			$bEmailSent = $Email->Send();

		// Check email sent status
		if ($bEmailSent) {

			// Update email sent count and write log
			ewrpt_AddEmailLog($sSender, $sRecipient, $sEmailSubject, $sEmailMessage);

			// Sent email success
			$this->setMessage($ReportLanguage->Phrase("SendEmailSuccess"));
		} else {

			// Sent email failure
			$this->setMessage($Email->SendErrDescription);
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Message Showing event
	function Message_Showing(&$msg) {

		// Example:
		//$msg = "your new message";

	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
