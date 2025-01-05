<?
  $vRefUser=$_GET['uMemberId'];
  if ($vRefUser!="")
  	 $vUser=$vRefUser;
 
  $vAwal=$_POST['dc'];
  $vAkhir=$_POST['dc1'];
  $vCrit=$_POST['tfCrit'];
  $vAction=$_POST['hAction'];
  $vUserChoosed=$_GET['uUp'];
  
  if ($vAwal=="") 
     $vAwal=$oPhpdate->getWeekDate(date("Y"),date("W"),true)." 00:00:00";
  if ($vAkhir=="") 
  	 $vAkhir=$oPhpdate->getWeekDate(date("Y"),date("W"),false)." 23:59:59"; 
	 $vOpsi=$_POST['rbOpsi'];

  if ($vOpsi != "vRT" && $vCrit!="") {
 
	  if (($oNetwork->hasDownline($vCrit) !=1) && isset($vCrit)) $vCrit=$oNetwork->getUpline($vCrit);
	  if ($vUserChoosed=="") $vUserChoosed=$vUser;
	  if ($vAction=="cari") { 
		  if ($oNetwork->isInNetwork($vCrit,$vUser)==1)
			 $vUserChoosed=$vCrit; 
		  else
			 $oSystem->jsAlert("Downline tidak ada, atau tidak berada dalam jaringan Anda!");	 
		}	 
  }
	 
 
?>
<script language="javascript">
  function doClick(obj) {
    if (obj.value=="vRT") {
	      document.demoform.tfCrit.disabled=true;
		  document.demoform.btnCari.disabled=true;
		  document.demoform.btnRefresh.disabled=false;	   	   
		  document.demoform.tfCrit.value="";
	   	  document.demoform.dc.disabled=false;
	      document.demoform.dc1.disabled=false;		  
	   }
	else {   
	alert('Isikan ID downline yang Anda cari!'); 
	   document.demoform.tfCrit.disabled=false;
	   document.demoform.tfCrit.focus();
	   document.demoform.btnCari.disabled=false;	   
	   document.demoform.btnRefresh.disabled=true;	   	   
	   document.demoform.dc.disabled=true;
	   document.demoform.dc1.disabled=true;
	   
	}   
  
  }
</script>
<link href="netto.css" rel="stylesheet" type="text/css">
<table width="100%" height="123" border="0" cellpadding="0" cellspacing="0" class="contentfont">
  <tr align="center" valign="top"> 
    <td colspan="8" valign="top" class="verdanabold">
      <br>
      Genealogi Jaringan (
      <?=$vUser?> 
      - 
      <?=$oMember->getMemberName($vUser)?>
    )      
    <hr>    </td>
  </tr>
  <tr align="center" valign="top">
    <td colspan="8" valign="top"><form method="post" name="demoform">
        <div align="left"><strong><strong><strong>
          <input name="rbOpsi" type="radio" id="rbOpsi" value="vDL" <? if ($vOpsi=="vDL") echo "checked";  ?> onclick="doClick(this)" />
        </strong></strong>Cari Downline
          </strong>
            <br />
          <input name="tfCrit" type="text" class="inputborder" id="tfCrit" value="<?=$vCrit?>" disabled="disabled" onkeyup="this.value=this.value.toUpperCase()">      
        &nbsp;
          <input name="btnCari" type="submit" id="btnCari" value="Cari" disabled="disabled">
        <input name="hAction" type="hidden" id="hAction" value="cari">
        <br />  
        <strong>        </strong></div><strong>
      <label></label>
      <div align="left"><strong>
        <label> <br />
        </label>
        <strong>
        <input name="rbOpsi" type="radio" id="rbOpsi" value="vRT" <? if ($vOpsi=="vRT") echo "checked";  ?> onclick="doClick(this)" />
        </strong>      </strong>Range Tanggal      </div>
      </strong>
      <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif"><strong> </strong>
            <input name="dc" class="inputborder" id="dc" value="<?=$vAwal?>" size="20" disabled="disabled" />
            <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.demoform.dc);return false;" ><img src="calbtn.gif" alt="" name="popcal" width="34" height="22" border="0" align="absmiddle" id="popcal" /></a> <strong>s/d</strong>
            <input class="inputborder" name="dc1" size="20" value="<?=$vAkhir?>" disabled="disabled" />
            <a href="javascript:void(0)" onclick="if(self.gfPop2)gfPop2.fPopCalendar(document.demoform.dc1);return false;" ><img src="calbtn.gif" alt="" name="popcal" width="34" height="22" border="0" align="absmiddle" id="popcal" /></a></font>
        <input name="btnRefresh" type="submit" id="btnRefresh" value="Refresh" disabled="disabled" />
      </div>
    </form></td>
  </tr>
  <tr>
    <td valign="top"><div align="center">
      <br>
      <table width="100%" border="1" cellspacing="0" cellpadding="0">
        <tr>
          <td><div align="center">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="contentfontnoback">
              <tr valign="middle">
                <td width="5%" align="center" bgcolor="#FFCC66">
                  <div align="center"><strong><img src="images/geneatop.png" width="30" height="48" align="middle"> <br>
                                  </strong></div></td>
                <td width="8%" align="center" bgcolor="#FFCC66"><strong>
                  <?
			   $vUp=$_GET['uUp'];
			   if ($vUp=="") $vUp=$vUser;
			   if (isset($vCrit)) $vUp=$vCrit;
			   if (strlen($vUp)>2) $vUserChoosed=$vUp;
			   $vName=$oMember->getMemberName($vUserChoosed);
			   $vKota=$oMember->getKota($vUserChoosed);
			   $vAlamat=$oMember->getAlamat($vUserChoosed);
			   $vEmail=$oMember->getEmail($vUserChoosed);
			   $vNoHP=$oMember->getNoHP($vUserChoosed);
			   $vAktif=$oMember->getActivationDate($vUser);
			   $vAktif=$oPhpdate->YMD2DMY($vAktif,"-");
			   $vUpline=$oNetwork->getUpline($vUserChoosed);
			   //if (strlen($vUpline)>2)
			    //  $vUserChoosed= 
			   echo strtoupper($vUserChoosed);
			?>
                </strong></td>
                <td width="14%" align="center" bgcolor="#FFCC66"><div align="left"><strong>
                    <?=$vName?>
                                </strong></div></td>
                <td width="9%" align="center" bgcolor="#FFCC66"><strong>
                    <? if (strtoupper($vUserChoosed)!=strtoupper($vUser)) { ?>
					<a href="?menu=genealogi&uUp=<?=$vUpline?>&uMemberId=<?=$vRefUser?>"><img src="images/arrowup.png" border="0" ></a>
					<? } ?>
                    <br>
      [
      <?
	     if ($vOpsi=="vRT")
		    echo $oNetwork->getDownlineCountByDateRange($vUserChoosed,$vAwal,$vAkhir);
		 else
		    echo $oNetwork->getDownlineCount($vUserChoosed)
	  
	  ?>
      ]</strong></td>
              </tr>
              <tr valign="middle">
                <td colspan="4" align="center" bgcolor="#FFCC66"><hr /></td>
                </tr>
              <tr valign="top">
                <td colspan="4"><div align="center"  ><img src="images/greendown.png" width="55" height="68"></div></td>
              </tr>
              <tr valign="top">
                <td colspan="4"><hr /></td>
              </tr>
              <tr>
                <?
			 $vOut=$oNetwork->getDownline($vUserChoosed);
			 if (is_array($vOut))
			    $vOutCount=count($vOut);
			 else	
			   $vOutCount=0;
			 for ($i=0;$i<$vOutCount;$i++) {
			   $vName=$oMember->getMemberName($vOut[$i]);
			   $vKota=$oMember->getKota($vOut[$i]);
			   $vAlamat=$oMember->getAlamat($vOut[$i]);
			   $vEmail=$oMember->getEmail($vOut[$i]);
			   $vNoHP=$oMember->getNoHP($vOut[$i]);
			   $vAktif=$oMember->getActivationDate($vOut[$i]);
			   $vAktif=$oPhpdate->YMD2DMY($vAktif,"-");
		  ?>
                <td colspan="4" bgcolor="#99CCFF">
                  <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0" class="contentfontnoback" >
                    
					<tr>
                      <td width="13%" height="10">
                        <div align="center"><img src="images/man.gif" width="19" height="31" align="absmiddle"> <font color="#FF0000">[Level <?echo $oNetwork->getDistance($vOut[$i],$vUser)?>] </font> </div></td>
                      <td width="7%">
                        <?=$vOut[$i]?>                      </td>
                      <td width="17%"><?=$vName?></td>
                      <td width="3%"> 
					  [<?
					  	if ($vOpsi=="vRT")
		    			   echo $vDown=$oNetwork->getDownlineCountByDateRange($vOut[$i],$vAwal,$vAkhir);
						else
					  	   echo $vDown=$oNetwork->getDownlineCount($vOut[$i])?>
					  ]
                          <? if ($vDown>0) { ?>
                          <a href="?menu=genealogi&uUp=<?=$vOut[$i]?>&uMemberId=<?=$vRefUser?>"><img src="images/arrowdown.png" border="0"></a>
                          <? } ?>
                          <br>                      </td>
                    </tr>
                </table></td>
              </tr>
              <? } ?>
			  <? if ($vOutCount<=0) { ?>
			  <tr><td colspan="4"><strong>No Downline</strong></td></tr>
			  <? } ?>
            </table>
          </div></td>
        </tr>
      </table>
        </div></td>
  </tr>
  <tr><td><table width="100%"  border="0" cellspacing="1" cellpadding="1" class="contentfont" height="<? echo($_SESSION['leftheight'] -700);?>">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table></td>
  </tr>
</table>
<iframe width=188 height=166 name="gToday:datetime:agenda.js:gfPop:plugins_time.js" id="gToday:datetime:agenda.js:gfPop:plugins_time.js" src="ipopeng.htm" scrolling="no" frameborder="0" style="visibility:visible; z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>
<iframe width=188 height=166 name="gToday:datetime:agenda.js:gfPop2:plugins_time2.js" id="gToday:datetime:agenda.js:gfPop2:plugins_time2.js" src="ipopeng.htm" scrolling="no" frameborder="0" style="z-index:999; position:absolute; top:-500px; left:-500px;">
</iframe>
