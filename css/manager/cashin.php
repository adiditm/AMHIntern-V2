<? include_once("../framework/admin_headside.blade.php")?>
<? include_once("../classes/ruleconfigclass.php")?>
<?
  define("MENU_ID", "royal_rekap_cashin");
if ($vPriv!="administrator") {
	$oSystem->jsAlert("Not Authorized");
	$oSystem->jsLocation("logout.php");
}

  $vPost=$_POST['hPost'];
  
    $vAwal=$_POST['dc'];
   if ($vAwal=="") $vAwal=date("Y-m-d",strtotime("-1 month"));
    $vAkhir=$_POST['dc1'];
   if ($vAkhir=="") $vAkhir=date("Y-m-d");  
   //$vAwal=substr($vAwal,0,10);
  // $vAkhir=substr($vAkhir,0,10);
  
  // $vAwal=$vAwal." 00:00:00";
  // $vAkhir=$vAkhir." 23:59:59";
  $vcbTgl=$_POST['cbTgl'];
  $vFiltterTgl='';$vFiltterTglRO='';
  if($vcbTgl !='1') {
     $vFiltterTgl.=" and date(ftglaktif) >= '$vAwal' and date(ftglaktif) <= '$vAkhir' ";
	 $vFiltterTglRO.=" and date(ftanggal) >= '$vAwal' and date(ftanggal) <= '$vAkhir' ";
  }
  	 
  
  if ($vPost=='vPost') {
     $vSQLBasic="select * from m_anggota where 1  $vFiltterTgl  and faktif=1 and fpaket='B'";
     $db->query($vSQLBasic);
 
	 while($db->next_record()) {
	   ;
     }
	
	 $vRowsBasic=$db->num_rows();
     $vSQLPrem="select * from m_anggota where 1 $vFiltterTgl and faktif=1 and fpaket='P'";
     $db->query($vSQLPrem);
	 
	 while($db->next_record()) {
	    ;
     }
	 $vRowsPrem=$db->num_rows(); 


  }
  
?>


<div class="content-wrapper" style="width:100%;">
<section class="content" >

<form action="" method="post" name="demoform">
        <div align="left"><br>
          <br>
          <br>
		  <style type="text/css">
.plain {height:20px; vertical-align:middle;}

td.diagonal
{
	background: linear-gradient(to right top, #ffffff 0%,#ffffff 49.9%,#000000 50%,#000000 51%,#ffffff 51.1%,#ffffff 100%);
}

.table-bordered td, .table-bordered th{
    border-color:#CCC !important;
}


          </style>
           <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />
          &nbsp;<strong>Mulai Tanggal : </strong> 
          <input class="inputborder" name="dc" id="dc" size="11" value="<?=$vAwal?>">
          <strong>s/d</strong> 
          <input class="inputborder" name="dc1"   id="dc1" size="11" value="<?=$vAkhir?>">
          &nbsp;&nbsp;          
          <input name="Submit22" type="submit" class="btn btn-success btn-sm" value="Refresh">
          <input type="checkbox" name="cbTgl" id="cbTgl" value="1" <? if ($vcbTgl=='1') echo 'checked';?>>
          <label for="checkbox">Abaikan Tanggal</label>
          <br>
          <br>
          <input type="hidden" name="hPost" value="vPost">
        </div>
		
        
		<? if ($vPost=='vPost') {?>	
        <div class="table-responsive">
      <table width="50%" style="width:70%" border="0" cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
            <tr >
              <td class="diagonal">&nbsp;</td>
              <td><div align="center"><strong>Basic</strong></div></td>
              <td><div align="center"><strong>Premium</strong></div></td>
            </tr>
            <tr > 
              <td width="25%"><div align="left"><strong>Jumlah 
                Member Aktif </strong></div></td>
              <td width="38%"> 
                <div align="right"><font color="#0000FF" size="2" face="Verdana, Arial, Helvetica, sans-serif">
                  <?=number_format($vRowsBasic,0,'.','.')?>              
                </font></div></td>
              <td width="37%"><div align="right"><font color="#0000FF" size="2" face="Verdana, Arial, Helvetica, sans-serif">
                <?=number_format($vRowsPrem,0,'.','.')?>
              </font></div></td>
            </tr>
            <tr>
              <td><div align="left"><strong>Fee Registrasi</strong></div></td>
              <td><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                <?=number_format($vRegFeeB=$oRules->getSettingByField("fregbasic"),0,'.','.')?>
              </font></div></td>
              <td><div align="right"> <?=number_format($vRegFeeP=$oRules->getSettingByField("fregprem"),0,'.','.')?></div></td>
            </tr>
            <tr>
              <td><strong>Dana Registrasi</strong></td>
              <td><div align="right"><font color="#0000FF" size="2" face="Verdana, Arial, Helvetica, sans-serif">
                <?=number_format($vTotB=$vRowsBasic * $vRegFeeB ,0,'.','.')?>
              </font></div></td>
              <td><div align="right"><font color="#0000FF" size="2" face="Verdana, Arial, Helvetica, sans-serif">
                <?=number_format($vTotP=$vRowsPrem * $vRegFeeP ,0,'.','.')?>
              </font></div></td>
            </tr>
            <tr >
              <td><strong>Total Dana Registrasi</strong></td>
              <td colspan="2"><div align="right">
                <strong>
                <?=number_format($vTotB+$vTotP,0,'.','.')?>
              </strong></div></td>
            </tr>
            <tr >
              <td><strong>Dana Repeat Order</strong></td>
              <td colspan="2"><div align="right">
              <?
                  $vSQL="select sum(fsubtotal) as subtotal from tb_trxstok_member where 1 $vFiltterTglRO ";
				 $db->query($vSQL);
				 $db->next_record();
				 $vTotRO=$db->f('subtotal');
				 echo number_format($vTotRO,0,'.','.')
			  ?>
              </div></td>
            </tr>
            <tr style="color:red"> 
              <td><div align="left"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Jumlah 
                Dana Masuk </font></strong></div></td>
              <td colspan="2"> 
                <div align="right">
                  <strong>
                  <?=number_format($vDanaMasuk=$vTotB+$vTotP+$vTotRO,0,'.','.')?>
              </strong></div>                <div align="right"></div></td>
            </tr>
          </table>
          </div><br>
          <br>
          <br>
       <div class="table-responsive">   
      <table width="50%" style="width:70%" border="0" cellpadding="0" cellspacing="0" class="table table-bordered table-striped">
            <tr >
              <td width="25%"><strong>Alokasi Bonus</strong></td>
              <td width="75%"><div align="right">
                <strong>
                <?
                   $vSQL="select sum(fcredit) as wcash from tb_mutasi where 1  $vFiltterTglRO ";
				   $db->query($vSQL);
				   $db->next_record();
				   $vBnsCash=$db->f('wcash');

                   $vSQL="select sum(fincometax) as tax from tb_mutasi where 1  $vFiltterTglRO ";
				   $db->query($vSQL);
				   $db->next_record();
				   $vTax=$db->f('tax');

                   $vSQL="select sum(fcredit) as wprod from tb_mutasi_wprod where 1  $vFiltterTglRO ";
				   $db->query($vSQL);
				   $db->next_record();
				   $vBnsProd=$db->f('wprod');


                   $vSQL="select sum(fcredit) as wkit from tb_mutasi_wkit where 1  $vFiltterTglRO ";
				   $db->query($vSQL);
				   $db->next_record();
				   $vBnsKit=$db->f('wkit');


                   $vSQL="select sum(fcredit) as wacc from tb_mutasi_wacc where 1  $vFiltterTglRO ";
				   $db->query($vSQL);
				   $db->next_record();
				   $vBnsAcc=$db->f('wacc');
				  
				   echo number_format($vBnsCash+$vBnsProd+$vBnsKit+$vBnsAcc,0,'.','.');
				?>
              </strong></div></td>
            </tr>
            <tr >
              <td><strong>Pajak</strong></td>
              <td><div align="right">
              <?

				 echo number_format($vTax,0,'.','.')
			  ?>
              </div></td>
            </tr>
            <tr style="color:red" class="hide"> 
              <td><div align="left"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Jumlah 
                Dana Keluar </font></strong></div></td>
              <td> 
                <div align="right">
                  <strong>
                  <? echo number_format($vDanaKeluar=$vBnsCash+$vBnsProd+$vBnsKit+$vBnsAcc,0,'.','.');?>
              </strong></div>                <div align="right"></div></td>
            </tr>
        <tr style="color:blue">
              <td><strong>Selisih (<? if ($vDanaMasuk > $vDanaKeluar) echo "Profit"; else echo "Loss";?>)</strong></td>
              <td><div align="right"><strong><? echo number_format($vSelisih=$vDanaMasuk-$vDanaKeluar,0,'.','.');?></strong></div></td>
            </tr>
        <tr style="color:blue">
          <td><strong>% Pay Out</strong></td>
          <td><div align="right"><strong><? 
		  if ($vDanaMasuk >0 )
		     echo number_format($vDanaKeluar / $vDanaMasuk * 100,2,'.','.').'%';
          else   echo "-";
		  ?>
             </strong></div></td>
             
        </tr>
          </table>
          </div>
          <? } ?>
         
		
          
          

      </form>

</section>
    <!-- /.content -->
  </div>
  <script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
  <!-- /.content-wrapper -->

<script language="javascript">
$(document).ready(function(){

    $('#caption').html('Cash In/Out Report');


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

<?
 include('../framework/admin_footside.blade.php');
?>




