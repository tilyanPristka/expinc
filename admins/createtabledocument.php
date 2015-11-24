<?php
@session_start();

include("inc.php");

CheckAuthentication();
CheckPermission('members');

$iCoID			= $_GET["id"];
$sFolderName	= $_GET["nm"];


$sql = ' CREATE TABLE `tilyan_'.$sFolderName.'_document` ( `DocID` bigint( 100 ) NOT NULL auto_increment ,'
. ' `RefDocID` bigint( 100 ) default NULL ,'
. ' `DocRealDate` date default NULL ,'
. ' `DocDate` date default NULL ,'
. ' `DocFullNo` varchar( 255 ) collate latin1_general_ci default NULL ,'
. ' `DocFolder` varchar( 50 ) collate latin1_general_ci default NULL ,'
. ' `DocADJ` varchar( 5 ) collate latin1_general_ci default NULL ,'
. ' `DocType` varchar( 5 ) collate latin1_general_ci default NULL ,'
. ' `DocInOut` varchar( 5 ) collate latin1_general_ci default NULL ,'
. ' `DocNickName` varchar( 50 ) collate latin1_general_ci default NULL ,'
. ' `DocCode` varchar( 5 ) collate latin1_general_ci default NULL ,'
. ' `DocCode2` varchar( 5 ) collate latin1_general_ci default NULL ,'
. ' `DocCode3` varchar( 5 ) collate latin1_general_ci default NULL ,'
. ' `DocYear` int( 10 ) default NULL ,'
. ' `DocMonth` int( 10 ) default NULL ,'
. ' `DocTime` varchar( 15 ) collate latin1_general_ci default NULL ,'
. ' `DocNo` bigint( 100 ) default NULL ,'
. ' `DocNotes` text collate latin1_general_ci default NULL ,'
. ' `DocClear` int( 10 ) default NULL ,'
. ' `DocClearDate` date default NULL ,'
. ' `DocAdjusted` int( 10 ) default NULL ,'
. ' `DocPrinted` int( 10 ) default NULL ,'
. ' PRIMARY KEY ( `DocID` ) ) ENGINE = MyISAM DEFAULT CHARSET = latin1 COLLATE = latin1_general_ci AUTO_INCREMENT =1;'
. ' ';

mysql_query($sql) or die(mysql_error());

mysql_query("INSERT INTO tilyan_memberstable (CoID, TableName) VALUES ('".$iCoID."', 'tilyan_".$sFolderName."_document')") or die(mysql_errno()." : ".mysql_error());

echo "<meta http-equiv=\"refresh\" content=\"0;URL=ClientEdit.php?id=".$iCoID."\">";
exit();

?>