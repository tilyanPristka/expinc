<?php
@session_start();

include("inc.php");

CheckMemberAuthentication();

$TodayDate = getdate();

$bError		= false;
$ThisPage	= "cashflow";
$PilihBulan	= $_GET['m'];
$PilihTahun	= $_GET['y'];

if($PilihBulan==""):
	$PilihBulan = $TodayDate[mon];
else:
	$PilihBulan = $_GET['m'];
endif;
if($PilihTahun==""):
	$PilihTahun = $TodayDate[year];
else:
	$PilihTahun = $_GET['y'];
endif;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="Description" content="Tilyan">
        <meta name="Keywords" content="">
        <link rel="shortcut icon" href="images/favicon.ico">
        <title>Tilyan Pristka</title>

        <link rel="stylesheet" href="css/style.css" />
	</head>

    <body>
    
        <div class="other" style="float:left; margin-bottom:6px;">
            <form name="ArticleFrm" id="ArticleFrm" action="<?=$_SERVER['PHP_SELF']."?"?>" method="get" style="padding-top:2px;">
        	<h3>List For 
				<input type="hidden" name="bSubmitted" id="bSubmitted" value="1">
                <select name="m" id="m" class="SELECT">
                    <option selected="selected">Month</option>
                    <?php
                    for ($month = 1; $month <= 12; $month++) {
                        if (strlen($month)==1):
                            echo "<option value=0".$month." ";
                        else:
                            echo "<option value=".$month." ";
                        endif;
                    
                        if ($PilihBulan==$month) {echo " SELECTED";}
                        echo ">";
                    
                        if ($month=="1"):
                            echo "Januari";
                        elseif ($month=="2"):
                            echo "Februari";
                        elseif ($month=="3"):
                            echo "Maret";
                        elseif ($month=="4"):
                            echo "April";
                        elseif ($month=="5"):
                            echo "Mei";
                        elseif ($month=="6"):
                            echo "Juni";
                        elseif ($month=="7"):
                            echo "Juli";
                        elseif ($month=="8"):
                            echo "Agustus";
                        elseif ($month=="9"):
                            echo "September";
                        elseif ($month=="10"):
                            echo "Oktober";
                        elseif ($month=="11"):
                            echo "November";
                        elseif ($month=="12"):
                            echo "Desember";
                        endif;
                        
                        echo"</option>\n";
                    }
                    ?>
                </select> : 
                <select name="y" id="select3" class="SELECT">
                    <option selected="selected">Year</option>
                    <?php
                    $currentYear = date("y");
                    for ($year = 2002; $year <= $TodayDate[year]; $year++) {
                        echo "<option";
                        if ($PilihTahun==$year) {echo " SELECTED";}
                        echo ">$year</option>\n";
                    }
                    ?>
                </select>&nbsp;
                <input type="submit" name="Submit" value="Submit" class="btn" /> - <div style="font-size: smaller; display: inline;">right-click then save file to download</div>
                
            </h3>
			</form>
            <p>&nbsp;</p>
			<?php
				$dir = "klien/".$_SESSION['TLY__MemberFolder']."/".$ThisPage."/".$PilihTahun.$PilihBulan."/*";
				//echo $dir;  
				
				$iFiles = 0;
				//Open a known directory, and proceed to read its contents  
				foreach(glob($dir) as $file) {
					$sFilename = explode("/",$file);
					$sTrueFilename = $sFilename[4];
					if($iFiles==2):
						$iFiles = 0;
						$sFloat = "left";
					elseif ($iFiles==1):
						$sFloat = "right";
					elseif ($iFiles==0):
						$sFloat = "left";
					endif; 
					echo "<div class=\"files\" style=\"float:$sFloat;\"><img src=\"images/icon_pdf.png\" align=\"absmiddle\" style=\"padding-right: 6px;\">filename: <a href=\"$file\" class=\"normallink\">$sTrueFilename</a></div>";
					$iFiles = $iFiles+1;
					if($iFiles==2):
						echo "<br />";
					endif;
				}
			?>

        </div>

    </body>
</html>
