<? include_once("../framework/member_headside.blade.php")?>
<font face="Verdana, Arial, Helvetica, sans-serif"><span class="col-lg-2">
<input name="dc"  id="dc" value="<?=$vAwal?>" size="20" class="form-control" />
</span></font>
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
   
   if ($oDetect->isMobile()) {
       $vTabMobile ='style="transform:scale(0.75);margin-left:-3.8em"';
	   
   } else $vTabMobile = '';
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
	var vURL='../memstock/detjual.php?uNoJual='+pParam+'&uTanggal='+pTgl+'&uIDMember='+pIDMem;
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
  <div class="content-wrapper">
    <section class="content">

      <font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="3"><br />
        </font></strong></font>
      <form id="demoform" name="demoform" method="post" action="" class="trhide">
        <p><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Mulai Tanggal : </strong>
         <div class="col-lg-2"></div>
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
      <div class="col-lg-10" >   
      <table  border="0" align="left" cellpadding="1" cellspacing="0" class="table table-striped table-bordered" style="transform:scale(0.75);transform-origin: top left;">
        <tr style="font-weight:bold">
          <td width="11%" align="center" >Tgl</td>
          <td width="32%" align="center">Serial</td>
          <td width="16%" align="center">Paket</td>
          <td width="24%" align="center">Status</td>
          <td width="24%" align="center">Ref</td>
          <td width="17%" align="center">Action</td>
        </tr>
        <?php
		$vsql="select * from tb_skit where fpendistribusi='$vUser' order by ftgldist";
		$db->query($vsql);
		while ($db->next_record())
		{
		  
		?>
        <tr >
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
		      echo $db->f("fpaket");
		  ?>
          </font></td>
          <td align="center"><font color="#000000">
            <?
			 $vStatus=$oJual->getStatusBuy($db->f("frefpurc"));
			 if ($vStatus == '0')
			    echo 'Pending';
			 else if ($vStatus == '2')	
			    echo 'Approved';
		     
		  ?>
          </font></td>
          <td align="center"><font color="#000000">
          <a href="#" onClick="printTrx('<?=$db->f("frefpurc")?>','<?=$db->f("ftgldist")?>','<?=$db->f("fpendistribusi")?>')">
            <?
		      echo $db->f("frefpurc");
		  ?>
          </a>
          </font></td>
          <td align="center"><input type="button" class="btn btn-xs btn-success" name="button" id="button" value="Print Receipt" onClick="printTrx('<?=$db->f("frefpurc")?>','<?=$db->f("ftgldist")?>','<?=$db->f("fpendistribusi")?>')"></td>
        </tr>
        <?
		}
		?>
        </table>
        </div>
    </div>
      <p align="left" class="style2"><font face="Verdana, Arial, Helvetica, sans-serif"><strong>History Penjualan Kartu </strong></font></p>
             <div class="row">
      <div class="col-lg-10">   

        <table  border="0" align="left" cellpadding="1" cellspacing="0" class="table table-striped table-bordered" style="transform:scape(0.75);-webkit-transform-origin: top left;">
        <tr style="font-weight:bold">
          <td width="28%" align="center">Tgl</td>
          <td width="18%" align="center">Serial</td>
          <td width="54%" align="center">Pembeli</td>
          </tr>
        <?php
		$vsql="select * from m_anggota where fidmember in (select fserno from tb_skit where fpendistribusi='$vUser') and faktif=1";
		$db->query($vsql);
		while ($db->next_record())
		{
		  
		?>
        <tr>
          <td align="center" nowrap> <font color="#000000">
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
          <td height="14" colspan="2" align="center"><span><b>Jumlah</b></span>
            <div align="right"></div></td>
          <td align="center">
          </td>
          </tr>
        </table>
     </div>
    </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>

  <?
 include('../framework/member_footside.blade.php');
?>
