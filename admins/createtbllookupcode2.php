<?php
@session_start();

include("inc.php");

CheckAuthentication();
CheckPermission('members');

$iCoID			= $_GET["id"];
$sFolderName	= $_GET["nm"];


$sql = ' CREATE TABLE `tilyan_'.$sFolderName.'_lookup_code2` ( `ID` bigint( 100 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,'
//$sql = ' CREATE TABLE `tilyan_test_lookup_account` ( `ID` bigint( 100 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,'
. ' `CodeName` varchar( 255 ) collate latin1_general_ci default NULL ,'
. ' `CodeDesc` text collate latin1_general_ci,'
. ' `ContractNo` varchar( 255 ) collate latin1_general_ci default NULL ,'
. ' `ContractValue` varchar( 255 ) collate latin1_general_ci default NULL ,'
. ' `StartDate` date default NULL ,'
. ' `EndDate` date default NULL ,'
. ' `Status` ENUM(\'0\',\'1\') NULL DEFAULT NULL ) ENGINE = MyISAM;'
. ' ';

mysql_query($sql) or die(mysql_error());

mysql_query("INSERT INTO tilyan_memberstable (CoID, TableName) VALUES ('".$iCoID."', 'tilyan_".$sFolderName."_lookup_code2')") or die(mysql_errno()." : ".mysql_error());

echo "<meta http-equiv=\"refresh\" content=\"0;URL=ClientEdit.php?id=".$iCoID."\">";
exit();

?>