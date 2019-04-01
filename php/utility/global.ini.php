<?php
/* ------ Power By Crearo. ------ */
ob_start();
session_set_cookie_params(30 * 24 * 60 * 60);
session_start();
/// 默认时区
ini_set ( "date.timezone", "Asia/Shanghai" );
header ( 'content-Type:text/html;charset=utf-8' );

$crlang_file = '../config/Region.xml';

$REGION = null;

if (file_exists($crlang_file))
{
    $xmldoc = new DOMDocument();
    if ($xmldoc->load($crlang_file))
    {
        $xpath = new DOMXPath($xmldoc);
        
        try {

            $nRegion = $xpath->query('/root/REGION')->item(0);
            
            $REGION = $nRegion->getAttribute('Value');
            
        } catch (Exception $e) {
            $REGION = null;
        }
    }
} 

$sREGION = empty($REGION) ? null : $REGION;

$temp = array(
	'region' => array(
		'name' => null
	) 
);

$temp = json_encode($temp);

echo "window.__EPC__ = $temp";

ob_end_flush();
exit();
?>


