<?
  define("MENU_ID", "royal_setting_list_jual_kartu");
  $vRefUser=$_GET['uMemberId'];
  if (isset($vRefUser))
  	 $vUser=$vRefUser;
  else	 
  	 $vUser=$_SESSION['LoginUser'];

	$vFilterSerial=$_POST['tfSerial'];
	$vFilterSerialFrom=$_POST['tfSerialFrom'];
	$vFilterSerialTo=$_POST['tfSerialTo'];
	
	$vFilterPin=$_POST['tfPin']; 
	$vFilterStatus=$_POST['lmStatus'];

	$vAnd="";

	if ($vFilterSerial!="") $vAnd.=" and a.fserno like '%$vFilterSerial%' ";
	if ($vFilterSerialFrom!="" &&  $vFilterSerialTo!="") $vAnd.=" and a.fserno >= '$vFilterSerialFrom' and a.fserno <= '$vFilterSerialTo'";
	if ($vFilterPin!="")  $vAnd.=" and a.fpin like '%$vFilterPin%' "; 
	if ($vFilterStatus=="-")  ;
	if ($vFilterStatus=="a")  $vAnd.=" and a.fserno not in (select fserial from tb_penjualan) "; 
	if ($vFilterStatus=="u")  $vAnd.=" and a.fserno in (select fserial from tb_penjualan) "; 
	
    $vsql="select * from tb_serialjual a ";
	 $vsql.=" where 1  $vAnd order by fserno ";
    $db->query($vsql);

    $curpage=$_POST['hPageNum'];
    if ($curpage=="" || $_POST['hBtn']=="cari") {
       $curpage="1";
    }
	
	$rows=$db->num_rows();
	$jml=$rows;
	$rowpage=25;
	$curpage=$curpage-1;
	$offset=$curpage*$rowpage;
	
	$pagenum=ceil($rows/$rowpage);
	
	$vDelAct=$_POST['hDel'];
	$vDelSer=$_POST['hDelSer'];
	
	if ($vDelAct=="y") {
	  $vsqlin="delete from tb_serialjual where fserno='$vDelSer'";
	  $dbin->query($vsqlin); 
	  $oSystem->jsAlert("Serial $vDelSer deleted!");
	}

	if ($vDelAct=="yblank") {
	  $vsqlin="delete FROM tb_serialjual WHERE NOT fpin REGEXP '[A-Za-z0-9]' ";
	  $dbin->query($vsqlin); 
	  $oSystem->jsAlert("Serial dengan PIN kosong deleted!");
	}
   
   
//Hapus   
if ($_POST['hPostDel']=="1" ){
$vcbChoice=$_POST['cbChoice'];
$vCount=0;
while (list($key,$val) = @each($vcbChoice)) { 
      $vkd=$val;   
	  $vsqlin="delete from tb_serialjual where fserno='$vkd'";
	  $dbin->query($vsqlin); 
   $vCount+=1;
}
  $oSystem->jsAlert("$vCount serial terhapus!");
}
  
//Penjualan
if ($_POST['hPostJual']=="1" ){
	$vcbChoice=$_POST['cbChoice'];
	$vPembeli=$_POST['tfPembeli'];
	
	if ($oMember->authActiveID($vPembeli)==1 && $oMember->isStockist($vPembeli)==1) {
	
		$vCount=0;
		while (list($key,$val) = @each($vcbChoice)) { 
			  $vkd=$val;   
			  $vsqlin="update tb_serialjual set fpendistribusi='$vPembeli', ftgldist=now() where fserno='$vkd'";
			  $dbin->query($vsqlin); 
		   $vCount+=1;
		   
		}
		  $oSystem->jsAlert("$vCount kartu terjual kepada \'$vPembeli\'/".$oMember->getMemberName($vPembeli)."!");
	 } else  $oSystem->jsAlert("Member \'$vPembeli\' tidak ada, atau tidak aktif, atau bukan stockist! Anda tidak dapat menjual kepada pembeli tersebut!");
}
   
 
?>
<link href="netto.css" rel="stylesheet" type="text/css">




<script language="JavaScript" type="text/JavaScript">
<!--
<!--

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->



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

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function doDelBlank() {
   vSure=confirm('Apakah Anda yakin menghapus serial dengan PIN kosong?');
   if (vSure==true) {      
       document.getElementById('hDel').value="yblank";
	   
	   document.demoform.submit();
   } 
}

function toggleCheck(cbChoice) {
    
    var vCount=0;
	for (i = 0; i < cbChoice.length; i++) {
		cbChoice[i].checked = document.demoform.cbAll.checked && !cbChoice[i].disabled;
		if (!cbChoice[i].disabled) vCount+=1;
		
	}	
	
	if (vCount>0 && document.demoform.cbAll.checked) {
	   document.demoform.cbSelfDel.disabled=false;
	   document.demoform.cbSelfJual.disabled=false;
	   alert(vCount+' selected!');
	}   
	else  { 
	   document.demoform.cbSelfDel.disabled=true;
	   document.demoform.cbSelfJual.disabled=true;
	}   
}  


function doSelfDel() {
  if (confirm('Yakin menghapus semua yang dipilih?')==true) { 
   document.demoform.hPostDel.value="1";
   document.demoform.submit();
  } 

}

function doDel() {
  if (confirm('Yakin menghapus semua yang dipilih?')==true) { 
   document.demoform.hPostDel.value="1";
   document.demoform.submit();
  } 

}



function doSelfJual() {
  var a=document.demoform.tfPembeli.value;
  if (a=="") a='Kosong';
  if (confirm('Warning!! Yakin menjual semua yang dipilih? Pembeli adalah :'+' '+a+'. Penjualan yang sudah terjadi tidak dapat dicancel!')==true) { 
   if (document.demoform.tfPembeli.value.length==8) {
     document.demoform.hPostJual.value="1";
     document.demoform.submit();
   } else {
     alert('Isikan ID Pembeli dengan benar!');	 
	 document.demoform.tfPembeli.focus();
   }	 
  } 

}

//-->
</script>
<style type="text/css">
<!--
table.MsoNormalTable {
font-size:10.0pt;
font-family:"Times New Roman";
}
p.MsoNormal {
margin:0cm;
margin-bottom:.0001pt;
font-size:12.0pt;
font-family:"Times New Roman";
}
.style2 {font-weight: bold}
.style3 {
	font-size: 12px;
	font-weight: bold;
}
.style4 {font-weight: bold}
.style5 {
	font-family: Arial;
	font-weight: bold;
	font-size: 8.0pt;
}
-->
</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow" class="contentfont">
  <!--DWLayoutTable-->
  <tr> 
    <td width="618" height="18" align="center" valign="middle"> <p><font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="3"><br />
      List Serial Penjualan </font><br>
    </strong></font></p></td>
  </tr>
  <tr> 
    <td height="5" align="center" valign="middle"> <hr> </td>
  </tr>
  
 
  

  
  
  <tr> 
    <td height="5" align="center" valign="top"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="3"><br />
      </font></strong></font>
        <form id="demoform" name="demoform" method="post" action="" >
		<input name="hPageNum" type="hidden" id="hPageNum">   
        <input name="hPage" type="hidden" id="hPage" value="<?=$curpage?>">
        <input name="hBtn" type="hidden" id="hBtn">
         <input name="ref" type="hidden" id="ref" >

          <table width="60%" border="0" cellpadding="2" cellspacing="0" bgcolor="#99CCFF" >
            <tr>
              <td colspan="3" style="border-top:solid windowtext 1.0pt;border-left:solid windowtext 1.0pt;border-bottom:none;border-right:solid windowtext 1.0pt;" ><div align="center" class="style3">Filter</div></td>
            </tr>
            <tr>
              <td width="33%" height="25" style="border-top:none;border-left:solid windowtext 1.0pt;border-bottom:none;border-right:none;"><div align="left">Serial</div></td>
              <td width="2%" height="25">:</td>
              <td width="65%" height="25" style="border-top:none;border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;"><div align="left">
                <input name="tfSerial" type="text" class="inputborder" id="tfSerial" value="<?=$vFilterSerial?>" />
              </div></td>
            </tr>
            <tr>
              <td height="25" style="border-top:none;border-left:solid windowtext 1.0pt;border-bottom:none;border-right:none;"><div align="left">Range Serial</div></td>
              <td height="25">:</td>
              <td height="25" style="border-top:none;border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;"><div align="left">
                <input name="tfSerialFrom" type="text" class="inputborder" id="tfSerialFrom" value="<?=$vFilterSerialFrom?>" /> 
                s.d 
                <input name="tfSerialTo" type="text" class="inputborder" id="tfSerialTo" value="<?=$vFilterSerialTo?>" />
              </div></td>
            </tr>
            <tr>
              <td height="25" style="border-top:none;border-left:solid windowtext 1.0pt;border-bottom:none;border-right:none;"><div align="left" >PIN</div></td>
              <td height="25">:</td>
              <td height="25" style="border-top:none;border-left:none;border-bottom:none;border-right:solid windowtext 1.0pt;"><div align="left">
                <input name="tfPin" type="text" class="inputborder" id="tfPin" value="<?=$vFilterPin?>" />
              </div></td>
            </tr>
            
            <tr>
              <td height="25" style="border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;" ><div align="left">Status</div></td>
              <td height="25" style="border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:none;" >:</td>
              <td height="25" style="border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;" ><div align="left">
                <select name="lmStatus" id="lmStatus">
                  <option value="-" selected="selected">All</option>
                  <option value="a" <? if ($vFilterStatus=="a") echo "selected" ?>>Aktif</option>
                  <option value="u" <? if ($vFilterStatus=="u") echo "selected" ?>>Used</option>
                </select>
              </div></td>
            </tr>
          </table>
          <p><font face="Verdana, Arial, Helvetica, sans-serif"><strong><br />
          </strong>&nbsp;&nbsp;
            <input name="Submit22" type="button" class="smallbutton" onclick="MM_callJS('doSubmit(\'cari\')')" value="   Lihat   "  />
          </font></p>
          <p align="right"><strong>Page
              <select name="select" id="select2" onchange="changePage(this)">
              <? for ($i=0;$i<$pagenum;$i++) {?>
              <option value="<?=$i+1 ?>" <? if ($curpage==($i)) echo "selected";?>>&nbsp;
              <?=$i+1?>
  &nbsp;</option>
              <? } ?>
            </select>
          </strong></p>
          <table width="70%" border="0">
            <tr>
              <td><div align="left">
                  <input name="cbSelfDel" type="button" id="cbSelfDel" onclick="doSelfDel();" value="Delete" disabled="disabled"/>
                  <input name="hPostDel" type="hidden" id="hPostDel" />
                  <input name="cbDel2" type="button" id="cbDel2" onclick="doDelBlank();" value="Hapus PIN Kosong" />
              <td>&nbsp;</td>
            </tr>
          </table>
          <br />
          <table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="552" style="width:457.0pt;margin-left:4.65pt;border-collapse:collapse;">
        <tr style="height:12.75pt;background-color:#99CCFF">
          <td width="136" align="center" valign="middle" nowrap="nowrap" style="width:10%;border-top:solid windowtext 1.0pt;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p class="MsoNormal style2"><span style="font-family:Arial; font-size:8.0pt; ">No</span></p>            </td>
          <td width="124" align="center" valign="middle" nowrap="nowrap" style="width:15%;border-top:solid windowtext 1.0pt;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p class="MsoNormal"><strong><span style="font-family:Arial; font-size:8.0pt; ">Serial</span></strong></p>            </td>
          <td width="181" align="center" valign="middle" nowrap="nowrap" style="width:10%;border:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p class="MsoNormal"><strong><span style="font-family:Arial; font-size:8.0pt; ">PIN</span></strong></p>            </td>
          <td width="168" valign="bottom" nowrap="nowrap" style="width:15%pt;border-top:solid windowtext 1.0pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p align="center" class="MsoNormal"><span class="style5">Check</span>
              <label>
            <input name="cbAll" type="checkbox" id="cbAll" value="checkbox" onclick="toggleCheck(document.demoform.cbChoice);" />
            </label>
          </p>            </td>
        </tr>
        
<?
  $vsql="select a.*,b.fidmember,a.fpendistribusi,b.fserial from tb_serialjual a left join tb_penjualan b on a.fserno=b.fserial ";
  $vsql.="where 1  $vAnd order by fserno";
   $vsql.=" limit  $offset, $rowpage ";
  $db->query($vsql);
  $vNo=0;
  $vTotalSpon=0;$vTotalCoup=0;$vTotalMatch=0;$vTotalLevel=0;$vTotalBonus=0;
  while ($db->next_record()) {
    $vSerno=$db->f("fserno");
	$vPin=$db->f("fpin");
	$vNo+=1;
	
?>
        <tr style="height:12.75pt;" <? if(($vNo % 2)==1) echo "bgcolor='#FFFFF3'"; else echo "bgcolor='#CCCCFF'"; ?>>
          <td width="136" nowrap="nowrap" valign="bottom" style="width:10%;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p class="MsoNormal"><span style="font-family:Arial; font-size:8.0pt; ">
            <?=$vNo+$offset?>
          </span></p></td>
          <td width="124" nowrap="nowrap" valign="bottom" style="width:32.0pt;border-top:none;border-left:solid windowtext 1.0pt;border-bottom:solid windowtext 1.0pt;border-right:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p align="left" class="MsoNormal"><span style="font-family:Arial; font-size:10.0pt; ">&nbsp;</span><span style="font-family:Arial; font-size:8.0pt; ">
            <?=$vSerno?>
          </span></p></td>
          <td width="181" nowrap="nowrap" valign="bottom" style="width:10%;border:solid windowtext 1.0pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p align="left" class="MsoNormal"><span style="font-family:Arial; font-size:10.0pt; ">&nbsp;</span><span style="font-family:Arial; font-size:8.0pt; ">
            <?
			  
			  if (preg_replace( '/[^[:print:]]/', '',$vPin)=="") echo "[PIN Kosong]";
			  else echo "[".trim($vPin)."]";
			  ?>
          
		  <?
				$vUserID=$db->f("fidmember");
				
				$vBuyer=$db->f("fpendistribusi");
				if ($vUserID!="") {
				   echo "Status: Terpakai, Used by : ".$vUserID;
				   $vStatus=1;
				}  
				else {
				   echo "Status: Aktif"  ;
				   $vStatus=3;
				}   
			
			?></span>
		  </p></td>
          <td width="168" nowrap="nowrap" valign="bottom" style="width:15%;border:solid windowtext 1.0pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:12.75pt;"><p class="MsoNormal">
            <input name="cbChoice[]" type="checkbox" id="cbChoice" onclick="document.demoform.cbSelfDel.disabled=!this.checked;document.demoform.cbSelfJual.disabled=!this.checked" value="<?=$vSerno?>" <? if ($vStatus!=3) echo "disabled";?> />
          </p></td>
        </tr>
<? } ?>		
      </table>
	  <p align="right"><strong>
	    <input name="hDelSer" type="hidden" id="hDelSer" value="" />
	    <input name="hDel" type="hidden" id="hDel" value="" />
	    <input name="ref" type="hidden" id="ref" />
	    Page
	    <select name="select2" id="select" onchange="changePage(this)">
          <? for ($i=0;$i<$pagenum;$i++) {?>
          <option value="<?=$i+1 ?>" <? if ($curpage==($i)) echo "selected";?>>&nbsp;
          <?=$i+1?>
  &nbsp;</option>
          <? } ?>
        </select>
	  </strong></p>
	  
       </form>
      <p align="center">&nbsp;</p>
      <p><br>      
      </p>
      <p>&nbsp;</p>
      <p>
        <input class="trhide" name="btnBukti" type="button"  id="btnBukti" onClick="MM_goToURL('parent','loggedin.php?menu=showbukti&uUser=<?=base64_encode($vUser)?>');return document.MM_returnValue" value="Lihat Bukti Pembayaran">      
        <br>
      </p>
      <blockquote>
        <div align="left"></div>
    </blockquote></td>
  </tr>
</table>
<iframe width=188 height=166 name="gToday:datetime:agenda.js:gfPop:plugins_time.js" id="gToday:datetime:agenda.js:gfPop:plugins_time.js" src="ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>
<iframe width=188 height=166 name="gToday:datetime:agenda.js:gfPop2:plugins_time2.js" id="gToday:datetime:agenda.js:gfPop2:plugins_time2.js" src="ipopeng.htm" scrolling="no" frameborder="0" style="z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>
