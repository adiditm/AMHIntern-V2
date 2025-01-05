<?php
  include_once("phplib.php");    
  class phpdate {
     var $vArBulan= array("01"=> "Januari", "02" => "Februari","03" => "Maret","04" => "April","05" => "Mei","06"=> "Juni","07" => "Juli","08" => "Agustus","09" => "September","10" => "Oktober","11" => "Nopember","12" => "Desember");
	 var $vArBulanInt= array(1=> "Januari", 2 => "Februari",3 => "Maret",4 => "April",5 => "Mei",6=> "Juni",7 => "Juli",8 => "Agustus",9 => "September",10 => "Oktober",11 => "Nopember",12 => "Desember");
	  //Tanggal sekarang ddmmyyyy
     function dispYearAround() {
	    $vYNow=date("Y");
		$vOut="";
		for ($i=5;$i>0;$i--) {
		  $vOut[]=$vYNow-$i; 
		}		
		for ($i=0;$i<5;$i++) {
		  $vOut[]=$vYNow+$i; 
		}		
		
		return $vOut;
	 }
	 
	      function dispYearAroundFwd() {
	    $vYNow=date("Y");
		$vOut="";
		for ($i=0;$i<5;$i++) {
		  $vOut[]=$vYNow+$i; 
		}		
		
		return $vOut;
	 }


	 function getNowDMY($pSeparator='-') {
	     if ($pSeparator=='/')
		    return date('d/m/Y');
		 else if ($pSeparator=='-')	
		    return date('d-m-Y');
	  }
 
       //Tanggal sekarang ddmmyyyyhms
      function getNowDMYT($pSeparator='-') {
	     if ($pSeparator=='/')
		    return date('d/m/Y H:i:s');
		 else if ($pSeparator=='-')	
		    return date('d-m-Y H:i:s');
	  }

       //Tanggal sekarang mmddyyyy
      function getNowMDY($pSeparator='-') {
	     if ($pSeparator=='/')
		    return date('m/d/Y');
		 else if ($pSeparator=='-')	
		    return date('m-d-Y');
	  }

       //Tanggal sekarang mmddyyyyhms
      function getNowMDYT($pSeparator='-') {
	     if ($pSeparator=='/')
		    return date('m/d/Y H:i:s');
		 else if ($pSeparator=='-')	
		    return date('m-d-Y H:i:s');
	  }


       //Tanggal sekarang yyyymmdd
      function getNowYMD($pSeparator='-') {
	     if ($pSeparator=='/')
		    return date('Y/m/d');
		 else if ($pSeparator=='-')	
		    return date('Y-m-d');
	  }


       //Tanggal sekarang yyyymmddhms
      function getNowYMDT($pSeparator='-') {
	     if ($pSeparator=='/')
		    return date('Y/m/d H:i:s');
		 else if ($pSeparator=='-')	
		    return date('Y-m-d H:i:s');
	  }

       //Waktu sekarang hms
      function getNowT() {
		    return date('H:i:s');
	  }


       //Tahun sekarang 
      function getNowYear() {
		    return date('Y');
	  }

       //bulan sekarang 
      function getNowMonth() {
		    return date('m');
	  }


       //tanggal sekarang 
      function getNowDay() {
		    return date('d');
	  }


       //Waktu awal
      function getStartTime() {
		    return "00:00:00";
	  }

       //Waktu akhir
      function getEndTime() {
		    return "23:59:59";
	  }


      //yyyymmdd ke ddmmyyyy
	  function YMD2DMY($pDate,$pSeparator='-') {
	      if ($pSeparator=='/')
		     $vOut=substr($pDate,8,2)."/".substr($pDate,5,2)."/".substr($pDate,0,4);
		  else if ($pSeparator=='-')	 	 
		     $vOut=substr($pDate,8,2)."-".substr($pDate,5,2)."-".substr($pDate,0,4);
		  return $vOut;
		  	 
	  }





      //yyyymmdd ke ddmmyyyy
	  function DMY2YMD($pDate,$pSeparator='-') {
	      if ($pSeparator=='/')
		     $vOut=substr($pDate,6,4)."/".substr($pDate,3,2)."/".substr($pDate,0,2);
		  else if ($pSeparator=='-')	 	 
		     $vOut=substr($pDate,6,4)."-".substr($pDate,3,2)."-".substr($pDate,0,2);
		  return $vOut;
		  	 
	  }


      //mmddyyyy ke ddmmyyyy
	  function MDY2DMY($pDate,$pSeparator='-') {
	      if ($pSeparator=='/')
		     $vOut=substr($pDate,3,2)."/".substr($pDate,0,2)."/".substr($pDate,6,4);
		  else if ($pSeparator=='-')	 	 
		     $vOut=substr($pDate,3,2)."-".substr($pDate,0,2)."-".substr($pDate,6,4);
		  return $vOut;
		  	 
	  }


      //ddmmyyyy ke mmddyyyy
	  function DMY2MDY($pDate,$pSeparator='-') {
	      if ($pSeparator=='/')
		     $vOut=substr($pDate,3,2)."/".substr($pDate,0,2)."/".substr($pDate,6,4);
		  else if ($pSeparator=='-')	 	 
		     $vOut=substr($pDate,3,2)."-".substr($pDate,0,2)."-".substr($pDate,6,4);
		  return $vOut;
		  	 
	  }


      //yyyymmddtt ke ddmmyyyytt
	  function YMDT2DMYT($pDate,$pSeparator='-') {
	      if ($pSeparator=='/')
		     $vOut=substr($pDate,8,2)."/".substr($pDate,5,2)."/".substr($pDate,0,4)." ".substr($pDate,11,8);
		  else if ($pSeparator=='-')	 	 
		     $vOut=substr($pDate,8,2)."-".substr($pDate,5,2)."-".substr($pDate,0,4)." ".substr($pDate,11,8);
		  return $vOut;
		  	 
	  }

      //Ambil waktu dari timestamp
	  function getTimeFromDate($pDate) {
			 $vOut=substr($pDate,11,8);
			 if (strlen($vOut)==0)
		        return "00:00:00";   
			 else
			 	return $vOut;	  	 
	  }

      //Ambil range 2 mingguan dari tanggal
	  function getRange2WeekFromDay($pDate) {
             global $oDB;
			 $vSQL="select date_add(concat(year('$pDate'),'-',month('$pDate'),'-','1'), interval 0 day) as mo_start,";
			 $vSQL.="date_sub(date_add(concat(year('$pDate'),'-',month('$pDate'),'-','1'), interval 1 month), interval 1 day) as mo_end;";
			 $oDB->query($vSQL);
			 $oDB->next_record();
			 $vStart=$oDB->f("mo_start");
			 $vEnd=$oDB->f("mo_end");
			 $vEndTgl=substr($vEnd,8,2);
			 $vTgl=substr($pDate,8,2);
			 $vTgl=(int) ($vTgl);
			 $vBln=substr($pDate,5,2);
			 $vThn=substr($pDate,0,4);
			 
			 if (( $vTgl >= 1) && ($vTgl) <= 15) {
			    $vAwal=$vThn."-".$vBln."-01";
				$vAkhir=$vThn."-".$vBln."-15";
			 }
			
			 if (($vTgl >= 16) && ($vTgl <= 31)) {
			    $vAwal=$vThn."-".$vBln."-16";
				$vAkhir=$vThn."-".$vBln."-$vEndTgl";
			 }
			
			 $vOut[0]=$vAwal;
			 $vOut[1]=$vAkhir;
			 return $vOut;
			 	
	  }


	  function dateDiff($interval,$dateTimeBegin,$dateTimeEnd) {
		//Parse about any English textual datetime
		//$dateTimeBegin, $dateTimeEnd
		
		$dateTimeBegin=strtotime($dateTimeBegin);
		if($dateTimeBegin === -1) {
		  return("..begin date Invalid");
		}
		
		$dateTimeEnd=strtotime($dateTimeEnd);
		if($dateTimeEnd === -1) {
		  return("..end date Invalid");
		}
		
		$dif=$dateTimeEnd - $dateTimeBegin;
		
		switch($interval) {
		  case "s"://seconds
			return($dif);
		
		  case "n"://minutes
			return(floor($dif/60)); //60s=1m
		
		  case "h"://hours
			return(floor($dif/3600)); //3600s=1h
		
		  case "d"://days
			return(floor($dif/86400)); //86400s=1d
		
		  case "ww"://Week
			return(floor($dif/604800)); //604800s=1week=1semana
		
		  case "m": //similar result "m" dateDiff Microsoft
			$monthBegin=(date("Y",$dateTimeBegin)*12)+
						date("n",$dateTimeBegin);
			$monthEnd=(date("Y",$dateTimeEnd)*12)+
					  date("n",$dateTimeEnd);
			$monthDiff=$monthEnd-$monthBegin;
			return($monthDiff);
		
		  case "yyyy": //similar result "yyyy" dateDiff Microsoft
			return(date("Y",$dateTimeEnd) - date("Y",$dateTimeBegin));
		
		  default:
			return(floor($dif/86400)); //86400s=1d
		}
		}
       //Tanggal sekarang yyyymmddhhmmss
      function getNowYMDTFlat() { 
		    return date('YmdHis');
	  }
      
	  function getWeekDate($year, $week, $start=true) {
			$from = date("Y-m-d", strtotime("{$year}-W{$week}-1")); 
			$to = date("Y-m-d", strtotime("{$year}-W{$week}-7"));   
		 
			if($start) {
				return $from;
			} else {
				return $to;
			}	
	  }
	  
	    function getFirstDay($pDate) {
		    return substr($pDate,0,4)."-".substr($pDate,5,2)."-01";
		}
	  //get Lastday
		function getLastday($pDate) {
		global $oMydate;
		   $month=$oMydate->getMonth($pDate);
		   $year=$oMydate->getYear($pDate);
		   if (empty($month)) {
			  $month = date('m');
		   }
		   if (empty($year)) {
			  $year = date('Y');
		   }
		   $result = strtotime("{$year}-{$month}-01");
		   $result = strtotime('-1 second', strtotime('+1 month', $result));
		   return date('Y-m-d', $result);
		}


  }// class phpdate
  
  class mysqldate {
     
     //Ambil Tahun dari tanggal yang dimasukkan      
	 function getYear($pMyDate) {
        global $oDB;		     
		$oDB->query("select year('$pMyDate') as myDate");	  
		$oDB->next_record();
		$vOut=$oDB->f("myDate");
		return $vOut;
     }

     //Ambil Bulan dari tanggal yang dimasukkan      
	 function getMonth($pMyDate) {
        global $oDB;		     
		$oDB->query("SELECT DATE_FORMAT( CURDATE(), '%m' ) as myDate");	  
		$oDB->next_record();
		$vOut=$oDB->f("myDate");
		return $vOut;
     }

     //Tambahkan tanggal
	 function dateAdd($pMyDate,$pInterval,$pUnit) {
        global $oDB;		     
		$oDB->query("select adddate('$pMyDate', interval $pInterval $pUnit) as myDate");	  
		$oDB->next_record();
		$vOut=$oDB->f("myDate");
		return $vOut;
     }

	 function dateSub($pMyDate,$pInterval,$pUnit) {
        global $oDB;		     
		$oDB->query("select DATE_SUB('$pMyDate', INTERVAL $pInterval $pUnit) as myDate");	  
		$oDB->next_record();
		$vOut=$oDB->f("myDate");
		return $vOut;
     }


     //Ambil Minggu dalam tahun dari tanggal yang dimasukkan      
	 function getWeek($pMyDate) {
        global $oDB;		     
		$oDB->query("select weekofyear('$pMyDate') as myDate");	  
		$oDB->next_record();
		$vOut=$oDB->f("myDate");
		return $vOut;
     }

     //Ambil Minggu sebelum dalam tahun dari tanggal yang dimasukkan      
	 function getPrevWeek($pMyDate) {
        global $oDB;		     
		$oDB->query("select weekofyear('$pMyDate') as myDate");	  
		$oDB->next_record();
		$vOut=$oDB->f("myDate");
		if ($vOut==52)
		   $vOut=1;
		else
		   $vOut-=1;    
		return $vOut;
     }

     //Ambil Tanggal dari tanggal yang dimasukkan      
	 function getDay($pMyDate) {
        global $oDB;		     
		$oDB->query("select day('$pMyDate') as myDate");	  
		$oDB->next_record();
		$vOut=$oDB->f("myDate");
		return $vOut;
     }



     //Set Kriteria tanggal    
	 function setCritDate($pField,$pMyDate) {
        global $oDB;		     
		$oDB->query("update tb_criteria set $pField='$pMyDate 23:59:59'");	  
     }

      //Set Kriteria tanggal   kemarin 
	 function setCritPrevDate($pField,$pDate) {
        global $oDB;		     
		$oDB->query("update tb_criteria set $pField=concat(date_format(date_sub('$pDate',interval 1 day),'%Y-%m-%d'),' 23:59:59')");	  
     }



  } //Class mysqldate
  
   $oMydate = new mysqldate;
   $oPhpdate = new phpdate; 
?>