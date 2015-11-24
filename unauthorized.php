<?php
@session_start();

include("inc.php");

//CheckMemberAuthentication();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?=$Site_Name?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="scripts/global.js"></script>
</head>

<body>
	<div id="main">

        <div class="main_logo" style="float:right; margin-right: 33px; margin-bottom:6px;">
        
        </div>
        <div class="basic" style="float:left; margin-left: 2em;" id="mylist">
            <a>Unauthorized</a>
            <div style="background-color:#FFF;">

				<p></p>
                <p></p>
				<p></p>
                <p></p>
                <p style="font-size:14px; color:#990000; font-weight:bold; text-align:center;">You Are Not Permitted To Access This Page</p>
                <p></p>
                <p></p>
                <p></p>
                <p></p>

            </div>
        </div>

        <div class="bottom" style="float:left; margin-right: 33px; margin-bottom:6px;"></div>
	</div>
</body>
</html>
