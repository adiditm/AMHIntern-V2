<? include_once("../framework/admin_headside.blade.php")?>
<?
  $_SESSION['lang']='id';
  $vRefer=$_SERVER['HTTP_REFERER'];
   $vID=$_GET['uID'];
   $vType=$_GET['type'];
   
  if ($vPriv=='sponsor')
     $vJenis = 'sponsor';
 else if ($vPriv=='korwil')
     $vJenis = 'korwil';
 else $vJenis='';	
   
    $vSQL="select * from m_tour where fidtour='$vID'";
   $db->query($vSQL);
  // $vBonusReg=$oRules->getSettingByCol('fbnsumrreg');
   while ($db->next_record()) {
      $vDesc=$db->f("fdesc");
	  $vPaket=$db->f("fpaket");
	  
	  $vHarga=$db->f("fhargapub");
	  $vKetPaket=$db->f("fketpaket");
	 // $vHargaNTA=$db->f("fhargapub")-$vBonusReg;;
	  $vCurr = $db->f("fcurrsym");
	  if ($db->f("fimage")=='') { 
	      $theImage='noimage-flat.jpg';
	      $vImage="../images/".$theImage;
	  } else { 
	      $theImage =$db->f("fimage");
		  $vImage="../images/user/".$theImage;
	  }
	  
	  
	  
	  $vOverv=$oInterface->getOvervLang($vID,$_SESSION['lang']);
	  $vDetail=$oInterface->getDetailLang($vID,$_SESSION['lang']);
	 
	  $vGmap=$db->f("fgmap");
 }


?>
	<div class="right_col" role="main">



  

  

  <div><label><h3>Detail <?=$vType=='UM'?'Umroh':'Tour';?> </h3></label></div>
<br>

		
	
         
  

   	<div class="col-md-12">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1default" data-toggle="tab"><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Detail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label></a></li>
                            <li class="hide"><a href="#tab2default" data-toggle="tab">Default 2</a></li>
                
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab1default">
<div id="packagedtl" class="isiTabs" style="width:100%;padding-right:10px;padding-left:10px;background-color:#FF9;border-radius:5px">
  <form method="post" action="savedoc.php" name="frmItiner" id="frmItiner">
    <input type="hidden" name="hItiner" id="hItiner" />
    <input type="hidden" name="hIDT" id="hIDT" />
    <div id="divItiner">
    <strong style="color:#00F"><?=$vDesc?></strong><br /><br />
     <? 
	 
	 if ($theImage!='noimage-flat.jpg') { ?>
     <img src="<?=$vImage?>" align="left" vspace="2" hspace="10" border="1" height="150" width="200" />     
     <? } ?>
  <?=stripslashes($vDetail)?>
  <br />
  </div>
  </form>
  
  <div align="left">
 <!-- <input type="button" value="Save Docs" onclick="document.frmItiner.hItiner.value=document.frmItiner.divItiner.innerHTML;document.frmItiner.submit();//document.location.href='savedoc.php?uID=<?=$vID?>'" /></div>-->
  <input class="btn btn-sm  btn-default" type="button" value="&laquo; Kembali" onclick="document.location.href='<?=$_SERVER['HTTP_REFERER']?>'" />
 
  <input class="btn btn-sm btn-info" type="button" value="Save Docs" onclick="document.getElementById('hItiner').value=document.getElementById('divItiner').innerHTML;document.getElementById('hIDT').value='<?=$vID?>';document.getElementById('frmItiner').submit();" />
  <? if ($vPriv=='administrator') { ?>
  <input class="btn btn-sm  btn-success" type="button" value="Booking" onclick="document.location.href='../manager/register.php?op=&current=mdm_memnet&menu=mdm_memnet_profile'" />
  <? } else  if($vJenis=='sponsor') { ?>
  <input class="btn btn-sm  btn-success" type="button" value="Booking" onclick="document.location.href='../manager/register.php?op=&current=mdm_pebisnis&menu=mdm_spon_regjamaah'" />  
  
  <? } else {?>
  
   <input class="btn btn-sm  btn-success" type="button" value="Booking" onclick="document.location.href='../manager/register.php?op=&current=mdm_korwil_sub&menu=mdm_korwil_subjamaah'" />  
  
  <? } ?>
  </div>
		</div>                        
                        </div>
                        <div class="tab-pane fade" id="tab2default hide">Default 2</div>
  
                    </div>
                </div>
            </div>
      </div>





  </div>
		<? include_once("../framework/member_footside.blade.php") ; ?>