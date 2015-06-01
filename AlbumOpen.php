<?
function img_resize($src, $dest, $width, $height, $rgb=0xFFFFFF, $quality=100)
{
  if (!file_exists($src)) return false;

  $size = getimagesize($src);

  if ($size === false) return false;

  // Определяем исходный формат по MIME-информации, предоставленной
  // функцией getimagesize, и выбираем соответствующую формату
  // imagecreatefrom-функцию.
  $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));
  $icfunc = "imagecreatefrom" . $format;
  if (!function_exists($icfunc)) return false;

  $x_ratio = $width / $size[0];
  $y_ratio = $height / $size[1];

  $ratio       = min($x_ratio, $y_ratio);
  $use_x_ratio = ($x_ratio == $ratio);

  $new_width   = $use_x_ratio  ? $width  : floor($size[0] * $ratio);
  $new_height  = !$use_x_ratio ? $height : floor($size[1] * $ratio);
  $new_left    = $use_x_ratio  ? 0 : floor(($width - $new_width) / 2);
  $new_top     = !$use_x_ratio ? 0 : floor(($height - $new_height) / 2);

  $isrc = $icfunc($src);
  $idest = imagecreatetruecolor($width, $height);

  imagefill($idest, 0, 0, $rgb);
  imagecopyresampled($idest, $isrc, $new_left, $new_top, 0, 0, 
    $new_width, $new_height, $size[0], $size[1]);

  imagejpeg($idest, $dest, $quality);

  imagedestroy($isrc);
  imagedestroy($idest);

  return true;

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Album Grande</title>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
<style>
	.imagelink {
	background-color: #F3F8F8;
	margin: 10px;
	padding: 5px;
	border: 1px solid #CCC;
	text-align: center;
	vertical-align: middle;
	height: 120px;
	width: 120px;
	}
	.imagelink td {
	background-color: #FFF;
	padding: 8px;
	border: 3px solid #E0E0E0;		
	}
	.imagelink td:hover {
	background-color: #CCC;
	padding: 3px;
	border: 2px solid #FFF;		
	}
</style>

</head>

<body>
<?
$album = $_GET['album'];

$path = "Photos/".$album."/images";

if (!(is_dir("Photos/".$album."/thumbs") ))
{
	mkdir("Photos/".$album."/thumbs");
}

if ( is_dir($path) ) 
{
	
	$dir_handle = opendir($path);
	$f = readdir($dir_handle);
	
	?> <table width="100%" border="0" cellspacing="20" cellpadding="8" class="imagelink" align="center"> <?
	$i = 0;
	while(!($f === false))
	{
		if ($i % 6 == 0) {
			?> <tr> <? 
		}
		if ($f != "." && $f != "..") {
			$file = $path.'/'.$f;
			$path_parts = pathinfo($file);
			if ($path_parts['extension'] == 'jpg')
			{
				
				$thumb = "Photos/".$album."/thumbs/".$f;
				if (!(file_exists($thumb)))
				{
					//create thumb
					
					img_resize($file, $thumb, 100, 100, 0xCCCCCC);
				}
				?> <td> <a href="<?= $file ?>" rel="lightbox[groupofimages]"><img src="<?= $thumb ?>" border="0" /></a></td> <?
			}
			else 
			{
				echo 'Error: directory has incorrect files (not jpg)';	
			}
		} else { $i--; }
		$f = readdir($dir_handle);
		$i++;
		if ($i % 6 == 0) {
			?> </tr> <?
		}
	}
	?> </table> <?
	closedir($dir_handle);
} else {
	echo "<strong>Kļūda - tādas galerijas nav.</strong>";
}


?>


</body>
</html>