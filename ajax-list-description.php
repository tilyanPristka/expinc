<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

if(isset($_GET['getDescByLetters']) && isset($_GET['letters'])){
	$letters = $_GET['letters'];
	$letters = preg_replace("/[^a-z0-9 ]/si","",$letters);
	$res = mysql_query("SELECT TransID,Description FROM tilyan_".$_SESSION['TLY__MemberFolder']."_account where Description like '".$letters."%' GROUP BY Description") or die(mysql_error());
	#echo "1###select ID,countryName from ajax_countries where countryName like '".$letters."%'|";
	while($inf = mysql_fetch_array($res)){
		//echo $inf["TransID"]."###".$inf["Description"]."|";
		echo $inf["TransID"]."###".$inf["Description"]."|";
	}	
}

?>
