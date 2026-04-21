<? include_once("../framework/admin_headside.blade.php")?>
<style type="text/css">

   .widget-stats {padding:5px 5px 5px 5px; border-radius:3px};

   

</style>

    <!-- end #headside -->

		

		<!-- begin #content -->

		<div class="right_col" role="main">



  

  

  <div><label>
  <h3>Etalase Produk</h3></label></div>
   
   
   <?
   $vPack='1';
   
   $vCnt=$_POST['lmCnt'];
   $vKota=$_POST['lmCity'];
   $vNama=$_POST['tfNama'];
   $vCanGo=$_GET['can2'];
   $vCat=$_POST['lmCat'];
   
   
   if ($vPack==1)	   
       $vPackDesc=$oInterface->getCaptionLang("front_capregular",$_SESSION['lang']);
   if ($vInt=="") $vPackDesc="";
   

  // if (trim($vPack!=""))
  //    $vAnd.=" and fpaket=$vPack ";


   if (trim($vKota!=""))
      $vAnd.=" and farea=$vKota ";  

   if (trim($vCat!="")) {
      $vAnd.=" and fidcat='$vCat' "; 
     // exit;
   }
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
   
   if ($vHari !='')
      $vAnd.=" and fjmlhari = $vHari ";


   
    $vSQL="select * from m_product where faktif='1'  $vAnd";
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
   $vString=$_SERVER['QUERY_STRING'];
   $pagenum=ceil($rows/$rowpage);
       if ($vScript=='loggedin.php') {
		  $vDetLink="../memstock/prodet.php&type=UM";
		  $vClear="?tack=tour";
	   } else  if ($vScript=='index.php') {
		  $vDetLink="?tick=prodet&type=UM";
		  $vClear="?tick=tour";
	   }		
	   
	   $vDetLink="../memstock/prodet.php?type=UM&$vString";
   

?>

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


.img-with-text {
    text-align: justify;
    width: 150px;
}

.img-with-text img {
    display: block;
    margin: 0 auto;
}

.img-with-text p {
	margin-top:3px;	
   font-weight:bold;
   color:#009;
   
}
</style>

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

function changeDay() {
	document.demoform.submit();
	
}
</script>
<form name="demoform" method="post" >
  
  
   
    <div class="form-group hide"  >
        <div class="row">
          <div class="col-lg-6">
          <label>Negara </label>
            <select onchange="changeKota(this.value)" name="lmCnt" id="lmCnt" class="form-control">
              <option value="">---Choose/Pilih---</option>
              <?
			     $vSQL = "select * from m_prdcountry where faktif=1 and fproduk <> 'PKO' order by fname ";
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
          </div>
        

          <div class="col-lg-6">
          <label>Kota</label>
            <select name="lmCity" id="lmCity" class="form-control">
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
          </div>
        
       
          <div class="col-lg-6">
          <label>Kata Kunci</label>
            <input  name="tfNama" id="tfNama" class="form-control" value="<?=($_POST['tfNama'])?>" size="28" /> 
            </div>
       </div> 
        <div>&nbsp;</div>
        <div class="row">
          <div class="col-lg-6">
<input class="btn btn-success" name="btCheckHrg" type="button" id="btCheckHrg" value="Search" onclick="demoform.submit()" />
             &nbsp; <input  class="btn btn-default" name="btCheckHrg2" type="button" id="btCheckHrg2"  value="Clear Search" onclick="yhRef('<?=$vClear?>')" />
</div>
        </div>
      
		
        
      </div>
      <!-- 
      </form>

<form name="demoform" id="demoform" method="post">  -->
<? if ($vCanGo!='1') {?>
<div align="right" style="cursor:pointer;margin-right:8px;background-color:#FF6600;display:none" onclick="$('#lySearch').slideToggle();"><img src="images/search.gif" width="24" height="24" alt="search" />Search Tour</div><br>
<? } ?>

<div class="row">
    <div class="col">
      <div align="left">
      <?
      if ($vuMenu1=='') { //menu biasa
	     $vMenu=$oInterface->getMenuHeader($vuMenu);
		 if ($vMenu=='') $vMenu = ucwords($vuMenu);
		 
	  } else if ($vuMenu1=='news' && $vJenis) { //menu news
	     echo "Info Wisata >> ".$oInterface->getNewsHeader($vIdNews);
	  }
	?>
    
      </div>
      
      
      
      </div>
     
  </div>

   <div class="row">
     <div class="col">


     </div></div>
 <div class="col-lg-6"><label>Kategori Produk</label>
   <select  name="lmCat" id="lmCat" onchange="changeDay()" class="form-control">
   <option value="">--Pilih--</option>
   <?
       $vSQL = "select * from m_catproduct";
	   $dbin->query($vSQL);
	   while($dbin->next_record()) {
		   $vIdCat= $dbin->f('fidcat');
		   $vNamaCat= $dbin->f('fnamacat');
   ?>
	<option value="<?=$vIdCat?>" <? if ($vIdCat==$vCat) echo 'selected';?>><?=$vNamaCat?></option>
	<? } ?>
</select>
   </div>
   <div>&nbsp;</div>
   <div class="col"><div align="right"> <br /><br><br>
     <?=$rows?> record(s), 
     <input name="hPageNum" type="hidden" id="hPageNum" />
      <input name="hPage" type="hidden" id="hPage" value="<?=$curpage?>" />
      <input name="hBtn" type="hidden" id="hBtn">
      <input name="ref" type="hidden" id="ref" >
      Halaman :
      <select name="select3" id="select3" onchange="changePage(this)">
        <? for ($i=0;$i<$pagenum;$i++) {?>
        <option value="<?=$i+1 ?>" <? if ($curpage==($i)) echo "selected";?>>&nbsp;
          <?=$i+1?>
          &nbsp;</option>
        <? } ?>
      </select>
      dari 
      <?=$pagenum?>

      </div></div>



<?
  $vSQL="select * from m_product where faktif=1   $vAnd order by fnamaproduk";
  $vSQL.=" limit  $offset, $rowpage ";
  
  
//  if ($_SESSION['LoginUser']=='adelina') echo $vSQL;
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
<div class="panel-body">
<div class="row"> 
    <?
  $vSQL="select * from m_product where faktif='1'    $vAnd order by fnamaproduk";
  $vSQL.=" limit  $offset, $rowpage ";
  $db->query($vSQL);
  $vNumRows=$db->num_rows();
  	$vCount=0;$vCol=2;
  while ($db->next_record()) {
    
	 $vHarga=$db->f('fhargajual1');
	 $vImage=$db->f('fimage');
	 $vID=$db->f('fidproduk');
	 $vDesc=$db->f('fdesc');
	 $vNamaProd=$db->f('fnamaproduk');
	
	 
	 if (trim($vImage)=="" || trim($vImage)=="0")
	    $vImage="noimage-flat.jpg";
		
		if (fmod($vCount,$vCol)==0) {   
	?>
	
	<? } ?>
	  <div class="col-lg-6">
	    <br>
        <a href="<?="$vDetLink&uID=$vID";?>" style="text-decoration:none;color:#000"><strong><?=$vNamaProd?></strong></a><br /><br />
        <? if ($vImage!='noimage-flat.jpg') { ?>
        <a href="<?="$vDetLink&uID=$vID";?>">  
        <div class="img-with-text">     
        <img align="left" hspace="5" vspace="4"  src="../images/prod/<?=$vImage?>" width="150" height="100">
        <p><?="Harga: Rp".number_format($db->f('fhargajual1'),0,",",".");?></p>
        </div>
        </a>
     

        <? } else {?>
		<a href="<?="$vDetLink&uID=$vID";?>">
         <div class="img-with-text">     
        <img align="left" vspace="4" hspace="5"  src="../images/<?=$vImage?>" width="150" height="100"> 
        <p><?="Harga: Rp".number_format($db->f('fhargajual1'),0,",",".");?></p>
        </div>
         </a>
		<? } 
		
		
		
		?>
 
       <?
            $vContent=$oInterface->prevContentOri($vDesc,300,"$vDetLink&uID=$vID");
			$vContent = preg_replace("/<p>(.*?)<\/p>\n/", "$1<br />", $vContent); 
			
			echo $vContent;
			
			
		?>
	      
	          
	        </div>
            
	  
	   
	<?
	 
	
	  
	   if (fmod($vCount,$vCol)==($vCol)-1) { 
	?>
  
  <? }	  
	  $vCount+=1; 
	  } //mod
  } //while
	


  ?>
 </div>


</div>


<div >
  <div class="row">
    <div class="col"><?
  if ($vNumRows<=0) echo '<strong>Data tidak ditemukan / Not Found!</strong>';
?></div>
    <div class="col">
    <div align="right">
     <?=$rows?> record(s), 
          <input name="hPageNum2" type="hidden" id="hPageNum2" />
      <input name="hPage2" type="hidden" id="hPage2" value="<?=$curpage?>" />
      <input name="hBtn2" type="hidden" id="hBtn2" />
      <input name="ref2" type="hidden" id="ref2">
      Halaman :
      <select name="select" id="select" onchange="changePage(this)">
        <? for ($i=0;$i<$pagenum;$i++) {?>
        <option value="<?=$i+1 ?>" <? if ($curpage==($i)) echo "selected";?>>&nbsp;
          <?=$i+1?>
          &nbsp;</option>
        <? } ?>
      </select>
      dari
      <?=$pagenum?>
     </div></div>
  </div>
</div>
</form>
	</div>

		<!-- end #content -->

		

        <!-- begin theme-panel -->



        <!-- end theme-panel -->

		

		<!-- begin scroll to top btn -->

		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>

		<!-- end scroll to top btn -->



	<!-- end page container -->

	





<? include_once("../framework/member_footside.blade.php") ; ?>
