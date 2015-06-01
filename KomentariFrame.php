<?php session_start(); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>&quot;Grande&quot; baleta studija. Dejas teāris. Komentari</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
$sqlhost="localhost";
//name of user
$sqluser="root"; 
//password
$sqlpass="uVh98)(kL"; 
//name of db
$db="grande"; 

//connecting to MySQL
mysql_connect($sqlhost,$sqluser,$sqlpass) or die ("MySQL is not ready!");
mysql_query("SET NAMES 'utf8'");

//connecting to db
mysql_select_db($db) or die("Error! Can't connect to DB!".mysql_error());


//insert new
if ($_POST['newcomm']!='')
{
	if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] === $_POST['keystring']){
			if ($_POST['name']=='Tālis' || $_POST['name']=='') {
				$_POST['name']='Nezināmais';
			}
			if ($_POST['name']=='Tālis123') {
				$_POST['name']='Tālis';
			}
			$message = $_POST['newcomm'];
			$message = stripcslashes(hebrevc($message));
			
			$sql = "
			INSERT INTO `comments` (
			`name` ,
			`date` ,
			`text`
			)
			VALUES (
			'".mysql_escape_string($_POST['name'])."', CURDATE(), '".mysql_escape_string($message)."'
			);
			";
			
			$result=mysql_query($sql);
			if ($result==false) {
				 echo 'Uzmanību! Neizdevas piereģitrēt Jūsu kommentāru. Atvainojamies par neērtībam. Pameiģiniet vēlreiz.' ;
				 $rr = false;
			} else {
				$rr = true;
			}
	}else{
		echo "Uzmanību! Drošības kods ir nepareizs. Pameiģiniet vēlreiz.";
		$rr = false;
	}
	

}


//delete row
if ($_GET['id']!=0 && $_SESSION['talis']==true) {
	$result=mysql_query("DELETE FROM comments WHERE id=".mysql_escape_string($_GET['id']));
	if ($result==false) {
		 echo 'Uzmanību! Neizdevas nodzēst kommentāru. Atvainojamies par neērtībam. Pameiģiniet velreiz vai pasakiet par problēmu Alvim.';
		 exit;
	}
}


//get all, but on current page
$page = mysql_escape_string($_GET['page']);
if ($page=='') { $page=0; }

$count = 10;

$result=mysql_query("SELECT id FROM comments");
$pagenum = (mysql_num_rows($result) - mysql_num_rows($result) % $count) / $count;
if (mysql_num_rows($result) % $count != 0) { $pagenum++; }

if ($page+1>$pagenum) { $page--; }

$sql = "SELECT id,name,date,text FROM comments ORDER BY id DESC LIMIT ".($page*$count).", ".$count;
$result=mysql_query($sql);


//login
if ($_POST['name']=='Tālis123-del' && $_POST['newcomm']=='')
{
	$_SESSION['talis']=true;
}

?>
<style type="text/css">
<!--
body {
	background-image: url(Images/fonVerySmall.jpg);
	margin-left: 0px;
	margin-top: 0px;
}
body,td,th {
	font-family: Times New Roman, Times, serif;
}
.one {
	padding: 8px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: dashed;
	border-right-style: none;
	border-bottom-style: dashed;
	border-left-style: none;
	border-top-color: #EADFFF;
	border-right-color: #EADFFF;
	border-bottom-color: #EADFFF;
	border-left-color: #EADFFF;
	text-align: left;
	vertical-align: middle;
}
.oneL {
	padding: 8px;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: dashed;
	border-right-style: none;
	border-bottom-style: dashed;
	border-left-style: none;
	border-top-color: #EADFFF;
	border-right-color: #EADFFF;
	border-bottom-color: #EADFFF;
	border-left-color: #EADFFF;
	text-align: center;
	vertical-align: middle;
	font-size: small;
	font-style: italic;
	font-weight: lighter;
	color: #666666;
}
.vip {
	padding: 8px;
	background-color: #F3EAFF;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-top-color: #CC6600;
	border-right-color: #CC6600;
	border-bottom-color: #CC6600;
	border-left-color: #CC6600;
	text-align: left;
	vertical-align: middle;
}
.vipL {
	padding: 8px;
	background-color: #F3EAFF;
	border-top-width: 1px;
	border-right-width: 1px;
	border-bottom-width: 1px;
	border-left-width: 1px;
	border-top-style: solid;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-top-color: #CC6600;
	border-right-color: #CC6600;
	border-bottom-color: #CC6600;
	border-left-color: #CC6600;
	font-style: italic;
	font-weight: bold;
	text-align: center;
	vertical-align: middle;
	color: #330000;
}
.new {
	background-color: #FFD793;
	text-align: center;
	vertical-align: middle;
	padding: 10px;
	color: #330066;
	border-top-width: 2px;
	border-right-width: 2px;
	border-bottom-width: 2px;
	border-left-width: 2px;
	border-top-style: solid;
	border-bottom-style: solid;
	border-top-color: #330000;
	border-right-color: #330000;
	border-bottom-color: #330000;
	border-left-color: #330000;
	border-right-style: none;
	border-left-style: none;
}
.sendbut {
	padding: 2px;
	height: 32px;
	width: 180px;
	border: 3px outset #993300;
	background-color: #990000;
	color: #FFFFFF;
	font-weight: bold;
}
.lapas {
	font-size: small;
	color: #666666;
	padding: 15px;
	text-align: center;
	vertical-align: middle;
}
.two {
	padding: 8px;
	background-color: #FFFAEE;
	text-align: left;
	vertical-align: middle;
}
.twoL {
	padding: 8px;
	background-color: #FFFAEE;
	text-align: center;
	vertical-align: middle;
	font-size: small;
	font-style: italic;
	font-weight: lighter;
	color: #666666;
}
#apDiv1 {
	position:absolute;
	left:79px;
	top:168px;
	width:443px;
	height:270px;
	z-index:1;
}
.all {
	padding: 10px;
}
-->
</style>
<meta name="keywords" content="balets dejas Grande baleta studija teatris izglītība dejot balets bērni bernu baleta teatris">
<meta name="description" content="Baleta studija, dejas teātris "grande"">
<script type="text/javascript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>

<body>
<table width="600" border="0" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr>
    <td height="100" colspan="2" valign="top"><img src="Images/fonKomentari.jpg" width="600" height="100"></td>
  </tr>
  <tr>
    <td height="1" colspan="2" valign="top"><img src="Images/horizLine.gif" width="600" height="1"></td>
  </tr>
  <tr>
    <td>
    <table border="0" cellpadding="0" cellspacing="0" class="all">
<?php
$i = 0;
while ($line = mysql_fetch_row($result))
{

if ($line[1] == 'Tālis') {
	$style = 'vip';
} else {
	if ($i%2==0) {
		$style = 'one';
	} else {
		$style = 'two';
	}
}

echo '<tr>';
echo '<td class="'.$style.'L">'.$line[1].'<br>'.$line[2].'</td>';
echo '<td class="'.$style.'">'.$line[3];

if ($_SESSION['talis']==true) {
echo '<p><a href="KomentariFrame.php?id='.$line[0].'&page='.$page.'" target="_self">-Nodzēst-</a></p>';
}

echo '</td>';
echo '</tr>';


$i++;
}
?>
      
    </table>
    </td>
  </tr>
  
  
  <tr>
  <td class="lapas">
  <?php
  	 if ($page!=0) 
	 { 
		 echo '<a href="KomentariFrame.php?page='.($page-1).'" target="_self">&lt;&lt;&lt;</a>';
		 echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	 }
	 for ($i=1;$i<$pagenum;$i++)
	 {
	 	echo ' ';
	 	if ($i!=$page+1) {
			echo '<a href="KomentariFrame.php?page='.($i-1).'" target="_self">';
		}
		echo $i;
		if ($i!=$page+1) {
			echo '</a>';
		}
		echo ' |';
	 }
	 if ($i!=$page+1) {
	    echo ' ';
		echo '<a href="KomentariFrame.php?page='.($i-1).'" target="_self">';
		}
		echo $i;
		if ($i!=$page+1) {
			echo '</a>';
		}
	  if ($page<$pagenum-1) 
	 { 
	 	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		 echo '<a href="KomentariFrame.php?page='.($page+1).'" target="_self">&gt;&gt;&gt;</a>';

	 }
  ?>
  </td>
  </tr>
  
  
  
  
  <tr>
    <td class="new">
    <script language="JavaScript" type="text/javascript">
	<!--
	function submitForm() {
	if (document.form1.name.value=='Tālis123-del')
	{ 
	   return (true);
	}
	   if (document.form1.newcomm.value=='')
		{
		// If there were no selections made display an alert box 
		alert("Ievadiet Jūsu kommentāru!")
		return (false);
		}
		return (true);
	}
	</script>
      <form name="form1" method="post" action="">
        <p>Jūsu vārds: <input type="text" name="name" id="textfield" maxlength="30" value="<?php
		if (isset($_POST['newcomm']) && $rr == false) {
			echo $_POST['name'];
		}
		?>"></p>
        <p>Komentārs: <br>
          <textarea name="newcomm" id="textarea" cols="60" rows="5"><?php
		if (isset($_POST['newcomm']) && $rr == false) {
			echo $_POST['newcomm'];
		}
		?></textarea>
        </p>
		<p>Lūdzam apakšā ievadīt drošības kodu:</p>
<p><img src="./kcaptcha/?<?php echo session_name()?>=<?php echo session_id()?>"></p>
<p><input type="text" name="keystring"></p>
        <p>
          <input type="submit" name="sendBut" id="button" value="Nosūtīt" class="sendbut">
        </p>
      </form>    
    </td>
  </tr>
</table>
</body>
</html>
