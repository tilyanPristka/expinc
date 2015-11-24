function LogOut() {
	if (confirm('You are about to log out from Administrator Page.\nClick OK to confirm.')) { document.location.href='logout.php?' }
}

function PopUp(theURL,winName,features) { //v2.0
	window.open(theURL,winName,features);
}

function Cancel(sRedir) {
	if (confirm('Cancel and Discard all changes?')) { document.location.href = sRedir}
}

function ForgetPassword() {
	window.open('forgetpassword.php?', "forgetpassword", "width=350,height=165,top=10,left=10,status=yes,scrollbars=yes,resizable=yes", false);
	}
