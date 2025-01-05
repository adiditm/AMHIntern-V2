<?php
header('Content-type: application/json');
   include_once("../server/config.php");
   include_once("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once(CLASS_DIR."ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."systemclass.php");
   include_once(CLASS_DIR."productclass.php");
   include_once(CLASS_DIR."texttoimageclass.php");
  
  if ($_GET['id']=='#') {
	  $vTop=$_GET['top'];

		$vName=$oMember->getMemberName($vTop);
		$vPack=$oMember->getPaket($vTop);
		$vLevel=$oMember->getMemField('flevel',$vTop);  

	  //  $vOmzetPriv=$oKomisi->getOmzetROMonthMember($vTop,date('m'),date('Y'));
	   // $vOmzetPriv+=$oKomisi->getOmzetROMonthMemberWallet($vTop,date('m'),date('Y'));
	//	$vOmzetPrivF=number_format($vOmzetPriv,0,",",".");
		
		$vTitle="$vName";
		$vTitle=str_replace(" ","&nbsp;",$vTitle);
	  
	  $vTopt='<a title='.$vTitle.'>'.$vTop.' ('.$vTitle.')</a>';
	  $vSponTree='[{"id":1,"text":"<b>'.$vTopt.'</b>","children":[';
	  $vOut='';
	  
	  $vAllSpon=$oNetwork->getSponsorship($vTop,$vOut);
	  $i=0;
	  while (list($key,$val)=each($vOut)) {
	      if ($oNetwork->hasSponsorship($val)) {
	         $vHasChild='true';
	         $vIcon="jstree-folder";
	      } else  { 
	         $vHasChild='false';
	         $vIcon="jstree-file";
	      
	      }
		$vName=$oMember->getMemberName($val);
		$vPack=$oMember->getPaket($val);
		$vLevel=$oMember->getMemField('flevel',$val);  
	//    $vOmzetPriv=$oKomisi->getOmzetROMonthMember($val,date('m'),date('Y'));
	//    $vOmzetPriv+=$oKomisi->getOmzetROMonthMemberWallet($val,date('m'),date('Y'));
	//	$vOmzetPrivF=number_format($vOmzetPriv,0,",",".");
		
		$vTitle="$vName";
		//$vTitle="$vName | Paket: $vPack | Peringkat: $vLevel";
		 $vTitle=str_replace(" ","&nbsp;",$vTitle); 
	     $valt='<a title='.$vTitle.'>'.$val.' ('.$vTitle.')</a>';
		  if ($i==0)
		     $vSponTree.='{"id":"'.$val.'","text":"'.$valt.'","children":'.$vHasChild.',"icon": "'.$vIcon.'"}';
		  else  $vSponTree.=',{"id":"'.$val.'","text":"'.$valt.'","children":'.$vHasChild.',"icon": "'.$vIcon.'"}'; 
	  $i++;
	  }
	  $vSponTree.=']}]';
	  
	  echo $vSponTree;
  } else { 
      $vDown=$_GET['id'];
      $vOut = '';
      $oNetwork->getSponsorship($vDown,$vOut);
   //   print_r($vOut);
      $vChild= '[';
      $i=0;
      while (list($key,$val)=each($vOut)) {
         
	      if ($oNetwork->hasSponsorship($val)) {
	         $vHasChild='true';
	         $vIcon="jstree-folder";
	      } else  { 
	         $vHasChild='false';
	         $vIcon="jstree-file";
	      
	      }
		$vName=$oMember->getMemberName($val);
		$vPack=$oMember->getPaket($val);
		$vLevel=$oMember->getMemField('flevel',$val);  
	   // $vOmzetPriv=$oKomisi->getOmzetROMonthMember($val,date('m'),date('Y'));
	 //   $vOmzetPriv+=$oKomisi->getOmzetROMonthMemberWallet($val,date('m'),date('Y'));
	//	$vOmzetPrivF=number_format($vOmzetPriv,0,",",".");
		
		$vTitle="$vName";
		//$vTitle="$vName | Paket: $vPack | Peringkat: $vLevel";
		$vTitle=str_replace(" ","&nbsp;",$vTitle);
		$valt='<a title='.$vTitle.'>'.$val.' ('.$vTitle.')</a>';
         if ($i==0)
            $vChild.='{"id":"'.$val.'","text":"'.$valt.'","children":'.$vHasChild.',"icon": "'.$vIcon.'"}';
         else   $vChild.= ',{"id":"'.$val.'","text":"'.$valt.'","children":'.$vHasChild.',"icon": "'.$vIcon.'"}';         
         $i++;
      }
      $vChild.=']';
      
      echo $vChild;
  
  }
  
?>