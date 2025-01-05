<?php
date_default_timezone_set('Asia/Jakarta');

require_once('../classes/PHPExcel.php');

$sheet = array(
    array(
      'a1 data',
      'b1 data',
      'c1 data',
      'd1 data',
    )
  );

  $doc = new PHPExcel();
  $doc->setActiveSheetIndex(0);

  $doc->getActiveSheet()->fromArray($sheet, null, 'A1');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="your_name.xls"');
header('Cache-Control: max-age=0');

  // Do your stuff here
  $writer = PHPExcel_IOFactory::createWriter($doc, 'Excel5');

$writer->save('php://output');
?>