<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

$TodayDate = getdate();
$TheDate = $TodayDate[year]."/".$TodayDate[mon]."/".$TodayDate[mday]." ".$TodayDate[hours].":".$TodayDate[minutes].":".$TodayDate[seconds];

//check table for client
$SQLCheck1	= mysql_query("SELECT CoID, TableName FROM tilyan_memberstable WHERE CoID = ".$_SESSION['TLY__MemberID']." AND TableName = 'tilyan_".$_SESSION['TLY__MemberFolder']."_document'");
if (mysql_num_rows($SQLCheck1) == 0) {
	$iTableExists1 = 0;
	//$iTableExists = 0;
} else {
	$iTableExists1 = 1;
	//$iTableExists = 1;
}
$SQLCheck2	= mysql_query("SELECT CoID, TableName FROM tilyan_memberstable WHERE CoID = ".$_SESSION['TLY__MemberID']." AND TableName = 'tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_code1'");
if (mysql_num_rows($SQLCheck2) == 0) {
	$iTableExists2 = 0;
} else {
	$iTableExists2 = 1;
}
$SQLCheck3	= mysql_query("SELECT CoID, TableName FROM tilyan_memberstable WHERE CoID = ".$_SESSION['TLY__MemberID']." AND TableName = 'tilyan_".$_SESSION['TLY__MemberFolder']."_lookup_code2'");
if (mysql_num_rows($SQLCheck3) == 0) {
	$iTableExists3 = 0;
} else {
	$iTableExists3 = 1;
}
if ($iTableExists1==1 && $iTableExists2==1 && $iTableExists3==1) {
	$iTableExists = 1;
} else {
	$iTableExists = 0;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="Description" content="Tilyan">
        <meta name="Keywords" content="">
        <link rel="shortcut icon" href="images/favicon.ico">
        <title>tilyanPristka</title>

        <link rel="stylesheet" href="css/style.css" />
        
        <script type="text/javascript" src="scripts/lib/jquery.js"></script>
        <script type="text/javascript" src="scripts/lib/chili-1.7.pack.js"></script>
        
        <script type="text/javascript" src="scripts/lib/jquery.easing.js"></script>
        <script type="text/javascript" src="scripts/lib/jquery.dimensions.js"></script>
        <script type="text/javascript" src="scripts/lib/jquery.accordion.js"></script>

		<script type="text/javascript">
			jQuery().ready(function(){
				// simple accordion
				jQuery('#mylist').accordion({
					/*autoheight: false*/
				});
				
		
				var wizard = $("#wizard").accordion({
					header: '.title',
					event: false
				});
			
				var wizardButtons = $([]);
				$("div.title", wizard).each(function(index) {
					wizardButtons = wizardButtons.add($(this)
					.next()
					.children(":button")
					.filter(".next, .previous")
					.click(function() {
						wizard.accordion("activate", index + ($(this).is(".next") ? 1 : -1))
					}));
				});
			
				// bind to change event of select to control first and seconds accordion
				// similar to tab's plugin triggerTab(), without an extra method
				var accordions = jQuery('#list1a, #list1b, #list2, #list3, #navigation, #wizard');
			
				jQuery('#switch select').change(function() {
					accordions.accordion("activate", this.selectedIndex-1 );
				});
				jQuery('#close').click(function() {
					accordions.accordion("activate", -1);
				});
				jQuery('#switch2').change(function() {
					accordions.accordion("activate", this.value);
				});
				jQuery('#enable').click(function() {
					accordions.accordion("enable");
				});
				jQuery('#disable').click(function() {
					accordions.accordion("disable");
				});
				jQuery('#remove').click(function() {
					accordions.accordion("destroy");
					wizardButtons.unbind("click");
				});
			});
		</script>

        <script type="text/javascript" src="scripts/lib/jquery.prettydate.js"></script>
		<script>
            $(function() {
                // set a fixed date for the demo to be independent of the current date
                $.prettyDate.now = function() {
                    return new Date("<?php echo $TheDate?>");
                }
                $("a").prettyDate({
					interval: false
				});
            });
        </script>

	</head>

<body>
	<div id="main">

        <div class="main_top" style="float:left; margin-left: 33px; margin-bottom:6px;">
        	<?php if ($_SESSION["TLY__Logo"]!="") { ?><img src="uploads/logo/<?php echo $_SESSION['TLY__Logo']?>" width="192" style="float: left; padding-right: 13px;" /><?php } ?>
        	<p>Welcome back, <strong style="color:#990000;"><?php echo $_SESSION["TLY__MemberName"]?> (<?php echo $_SESSION["TLY__PermissionText"]?>)</strong></p>
            <p><?php if ($_SESSION["TLY__LastLogin"]!="0000-00-00 00:00:00") { ?>Your Last Login : <span style="color: #990000;"><a title="<?php echo ViewDateTimeFormat($_SESSION["TLY__LastLogin"], 8)?>"><?php echo ViewDateTimeFormat($_SESSION["TLY__LastLogin"], 2)?></a></span><?php } else { ?>This is <span style="color: #990000;">Your First Login</span><?php } ?></p>
            <p><a href="logout.php?">logout</a>
        </div>
        <div class="main_logo" style="float:right; margin-right: 33px; margin-bottom:6px;">
        
        </div>


        <div class="basic" style="float:left; margin-left: 2em;" id="mylist">
            <a>Account Administration</a>
            <div style="background-color:#FFF;">
				<iframe id='account' name='account' src='account.php' framespacing='0' frameborder='no' scrolling='yes' width='100%' height='335'></iframe>
            </div>
            <?php
			if($iTableExists):
			?>
            <a>Documents</a>
            <div style="background-color:#FFF;">
				<iframe id='documents' name='documents' src='documentadd.php' framespacing='0' frameborder='no' scrolling='yes' width='100%' height='335'></iframe>
            </div>
            <?php
			endif;
			?>
            <a>Financial Statement - Balance Sheet</a>
            <div style="background-color:#FFF;">
				<iframe id='balance_sheet' name='balance_sheet' src='balance.php' framespacing='0' frameborder='no' scrolling='yes' width='100%' height='335'></iframe>
            </div>
            <a>Financial Statement - Income Statement</a>
            <div style="background-color:#FFF;">
				<iframe id='income_statement' name='income_statement' src='income.php' framespacing='0' frameborder='no' scrolling='yes' width='100%' height='335'></iframe>
            </div>
            <a>Financial Statement - Cash Flow</a>
            <div style="background-color:#FFF;">
				<iframe id='cash_flow' name='cash_flow' src='cashflow.php' framespacing='0' frameborder='no' scrolling='yes' width='100%' height='335'></iframe>
            </div>
            <a>Tax Report</a>
            <div style="background-color:#FFF;">
				<iframe id='journal_voucher' name='journal_voucher' src='voucher.php' framespacing='0' frameborder='no' scrolling='yes' width='100%' height='335'></iframe>
            </div>
        </div>

        <div class="bottom" style="float:left; margin-right: 33px; margin-bottom:6px;"></div>
	</div>

</body>
</html>
