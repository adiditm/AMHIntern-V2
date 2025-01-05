<? include_once("../framework/admin_headside.blade.php")?>
<div class="right_col" role="main">
			
				 <div><label><h3>Menu Privilege</h3></label></div>

<?
  
  define("MENU_ID", "royal_setting_menupriv");
  $vUserChoosed=$_POST['cbUser'];
  if (!isset($vUserChoosed)) $vUserChoosed=$_GET['uUserChoosed'];
  $vcbNoPriv=$_POST['cbNoPriv'];
  $vcbPriv=$_POST['cbPriv'];
  $vOP=$_POST['hOP'];

  if ($vOP != "") {
     if ($vOP=="Add") { // add
	      while (list($key,$val) = @each($vcbNoPriv)) { 
     	    $vIDMenu=$val; 
		    $oSystem->addPriv($vUserChoosed,$vIDMenu);
  		}
 
	 } // Add
     if ($vOP=="Remove") { // remove
	      while (list($key,$val) = @each($vcbPriv)) { 
     	    $vIDMenu=$val; 
		    $oSystem->delPriv($vUserChoosed,$vIDMenu);
  		}
 
	 } // remove

  } //$vOP
  
  
?>
<script language="javascript">
function userChanged() {
   var vUser=document.getElementById('cbUser').value;
   document.getElementById('hOP').value="";
   document.frmUser.submit();
}

function changePriv(pOper) {
   //Check Pilihan User
  
   if (document.getElementById('cbUser').value=="-") {
      alert('Pilih user terlebih dahulu!');
	  document.getElementById('cbUser').focus();
	  return false;
   }
   
   
   //Add Priv
   if (pOper=='Add') {
   	   if (document.frmUser.cbNoPriv==undefined) {
	      alert('Semua hak sudah diberikan kepada user ini!');
		  return false;
	   }

       var vLengthNo=document.frmUser.cbNoPriv.length;   
       var vChecked=0;
	   var i=0;
	   if (!document.frmUser.cbNoPriv.length) {
			  vLengthNo=1; 			  
		   for (i=0;i<vLengthNo;i++) 
			  if (document.frmUser.cbNoPriv.checked) 
				 vChecked+=1;				 
		} else {
		   for (i=0;i<vLengthNo;i++) 
			  if (document.frmUser.cbNoPriv[i].checked) 
				 vChecked+=1;		
		}
	   if (vChecked <=0) {	
      		alert('Pilih Menu di sebelah kiri yang akan ditambahkan haknya!');
	  		return false;
	   }    
       document.getElementById('hOP').value='Add';
	   document.frmUser.submit();
		   
   } 
   else if (pOper=='Remove') { //Remove Priv
       vChecked=0;
	   i=0;
	   if (document.frmUser.cbPriv===undefined) {
	      alert('Belum ada hak yang bisa dicabut!');
		  return false;
	   }
	      
	   var vLengthPriv=document.frmUser.cbPriv.length;	  
	
	   if (!document.frmUser.cbPriv.length) {
			  vLengthPriv=1; 
		   for (i=0;i<vLengthPriv;i++) 
			  if (document.frmUser.cbPriv.checked) 
				 vChecked+=1;
				 
		} else {
		   for (i=0;i<vLengthPriv;i++) 
			  if (document.frmUser.cbPriv[i].checked) 
				 vChecked+=1;
		
		}
	   if (vChecked <=0) {	
      		alert('Pilih Menu di sebelah kanan yang akan dicabut haknya!');
	  		return false;
	   }    
       
       document.getElementById('hOP').value='Remove';
	   document.frmUser.submit();
   
   }
   
}
</script>
<style type="text/css">
<!--
.style1 {color: #FFFF00}
-->
</style>


<form id="frmUser" name="frmUser" method="post" action="">
  <table width="85%" border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="35%"><div align="center"><strong>
        <input type="hidden" name="hOP" id="hOP">
      Belum Mempunyai Privilege ke Menu:</strong></div></td>
      <td width="26%"><div align="center">
        <label><strong>User :</strong>
          <select name="cbUser" id="cbUser" onChange="userChanged()" class="form-control" style="max-width:250px">
  <option value="-" selected="selected">-----Pilih-----</option>
  <?
		     $vAdmin=$oSystem->getUserAdmin();
			 if (is_array($vAdmin)) {
			    for ($i=0;$i<count($vAdmin['fid']);$i++) {
		 ?>
  <option value="<?=$vAdmin['fid'][$i]?>" <? if ($vUserChoosed==$vAdmin['fid'][$i]) echo "selected"?>><?=$vAdmin['fid'][$i]?> / <?=$vAdmin['fnama'][$i]?></option>
  <? 		
				}
			 }
		  ?>
</select>
        </label>
      </div></td>
      <td width="39%"><div align="center"><strong>Sudah Mempunyai Privilege ke Menu:</strong></div></td>
    </tr>
    <tr>
      <td valign="top">
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#996666" style="border:none;">
      <tr>
      <td width="13%" align="center"><input name="cbAllHaveNo" type="checkbox" id="cbAllHaveNo" ></td>
      <td width="87%"> Check All</td>
      </tr>
      </table>
       
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#996666" style="border:1px solid;">
          <? 
		     $vMenu=$oSystem->getUserMenu($vUserChoosed,false);
			 if (count($vMenu['fid'])>0) {
			    $vCount=count($vMenu['fid']);
				for ($i=0;$i<$vCount;$i++) {
			 
		  ?>
		  <tr>
            <td width="12%"><div align="center">
              <label>
              <input type="checkbox" name="cbNoPriv[]" value="<?=$vMenu['fid'][$i]?>" id="cbNoPriv">
              </label>
            </div></td>
            <td width="88%"><div align="left">
          <?
              $vSQL="select menu_title from m_menu where menu_id='".$vMenu['fparent'][$i]."'";
			  $db->query($vSQL);
			  $db->next_record();
		  ?>
            
              <?=$vMenu['fnama'][$i]?> <? if ($vMenu['fparent'][$i]!='') {?>(Kategori  <?=$db->f('menu_title');?>) <? } ?>
            </div></td>
          </tr>
		  <?
		      }
			}
			
			
		  ?>
		  
      </table></td>
      <td><div align="center">
        <label>
        <input  class="btn btn-info" name="btnAdd" type="button" id="btnAdd" value="Beri Hak &raquo;" style="width:100px" onClick="changePriv('Add')">
        </label>
        <br>
        <br>
		<input class="btn btn-info"  name="btnRemove" type="button" id="btnRemove" value="&laquo; Cabut Hak" style="width:100px" onClick="changePriv('Remove')">
      </div></td>
      <td valign="top">
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#996666" style="border:none;">
      <tr>
      <td width="11%" align="center"><input name="cbAllHave" type="checkbox" id="cbAllHave" ></td>
      <td width="89%"> Check All</td>
      </tr>
      </table>
     
      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#996666" style="border:1px solid;">
        <? 
		     $vMenu=$oSystem->getUserMenu($vUserChoosed,true);			 
			 if (count($vMenu['fid'])>0) {
			    $vCount=count($vMenu['fid']);
				for ($i=0;$i<$vCount;$i++) {
			 
		  ?>
        <tr>
          <td width="11%"><div align="center">
              
              <input name="cbPriv[]" type="checkbox" id="cbPriv" value="<?=$vMenu['fid'][$i]?>">
              
          </div></td>
          <td width="89%"><div align="left">
          <?
              $vSQL="select menu_title from m_menu where menu_id='".$vMenu['fparent'][$i]."'";
			  $db->query($vSQL);
			  $db->next_record();
		  ?>
              <?=$vMenu['fnama'][$i]?> <? if ($vMenu['fparent'][$i]!='') {?>(Kategori <?=$db->f('menu_title');?>) <? } ?>
          </div></td>
        </tr>
        <?
		      }
			} else {//is_array 
		  ?>
        <tr>
          <td colspan="2"><span style="color:#000" >User
              <?=$vUserChoosed?>
            belum memiliki hak di semua menu!</span></td>
        </tr>
        <? } ?>
      </table></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td><div align="center">
        <br><input class="btn btn-info" name="btnRefresh" type="button" id="btnRefresh" value="Refresh" style="width:100px" onClick="window.location='?menu=menupriv&uUserChoosed=<?=$vUserChoosed?>'">
        
      </div></td>
      <td valign="top">&nbsp;</td>
    </tr>
  </table>
  <blockquote>
    <blockquote>
      <p>&nbsp;</p>
    </blockquote>
  </blockquote>
</form>

 </div>
<!-- Placed js at the end of the document so the pages load faster -->


<script src="../js/jquery-migrate-1.2.1.min.js"></script>

<script src="../js/modernizr.min.js"></script>
<script src="../js/jquery.nicescroll.js"></script>




<!--ios7-->
<script src="../js/ios-switch/switchery.js" ></script>
<script src="../js/ios-switch/ios-init.js" ></script>

<!--icheck -->
<script src="../js/iCheck/jquery.icheck.js"></script>
<script src="../js/icheck-init.js"></script>
<!--multi-select-->
<script type="text/javascript" src="../js/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="../js/jquery-multi-select/js/jquery.quicksearch.js"></script>
<script src="../js/multi-select-init.js"></script>
<!--spinner-->
<script type="text/javascript" src="../js/fuelux/js/spinner.min.js"></script>
<script src="../js/spinner-init.js"></script>
<!--file upload-->
<script type="text/javascript" src="../js/bootstrap-fileupload.min.js"></script>
<!--tags input-->
<script src="../js/jquery-tags-input/jquery.tagsinput.js"></script>
<script src="../js/tagsinput-init.js"></script>
<!--bootstrap input mask-->
<script type="text/javascript" src="../js/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

<!--common scripts for all pages-->



<script type="text/javascript">
    $(document).ready(function() {
		
		$("#cbAllHaveNo").click(function(){
    		$("input[name*='cbNoPriv']").not(this).prop('checked', this.checked);
		});
 
 		$("#cbAllHave").click(function(){
    		$("input[name*='cbPriv']").not(this).prop('checked', this.checked);
		});


		$('#caption').html('Menu Privilege');
		   	});
			
			$('.pme-search').addClass('hide');
</script>
  
</div>

<? include_once("../framework/admin_footside.blade.php") ; ?>