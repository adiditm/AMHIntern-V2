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
			 $oSystem->jsLocation("./genealogi24.php?op=38ef1f498a09bdeb60928a81c0f77bb4d350f62795e71a17bfaad674ffea965f&uMemberId=ONOTOP");
		  }
     
	  } else {
	  
		  if ($oNetwork->isInNetwork($vCrit,$vUser)=='1')
			 $vUserChoosed=$vCrit; 
		  else
			 $oSystem->jsAlert("Downline tidak ada, atau tidak berada dalam jaringan Anda!");	 

	} 	 
	  
  }
  $vCurrent=$_GET['current'];
  $vMenu=$_GET['menu'];
?>
<link href="../build/css/custom.min.css" rel="stylesheet">

 <div class="right_col" role="main">
		<div><label><h3>Genealogy</h3></label></div> 
<div class="table-responsive">
<?
   			 
			   $vUp=$_GET['uUp'];
			   if (strlen($vUp)>2) $vUserChoosed=$vUp;

			   $vName=$oMember->getMemberName($vUserChoosed);
			    $vUpline=$oNetwork->getUpline($vUserChoosed);
				
			   //if (strlen($vUpline)>2)
			    //  $vUserChoosed= 
			   
			?>
<table class="pohon-mbr" border="0" cellspacing="0" cellpadding="0">

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

    <td colspan="3" valign="top" ><div align="center">
	<? if (strtoupper($vUserChoosed)!=$oMember->getFirstID() && $vUserChoosed != $vUser && $vUserChoosed!=$oMember->getFirstID()) { ?>
	<a href="?op=<?=$_SESSION['sop']?>&uUp=<?=$vUpline?>&uMemberId=<?=$vRefUser?>">
	<img src="../images/triangleup.png" width="28" height="15" border="0"></a></div>
    <? } ?></td>

	

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

    <td colspan="3"  valign="top" bgcolor="#fff" class="kotak-member">
    
   
      <?
      		   $vPaket=$oMember->getPaketID($vUserChoosed);
			   if ($vPaket=='S')
			       $vPackIcon='../images/gene-1-hu.png';
			   else 	  if ($vPaket=='G')
			       $vPackIcon='../images/gene-3-hu.png';
			   else 	  if ($vPaket=='P')
			       $vPackIcon='../images/gene-7-hu.png';
				   
			   $vSex=$oMember->getMemField('fsex',$vUserChoosed);
			   $vStatus = $oMember->getMemField('faktif',$vUserChoosed) ;
			   if ($vSex=='M') {
			      if ( $vStatus == '1')
				     $vMemIcon='../images/member-icon-L-a.png';
				  elseif ( $vStatus == '4')	 
				     $vMemIcon='../images/member-icon-L-t.png';
				  elseif ( $vStatus == '3')	 
				     $vMemIcon='../images/member-icon-L-f.png';
			   } else {	  
			      if ( $vStatus == '1')
				     $vMemIcon='../images/member-icon-W-a.png';
				  elseif ( $vStatus == '4')	 
				     $vMemIcon='../images/member-icon-W-t.png';
				  elseif ( $vStatus == '3')	 
				     $vMemIcon='../images/member-icon-W-f.png';

			   }
			   
			   
			   $vRegular=$oNetwork->getDownlinePos($vUserChoosed);   
			   
			   $vCountDownL=$oNetwork->getDownlineCountLR($vUserChoosed,'L');		      
			   $vCountDownR=$oNetwork->getDownlineCountLR($vUserChoosed,'R');

		
			   
			   $vToolTip="Nama : ".$oMember->getMemberName($vUserChoosed);
			   $vToolTip.="<br>Downline Group L : ".number_format($vCountDownL,0,",",".");
			   $vToolTip.="<br>"."Downline Group R : ".number_format($vCountDownR,0,",",".");
			  // $vToolTip.="<br>"."Downline Premium (L|R): ($vDownPremL | $vDownPremR) ";
			   $vToolTip.="<br> Activation Date : ".$oPhpdate->YMD2DMY($oMember->getActivationDate($vUserChoosed));
			   $vToolTip.="<br> Paket : ".$oProduct->getPackName($oMember->getMemField('fpaket',$vUserChoosed));
			 
 
			?>
      
     
  

      <div>

        <div class="icon-mbr"><img src="<?=$vMemIcon?>" style="max-width:100%" /></div>

<div class="icon-mbr-kecil"><img style="max-width:100%" src="<?=$vPackIcon?>" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><?=$vUserChoosed?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vUserChoosed)?></div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vUserChoosed))?></div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(
        <?
			 echo number_format($vCountDownL,0,",",".");
		?>
        </div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?

			 echo number_format($vCountDownR,0,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vUserChoosed,'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vUserChoosed,'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vUserChoosed);
			   echo $vSpon;
			   
			   
		  		$vDownLevel1=$oNetwork->getDownlinePos($vUserChoosed);
				
			   
		?></strong></div>

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

  </tr>

  <tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="8" style="border-right:1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="8" style="border-left:1px solid #000">&nbsp;</td>

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

    <td colspan="8" style="border-left: 1px solid #000; border-top: 1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="8" style="border-right: 1px solid #000; border-top: 1px solid #000">&nbsp;</td>

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

    <td colspan="3"  valign="top" bgcolor="#fff" class="kotak-member">
    		<? 
			  if (trim($vDownLevel1['L']) != -1 && trim($vDownLevel1['L'] )!='') {
					   $vPaket=$oMember->getPaketID($vDownLevel1['L']);
					   if ($vPaket=='S')
						   $vPackIcon='../images/gene-1-hu.png';
					   else 	  if ($vPaket=='G')
						   $vPackIcon='../images/gene-3-hu.png';
					   else 	  if ($vPaket=='P')
						   $vPackIcon='../images/gene-7-hu.png';
						   
					   $vSex=$oMember->getMemField('fsex',$vDownLevel1['L']);
					   $vStatus = $oMember->getMemField('faktif',$vDownLevel1['L']);
		
					   if ($vSex=='M') {
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-L-a.png';
						  elseif ($vStatus == '4')	 
							 $vMemIcon='../images/member-icon-L-t.png';
						  elseif ($vStatus  == '3')	 
							 $vMemIcon='../images/member-icon-L-f.png';
					   } else {	  
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-W-a.png';
						  elseif ($vStatus  == '4')	 
							 $vMemIcon='../images/member-icon-W-t.png';
						  elseif ($vStatus == '3')	 
							 $vMemIcon='../images/member-icon-W-f.png';
		
					   }
					   
						$vCountDownL=$oNetwork->getDownlineCountLR($vDownLevel1['L'],'L');		      
						$vCountDownR=$oNetwork->getDownlineCountLR($vDownLevel1['L'],'R');
               ?>
      <div>

     	<div class="icon-mbr">
        <a href="?menu=genealogi24&uTop=<?=$vDownLevel1['L']?>&uMemberId=<?=$vRefUser?>&current=<?=$vCurrent?>&menu=<?=$vMenu?>" >
        <img src="<?=$vMemIcon?>" style="max-width:100%" />
        </a>
        </div>

<div class="icon-mbr-kecil"><img style="max-width:100%" src="<?=$vPackIcon?>" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><?
           echo $vDownLevel1['L'];
		?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vDownLevel1['L'])?></div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vDownLevel1['L']))?></div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
            
			 echo number_format($vCountDownL,0,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
			 echo number_format($vCountDownR,0,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vDownLevel1['L'],'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vDownLevel1['L'],'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vDownLevel1['L']);
			   echo $vSpon;
		  	   $vDownLevel2L=$oNetwork->getDownlinePos($vDownLevel1['L']);
		?></strong></div>

      </div>
      <? } else { ?>
 
       <div>

        <div class="icon-mbr-kosong"><img src="../images/member-icon-vacant.png" style="max-width:100%" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr">
        
        <? if (trim($vUserChoosed) != -1 && trim($vUserChoosed)!='') {?>	
        <div class="txt-mbr"><a href="<?='../memstock/registerst.php?uMemberId='.$vUserChoosed.'&pos=L';?>">Daftarkan di sini</a></div>
        <? } ?>

      </div>     
      <? } ?>      
      </td>

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

    <td colspan="3"  valign="top" bgcolor="#fff" class="kotak-member">
<? 

			   if (trim($vDownLevel1['R']) != -1 && trim($vDownLevel1['R'] )!='') {
								   $vPaket=$oMember->getPaketID($vDownLevel1['R']);
								   if ($vPaket=='S')
									   $vPackIcon='../images/gene-1-hu.png';
								   else 	  if ($vPaket=='G')
									   $vPackIcon='../images/gene-3-hu.png';
								   else 	  if ($vPaket=='P')
									   $vPackIcon='../images/gene-7-hu.png';
									   
								   $vSex=$oMember->getMemField('fsex',$vDownLevel1['R']);
								   $vStatus = $oMember->getMemField('faktif',$vDownLevel1['R']);
					
								   if ($vSex=='M') {
									  if ($vStatus  == '1')
										 $vMemIcon='../images/member-icon-L-a.png';
									  elseif ($vStatus == '4')	 
										 $vMemIcon='../images/member-icon-L-t.png';
									  elseif ($vStatus  == '3')	 
										 $vMemIcon='../images/member-icon-L-f.png';
								   } else {	  
									  if ($vStatus  == '1')
										 $vMemIcon='../images/member-icon-W-a.png';
									  elseif ($vStatus  == '4')	 
										 $vMemIcon='../images/member-icon-W-t.png';
									  elseif ($vStatus == '3')	 
										 $vMemIcon='../images/member-icon-W-f.png';
					
								   }
								   
								   
								
									$vCountDownL=$oNetwork->getDownlineCountLR($vDownLevel1['R'],'L');		      
									$vCountDownR=$oNetwork->getDownlineCountLR($vDownLevel1['R'],'R');
			 
               ?>
      <div>

     	<div class="icon-mbr">
        <a href="?menu=genealogi24&uTop=<?=$vDownLevel1['R']?>&uMemberId=<?=$vRefUser?>&current=<?=$vCurrent?>&menu=<?=$vMenu?>" >
        <img src="<?=$vMemIcon?>" style="max-width:100%" />
        </a>
        </div>

     	<div class="icon-mbr-kecil"><img style="max-width:100%" src="../images/gene-7-hu.png" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><?
           echo $vDownLevel1['R'];
		?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vDownLevel1['R'])?></div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vDownLevel1['R']))?></div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
            
			 echo number_format($vCountDownL,0,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
			 echo number_format($vCountDownR,0,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vDownLevel1['R'],'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vDownLevel1['R'],'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vDownLevel1['R']);
			   echo $vSpon;
		  	   $vDownLevel2R=$oNetwork->getDownlinePos($vDownLevel1['R']);
		?></strong></div>

      </div>
      <? } else {?>
 
       <div>

        <div class="icon-mbr-kosong"><img src="../images/member-icon-vacant.png" style="max-width:100%" /></div>

        <div style="clear:both"></div>

        <? if (trim($vUserChoosed) != -1 && trim($vUserChoosed)!='') {?>	
        <div class="txt-mbr"><a href="<?='../memstock/registerst.php?uMemberId='.$vUserChoosed.'&pos=R';?>">Daftarkan di sini</a></div>
        <? } ?>

      </div>       
      <? } ?>
      </td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td></td>

    <td></td>

    <td colspan="4" style="border-right:1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="4" style="border-left:1px solid #000">&nbsp;</td>

    <td></td>

    <td></td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td></td>

    <td colspan="4" style="border-right:1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="4" style="border-left:1px solid #000">&nbsp;</td>

    <td></td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td></td>

    <td></td>

    <td colspan="4" style="border-left: 1px solid #000; border-top: 1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="4" style="border-right: 1px solid #000; border-top: 1px solid #000">&nbsp;</td>

    <td></td>

    <td></td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td></td>

    <td colspan="4" style="border-left: 1px solid #000; border-top: 1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="4" style="border-right: 1px solid #000; border-top: 1px solid #000">&nbsp;</td>

    <td></td>

    <td>&nbsp;</td>

  </tr>

  <tr>

    <td></td>



    

    <td colspan="3" valign="top" bgcolor="#fff" class="kotak-member">
<? 
			  if (trim($vDownLevel2L['L']) != -1 && trim($vDownLevel2L['L'] )!='') {
					   $vPaket=$oMember->getPaketID($vDownLevel2L['L']);
					   if ($vPaket=='S')
						   $vPackIcon='../images/gene-1-hu.png';
					   else 	  if ($vPaket=='G')
						   $vPackIcon='../images/gene-3-hu.png';
					   else 	  if ($vPaket=='P')
						   $vPackIcon='../images/gene-7-hu.png';
						   
					   $vSex=$oMember->getMemField('fsex',$vDownLevel2L['L']);
					   $vStatus = $oMember->getMemField('faktif',$vDownLevel2L['L']);
		
					   if ($vSex=='M') {
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-L-a.png';
						  elseif ($vStatus == '4')	 
							 $vMemIcon='../images/member-icon-L-t.png';
						  elseif ($vStatus  == '3')	 
							 $vMemIcon='../images/member-icon-L-f.png';
					   } else {	  
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-W-a.png';
						  elseif ($vStatus  == '4')	 
							 $vMemIcon='../images/member-icon-W-t.png';
						  elseif ($vStatus == '3')	 
							 $vMemIcon='../images/member-icon-W-f.png';
		
					   }
					   
						$vCountDownL=$oNetwork->getDownlineCountLR($vDownLevel2L['L'],'L');		      
						$vCountDownR=$oNetwork->getDownlineCountLR($vDownLevel2L['L'],'R');
               ?>
     <div>

     	<div class="icon-mbr">
        <a href="?menu=genealogi24&uTop=<?=$vDownLevel2L['L']?>&uMemberId=<?=$vRefUser?>&current=<?=$vCurrent?>&menu=<?=$vMenu?>">
        <img src="<?=$vMemIcon?>" style="max-width:100%" /></a></div>

<div class="icon-mbr-kecil"><img style="max-width:100%" src="<?=$vPackIcon?>" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><?
           echo $vDownLevel2L['L'];
		?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vDownLevel2L['L'])?></div>

        <div style="clear:both"></div>

     	<div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vDownLevel2L['L']))?></div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
            
			 echo number_format($vCountDownL,0,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?   echo number_format($vCountDownR,0,",",".");?>)</div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vDownLevel2L['L'],'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vDownLevel2L['L'],'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vDownLevel2L['L']);
			   echo $vSpon;
		  	   $vDownLevel3LL=$oNetwork->getDownlinePos($vDownLevel2L['L']);
		?></strong></div>

      </div>
      <? } else {?>
 
       <div>

        <div class="icon-mbr-kosong"><img src="../images/member-icon-vacant.png" style="max-width:100%" /></div>

        <div style="clear:both"></div>
		<? if (trim($vDownLevel1['L']) != -1 && trim($vDownLevel1['L'] )!='') {?>	
        <div class="txt-mbr"><a href="<?='../memstock/registerst.php?uMemberId='.$vDownLevel1['L'].'&pos=L';?>">Daftarkan di sini</a></div>
        <? } ?>

      </div>          
      <? } ?>

    </td>

    <td></td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td></td>



    

    <td colspan="3" valign="top" bgcolor="#fff" class="kotak-member">
<? 
			  if (trim($vDownLevel2L['R']) != -1 && trim($vDownLevel2L['R'] )!='') {
					   $vPaket=$oMember->getPaketID($vDownLevel2L['R']);
					   if ($vPaket=='S')
						   $vPackIcon='../images/gene-1-hu.png';
					   else 	  if ($vPaket=='G')
						   $vPackIcon='../images/gene-3-hu.png';
					   else 	  if ($vPaket=='P')
						   $vPackIcon='../images/gene-7-hu.png';
						   
					   $vSex=$oMember->getMemField('fsex',$vDownLevel2L['R']);
					   $vStatus = $oMember->getMemField('faktif',$vDownLevel2L['R']);
		
					   if ($vSex=='M') {
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-L-a.png';
						  elseif ($vStatus == '4')	 
							 $vMemIcon='../images/member-icon-L-t.png';
						  elseif ($vStatus  == '3')	 
							 $vMemIcon='../images/member-icon-L-f.png';
					   } else {	  
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-W-a.png';
						  elseif ($vStatus  == '4')	 
							 $vMemIcon='../images/member-icon-W-t.png';
						  elseif ($vStatus == '3')	 
							 $vMemIcon='../images/member-icon-W-f.png';
		
					   }
					   
						$vCountDownL=$oNetwork->getDownlineCountLR($vDownLevel2L['R'],'L');		      
						$vCountDownR=$oNetwork->getDownlineCountLR($vDownLevel2L['R'],'R');
               ?>
     <div>

     	<div class="icon-mbr">
         <a href="?menu=genealogi24&uTop=<?=$vDownLevel2L['R']?>&uMemberId=<?=$vRefUser?>&current=<?=$vCurrent?>&menu=<?=$vMenu?>">
        <img src="<?=$vMemIcon?>" style="max-width:100%" /></a></div>

<div class="icon-mbr-kecil"><img style="max-width:100%" src="<?=$vPackIcon?>" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><?
           echo $vDownLevel2L['R'];
		?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vDownLevel2L['R'])?></div>

        <div style="clear:both"></div>

     	<div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vDownLevel2L['R']))?></div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
            
			 echo number_format($vCountDownL,0,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?   echo number_format($vCountDownR,0,",",".");?>)</div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vDownLevel2L['R'],'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vDownLevel2L['R'],'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vDownLevel2L['R']);
			   echo $vSpon;
		  	   $vDownLevel3LR=$oNetwork->getDownlinePos($vDownLevel2L['R']);
		?></strong></div>

      </div>
  <? } else {?>
 
       <div>

        <div class="icon-mbr-kosong"><img src="../images/member-icon-vacant.png" style="max-width:100%" /></div>

        <div style="clear:both"></div>

        <? if (trim($vDownLevel1['L']) != -1 && trim($vDownLevel1['L'] )!='') {?>	
        <div class="txt-mbr"><a href="<?='../memstock/registerst.php?uMemberId='.$vDownLevel1['L'].'&pos=R';?>">Daftarkan di sini</a></div>
        <? } ?>

      </div>          
      <? } ?>     
      
      </td>

    <td></td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td></td>



    

    <td colspan="3" valign="top" bgcolor="#fff" class="kotak-member">
<? 
			  if (trim($vDownLevel2R['L']) != -1 && trim($vDownLevel2R['L'] )!='') {
					   $vPaket=$oMember->getPaketID($vDownLevel2R['L']);
					   if ($vPaket=='S')
						   $vPackIcon='../images/gene-1-hu.png';
					   else 	  if ($vPaket=='G')
						   $vPackIcon='../images/gene-3-hu.png';
					   else 	  if ($vPaket=='P')
						   $vPackIcon='../images/gene-7-hu.png';
						   
					   $vSex=$oMember->getMemField('fsex',$vDownLevel2R['L']);
					   $vStatus = $oMember->getMemField('faktif',$vDownLevel2R['L']);
		
					   if ($vSex=='M') {
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-L-a.png';
						  elseif ($vStatus == '4')	 
							 $vMemIcon='../images/member-icon-L-t.png';
						  elseif ($vStatus  == '3')	 
							 $vMemIcon='../images/member-icon-L-f.png';
					   } else {	  
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-W-a.png';
						  elseif ($vStatus  == '4')	 
							 $vMemIcon='../images/member-icon-W-t.png';
						  elseif ($vStatus == '3')	 
							 $vMemIcon='../images/member-icon-W-f.png';
		
					   }
					   
						$vCountDownL=$oNetwork->getDownlineCountLR($vDownLevel2R['L'],'L');		      
						$vCountDownR=$oNetwork->getDownlineCountLR($vDownLevel2R['L'],'R');
               ?>
     <div>

     	<div class="icon-mbr"> 
        <a href="?menu=genealogi24&uTop=<?=$vDownLevel2R['L']?>&uMemberId=<?=$vRefUser?>&current=<?=$vCurrent?>&menu=<?=$vMenu?>">
        <img src="<?=$vMemIcon?>" style="max-width:100%" /></a></div>

     	<div class="icon-mbr-kecil"><img style="max-width:100%" src="<?=$vPackIcon?>" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><? echo $vDownLevel2R['L'];?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vDownLevel2R['L'])?></div>

        <div style="clear:both"></div>

     	<div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vDownLevel2R['L']))?></div>

          <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
            
			 echo number_format($vCountDownL,0,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?   echo number_format($vCountDownR,0,",",".");?>)</div>

         <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vDownLevel2R['L'],'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vDownLevel2R['L'],'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vDownLevel2R['L']);
			   echo $vSpon;
		  	   $vDownLevel3RL=$oNetwork->getDownlinePos($vDownLevel2R['L']);
		?></strong></div>

      </div>
 <? } else {?>
 
       <div>

        <div class="icon-mbr-kosong"><img src="../images/member-icon-vacant.png" style="max-width:100%" /></div>

        <div style="clear:both"></div>

       <? if (trim($vDownLevel1['R']) != -1 && trim($vDownLevel1['R'] )!='') {?>	
        <div class="txt-mbr"><a href="<?='../memstock/registerst.php?uMemberId='.$vDownLevel1['R'].'&pos=L';?>">Daftarkan di sini</a></div>
        <? } ?>

      </div>          
      <? } ?>          
      </td>

    <td></td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td></td>



    

    <td colspan="3" valign="top" bgcolor="#fff" class="kotak-member">
<? 
			  if (trim($vDownLevel2R['R']) != -1 && trim($vDownLevel2R['R'] )!='') {
					   $vPaket=$oMember->getPaketID($vDownLevel2R['R']);
					   if ($vPaket=='S')
						   $vPackIcon='../images/gene-1-hu.png';
					   else 	  if ($vPaket=='G')
						   $vPackIcon='../images/gene-3-hu.png';
					   else 	  if ($vPaket=='P')
						   $vPackIcon='../images/gene-7-hu.png';
						   
					   $vSex=$oMember->getMemField('fsex',$vDownLevel2R['R']);
					   $vStatus = $oMember->getMemField('faktif',$vDownLevel2R['R']);
		
					   if ($vSex=='M') {
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-L-a.png';
						  elseif ($vStatus == '4')	 
							 $vMemIcon='../images/member-icon-L-t.png';
						  elseif ($vStatus  == '3')	 
							 $vMemIcon='../images/member-icon-L-f.png';
					   } else {	  
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-W-a.png';
						  elseif ($vStatus  == '4')	 
							 $vMemIcon='../images/member-icon-W-t.png';
						  elseif ($vStatus == '3')	 
							 $vMemIcon='../images/member-icon-W-f.png';
		
					   }
					   
						$vCountDownL=$oNetwork->getDownlineCountLR($vDownLevel2R['R'],'L');		      
						$vCountDownR=$oNetwork->getDownlineCountLR($vDownLevel2R['R'],'R');
               ?>
     <div>

     	<div class="icon-mbr">
        <a href="?menu=genealogi24&uTop=<?=$vDownLevel2R['R']?>&uMemberId=<?=$vRefUser?>&current=<?=$vCurrent?>&menu=<?=$vMenu?>">
        <img src="<?=$vMemIcon?>" style="max-width:100%" /></a></div>

     	<div class="icon-mbr-kecil"><img style="max-width:100%" src="<?=$vPackIcon?>" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><? echo $vDownLevel2R['R'];?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vDownLevel2R['R'])?></div>

        <div style="clear:both"></div>

     	<div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vDownLevel2R['R']))?></div>

      <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
            
			 echo number_format($vCountDownL,0,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?   echo number_format($vCountDownR,0,",",".");?>)</div>

           <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vDownLevel2R['R'],'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vDownLevel2R['R'],'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vDownLevel2R['R']);
			   echo $vSpon;
		  	   $vDownLevel3RR=$oNetwork->getDownlinePos($vDownLevel2R['R']);
		?></strong></div>

      </div>
 <? } else {?>
 
       <div>

        <div class="icon-mbr-kosong"><img src="../images/member-icon-vacant.png" style="max-width:100%" /></div>

        <div style="clear:both"></div>

        <? if (trim($vDownLevel1['R']) != -1 && trim($vDownLevel1['R'] )!='') {?>	
        <div class="txt-mbr"><a href="<?='../memstock/registerst.php?uMemberId='.$vDownLevel1['R'].'&pos=R';?>">Daftarkan di sini</a></div>
        <? } ?>

      </div>          
      <? } ?>         
      </td>

    <td></td>

  </tr>

  <tr>

    <td colspan="2" style="border-right:1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2" style="border-left:1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2" style="border-right:1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2" style="border-left:1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2" style="border-right:1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2" style="border-left:1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2" style="border-right:1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2" style="border-left:1px solid #000">&nbsp;</td>

  </tr>

  <tr>

   <td colspan="2" style="border-left: 1px solid #000; border-top: 1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2" style="border-right: 1px solid #000; border-top: 1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2" style="border-left: 1px solid #000; border-top: 1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2" style="border-right: 1px solid #000; border-top: 1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2" style="border-left: 1px solid #000; border-top: 1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2" style="border-right: 1px solid #000; border-top: 1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2" style="border-left: 1px solid #000; border-top: 1px solid #000">&nbsp;</td>

    <td>&nbsp;</td>

    <td colspan="2" style="border-right: 1px solid #000; border-top: 1px solid #000">&nbsp;</td>

  </tr>

  <tr>

    <td valign="top" bgcolor="#fff" class="kotak-member">
<? 
			  if (trim($vDownLevel3LL['L']) != -1 && trim($vDownLevel3LL['L'] )!='') {
					   $vPaket=$oMember->getPaketID($vDownLevel3LL['L']);
					   if ($vPaket=='S')
						   $vPackIcon='../images/gene-1-hu.png';
					   else 	  if ($vPaket=='G')
						   $vPackIcon='../images/gene-3-hu.png';
					   else 	  if ($vPaket=='P')
						   $vPackIcon='../images/gene-7-hu.png';
						   
					   $vSex=$oMember->getMemField('fsex',$vDownLevel3LL['L']);
					   $vStatus = $oMember->getMemField('faktif',$vDownLevel3LL['L']);
		
					   if ($vSex=='M') {
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-L-a.png';
						  elseif ($vStatus == '4')	 
							 $vMemIcon='../images/member-icon-L-t.png';
						  elseif ($vStatus  == '3')	 
							 $vMemIcon='../images/member-icon-L-f.png';
					   } else {	  
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-W-a.png';
						  elseif ($vStatus  == '4')	 
							 $vMemIcon='../images/member-icon-W-t.png';
						  elseif ($vStatus == '3')	 
							 $vMemIcon='../images/member-icon-W-f.png';
		
					   }
					   
						$vCountDownL=$oNetwork->getDownlineCountLR($vDownLevel3LL['L'],'L');		      
						$vCountDownR=$oNetwork->getDownlineCountLR($vDownLevel3LL['L'],'R');
               ?>
     <div>

     	<div class="icon-mbr"><img src="<?=$vMemIcon?>" style="max-width:100%" /></div>

<div class="icon-mbr-kecil"><img style="max-width:100%" src="<?=$vPackIcon?>" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><?
           echo $vDownLevel3LL['L'];
		?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vDownLevel3LL['L'])?></div>

        <div style="clear:both"></div>

     	<div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vDownLevel3LL['L']))?></div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
            
			 echo number_format($vCountDownL,0,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?   echo number_format($vCountDownR,0,",",".");?>)</div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3LL['L'],'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3LL['L'],'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vDownLevel3LL['L']);
			   echo $vSpon;
		  	  // $vDownLevel3LL=$oNetwork->getDownlinePos($vDownLevel2L['L']);
		?></strong></div>

      </div>
      <? } else {?>
 
       <div>

        <div class="icon-mbr-kosong"><img src="../images/member-icon-vacant.png" style="max-width:100%" /></div>

        <div style="clear:both"></div>

        <? if (trim($vDownLevel2L['L']) != -1 && trim($vDownLevel2L['L'] )!='') {?>	
        <div class="txt-mbr"><a href="<?='../memstock/registerst.php?uMemberId='.$vDownLevel2L['L'].'&pos=L';?>">Daftarkan di sini</a></div>
        <? } ?>

      </div>          
      <? } ?>
   
   
   </td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td valign="top" bgcolor="#fff" class="kotak-member">

     <? 
			  if (trim($vDownLevel3LL['R']) != -1 && trim($vDownLevel3LL['R'] )!='') {
					   $vPaket=$oMember->getPaketID($vDownLevel3LL['R']);
					   if ($vPaket=='S')
						   $vPackIcon='../images/gene-1-hu.png';
					   else 	  if ($vPaket=='G')
						   $vPackIcon='../images/gene-3-hu.png';
					   else 	  if ($vPaket=='P')
						   $vPackIcon='../images/gene-7-hu.png';
						   
					   $vSex=$oMember->getMemField('fsex',$vDownLevel3LL['R']);
					   $vStatus = $oMember->getMemField('faktif',$vDownLevel3LL['R']);
		
					   if ($vSex=='M') {
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-L-a.png';
						  elseif ($vStatus == '4')	 
							 $vMemIcon='../images/member-icon-L-t.png';
						  elseif ($vStatus  == '3')	 
							 $vMemIcon='../images/member-icon-L-f.png';
					   } else {	  
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-W-a.png';
						  elseif ($vStatus  == '4')	 
							 $vMemIcon='../images/member-icon-W-t.png';
						  elseif ($vStatus == '3')	 
							 $vMemIcon='../images/member-icon-W-f.png';
		
					   }
					   
						$vCountDownL=$oNetwork->getDownlineCountLR($vDownLevel3LL['R'],'L');		      
						$vCountDownR=$oNetwork->getDownlineCountLR($vDownLevel3LL['R'],'R');
               ?>
     <div>

     	<div class="icon-mbr"><img src="<?=$vMemIcon?>" style="max-width:100%" /></div>

<div class="icon-mbr-kecil"><img style="max-width:100%" src="<?=$vPackIcon?>" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><?
           echo $vDownLevel3LL['R'];
		?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vDownLevel3LL['R'])?></div>

        <div style="clear:both"></div>

     	<div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vDownLevel3LL['R']))?></div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
            
			 echo number_format($vCountDownL,0,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?   echo number_format($vCountDownR,0,",",".");?>)</div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3LL['R'],'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3LL['R'],'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vDownLevel3LL['R']);
			   echo $vSpon;
		  	   $vDownLevel3LL=$oNetwork->getDownlinePos($vDownLevel2L['L']);
		?></strong></div>

      </div>
      <? } else {?>
 
       <div>

        <div class="icon-mbr-kosong"><img src="../images/member-icon-vacant.png" style="max-width:100%" /></div>

        <div style="clear:both"></div>

          <? if (trim($vDownLevel2L['L']) != -1 && trim($vDownLevel2L['L'])!='') {?>	
        <div class="txt-mbr"><a href="<?='../memstock/registerst.php?uMemberId='.$vDownLevel2L['L'].'&pos=R';?>">Daftarkan di sini</a></div>
        <? } ?>

      </div>          
      <? } ?>
      </td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td valign="top" bgcolor="#fff" class="kotak-member">

  <? 
			  if (trim($vDownLevel3LR['L']) != -1 && trim($vDownLevel3LR['L'] )!='') {
					   $vPaket=$oMember->getPaketID($vDownLevel3LR['L']);
					   if ($vPaket=='S')
						   $vPackIcon='../images/gene-1-hu.png';
					   else 	  if ($vPaket=='G')
						   $vPackIcon='../images/gene-3-hu.png';
					   else 	  if ($vPaket=='P')
						   $vPackIcon='../images/gene-7-hu.png';
						   
					   $vSex=$oMember->getMemField('fsex',$vDownLevel3LR['L']);
					   $vStatus = $oMember->getMemField('faktif',$vDownLevel3LR['L']);
		
					   if ($vSex=='M') {
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-L-a.png';
						  elseif ($vStatus == '4')	 
							 $vMemIcon='../images/member-icon-L-t.png';
						  elseif ($vStatus  == '3')	 
							 $vMemIcon='../images/member-icon-L-f.png';
					   } else {	  
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-W-a.png';
						  elseif ($vStatus  == '4')	 
							 $vMemIcon='../images/member-icon-W-t.png';
						  elseif ($vStatus == '3')	 
							 $vMemIcon='../images/member-icon-W-f.png';
		
					   }
					   
						$vCountDownL=$oNetwork->getDownlineCountLR($vDownLevel3LR['L'],'L');		      
						$vCountDownR=$oNetwork->getDownlineCountLR($vDownLevel3LR['L'],'R');
               ?>
     <div>

     	<div class="icon-mbr"><img src="<?=$vMemIcon?>" style="max-width:100%" /></div>

<div class="icon-mbr-kecil"><img style="max-width:100%" src="<?=$vPackIcon?>" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><?
           echo $vDownLevel3LR['L'];
		?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vDownLevel3LR['L'])?></div>

        <div style="clear:both"></div>

     	<div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vDownLevel3LR['L']))?></div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
            
			 echo number_format($vCountDownL,0,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?   echo number_format($vCountDownR,0,",",".");?>)</div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3LR['L'],'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3LR['L'],'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vDownLevel3LR['L']);
			   echo $vSpon;
		  	  // $vDownLevel3LL=$oNetwork->getDownlinePos($vDownLevel2L['L']);
		?></strong></div>

      </div>
      <? } else {?>
 
       <div>

        <div class="icon-mbr-kosong"><img src="../images/member-icon-vacant.png" style="max-width:100%" /></div>

        <div style="clear:both"></div>

            <? if (trim($vDownLevel2L['R']) != -1 && trim($vDownLevel2L['R'])!='') {?>	
        <div class="txt-mbr"><a href="<?='../memstock/registerst.php?uMemberId='.$vDownLevel2L['R'].'&pos=L';?>">Daftarkan di sini</a></div>
        <? } ?>

      </div>          
      <? } ?>
      
      </td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td valign="top" bgcolor="#fff" class="kotak-member">

   
     <? 
			  if (trim($vDownLevel3LR['R']) != -1 && trim($vDownLevel3LR['R'] )!='') {
					   $vPaket=$oMember->getPaketID($vDownLevel3LR['R']);
					   if ($vPaket=='S')
						   $vPackIcon='../images/gene-1-hu.png';
					   else 	  if ($vPaket=='G')
						   $vPackIcon='../images/gene-3-hu.png';
					   else 	  if ($vPaket=='P')
						   $vPackIcon='../images/gene-7-hu.png';
						   
					   $vSex=$oMember->getMemField('fsex',$vDownLevel3LR['R']);
					   $vStatus = $oMember->getMemField('faktif',$vDownLevel3LR['R']);
		
					   if ($vSex=='M') {
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-L-a.png';
						  elseif ($vStatus == '4')	 
							 $vMemIcon='../images/member-icon-L-t.png';
						  elseif ($vStatus  == '3')	 
							 $vMemIcon='../images/member-icon-L-f.png';
					   } else {	  
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-W-a.png';
						  elseif ($vStatus  == '4')	 
							 $vMemIcon='../images/member-icon-W-t.png';
						  elseif ($vStatus == '3')	 
							 $vMemIcon='../images/member-icon-W-f.png';
		
					   }
					   
						$vCountDownL=$oNetwork->getDownlineCountLR($vDownLevel3LR['R'],'L');		      
						$vCountDownR=$oNetwork->getDownlineCountLR($vDownLevel3LR['R'],'R');
               ?>
     <div>

     	<div class="icon-mbr"><img src="<?=$vMemIcon?>" style="max-width:100%" /></div>

<div class="icon-mbr-kecil"><img style="max-width:100%" src="<?=$vPackIcon?>" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><?
           echo $vDownLevel3LR['R'];
		?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vDownLevel3LR['R'])?></div>

        <div style="clear:both"></div>

     	<div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vDownLevel3LR['R']))?></div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
            
			 echo number_format($vCountDownL,0,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?   echo number_format($vCountDownR,0,",",".");?>)</div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3LL['R'],'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3LR['R'],'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vDownLevel3LR['R']);
			   echo $vSpon;
		  	  // $vDownLevel3LL=$oNetwork->getDownlinePos($vDownLevel2L['L']);
		?></strong></div>

      </div>
      <? } else {?>
 
       <div>

        <div class="icon-mbr-kosong"><img src="../images/member-icon-vacant.png" style="max-width:100%" /></div>

        <div style="clear:both"></div>

        <? if (trim($vDownLevel2L['R']) != -1 && trim($vDownLevel2L['R'])!='') {?>	
        <div class="txt-mbr"><a href="<?='../memstock/registerst.php?uMemberId='.$vDownLevel2L['R'].'&pos=R';?>">Daftarkan di sini</a></div>
        <? } ?>

      </div>          
      <? } ?>
      
      </td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td valign="top" bgcolor="#fff" class="kotak-member">
<? 
			  if (trim($vDownLevel3RL['L']) != -1 && trim($vDownLevel3RL['L'] )!='') {
					   $vPaket=$oMember->getPaketID($vDownLevel3LL['L']);
					   if ($vPaket=='S')
						   $vPackIcon='../images/gene-1-hu.png';
					   else 	  if ($vPaket=='G')
						   $vPackIcon='../images/gene-3-hu.png';
					   else 	  if ($vPaket=='P')
						   $vPackIcon='../images/gene-7-hu.png';
						   
					   $vSex=$oMember->getMemField('fsex',$vDownLevel3RL['L']);
					   $vStatus = $oMember->getMemField('faktif',$vDownLevel3RL['L']);
		
					   if ($vSex=='M') {
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-L-a.png';
						  elseif ($vStatus == '4')	 
							 $vMemIcon='../images/member-icon-L-t.png';
						  elseif ($vStatus  == '3')	 
							 $vMemIcon='../images/member-icon-L-f.png';
					   } else {	  
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-W-a.png';
						  elseif ($vStatus  == '4')	 
							 $vMemIcon='../images/member-icon-W-t.png';
						  elseif ($vStatus == '3')	 
							 $vMemIcon='../images/member-icon-W-f.png';
		
					   }
					   
						$vCountDownL=$oNetwork->getDownlineCountLR($vDownLevel3RL['L'],'L');		      
						$vCountDownR=$oNetwork->getDownlineCountLR($vDownLevel3RL['L'],'R');
               ?>
     <div>

     	<div class="icon-mbr"><img src="<?=$vMemIcon?>" style="max-width:100%" /></div>

<div class="icon-mbr-kecil"><img style="max-width:100%" src="<?=$vPackIcon?>" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><?
           echo $vDownLevel3RL['L'];
		?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vDownLevel3RL['L'])?></div>

        <div style="clear:both"></div>

     	<div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vDownLevel3RL['L']))?></div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
            
			 echo number_format($vCountDownL,0,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?   echo number_format($vCountDownR,0,",",".");?>)</div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3RL['L'],'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3RL['L'],'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vDownLevel3RL['L']);
			   echo $vSpon;
		  	  // $vDownLevel3LL=$oNetwork->getDownlinePos($vDownLevel2L['L']);
		?></strong></div>

      </div>
      <? } else {?>
 
       <div>

        <div class="icon-mbr-kosong"><img src="../images/member-icon-vacant.png" style="max-width:100%" /></div>

        <div style="clear:both"></div>

        <? if (trim($vDownLevel2R['L']) != -1 && trim($vDownLevel2R['L'])!='') {?>	
        <div class="txt-mbr"><a href="<?='../memstock/registerst.php?uMemberId='.$vDownLevel2R['L'].'&pos=L';?>">Daftarkan di sini</a></div>
        <? } ?>

      </div>          
      <? } ?>
   

</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td valign="top" bgcolor="#fff" class="kotak-member">

     <? 
			  if (trim($vDownLevel3RL['R']) != -1 && trim($vDownLevel3RL['R'] )!='') {
					   $vPaket=$oMember->getPaketID($vDownLevel3RL['R']);
					   if ($vPaket=='S')
						   $vPackIcon='../images/gene-1-hu.png';
					   else 	  if ($vPaket=='G')
						   $vPackIcon='../images/gene-3-hu.png';
					   else 	  if ($vPaket=='P')
						   $vPackIcon='../images/gene-7-hu.png';
						   
					   $vSex=$oMember->getMemField('fsex',$vDownLevel3RL['R']);
					   $vStatus = $oMember->getMemField('faktif',$vDownLevel3RL['R']);
		
					   if ($vSex=='M') {
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-L-a.png';
						  elseif ($vStatus == '4')	 
							 $vMemIcon='../images/member-icon-L-t.png';
						  elseif ($vStatus  == '3')	 
							 $vMemIcon='../images/member-icon-L-f.png';
					   } else {	  
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-W-a.png';
						  elseif ($vStatus  == '4')	 
							 $vMemIcon='../images/member-icon-W-t.png';
						  elseif ($vStatus == '3')	 
							 $vMemIcon='../images/member-icon-W-f.png';
		
					   }
					   
						$vCountDownL=$oNetwork->getDownlineCountLR($vDownLevel3RL['R'],'L');		      
						$vCountDownR=$oNetwork->getDownlineCountLR($vDownLevel3RL['R'],'R');
               ?>
     <div>

     	<div class="icon-mbr"><img src="<?=$vMemIcon?>" style="max-width:100%" /></div>

<div class="icon-mbr-kecil"><img style="max-width:100%" src="<?=$vPackIcon?>" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><?
           echo $vDownLevel3RL['R'];
		?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vDownLevel3RL['R'])?></div>

        <div style="clear:both"></div>

     	<div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vDownLevel3RL['R']))?></div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
            
			 echo number_format($vCountDownL,0,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?   echo number_format($vCountDownR,0,",",".");?>)</div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3RL['R'],'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3RL['R'],'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vDownLevel3RL['R']);
			   echo $vSpon;
		  	  // $vDownLevel3LL=$oNetwork->getDownlinePos($vDownLevel2L['L']);
		?></strong></div>

      </div>
      <? } else {?>
 
       <div>

        <div class="icon-mbr-kosong"><img src="../images/member-icon-vacant.png" style="max-width:100%" /></div>

        <div style="clear:both"></div>

       <? if (trim($vDownLevel2R['L']) != -1 && trim($vDownLevel2R['L'])!='') {?>	
        <div class="txt-mbr"><a href="<?='../memstock/registerst.php?uMemberId='.$vDownLevel2R['L'].'&pos=R';?>">Daftarkan di sini</a></div>
        <? } ?>


      </div>          
      <? } ?>
    </td>
 <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>
    
    <td valign="top" bgcolor="#fff" class="kotak-member">
<? 
			  if (trim($vDownLevel3RR['L']) != -1 && trim($vDownLevel3RR['L'] )!='') {
					   $vPaket=$oMember->getPaketID($vDownLevel3RR['L']);
					   if ($vPaket=='S')
						   $vPackIcon='../images/gene-1-hu.png';
					   else 	  if ($vPaket=='G')
						   $vPackIcon='../images/gene-3-hu.png';
					   else 	  if ($vPaket=='P')
						   $vPackIcon='../images/gene-7-hu.png';
						   
					   $vSex=$oMember->getMemField('fsex',$vDownLevel3RR['L']);
					   $vStatus = $oMember->getMemField('faktif',$vDownLevel3RR['L']);
		
					   if ($vSex=='M') {
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-L-a.png';
						  elseif ($vStatus == '4')	 
							 $vMemIcon='../images/member-icon-L-t.png';
						  elseif ($vStatus  == '3')	 
							 $vMemIcon='../images/member-icon-L-f.png';
					   } else {	  
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-W-a.png';
						  elseif ($vStatus  == '4')	 
							 $vMemIcon='../images/member-icon-W-t.png';
						  elseif ($vStatus == '3')	 
							 $vMemIcon='../images/member-icon-W-f.png';
		
					   }
					   
						$vCountDownL=$oNetwork->getDownlineCountLR($vDownLevel3RR['L'],'L');		      
						$vCountDownR=$oNetwork->getDownlineCountLR($vDownLevel3RR['L'],'R');
               ?>
     <div>

     	<div class="icon-mbr"><img src="<?=$vMemIcon?>" style="max-width:100%" /></div>

<div class="icon-mbr-kecil"><img style="max-width:100%" src="<?=$vPackIcon?>" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><?
           echo $vDownLevel3RR['L'];
		?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vDownLevel3RR['L'])?></div>

        <div style="clear:both"></div>

     	<div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vDownLevel3RR['L']))?></div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
            
			 echo number_format($vDownLevel3RR,0,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?   echo number_format($vDownLevel3RR,0,",",".");?>)</div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3RR['L'],'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3RR['L'],'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vDownLevel3RR['L']);
			   echo $vSpon;
		  	  // $vDownLevel3LL=$oNetwork->getDownlinePos($vDownLevel2L['L']);
		?></strong></div>

      </div>
      <? } else {?>
 
       <div>

        <div class="icon-mbr-kosong"><img src="../images/member-icon-vacant.png" style="max-width:100%" /></div>

        <div style="clear:both"></div>

        <? if (trim($vDownLevel2R['R']) != -1 && trim($vDownLevel2R['R'])!='') {?>	
        <div class="txt-mbr"><a href="<?='../memstock/registerst.php?uMemberId='.$vDownLevel2R['R'].'&pos=L';?>">Daftarkan di sini</a></div>
        <? } ?>


      </div>          
      <? } ?>
    
    </td>
      
      <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>
   <td valign="top" bgcolor="#fff" class="kotak-member">

      <? 
			  if (trim($vDownLevel3RR['R']) != -1 && trim($vDownLevel3RR['R'] )!='') {
					   $vPaket=$oMember->getPaketID($vDownLevel3RR['R']);
					   if ($vPaket=='S')
						   $vPackIcon='../images/gene-1-hu.png';
					   else 	  if ($vPaket=='G')
						   $vPackIcon='../images/gene-3-hu.png';
					   else 	  if ($vPaket=='P')
						   $vPackIcon='../images/gene-7-hu.png';
						   
					   $vSex=$oMember->getMemField('fsex',$vDownLevel3RR['R']);
					   $vStatus = $oMember->getMemField('faktif',$vDownLevel3RR['R']);
		
					   if ($vSex=='M') {
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-L-a.png';
						  elseif ($vStatus == '4')	 
							 $vMemIcon='../images/member-icon-L-t.png';
						  elseif ($vStatus  == '3')	 
							 $vMemIcon='../images/member-icon-L-f.png';
					   } else {	  
						  if ($vStatus  == '1')
							 $vMemIcon='../images/member-icon-W-a.png';
						  elseif ($vStatus  == '4')	 
							 $vMemIcon='../images/member-icon-W-t.png';
						  elseif ($vStatus == '3')	 
							 $vMemIcon='../images/member-icon-W-f.png';
		
					   }
					   
						$vCountDownL=$oNetwork->getDownlineCountLR($vDownLevel3RR['R'],'L');		      
						$vCountDownR=$oNetwork->getDownlineCountLR($vDownLevel3RR['R'],'R');
               ?>
     <div>

     	<div class="icon-mbr"><img src="<?=$vMemIcon?>" style="max-width:100%" /></div>

<div class="icon-mbr-kecil"><img style="max-width:100%" src="<?=$vPackIcon?>" /></div>

        <div style="clear:both"></div>

        <div class="txt-mbr"><strong><?
           echo $vDownLevel3RR['R'];
		?></strong></div>

        <div class="txt-mbr"><?=$oMember->getMemberName($vDownLevel3RR['R'])?></div>

        <div style="clear:both"></div>

     	<div class="txt-mbr">Join : <?=$oPhpdate->YMD2DMY($oMember->getMemField('ftglaktif',$vDownLevel3RR['R']))?></div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
            
			 echo number_format($vDownLevel3RR,0,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?   echo number_format($vDownLevel3RR,0,",",".");?>)</div>

        <div style="clear:both"></div>

        <div style="float:left; width:47%; text-align:right">(<?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3RR['R'],'L');
			   echo number_format($vPR,1,",",".");
		?></div>

        <div style="float:left; width:6%; text-align:center;"><strong>|</strong></div>

        <div style="float:left; width:47%;"><?
              $vPR = $oKomisi->getPoinRwd($vDownLevel3RR['R'],'R');
			   echo number_format($vPR,1,",",".");
		?>)</div>

        <div style="clear:both"></div>

        <div class="txt-mbr">Sponsor: <strong><?
               $vSpon=$oNetwork->getSponsor($vDownLevel3RR['R']);
			   echo $vSpon;
		  	   $vDownLevel3LL=$oNetwork->getDownlinePos($vDownLevel2L['L']);
		?></strong></div>

      </div>
      <? } else {?>
 
       <div>

        <div class="icon-mbr-kosong"><img src="../images/member-icon-vacant.png" style="max-width:100%" /></div>

        <div style="clear:both"></div>

        <? if (trim($vDownLevel2R['R']) != -1 && trim($vDownLevel2R['R'])!='') {?>	
        <div class="txt-mbr"><a href="<?='../memstock/registerst.php?uMemberId='.$vDownLevel2R['R'].'&pos=R';?>">Daftarkan di sini</a></div>
        <? } ?>

      </div>          
      <? } ?>
     </td> 
  </tr>

  <tr>

    <td valign="top" ><div align="center">
	<? 
	$vDownLevel4=$oNetwork->getDownlinePos($vDownLevel3LL['L']);
	if (count($vDownLevel4)>0) {?>
	<a href="?menu=genealogi24&uTop=<?=$vDownLevel3LL['L']?>&uMemberId=<?=$vRefUser?>&current=<?=$vCurrent?>&menu=<?=$vMenu?>" >
	<img src="../images/triangledown.png" width="28"  border="0">	</a>
	<? } ?></div></td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td valign="top" ><div align="center"><? 
	$vDownLevel4=$oNetwork->getDownlinePos($vDownLevel3LL['R']);
	if (count($vDownLevel4)>0) {?>
	<a href="?menu=genealogi24&uTop=<?=$vDownLevel3LL['R']?>&uMemberId=<?=$vRefUser?>&current=<?=$vCurrent?>&menu=<?=$vMenu?>" >
	<img src="../images/triangledown.png" width="28"  border="0">	</a>
	<? } ?></div></td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td valign="top" ><div align="center"><? 
	$vDownLevel4=$oNetwork->getDownlinePos($vDownLevel3LR['L']);
	if (count($vDownLevel4)>0) {?>
	<a href="?menu=genealogi24&uTop=<?=$vDownLevel3LR['L']?>&uMemberId=<?=$vRefUser?>&current=<?=$vCurrent?>&menu=<?=$vMenu?>" >
	<img src="../images/triangledown.png" width="28"  border="0">	</a>
	<? } ?></div></td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td valign="top" ><div align="center"><? 
	$vDownLevel4=$oNetwork->getDownlinePos($vDownLevel3LR['R']);
	if (count($vDownLevel4)>0) {?>
	<a href="?menu=genealogi24&uTop=<?=$vDownLevel3LR['R']?>&uMemberId=<?=$vRefUser?>&current=<?=$vCurrent?>&menu=<?=$vMenu?>" >
	<img src="../images/triangledown.png" width="28"  border="0">	</a>
	<? } ?> </div></td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td valign="top" ><div align="center">
<? 
	$vDownLevel4=$oNetwork->getDownlinePos($vDownLevel3RL['L']);
	if (count($vDownLevel4)>0) {?>
	<a href="?menu=genealogi24&uTop=<?=$vDownLevel3RL['L']?>&uMemberId=<?=$vRefUser?>&current=<?=$vCurrent?>&menu=<?=$vMenu?>" >
	<img src="../images/triangledown.png" width="28"  border="0">	</a>
	<? } ?>    
    
    </div></td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td valign="top" ><div align="center">
<? 
	$vDownLevel4=$oNetwork->getDownlinePos($vDownLevel3RL['R']);
	if (count($vDownLevel4)>0) {?>
	<a href="?menu=genealogi24&uTop=<?=$vDownLevel3RL['R']?>&uMemberId=<?=$vRefUser?>&current=<?=$vCurrent?>&menu=<?=$vMenu?>" >
	<img src="../images/triangledown.png" width="28"  border="0">	</a>
	<? } ?>    
    </div></td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td valign="top" ><div align="center">
    <? 
	$vDownLevel4=$oNetwork->getDownlinePos($$vDownLevel3RR['L']);
	if (count($vDownLevel4)>0) {?>
	<a href="?menu=genealogi24&uTop=<?=$$vDownLevel3RR['L']?>&uMemberId=<?=$vRefUser?>&current=<?=$vCurrent?>&menu=<?=$vMenu?>" >
	<img src="../images/triangledown.png" width="28"  border="0">	</a>
	<? } ?>
    </div></td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td valign="top" ><div align="center">
    <? 
	$vDownLevel4=$oNetwork->getDownlinePos($$vDownLevel3RR['R']);
	if (count($vDownLevel4)>0) {?>
	<a href="?menu=genealogi24&uTop=<?=$$vDownLevel3RR['R']?>&uMemberId=<?=$vRefUser?>&current=<?=$vCurrent?>&menu=<?=$vMenu?>" >
	<img src="../images/triangledown.png" width="28"  border="0">	</a>
	<? } ?>
    </div></td>

  </tr>

</table>
</div>
<p><img src="../images/Keterangan-Gambar.jpg" /></p>

</div>
	<!-- end page container -->
	

<? if ($_GET['op'] != '') 
	 include_once("../framework/admin_footside.blade.php") ; 
else	
     include_once("../framework/member_footside.blade.php") ; 
?>