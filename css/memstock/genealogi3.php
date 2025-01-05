<? 
		if ($_GET['op'] != '') 
           include_once("../framework/admin_headside.blade.php");
        else
           include_once("../framework/member_headside.blade.php") ;  
?>
<? include_once("../classes/networkclass.php")?>
<? include_once("../classes/memberclass.php")?>
<? include_once("../classes/komisiclass.php")?>
<?
 error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
  //$oSystem->doED("decrypt",'RCtuaXgrTnowZmtnKzl6Z2JXNXN4Zz09');
  $vUser=$_SESSION['LoginUser'];
  $vRefUser=$_GET['uMemberId'];
  $vRefer= $_SERVER['HTTP_REFERER'];
  if (preg_match("/aktif.php/i",$vRefer,$var))
     $vFirst='1';
  else $vFirst='0';   

   $oSystem->getPriv($vUser);
  
  $vSpy = md5('spy').md5($_GET['uMemberId']);
  if ($_GET['op'] == $vSpy)
     $_SESSION['sop']=$vSpy;
  	
  //echo $vUserChoosed;
  $vCrit=$_POST['tfCrit'];
  $vAction=$_POST['hAction'];
   
  if($vUserChoosed=="" && $vPriv!="administrator") 
     $vUserChoosed=$vUser;
  else	 
     $vUserChoosed=$oMember->getFirstID();
	 
  if ($_GET['uTop']!="")
  $vUserChoosed=$_GET['uTop']; 	 
  
 // if ($oSystem->getPriv($vRefUser)==-1)
 //    $vUserChoosed=$vRefUser;
  
  if ($oNetwork->isInNetwork($vUserChoosed,$vUser)==-1 && $vPriv != "administrator")
     $vUserChoosed=$vUser;

//  if($oNetwork->isInNetwork($vUserChoosed,$vUser)==-1) $vUserChoosed=$vUser;
  //$vUserChoosed=;

	
  if ($vAction=="cari") { 
     if( $oSystem->getPriv($vUser)=='administrator') {
		  if ($oNetwork->isInNetwork($vCrit,'UNIGTOP')=='1')
			 $vUserChoosed=$vCrit; 
		  else {
			 $oSystem->jsAlert("Downline tidak ada, atau tidak berada dalam jaringan $vUserChoosed, top node dikembalikan ke UNIGTOP!");	 
			 $oSystem->jsLocation("./genealogi2.php?op=38ef1f498a09bdeb60928a81c0f77bb4d350f62795e71a17bfaad674ffea965f&uMemberId=UNIGTOP");
		  }
     
	  } else {
	  
		  if ($oNetwork->isInNetwork($vCrit,$vUser)=='1')
			 $vUserChoosed=$vCrit; 
		  else
			 $oSystem->jsAlert("Downline tidak ada, atau tidak berada dalam jaringan Anda!");	 

	} 	 
	  
  }

?>
<script language="Javascript">
$(document).ready(function(){
      $('#caption').html('Genealogi');

    $('[data-toggle="tooltip"]').tooltip({tooltipClass:"ttclass", html: true}); 
    
    if ('<?= $_SESSION["sop"]?>' == '<?=$vSpy?>'  && '<?=$vFirst?>' == '1') {
       document.getElementById('tfCrit2').value='<?=$vRefUser?>';
       document.frmFilter.submit();
    }

      
});	
	
	
</script>

<style type="text/css">
.ttclass {
 opacity:1;
 background-color:#ddd;
 border:1px solid;
 border-radius:3px;
 max-width:250px;
 color:black;
}



</style>

<body class="sticky-header">
<?
//echo $_SERVER['HTTP_REFERER'];
?>
 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />
  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />

 <div class="right_col" role="main">
		<div><label><h3>Genealogy</h3></label></div> 

<table width="500"  border="0" align="center" cellpadding="0" cellspacing="0">
 <?
   			   $vUp=$_GET['uUp'];
			   if (strlen($vUp)>2) $vUserChoosed=$vUp;

			   $vName=$oMember->getMemberName($vUserChoosed);
			    $vUpline=$oNetwork->getUpline($vUserChoosed);
			   //if (strlen($vUpline)>2)
			    //  $vUserChoosed= 
			   
			?>
  <tr align="lefty" valign="top">
    <td style="width: 500px"><form id="frmFilter" name="frmFilter" method="post">
        <strong>Search Username </strong>
        <input name="tfCrit" type="text" class="inputborder" id="tfCrit2" value="<?=$vCrit?>" onBlur="this.value=this.value.toUpperCase()">
&nbsp;
  <input name="btnCari" type="submit" id="btnCari" value="Search">
  <input name="hAction" type="hidden" id="hAction" value="cari">
  <br>
  <br>
        </form></td>
  </tr>
  <? 
  //  $vDeep=$oRules->getRealMaxLevel(1);
  $vDeep = 10;
	for ($i=0;$i<$vDeep;$i++) {	
?>	
  <? } ?>
</table>
<div class="table-responsive">
<table width="1024" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="boxgenea" colspan="3" valign="top" bgcolor="#ffff99" ><div align="center"><a href="" class="linknodecortop" ><strong>Go Top</strong></a></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" valign="top" ><div align="center">
	<? if (strtoupper($vUserChoosed)!=$oMember->getFirstID() && $vUserChoosed != $vUser && $vUserChoosed!=$oMember->getFirstID()) { ?>
	<a href="">
	<img src="../images/triangleup.png" height="15" border="0"></a></div></td>
	
	<? } ?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3"  valign="top" bgcolor="#fff"  style="">
     <div align="center" style="border:1px solid;border-radius:4px">
    <div align="center">
      <?
       $vPaket=$oMember->getPaket($vUserChoosed);
    ?>
      
      <?
			   $vSex=$oMember->getMemField('fsex',$vUserChoosed);

			   if ($vSex=='M') {
			      if ($oMember->getPaketID($vUserChoosed) == 'S')
				     $vMemIcon='../images/geneaim.png';
				  else if ($oMember->getPaketID($vUserChoosed) == 'G') 	 
				     $vMemIcon='../images/geneaim.png';
				  else if ($oMember->getPaketID($vUserChoosed) == 'P') 	 
				     $vMemIcon='../images/geneaim.png';

					 
			   } else {	  
			      if ($oMember->getPaketID($vUserChoosed) == 'S')
				     $vMemIcon='../images/geneaif.png';
				  else if ($oMember->getPaketID($vUserChoosed) == 'G') 	 
				     $vMemIcon='../images/geneaif.png';
				  else if ($oMember->getPaketID($vUserChoosed) == 'P') 	 
				     $vMemIcon='../images/geneaif.png';

			   }
			   
			   $vRegular=$oNetwork->getDownlinePos($vUserChoosed);   
			   
			   /*$vOmzetPriv=$oKomisi->getOmzetROAllMember($vUserChoosed);
			   $vOmzetPriv=$oKomisi->getOmzetROMonthMember($vUserChoosed,date('m'),date('Y'));
			   $vOmzetPriv+=$oKomisi->getOmzetROMonthMemberWallet($vUserChoosed,date('m'),date('Y'));
			   
			 //  $vOmzetDown=$oKomisi->getOmzetROWholeMemberMonth($vUserChoosed,date('m'),date('Y'));
			   $vOmzetDownL=$oKomisi->getOmzetROWholeMemberMonth($vRegular['L'],date('m'),date('Y'));
			   $vOmzetDownR=$oKomisi->getOmzetROWholeMemberMonth($vRegular['R'],date('m'),date('Y'));
			   $vOmzetDownLW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular['L'],date('m'),date('Y'));
			   $vOmzetDownRW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular['R'],date('m'),date('Y'));
			   
			   
			   $vOmzetDownLF=number_format($vOmzetDownL+$vOmzetDownLW,0,",",".");
			   $vOmzetDownRF=number_format($vOmzetDownR+$vOmzetDownRW,0,",",".");
			   
			   
			   
			   $vOmzetGroup=$vOmzetPriv + 	$vOmzetDown;
			   */
			  // $vPoint=$oKomisi->getPoint($vUserChoosed,'2016-04-01',date("Y-m-d"));
			   $vDownL=$oNetwork->getDownlineCountLR($vUserChoosed,'L');
			   $vDownPrem=$oNetwork->getDownlineCountByPrem($vUserChoosed);
			   $vNodeL=$oNetwork->getDownLR($vUserChoosed,'L');
			   $vNodeR=$oNetwork->getDownLR($vUserChoosed,'R');
			   $vDownPremL=$oNetwork->getDownlineCountByPrem($vNodeL);
			   $vDownPremR=$oNetwork->getDownlineCountByPrem($vNodeR);
			   if ($oMember->getPaketID($vNodeL) =='P') $vDownPremL +=1;
			   if ($oMember->getPaketID($vNodeR) =='P') $vDownPremR +=1;
			      
			   
			   $vDownR=$oNetwork->getDownlineCountLR($vUserChoosed,'R');
			   $vCFReal=$oNetwork->getCFDate($vUserChoosed,date('Y-m-d'));
			   /*
			   $vCFBeforeL=$oKomisi->getCFPosRT($vUserChoosed,'L',date('Y-m-d'));
			   $vCFBeforeR=$oKomisi->getCFPosRT($vUserChoosed,'R',date('Y-m-d'));
				*/
			  
			   
			   $vToolTip="Nama : ".$oMember->getMemberName($vUserChoosed);
			   $vToolTip.="<br>Downline Group L : ".number_format($vDownL,0,",",".");
			   $vToolTip.="<br>"."Downline Group R : ".number_format($vDownR,0,",",".");
			  // $vToolTip.="<br>"."Downline Premium (L|R): ($vDownPremL | $vDownPremR) ";
			   $vToolTip.="<br> Activation Date : ".$oPhpdate->YMD2DMY($oMember->getActivationDate($vUserChoosed));
			   $vToolTip.="<br> Paket : ".$oProduct->getPackName($oMember->getMemField('fpaket',$vUserChoosed));
			   //$vToolTip.="<br> LRTCF : ".($vCFReal['L'] + $vCFBeforeL).", RRTCF : ".($vCFReal['R'] + $vCFBeforeR) ;
			   //$vToolTip.="<br> Personal RO : ".number_format($vOmzetPriv,0,",",".");
			   //$vToolTip.="<br> Omzet  RO (L) : $vOmzetDownLF <br> Omzet  RO (R) : $vOmzetDownRF " ;
			   
			   //$vToolTip.="<br> Group Omzet : ".number_format($vOmzetGroup,0,",",".");
			   
 			 //  echo '<strong data-toggle="tooltip" title="'.$vToolTip.'">'.$vUserChoosed.'</strong>';

			   		  //print_r($vRegular);
			  
			 /* for ($j=1;$j<count($vDownline)+1;$j++) {
			       if ($j==1) $ji="L";if ($j==2) $ji="R";
				  // echo $ji;
				   $vRegular[$ji]=$vDownline[$j];   
				  // print_r($vRegular);
			  } 
			//  while(@list($vKey,$vVal)=@each($vDownline))
			//       $vRegular[$vKey]=$vDownline[$vKey];
			       */
 
			?>
      
      <div data-toggle="tooltip" title="<?=$vToolTip?>">
        
        <img height="110"  src="<?=$vMemIcon?>"  > 
        </div>
      </div>     
        <span  style="text-align:center;">
        </span><br>
       
        <span  >
          <?=$vUserChoosed?><br>
          <?=trim($oMember->getMemberName($vUserChoosed))?>
          <? 
		  $vRegular1="";
		  $vRegular1=$oNetwork->getDownlinePos($vRegular["L"]); 
		  $vRegular3=$oNetwork->getDownlinePos($vRegular["R"]);
		  // print_r($vRegular1);

	/*	//   
			  for ($j=1;$j<count($vDownline1)+1;$j++) {
				    if ($j==1) $ji="L";if ($j==2) $ji="R";
				   $vRegular1[$ji]=$vDownline1[$j];   
			  }  
			 // print_r($vDownline1);
		  //while (@list($vKey,$vVal)=@each($vDownline1))
		    //     $vRegular1[$vKey]=$vDownline1[$vKey];   
	  
*/
		?>
          
          <?
		    //aslinya di kiri
			$vJmlDown=$oNetwork->getDownlineCount($vRegular["L"]);
			$vJmlDown1=$vJmlDown;
			$vIsArr=$vRegular["L"];
			if ($vJmlDown > 0) 
			    $vJmlDown+1;
			else if (($vJmlDown == 0) && ($vIsArr != ""))
				//echo 1;
				;
		    else if (($vJmlDown == 0) && ($vIsArr==""))
			    ;
			 //   echo 0;		
		  ?>
          
          
          <?
		  //Aslinya di kanan
		    $vJmlDown=$oNetwork->getDownlineCount($vRegular["R"]);
			$vJmlDown3=$vJmlDown;
			$vIsArr=$vRegular["R"];
			if ($vJmlDown > 0) 
			   // echo  $vJmlDown+1;
			   ;
			else if (($vJmlDown == 0) && ($vIsArr != ""))
				//echo 1;
				;
		    else if (($vJmlDown == 0) && ($vIsArr==""))
			    // echo 0;
			    ;
		  ?>
        </span>
        
      </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="10"><div align="right"><img src="../images/genmirleft.png" height="52"></div></td>
    <td>&nbsp;</td>
    <td colspan="10"><div align="left"><img src="../images/genmirright.png" height="52"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3"  valign="top" bgcolor="#fff"  style="">
     <div align="center" style="border:1px solid;border-radius:4px">
    <div align="center">
      <?
       $vPaket=$oMember->getPaket($vUserChoosed);
    ?>
      
      <?
			   $vSex=$oMember->getMemField('fsex',$vUserChoosed);

			   if ($vSex=='M') {
			      if ($oMember->getPaketID($vUserChoosed) == 'S')
				     $vMemIcon='../images/geneaim.png';
				  else if ($oMember->getPaketID($vUserChoosed) == 'G') 	 
				     $vMemIcon='../images/geneaim.png';
				  else if ($oMember->getPaketID($vUserChoosed) == 'P') 	 
				     $vMemIcon='../images/geneaim.png';

					 
			   } else {	  
			      if ($oMember->getPaketID($vUserChoosed) == 'S')
				     $vMemIcon='../images/geneaif.png';
				  else if ($oMember->getPaketID($vUserChoosed) == 'G') 	 
				     $vMemIcon='../images/geneaif.png';
				  else if ($oMember->getPaketID($vUserChoosed) == 'P') 	 
				     $vMemIcon='../images/geneaif.png';

			   }
			   
			   $vRegular=$oNetwork->getDownlinePos($vUserChoosed);   
			   
			   /*$vOmzetPriv=$oKomisi->getOmzetROAllMember($vUserChoosed);
			   $vOmzetPriv=$oKomisi->getOmzetROMonthMember($vUserChoosed,date('m'),date('Y'));
			   $vOmzetPriv+=$oKomisi->getOmzetROMonthMemberWallet($vUserChoosed,date('m'),date('Y'));
			   
			 //  $vOmzetDown=$oKomisi->getOmzetROWholeMemberMonth($vUserChoosed,date('m'),date('Y'));
			   $vOmzetDownL=$oKomisi->getOmzetROWholeMemberMonth($vRegular['L'],date('m'),date('Y'));
			   $vOmzetDownR=$oKomisi->getOmzetROWholeMemberMonth($vRegular['R'],date('m'),date('Y'));
			   $vOmzetDownLW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular['L'],date('m'),date('Y'));
			   $vOmzetDownRW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular['R'],date('m'),date('Y'));
			   
			   
			   $vOmzetDownLF=number_format($vOmzetDownL+$vOmzetDownLW,0,",",".");
			   $vOmzetDownRF=number_format($vOmzetDownR+$vOmzetDownRW,0,",",".");
			   
			   
			   
			   $vOmzetGroup=$vOmzetPriv + 	$vOmzetDown;
			   */
			  // $vPoint=$oKomisi->getPoint($vUserChoosed,'2016-04-01',date("Y-m-d"));
			   $vDownL=$oNetwork->getDownlineCountLR($vUserChoosed,'L');
			   $vDownPrem=$oNetwork->getDownlineCountByPrem($vUserChoosed);
			   $vNodeL=$oNetwork->getDownLR($vUserChoosed,'L');
			   $vNodeR=$oNetwork->getDownLR($vUserChoosed,'R');
			   $vDownPremL=$oNetwork->getDownlineCountByPrem($vNodeL);
			   $vDownPremR=$oNetwork->getDownlineCountByPrem($vNodeR);
			   if ($oMember->getPaketID($vNodeL) =='P') $vDownPremL +=1;
			   if ($oMember->getPaketID($vNodeR) =='P') $vDownPremR +=1;
			      
			   
			   $vDownR=$oNetwork->getDownlineCountLR($vUserChoosed,'R');
			   $vCFReal=$oNetwork->getCFDate($vUserChoosed,date('Y-m-d'));
			   /*
			   $vCFBeforeL=$oKomisi->getCFPosRT($vUserChoosed,'L',date('Y-m-d'));
			   $vCFBeforeR=$oKomisi->getCFPosRT($vUserChoosed,'R',date('Y-m-d'));
				*/
			  
			   
			   $vToolTip="Nama : ".$oMember->getMemberName($vUserChoosed);
			   $vToolTip.="<br>Downline Group L : ".number_format($vDownL,0,",",".");
			   $vToolTip.="<br>"."Downline Group R : ".number_format($vDownR,0,",",".");
			  // $vToolTip.="<br>"."Downline Premium (L|R): ($vDownPremL | $vDownPremR) ";
			   $vToolTip.="<br> Activation Date : ".$oPhpdate->YMD2DMY($oMember->getActivationDate($vUserChoosed));
			   $vToolTip.="<br> Paket : ".$oProduct->getPackName($oMember->getMemField('fpaket',$vUserChoosed));
			   //$vToolTip.="<br> LRTCF : ".($vCFReal['L'] + $vCFBeforeL).", RRTCF : ".($vCFReal['R'] + $vCFBeforeR) ;
			   //$vToolTip.="<br> Personal RO : ".number_format($vOmzetPriv,0,",",".");
			   //$vToolTip.="<br> Omzet  RO (L) : $vOmzetDownLF <br> Omzet  RO (R) : $vOmzetDownRF " ;
			   
			   //$vToolTip.="<br> Group Omzet : ".number_format($vOmzetGroup,0,",",".");
			   
 			 //  echo '<strong data-toggle="tooltip" title="'.$vToolTip.'">'.$vUserChoosed.'</strong>';

			   		  //print_r($vRegular);
			  
			 /* for ($j=1;$j<count($vDownline)+1;$j++) {
			       if ($j==1) $ji="L";if ($j==2) $ji="R";
				  // echo $ji;
				   $vRegular[$ji]=$vDownline[$j];   
				  // print_r($vRegular);
			  } 
			//  while(@list($vKey,$vVal)=@each($vDownline))
			//       $vRegular[$vKey]=$vDownline[$vKey];
			       */
 
			?>
      
      <div data-toggle="tooltip" title="<?=$vToolTip?>">
        
        <img height="110"  src="<?=$vMemIcon?>"  > 
        </div>
      </div>     
        <span  style="text-align:center;">
        </span><br>
       
        <span  >
          <?=$vUserChoosed?><br>
          <?=trim($oMember->getMemberName($vUserChoosed))?>
          <? 
		  $vRegular1="";
		  $vRegular1=$oNetwork->getDownlinePos($vRegular["L"]); 
		  $vRegular3=$oNetwork->getDownlinePos($vRegular["R"]);
		  // print_r($vRegular1);

	/*	//   
			  for ($j=1;$j<count($vDownline1)+1;$j++) {
				    if ($j==1) $ji="L";if ($j==2) $ji="R";
				   $vRegular1[$ji]=$vDownline1[$j];   
			  }  
			 // print_r($vDownline1);
		  //while (@list($vKey,$vVal)=@each($vDownline1))
		    //     $vRegular1[$vKey]=$vDownline1[$vKey];   
	  
*/
		?>
          
          <?
		    //aslinya di kiri
			$vJmlDown=$oNetwork->getDownlineCount($vRegular["L"]);
			$vJmlDown1=$vJmlDown;
			$vIsArr=$vRegular["L"];
			if ($vJmlDown > 0) 
			    $vJmlDown+1;
			else if (($vJmlDown == 0) && ($vIsArr != ""))
				//echo 1;
				;
		    else if (($vJmlDown == 0) && ($vIsArr==""))
			    ;
			 //   echo 0;		
		  ?>
          
          
          <?
		  //Aslinya di kanan
		    $vJmlDown=$oNetwork->getDownlineCount($vRegular["R"]);
			$vJmlDown3=$vJmlDown;
			$vIsArr=$vRegular["R"];
			if ($vJmlDown > 0) 
			   // echo  $vJmlDown+1;
			   ;
			else if (($vJmlDown == 0) && ($vIsArr != ""))
				//echo 1;
				;
		    else if (($vJmlDown == 0) && ($vIsArr==""))
			    // echo 0;
			    ;
		  ?>
        </span>
        
      </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3"  valign="top" bgcolor="#fff"  style="">
     <div align="center" style="border:1px solid;border-radius:4px">
    <div align="center">
      <?
       $vPaket=$oMember->getPaket($vUserChoosed);
    ?>
      
      <?
			   $vSex=$oMember->getMemField('fsex',$vUserChoosed);

			   if ($vSex=='M') {
			      if ($oMember->getPaketID($vUserChoosed) == 'S')
				     $vMemIcon='../images/geneaim.png';
				  else if ($oMember->getPaketID($vUserChoosed) == 'G') 	 
				     $vMemIcon='../images/geneaim.png';
				  else if ($oMember->getPaketID($vUserChoosed) == 'P') 	 
				     $vMemIcon='../images/geneaim.png';

					 
			   } else {	  
			      if ($oMember->getPaketID($vUserChoosed) == 'S')
				     $vMemIcon='../images/geneaif.png';
				  else if ($oMember->getPaketID($vUserChoosed) == 'G') 	 
				     $vMemIcon='../images/geneaif.png';
				  else if ($oMember->getPaketID($vUserChoosed) == 'P') 	 
				     $vMemIcon='../images/geneaif.png';

			   }
			   
			   $vRegular=$oNetwork->getDownlinePos($vUserChoosed);   
			   
			   /*$vOmzetPriv=$oKomisi->getOmzetROAllMember($vUserChoosed);
			   $vOmzetPriv=$oKomisi->getOmzetROMonthMember($vUserChoosed,date('m'),date('Y'));
			   $vOmzetPriv+=$oKomisi->getOmzetROMonthMemberWallet($vUserChoosed,date('m'),date('Y'));
			   
			 //  $vOmzetDown=$oKomisi->getOmzetROWholeMemberMonth($vUserChoosed,date('m'),date('Y'));
			   $vOmzetDownL=$oKomisi->getOmzetROWholeMemberMonth($vRegular['L'],date('m'),date('Y'));
			   $vOmzetDownR=$oKomisi->getOmzetROWholeMemberMonth($vRegular['R'],date('m'),date('Y'));
			   $vOmzetDownLW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular['L'],date('m'),date('Y'));
			   $vOmzetDownRW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular['R'],date('m'),date('Y'));
			   
			   
			   $vOmzetDownLF=number_format($vOmzetDownL+$vOmzetDownLW,0,",",".");
			   $vOmzetDownRF=number_format($vOmzetDownR+$vOmzetDownRW,0,",",".");
			   
			   
			   
			   $vOmzetGroup=$vOmzetPriv + 	$vOmzetDown;
			   */
			  // $vPoint=$oKomisi->getPoint($vUserChoosed,'2016-04-01',date("Y-m-d"));
			   $vDownL=$oNetwork->getDownlineCountLR($vUserChoosed,'L');
			   $vDownPrem=$oNetwork->getDownlineCountByPrem($vUserChoosed);
			   $vNodeL=$oNetwork->getDownLR($vUserChoosed,'L');
			   $vNodeR=$oNetwork->getDownLR($vUserChoosed,'R');
			   $vDownPremL=$oNetwork->getDownlineCountByPrem($vNodeL);
			   $vDownPremR=$oNetwork->getDownlineCountByPrem($vNodeR);
			   if ($oMember->getPaketID($vNodeL) =='P') $vDownPremL +=1;
			   if ($oMember->getPaketID($vNodeR) =='P') $vDownPremR +=1;
			      
			   
			   $vDownR=$oNetwork->getDownlineCountLR($vUserChoosed,'R');
			   $vCFReal=$oNetwork->getCFDate($vUserChoosed,date('Y-m-d'));
			   /*
			   $vCFBeforeL=$oKomisi->getCFPosRT($vUserChoosed,'L',date('Y-m-d'));
			   $vCFBeforeR=$oKomisi->getCFPosRT($vUserChoosed,'R',date('Y-m-d'));
				*/
			  
			   
			   $vToolTip="Nama : ".$oMember->getMemberName($vUserChoosed);
			   $vToolTip.="<br>Downline Group L : ".number_format($vDownL,0,",",".");
			   $vToolTip.="<br>"."Downline Group R : ".number_format($vDownR,0,",",".");
			  // $vToolTip.="<br>"."Downline Premium (L|R): ($vDownPremL | $vDownPremR) ";
			   $vToolTip.="<br> Activation Date : ".$oPhpdate->YMD2DMY($oMember->getActivationDate($vUserChoosed));
			   $vToolTip.="<br> Paket : ".$oProduct->getPackName($oMember->getMemField('fpaket',$vUserChoosed));
			   //$vToolTip.="<br> LRTCF : ".($vCFReal['L'] + $vCFBeforeL).", RRTCF : ".($vCFReal['R'] + $vCFBeforeR) ;
			   //$vToolTip.="<br> Personal RO : ".number_format($vOmzetPriv,0,",",".");
			   //$vToolTip.="<br> Omzet  RO (L) : $vOmzetDownLF <br> Omzet  RO (R) : $vOmzetDownRF " ;
			   
			   //$vToolTip.="<br> Group Omzet : ".number_format($vOmzetGroup,0,",",".");
			   
 			 //  echo '<strong data-toggle="tooltip" title="'.$vToolTip.'">'.$vUserChoosed.'</strong>';

			   		  //print_r($vRegular);
			  
			 /* for ($j=1;$j<count($vDownline)+1;$j++) {
			       if ($j==1) $ji="L";if ($j==2) $ji="R";
				  // echo $ji;
				   $vRegular[$ji]=$vDownline[$j];   
				  // print_r($vRegular);
			  } 
			//  while(@list($vKey,$vVal)=@each($vDownline))
			//       $vRegular[$vKey]=$vDownline[$vKey];
			       */
 
			?>
      
      <div data-toggle="tooltip" title="<?=$vToolTip?>">
        
        <img height="110"  src="<?=$vMemIcon?>"  > 
        </div>
      </div>     
        <span  style="text-align:center;">
        </span><br>
       
        <span  >
          <?=$vUserChoosed?><br>
          <?=trim($oMember->getMemberName($vUserChoosed))?>
          <? 
		  $vRegular1="";
		  $vRegular1=$oNetwork->getDownlinePos($vRegular["L"]); 
		  $vRegular3=$oNetwork->getDownlinePos($vRegular["R"]);
		  // print_r($vRegular1);

	/*	//   
			  for ($j=1;$j<count($vDownline1)+1;$j++) {
				    if ($j==1) $ji="L";if ($j==2) $ji="R";
				   $vRegular1[$ji]=$vDownline1[$j];   
			  }  
			 // print_r($vDownline1);
		  //while (@list($vKey,$vVal)=@each($vDownline1))
		    //     $vRegular1[$vKey]=$vDownline1[$vKey];   
	  
*/
		?>
          
          <?
		    //aslinya di kiri
			$vJmlDown=$oNetwork->getDownlineCount($vRegular["L"]);
			$vJmlDown1=$vJmlDown;
			$vIsArr=$vRegular["L"];
			if ($vJmlDown > 0) 
			    $vJmlDown+1;
			else if (($vJmlDown == 0) && ($vIsArr != ""))
				//echo 1;
				;
		    else if (($vJmlDown == 0) && ($vIsArr==""))
			    ;
			 //   echo 0;		
		  ?>
          
          
          <?
		  //Aslinya di kanan
		    $vJmlDown=$oNetwork->getDownlineCount($vRegular["R"]);
			$vJmlDown3=$vJmlDown;
			$vIsArr=$vRegular["R"];
			if ($vJmlDown > 0) 
			   // echo  $vJmlDown+1;
			   ;
			else if (($vJmlDown == 0) && ($vIsArr != ""))
				//echo 1;
				;
		    else if (($vJmlDown == 0) && ($vIsArr==""))
			    // echo 0;
			    ;
		  ?>
        </span>
        
      </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="height: 50px"></td>
    <td style="height: 50px"></td>
    <td colspan="5" style="height: 50px"><div align="right"><img src="../images/genmirleft.png" height="52"></div></td>
    <td style="height: 50px"><div align="center"></div></td>
    <td colspan="5" style="height: 50px"><div align="left"><img src="../images/genmirright.png" height="52"></div></td>
    <td style="height: 50px"></td>
    <td style="height: 50px"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="height: 50px"></td>
    <td colspan="5" style="height: 50px"><div align="right"><img src="../images/genmirleft.png" height="52"></div></td>
    <td style="height: 50px"><div align="center"></div></td>
    <td colspan="5" style="height: 50px"><div align="left"><img src="../images/genmirright.png" height="52"></div></td>
    <td style="height: 50px"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="height: 68px"></td>
<?
     $vPoint=$oKomisi->getPoint($vRegular["L"],'2016-04-01',date('Y-m-d'));
     $vTitle="Point L : ".$vPoint['L'];
     $vTitle.= "\n";
     $vTitle.="Point R : ".$vPoint['R'];
     $vTitle.= "\n";

      $vTitle.="Activation : ".$oMember->getActivationDate($vRegular["L"]);

  ?>
    
    <td colspan="3" valign="top" bgcolor="#fff"    >
	<? if ($vJmlDown1 > 0) { ?>
	<a href="" class="linknodecor" >
	<? } ?>
	<!-- <div align="center"  style="height:10em;border-bottom:none;border-left:1px solid gray;border-right:1px solid gray;border-top:1px solid gray;border-bottom:1px solid gray;height:170px" data-toggle="tooltip" title="<?=$vToolTip?>">-->
    <div align="center"   style="border:1px solid;border-radius:4px;height:170px" >
    
        
        <strong >
        <?
        
 			if ($vRegular["L"] !="") {
		    //echo $oMember->getMemberName($vRegular["L"]);
		   // echo "::OmzetPriv:".$oKomisi->getOmzetROAllMember($vRegular["L"]);
			  /* $vOmzetPriv=$oKomisi->getOmzetROMonthMember($vRegular["L"],date('m'),date('Y'));
			   $vOmzetPriv+=$oKomisi->getOmzetROMonthMemberWallet($vRegular["L"],date('m'),date('Y'));
			 //  $vOmzetDown=$oKomisi->getOmzetROWholeMember($vRegular["L"]);
			  // $vOmzetGroup=$vOmzetPriv + 	$vOmzetDown;

			   $vOmzetDownL=$oKomisi->getOmzetROWholeMemberMonth($vRegular1['L'],date('m'),date('Y'));
			   $vOmzetDownR=$oKomisi->getOmzetROWholeMemberMonth($vRegular1['R'],date('m'),date('Y'));
			   $vOmzetDownLW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular1['L'],date('m'),date('Y'));
			   $vOmzetDownRW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular1['R'],date('m'),date('Y'));

			   $vOmzetDownLF=number_format($vOmzetDownL+$vOmzetDownLW,0,",",".");
			   $vOmzetDownRF=number_format($vOmzetDownR+$vOmzetDownRW,0,",",".");
			   */

			   $vDownL=$oNetwork->getDownlineCountLR($vRegular["L"],'L');
			   $vDownR=$oNetwork->getDownlineCountLR($vRegular["L"],'R');
			   $vDownPrem=$oNetwork->getDownlineCountByPrem($vRegular["L"]);

			   $vNodeL=$oNetwork->getDownLR($vRegular["L"],'L');
			   $vNodeR=$oNetwork->getDownLR($vRegular["L"],'R');
			   $vDownPremL=$oNetwork->getDownlineCountByPrem($vNodeL);
			   $vDownPremR=$oNetwork->getDownlineCountByPrem($vNodeR);
			   if ($oMember->getPaketID($vNodeL) =='P') $vDownPremL +=1;
			   if ($oMember->getPaketID($vNodeR) =='P') $vDownPremR +=1;
			   
			   $vCFReal=$oNetwork->getCFDate($vRegular["L"],date('Y-m-d'));
			  // $vCFBeforeL=$oKomisi->getCFPosRT($vRegular["L"],'L',date('Y-m-d'));
			   //$vCFBeforeR=$oKomisi->getCFPosRT($vRegular["L"],'R',date('Y-m-d'));
			   
			   
			   
			   
			   $vToolTip="Nama : ".$oMember->getMemberName($vRegular["L"]);
			   $vToolTip.="<br>Downline Group L : ".$vDownL;
			   $vToolTip.="<br> Downline Group R : ".$vDownR;
			   //$vToolTip.="<br>"."Downline Premium (L|R): ($vDownPremL | $vDownPremR)";
			   $vToolTip.="<br> Activation Date : ".$oPhpdate->YMD2DMY($oMember->getActivationDate($vRegular["L"]));
			   $vToolTip.="<br> Paket : ".$oProduct->getPackName($oMember->getMemField('fpaket',$vRegular["L"]));
			   //$vToolTip.="<br> LRTCF : ".($vCFReal['L'] + $vCFBeforeL).", RRTCF : ".($vCFReal['R'] + $vCFBeforeR) ;
			   //$vToolTip.="<br> Personal RO : ".number_format($vOmzetPriv,0,",",".");
			   $vToolTip.="<br> Omzet RO (L) : $vOmzetDownLF <br> Omzet RO (R) : $vOmzetDownRF " ;
		    echo '<div data-toggle="tooltip" title="'.$vToolTip.'">';
      
 

	     $vPaket=($oMember->getPaket($vRegular["L"]));


			   $vSex=$oMember->getMemField('fsex',$vRegular["L"]);
			   if ($vSex=='M') {
			      if ($oMember->getPaketID($vRegular["L"]) == 'S')
				     $vMemIcon='../images/geneaim.png';
				  else if ($oMember->getPaketID($vRegular["L"]) == 'G') 	 
				     $vMemIcon='../images/geneaim.png';
				  else if ($oMember->getPaketID($vRegular["L"]) == 'P') 	 
				     $vMemIcon='../images/geneaim.png';		 
			   } else {	  
			      if ($oMember->getPaketID($vRegular["L"]) == 'S')
				     $vMemIcon='../images/geneaif.png';
				  else if ($oMember->getPaketID($vRegular["L"]) == 'G') 	 
				     $vMemIcon='../images/geneaif.png';
				  else if ($oMember->getPaketID($vRegular["L"]) == 'P') 	 
				     $vMemIcon='../images/geneaif.png';

			   }
			   
			   	    // echo '<img height="100" data-toggle="tooltip" title="'.$vToolTip.'" src="../images/geneicon.png">';
	     echo '<img height="110" data-toggle="tooltip"  src="'.$vMemIcon.'">';
	     echo $vRegular["L"];
	      

	  } else { 
	     echo "<img src='../images/nomem.png' height='110'>";	       
		 if ($vUserChoosed != "")
		 	echo '<a href="../memstock/registerst.php?uMemberId='.$vUserChoosed.'&pos=L">Daftarkan di sini</a> <br><br>';
 
		 
	  }
	   
	?></strong></div>        
        
<?
			if ($vRegular["L"] !="") 
		  echo  substr($oMember->getMemberName($vRegular["L"]),0,9)."...";
		   // echo "::OmzetPriv:".$oKomisi->getOmzetROAllMember($vRegular["L"]);
			  /* $vOmzetPriv=$oKomisi->getOmzetROAllMember($vRegular["L"]);
			   $vOmzetDown=$oKomisi->getOmzetROWholeMember($vRegular["L"]);
			   $vOmzetGroup=$vOmzetPriv + 	$vOmzetDown;
			   */
			   $vDownL=$oNetwork->getDownlineCountLR($vRegular["L"],'L');
			   $vDownR=$oNetwork->getDownlineCountLR($vRegular["L"],'R');

			   
			  // $vToolTip="Personal RO : ".number_format($vOmzetPriv,0,",",".");
			   //$vToolTip.="<br>"."Group Omzet : ".number_format($vOmzetGroup,0,",",".");
			 //  $vToolTip.="<br>"."Downline Group L : ".number_format($vDownL,0,",",".");
			 //  $vToolTip.="<br>"."Downline Group R : ".number_format($vDownR,0,",",".");


		  //  echo '<strong data-toggle="tooltip" title="'.$vToolTip.'">'.$vRegular["L"].'</strong>';


         ?>


    <? if ($vJmlDown1>0) { ?></a><? } ?></a>
    <div data-toggle="tooltip" title="<?=$vToolTip?>" style="cursor:pointer" onClick="document.location.href='?op=<?=$_SESSION['sop']?>&uTop=<?=$vRegular["L"]?>&uMemberId=<?=$vRefUser?>'">&nbsp;
    </div>
    </td>
    <td style="height: 68px"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="height: 68px"></td>
<?
    /* $vPoint=$oKomisi->getPoint($vRegular["R"],'2016-04-01',date('Y-m-d'));
     $vTitle="Point L : ".$vPoint['L'];
     $vTitle.= "\n";
     $vTitle.="Point R : ".$vPoint['R'];
     $vTitle.= "\n";

      $vTitle.="Activation : ".$oMember->getActivationDate($vRegular["R"]);*/

			   //$vOmzetPriv=$oKomisi->getOmzetROAllMember($vRegular["R"]);
			  /* $vOmzetPriv=$oKomisi->getOmzetROMonthMember($vRegular["R"],date('m'),date('Y'));
			   $vOmzetPriv+=$oKomisi->getOmzetROMonthMemberWallet($vRegular["R"],date('m'),date('Y'));

			   $vOmzetDownL=$oKomisi->getOmzetROWholeMemberMonth($vRegular3['L'],date('m'),date('Y'));
			   $vOmzetDownR=$oKomisi->getOmzetROWholeMemberMonth($vRegular3['R'],date('m'),date('Y'));
			   $vOmzetDownLW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular3['L'],date('m'),date('Y'));
			   $vOmzetDownRW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular3['R'],date('m'),date('Y'));

			   $vOmzetDownLF=number_format($vOmzetDownL+$vOmzetDownLW,0,",",".");
			   $vOmzetDownRF=number_format($vOmzetDownR+$vOmzetDownRW,0,",",".");
			   
			//   $vOmzetDown=$oKomisi->getOmzetROWholeMember($vRegular["R"]);
		//	   $vOmzetGroup=$vOmzetPriv + 	$vOmzetDown;
			   */
			   $vDownL=$oNetwork->getDownlineCountLR($vRegular["R"],'L');
			   $vDownR=$oNetwork->getDownlineCountLR($vRegular["R"],'R');
			   $vDownPrem=$oNetwork->getDownlineCountByPrem($vRegular["R"]);

			   $vNodeL=$oNetwork->getDownLR($vRegular["R"],'L');
			   $vNodeR=$oNetwork->getDownLR($vRegular["R"],'R');
			   $vDownPremL=$oNetwork->getDownlineCountByPrem($vNodeL);
			   $vDownPremR=$oNetwork->getDownlineCountByPrem($vNodeR);
			   if ($oMember->getPaketID($vNodeL) =='P') $vDownPremL +=1;
			   if ($oMember->getPaketID($vNodeR) =='P') $vDownPremR +=1;
			   
			    $vCFReal=$oNetwork->getCFDate($vRegular["R"],date('Y-m-d'));
			//   $vCFBeforeL=$oKomisi->getCFPosRT($vRegular["R"],'L',date('Y-m-d'));
			 //  $vCFBeforeR=$oKomisi->getCFPosRT($vRegular["R"],'R',date('Y-m-d'));
				
				
			  
			  
			   $vToolTip="Nama : ".$oMember->getMemberName($vRegular["R"]);
			   $vToolTip.="<br>Downline Group L : ".$vDownL;
			   $vToolTip.="<br> Downline Group R : ".$vDownR;
			   //$vToolTip.="<br>"."Downline Premium (L|R): ($vDownPremL | $vDownPremR) ";
			   $vToolTip.="<br> Activation Date : ".$oPhpdate->YMD2DMY($oMember->getActivationDate($vRegular["R"]));
			   $vToolTip.="<br> Paket : ".$oProduct->getPackName($oMember->getMemField('fpaket',$vRegular["R"]));
			   //$vToolTip.="<br> LRTCF : ".($vCFReal['L'] + $vCFBeforeL).", RRTCF : ".($vCFReal['R'] + $vCFBeforeR) ;
			  // $vToolTip.="<br> Personal RO : ".number_format($vOmzetPriv,0,",",".");
			  // $vToolTip.="<br> Omzet RO (L) : $vOmzetDownLF <br> Omzet RO (R) : $vOmzetDownRF " ;

      

  ?>
    
    <td colspan="3" valign="top" bgcolor="#fff" class="boxgenea" style="height: 110px" title="">
	 <? if ($vJmlDown3 > 0) { ?>
	 <a    href="" class="linknodecor">
	 	 <? } ?>
	<div align="center"   style="border:1px solid;border-radius:4px;height:170px"  <? if ($vJmlDown3 > 0) echo 'data-toggle="tooltip" title="'.$vToolTip.'"';?>>
   
    <strong>
  
   
	
	    <?
  
  
        
  			   $vSex=$oMember->getMemField('fsex',$vRegular["R"]);
			   if ($vSex=='M') {
			      if ($oMember->getPaketID($vRegular["R"]) == 'S')
				     $vMemIcon='../images/geneaim.png';
				  else if ($oMember->getPaketID($vRegular["R"]) == 'G') 	 
				     $vMemIcon='../images/geneaim.png';
				  else if ($oMember->getPaketID($vRegular["R"]) == 'P') 	 
				     $vMemIcon='../images/geneaim.png';		 
			   } else {	  
			      if ($oMember->getPaketID($vRegular["R"]) == 'S')
				     $vMemIcon='../images/geneaif.png';
				  else if ($oMember->getPaketID($vRegular["R"]) == 'G') 	 
				     $vMemIcon='../images/geneaif.png';
				  else if ($oMember->getPaketID($vRegular["R"]) == 'P') 	 
				     $vMemIcon='../images/geneaif.png';

			   }
			    
	   if ($vRegular["R"] !="") {
	     $vPaket=($oMember->getPaket($vRegular["R"]));

		   $vToolTip="Nama : ".$oMember->getMemberName($vRegular["R"]);
			   $vToolTip.="<br>Downline Group L : ".$vDownL;
			   $vToolTip.="<br> Downline Group R : ".$vDownR;
			   //$vToolTip.="<br>"."Downline Premium (L|R): ($vDownPremL | $vDownPremR)";
			   $vToolTip.="<br> Activation Date : ".$oPhpdate->YMD2DMY($oMember->getActivationDate($vRegular["R"]));
			   $vToolTip.="<br> Paket : ".$oProduct->getPackName($oMember->getMemField('fpaket',$vRegular["R"]));
			   //$vToolTip.="<br> LRTCF : ".($vCFReal['L'] + $vCFBeforeL).", RRTCF : ".($vCFReal['R'] + $vCFBeforeR) ;
			   //$vToolTip.="<br> Personal RO : ".number_format($vOmzetPriv,0,",",".");
			   //$vToolTip.="<br> Omzet RO (L) : $vOmzetDownLF <br> Omzet RO (R) : $vOmzetDownRF " ;
		    echo '<div data-toggle="tooltip" title="'.$vToolTip.'">';			 
	     echo '<img height="110" src="'.$vMemIcon.'">';
	     echo $vRegular["R"];
		 echo "</div>";


		 
		 
	  } else { 
	      echo "<img src='../images/nomem.png'>";	
		  echo "&nbsp;";
		  if ($vUserChoosed != "")
		   echo '<a href="../memstock/registerst.php?uMemberId='.$vUserChoosed.'&pos=R">Daftarkan di sini</a> <br><br>';
	  
	  
	  }
	   
	?>      </strong>
	  <span >
	  <?
	      if ($vRegular["R"] !="")
		    echo substr($oMember->getMemberName($vRegular["R"]),0,9)."...";
  		  $vRegular3=$oNetwork->getDownlinePos($vRegular["R"]);   
  		//  echo "::OmzetPriv:".$oKomisi->getOmzetROAllMember($vRegular["R"]);

		 
		  /*
		  for ($j=1;$j<count($vDownline3)+1;$j++) {
				   if ($j==1) $ji="L";if ($j==2) $ji="R";
				   $vRegular3[$ji]=$vDownline3[$j];   
		  } 
		 //  while(@list($vKey,$vVal)=@each($vDownline3))
		 //       $vRegular3[$vKey]=$vDownline3[$vKey];  
		 
		 */
	  ?>
	  
	   <?
		    $vJmlDown=$oNetwork->getDownlineCount($vRegular1["L"]);
			$vIsArr=$vRegular1["L"];
			if ($vJmlDown > 0) 
			  //  echo  $vJmlDown+1;
			  ;
			else if (($vJmlDown == 0) && ($vIsArr != ""))
				//echo 1;
				;
		    else if (($vJmlDown == 0) && ($vIsArr==""))
			   // echo 0;		
			   ;
		  ?>
		   <?
		    $vJmlDown=$oNetwork->getDownlineCount($vRegular1["R"]);
			$vIsArr=$vRegular1["R"];
			if ($vJmlDown > 0) 
			   // echo  $vJmlDown+1;
			   ;
			else if (($vJmlDown == 0) && ($vIsArr != ""))
				//echo 1;
				;
		    else if (($vJmlDown == 0) && ($vIsArr==""))
			    //echo 0;		
			    ;
		  ?>
		   <?
		    $vJmlDown=$oNetwork->getDownlineCount($vRegular3["L"]);
			$vIsArr=$vRegular3["L"];
			if ($vJmlDown > 0) 
			  //  echo  $vJmlDown+1;
			  ;
			else if (($vJmlDown == 0) && ($vIsArr != ""))
				//echo 1;
				;
		    else if (($vJmlDown == 0) && ($vIsArr==""))
			  //  echo 0;		
			  ;
		  ?>
		   <?
		    $vJmlDown=$oNetwork->getDownlineCount($vRegular3["R"]);
			$vIsArr=$vRegular3["R"];
			if ($vJmlDown > 0) 
			  //  echo  $vJmlDown+1;
			  ;
			else if (($vJmlDown == 0) && ($vIsArr != ""))
				//echo 1;
				;
		    else if (($vJmlDown == 0) && ($vIsArr==""))
			    //echo 0;		
			    ;
		  ?>
	  </span></div>
	<? if ($vJmlDown3 > 0) { ?></a><? } ?></td>
    <td style="height: 68px"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="height: 68px"></td>
<?
     $vPoint=$oKomisi->getPoint($vRegular["L"],'2016-04-01',date('Y-m-d'));
     $vTitle="Point L : ".$vPoint['L'];
     $vTitle.= "\n";
     $vTitle.="Point R : ".$vPoint['R'];
     $vTitle.= "\n";

      $vTitle.="Activation : ".$oMember->getActivationDate($vRegular["L"]);

  ?>
    
    <td colspan="3" valign="top" bgcolor="#fff"    >
	<? if ($vJmlDown1 > 0) { ?>
	<a href="" class="linknodecor" >
	<? } ?>
	<!-- <div align="center"  style="height:10em;border-bottom:none;border-left:1px solid gray;border-right:1px solid gray;border-top:1px solid gray;border-bottom:1px solid gray;height:170px" data-toggle="tooltip" title="<?=$vToolTip?>">-->
    <div align="center"   style="border:1px solid;border-radius:4px;height:170px" >
    
        
        <strong >
        <?
        
 			if ($vRegular["L"] !="") {
		    //echo $oMember->getMemberName($vRegular["L"]);
		   // echo "::OmzetPriv:".$oKomisi->getOmzetROAllMember($vRegular["L"]);
			  /* $vOmzetPriv=$oKomisi->getOmzetROMonthMember($vRegular["L"],date('m'),date('Y'));
			   $vOmzetPriv+=$oKomisi->getOmzetROMonthMemberWallet($vRegular["L"],date('m'),date('Y'));
			 //  $vOmzetDown=$oKomisi->getOmzetROWholeMember($vRegular["L"]);
			  // $vOmzetGroup=$vOmzetPriv + 	$vOmzetDown;

			   $vOmzetDownL=$oKomisi->getOmzetROWholeMemberMonth($vRegular1['L'],date('m'),date('Y'));
			   $vOmzetDownR=$oKomisi->getOmzetROWholeMemberMonth($vRegular1['R'],date('m'),date('Y'));
			   $vOmzetDownLW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular1['L'],date('m'),date('Y'));
			   $vOmzetDownRW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular1['R'],date('m'),date('Y'));

			   $vOmzetDownLF=number_format($vOmzetDownL+$vOmzetDownLW,0,",",".");
			   $vOmzetDownRF=number_format($vOmzetDownR+$vOmzetDownRW,0,",",".");
			   */

			   $vDownL=$oNetwork->getDownlineCountLR($vRegular["L"],'L');
			   $vDownR=$oNetwork->getDownlineCountLR($vRegular["L"],'R');
			   $vDownPrem=$oNetwork->getDownlineCountByPrem($vRegular["L"]);

			   $vNodeL=$oNetwork->getDownLR($vRegular["L"],'L');
			   $vNodeR=$oNetwork->getDownLR($vRegular["L"],'R');
			   $vDownPremL=$oNetwork->getDownlineCountByPrem($vNodeL);
			   $vDownPremR=$oNetwork->getDownlineCountByPrem($vNodeR);
			   if ($oMember->getPaketID($vNodeL) =='P') $vDownPremL +=1;
			   if ($oMember->getPaketID($vNodeR) =='P') $vDownPremR +=1;
			   
			   $vCFReal=$oNetwork->getCFDate($vRegular["L"],date('Y-m-d'));
			  // $vCFBeforeL=$oKomisi->getCFPosRT($vRegular["L"],'L',date('Y-m-d'));
			   //$vCFBeforeR=$oKomisi->getCFPosRT($vRegular["L"],'R',date('Y-m-d'));
			   
			   
			   
			   
			   $vToolTip="Nama : ".$oMember->getMemberName($vRegular["L"]);
			   $vToolTip.="<br>Downline Group L : ".$vDownL;
			   $vToolTip.="<br> Downline Group R : ".$vDownR;
			   //$vToolTip.="<br>"."Downline Premium (L|R): ($vDownPremL | $vDownPremR)";
			   $vToolTip.="<br> Activation Date : ".$oPhpdate->YMD2DMY($oMember->getActivationDate($vRegular["L"]));
			   $vToolTip.="<br> Paket : ".$oProduct->getPackName($oMember->getMemField('fpaket',$vRegular["L"]));
			   //$vToolTip.="<br> LRTCF : ".($vCFReal['L'] + $vCFBeforeL).", RRTCF : ".($vCFReal['R'] + $vCFBeforeR) ;
			   //$vToolTip.="<br> Personal RO : ".number_format($vOmzetPriv,0,",",".");
			   $vToolTip.="<br> Omzet RO (L) : $vOmzetDownLF <br> Omzet RO (R) : $vOmzetDownRF " ;
		    echo '<div data-toggle="tooltip" title="'.$vToolTip.'">';
      
 

	     $vPaket=($oMember->getPaket($vRegular["L"]));


			   $vSex=$oMember->getMemField('fsex',$vRegular["L"]);
			   if ($vSex=='M') {
			      if ($oMember->getPaketID($vRegular["L"]) == 'S')
				     $vMemIcon='../images/geneaim.png';
				  else if ($oMember->getPaketID($vRegular["L"]) == 'G') 	 
				     $vMemIcon='../images/geneaim.png';
				  else if ($oMember->getPaketID($vRegular["L"]) == 'P') 	 
				     $vMemIcon='../images/geneaim.png';		 
			   } else {	  
			      if ($oMember->getPaketID($vRegular["L"]) == 'S')
				     $vMemIcon='../images/geneaif.png';
				  else if ($oMember->getPaketID($vRegular["L"]) == 'G') 	 
				     $vMemIcon='../images/geneaif.png';
				  else if ($oMember->getPaketID($vRegular["L"]) == 'P') 	 
				     $vMemIcon='../images/geneaif.png';

			   }
			   
			   	    // echo '<img height="100" data-toggle="tooltip" title="'.$vToolTip.'" src="../images/geneicon.png">';
	     echo '<img height="110" data-toggle="tooltip"  src="'.$vMemIcon.'">';
	     echo $vRegular["L"];
	      

	  } else { 
	     echo "<img src='../images/nomem.png' height='110'>";	       
		 if ($vUserChoosed != "")
		 	echo '<a href="../memstock/registerst.php?uMemberId='.$vUserChoosed.'&pos=L">Daftarkan di sini</a> <br><br>';
 
		 
	  }
	   
	?></strong></div>        
        
<?
			if ($vRegular["L"] !="") 
		  echo  substr($oMember->getMemberName($vRegular["L"]),0,9)."...";
		   // echo "::OmzetPriv:".$oKomisi->getOmzetROAllMember($vRegular["L"]);
			  /* $vOmzetPriv=$oKomisi->getOmzetROAllMember($vRegular["L"]);
			   $vOmzetDown=$oKomisi->getOmzetROWholeMember($vRegular["L"]);
			   $vOmzetGroup=$vOmzetPriv + 	$vOmzetDown;
			   */
			   $vDownL=$oNetwork->getDownlineCountLR($vRegular["L"],'L');
			   $vDownR=$oNetwork->getDownlineCountLR($vRegular["L"],'R');

			   
			  // $vToolTip="Personal RO : ".number_format($vOmzetPriv,0,",",".");
			   //$vToolTip.="<br>"."Group Omzet : ".number_format($vOmzetGroup,0,",",".");
			 //  $vToolTip.="<br>"."Downline Group L : ".number_format($vDownL,0,",",".");
			 //  $vToolTip.="<br>"."Downline Group R : ".number_format($vDownR,0,",",".");


		  //  echo '<strong data-toggle="tooltip" title="'.$vToolTip.'">'.$vRegular["L"].'</strong>';


         ?>


    <? if ($vJmlDown1>0) { ?></a><? } ?></a>
    <div data-toggle="tooltip" title="<?=$vToolTip?>" style="cursor:pointer" onClick="document.location.href='?op=<?=$_SESSION['sop']?>&uTop=<?=$vRegular["L"]?>&uMemberId=<?=$vRefUser?>'">&nbsp;
    </div>
    </td>
    <td style="height: 68px"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="height: 68px"></td>
<?
    /* $vPoint=$oKomisi->getPoint($vRegular["R"],'2016-04-01',date('Y-m-d'));
     $vTitle="Point L : ".$vPoint['L'];
     $vTitle.= "\n";
     $vTitle.="Point R : ".$vPoint['R'];
     $vTitle.= "\n";

      $vTitle.="Activation : ".$oMember->getActivationDate($vRegular["R"]);*/

			   //$vOmzetPriv=$oKomisi->getOmzetROAllMember($vRegular["R"]);
			  /* $vOmzetPriv=$oKomisi->getOmzetROMonthMember($vRegular["R"],date('m'),date('Y'));
			   $vOmzetPriv+=$oKomisi->getOmzetROMonthMemberWallet($vRegular["R"],date('m'),date('Y'));

			   $vOmzetDownL=$oKomisi->getOmzetROWholeMemberMonth($vRegular3['L'],date('m'),date('Y'));
			   $vOmzetDownR=$oKomisi->getOmzetROWholeMemberMonth($vRegular3['R'],date('m'),date('Y'));
			   $vOmzetDownLW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular3['L'],date('m'),date('Y'));
			   $vOmzetDownRW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular3['R'],date('m'),date('Y'));

			   $vOmzetDownLF=number_format($vOmzetDownL+$vOmzetDownLW,0,",",".");
			   $vOmzetDownRF=number_format($vOmzetDownR+$vOmzetDownRW,0,",",".");
			   
			//   $vOmzetDown=$oKomisi->getOmzetROWholeMember($vRegular["R"]);
		//	   $vOmzetGroup=$vOmzetPriv + 	$vOmzetDown;
			   */
			   $vDownL=$oNetwork->getDownlineCountLR($vRegular["R"],'L');
			   $vDownR=$oNetwork->getDownlineCountLR($vRegular["R"],'R');
			   $vDownPrem=$oNetwork->getDownlineCountByPrem($vRegular["R"]);

			   $vNodeL=$oNetwork->getDownLR($vRegular["R"],'L');
			   $vNodeR=$oNetwork->getDownLR($vRegular["R"],'R');
			   $vDownPremL=$oNetwork->getDownlineCountByPrem($vNodeL);
			   $vDownPremR=$oNetwork->getDownlineCountByPrem($vNodeR);
			   if ($oMember->getPaketID($vNodeL) =='P') $vDownPremL +=1;
			   if ($oMember->getPaketID($vNodeR) =='P') $vDownPremR +=1;
			   
			    $vCFReal=$oNetwork->getCFDate($vRegular["R"],date('Y-m-d'));
			//   $vCFBeforeL=$oKomisi->getCFPosRT($vRegular["R"],'L',date('Y-m-d'));
			 //  $vCFBeforeR=$oKomisi->getCFPosRT($vRegular["R"],'R',date('Y-m-d'));
				
				
			  
			  
			   $vToolTip="Nama : ".$oMember->getMemberName($vRegular["R"]);
			   $vToolTip.="<br>Downline Group L : ".$vDownL;
			   $vToolTip.="<br> Downline Group R : ".$vDownR;
			   //$vToolTip.="<br>"."Downline Premium (L|R): ($vDownPremL | $vDownPremR) ";
			   $vToolTip.="<br> Activation Date : ".$oPhpdate->YMD2DMY($oMember->getActivationDate($vRegular["R"]));
			   $vToolTip.="<br> Paket : ".$oProduct->getPackName($oMember->getMemField('fpaket',$vRegular["R"]));
			   //$vToolTip.="<br> LRTCF : ".($vCFReal['L'] + $vCFBeforeL).", RRTCF : ".($vCFReal['R'] + $vCFBeforeR) ;
			  // $vToolTip.="<br> Personal RO : ".number_format($vOmzetPriv,0,",",".");
			  // $vToolTip.="<br> Omzet RO (L) : $vOmzetDownLF <br> Omzet RO (R) : $vOmzetDownRF " ;

      

  ?>
    
    <td colspan="3" valign="top" bgcolor="#fff" class="boxgenea" style="height: 110px" title="">
	 <? if ($vJmlDown3 > 0) { ?>
	 <a    href="" class="linknodecor">
	 	 <? } ?>
	<div align="center"   style="border:1px solid;border-radius:4px;height:170px"  <? if ($vJmlDown3 > 0) echo 'data-toggle="tooltip" title="'.$vToolTip.'"';?>>
   
    <strong>
  
   
	
	    <?
  
  
        
  			   $vSex=$oMember->getMemField('fsex',$vRegular["R"]);
			   if ($vSex=='M') {
			      if ($oMember->getPaketID($vRegular["R"]) == 'S')
				     $vMemIcon='../images/geneaim.png';
				  else if ($oMember->getPaketID($vRegular["R"]) == 'G') 	 
				     $vMemIcon='../images/geneaim.png';
				  else if ($oMember->getPaketID($vRegular["R"]) == 'P') 	 
				     $vMemIcon='../images/geneaim.png';		 
			   } else {	  
			      if ($oMember->getPaketID($vRegular["R"]) == 'S')
				     $vMemIcon='../images/geneaif.png';
				  else if ($oMember->getPaketID($vRegular["R"]) == 'G') 	 
				     $vMemIcon='../images/geneaif.png';
				  else if ($oMember->getPaketID($vRegular["R"]) == 'P') 	 
				     $vMemIcon='../images/geneaif.png';

			   }
			    
	   if ($vRegular["R"] !="") {
	     $vPaket=($oMember->getPaket($vRegular["R"]));

		   $vToolTip="Nama : ".$oMember->getMemberName($vRegular["R"]);
			   $vToolTip.="<br>Downline Group L : ".$vDownL;
			   $vToolTip.="<br> Downline Group R : ".$vDownR;
			   //$vToolTip.="<br>"."Downline Premium (L|R): ($vDownPremL | $vDownPremR)";
			   $vToolTip.="<br> Activation Date : ".$oPhpdate->YMD2DMY($oMember->getActivationDate($vRegular["R"]));
			   $vToolTip.="<br> Paket : ".$oProduct->getPackName($oMember->getMemField('fpaket',$vRegular["R"]));
			   //$vToolTip.="<br> LRTCF : ".($vCFReal['L'] + $vCFBeforeL).", RRTCF : ".($vCFReal['R'] + $vCFBeforeR) ;
			   //$vToolTip.="<br> Personal RO : ".number_format($vOmzetPriv,0,",",".");
			   //$vToolTip.="<br> Omzet RO (L) : $vOmzetDownLF <br> Omzet RO (R) : $vOmzetDownRF " ;
		    echo '<div data-toggle="tooltip" title="'.$vToolTip.'">';			 
	     echo '<img height="110" src="'.$vMemIcon.'">';
	     echo $vRegular["R"];
		 echo "</div>";


		 
		 
	  } else { 
	      echo "<img src='../images/nomem.png'>";	
		  echo "&nbsp;";
		  if ($vUserChoosed != "")
		   echo '<a href="../memstock/registerst.php?uMemberId='.$vUserChoosed.'&pos=R">Daftarkan di sini</a> <br><br>';
	  
	  
	  }
	   
	?>      </strong>
	  <span >
	  <?
	      if ($vRegular["R"] !="")
		    echo substr($oMember->getMemberName($vRegular["R"]),0,9)."...";
  		  $vRegular3=$oNetwork->getDownlinePos($vRegular["R"]);   
  		//  echo "::OmzetPriv:".$oKomisi->getOmzetROAllMember($vRegular["R"]);

		 
		  /*
		  for ($j=1;$j<count($vDownline3)+1;$j++) {
				   if ($j==1) $ji="L";if ($j==2) $ji="R";

				   $vRegular3[$ji]=$vDownline3[$j];   
		  } 
		 //  while(@list($vKey,$vVal)=@each($vDownline3))
		 //       $vRegular3[$vKey]=$vDownline3[$vKey];  
		 
		 */
	  ?>
	  
	   <?
		    $vJmlDown=$oNetwork->getDownlineCount($vRegular1["L"]);
			$vIsArr=$vRegular1["L"];

			if ($vJmlDown > 0) 
			  //  echo  $vJmlDown+1;
			  ;
			else if (($vJmlDown == 0) && ($vIsArr != ""))
				//echo 1;
				;
		    else if (($vJmlDown == 0) && ($vIsArr==""))
			   // echo 0;		
			   ;
		  ?>
		   <?
		    $vJmlDown=$oNetwork->getDownlineCount($vRegular1["R"]);
			$vIsArr=$vRegular1["R"];
			if ($vJmlDown > 0) 
			   // echo  $vJmlDown+1;
			   ;
			else if (($vJmlDown == 0) && ($vIsArr != ""))
				//echo 1;
				;
		    else if (($vJmlDown == 0) && ($vIsArr==""))
			    //echo 0;		
			    ;
		  ?>
		   <?
		    $vJmlDown=$oNetwork->getDownlineCount($vRegular3["L"]);
			$vIsArr=$vRegular3["L"];
			if ($vJmlDown > 0) 
			  //  echo  $vJmlDown+1;
			  ;
			else if (($vJmlDown == 0) && ($vIsArr != ""))
				//echo 1;
				;
		    else if (($vJmlDown == 0) && ($vIsArr==""))
			  //  echo 0;		
			  ;
		  ?>
		   <?
		    $vJmlDown=$oNetwork->getDownlineCount($vRegular3["R"]);
			$vIsArr=$vRegular3["R"];
			if ($vJmlDown > 0) 
			  //  echo  $vJmlDown+1;
			  ;
			else if (($vJmlDown == 0) && ($vIsArr != ""))
				//echo 1;
				;
		    else if (($vJmlDown == 0) && ($vIsArr==""))
			    //echo 0;		
			    ;
		  ?>
	  </span></div>
	<? if ($vJmlDown3 > 0) { ?></a><? } ?></td>
    <td style="height: 68px"></td>
  </tr>
  <tr>
   <td height="40" colspan="2"><div align="right"><img src="../images/genmirleftbwh.png" height="50"></div></td>
    <td><div align="center"></div></td>
    <td colspan="2"><div align="left"><img src="../images/genmirrightbwh.png" height="50"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="right"><img src="../images/genmirleftbwh.png" height="50"></div></td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="left"><img src="../images/genmirrightbwh.png" height="50"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td height="40" colspan="2"><div align="right"><img src="../images/genmirleftbwh.png" height="50"></div></td>
    <td><div align="center"></div></td>
    <td colspan="2"><div align="left"><img src="../images/genmirrightbwh.png" height="50"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="right"><img src="../images/genmirleftbwh.png" height="50"></div></td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="left"><img src="../images/genmirrightbwh.png" height="50"></div></td>
  </tr>
  <tr>
    <td valign="top" ><div align="center">
	<? if ($vDown11>0) {?>
	<a href="" >
	<img src="../images/triangledown.png" height="14" border="0">	</a>
	<? } ?>
	</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top" ><div align="center">
      <? if ($vDown13>0) {?>
      <a href="" > <img src="../images/triangledown.png" height="14" border="0"> </a>
      <? } ?>
</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top" ><div align="center">
      <? if ($vDown31>0) {?>
      <a href="" > <img src="../images/triangledown.png" height="14" border="0"> </a>
      <? } ?>
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top" ><div align="center">
      <? if ($vDown33>0) {?>
      <a href="" > <img src="../images/triangledown.png" height="14" border="0"> </a>
      <? } ?>
</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top" ><div align="center">
      <? if ($vDown33>0) {?>
      <a href="" > <img src="../images/triangledown.png" height="14" border="0"> </a>
      <? } ?>
</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top" ><div align="center">
      <? if ($vDown33>0) {?>
      <a href="" > <img src="../images/triangledown.png" height="14" border="0"> </a>
      <? } ?>
</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top" ><div align="center">
      <? if ($vDown33>0) {?>
      <a href="?menu=genealogi2&uTop=<?=$vRegular3["R"]?>&uMemberId=<?=$vRefUser?> " > <img src="../images/triangledown.png" height="14" border="0"> </a>
      <? } ?>
</div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top" ><div align="center">
      <? if ($vDown33>0) {?>
      <a href="?menu=genealogi2&uTop=<?=$vRegular3["R"]?>&uMemberId=<?=$vRefUser?> " > <img src="../images/triangledown.png" height="14" border="0"> </a>
      <? } ?>
</div></td>
  </tr>
</table>
<div class="col-lg-6 " style="font-weight:bold">
<p>&nbsp;</p>
<p>LRTCF = LEFT REAL TIME CF<br>
RRTCF = RIGHT REAL TIME CF</p>

</div>
</div>
</div>
       

<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="../js/jquery-migrate-1.2.1.min.js"></script>

<script src="../js/modernizr.min.js"></script>
<script src="../js/jquery.nicescroll.js"></script>
<script src="../js/jquery.price_format.js"></script>




<script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="../js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<!--common scripts for all pages-->
<script src="../js/pickers-init.js"></script>
</div>
	<!-- end page container -->
	

<? if ($_GET['op'] != '') 
	 include_once("../framework/admin_footside.blade.php") ; 
else	
     include_once("../framework/member_footside.blade.php") ; 
