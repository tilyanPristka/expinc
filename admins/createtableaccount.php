<?php
@session_start();

include("inc.php");

CheckAuthentication();
CheckPermission('members');

$iCoID			= $_GET["id"];
$sFolderName	= $_GET["nm"];

$sql = ' CREATE TABLE `tilyan_'.$sFolderName.'_account` ( `TransID` bigint( 100 ) NOT NULL auto_increment ,'
. ' `DocID` bigint( 100 ) default NULL ,'
. ' `AccNo` varchar( 255 ) collate latin1_general_ci default NULL ,'
. ' `DocCode` varchar( 5 ) collate latin1_general_ci default NULL ,'
. ' `DocCode2` varchar( 5 ) collate latin1_general_ci default NULL ,'
. ' `DocCode3` varchar( 15 ) collate latin1_general_ci default NULL ,'
. ' `AccName` text collate latin1_general_ci,'
. ' `Description` text collate latin1_general_ci,'
. ' `Amount`  decimal( 65, 2 ) DEFAULT NULL ,'
. ' `DRCR` varchar( 5 ) collate latin1_general_ci default NULL ,'
. ' PRIMARY KEY ( `TransID` ) ) ENGINE = MyISAM DEFAULT CHARSET = latin1 COLLATE = latin1_general_ci AUTO_INCREMENT =1;'
. ' ';

mysql_query($sql) or die(mysql_error());

mysql_query("INSERT INTO tilyan_memberstable (CoID, TableName) VALUES ('".$iCoID."', 'tilyan_".$sFolderName."_account')") or die(mysql_errno()." : ".mysql_error());

echo "<meta http-equiv=\"refresh\" content=\"0;URL=ClientEdit.php?id=".$iCoID."\">";
exit();

?>
