function LogOut() {
	if (confirm('You are about to log out from Administrator Page.\nClick OK to confirm.')) { document.location.href='logout.php?' }
}

function PopUp(theURL,winName,features) { //v2.0
	window.open(theURL,winName,features);
}

function Cancel(sRedir) {
	if (confirm('Cancel and lose all changes?')) { document.location.href = sRedir}
}