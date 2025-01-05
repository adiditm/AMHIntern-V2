<?

   include_once("config.php");
   include_once("phplib.php");
   
   include_once(CLASS_DIR."memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once(CLASS_DIR."networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once(CLASS_DIR."ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."productclass.php");
   
   $vPack='1';
   $vCnt=$_POST['lmCnt'];
   $vKota=$_POST['lmCity'];
   $vNama=$_POST['tfNama'];
   $vCanGo=$_GET['can2'];
   
   
   if ($vPack==1)	   
       $vPackDesc=$oInterface->getCaptionLang("front_capregular",$_SESSION['lang']);
   if ($vInt=="") $vPackDesc="";
   

   if (trim($vPack!=""))
      $vAnd.=" and fpaket=$vPack ";


   if (trim($vKota!=""))
      $vAnd.=" and farea=$vKota ";  
      
   if (trim($vCnt!=""))
      $vAnd.=" and fcountry='$vCnt' ";  

   if (trim($vNama!=""))
      $vAnd.=" and (fdesc like '%$vNama%') ";  
      
     


   if (trim($vCanGo=="1")) {
      $vAnd.=" and fcango='1'";
      $vCan=" <strong>2 Can Go</strong>";
   }   


   if (trim($vCnt!="")) {
      if (trim($vCnt=="SMT"))  
	     $vAnd.=" and (fcountry='SG' or fcountry='MY' or fcountry='TH') ";
	  else
	     $vAnd.="and fcountry='$vCnt'";	 
   }	  


   
    $vSQL="select * from m_tour where fstatusrow=1 and fgroup='t' and date(fexpired) > date(now()) $vAnd";
   $db->query($vSQL);
   
   $curpage=$_POST['hPageNum'];
   if ($curpage=="" || $_POST['hBtn']=="cari") {
      $curpage="1";
   }
	
   $rows=$db->num_rows();
   $jml=$rows;
   $rowpage=10;
   $curpage=$curpage-1;
   $offset=$curpage * $rowpage;
   $vClear="";	
   $pagenum=ceil($rows/$rowpage);
       if ($vScript=='loggedin.php') {
		  $vDetLink="?tack=tourdet&type=TD";
		  $vClear="?tack=tour";
	   } else  if ($vScript=='index.php') {
		  $vDetLink="?tick=tourdet&type=TD";
		  $vClear="?tick=tour";
	   }		
	   
   

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Voucher</title>
<link rel="stylesheet" type="text/css" href="css/mdm.css" />
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
.style2 {color: #999999}
-->

 .glow:hover {
   margin: auto;
   width: auto;
   height: 105px;
  padding-top:4px;
   vertical-align:middle;
   
   background-color: #FC0;
   -webkit-border-radius: 10px;
 -moz-border-radius: 10px;
 border-radius: 10px;
 }
 
 .glow {
   margin: auto;
   width: auto;
   height: 105px;
   padding-top:4px;
   vertical-align:middle;
   
   background-color: #FFF;
   -webkit-border-radius: 10px;
 -moz-border-radius: 10px;
 border-radius: 10px;
 }

</style>
</head>

<body>
<script>
   function changePage(pMenu) {
     document.demoform.hPageNum.value=pMenu.value;
	 doSubmit("refresh");
   }
   function doSubmit(btn) {
      document.demoform.hBtn.value=btn;
	  if (btn=="refresh")
	     document.getElementById("ref").value="posting";
	  else if (btn=="cari")
	     document.getElementById("ref").value="posting";
	  document.demoform.submit();
   }

</script>
<form name="demoform" method="post" >
   <div id="lySearch">
   <img style="cursor:pointer" onclick="closeSearch()" src="images/close.png" alt="Close" width="12" height="12" align="right" />
    <table class="tbsearch"  style="font-family:Tahoma;border:none;border-color:#6666FF;padding:5px 5px 5px 5px" width="255" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="left"><strong>Negara :</strong> <br />
            <select onchange="changeKota(this.value)" name="lmCnt" id="lmCnt" style="width:220px;background-color:#FC9">
              <option value="">---Choose/Pilih---</option>
              <?
			     $vSQL = "select * from m_country where faktif=1 and fproduk <> 'PKO' order by fname ";
				 $db->query($vSQL);
				 while ($db->next_record()) {
				  $vCode=$db->f("fiso");
				  $vName=$db->f("fprintname");    
			  ?>
              <option value="<?=$vCode?>" <? if ($vCode==$_POST['lmCnt']) echo "selected";?>>
                <?=$vName?>
                </option>
              <? } ?>
            </select>
          </div></td>
        </tr>
        <tr>
          <td><div align="left"><strong>Kota :</strong>  <br />
            <select name="lmCity" id="lmCity" style="width:220px;background-color:#FC9">
              <option value="">---Choose/Pilih---</option>
              <?
			     $vSQL = "select * from m_kotav where faktif=1  order by fnamakota ";
				 $db->query($vSQL);
				 while ($db->next_record()) {
				  $vCode=$db->f("fidsys");
				  $vName=$db->f("fnamakota");    
			  ?>
              <option value="<?=$vCode?>" <? if ($vCode==$vCity) echo "selected";?>>
                <?=$vName?>
                </option>
              <? } ?>
            </select>
          </div></td>
        </tr>
        <tr>
          <td><div align="left"><strong>Kata Kunci :</strong> <br />
            <input  name="tfNama" id="tfNama" style="width:210px;background-color:#FC9" value="<?=($_POST['tfNama'])?>" size="28" /> </div></td>
        </tr>
        <tr>
          <td height="41"><div align="center">
              <input class="rounded-corners" name="btCheckHrg" type="button" id="btCheckHrg" style="background-color:#F96;color:#FFFFFF;height:27px;border:1px solid;border-color:#999;border-radius: 5px;" value="Search" onclick="demoform.submit()" />
             &nbsp; <input  class="rounded-cornersx" name="btCheckHrg2" type="button" id="btCheckHrg2" style="border-radius: 5px;;background-color:#F96;color:#FFFFFF;height:27px;border:1px solid;border-color:#999" value="Clear Search" onclick="yhRef('<?=$vClear?>')" />
          </div></td>
        </tr>
		<tr>
		  <td style="height: 29px">
		    </td>
        </tr>
        
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        </table>
      </div>
      <!-- 
      </form>

<form name="demoform" id="demoform" method="post">  -->
<? if ($vCanGo!='1') {?>
<div align="right" style="cursor:pointer;margin-right:8px;background-color:#FF6600" onclick="$('#lySearch').slideToggle();"><img src="images/search.gif" width="24" height="24" alt="search" />Search Tour</div><br>
<? } ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:-10px;margin-left:-10px;font-family:Tahoma, Verdana;font-weight:bold">
  <tr >
    <td >
      <div align="left" class="navinfo">
      <?
      if ($vuMenu1=='') { //menu biasa
	     $vMenu=$oInterface->getMenuHeader($vuMenu);
		 if ($vMenu=='') $vMenu = ucwords($vuMenu);
		 echo "Booking >> Tour Domestik (Trial)";
	  } else if ($vuMenu1=='news' && $vJenis) { //menu news
	     echo "Info Wisata >> ".$oInterface->getNewsHeader($vIdNews);
	  }
	?>
    
      </div>
      
      
      
      </td>
     
  </tr>
   <? if ($_SERVER['SCRIPT_NAME']=='/loggedin.php') { ?>
   <tr>
     <td style="color:#00F;font-size:12px;padding-left:10px;padding-top:10px"><? //strip_tags($oInterface->getKetTRX("tour"))?></td></tr>
  <tr>
  <? } ?>
   <tr>
     <td style="color:#00F;font-size:12px;padding-left:10px;padding-top:10px">

<? if ($_POST['lmCnt']!="" || $_POST['lmCity']!="" || $_POST['tfNama']!="") { ?>
<table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-weight:normal;color:#0000FF">
        <tr>
          <td colspan="2"><strong>Pencarian berdasarkan / Searching based on : </strong></td>
          </tr>
        <? if ($_POST['lmCnt']!="") {?>
        <tr>
          <td style="height: 20px"><div align="left">Negara/Country</div></td>
          <td style="height: 20px"><div align="left">: 
            <?=$oInterface->getCountry($_POST['lmCnt'])?>
            </div></td>
          </tr>
        <? } ?>
        <? if ($_POST['lmCity']!="") {?>
        <tr>
          <td style="height: 20px"><div align="left">Kota/City</div></td>
          <td style="height: 20px"><div align="left">: 
            <?=$oInterface->getCityV($_POST['lmCity'])?>
            </div></td>
          </tr>
        <? } ?>

        <? if ($_POST['tfNama']!="") {?>
        <tr>
          <td><div align="left">Kata Kunci</div></td>
          <td><div align="left">: 
            <?=$_POST['tfNama']?>
            </div></td>
          </tr>
        <? } ?>

               
        </table>
     <? } ?>
     </td></tr>
 
   <td ><div align="right"> <br />
     <?=$rows?> record(s), 
     <input name="hPageNum" type="hidden" id="hPageNum" />
      <input name="hPage" type="hidden" id="hPage" value="<?=$curpage?>" />
      <input name="hBtn" type="hidden" id="hBtn">
      <input name="ref" type="hidden" id="ref" >
      Halaman :
      <select style="font-weight:bold;" name="select3" id="select3" onchange="changePage(this)">
        <? for ($i=0;$i<$pagenum;$i++) {?>
        <option value="<?=$i+1 ?>" <? if ($curpage==($i)) echo "selected";?>>&nbsp;
          <?=$i+1?>
          &nbsp;</option>
        <? } ?>
      </select>
      dari 
      <?=$pagenum?>
      <br />  <br /> 
      </strong></div></td>
  </tr>
</table>

<?
  $vSQL="select * from m_tour where fstatusrow=1 and fgroup='t' and date(fexpired) > date(now()) $vAnd order by fcountry";
  $vSQL.=" limit  $offset, $rowpage ";
  $db->query($vSQL);
  $vNumRows=$db->num_rows();
  while ($db->next_record()) {
     $vStar=$db->f('fstar');
	 $vHarga=$db->f('fharga');
	 $vImage=$db->f('fimage');
	 $vID=$db->f('fidtour');
	 if (trim($vImage)=="" || trim($vImage)=="0")
	    $vImage="noimage-flat.jpg";
	 
?>
<div>
<table width="99%" cellpadding="0" cellspacing="1" style="border:1px dotted;border-color:#999999;border-collapse:collapse"> 
    <?
  $vSQL="select * from m_tour where fstatusrow=1  and fgroup='d' AND date(fexpired) > date(now()) $vAnd order by fcountry";
  $vSQL.=" limit  $offset, $rowpage ";
  $db->query($vSQL);
  $vNumRows=$db->num_rows();
  	$vCount=0;$vCol=2;
  while ($db->next_record()) {
     $vArea=$db->f('farea');
	 $vHarga=$db->f('fharga');
	 $vImage=$db->f('fimage');
	 $vID=$db->f('fidtour');
	 $vDesc=$db->f('fdesc');
	 $vDet=$db->f('fdetail');
	 $vKotaData=$oInterface->getKota($vArea);
	 
	 if (trim($vImage)=="" || trim($vImage)=="0")
	    $vImage="noimage-flat.jpg";
		
		if (fmod($vCount,$vCol)==0) {   
	?>
	<tr>
	<? } ?>
	  <td  width="50%" style="padding-bottom:10px;padding-left:10px;border-bottom:1px dotted #CCC;border-right:1px dotted #CCC;border-collapse:collapse" valign="top">
	    <div align="left">
        <a href="<?="$vDetLink&uID=$vID";?>" style="text-decoration:none;color:#000"><strong><?=$vDesc?>&nbsp;::&nbsp;<span style="color:#F60"><?=$vKotaData?></span></strong></a><br /><br />
        <? if ($vImage!='noimage-flat.jpg') { ?>
        <a href="<?="$vDetLink&uID=$vID";?>"><img align="left" hspace="5" vspace="4"  border="1" src="images/user/<?=$vImage?>" width="150" height="100"></a>
        <? } else {?>
		<a href="<?="$vDetLink&uID=$vID";?>"><img align="left" vspace="4" hspace="5"  border="1" src="images/<?=$vImage?>" width="150" height="100">  </a>
		<? } ?>
 
        <?
            $vContent=$oInterface->prevContentOri($vDet,300,"$vDetLink&uID=$vID");
			$vContent = preg_replace("/<p>(.*?)<\/p>\n/", "$1<br />", $vContent); 
			echo $vContent;
		?>
	      
	          
	        </div></td>
	  
	   
	<?
	 
	  
	   if (fmod($vCount,$vCol)==($vCol)-1) { 
	?>
  </tr>	  
  <? }	  
	  $vCount+=1; 
	  } //mod
  } //while
	


  ?>
 </table>


</div>

<?
  if ($vNumRows<=0) echo "<strong style='padding-left:15px'>Data tidak ditemukan / Not Found!</strong>";
?>
<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Tahoma, Verdana;font-weight:bold">
  <tr>
    <td><div align="right">
     <?=$rows?> record(s), 
          <input name="hPageNum2" type="hidden" id="hPageNum2" />
      <input name="hPage2" type="hidden" id="hPage2" value="<?=$curpage?>" />
      <input name="hBtn2" type="hidden" id="hBtn2" />
      <input name="ref2" type="hidden" id="ref2">
      Halaman :
      <select style="font-weight:bold" name="select" id="select" onchange="changePage(this)">
        <? for ($i=0;$i<$pagenum;$i++) {?>
        <option value="<?=$i+1 ?>" <? if ($curpage==($i)) echo "selected";?>>&nbsp;
          <?=$i+1?>
          &nbsp;</option>
        <? } ?>
      </select>
      dari
      <?=$pagenum?>
     </div></td>
  </tr>
</table>
</form>
</body>
</html>
