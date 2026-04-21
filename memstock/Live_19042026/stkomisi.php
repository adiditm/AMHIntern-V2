<?
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
  $vDeep=$oRules->getRealMaxLevel(1);
  $vCoup=$oRules->getSettingByField("ffeecouple",1);
  $vSponsor=$oRules->getSponFee(1);
if ($vTanggal=="")
   $vTanggal=$oPhpdate->getNowYMD("-");  
?>
<link href="netto.css" rel="stylesheet" type="text/css">




<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.style1 {
	color: #0000FF;
	font-weight: bold;
}
.style3 {color: #FFFF00}
.style4 {font-weight: bold}
-->
</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" dwcopytype="CopyTableRow" class="contentfont">
  <!--DWLayoutTable-->
  <tr> 
    <td width="618" height="18" align="center" valign="middle"> <p><font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="3">Status 
        Komisi (Total)</font><br>
    </strong></font></p></td>
  </tr>
  <tr> 
    <td height="5" align="center" valign="middle"> <hr> </td>
  </tr>
  <tr> 
    <td height="5" align="center" valign="middle"> <font face="Verdana, Arial, Helvetica, sans-serif"> 
     <?
		$vYear=date('Y');
		$hariIni=date("Ymd");
		$thn=substr($hariIni,0,4);
		$bln=substr($hariIni,4,2);
		$tgl=substr($hariIni,6,2);
		$tglSekarang=$thn."-".$bln."-".$tgl;

	?>
      </font> 
      <table width="57%" border="0" cellpadding="0" cellspacing="0" class="contentfont">
        <tr> 
          <td width="35%"> <div align="left">N A M A</div></td>
          <td width="4%">:</td>
          <td width="61%"><div align="left">
            <?=$oMember->getMemberName($vUser)?>
          </div></td>
        </tr>
        <tr> 
          <td><div align="left">User ID</div></td>
          <td>:</td>
          <td><div align="left">
            <?=$vUser?>
          </div></td>
        </tr>
        <tr> 
          <td><div align="left">Sponsor</div></td>
          <td>:</td>
          <td>            <div align="left">
            <?=$oNetwork->getSponsor($vUser)?>
(
<?=$oMember->getMemberName($oNetwork->getSponsor($vUser))?>
) </div></td>
        </tr>
        <tr> 
          <td><div align="left">Upline</div></td>
          <td>:</td>
          <td>            <div align="left">
            <?=$oNetwork->getUpline($vUser)?>
(
<?=$oMember->getMemberName($oNetwork->getUpline($vUser))?>
) </div></td>
        </tr>
      </table>	  
    </td>
  </tr>
  <tr> 
    <td height="5" align="center" valign="middle"> <hr> </td>
  </tr>
  <tr> 
    <td height="5" align="center" valign="middle"> <table width="75%" border="0" cellpadding="0" cellspacing="0" class="contentfont">
        <tr> 
          <td align="center"><strong><?=$oMember->getBank($vUser)?></strong></td>
        </tr>
        <tr> 
          <td align="center">Nomor Rekening <strong>
            <?=$oMember->getRekening($vUser)?>
            </strong></td>
        </tr>
        <tr> 
          <td align="center">Atas nama <strong>
            <?=$oMember->getAtasNama($vUser)?>
            </strong></td>
        </tr>
        
      </table></td>
  </tr>

  <tr> 
    <td height="5" align="center" valign="middle"> <hr> </td>
  </tr>
  <tr> 
    <td height="5" align="center" valign="middle"> <font face="Verdana, Arial, Helvetica, sans-serif"><strong></strong></font></td>
  </tr>
  <tr> 
    <td height="5" align="center" valign="top"> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="3"><br />
      </font></strong></font>
        <form id="demoform" name="demoform" method="post" action="" class="trhide">
          <p><font face="Verdana, Arial, Helvetica, sans-serif"><strong>Mulai Tanggal : </strong>
            <input name="dc" class="inputborder" id="dc" value="<?=$vAwal?>" size="20" />
                <a href="javascript:void(0)" onclick="if(self.gfPop)gfPop.fPopCalendar(document.demoform.dc);return false;" ><img src="calbtn.gif" alt="" name="popcal" width="34" height="22" border="0" align="absmiddle" id="popcal" /></a> <strong>s/d</strong>
            <input class="inputborder" name="dc1" size="20" value="<?=$vAkhir?>" />
                <a href="javascript:void(0)" onclick="if(self.gfPop2)gfPop2.fPopCalendar(document.demoform.dc1);return false;" ><img src="calbtn.gif" alt="" name="popcal" width="34" height="22" border="0" align="absmiddle" id="popcal" /></a>&nbsp;&nbsp;
            <input name="Submit22" type="submit" class="smallbutton" value="   Lihat   " />
            </font></p>
        </form>
        <font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="3"></font></strong></font><font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="3"><br />
      Komisi Sponsor </font></strong></font><br>
      </div>      
    <table width="500" border="1" align="center" cellpadding="0" cellspacing="0" bordercolordark="#33FF99" class="contentfontnoback">
        <tr bgcolor="#CCCCFF"> 
          <td width="28%" height="5"  align="center"> <span class="style1">Jumlah Sponsorship </span>         </td>
          <td width="27%" align="center" bgcolor="#CCCCFF"><span class="style1">Komisi Sponsor </span></td>
          <td width="45%" align="center"><span class="style1">Jumlah Komisi</span></td>
        </tr>
        
        <tr bgcolor="#FFFFCC"> 
          <td align="center"> <font color="#000000"> 
            <?
			  $vJmlSponsor=$oNetwork->getSponsorshipCount($vUser);
			   echo number_format($vJmlSponsor,0,',','.');
			?>
            </font></td>
          <td align="center"> <div align="right"><font color="#000000">Rp. 
              <?
			 $vKomSpon=$vJmlSponsor * $vSponsor;
			 echo number_format($vSponsor,0,',','.');
		  ?>
          </font></div></td>
          <td align="center"> <div align="right"><font color="#000000">Rp. 
              <?
			 if($oMember->isFree($vUser)==1)
			     $vKomSpon=$vJmlSponsor * $vSponsor * 0;
			 else if ($oMember->isActive($vUser)==1)	 
			     $vKomSpon=$vJmlSponsor * $vSponsor;
			 echo number_format($vKomSpon,0,',','.');
		  ?>
          </font></div></td>
        </tr>
      </table>
      <p align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="3"><br>
        Komisi 
          Pasangan</font></strong></font> </p>
      <table width="500" border="1" align="center" cellpadding="0" cellspacing="0" bordercolordark="#33FF99" class="contentfontnoback">
        <tr bgcolor="#CCCCFF">
          <td width="28%" height="5"  align="center"><span class="style1">Jumlah Pasangan </span> </td>
          <td width="27%" align="center" bgcolor="#CCCCFF"><span class="style1">Komisi Pasangan </span></td>
          <td width="45%" align="center"><span class="style1">Jumlah Komisi</span></td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td align="center"><font color="#000000">
            <?
			  $vTomorrow=$oMydate->dateAdd(date("Y-m-d"),1,"day");
			  $vJmlCoup=$oKomisi->getAllCoupFee($vUser,$vTomorrow)/$vCoup;
			   echo number_format($vJmlCoup,0,',','.');
			?>
          </font></td>
          <td align="center"><div align="right"><font color="#000000">Rp.
            <?
			 
			 echo number_format($vCoup,0,',','.');
		  ?>
          </font></div></td>
          <td align="center"><div align="right"><font color="#000000">Rp.
                <?
	     	 $vKomCoup=$oKomisi->getAllCoupFee($vUser,$vTomorrow);
			 echo number_format($vKomCoup,0,',','.');
		  ?>
          </font></div></td>
        </tr>
      </table>
      <div style="display:none">
      <p align="center" ><font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="3">Komisi Matching </font></strong></font> <br />
        <span class="style1">Rp 1000 / Generasi Sponsor, dari jaringan yang mendapatkan komisi Pasangan</span></p>
      <table width="500" border="1" align="center" cellpadding="0" cellspacing="0" bordercolordark="#33FF99" class="contentfontnoback">
        <tr bgcolor="#CCCCFF">
          <td width="45%" height="5" align="center"><span class="style1">Jumlah Komisi </span></td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td align="center"><div align="right"><font color="#000000">Rp.
            <?
	     	 $vKomMatch=$oKomisi->getAllMatchFee($vUser,$vTomorrow);
			 $vKomMatch=0;
			 echo number_format($vKomMatch,0,',','.');
		  ?>
          </font></div></td>
        </tr>
      </table>
	  </div>
      <p><font face="Verdana, Arial, Helvetica, sans-serif"> </font></p>
      <p style="display:" align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="3">Komisi Titik </font></strong></font> </p>      
      <table style="display:" width="500" border="1" align="center" cellpadding="0" cellspacing="0" bordercolordark="#33FF99" class="contentfontnoback">
        <tr bgcolor="#CCCCFF">
          <td width="34%" align="center"><span class="style1">Jumlah Komisi </span></td>
        </tr>
        <?php
		$vTotMat=0;
		for ($i=1;$i<=$vDeep;$i++)
		{
		  $vMatrix=$oRules->getLevelFeeByID($i,1);
		?>
        
        <?
		}
		?>
        <tr bgcolor="#FFFFCC">
          <td align="center">
            <div align="right"><font color="#000000">
            
              <font color="#000000">Rp. 
              
              <?
	     	 $vTotMat=$oKomisi->getKomLevel($vUser,$vTomorrow);
			 echo number_format($vTotMat,0,',','.');
		  ?>
            </font></font></div></td>
        </tr>
      </table>
      <p><font face="Verdana, Arial, Helvetica, sans-serif"> <br>
      </font></p>
      <table width="500" border="1" align="center" cellpadding="0" cellspacing="0" bordercolordark="#33FF99" class="trhide">
        <tr bgcolor="#CCCCFF">
          <td width="17%" align="center" bgcolor="#CCCCFF"><span class="style1">Level</span></td>
          <td width="24%" align="center"><span class="style1">Jumlah Downline </span></td>
          <td width="25%" align="center"><span class="style1">Komisi Level </span></td>
          <td width="34%" align="center"><span class="style1">Jumlah Komisi </span></td>
        </tr>
        <?php
		//$vTotMat=0;
		for ($i=1;$i<=$vDeep;$i++)
		{
		  $vMatrix=$oRules->getLevelFeeByID($i,1);
		?>
        <tr bgcolor="#FFFFCC">
          <td align="center"><font color="#000000">
            <?=$i?>
          </font></td>
          <td align="center"><div align="right"> <font color="#000000">
              <?
		   //  $vJmlMember=$oNetwork->getDownlineCountLevelActive($vUser,$i);			 
			 echo number_format($vJmlMember,0,',','.');
		  ?>
          </font></div></td>
          <td align="center" bgcolor="#FFFFCC"><div align="right"> <font color="#000000">
              <?
		     echo number_format($vMatrix,0,',','.');
		  ?>
          </font></div></td>
          <td align="center"><div align="right"><font color="#000000">
            <?
		     //$vJmlMember=$oNetwork->getDownlineCountLevelActive($vUser,$i);
			 if($oMember->isFree($vUser)==1)
			     $vKomMtx=$vJmlMember * $vMatrix * 0;
			 else if ($oMember->isActive($vUser)==1)	 
			     $vKomMtx=$vJmlMember * $vMatrix;
				 
			 //$vTotMat+= $vKomMtx;	 
			 echo number_format($vKomMtx,0,',','.');
		  ?>
          </font></div></td>
        </tr>
        <?
		}
		?>
        <tr bgcolor="#FFFFCC">
          <td align="center"><span class="style1">Jumlah</span></td>
          <td align="center"><div align="right"><strong><font color="#000000">
              <?
		     $vTotMember=$oNetwork->getDownlineCountActive($vUser);			 
			 echo number_format($vTotMember,0,',','.');
		  ?>
          </font></strong></div></td>
          <td align="center"><div align="right">
              <div align="right"></div>
          </div></td>
          <td align="center"><div align="right"><strong><font color="#000000">
            <?
			 echo number_format($vTotMat,0,',','.');
		  ?>
          </font></strong></div></td>
        </tr>
      </table>
      <p align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="4"><font size="3"> Komisi Jaringan </font> </font></strong></font>      </p>
      <table width="500" border="1" align="center" cellpadding="0" cellspacing="0" class="contentfontnoback">
        <tr bgcolor="#CCCCFF"> 
          <td width="10%" align="center"><span class="style1">Komisi</span></td>
          <td width="16%" align="center"><span class="style1">Total Jumlah</span></td>
        </tr>
        <tr bgcolor="#FFFFCC"> 
          <td height="23" align="center"> 
            <div align="left"><font color="#000000">Sponsor</font></div></td>
          <td align="center"> <div align="right"><font color="#000000"> 
          <?
		     if($oMember->isFree($vUser)==1)
			     $vKomSpon=$vJmlSponsor * $vSponsor * 0;
			 else if ($oMember->isActive($vUser)==1)	 
			     $vKomSpon=$vJmlSponsor * $vSponsor;
			 echo number_format($vKomSpon,0,',','.');
		  ?>
              </font></div></td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td align="center"><div align="left"><font color="#000000">Titik</font></div></td>
          <td align="center"><div align="right"> <font color="#000000"> 
              <font color="#000000"> 
              <?
			 echo number_format($vTotMat,0,',','.');
		  ?>
              </font> </font></div></td>
        </tr>
        <tr bgcolor="#FFFFCC"> 
          <td align="center"> <div align="left"><font color="#000000">Pasangan</font></div></td>
          <td align="center"> <div align="right"> <font color="#000000"> 
              <font color="#000000"> 
              <?
			 echo number_format($vKomCoup,0,',','.');
		  ?>
              </font> </font></div></td>
        </tr>
        <tr bgcolor="#FFFFCC" class="trhide">
          <td align="center"><div align="left"><font color="#000000">Matching</font></div></td>
          <td align="center"><div align="right"><font color="#000000"><font color="#000000">
            <?
			 echo number_format($vKomMatch,0,',','.');
		  ?>
          </font></font></div></td>
        </tr>
        
        <tr bgcolor="#FFFFCC"> 
          <td align="center"> <div align="left"><font color="#000000"><strong>Jumlah</strong></font></div></td>
          <td align="center"> <div align="right"><font color="#000000">
		  <?php 
		      $vKomTot=$vKomSpon+$vTotMat+$vKomCoup+$vKomMatch;
		      echo number_format($vKomTot,0,".",".");  
		  
		  ?></font></div></td>
        </tr>
      </table>
      <table width="500" border="1" align="center" cellpadding="0" cellspacing="0" class="trhide">
        <tr bgcolor="#CCCCFF">
          <td width="10%" align="center"><span class="style1">Komisi</span></td>
          <td width="16%" align="center"><span class="style1">Total Jumlah</span></td>
          <td width="18%" align="center"><span class="style1">Telah Dibayarkan</span></td>
          <td width="21%" align="center"><span class="style1">Saldo </span></td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td height="23" align="center"><div align="left"><font color="#000000">Sponsor</font></div></td>
          <td align="center"><div align="right"><font color="#000000">
              <?
		     if($oMember->isFree($vUser)==1)
			     $vKomSpon=$vJmlSponsor * $vSponsor * 0;
			 else if ($oMember->isActive($vUser)==1)	 
			     $vKomSpon=$vJmlSponsor * $vSponsor;
			 echo number_format($vKomSpon,0,',','.');
		  ?>
          </font></div></td>
          <td align="center"><div align="right"> <font color="#000000">
              <?php
		if ($oMember->getRekening($vUser)!=-1) { 
		   $vSponPaid=$oNetwork->getSponPaid($vUser);	  
		   echo number_format($vSponPaid,0,',','.');
		} else
		   echo 0;	  
		  
		  ?>
          </font></div></td>
          <td align="center"><div align="right"> <font color="#000000">
              <? 
			    //$vmatming=get_sponsor_minggu($vkd,date('W'),$vYear);
				$vSaldoSpon = $vKomSpon - $oNetwork->getSponPaid($vUser);
				echo number_format($vSaldoSpon,0,',','.');
			  ?>
          </font></div></td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td align="center"><div align="left"><font color="#000000">Pasangan</font></div></td>
          <td align="center"><div align="right"> <font color="#000000"> <font color="#000000">
              <?
			 echo number_format($vKomCoup,0,',','.');
		  ?>
          </font> </font></div></td>
          <td align="center"><div align="right"> <font color="#000000">
              <?php
	
		   echo $vCoupPaid=0;	  
		  
		  ?>
          </font></div></td>
          <td align="center"><div align="right"><font color="#000000">
              <? 
			    
				$vSaldoCoup = $vKomCoup - $vCoupPaid;
				echo number_format($vSaldoCoup,0,',','.');
			  ?>
          </font></div></td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td align="center"><div align="left"><font color="#000000">Matching</font></div></td>
          <td align="center"><div align="right"><font color="#000000"><font color="#000000">
              <?
			 echo number_format($vKomMatch,0,',','.');
		  ?>
          </font></font></div></td>
          <td align="center"><div align="right"><font color="#000000">
              <?php
	
		   echo $vMatchPaid=0;	  
		  
		  ?>
          </font></div></td>
          <td align="center"><div align="right"><font color="#000000">
              <? 
			    
				$vSaldoMatch = $vKomMatch - $vMatchPaid;
				echo number_format($vSaldoMatch,0,',','.');
			  ?>
          </font></div></td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td align="center"><div align="left"><font color="#000000">Leveling</font></div></td>
          <td align="center"><div align="right"><font color="#000000"><font color="#000000">
              <?
			 echo number_format($vTotMat,0,',','.');
		  ?>
          </font></font></div></td>
          <td align="center"><div align="right"><font color="#000000">
              <?php
		if ($oMember->getRekening($vUser)!=-1) { 
		   $vTotMtxPaid=$oNetwork->getMtxPaid($vUser);	  
		   echo number_format($vTotMtxPaid,0,',','.');
		} else
		   echo 0;	  
		  
		  ?>
          </font></div></td>
          <td align="center"><div align="right"><font color="#000000">
              <? 
			    
				$vSaldoLevel = $vTotMat - $vTotMtxPaid;
				echo number_format($vSaldoLevel,0,',','.');
			  ?>
          </font></div></td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td align="center"><div align="left"><font color="#000000"><strong>Jumlah</strong></font></div></td>
          <td align="center"><div align="right"><font color="#000000"><?php echo number_format($vKomSpon+$vTotMat+$vKomCoup+$vKomMatch,0,".",".");  ?></font></div></td>
          <td align="center"><div align="right"><font color="#000000"><?php echo number_format(($vSponPaid+$vTotMtxPaid+$vCoupPaid+$vMatchPaid),0,".","."); ?></font></div></td>
          <td align="center"><div align="right"><font color="#000000"><?php echo number_format(($vSaldoSpon+$vSaldoLevel+$vSaldoCoup+$vSaldoMatch),0,".","."); ?></font></div></td>
        </tr>
      </table>
      <p><font face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="4"><font size="3"><br />
      Rekap Komisi</font></font></strong></font></p>
      <table width="500" border="1" align="center" cellpadding="0" cellspacing="0" class="contentfontnoback">
        <tr bgcolor="#CCCCFF">
          <td width="17%" align="center"><span class="style1">Jenis Penerimaan Komisi</span></td>
          <td width="18%" align="center"><span class="style1">Nominal</span></td>
          <td width="24%" align="center"><span class="style1">(-) 10% Biaya Admin <span class="style3"> </span></span></td>
          <td width="23%" align="center"><span class="style1">Total Bonus </span></td>
          <td width="18%" align="center"><span class="style1">Saldo Bonus </span></td>
        </tr>
        <tr bgcolor="#FFFFCC">
          <td  align="center"><div align="left"><span class="style4"><font color="#000000">Cash</font> (90%) </span></div></td>
          <td align="center"><div align="right"><font color="#000000"> </font><strong>
              <?
			   
			   $vAllCash= $vKomTot - ($vKomTot * 10/100);
			   
			   echo number_format($vAllCash,"0",",",".");
			   
			   ?>
          </strong></div></td>
          <td align="center"><div align="right"><strong>
              <?
			//$vFeeAdmCount=$oKomisi->getCountCashPaidA($vUser);
			//$vFeeAdmPaid=$vFeeAdm * $vFeeAdmCount;
			$vAllCashNett= $vAllCash - ($vKomTot * 10/100);
			echo number_format($vAllCashNett,"0",",",".");
			?>
          </strong></div></td>
          <td align="center"><div align="right"><strong>
              <?
			   $vCashPaid=$oKomisi->getCashPaidA($vUser);
			   
			   $vCashPaidOri=$vCashPaid * 100/90;
			    $vCashPaidNett= $vCashPaid - ($vCashPaidOri * 10/100) ;
			   echo number_format($vCashPaidNett,"0",",",".")
			?>
          </strong></div></td>
          <td align="center"><div align="right"><strong>
              <?
			   $vCashSaldo=$vAllCashNett-$vCashPaidNett;
			  // if ($vCashSaldo >=$vFeeAdm) $vCashSaldo=$vCashSaldo-$vFeeAdm;
			   echo number_format($vCashSaldo,"0",",",".")
			?>
          </strong></div></td>
        </tr>
      </table>
      <p><br>      
        <input name="cbHistory" type="button" id="cbHistory" onclick="MM_openBrWindow('pophist.php?uID=<?=$vUser?>&amp;hist=a','wHist','width=600,height=700')" value="Statement Bonus" />
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
