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
  $theVal = $doc->getActiveSheet()->getCell('C1')->getValue();
  if ($vIndex !='statedaybm' && $vIndex !='statemonthbm' && $vIndex !='statemonthstbm')
     $doc->getActiveSheet()->getStyle('A3:J3')->getFont()->setBold(true);
  else	{ 
	  
	  
	  $doc->getActiveSheet()->setCellValueExplicit('C1', $theVal,  PHPExcel_Cell_DataType::TYPE_STRING);
	  $vCount=count($sheet); 
	  for ($i=1;$i<$vCount+2;$i++) {
		  $theVal = $sheet[($i)][0];  
		  $doc->getActiveSheet()->setCellValueExplicit('A'.($i+1), $theVal,  PHPExcel_Cell_DataType::TYPE_STRING);
	  }
	  
	  	  for ($i=1;$i<$vCount+2;$i++) {
		  $theVal = $sheet[($i)][10];  
		  $doc->getActiveSheet()->setCellValueExplicit('K'.($i+1), $theVal,  PHPExcel_Cell_DataType::TYPE_STRING);
	  }
	}
//->getNumberFormat()->setFormatCode('0000');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$vFileName.'.xls"');
header('Cache-Control: max-age=0');

  // Do your stuff here
  $writer = PHPExcel_IOFactory::createWriter($doc, 'Excel5');

$writer->save('php://output');

//print_r($sheet);
?>