<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<?php
$to = "instrbanka@delfi.lv";


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// Additional headers
//$headers .= 'To: to <to@example.com>, Kelly <to2@example.com>' . "\r\n";
//$headers .= 'From: from <from@example.com>' . "\r\n";
//$headers .= 'Cc: cc@example.com' . "\r\n";
//$headers .= 'Bcc: bcc@example.com' . "\r\n";


mail($to,'Grande massage','<b>'.$_POST['sub'].'</b><br><br>'.$_POST['mes'],$headers);
echo "Jūsu komentārs ar tekstu:<br><br>".$_POST['mes']."<br><br> drīzumā būs novietots mūsu saitā. <BR><center>
<a href='http://www.grande.lv/KomentariFrame.php'>Atpakaļ</a>";
?>
</body>
</html>