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
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" id="btnModal" style="display:none" data-backdrop="static">Open Modal</button>

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
    
    </div>
    
   
  
  


</div>
<script language="javascript">
   $(document).ready(function(){
	   <? 
	   $vRefer = addslashes($vRefer);
	   if (preg_match("/login.php/i","$vRefer") && $vPriv !='administrator') { ?>
	   		$('#btnModal').trigger('click'); 
	// $('#btnModal').modal({
    //backdrop: 'static',
 //   keyboard: false
//})

	 
	   <? } ?>
	   
   });
   
 

   
</script>

<? include_once("../framework/admin_footside.blade.php") ; ?>
