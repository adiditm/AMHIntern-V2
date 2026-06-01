<? include_once("../framework/admin_headside.blade.php")?>
<?
  $vRefer=$_SERVER['HTTP_REFERER'];
  $vRefer = explode("/",$vRefer);
  $vCount = count($vRefer) -1;
  $vRefer = $vRefer[$vCount];
  if ($vPriv=='sponsor')
     $vContent=$oInterface->getMenuContent('beranda3');
  if ($vPriv=='korwil')
     $vContent=$oInterface->getMenuContent('beranda2');

?>
	<style type="text/css">
@media (min-width: 992px) {
  .modal-dialog {
    width: 80% !important;
  }
}
.modal-header .close {
  display:none;
}	
    </style>
    
    	<div class="right_col" role="main">

  
  
  <div><label><h3>Dashboard </h3></label></div>
  
 <div class="container">
 
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="btnModal" style="display:none">Open Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Tata Cara</h4>
        </div>
        <div class="modal-body">
          <p><?=$vContent?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">Saya setuju dengan tata-cara ini!</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>



  <div class="row states-info">
    
    <div class="col-md-3">
      
      <div class="panel bg-purple">
        
        <div class="panel-body">
          
          <div class="row">
            
            <div class="col-xs-4">
              
              <i class="fa fa-user"></i>
              
              </div>
            
            <div class="col-xs-8 ">
              
              <b><span class="state-title"> Total Jamaah </span></b>
              
              <h4>
              <?
              		$vSQL = "select count(fidsys) as fcount from m_anggota where faktif  ='1' ";
					$db->query($vSQL);
					$db->next_record();
					echo $db->f('fcount');
			  ?>
              
              </h4>
              
              </div>
            
            </div>
          
          </div>
        
        </div>
      
      </div>
    
    <div class="col-md-3">
      
      <div class="panel bg-blue">
        
        <div class="panel-body">
          
          <div class="row">
            
            <div class="col-xs-4">
              
              <i class="fa fa-user"></i>
              
              </div>
            
            <div class="col-xs-8">
              
              <b><span class="state-title">   Jamaah Bulan Ini  </span></b>
              
              <h4>
              <?
              		$vMonthNow = date('Y-m');
					$vSQL = "select count(fidsys) as fcount from m_anggota where faktif  ='1' and  date_format(ftglaktif,'%Y-%m') = '$vMonthNow' ";
					$db->query($vSQL);
					$db->next_record();
					echo $db->f('fcount');
			  ?>
              </h4>
              
              </div>
            
            </div>
          
          </div>
        
        </div>
      
      </div>
    
    <div class="col-md-3">
      
      <div class="panel bg-green">
        
        <div class="panel-body">
          
          <div class="row">
            
            <div class="col-xs-4">
              
              <i class="fa fa-plane"></i>
              
              </div>
            
            <div class="col-xs-8">
              
             <b> <span class="state-title">  Siap Brgkt Bln. Ini</span></b>
              
              <h4><?
              		$vMonthNow = date('Y-m');
					$vSQL = "select count(fidsys) as fcount from m_anggota where faktif  ='1' and  date_format(ftglaktif,'%Y-%m') = '$vMonthNow' and fpaspor <>'' ";
					$db->query($vSQL);
					$db->next_record();
					echo $db->f('fcount');
			  ?></h4>
              
              </div>
            
            </div>
          
          </div>
        
        </div>
      
      </div>
    
    <div class="col-md-3">
      
      <div class="panel bg-red">
        
        <div class="panel-body">
          
          <div class="row">
            
            <div class="col-xs-4">
              
              <i class="fa fa-clock-o"></i>
              
              </div>
            
            <div class="col-xs-8">
              
              <b><span class="state-title"> Blm Siap Berangkat </span></b>
              
              <h4><?
              		$vMonthNow = date('Y-m');
					$vSQL = "select count(fidsys) as fcount from m_anggota where faktif  ='1' and  date_format(ftglaktif,'%Y-%m') = '$vMonthNow' and fpaspor ='' ";
					$db->query($vSQL);
					$db->next_record();
					echo $db->f('fcount');
			  ?></h4>
              
              </div>
            
            </div>
          
          </div>
        
        </div>
      
      </div>
      
      
 <div class="col-md-3">
      
      <div class="panel bg-blue">
        
        <div class="panel-body">
          
          <div class="row">
            
            <div class="col-xs-4">
              
              <i class="fa fa-list"></i>
              
              </div>
            
            <div class="col-xs-8">
              
              <b><span class="state-title">Transaksi Produk Pending  </span></b>
              
              <h4>
              <?
              		$vMonthNow = date('Y-m');
					$vSQL = "select count(*) as fcount from(select distinct fidpenjualan from tb_penjualan_temp) as a ";
					$db->query($vSQL);
					$db->next_record();
					echo $db->f('fcount');
			  ?>
              </h4>
              
              </div>
            
            </div>
          
          </div>
        
        </div>
      
      </div>     
      
 
 
  <div class="col-md-3">
      
      <div class="panel bg-purple">
        
        <div class="panel-body">
          
          <div class="row">
            
            <div class="col-xs-4">
              
              <i class="fa fa-list"></i>
              
              </div>
            
            <div class="col-xs-8">
              
              <b><span class="state-title">Transaksi Produk Sukses  </span></b>
              
              <h4>
              <?
              		$vMonthNow = date('Y-m');
					$vSQL = "select count(*) as fcount from(select distinct fidpenjualan from tb_penjualan) as a ";
					$db->query($vSQL);
					$db->next_record();
					echo $db->f('fcount');
			  ?>
              </h4>
              
              </div>
            
            </div>
          
          </div>
        
        </div>
      
      </div>        
      
    
    </div>
  
  


</div>
<script language="javascript">
   $(document).ready(function(){
	   <? 
	   $vRefer = addslashes($vRefer);
	   if (preg_match("/login.php/i","$vRefer") && $vPriv !='administrator') { ?>
	   		$('#btnModal').trigger('click');
	   
	   <? } ?>
	   
   });
   
   
<? if ($vScriptName!='aktif.php') { 
			$vSQL = "select  * from m_anggota where faktif = '0' ";
			$db->query($vSQL);
			while($db->next_record()) {
				$vIDMember = $db->f('fidmember');
				$vNama = $db->f('fnama');
				$vRefer = $db->f('frefer');
				$vNamaRefer = $db->f('fnamarefer');
				$vRegistrar = $db->f('fidregistrar');

?>
Lobibox.notify('warning',  // Available types 'warning', 'info', 'success', 'error'
{
   closeOnEsc      : true,
   draggable       : true, 
   msg					:'Aktifasi <font color="#0f0">member</font> <?=$vIDMember?> / <?=$vNama?> ! Klik <a style="color:blue" href="../manager/aktif.php?hOP=post&current=mdm_admin&menu=mdm_admin_verify&tfNama=&tfKota=&tfDepart=&tfNoHP=&lmAktif=&tfID=&tfNama=<?=$vNama?>&tfNoHP=&tfKota=&tfDepart=&lmStockist=&lmAktif=3&lmMship=-&lmSort=1&Submit=Cari&choosed=<?=$vIDMember?>">di sini</a> utk memproses. ',
   delay: false,
   closeOnClick : false,
   size : 'mini' 


});
<? } 
}
?>


<? if ($vScriptName!='appvpay.php') { 

				$vsql ="select distinct ftglentry, fidpenjualan,fidseller,fidmember, fketerangan,fprocessed, fjumlah, fsubtotal   from tb_payment_temp where   fjenis='POIN' and fmethod='ctr' and fprocessed='1' ";
				 $vsql.= " union ";			 
				 $vsql.= " select distinct ftglentry, fidpenjualan,fidseller,fidmember, fketerangan,fprocessed , fjumlah, fsubtotal  from tb_payment where   fjenis='POIN' and fmethod='ctr'  and fprocessed='1'";
				 			
			$db->query($vsql);
			while($db->next_record()) {
				$vIDMember = $db->f('fidmember');
				$vNama = $oMember->getMemberName($vIDMember);
				$vPayer = $db->f('fidseller');
				

?>
Lobibox.notify('warning',  // Available types 'warning', 'info', 'success', 'error'
{
   closeOnEsc      : true,
   draggable       : true, 
   msg					:'Aktifasi <font color="#0f0">payment</font> <?=$vIDMember?> / <?=$vNama?> ! Klik <a style="color:blue" href="../manager/appvpay.php?op=&current=mdm_admin&menu=mdm_admin_appvpay">di sini</a> utk memproses. ',
   delay: false,
   closeOnClick : false,
   size : 'mini' 


});
<? } 
}
?>


<? if ($vScriptName!='veriwith.php') { 

				$vsql ="select distinct ftglupdate, fidwithdraw,fidmember, fket,fstatusrow, fnominal from tb_withdraw where    fstatusrow='0' ";
				 			
			$db->query($vsql);
			while($db->next_record()) {
				$vIDMember = $db->f('fidmember');
				$vNama = $oMember->getMemberNameAdm($vIDMember,'sponsor');
				
				

?>
Lobibox.notify('warning',  // Available types 'warning', 'info', 'success', 'error'
{
   closeOnEsc      : true,
   draggable       : true, 
   msg					:'Approval <font color="#0f0">pencairan</font> <?=$vIDMember?> / <?=$vNama?> ! Klik <a style="color:blue" href="../manager/veriwith.php?op=&current=mdm_admin&menu=mdm_admin_veriwith">di sini</a> utk memproses. ',
   delay: false,
   closeOnClick : false,
   size : 'mini' 


});
<? } 
}
?>

   
</script>

<? include_once("../framework/admin_footside.blade.php") ; ?>