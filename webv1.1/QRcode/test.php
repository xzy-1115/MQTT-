
<?php
$filename = $_GET['filename'];
$path = __DIR__."/var/www/".$filename;
Header( "Content-type:  application/octet-stream");
Header( "Accept-Ranges:  bytes ");
Header( "Accept-Length: " .filesize($filename));
header( "Content-Disposition:  attachment;  filename={$filename}");
echo file_get_contents($filename);
?>