
/////////////////////////////////////////////////
// Form Validator class.
// Provides methods for validating form elements, specifying rules,
// error messages, and whether to focus on the incorrect elements.
// Pass in the form object reference when instantiating this class.
//
/* class */ function CValidator(oForm) {
	var bError				= false;
	var sErrorMessage		= "";
	var oElementToFocus		= null;
	
	/////////////////////////////////////////////////
	// Resets the Validator object.
	//
	/* void */ function Reset() {
		bError				= false;
		sErrorMessage		= "";
		oElementToFocus		= null;
	}
	
	/////////////////////////////////////////////////
	// Validates an element containing a string.
	// Example: oValidator.ValidateString("FullName", 1, 50, "Please enter your Full Name.", true);
	//
	/* bool */ function ValidateString(sElementName, iMinChars, iMaxChars, sErrMessage, bFocus) {
		var oElement		= oForm.elements[sElementName];
		var bCorrectLength	= true;
		
		if (iMinChars) {
			if (oElement.value.length < iMinChars) bCorrectLength = false;
		}
			
		if (iMaxChars) {
			if (oElement.value.length > iMaxChars) bCorrectLength = false;
		}
			
		if (bCorrectLength == false) {
			AddErrorMessage(sErrMessage);
			if (bFocus == true) SetElementToFocus(oElement);
		}
		return bCorrectLength;
	}
	
	/////////////////////////////////////////////////
	// Validates an element containing a number.
	// Example: oValidator.ValidateNumber("Percentage", 0, 100, "Please enter a number between 0 and 100.", true);
	//
	/* bool */ function ValidateNumber(sElementName, iMinAmount, iMaxAmount, sErrMessage, bFocus) {
		var oElement		= oForm.elements[sElementName];
		var bCorrectAmount	= true;
		var bIsNaN			= false;
		
		if (!isNaN(oElement.value) && oElement.value != "") {
			var fValue		= parseFloat(oElement.value);
			if (iMinAmount) {
				if (fValue < iMinAmount) bCorrectAmount = false;
			}
				
			if (iMaxAmount) {
				if (fValue > iMaxAmount) bCorrectAmount = false;
			}
		}
		else {
			bIsNaN			= true;
		}
			
		if (bCorrectAmount == false || bIsNaN == true) {
			AddErrorMessage(sErrMessage);
			if (bFocus == true) SetElementToFocus(oElement);
		}
		return (bCorrectAmount == true && bIsNaN == false);
	}
	
	/////////////////////////////////////////////////
	// Validates a select element.
	// Checks if selected item has a value of "" (empty string).
	// Example: oValidator.ValidateSelect("Country", "Please select your Country.", true);
	//
	/* bool */ function ValidateSelect(sElementName, sErrMessage, bFocus) {
		var oElement		= oForm.elements[sElementName];
		if (oElement[oElement.selectedIndex].value == "") {
			AddErrorMessage(sErrMessage);
			if (bFocus == true) SetElementToFocus(oElement);
		}
		return (oElement[oElement.selectedIndex].value != "");
	}

	/////////////////////////////////////////////////
	// Validates checkbox elements.
	// Checks if at least one checkbox is selected.
	// Example: oValidator.ValidateCheckbox("Industry", "Please select at least one Industry.", true);
	//
	/* bool */ function ValidateCheckbox(sElementName, sErrMessage, bFocus) {
		var oElement		= oForm.elements[sElementName];
		var bChecked		= false;
		
		if (oElement.length != null) { // more than one checkbox element.
			for (var iIterate = 0; iIterate < oElement.length; iIterate++) {
				if (oElement[iIterate].checked == true) {
					bChecked = true;
					break;
				}
			}
		}
		else {
			if (oElement.checked == true) {
				bChecked = true;
			}
		}
		
		if (bChecked == false) {
			AddErrorMessage(sErrMessage);
			if (bFocus == true) SetElementToFocus(oElement[0]);
		}
		
		return bChecked;
	}
	
	/////////////////////////////////////////////////
	// Validates radio button elements.
	// Checks if one radio button is selected.
	// Example: oValidator.ValidateRadio("PaymentMethod", "Please select one Payment Method.", true);
	//
	/* bool */ function ValidateRadio(sElementName, sErrMessage, bFocus) {
		return ValidateCheckbox(sElementName, sErrMessage, bFocus);
	}
	
	/////////////////////////////////////////////////
	// Validates an element using specified regular expressions pattern.
	// Example: oValidator.ValidateRegex("PaymentMethod", /^.+@([\w\d-]+\.?)+\.\w\w+$/, "Please enter a valid Email Address.", true);
	//
	/* bool */ function ValidateRegex(sElementName, oRegexPattern, sErrMessage, bFocus) {
		var oElement = oForm.elements[sElementName];
		if (oRegexPattern.test(oElement.value) != true) {
			AddErrorMessage(sErrMessage);
			if (bFocus == true) SetElementToFocus(oElement);
		}
		return oRegexPattern.test(oElement.value);	
	}
	
	/////////////////////////////////////////////////
	// Validates the supplied "condition".
	// If bCondition does not result in true, error message is added.
	// Example: oValidator.ValidateCondition(parseFloat(oMale.value) + parseFloat(oFemale.value) == 100, "Sum of Male and Female must equal 100(%).", oMale);
	//
	/* bool */ function ValidateCondition(bCondition, sErrMessage, sElementNameToFocus) {
		if (bCondition != true) {
			AddErrorMessage(sErrMessage);
			SetElementToFocus(oForm.elements[sElementNameToFocus]);
		}
		return bCondition;
	}
	
	/////////////////////////////////////////////////
	// Returns true if all validated elements have no errors.
	//
	/* bool */ function IsValid() {
		return !bError;
	}
	
	/////////////////////////////////////////////////
	// Returns the entire error message constructed when validating elements.
	//
	/* string */ function GetErrorMessage() {
		return sErrorMessage;
	}
	
	/////////////////////////////////////////////////
	// Displays the entire error message in a Javascript alert box.
	//
	/* void */ function ShowErrorMessage() {
		alert(sErrorMessage);
		if (oElementToFocus != null) oElementToFocus.focus();
	}
	
	/////////////////////////////////////////////////
	// Adds error message to the error message holder variable.
	//
	/* void */ function AddErrorMessage(sNewErrorMessage) {
		bError				= true;
		sErrorMessage		+= (sErrorMessage == "" ? "" : "\n") + sNewErrorMessage;
	}
	
	/////////////////////////////////////////////////
	// Sets the specified element so that it gets the focus after displaying error message.
	//
	/* void */ function SetElementToFocus(oElement) {
		if (oElementToFocus == null) oElementToFocus = oElement;
	}
	
	/////////////////////////////////////////////////
	// Returns true if sValue is valid GUID.
	//
	/* bool */ function IsGUID(sValue) {
		var oRE;
		
		if (sValue != null) {
			if (sValue.length == 38) {
				oRE = new RegExp(/^\{(\d|[A-F]){8}-(\d|[A-F]){4}-(\d|[A-F]){4}-(\d|[A-F]){4}-(\d|[A-F]){12}}$/);
			}
			else if (sValue.length == 36) {
				oRE = new RegExp(/^(\d|[A-F]){8}-(\d|[A-F]){4}-(\d|[A-F]){4}-(\d|[A-F]){4}-(\d|[A-F]){12}$/);
			}
			else return false;
		}
		else return false;

		oRE.ignoreCase = true;
		return oRE.test(sValue);

	}

	/////////////////////////////////////////////////
	// Returns true if sValue is a valid email address format.
	//
	/* bool */ function IsValidEmail(sValue) {
		//var oRE = /^.+@([\w\d-]+\.?)+\.\w\w+$/;
		var oRE = /^[\w!#\$%&amp;\*\+-=?\^_\|~\.]+@[\w!#\$%&\*\+-=?\^_\|~\.]+(\.[\w!#\$%&\*\+-=?\^_\|~\.]+)+$/;
		return oRE.test(sValue);
	}
	
	/////////////////////////////////////////////////
	// Returns true if sLoginName does not contain
	// invalid characters.
	//
	function IsValidLoginName(sLoginName) {
		var oWSPattern = /\s/;
		var oCharPattern = /[\~\`\\\$\!\%\^\&\(\)\{\}\[\]\=\:\#\@\,\.\?\+\|\"\'\<\>\;\/]/;
		if (oWSPattern.test(sLoginName) || oCharPattern.test(sLoginName)) return (false);
		else return true;
	}
	
	/////////////////////////////////////////////////
	// Returns true if sPassword does not contain
	// invalid characters.
	//
	function IsValidPassword(sPassword) {
		var oPattern = /\s/;
		if (oPattern.test(sPassword)) return false;
		
		var iValidationLevel = 0;
		oPattern = /[a-z]/;
		if (oPattern.test(sPassword)) iValidationLevel += 1;
		oPattern = /[A-Z]/;
		if (oPattern.test(sPassword)) iValidationLevel += 1;
		oPattern = /\d/;
		if (oPattern.test(sPassword)) iValidationLevel += 1;
		oPattern = /[~!@#\$%\^&\*\(\)_\+-=\{\}\[\]]/;
		if (oPattern.test(sPassword)) iValidationLevel += 1;
		
		if (iValidationLevel >= 3) return true;
		else return false;
	}
	
	/////////////////////////////////////////////////
	// Returns true if sPhoneNumber has a valid
	// phone number format.
	//
	function IsValidPhoneNumber(sPhoneNumber) {
		if (sPhoneNumber != '')
		{
			var oPattern = /^(((\d?[\. -]?((\d{3,3}[\. -])|(\(\d{3,3}\)))[ ]?)?\d{3,3}[\. -]\d{4,4})|(\+?(\d|\s|\(\d+\)|([\-\.\,][0-9]))+))((\s)?(x|ext\.?\s?)\d+)?$/;
			return oPattern.test(sPhoneNumber);
		}
		return false;
	}
	
	/////////////////////////////////////////////////
	// Returns true if sURL has a valid
	// URL format.
	//
	function IsValidURL(sURL) {
		var oPattern = /^(http|https):\/\/[\w!#\$%&amp;\*\+-=?\^_\|~\.\/]+\.[\w!#\$%&amp;\*\+-=?\^_\|~\.\/]+$/;
		return oPattern.test(sURL);
	}
	
	/////////////////////////////////////////////////
	// Returns true if sPostalCode has a valid
	// Postal Code format (Atlas-wise).
	//
	function IsValidPostalCode(sPostalCode) {
		var oPattern = /^((\d{5,5}(-\d{4,4})?)|((\d[a-zA-Z]\d)(-| )?([a-zA-Z]\d[a-zA-Z]))|(([a-zA-Z]\d[a-zA-Z])(-| )?(\d[a-zA-Z]\d)))$/;
		return oPattern.test(sPostalCode);
	}
	
	/////////////////////////////////////////////////
	// Returns true if sGUID1 == sGUID2
	// Both are normalized before compared.
	// So: 
	//
	/* bool */ function CompareGUID(sGUID1, sGUID2) {
		// Normalize the GUIDs
		if (sGUID1 != null) {
			sGUID1 = sGUID1.toUpperCase();
			sGUID1 = sGUID1.replace(/\{|\}/g, "");
		}
		if (sGUID2 != null) {
			sGUID2 = sGUID2.toUpperCase();
			sGUID2 = sGUID2.replace(/\{|\}/g, "");
		}
		
		// Return the comparison
		return (sGUID1 == sGUID2);
	}
	
	this.IsValid			= IsValid;
	this.GetErrorMessage	= GetErrorMessage;
	this.ShowErrorMessage	= ShowErrorMessage;
	this.ValidateString		= ValidateString;
	this.ValidateNumber		= ValidateNumber;
	this.ValidateSelect		= ValidateSelect;
	this.ValidateCheckbox	= ValidateCheckbox;
	this.ValidateRadio		= ValidateRadio;
	this.ValidateRegex		= ValidateRegex;
	this.ValidateCondition	= ValidateCondition;
	this.Reset				= Reset;
	
	this.IsGUID				= IsGUID;
	this.IsValidEmail		= IsValidEmail;
	this.IsValidLoginName	= IsValidLoginName;
	this.IsValidPassword	= IsValidPassword;
	this.IsValidPhoneNumber	= IsValidPhoneNumber;
	this.IsValidPostalCode	= IsValidPostalCode;
	this.IsValidURL			= IsValidURL;
	this.CompareGUID		= CompareGUID;
}