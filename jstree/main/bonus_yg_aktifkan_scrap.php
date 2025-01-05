<?
			//Bonus RO bagi yg mengaktifkan
			if ($_SESSION['Priv']=='administrator')
				$vLastBal=$oMember->getMemFieldAdm('fsaldoro',$vUserL);
			else	
				$vLastBal=$oMember->getMemField('fsaldoro',$vUserL);
			$vNewBal=$vLastBal + $vBonusRO;
			$vUserL=$_SESSION['LoginUser'];
			$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax) "; 
			$vsql.="values ('$vUserL', '$pID', now(),'Bonus RO dari rekrutmen $pID' , $vBonusRO,0 ,$vNewBal ,'ro' , '1','$vUserL' , now(),$vSponFeeAdm) "; 
			$db->query($vsql); 
			
			if ($_SESSION['Priv']=='administrator')
			   $oMember->updateBalConnROAdm($vUserL,$vNewBal,$db);
			else   
			   $oMember->updateBalConnRO($vUserL,$vNewBal,$db);



			$vLastBal=$oMember->getMemField('fsaldoro',$vSponsor);
			$vNewBal=$vLastBal + $vSponFeeRO;

			$vsql="insert into tb_mutasi_ro (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax) "; 
			$vsql.="values ('$vSponsor', '$pID', now(),'Bonus sponsor dari rekrutmen $pID' , $vSponFeeRO,0 ,$vNewBal ,'spon' , '1','$vUserL' , now(),$vSponFeeAdm) "; 
			$db->query($vsql); 
			
		   $oMember->updateBalConnRO($vSponsor,$vNewBal,$db);

?>