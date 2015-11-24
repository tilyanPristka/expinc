<?php
@session_start();

include("inc.php");

CheckAuthentication();
CheckPermission('members');

$iCoID			= $_GET["id"];
$sFolderName	= $_GET["nm"];


$sql = ' CREATE TABLE `tilyan_'.$sFolderName.'_lookup_account` ( `ID` bigint( 100 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,'
//$sql = ' CREATE TABLE `tilyan_test_lookup_account` ( `ID` bigint( 100 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,'
. ' `AccNo` varchar( 255 ) collate latin1_general_ci default NULL ,'
. ' `AccName` text collate latin1_general_ci,'
. ' `Type` varchar( 255 ) collate latin1_general_ci default NULL ,'
. ' `Status` ENUM(\'0\',\'1\') NULL DEFAULT NULL ) ENGINE = MyISAM;'
. ' ';

mysql_query($sql) or die(mysql_error());

mysql_query("INSERT INTO tilyan_memberstable (CoID, TableName) VALUES ('".$iCoID."', 'tilyan_".$sFolderName."_lookup_account')") or die(mysql_errno()." : ".mysql_error());

echo "<meta http-equiv=\"refresh\" content=\"0;URL=ClientEdit.php?id=".$iCoID."\">";
exit();

?>