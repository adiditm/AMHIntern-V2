<? include_once("../framework/member_headside.blade.php")?>
  <? include_once("../classes/networkclass.php");
     include_once("../classes/systemclass.php"); 
include_once("../server/config.php")
?>
<?
   $vAwal=$_POST['dc'];$vAkhir=$_POST['dc1'];
  $vRefUser=$_GET['uMemberId'];
  if (isset($vRefUser))
  	 $vUser=$vRefUser;
  else	 
  	 $vUser=$_SESSION['LoginUser'];
  $vYear=date('Y');
  $vTWeek=date('W');
  if ($vTWeek==1) {
    $vTYear=$vYear-1;
	$vSTanggal=mktime(0,0,0,12,31,$vTYear);
	$vWeek=date('W',$vSTanggal);
	$vYear=$vYear-1;
  } else {
    $vWeek=$vTWeek-1;
  }
if ($vTanggal=="")
   $vTanggal=$oPhpdate->getNowYMD("-");  
   $vAnd="";$vAndJual="";
  if ($vAwal !='' && $vAkhir!='') {
      $vAnd .=" and date(ftgldist) between '$vAwal' and '$vAkhir' ";
	  $vAndJual .=" and date(ftglaktif) between '$vAwal' and '$vAkhir' ";
  }
?>


 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />



<style type="text/css">

.table-bordered td, .table-bordered th{
    border-color:#CCC !important;
}
</style>
<script language="javascript">
function printTrx(pParam,pTgl,pIDMem) {
	var vURL='../memstock/detpo.php?uNoJual='+pParam+'&uTanggal='+pTgl+'&uIDMember='+pIDMem;
	window.open(vURL,'wPrint','width=900 height=600');
}
$(document).ready(function(){

    $('#caption').html('Card Wallet ');


   $('#dc').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  
  

    

       $('#dc1').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  
});
</script>
 	<div id="content" class="content">
			<ol class="breadcrumb pull-right">
				<h4><li><a href="javascript:;">Card Wallet</a></li></h4>
				
			</ol>
<h1 class="page-header">&nbsp;</small></h1>

      <font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="3"><br />
        </font></strong></font>
      <form id="demoform" name="demoform" method="post" action="" class="trhide">
        <p><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Mulai Tanggal : </strong>
         <div class="col-lg-2"> <input name="dc"  id="dc" value="<?=$vAwal?>" size="20" class="form-control" /></div>
          <div class="col-lg-1">s/d</div>
          <div class="col-lg-2"><input name="dc1" id="dc1" size="20" value="<?=$vAkhir?>" class="form-control" /></div>
          &nbsp;&nbsp;
          <input name="Submit22" type="submit" class="btn btn-sm btn-success" value="   Refresh   " />
          </font></p>
    </form>
    <br>
     <div>
     <p align="left">
     <font face="Verdana, Arial, Helvetica, sans-serif"> <strong style="text-align:left">
        <span >Rekap Kartu </span></strong></font>
       </p>
        


    </div>   
    <div class="row">
      <div class="col-lg-10">   
      <table  border="0" align="left" cellpadding="1" cellspacing="0" class="table table-striped table-bordered">
        <tr style="font-weight:bold">
          <td width="28%"  align="center">Total Kartu</td> 
          <td width="28%" height="5"  align="center">Kartu  Terjual          </td>
          <td width="27%" align="center">Saldo</td>
        </tr>
        
        <tr >
          <td align="center"><div align="right"><font color="#000000">
            <?
			 $vAllCard=$oJual->getAllCard($vUser);
			 echo number_format($vAllCard,0,',','.');
		  ?>
            </font></div></td> 
          <td align="center"> <div align="right"><font color="#000000">
            <?
			 $vSold=$oJual->getSoldCard($vUser);
			 echo number_format($vSold,0,',','.');
		  ?>
            </font></div></td>
          <td align="center"> <div align="right"><font color="#000000">
            <?
			 $vSaldo=$oJual->getSaldoCard($vUser);
			 echo number_format($vSaldo,0,',','.');
		  ?>
            </font></div></td>
        </tr>
        </table>
      </div>
    </div>
   
    <p align="left" class="style2"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>History Pembelian Kartu </strong></font></p>
      <div class="row">
      <div class="col-lg-12">   
       <div class="table-responsive">
      <table  border="0" align="left" cellpadding="1" cellspacing="0" class="table table-striped table-bordered" width="100%">
        <tr style="font-weight:bold">
          <td width="4%" align="center" >No.</td>
          <td width="10%" align="center" >Tgl</td>
          <td width="12%" align="center">Serial</td>
          <td width="12%" align="center">Paket</td>
          <td width="33%" align="center">Status</td>
          <td width="13%" align="center">Ref</td>
          <td width="16%" align="center">Action</td>
        </tr>
        <?php
		$vsql="select * from tb_skit where fpendistribusi='$vUser' $vAnd order by ftgldist";
		$db->query($vsql);
		$vNo=0;
		while ($db->next_record())
		{
			
			$vNo++;
		  
		?>
        <tr >
          <td align="center" nowrap><?=$vNo?>&nbsp;</td>
          <td align="center" nowrap><font color="#000000">
            <?=$oPhpdate->YMD2DMY($db->f("ftgldist"),"-")?>
            </font></td>
          <td align="center"><div align="center"><font color="#000000">
            <?
		      echo $db->f("fserno");
		  ?>
          </font></div></td>
          <td align="center"><font color="#000000">
            <?
		      echo $oProduct->getPackName($db->f("fpaket"));
		  ?>
          </font></td>
          <td align="center"><font color="#000000">
            <?
			
			$vSQL="select fidmember, fnama from m_anggota where fserno='".$db->f("fserno")."'";
			$dbin->query($vSQL);
			$dbin->next_record();
			$vUserID=$dbin->f("fidmember");
			$vNama=$dbin->f("fnama");

			$vStatus=$oJual->getStatusBuy($db->f("frefpurc"));
			 if ($vStatus==-1) $vStatus=$db->f('fstatus');
				if ($vStatus=='4') {
				   echo "Active, terjual kepada stockist [$vUser/".$oMember->getMemberName($vUser)."], used by : [".$vUserID." / ".$vNama."]";
				  // $vStatus=4;
				}  else if ($vStatus=='3') {
				   echo "Active, terjual kepada stockist [$vUser/".$oMember->getMemberName($vUser)."]";   
				 ///  $vStatus=2;
				}  else if($vStatus=='2'){
				   echo "Not Active, terjual kepada stockist [$vUser/".$oMember->getMemberName($vUser)."]"; 
				  // $vStatus=3;
				}  else if($vStatus=='1')
				   echo "Not Active, belum terjual";  
		     
		  ?>
          </font></td>
          <td align="center"><font color="#000000">
          <? 

		      $vRef= $db->f("frefpurc");
			  if (trim($vRef)=='') {
			     $vRef = "Dikirim oleh admin";
				
			  
		  
		  ?>
          <a><?=$vRef?></a>
            <?
			  } else {
				  
				  
				  ?>
             <a href="#" onClick="printTrx('<?=$db->f("frefpurc")?>','<?=$db->f("ftgldist")?>','<?=$db->f("fpendistribusi")?>')"><?=$vRef?> </a>    
                  
                  <?
			  }
				 
				// echo $vRef;
		  ?>

          </font></td>
          <td align="center">
          <? if ($vRef !='Dikirim oleh admin') {?>
          <input type="button" class="btn btn-xs btn-success" name="button" id="button" value="Print Receipt" onClick="printTrx('<?=$db->f("frefpurc")?>','<?=$db->f("ftgldist")?>','<?=$db->f("fpendistribusi")?>')">
          <? } ?>
          
          </td>
        </tr>
        <?
		}
		?>
        </table>
        </div>
        </div>
    </div>
      <p align="left" class="style2"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>History Penjualan Kartu </strong></font></p>
             <div class="row">
      <div class="col-lg-10">   

        <table  border="0" align="left" cellpadding="1" cellspacing="0" class="table table-striped table-bordered">
        <tr style="font-weight:bold">
          <td width="5%" align="center">No.</td>
          <td width="23%" align="center">Tgl</td>
          <td width="28%" align="center">Serial</td>
          <td width="44%" align="center">Pembeli</td>
          </tr>
        <?php
		$vsql="select * from m_anggota where fserno in (select fserno from tb_skit where fpendistribusi='$vUser') and faktif=1  $vAndJual";
		$db->query($vsql);
		$vNo=0;
		while ($db->next_record())
		{
		  $vNo++;
		?>
        <tr>
          <td align="center"><?=$vNo?>&nbsp;</td>
          <td align="center"> <font color="#000000">
            <?=$oPhpdate->YMD2DMY($db->f("ftglaktif"),"-")?>
            </font></td>
          <td align="center"><div align="center"><font color="#000000">
            <?
		      echo $db->f("fidmember");
		  ?>
          </font></div></td>
          <td align="center">
            <div align="left"><font color="#000000">
              <?
		      echo $db->f("fidmember")."/".$oMember->getMemberName($db->f("fidmember"));
		  ?>
            </font></div></td>
          </tr>
        <?
		}
		?>
        <tr >
          <td height="14" colspan="3" align="center"><span><b>Jumlah</b></span>
            <div align="right"></div></td>
          <td align="center"><?=$vNo?>
          </td>
          </tr>
        </table>
     </div>
    </div>


  <!-- /.content-wrapper -->
<script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
</div>
	<!-- end page container -->
	
<? include_once("../framework/admin_bottomjs.blade.php")?>	
	<script>
		$(document).ready(function() {
			App.init();
			Dashboard.init();
		});
	</script>

<? include_once("../framework/admin_footside.blade.php") ; ?>