<div class="row" style="text-align:left">
  <div class="col-lg-12">
  <? if ($vCurrent=='mdm_admin') { ?>      
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?> <input alt="Detail / Verifikasi Data" name="btDetail<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btDetail<?=$vSeq?>" onClick="return MM_goToURL('parent','../manager/profile.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Detail / Verifikasi Data &raquo;" onMouseovers="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? }  ?>        
          
          

          

         <!-- <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_detail")) { ?> <input alt="Member Activation" name="btActiv" type="button" class="btn btn-success btn-sm" id="btActiv" onClick="return MM_goToURL('parent','../memstock/activationadm.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Actvation&raquo;" onMouseovers="showhint('Aktiifasi Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? } ?>       



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstock")) { ?><input name="btStock" type="button" class="btn btn-success btn-sm" id="btStock" onClick="return MM_goToURL('parent','../memstock/rptstockphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Reseller Stock &raquo;" onMouseovers="showhint('Stock MS '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> -->



         <!--  <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repkit")) { ?><input name="btKit" type="button" class="btn btn-success btn-sm" id="bKit" onClick="return MM_goToURL('parent','../memstock/rptkitphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Agent KIT Report &raquo;" onMouseovers="showhint('KIT Agent '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> -->

 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWallet<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btWallet<?=$vSeq?>" onClick="return MM_goToURL('parent','../memstock/reorderfund.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Entri Pembayaran &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>
 
 
 
 

          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWallet<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btWallet<?=$vSeq?>" onClick="return MM_goToURL('parent','../memstock/payhistory.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="History Pembayaran &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWalletProd<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btWalletProd<?=$vSeq?>" onClick="return MM_goToURL('parent','../memstock/recompass.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Rekom Pengurusan Paspor &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>


          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btBawaan<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btBawaan<?=$vSeq?>" onClick="return MM_goToURL('parent','../manager/databring.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Barang Bawaan &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btTrBawaan<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btTrBawaan<?=$vSeq?>" onClick="return MM_goToURL('parent','../manager/terimabawa.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="T. Terima Bawaan &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>
 
 
 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btIdent<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btIdent<?=$vSeq?>" onClick="return MM_goToURL('parent','../manager/dataident.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Kelengkapan Identitas &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>           

 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btTrDoku<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btTrDoku<?=$vSeq?>" onClick="return MM_goToURL('parent','../manager/terimaident.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="T. Terima Identitas &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

          <? if (true) { ?><input name="btWalletKit<?=$vSeq?>" type="button" class="btn btn-success btn-sm"  id="btWalletKit<?=$vSeq?>"  onClick="return MM_openBrWindow('../memstock/kuitansi.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&no='+document.getElementById('lmAngs').value+'&uMemberId='+getValue(),'wKui','');return document.MM_returnValue" value="Kuitansi Angs  &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> 
		  <select id="lmAngs" name="lmAngs" style="max-width:45px;height:28px" onChange="document.getElementById('lmAngs1').value=this.value" >
                   <option value="1">1</option>
                   <option value="2">2</option>
                   <option value="3">3</option>
                   <option value="4">4</option>
                   <option value="str">Setoran Awal</option>
                   <option value="lns">Pelunasan</option>
          </select>
		  <? } ?>

          

                    <? if (true) { ?><input name="btWalletAcc<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btWalletAcc<?=$vSeq?>" onClick="return MM_openBrWindow('../memstock/invoiceamh.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&no='+document.getElementById('lmInvo').value+'&uMemberId='+getValue());return document.MM_returnValue" value="Invoice Setoran &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" />
                    <select id="lmInvo" name="lmInvo" style="max-width:45px;height:28px;display:none" onChange="document.getElementById('lmInvo1').value=this.value" >
               <option value="1">1</option>
               <option value="2">2</option>
               <option value="3">3</option>
               <option value="4">4</option>
               <option value="str">Setoran Awal</option>
               <option value="lns">Pelunasan</option>
               </select>
                     <? } ?>
<? } //admin ?>
 
 <? if ($vCurrent=='mdm_memnet') { ?>      
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?> <input alt="Detail / Verifikasi Data" name="btKontak<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="Kontak<?=$vSeq?>" onClick="return MM_goToURL('parent','../manager/contactfam.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Kontak Tidak Serumah &raquo;" onMouseovers="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? }  }?>        
          
                    
<? if ($vCurrent=='mdm_operator') { ?>                          
                    <? if (true) { ?><input name="btDataFull<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btDataFull<?=$vSeq?>" onClick="return MM_goToURL('parent','../manager/datafull.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Kelengkapan Data &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>


<? } //operator ?>
          
<input name="btPrint<?=$vSeq?>" type="button" class="btn btn-success btn-sm"  id="btPrint<?=$vSeq?>"  onClick="return MM_openBrWindow('../manager/printreg.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&no=&uMemberId='+getValue(),'wKui','');return document.MM_returnValue" value="Print Data Registrasi Jamaah  &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" />
          

          <!-- <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWallet" type="button" class="btn btn-success btn-sm" id="btWallet" onClick="return MM_goToURL('parent','../memstock/ewalletrobalphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="RO-Wallet  &raquo;" onMouseovers="showhint('RO Wallet  '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> -->

          

          <!-- 

                    <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btState3" type="button" class="btn btn-success btn-sm" id="btState3" onClick="return MM_goToURL('parent','../memstock/statementphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Weekly Statement &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /><? } ?>



                    <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btState4" type="button" class="btn btn-success btn-sm" id="btState2" onClick="return MM_goToURL('parent','../memstock/statementmophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Monthly Statement &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /><? } ?> -->

          

<!--

          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_walladj")) { ?><input name="btKoreksi" type="button" class="btn btn-success btn-sm" id="bKoreksi" onClick="return MM_goToURL('parent','../manager/koreksi.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Koreksi Saldo &raquo;" onMouseovers="showhint('Nex-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

          

<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_walladj")) { ?><input name="btKoreksiAu" type="button" class="btn btn-success btn-sm" id="bKoreksiAu" onClick="return MM_goToURL('parent','../manager/koreksiro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Koreksi Saldo Automain &raquo;" onMouseovers="showhint('Nex-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>          

          

 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btEfund" type="button" class="btn btn-success btn-sm" id="btEfund" onClick="return MM_goToURL('parent','../manager/efundmem.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Entri Automain eFund &raquo;" onMouseovers="showhint('Nex-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>          

          

 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_walladj")) { ?><input name="btSet" type="button" class="btn btn-success btn-sm" id="btSet" onClick="return MM_goToURL('parent','../manager/koreksistockist.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Set Saldo Jaminan Stockist &raquo;" onMouseovers="showhint('Nex-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

           

        <!--  <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_walladj")) { ?><input name="btKoreksiRO" type="button" class="btn btn-danger btn-sm" id="bKoreksiRO" onClick="return MM_goToURL('parent','../manager/koreksirophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="RO-Wallet Correction &raquo;" onMouseovers="showhint('RO-Wallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> 



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstinout")) { ?><input name="btStWallet" type="button" class="btn btn-success btn-sm" id="btStWallet" onClick="return MM_goToURL('parent','../memstock/stockbalphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock In/Out Report &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

          

          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstinout")) { ?><input name="btStWallet1" type="button" class="btn btn-success btn-sm" id="btStWallet1" onClick="return MM_goToURL('parent','../memstock/stockbalrophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="St In/Out Rpt (RO Items) &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstinout")) { ?><input name="btStWallet2" type="button" class="btn btn-success btn-sm" id="btStWallet2" onClick="return MM_goToURL('parent','../memstock/rptstockphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock Position &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>





          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repstinout")) { ?><input name="btStWallet3" type="button" class="btn btn-success btn-sm" id="btStWallet3" onClick="return MM_goToURL('parent','../memstock/rptstockrophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock Position (RO Items) &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>

          



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_stockadj")) { ?><input name="btKoreksiSt" type="button" class="btn btn-success btn-sm" id="bKoreksiSt" onClick="return MM_goToURL('parent','../manager/koreksistockphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock Adjustment &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>



                    <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_stockadj")) { ?><input name="btKoreksiSt4" type="button" class="btn btn-success btn-sm" id="bKoreksiSt4" onClick="return MM_goToURL('parent','../manager/koreksistockrophp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Stock Adjustment (RO Items) &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /><? } ?>-->

<!--
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_reporderhist")) { ?><input name="btHist" type="button" class="btn btn-success btn-sm" id="btHist" onClick="return MM_goToURL('parent','../memstock/historyro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="History Penjualan &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>



         <!--  <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repspon")) { ?><input name="btSpon" type="button" class="btn btn-success btn-sm" id="btSpon" onClick="return MM_goToURL('parent','../memstock/stjaringanphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Sponsorship Report &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?> -->


<!--
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btGenea" type="button" class="btn btn-success btn-sm" id="btGenea" onClick="return MM_goToURL('parent','../memstock/genealogi2.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Genealogi &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>



         <? if (false) { ?><input name="btGeneaS" type="button" class="btn btn-success btn-sm" id="btGeneaS" onClick="return MM_goToURL('parent','../memstock/genealogispon.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Genealogi Unilevel &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

         

         

		<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBP" type="button" class="btn btn-success btn-sm" id="btBBP" onClick="return MM_goToURL('parent','../memstock/rptbnssponreal.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Pengembangan Tim &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>



		<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBP" type="button" class="btn btn-success btn-sm" id="btBBP" onClick="return MM_goToURL('parent','../memstock/pairing.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Pengembangan Harian &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        

<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBPcf" type="button" class="btn btn-success btn-sm" id="btBBPcf" onClick="return MM_goToURL('parent','../memstock/pairingcf.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Carry Forward Bonus &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>        



		<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBP" type="button" class="btn btn-success btn-sm" id="btBBP" onClick="return MM_goToURL('parent','../memstock/rptbnsmatch.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Royalti &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>



        

		<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBP" type="button" class="btn btn-success btn-sm" id="btBBP" onClick="return MM_goToURL('parent','../memstock/rptprivro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Belanja Pribadi &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btBBG" type="button" class="btn btn-success btn-sm" id="btBBG" onClick="return MM_goToURL('parent','../memstock/rptgroupro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Pengembangan Bulanan &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="BtBMM" type="button" class="btn btn-success btn-sm" id="BtBMM" onClick="return MM_goToURL('parent','../memstock/rptmegamatch.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Penghargaan Kepemimpinan &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        

        <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="BtBMM3" type="button" class="btn btn-success btn-sm" id="BtBMM3" onClick="return MM_goToURL('parent','../memstock/rptmegamatch.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Klub Presiden &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

        

        <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btRoHist" type="button" class="btn btn-success btn-sm" id="btRoHist" onClick="return MM_goToURL('parent','../memstock/historyro.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="RO History &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>





 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btOneRoHist" type="button" class="btn btn-success btn-sm" id="btOneRoHist" onClick="return MM_goToURL('parent','../memstock/rptrostockist.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Onetime + RO Stockist &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

 

 

 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?><input name="btPoinStock" type="button" class="btn btn-success btn-sm" id="btPoinStock" onClick="return MM_goToURL('parent','../memstock/rptpoinstockist.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Poin Stockist &raquo;" onMouseovers="showhint('Genealogi Unilevel '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?> -->

 

         <!-- <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_reppair")) { ?><input name="btPair" type="button" class="btn btn-success btn-sm" id="btPair" onClick="return MM_goToURL('parent','../memstock/pairingphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Komisi Pair Report &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repcf")) { ?><input name="btCF" type="button" class="btn btn-success btn-sm" id="btCF" onClick="return MM_goToURL('parent','../memstock/pairingcfphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="CF Omzet &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp; <? } ?>



          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repcf")) { ?><input name="btCFR" type="button" class="btn btn-success btn-sm" id="btCFR" onClick="return MM_goToURL('parent','../memstock/pairingcfrealphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="CF Real &raquo;" onMouseovers="showhint('UWallet Correction '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp; <? } ?>





          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repwd")) { ?><input name="btWD" type="button" class="btn btn-success btn-sm" id="btWD" onClick="return MM_goToURL('parent','../memstock/withdrawphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Withdraw History &raquo;" onMouseovers="showhint('Withdraw History '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>

          

          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_repwd")) { ?><input name="btRoyal" type="button" class="btn btn-success btn-sm" id="btRoyal" onClick="return MM_goToURL('parent','../memstock/bnsroyaltyphp?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Bns Royalty Preview &raquo;" onMouseovers="showhint('Withdraw History '+getValue(), this, event, '210px')" style="margin-top:5px" />&nbsp;<? } ?>       -->   



      </div>

      </div>