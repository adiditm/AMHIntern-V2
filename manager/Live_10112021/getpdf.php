<?php
session_start();
date_default_timezone_set('Asia/Jakarta');

$vFileName=$_GET['file']."_".date("YmdHis");
$vIndex=$_GET['arr'];

require_once('../classes/PHPExcel.php');
/*
$sheet = array(
    array(
      'Member Data'
    ),
	
	    array(
      ''
    ),

	    array(
      'a1 data',
      'b1 data',
      'c1 data',
      'd1 data',
    ),

	
  );
*/
$sheet = $_SESSION[$vIndex];

  $doc = new PHPExcel();
  $doc->setActiveSheetIndex(0);

  $doc->getActiveSheet()->fromArray($sheet, null, 'A1');

header('Content-Type: application/pdf');
header('Content-Disposition: attachment;filename="01simple.pdf"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF');
$objWriter->save('php://output');
exit;

?>