
<div class="col-lg-12">
  <? if ($vCurrent=='mdm_korwil_sub') { ?>      
          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_genealogi")) { ?> <input alt="Detail / Verifikasi Data" name="btDetail<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btDetail<?=$vSeq?>" onClick="return MM_goToURL('parent','../manager/profile.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Detail / Verifikasi Data &raquo;" onMouseovers="showhint('Lihat detail /  Edit Member '+getValue(), this, event, '220px')" style="margin-top:5px" >  <? }  ?>  
		  
<? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWallet<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btWallet<?=$vSeq?>" onClick="return MM_goToURL('parent','../memstock/reorderfund.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Entri Pembayaran &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? }

}
 ?>		        
         

          <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btWallet<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btWallet<?=$vSeq?>" onClick="return MM_goToURL('parent','../memstock/payhistory.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="History Pembayaran &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>		  
          
   <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btBawaan<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btBawaan<?=$vSeq?>" onClick="return MM_goToURL('parent','../manager/databring.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Barang Bawaan &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>
 
 
 <? if (true || $oSystem->checkPriv($vUser,"mdm_listprof_uwallet")) { ?><input name="btIdent<?=$vSeq?>" type="button" class="btn btn-success btn-sm" id="btIdent<?=$vSeq?>" onClick="return MM_goToURL('parent','../manager/dataident.php?current=<?=$vCurrent?>&op=<?=$vSpy?>'+CryptoJS.MD5(getValue().trim())+'&uMemberId='+getValue());return document.MM_returnValue" value="Kelengkapan Identitas &raquo;" onMouseovers="showhint('Nex-Wallet '+getValue(), this, event, '210px')" style="margin-top:5px" /> <? } ?>   
          


      </div>
	  
	  