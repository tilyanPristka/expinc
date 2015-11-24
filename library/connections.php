<?php
$MyHost		= "localhost";
$MyDBUser	= "tp_tilyan";
$MyDBPassword	= "aOBWhfXHXJ1h";
$MyDBName	= "tp_tilyan";

// Connect to Database.
@mysql_connect($MyHost,$MyDBUser,$MyDBPassword) or die("Can't connect to the database server. Error Message:<br />".mysql_error());
@mysql_select_db($MyDBName) or die("Can't connect to the database $MyDBName. Error Message :<br />".mysql_error());
?>