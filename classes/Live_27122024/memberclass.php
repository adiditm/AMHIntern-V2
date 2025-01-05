<?php

 //  include_once "../config.php";

   include_once $CLASS_DIR."prefixclass.php";	

   include_once $CLASS_DIR."dateclass.php";	

   include_once $CLASS_DIR."systemclass.php";	   

   include_once $CLASS_DIR."dateclass.php";	  

   include_once $CLASS_DIR."ruleconfigclass.php";	   

  



   

   class member {

 

 		function checkForEmpty() {

            global $oDB; 

			$vres="";

		    $vsql="SELECT count(fidmember) as fjumlah from m_anggota";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fjumlah");

			}

			if ($vres > 0)

	  		   return $vres;

			else

			   return 0;   

		}



        //ambil nomor urut dari ID yang diketahui

		function getNoUrut($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fcount from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fcount");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}

 

        //ambil nama member dari ID yang diketahui

		function getMemberName($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fnama from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fnama");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}



		 //Get Mem Field

		function getMemField($pField,$pId) {

		     global $oDB; 

  			 $vsql="select $pField as fres from m_anggota where fidmember='$pId' ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fres");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return "";   

		}		                

	 //Get Mem Field Tabungan

		function getMemFieldTab($pField,$pId) {

		     global $oDB; 

  			 $vsql="select $pField as fres from m_anggota_tab where fidmember='$pId' ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fres");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return "";   

		}		
		
		
		 //Get  ExistPay

		function isExistPay($pPayKind,$pId) {

		     global $oDB; 

  			  $vsql="select fkind as fres from tb_payhist where fidmember='$pId'  and fkind = '$pPayKind' ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fres");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return "";   

		}		


		 //Get  ExistPaytab

		function isExistPayTab($pPayKind,$pId) {

		     global $oDB; 

  			  $vsql="select fkind as fres from tb_payhisttab where fidmember='$pId'  and fkind = '$pPayKind' ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fres");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return "";   

		}		


		 //Get Mem Field

		function getFieldByField($pSearch,$pResult,$pValue) {

		     global $oDB; 

  			 $vsql="select $pResult as fres from m_anggota where $pSearch='$pValue' ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fres");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return "";   

		}		                



		 //Update Mem Field

		function updateMemField($pField,$pId, $pVal) {

		     global $oDB; 

  			 $vsql="update m_anggota set $pField = '$pVal' where  fidmember='$pId' ";	

			 $oDB->query($vsql);		

		}		                



		 //Get Mem Field

		function getMemFieldAdm($pField,$pId) {

		     global $oDB; 

  			 $vsql="select $pField as fres from m_admin where fidmember=trim('$pId') ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fres");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return -1;   

		}


		 //Get Mem Field Bis

		function getMemFieldBis($pField,$pId) {

		     global $oDB; 

  			 $vsql="select $pField as fres from m_pebisnis where fidmember='$pId' ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fres");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return -1;   

		}


 //Get Mem Field Seller

		function getMemFieldSell($pField,$pId) {
		     global $oDB; 
  			 $vsql="select $pField as fres from m_seller where fidseller='$pId' ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fres");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return -1;   

		}
                

		 //Get Mem Field

		function getMemFieldAdmin($pField,$pId) {

		     global $oDB; 

  			 $vsql="select $pField as fres from m_admin where fidmember='$pId' ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fres");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return -1;   

		}		                

                

        //ambil  ID dari username yang diketahui

		function getIDByUserName($pUsername) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fidmember from m_anggota where fusername='$pUsername' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}



        //ambil  Username dari ID yang diketahui

		function getUserNameByID($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fusername from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fusername");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}



        //ambil password dari ID yang diketahui

		function getPass($pID) {

            global $oDB, $oSystem; 

			$vres="";

		    $vsql="SELECT fpassword from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fpassword");

				

			}

			if ($vres != "")

	  		   return $oSystem->doED('decrypt',$vres);

			else

			   return -1;   

		}











        //ambil ID member dari Nama yang diketahui

		function getMemberID($pAnggota) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fidmember from m_anggota where fnama='$pAnggota' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}



        //CheckUserName

		function checkUserName($pUser) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fusername from m_anggota where fusername='$pUser' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fusername");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}



        //ambil jumlah member yang aktif

		function getActiveMemberCount() {

            global $oDB; 

			$vres="";

		    $vsql="SELECT count(fidmember) as faktifcount from m_anggota where faktif <> '0' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("faktifcount");

			}

			if ($vres > 0)

	  		   return $vres;

			else

			   return -1;   

		}



        //ambil jumlah member yang Free

		function getFreeMemberCount() {

            global $oDB; 

			$vres="";

		    $vsql="SELECT count(fidmember) as ffreecount from m_anggota where faktif = 2 ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("ffreecount");

			}

			if ($vres > 0)

	  		   return $vres;

			else

			   return -1;   

		}



        //ambil jumlah member yang tidak aktif

		function getnoActiveMemberCount() {

            global $oDB; 

			$vres="";

		    $vsql="SELECT count(fidmember) as faktifcount from m_anggota where faktif='0' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("faktifcount");

			}

			if ($vres > 0)

	  		   return $vres;

			else

			   return -1;   

		}











        //ambil serial  dari ID yang diketahui

		function getSerial($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fserno from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fserno");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}





        //ambil PIN  dari ID yang diketahui

		function getPIN($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fpin from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fpin");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}





        //ambil Tanggal Daftar  dari ID yang diketahui

		function getRegDate($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT ftgldaftar from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("ftgldaftar");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}



       //ambil Tanggal Aktif  dari ID yang diketahui

		function getActivationDate($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT ftglaktif from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("ftglaktif");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}





       //ambil Tanggal Aktif  dari ID yang diketahui tanpa waktu

		function getActivationDateOnly($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT ftglaktif from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = substr($oDB->f("ftglaktif"),0,10);

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}



       //ambil Tanggal Aktif  dari ID yang diketahui

		function getIdSys($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fidsys from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidsys");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}





       //ambil Tanggal Aktif  dari ID yang diketahui

		function getUpgradeDate($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT ftglupgrade from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("ftglupgrade");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}



		

       //ambil Reserved Sponsor   dari ID yang diketahui

		function getResSponsor($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fidressponsor from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidressponsor");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}		





       //ambil Reserved Upline  dari ID yang diketahui

		function getResUpline($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fidresupline from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidresupline");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}





       //ambil Batas Transfer

		function getBatasTrans($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fbtstrans from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fbtstrans");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}



       //ambil Batas Transfer Penjualan

		function getBatasTransBuy($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fbtstransbuy from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fbtstransbuy");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}



		

        //check apakah ID Member ada

		function authID($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fidmember from m_anggota where fidmember='$pID' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fidmember");
			}
			if ($vres != "")
	  		   return 1;
			else
			   return 0;   
		}

		function authKor($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fidkorwil from m_korwil where fidkorwil='$pID' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fidkorwil");
			}
			if ($vres != "")
	  		   return 1;
			else
			   return 0;   
		}
		
		
		function authSell($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fidseller from m_seller where fidseller='$pID' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fidseller");
			}
			if ($vres != "")
	  		   return 1;
			else
			   return 0;   
		}

        //check apakah ID Member ada DAN AKTIF

		function authActiveID($pID) {

            global $oDB; 

			$vres="";

		   $vsql="SELECT fidmember from m_anggota where fidmember='$pID' and faktif <> '0'";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}



     //check apakah ID Member ada DAN AKTIF Korwil

		function authKorwilActiveID($pID) {

            global $oDB; 

			$vres="";

		   $vsql="SELECT b.fidmember from m_korwil a left join m_pebisnis b on a.fidbisnis=b.fidmember where b.fidmember='$pID' and a.faktif <> '0'";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}

		function authSponActiveID($pID) {

            global $oDB; 

			$vres="";

		   $vsql="SELECT fidmember from m_pebisnis where fidmember='$pID' and faktif <> '0'";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}

        //check apakah Password cocok

		function authPass($pID,$pPass) {		

            global $oDB, $oSystem; 

			$pID=addslashes($pID);

			$pPass=addslashes($pPass);

			$vres="";

			$pPass=$oSystem->doED('encrypt',$pPass);

		    $vsql="SELECT fidmember from m_anggota where fidmember='$pID' and fpassword='$pPass' and faktif <> '0' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}


      //check apakah Password cocok

		function authSponPass($pID,$pPass) {		

            global $oDB, $oSystem; 

			$pID=addslashes($pID);

			$pPass=addslashes($pPass);

			$vres="";

			//$pPass=$oSystem->doED('encrypt',$pPass);
			$pPass=md5($pPass);

		    $vsql="SELECT a.fidmember from m_pebisnis a left join m_admin b on a.fidmember=b.fidmember where a.fidmember='$pID' and b.fpassword='$pPass' and a.faktif <> '0' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}


    //check apakah Password cocok

		function authKorwilPass($pID,$pPass) {		

            global $oDB, $oSystem; 

			$pID=addslashes($pID);

			$pPass=addslashes($pPass);

			$vres="";

			//$pPass=$oSystem->doED('encrypt',$pPass);
			$pPass=md5($pPass);

		    $vsql="SELECT a.fidmember from m_pebisnis a left join m_korwil b on a.fidmember=b.fidbisnis left join m_admin c on a.fidmember=c.fidmember where b.fidkorwil='$pID' and c.fpassword='$pPass' and b.faktif <> '0' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}

        //check apakah email cocok

		function authEmail($pID,$pEmail) {		

            global $oDB, $oSystem; 

			$pID=addslashes($pID);

			$pEmail=addslashes($pEmail);

			$vres="";

			//$pPass=$oSystem->doED('encrypt',$pPass);

		    $vsql="SELECT fidmember from m_anggota where fidmember='$pID' and femail='$pEmail' and faktif <> '0' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}

        //check apakah Password cocok

		function authPin($pID,$pPin) {		

            global $oDB; 

			$pID=addslashes($pID);

			$pPass=addslashes($pPin);

			$vres="";			

		    $vsql="SELECT fidmember from m_anggota where fidmember='$pID' and fpin='$pPin' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}





        //check apakah Aktif

		function isActive($pID) {

            global $oDB, $oSystem; 

			$vres="";

		    $vsql="SELECT faktif from m_anggota where fidmember COLLATE latin1_general_cs ='$pID' ";	

			

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("faktif");

			}

			if ($vres == "1")

	  		   return 1;

			else

			   return 0;   

		}



        //check apakah Aktif Peuh

		function isFullActive($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT faktif from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("faktif");

			}

			if ($vres == 1)

	  		   return 1;

			else

			   return 0;   

		}





        //check apakah Free Member

		function isFree($pID) {

            global $oDB; 

			$vres="";

		     $vsql="SELECT faktif from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("faktif");

			}

			if ($vres == 2)

	  		   return 1;

			else

			   return 0;   

		}











        //Set Password

		function setPass($pNew, $pID) {

            global $oDB, $oSystem; 

			$vres="";

			$pNew=$oSystem->doED('encrypt',$pNew);

		    $vsql="update m_anggota set fpassword = '$pNew' where fidmember='$pID' ";	

			$vres=$oDB->query($vsql);

			if ($oDB->affected_rows() > 0) {

	  		   $oSystem->jsAlert("Password changed successfully!");

			   return 1;			   

			} else {

			   $oSystem->jsAlert("Error!, kemungkinan karena : ID Member tidak ada, dan atau password sama dengan yang lama!\n\r Yakinkan ID Member ada atau coba dengan password baru! ");

			   return "Error!, kemungkinan karena : ID Member tidak ada, dan atau password sama dengan yang lama!\n\r Yakinkan ID Member ada atau coba dengan password baru! ";   

			}   

		}





		function setPassAdmin($pNew, $pID) {

            global $oDB, $oSystem; 

			$vres="";

			$pNew=md5($pNew);

		    $vsql="update m_admin set fpassword = '$pNew' where fidmember='$pID' ";	

			$vres=$oDB->query($vsql);

			if ($oDB->affected_rows() > 0) {

	  		   $oSystem->jsAlert("Password changed successfully!");

			   return 1;			   

			} else {

			   $oSystem->jsAlert("Error!, kemungkinan karena : ID Member tidak ada, dan atau password sama dengan yang lama!\n\r Yakinkan ID Member ada atau coba dengan password baru! ");

			   return "Error!, kemungkinan karena : ID Member tidak ada, dan atau password sama dengan yang lama!\n\r Yakinkan ID Member ada atau coba dengan password baru! ";   

			}   

		}

                





        //Set Active / Deacvtive

		function changeActive($pID,$pActive) {

            global $oDB; 

			$vres="";

			$vcount=$this->getActiveMemberCount();

			$vcount+=1;

		       $vsql="update m_anggota set faktif = '$pActive' , ftglaktif=now(), fcount=$vcount where fidmember='$pID' ";	

			$vres=$oDB->query($vsql);

			if ($oDB->affected_rows() > 0)

	  		   return 1;

			else

			   return "Error!, kemungkinan karena : ID Member tidak ada, dan atau kondisi sudah aktif / non aktif ";   

		}



        //Set Active / Deacvtive with DB

		function changeActiveDB($pID,$pActive, $pDB) {

            global $oDB; 

			$vres="";

			$vcount=$this->getActiveMemberCount();

			$vcount+=1;

		       $vsql="update m_anggota set faktif = '$pActive' , ftglaktif=now(), fcount=$vcount where fidmember='$pID' ";	

			$vres=$pDB->query($vsql);

			if ($pDB->affected_rows() > 0)

	  		   return 1;

			else

			   return "Error!, kemungkinan karena : ID Member tidak ada, dan atau kondisi sudah aktif / non aktif ";   

		}





        //Set Active Date

		function setActiveDate($pID,$pDate) {

            global $oDB; 

			if ($pDate!="now()")

			   $pDate="'".$pDate."'";

			$vres="";

		       $vsql="update m_anggota set ftglaktif = $pDate where fidmember='$pID' ";	

			$vres=$oDB->query($vsql);

			if ($oDB->affected_rows() > 0)

	  		   return 1;

			else

			   return "Error!, kemungkinan karena : ID Member tidak ada, dan atau kondisi sudah aktif / non aktif ";   

		}





        //Set Active Date with DB

		function setActiveDateDB($pID,$pDate,$pDB) {

            global $oDB; 

			if ($pDate!="now()")

			   $pDate="'".$pDate."'";

			$vres="";

		       $vsql="update m_anggota set ftglaktif = $pDate where fidmember='$pID' ";	

			$vres=$pDB->query($vsql);

			if ($pDB->affected_rows() > 0)

	  		   return 1;

			else

			   return "Error!, kemungkinan karena : ID Member tidak ada, dan atau kondisi sudah aktif / non aktif ";   

		}

		

       //Get Next ID

		function getNextID() {

		    global $oDB; 

			global $oPrefix;

			$vsql="select max(fidmember) as flastid from m_anggota ";	

			$oDB->query($vsql);

			

			while ($oDB->next_record()) {

			   $lastid = $oDB->f("flastid");

			}

			if (strlen($lastid)<=0) {

			   $vStartPrefix=$oPrefix->getPrefixName(1);

			   $lastid=$vStartPrefix."000000";

			 }  

			$prefix=substr($lastid,0,2);

			$curPrefixID=$oPrefix->getPrefixID($prefix);

			$lastid=substr($lastid,2,6);

			$lastid=intval($lastid);

			

			if ($lastid < 999999) {

				$lastid+=1;

				$len=strlen($lastid);

				for ($i=0;$i<(6-$len);$i++)

					  $lastid="0".$lastid;

				return $lastid=$prefix.$lastid;	  

			} else {

			  $curPrefixID+=1;

			  $nextPrefix=$oPrefix->getPrefixName($curPrefixID);  

			  return $lastid=$nextPrefix."000001";	    

			}

		 }	  	 



       //Get Last ID

		function getLastID() {

		    global $oDB; 

			$vsql="select max(fidmember) as flastid from m_anggota ";	

			$oDB->query($vsql);

			

			while ($oDB->next_record()) {

			   $lastid = $oDB->f("flastid");

			}

			return $lastid;				

		 }	  	 





       //Get Last Bal Mutasi

		function getLastBalMut($pID) {

		    global $oDB; 

			$vsql="select fbalance from tb_mutasi where fidmember='$pID' order by fidsys desc limit 1;";	

			$oDB->query($vsql);

			

			while ($oDB->next_record()) {

			   $lastbal = $oDB->f("fbalance");

			}

			if ($lastbal <> '')

			return $lastbal;	

			else return 0;			

		 }	  	 





       //Get Last Bal Mutasi Prof

		function getLastBalMutProd($pID) {

		    global $oDB; 

			$vsql="select fbalance from tb_mutasi_wprod where fidmember='$pID' order by fidsys desc limit 1;";	

			$oDB->query($vsql);

			

			while ($oDB->next_record()) {

			   $lastbal = $oDB->f("fbalance");

			}

			if ($lastbal <> '')

			return $lastbal;	

			else return 0;			

		 }	  	 





       //Get Last Bal Mutasi Kit

		function getLastBalMutKIT($pID) {

		    global $oDB; 

			$vsql="select fbalance from tb_mutasi_wkit where fidmember='$pID' order by fidsys desc limit 1;";	

			$oDB->query($vsql);

			

			while ($oDB->next_record()) {

			   $lastbal = $oDB->f("fbalance");

			}

			if ($lastbal <> '')

			return $lastbal;	

			else return 0;			

		 }	  	 





       //Get Last Bal Mutasi Kit

		function getLastBalMutAcc($pID) {

		    global $oDB; 

			$vsql="select fbalance from tb_mutasi_wacc where fidmember='$pID' order by fidsys desc limit 1;";	

			$oDB->query($vsql);

			

			while ($oDB->next_record()) {

			   $lastbal = $oDB->f("fbalance");

			}

			if ($lastbal <> '')

			return $lastbal;	

			else return 0;			

		 }	



       //Get Last ID

		function getFirstID() {

		    global $oDB; 

			$vsql="select fidmember as ffirstid from m_anggota where fidsys=1";	

			$oDB->query($vsql);

			

			while ($oDB->next_record()) {

			   $firstid = $oDB->f("ffirstid");

			}

			return $firstid;				

		 }	  	 



		 



		 //Get Alamat

		function getAlamat($pId) {

		     global $oDB; 

  			 $vsql="select falamat from m_anggota where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("falamat");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return -1;   

		}





		 //Get Alamat Lengkap

		function getAlamatLengkap($pId) {

		     global $oDB; 

  			 $vsql="select a.*, b.fnamawil as bkota, c.fnamawil as cprop  from m_anggota a left join m_wilayah b on (a.fkota=b.fkabkota and a.fpropinsi=b.fprop and b.fkec='00' and b.fdeskel='0000') left join m_wilayah c on (a.fpropinsi=c.fprop and c.fkabkota='00' and b.fkec='00' and b.fdeskel='0000') where a.fidmember='$pId' ";	

			 $oDB->query($vsql);		

			 $vOut=array('alamat'=>'','prop'=>'','kota'=>'');

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("falamat")." ".$oDB->f("bkota")." ".$oDB->f("cprop");

			   $vOut['alamat']=$vres;

			   $vOut['prop']=$oDB->f("fpropinsi");

			   $vOut['kota']=$oDB->f("fkota");

			 }

			 

			 

 		  

			    return $vOut;

			    

		}



//Get alamat lengkap pebisnis
		function getAlamatLengkapBiz($pId) {

		     global $oDB; 

  			 $vsql="select a.*, b.fnamawil as bkota, c.fnamawil as cprop  from m_pebisnis a left join m_wilayah b on (a.fkota=b.fkabkota and a.fprop=b.fprop and b.fkec='00' and b.fdeskel='0000') left join m_wilayah c on (a.fprop=c.fprop and c.fkabkota='00' and b.fkec='00' and b.fdeskel='0000') where a.fidmember='$pId' ";	

			 $oDB->query($vsql);		

			 $vOut=array('alamat'=>'','prop'=>'','kota'=>'');

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("falamat")." ".$oDB->f("bkota")." ".$oDB->f("cprop");

			   $vOut['alamat']=$vres;

			   $vOut['prop']=$oDB->f("fpropinsi");

			   $vOut['kota']=$oDB->f("fkota");

			 }

			    return $vOut;
		}


		 //Get Kota

		function getKota($pId) {

		     global $oDB; 

  			 $vsql="select fkota from m_anggota where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fkota");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return -1;   

		}





		 //Get Email

		function getEmail($pId) {

		     global $oDB; 

  			 $vsql="select femail from m_anggota where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("femail");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return -1;   

		}





		 //Get No HP

		function getNoHP($pId) {

		     global $oDB; 

  			 $vsql="select fnohp from m_anggota where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fnohp");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return -1;   

		}



		 //Get No Phone

		function getNoPhone($pId) {

		     global $oDB; 

  			 $vsql="select fnophone from m_anggota where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fnophone");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return -1;   

		}



		 //Get Bank

		function getBank($pId) {

		     global $oDB; 

  			 $vsql="select fnamabank from m_anggota where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fnamabank");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return -1;   

		}
//Ambil saldo
	function getSaldoAdm($pId,$pJenis) {
		     global $oDB; 
			 if ($pJenis=='sponsor')	
  			 	$vsql="select fsaldovcr from m_pebisnis where fidmember='$pId' ";	
			 else if($pJenis=='korwil')	
			    $vsql="select b.fsaldovcr from m_korwil a left join m_pebisnis b on b.fidmember=a.fidbisnis  where a.fidkorwil='$pId' ";	
				
				//echo  "$pJenis $vsql";
			 $oDB->query($vsql);
	
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fsaldovcr");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return -1;   
		}

		 //Get Bank Adm

		function getMemberNameAdm($pId,$pJenis) {
		     global $oDB; 
			 if ($pJenis=='sponsor')	
  			 	$vsql="select fnama from m_pebisnis where fidmember='$pId' ";	
			 else if($pJenis=='korwil')	
			    $vsql="select a.fnama from m_korwil a left join m_pebisnis b on b.fidmember=a.fidbisnis  where a.fidkorwil='$pId' ";	
			 $oDB->query($vsql);
	
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fnama");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return -1;   
		}

		 //Get Bank Adm

		function getBankAdm($pId,$pJenis) {
		     global $oDB; 
			 if ($pJenis=='sponsor')	
  			 	$vsql="select fnamabank from m_pebisnis where fidmember='$pId' ";	
			 else if($pJenis=='korwil')	
			    $vsql="select b.fnamabank from m_korwil a left join m_pebisnis b on b.fidmember=a.fidbisnis  where a.fidkorwil='$pId' ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fnamabank");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return -1;   
		}


		//Get atas nama Rekening

		function getAtasNama($pId) {

		     global $oDB; 

  			 $vsql="select fatasnama from m_anggota where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fatasnama");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return -1;   

		}


		 //Get Atas nama Adm

		function getAtasNamaAdm($pId,$pJenis) {
		     global $oDB; 
			 if ($pJenis=='sponsor')	
  			 	$vsql="select fatasnama from m_pebisnis where fidmember='$pId' ";	
			 else if($pJenis=='korwil')	
			    $vsql="select b.fatasnama from m_korwil a left join m_pebisnis b on b.fidmember=a.fidbisnis  where a.fidkorwil='$pId' ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fatasnama");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return -1;   
		}




		 //Get No Rekening

		function getRekening($pId) {

		     global $oDB; 

  			 $vsql="select fnorekening from m_anggota where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vrek = $oDB->f("fnorekening");

			 }

 		     if (strlen($vrek)>=8)

			    return $vrek;

			 else 

			    return -1;   

		}


	 //Get rekening nama Adm

		function getRekeningAdm($pId,$pJenis) {
		     global $oDB; 
			 if ($pJenis=='sponsor')	
  			 	$vsql="select fnorekening from m_pebisnis where fidmember='$pId' ";	
			 else if($pJenis=='korwil')	
			    $vsql="select b.fnorekening from m_korwil a left join m_pebisnis b on b.fidmember=a.fidbisnis  where a.fidkorwil='$pId' ";	
			 $oDB->query($vsql);		
			 while ($oDB->next_record()) {
			   $vres = $oDB->f("fnorekening");
			 }
 		     if ($vres!="")
			    return $vres;
			 else 
			    return -1;   
		}
		
		
		 //Get Propinsi

		function getPropinsi($pId) {

		     global $oDB; 

  			 $vsql="select fpropinsi from m_anggota where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fpropinsi");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return -1;   

		}



		 //Get Propinsi

		function getKodepos($pId) {

		     global $oDB; 

  			 $vsql="select fkodepos from m_anggota where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

			 while ($oDB->next_record()) {

			   $vres = $oDB->f("fkodepos");

			 }

 		     if ($vres!="")

			    return $vres;

			 else 

			    return -1;   

		}



			//REGISTER MEMBER

	

	 function regMember($tfSerno,$tfIdent,$tfNama,$tfTempat,$tfTglLahir,$lmNation,$tfSex,$taAlamat,$lmCountry,$lmProp,$lmKota,$tfPhone,$tfHP,$tfEmail,$tfBank,$tfRek,$tfAtasNama,$tfKotaBank,$tfBranchBank,$lmCountryBank,$tfSwift,$tfSernoUp,$tfSernoSpon,$tfPhoneSpon,$tfEmailSpon,$rbPosition,$hTot,$rbPaket, $tfNPWP,$db='',$fIDStockist,$fAutoShip,$pRefTrx,$pSerno,$pSernoPres,$pEmailOno,$pPrd,$pStockFrom='')  {

			// echo "regMember($tfSerno,$tfIdent,$tfNama,$tdTempat,$tfTglLahir,$lmNation,$tfSex,$taAlamat,$lmCountry,$lmProp,$lmKota,$tfPhone,$tfHP,$tfEmail,$tfBank,$tfRek,$tfAtasNama,$tfKotaBank,$tfBranchBank,$lmCountryBank,$tfSwift,$tfSponsor,$tfSernoSpon,$tfPhoneSpon,$tfEmailSpon,$rbPosition,$hTot,$rbPaket,$tfNPWP)";  		

			 global $oDB, $oRules, $oPhpdate, $oSystem;

			 $except="";

			 if ($tfSerno=="") 

			    $except.="<font color='#FF0000'> ID Member tidak boleh kosong!</font><br>";

			 if ($this->authID($tfSerno)==1)

			    $except.="<font color='#FF0000'>Error!, ID Member $tfSernosudah digunakan!</font><br>";

			 if (trim($hTot)=='') $hTot=0;			

	

			 if ($tfNama=="")

			    $except.="<font color='#FF0000'>Nama tidak boleh kosong!</FONT><br>"; 	

			 if ($tfTglLahir=="")

			    $except.="<font color='#FF0000'>Tanggal Lahir tidak boleh kosong!</font><br>"; 	

			// if ($fidressponsor=="")

			//     $fidressponsor=$this->getFirstID();  			 	

			// $fpassword=str_replace("-","",$tfTglLahir);	

			  $fpassword=substr($tfHP,-8);

			 //$fpassword=base64_encode($fpassword);	

			 $fpassword=$oSystem->doED("encrypt",$fpassword);

			 $tfTglLahir=$oPhpdate->DMY2YMD($tfTglLahir);

			// $fbtstrans=$oRules->getMinTrans(1);

			// $fbtstransbuy=$oRules->getMinTransBuy(1);

	 		 $vIP=$_SERVER['REMOTE_ADDR'];

			 $vsql="INSERT INTO m_anggota (fidmember , fidressponsor , fidresupline ,  fnoinduk, fuserid,fnama , fpassword, fnohp , fnophone , fnamabank , fnorekening , ftempatlahir , ftgllahir , falamat , fkota , fkodepos , fpropinsi , fcountry, femail , fsernospon,fnamaspon, faktif , ftglaktif , fatasnama , fkotabank, fcabbank, fcountrybank, fswift, fsponphone, femailspon,fposition,fbtstrans,  ftotbelanja ,   ftgldaftar , fstatusrow , ftglentry, fstockist,fidstockist,fstockfrom,fpaket,fsex,fnoktp,fnpwp,fnation,fautoship,fref,fipaddress,fserno,fidrespres,femailono,fproduct) " ;

			 $vsql.="VALUES ('$tfSerno', '$tfSernoSpon', '$tfSernoUp', '-1', '', '".addslashes($tfNama)."', '$fpassword', '$tfHP', '$tfPhone', '$tfBank', '$tfRek', '$tfTempat', '$tfTglLahir', '".addslashes($taAlamat)."', '$lmKota', '', '$lmProp', '$lmCountry','$tfEmail',  '$tfSernoSpon','$tfSponsor','0', null, '".addslashes($tfAtasNama)."','$tfKotaBank','$tfBranchBank','$lmCountryBank','$tfSwift', '$tfPhoneSpon','$tfEmailSpon','$rbPosition', 1000,  $hTot,  now(), '1', now(),'0','','$pStockFrom','$rbPaket','$tfSex','$tfIdent','$tfNPWP','$lmNation','$fAutoShip','$pRefTrx','$vIP','$pSerno','$pSernoPres','$pEmailOno','$pPrd');";	

				

			 if ($except!="") {

			    echo $except;	

				return -1;

			 } else {;

				$db->query($vsql);		

				if ($db->affected_rows() > 0 ) 

				  return 1;

				else

				  return 0; 

			 }	  

	}		



			//REGISTER korwil

	

	 function regKorwil($fidkorwil, $flevel, $fnama, $fnohp, $falamat, $fprop,$fkota, $fkec, $femail, $fnoktp, $fket,$fidupline,$fidbisnis,$db)  {
			
			 global $oDB, $oRules, $oPhpdate, $oSystem;
			 $except="";
			 if ($fidkorwil=="") 
			    $except.="<font color='#FF0000'> ID Korwil tidak boleh kosong!</font><br>";
			 if ($this->authKor($fidkorwil)==1)
			    $except.="<font color='#FF0000'>Error!, ID Korwil $fidkorwil pernah sudah digunakan!</font><br>";
			 if (trim($hTot)=='') $hTot=0;			
	
			 if ($fnama=="")
			    $except.="<font color='#FF0000'>Nama tidak boleh kosong!</FONT><br>"; 	
			 
			  $fpassword=substr($tfHP,-8);
			 $fpassword=$oSystem->doED("encrypt",$fpassword);
			
	 		 $vIP=$_SERVER['REMOTE_ADDR'];
			 $vsql="INSERT INTO m_korwil ( fidkorwil, flevel,  fnama, fnohp, falamat, fprop,fkota, fkec, femail, fnoktp,  fket, fidupline, ftglentry, ftglaktif,faktif,fidbisnis) " ;
			 $vsql.="VALUES ('$fidkorwil', '$flevel', '$fnama', '$fnohp', '$falamat', '$fprop','$fkota', '$fkec', '$femail', '$fnoktp', '$fket','$fidupline', now(), now(),'1','$fidbisnis');";	
				
			 if ($except!="") {
			    echo $except;	
				return -1;
			 } else {
				$db->query($vsql);		
				if ($db->affected_rows() > 0 ) 
				  return 1;
				else
				  return 0; 
			 }	  
	}		




			//REGISTER Pilgrims


	 function regPilgrims($fidmember, $fjenis, $fstorawal, $fangsur1, $fangsur2, $fangsur3, $fangsur4, $flunas, $ftotalbayar, $frefer='', $fnama, $fnohp, $fnamabank='', $fnorekening='', $ftempat, $ftgllahir, $falamat, $fkota, $fkodepos, $fprop, $femail='', $fpassword, $fpaspor='', $fnamarefer='', $faktif, $ftglaktif, $fatasnama='', $fkotabank='', $ftgldaftar,  $ftglentry, $fcount, $fcabbank='', $fcountrybank='', $fswift='', $flastuser, $flastupdate, $ftitle, $fsex, $fnation, $ffoto='', $fdoc='', $fnoktp, $fcountry, $fket, $fnpwp='',$fpaket,$fpaketday,$fjenpay,$fprogram,$fprice,$fairporttax,$fassure,$fkakek,$fayah,$fkec,$fdes='',$fnohprefer,$fnoktprefer,$fnamabuss,$fnohpbuss,$fnoktpbuss,$ftgldepart,$farabassure,$fwarisbuss,$fpromo,$fprod,$floginuser,$fjenispax,$db)  {

		

			 global $oDB, $oRules, $oPhpdate, $oSystem;

			 $except="";

			 if ($fidmember=="") 

			    $except.="<font color='#FF0000'> ID Member tidak boleh kosong!</font><br>";

			 if ($this->authID($fidmember)==1)

			    $except.="<font color='#FF0000'>Error!, ID Member $tfSernosudah digunakan!</font><br>";

			 if (trim($hTot)=='') $hTot=0;			

	

			 if ($fnama=="")

			    $except.="<font color='#FF0000'>Nama tidak boleh kosong!</FONT><br>"; 	

			 if ($ftgllahir=="")

			    $except.="<font color='#FF0000'>Tanggal Lahir tidak boleh kosong!</font><br>"; 	

			// if ($fidressponsor=="")

			//     $fidressponsor=$this->getFirstID();  			 	

			// $fpassword=str_replace("-","",$tfTglLahir);	

			  $fpassword=substr($fnohp,-8);

			 //$fpassword=base64_encode($fpassword);	

			 $fpassword=$oSystem->doED("encrypt",$fpassword);

			 $ftgllahir=$oPhpdate->DMY2YMD($ftgllahir);

			// $fbtstrans=$oRules->getMinTrans(1);

			// $fbtstransbuy=$oRules->getMinTransBuy(1);
			$fnama = addslashes($fnama);
			$falamat = addslashes($falamat);
			$fatasnama = addslashes($fatasnama);
			
	 		 $vIP=$_SERVER['REMOTE_ADDR'];
	 		 if ($ftglaktif=='null') {
	 		    $vTglAktif="null";
	 		 } else {
	 		    $vTglAktif="'$ftglaktif'";
	 		 }

			 $vsql="INSERT INTO m_anggota (fidmember, fjenis, fstorawal, fangsur1, fangsur2, fangsur3, fangsur4, flunas, ftotalbayar, frefer, fnama, fnohp, fnamabank, fnorekening, ftempat, ftgllahir, falamat, fkota, fkodepos, fprop, femail, fpassword, fpaspor, fnamarefer, faktif, ftglaktif, fatasnama, fkotabank, ftgldaftar,  ftglentry, fcount, fcabbank, fcountrybank, fswift, flastuser, flastupdate, ftitle, fsex, fnation, ffoto, fdoc,fnoktp, fcountry, fket, fnpwp,fpaket,fpaketday,fjenpay,fprogram,fprice,fairporttax,fassure,fkakek,fayah,fkec,fdes,fnohprefer,fnoktprefer,fnamabuss,fnohpbuss,fnoktpbuss,ftgldepart, fwarisbuss,fpromo,fidregistrar,farabassure,fprod,fjenispax) " ;

			  $vsql.="VALUES ('$fidmember', '$fjenis', $fstorawal, $fangsur1, $fangsur2, $fangsur3, $fangsur4, $flunas, $ftotalbayar, '$frefer', '$fnama', '$fnohp', '$fnamabank', '$fnorekening', '$ftempat', '$ftgllahir', '$falamat', '$fkota', '$fkodepos', '$fprop', '$femail', '$fpassword', '$fpaspor', '$fnamarefer', '$faktif', $vTglAktif, '$fatasnama', '$fkotabank', now(), now(), $fcount, '$fcabbank', '$fcountrybank', '$fswift', '$flastuser',now(), '$ftitle', '$fsex', '$fnation', '$ffoto','$fdoc', '$fnoktp', '$fcountry', '$fket', '$fnpwp','$fpaket','$fpaketday','$fjenpay','$fprogram',$fprice,$fairporttax,$fassure,'$fkakek','$fayah','$fkec','$fdes','$fnohprefer','$fnoktprefer','$fnamabuss','$fnohpbuss','$fnoktpbuss','$ftgldepart','$fwarisbuss','$fpromo','$floginuser',$farabassure,'$fprod','$fjenispax');";	

				

			 if ($except!="") {

			    echo $except;	

				return -1;

			 } else {;

				$db->query($vsql);		

				if ($db->affected_rows() > 0 ) 

				  return 1;

				else

				  return 0; 

			 }	  

	}		





			//REGISTER Tabungan


	 function tabPilgrims($fidmember, $fjenis, $fstorawal, $fangsur1, $fangsur2, $fangsur3, $fangsur4, $flunas, $ftotalbayar, $frefer='', $fnama, $fnohp, $fnamabank='', $fnorekening='', $ftempat, $ftgllahir, $falamat, $fkota, $fkodepos, $fprop, $femail='', $fpassword, $fpaspor='', $fnamarefer='', $faktif, $ftglaktif, $fatasnama='', $fkotabank='', $ftgldaftar,  $ftglentry, $fcount, $fcabbank='', $fcountrybank='', $fswift='', $flastuser, $flastupdate, $ftitle, $fsex, $fnation, $ffoto='', $fdoc='', $fnoktp, $fcountry, $fket, $fnpwp='',$fpaket,$fpaketday,$fjenpay,$fprogram,$fprice,$fairporttax,$fassure,$fkakek,$fayah,$fibu,$fkec,$fdes='',$fnohprefer,$fnoktprefer,$fnamabuss,$fnohpbuss,$fnoktpbuss,$ftgldepart,$farabassure,$fwarisbuss,$fpromo,$floginuser,$fttd,$fktpdoc,$db)  {

		

			 global $oDB, $oRules, $oPhpdate, $oSystem;

			 $except="";

			 if ($fidmember=="") 

			    $except.="<font color='#FF0000'> ID Member tidak boleh kosong!</font><br>";

			 if ($this->authID($fidmember)==1)

			    $except.="<font color='#FF0000'>Error!, ID Member $tfSernosudah digunakan!</font><br>";

			 if (trim($hTot)=='') $hTot=0;			

	

			 if ($fnama=="")

			    $except.="<font color='#FF0000'>Nama tidak boleh kosong!</FONT><br>"; 	

			 if ($ftgllahir=="")

			    $except.="<font color='#FF0000'>Tanggal Lahir tidak boleh kosong!</font><br>"; 	

			// if ($fidressponsor=="")

			//     $fidressponsor=$this->getFirstID();  			 	

			// $fpassword=str_replace("-","",$tfTglLahir);	

			  $fpassword=substr($fnohp,-8);

			 //$fpassword=base64_encode($fpassword);	

			 $fpassword=$oSystem->doED("encrypt",$fpassword);

			 $ftgllahir=$oPhpdate->DMY2YMD($ftgllahir);

			// $fbtstrans=$oRules->getMinTrans(1);

			// $fbtstransbuy=$oRules->getMinTransBuy(1);
			$fnama = addslashes($fnama);
			$falamat = addslashes($falamat);
			$fatasnama = addslashes($fatasnama);
			
	 		 $vIP=$_SERVER['REMOTE_ADDR'];
	 		 if ($ftglaktif=='null') {
	 		    $vTglAktif="null";
	 		 } else {
	 		    $vTglAktif="'$ftglaktif'";
	 		 }

			 $vsql="INSERT INTO m_anggota_tab (fidmember, fjenis, fstorawal, fangsur1, fangsur2, fangsur3, fangsur4, flunas, ftotalbayar, frefer, fnama, fnohp, fnamabank, fnorekening, ftempat, ftgllahir, falamat, fkota, fkodepos, fprop, femail, fpassword, fpaspor, fnamarefer, faktif, ftglaktif, fatasnama, fkotabank, ftgldaftar,  ftglentry, fcount, fcabbank, fcountrybank, fswift, flastuser, flastupdate, ftitle, fsex, fnation, ffoto, fdoc,fnoktp, fcountry, fket, fnpwp,fpaket,fpaketday,fjenpay,fprogram,fprice,fairporttax,fassure,fkakek,fayah,fibu,fkec,fdes,fnohprefer,fnoktprefer,fnamabuss,fnohpbuss,fnoktpbuss,ftgldepart, fwarisbuss,fpromo,fidregistrar,farabassure,fttd,fktpdoc) " ;

			  $vsql.="VALUES ('$fidmember', '$fjenis', $fstorawal, $fangsur1, $fangsur2, $fangsur3, $fangsur4, $flunas, $ftotalbayar, '$frefer', '$fnama', '$fnohp', '$fnamabank', '$fnorekening', '$ftempat', '$ftgllahir', '$falamat', '$fkota', '$fkodepos', '$fprop', '$femail', '$fpassword', '$fpaspor', '$fnamarefer', '$faktif', $vTglAktif, '$fatasnama', '$fkotabank', now(), now(), $fcount, '$fcabbank', '$fcountrybank', '$fswift', '$flastuser',now(), '$ftitle', '$fsex', '$fnation', '$ffoto','$fdoc', '$fnoktp', '$fcountry', '$fket', '$fnpwp','$fpaket','$fpaketday','$fjenpay','$fprogram',$fprice,$fairporttax,$fassure,'$fkakek','$fayah','$fibu','$fkec','$fdes','$fnohprefer','$fnoktprefer','$fnamabuss','$fnohpbuss','$fnoktpbuss',null,'$fwarisbuss','$fpromo','$floginuser',$farabassure,'$fttd','$fktpdoc');";	

				

			 if ($except!="") {

			    echo $except;	

				return -1;

			 } else {;

				$db->query($vsql);		

				if ($db->affected_rows() > 0 ) 

				  return 1;

				else

				  return 0; 

			 }	  

	}		




			//REGISTER Pilgrims Temp

	

	 function regMemberTemp($tfSerno,$tfIdent,$tfNama,$tfTempat,$tfTglLahir,$lmNation,$tfSex,$taAlamat,$lmCountry,$lmProp,$lmKota,$tfPhone,$tfHP,$tfEmail,$tfBank,$tfRek,$tfAtasNama,$tfKotaBank,$tfBranchBank,$lmCountryBank,$tfSwift,$tfSponsor,$tfSernoSpon,$tfPhoneSpon,$tfEmailSpon,$rbPosition,$hTot,$rbPaket, $tfNPWP,$db='')  {

			// echo "regMember($tfSerno,$tfIdent,$tfNama,$tdTempat,$tfTglLahir,$lmNation,$tfSex,$taAlamat,$lmCountry,$lmProp,$lmKota,$tfPhone,$tfHP,$tfEmail,$tfBank,$tfRek,$tfAtasNama,$tfKotaBank,$tfBranchBank,$lmCountryBank,$tfSwift,$tfSponsor,$tfSernoSpon,$tfPhoneSpon,$tfEmailSpon,$rbPosition,$hTot,$rbPaket,$tfNPWP)";  		

			 global $oDB, $oRules, $oPhpdate, $oSystem;

			 $except="";

			 if ($tfSerno=="") 

			    $except.="<font color='#FF0000'> ID Member tidak boleh kosong!</font><br>";

			 if ($this->authID($tfSerno)==1)

			    $except.="<font color='#FF0000'>Error!, ID Member $tfSernosudah digunakan!</font><br>";

			 if (trim($hTot)=='') $hTot=0;			

	

			 if ($tfNama=="")

			    $except.="<font color='#FF0000'>Nama tidak boleh kosong!</FONT><br>"; 	

			 if ($tfTglLahir=="")

			    $except.="<font color='#FF0000'>Tanggal Lahr tidak boleh kosong!</font><br>"; 	

			// if ($fidressponsor=="")

			//     $fidressponsor=$this->getFirstID();  			 	

			// $fpassword=str_replace("-","",$tfTglLahir);	

			 $fpassword=substr($tfHP,-8);

			 //$fpassword=base64_encode($fpassword);	

			 $fpassword=$oSystem->doED("encrypt",$fpassword);

			 $tfTglLahir=$oPhpdate->DMY2YMD($tfTglLahir);

			// $fbtstrans=$oRules->getMinTrans(1);

			// $fbtstransbuy=$oRules->getMinTransBuy(1);

	 		 $vsql="INSERT INTO m_anggota_temp (fidmember , fidressponsor , fidresupline ,  fnoinduk, fuserid,fnama , fpassword, fnohp , fnophone , fnamabank , fnorekening , ftempatlahir , ftgllahir , falamat , fkota , fkodepos , fpropinsi , fcountry, femail , fsernospon,fnamaspon, faktif , ftglaktif , fatasnama , fkotabank, fcabbank, fcountrybank, fswift, fsponphone, femailspon,fposition,fbtstrans,  ftotbelanja ,   ftgldaftar , fstatusrow , ftglentry, fstockist,fidstockist,fstockfrom,fpaket,fsex,fnoktp,fnpwp,fnation) " ;

			 $vsql.="VALUES ('$tfSerno', '$tfSernoSpon', '$tfSernoSpon', '-1', '', '".addslashes($tfNama)."', '$fpassword', '$tfHP', '$tfPhone', '$tfBank', '$tfRek', '$tfTempat', '$tfTglLahir', '".addslashes($taAlamat)."', '$lmKota', '', '$lmProp', '$lmCountry','$tfEmail',  '$tfSernoSpon','$tfSponsor','0', null, '".addslashes($tfAtasNama)."','$tfKotaBank','$tfBranchBank','$lmCountryBank','$tfSwift', '$tfPhoneSpon','$tfEmailSpon','$rbPosition', 1000,  $hTot,  now(), '1', now(),'0','','','$rbPaket','$tfSex','$tfIdent','$tfNPWP','$lmNation');";	

				

			 if ($except!="") {

			    echo $except;	

				return -1;

			 } else {;

				$db->query($vsql);		

				if ($db->affected_rows() > 0 ) 

				  return 1;

				else

				  return 0; 

			 }	  

	}

	

	

	 function regMemberLama($fidmember, $fidressponsor, $fidresupline, $fnoinduk, $fuserid, $fnama, $fpassword, $fnohp, $fnophone, $fnamabank, $fnorekening, $ftempatlahir, $ftgllahir, $falamat, $fkota, $fkodepos, $fpropinsi, $femail, $fwaris, $fhubungan, $faktif, $ftglaktif, $fatasnama, $fbtstrans, $fkodeunik, $fpin, $fserno, $ftgldaftar, $fstatusrow, $ftglentry,$fstockist,$fidstockist,$fstockfrom,$fpaket,$fsex,$fnoktp,$fprod) {

			 global $oDB, $oRules, $oSystem;

			 $except="";

			 if ($fidmember=="") 

			    $except.="<font color='#FF0000'> ID Member tidak boleh kosong!</font><br>";

			 if ($this->authID($fidmember)==1)

			    $except.="<font color='#FF0000'>Error!, ID Member $fidmember sudah digunakan!</font><br>";



			 if ($fnama=="")

			    $except.="<font color='#FF0000'>Nama tidak boleh kosong!</FONT><br>"; 	

			 if ($fpassword=="")

			    $except.="<font color='#FF0000'>Password tidak boleh kosong!</font><br>"; 	

			 if ($fidressponsor=="")

			     $fidressponsor=$this->getFirstID();  			 	

			  	

			 $fpassword=$oSystem->doED('encrypt',$fpassword);	

			 $fbtstrans=$oRules->getMinTrans(1);

			 $fbtstransbuy=$oRules->getMinTransBuy(1);

	 		 $vsql="INSERT INTO m_anggota (fidmember , fidressponsor , fidresupline ,  fnoinduk, fuserid,fnama , fpassword, fnohp , fnophone , fnamabank , fnorekening , ftempatlahir , ftgllahir , falamat , fkota , fkodepos , fpropinsi , femail , fwaris,fhubungan, faktif , ftglaktif , fatasnama , fbtstrans,  fbtstransbuy , fkodeunik , fpin , fserno , ftgldaftar , fstatusrow , ftglentry, fstockist,fidstockist,fstockfrom,fpaket,fsex,fnoktp,fprod ) " ;

			 $vsql.="VALUES ('$fidmember', '$fidressponsor', '$fidresupline', '$fnoinduk', '$fuserid', '".addslashes($fnama)."', '$fpassword', '$fnohp', '$fnophone', '$fnamabank', '$fnorekening', '$ftempatlahir', '$ftgllahir', '".addslashes($falamat)."', '$fkota', '$fkodepos', '$fpropinsi', '$femail',  '".addslashes($fwaris)."','$fhubungan','0', null, '".addslashes($fatasnama)."', $fbtstrans,  $fbtstransbuy,'$fkodeunik', '$fpin', '$fserno', now(), '1', now(),'$fstockist','$fidstockist','$fstockfrom','$fpaket','$fsex','$fnoktp','$fprod');";	

				

			 if ($except!="") {

			    echo $except;	

				return -1;

			 } else {

				$oDB->query($vsql);		

				if ($oDB->affected_rows() > 0 ) 

				  return 1;

				else

				  return 0;   

			 }	  

	}		

     //Update Member

//	 		 $vsql="INSERT INTO m_anggota (fidmember , fidressponsor , fidresupline ,  fnoinduk, fuserid,fnama , fpassword, fnohp , fnophone , fnamabank , fnorekening , ftempatlahir , ftgllahir , falamat , fkota , fkodepos , fpropinsi , fcountry, femail , fsernospon,fnamaspon, faktif , ftglaktif , fatasnama , fkotabank, fcabbank, fcountrybank, fswift, fsponphone, femailspon,fposition,fbtstrans,  ftotbelanja ,   ftgldaftar , fstatusrow , ftglentry, fstockist,fidstockist,fstockfrom,fpaket,fsex,fnoktp,fnpwp,fnation) " ;

//			 $vsql.="VALUES ('$tfSerno', '$tfSernoSpon', '$tfSernoSpon', '-1', '', '".addslashes($tfNama)."', '$fpassword', '$tfHP', '$tfPhone', '$tfBank', '$tfRek', '$tfTempat', '$tfTglLahir', '".addslashes($taAlamat)."', '$lmKota', '', '$lmProp', '$lmCountry','$tfEmail',  '$tfSernoSpon','$tfSponsor','0', null, '".addslashes($tfAtasNama)."','$tfKotaBank','$tfBranchBank','$lmCountryBank','$tfSwift', '$tfPhoneSpon','$tfEmailSpon','$rbPosition', 1000,  $hTot,  now(), '1', now(),'0','','','$rbPaket','$tfSex','$tfIdent','$tfNPWP','$lmNation');";	

     

     //                   updateMember($tfSerno,$tfIdent,$tfNama,$tfTempat,$tfTglLahir,$lmNation,$tfSex,$taAlamat,$lmCountry,$lmProp,$lmKota,$tfPhone,$tfHP,$tfEmail,$tfBank,$tfRek,$tfAtasNama,$tfKotaBank,$tfBranchBank,$lmCountryBank,$tfSwift,$tfNPWP)
//updateKorwil($fidkorwil, $flevel, $fnama, $fnohp, $falamat, $fprop,fkota $fkec, $femail, $fnoktp, $fket,$db)

 function updateKorwil($fidkorwil, $flevel, $fnama, $fnohp, $falamat, $fprop,$fkota, $fkec, $femail, $fnoktp, $fket,$fidupline,$fidbisnis,$db) {

     	global $oDB, $oSystem;



		    $vsql="update m_korwil set flevel='$flevel',fnama='$fnama',fnohp='$fnohp',falamat='$falamat',fprop='$fprop',fkota='$fkota',fkec='$fkec',femail='$femail',fnoktp='$fnoktp',fidupline='$fidupline', fidbisnis='$fidbisnis'  where fidkorwil='$fidkorwil'"; 

		$db->query($vsql);
		//$oSystem->jsAlert("Member updated!!");
				if ($db->affected_rows() > 0 ) 
				  return 1;
				else
				  return 0;   
 }
 
 
 
 
 function updateSeller($fidseller, $fbank, $fnama,$fwaris,$fcomp, $fnohp, $falamat, $fprop,$fkota, $fkec,$fkel, $femail, $fnoktp, $fnib, $fnorekening, $fatasnama,$fcountry,$db) {

     	global $oDB, $oSystem;

// $vsql="INSERT INTO m_seller (fidseller, fbank, fatasnama, fnama, fnohp, falamat, fkota, fprop, femail, faktif, ftglaktif, fstatusrow, ftglentry, fket, fnoktp, fkec, fnorekening, fcountry) " ;
					//	 $vsql.="VALUES ('$fidseller', '$fbank', '$fatasnama', '$fnama', '$fnohp', '$falamat','$fkota', '$fprop', '$femail', '1', now(),'1',now(),'','$fnoktp', '$fkec','$fnorekening', '$fcountry');";	

		    $vsql="update m_seller set fbank='$fbank',fnama='$fnama',fwaris='$fwaris',fcomp='$fcomp',fnohp='$fnohp',falamat='$falamat',fprop='$fprop',fkota='$fkota',fkec='$fkec',fkel='$fkel',femail='$femail',fnoktp='$fnoktp',fnib='$fnib',fatasnama='$fatasnama', fnorekening='$fnorekening',fcountry='$fcountry'  where fidseller='$fidseller'"; 

		$db->query($vsql);
		//$oSystem->jsAlert("Member updated!!");
				if ($db->affected_rows() > 0 ) 
				  return 1;
				else
				  return 0;   
 }
 
 
 function updateRef($fidmember,$fnama, $fnohp, $falamat,  $fprop,$fkota, $fkec, $femail, $fnoktp, $fket,$fnorekening,$fatasnama,$fnamabank,$faktif,$fbefore,$fextdate,$db) {

     	global $oDB, $oSystem;



		    $vsql="update m_pebisnis set fnama='$fnama',fnohp='$fnohp',falamat='$falamat',fprop='$fprop',fkota='$fkota',fkec='$fkec',femail='$femail',fnoktp='$fnoktp', fnorekening='$fnorekening', fatasnama='$fatasnama', fnamabank='$fnamabank', faktif='$faktif'  where fidmember='$fidmember'"; 

		$db->query($vsql);
		
		if ($fextdate !=''){
			$vLog = "Perpanjangan dari $fbefore ke $fextdate";
			$vsql="update m_pebisnis set ftglaktif='$fextdate', flog='$vLog'  where fidmember='$fidmember'"; 

			$db->query($vsql);
		}
			
		
		$vsql="update m_admin set faktif='$faktif'  where fidmember='$fidmember'"; 

		$db->query($vsql);
		//$oSystem->jsAlert("Member updated!!");
				if ($db->affected_rows() > 0 ) 
				  return 1;
				else
				  return 0;   
 }

     function updateMember($tfSerno,$tfIdent,$tfNama,$tfTempat,$tfTglLahir,$lmNation,$tfSex,$taAlamat,$lmCountry,$lmProp,$lmKota,$tfPhone,$tfHP,$tfEmail,$tfBank,$tfRek,$tfAtasNama,$tfKotaBank,$tfBranchBank,$lmCountryBank,$tfSwift,$tfNPWP,$tfSernoSpon,$cbStockist,$tfAutoShip,$hPict) {

     	global $oDB, $oSystem;



		    $vsql="update m_anggota set fbtstrans=1000,fatasnama='".addslashes($tfAtasNama)."',fnoinduk='INDUK',fnama='".$tfNama."',fnohp='$tfHP',fnophone='".$tfPhone."',fnamabank='".$tfBank."',fnorekening='".$tfRek."',ftempatlahir='".$tfTempat."',ftgllahir='".$tfTglLahir."',falamat='".$taAlamat."',fkota='".$lmKota."',fkodepos='00000',fpropinsi='".$lmProp."',femail='".$tfEmail."', fswift='".$tfSwift."',fstockist='".$cbStockist."',fidressponsor='".$tfSernoSpon."',fsex='".$tfSex."',fnoktp='".$tfIdent."',fautoship='".$tfAutoShip."',fimage='$hPict'  where fidmember='".$tfSerno."'"; 

		

		$oDB->query($vsql);

                

		//$oSystem->jsAlert("Member updated!!");

				if ($oDB->affected_rows() > 0 ) 

				  return 1;

				else

				  return 0;   

                

 	 }



    function updPilgrimsBasic($fidmember, $fjenis, $fstorawal, $fangsur1, $fangsur2, $fangsur3, $fangsur4, $flunas, $ftotalbayar, $frefer='', $fnama, $fnohp, $fnamabank='', $fnorekening='', $ftempat, $ftgllahir, $falamat, $fkota, $fkodepos, $fprop, $femail='', $fpassword, $fpaspor='', $fnamarefer='', $faktif, $ftglaktif, $fatasnama='', $fkotabank='', $ftgldaftar,  $ftglentry, $fcount, $fcabbank='', $fcountrybank='', $fswift='', $flastuser, $flastupdate, $ftitle, $fsex, $fnation, $ffoto='', $fdoc='', $fnoktp, $fcountry, $fket, $fnpwp='',$fpaket,$fpaketday,$fjenpay,$fprogram,$fprice,$fairporttax,$fassure,$fkakek,$fayah,$fkec,$fdes='',$fkurslunas,$ftgldepart,$farabassure,$fwarisbuss,$fpromo,$db) {

     	global $oDB, $oSystem;

         $fnama = str_replace("'","''",$fnama);
		 $falamat = str_replace("'","''",$falamat);

		     $vsql="UPDATE m_anggota SET fjenis = '$fjenis', fstorawal =$fstorawal , fangsur1 = $fangsur1, fangsur2 = $fangsur2,fangsur3 = $fangsur3 ,fangsur4 = $fangsur4,flunas = $flunas,ftotalbayar = $ftotalbayar ,frefer = '$frefer',fnama = '$fnama',fnohp = '$fnohp',ftempat = '$ftempat',ftgllahir ='$ftgllahir' ,falamat = '$falamat',fkota = '$fkota',fprop = '$fprop',femail = '$femail',fpaspor = '$fpaspor',flastuser = '$flastuser',flastupdate =now(), fsex = '$fsex',fnation = '$fnation',fnoktp = '$fnoktp',fcountry = '$fcountry',fket = '$fket',fpaket = '$fpaket',fpaketday = '$fpaketday' ,fjenpay = '$fjenpay', fprogram = '$fprogram',fprice=$fprice,fairporttax=$fairporttax,fassure=$fassure,fkakek = '$fkakek',fayah='$fayah',fkec='$fkec',fdes='$fdes',fkurslunas='$fkurslunas', ftgldepart='$ftgldepart', farabassure=$farabassure, fwarisbuss='$fwarisbuss',fpromo='$fpromo' WHERE fidmember='$fidmember' ;"; 

		

		$oDB->query($vsql);

                

		//$oSystem->jsAlert("Member updated!!");

				if ($oDB->affected_rows() > 0 ) 

				  return 1;

				else

				  return 0;   

                

 	 }


    function tabPilgrimsBasic($fidmember, $fjenis, $fstorawal, $fangsur1, $fangsur2, $fangsur3, $fangsur4, $flunas, $ftotalbayar, $frefer='', $fnama, $fnohp, $fnamabank='', $fnorekening='', $ftempat, $ftgllahir, $falamat, $fkota, $fkodepos, $fprop, $femail='', $fpassword, $fpaspor='', $fnamarefer='', $faktif, $ftglaktif, $fatasnama='', $fkotabank='', $ftgldaftar,  $ftglentry, $fcount, $fcabbank='', $fcountrybank='', $fswift='', $flastuser, $flastupdate, $ftitle, $fsex, $fnation, $ffoto='', $fdoc='', $fnoktp, $fcountry, $fket, $fnpwp='',$fpaket,$fpaketday,$fjenpay,$fprogram,$fprice,$fairporttax,$fassure,$fkakek,$fayah,$fibu,$fkec,$fdes='',$fkurslunas,$ftgldepart,$farabassure,$fwarisbuss,$fpromo,$fttd,$fktpdoc,$db) {

     	global $oDB, $oSystem;

         $fnama = str_replace("'","''",$fnama);
		 $falamat = str_replace("'","''",$falamat);
		 
		

		     $vsql="UPDATE m_anggota_tab SET fjenis = '$fjenis', fstorawal =$fstorawal , fangsur1 = $fangsur1, fangsur2 = $fangsur2,fangsur3 = $fangsur3 ,fangsur4 = $fangsur4,flunas = $flunas,ftotalbayar = $ftotalbayar ,frefer = '$frefer',fnama = '$fnama',fnohp = '$fnohp',ftempat = '$ftempat',ftgllahir ='$ftgllahir' ,falamat = '$falamat',fkota = '$fkota',fprop = '$fprop',femail = '$femail',fpaspor = '$fpaspor',flastuser = '$flastuser',flastupdate =now(), fsex = '$fsex',fnation = '$fnation',fnoktp = '$fnoktp',fcountry = '$fcountry',fket = '$fket',fpaket = '$fpaket',fpaketday = '$fpaketday' ,fjenpay = '$fjenpay', fprogram = '$fprogram',fprice=$fprice,fairporttax=$fairporttax,fassure=$fassure,fkakek = '$fkakek',fayah='$fayah',fibu='$fibu',fkec='$fkec',fdes='$fdes',fkurslunas='$fkurslunas', ftgldepart=null, farabassure=$farabassure, fwarisbuss='$fwarisbuss',fpromo='$fpromo' $fttd $fktpdoc WHERE fidmember='$fidmember' ;"; 

		

		$oDB->query($vsql);

                

		//$oSystem->jsAlert("Member updated!!");

				if ($oDB->affected_rows() > 0 ) 

				  return 1;

				else

				  return 0;   

                

 	 }
	 
	 
	//REGISTER Seller

	

	 function regSeller($fidseller, $fbank, $fnama, $fwaris, $fcomp, $fnohp, $falamat, $fprop,$fkota, $fkec,$fkel, $femail, $fnoktp, $fnib, $fnorekening, $fatasnama,$fcountry,$db) {
			
			 global $oDB, $oRules, $oPhpdate, $oSystem;
			 $except="";
			 if ($fidseller=="") 
			    $except.="<font color='#FF0000'> ID Seller tidak boleh kosong!</font><br>";
			 if ($this->authSell($fidseller)==1)
			    $except.="<font color='#FF0000'>Error!, ID Seller $fidseller pernah sudah digunakan!</font><br>";
			 if (trim($hTot)=='') $hTot=0;			
	
			 if ($fnama=="")
			    $except.="<font color='#FF0000'>Nama tidak boleh kosong!</FONT><br>"; 	
			 
			  $fpassword=substr($tfHP,-8);
			 $fpassword=$oSystem->doED("encrypt",$fpassword);
			
	 		 $vIP=$_SERVER['REMOTE_ADDR'];
			 $vsql="INSERT INTO m_seller (fidseller, fbank, fatasnama, fnama, fwaris,fcomp, fnohp, falamat, fkota, fprop, femail, faktif, ftglaktif, fstatusrow, ftglentry, fket, fnoktp,fnib, fkec,fkel, fnorekening, fcountry) " ;
						 $vsql.="VALUES ('$fidseller', '$fbank', '$fatasnama', '$fnama','$fwaris','$fcomp', '$fnohp', '$falamat','$fkota', '$fprop', '$femail', '1', now(),'1',now(),'','$fnoktp','$fnib', '$fkec', '$fkel','$fnorekening', '$fcountry');";	
			
			 if ($except!="") {
			    echo $except;	
				return -1;
			 } else {
				 	
				$db->query($vsql);		
				if ($db->affected_rows() > 0 ) 
				  return 1;
				else
				  return 0; 
			 }	  
	}			 
	 
	 
	 

  //Paspor
  function updPilgrimsPass($fidmember,  $fpaspor, $fpasscntid, $fpassrelease, $fpassexpired, $fpassnoreg, $fpassoffice, $fpasssign='',$flastuser ,$ftgldepart,$frelation,$fket,$fnik,$feducation,$fjob,$fdoc,$db) {

     	global $oDB, $oSystem;

         $fnama = str_replace("'","''",$fnama);
		 $falamat = str_replace("'","''",$falamat);
		 $fket = str_replace("'","''",$fket);

		     $vsql="UPDATE m_anggota SET fpaspor = '$fpaspor', fpasscntid ='$fpasscntid' , fpassrelease = '$fpassrelease', fpassexpired = '$fpassexpired',fpassnoreg = '$fpassnoreg' ,fpassoffice = '$fpassoffice',fpasssign = '$fpasssign' , flastuser='$flastuser', ftgldepart='$ftgldepart', frelation='$frelation', fket='$fket',fnik='$fnik', feducation='$feducation',fjob='$fjob',fdoc='$fdoc',flastupdate=now() WHERE fidmember='$fidmember' ;"; 

		

		$oDB->query($vsql);

                

		//$oSystem->jsAlert("Member updated!!");

				if ($oDB->affected_rows() > 0 ) 

				  return 1;

				else

				  return 0;   

                

 	 }
	 
	 
	 
//Kontak
  function updPilgrimsKontak($fidmember,  $focname, $focktp, $focjenkel, $focalamat, $foctelp, $fochp, $focrelation,$db) {

     	global $oDB, $oSystem;

         $focname = str_replace("'","''",$focname);
		 $focalamat = str_replace("'","''",$focalamat);
		 $fket = str_replace("'","''",$fket);

		     $vsql="UPDATE m_anggota SET focname = '$focname', focktp ='$focktp' , focjenkel = '$focjenkel', focalamat = '$focalamat',foctelp = '$foctelp' ,fochp = '$fochp',focrelation = '$focrelation',flastupdate=now() WHERE fidmember='$fidmember' ;"; 

		$oDB->query($vsql);
				if ($oDB->affected_rows() > 0 ) 
				  return 1;
				else
				  return 0;   
 	 }	 


//Bawaan
  function updPilgrimsBring($fidmember,  $fbring, $bringdoc,$db) {

     	global $oDB, $oSystem;

      
			 if (trim($bringdoc) !='')
		            $vsql="UPDATE m_anggota SET fbring = '$fbring', fbringdoc ='$bringdoc', flastupdate=now() WHERE fidmember='$fidmember' ;"; 
			 else		
					$vsql="UPDATE m_anggota SET fbring = '$fbring', flastupdate=now() WHERE fidmember='$fidmember' ;"; 
					
		$oDB->query($vsql);
				if ($oDB->affected_rows() > 0 ) 
				  return 1;
				else
				  return 0;   
 }	 
 
 
 
 //Bawaan
  function updPilgrimsIdent($fidmember,  $fident, $fidentdoc,$db) {

     	global $oDB, $oSystem;

      
			 if (trim($fidentdoc) !='')
		            $vsql="UPDATE m_anggota SET fcheckident = '$fident', fcheckidentdoc ='$fidentdoc', flastupdate=now() WHERE fidmember='$fidmember' ;"; 
			 else		
					$vsql="UPDATE m_anggota SET fcheckident = '$fident', flastupdate=now() WHERE fidmember='$fidmember' ;"; 
					
		$oDB->query($vsql);
				if ($oDB->affected_rows() > 0 ) 
				  return 1;
				else
				  return 0;   
 	 }	
   //Set Password

     function setPassConfirm($pID,$pNewPass,$pConfirm){

     	global $oDB, $oSystem;

		if ($pNewPass==$pConfirm) {

			$this->setPass($pNewPass,$pID);

		} else

		   $oSystem->jsAlert("Konfirmasi salah!");

 	 }









	//Delete MEMBER

	 function delMember($pID) {

		 global $oDB, $oSystem, $oNetwork;

		 if ($oNetwork->hasDownline($pID)==1) {

		   echo "Error!, Member sudah aktif dan memiliki downline, tidak bisa dihapus!";

		   return -1;

		 } else if ($oNetwork->hasSponsorship($pID)==1) {

		   echo "Error!, Member sudah memiliki referral, tidak bisa dihapus!";

		   return -1;		 

		 } else {

			  

		   $vsql="delete from tb_updown where fdownline='$pID' " ;	

		   $oDB->query($vsql);		



	 	   $vsql="delete from m_anggota where fidmember='$pID' ";	   

		   $oDB->query($vsql);		

		   

	 	   $vsql="delete from tb_kom_spon where fidregistrar='$pID' ";	   

		   $oDB->query($vsql);		



	 	   $vsql="delete from tb_kom_mtx where fidregistrar='$pID' ";	   

		   $oDB->query($vsql);		





	 	   $vsql="delete from tb_overmatrix where fidregistrar='$pID' ";	   

		   $oDB->query($vsql);		





	 	   $vsql="delete from tb_kom_couple where fidregistrar='$pID' ";	   

		   $oDB->query($vsql);		



	

		   

		 }

			 

	 }

		   //     Apakah ada di support

		function isInSupport($pID) {

            global $oDB; 

			$vres="";

		    $vsql="select count(fidanggota) as jumsup from tb_support where fidanggota='$pID' ";

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("jumsup");

			}

			if ($vres >0 )

	  		   return 1;

			else

			   return -1;   

		}

 



		 //Set Stockist

	function setStockist($pId) {

		     global $oDB; 

  			 $vsql="update m_anggota set fstockist=1 where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

		}







		 //unSet Stockist

	function unsetStockist($pId) {

		     global $oDB; 

  			 $vsql="update m_anggota set fstockist=0 where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

		}



		 //Set WH, Stokist, Master, Member

	function setAttr($pId,$pAttr) {

		     global $oDB; 

  			 $vsql="update m_anggota set fstockist=$pAttr where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

		}



		 //set inactive

	function deActivate($pId) {

		     global $oDB; 

  			 $vsql="update m_anggota set faktif=0 where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

		}





        //check apakah Stockist

		function isStockist($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fstockist from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fstockist");

			}

			

			return $vres ;

/*			if ($vres == 1 || $vres == 2)

	  		   return 1;

			else

			   return 0;   

			   

			   */

		}



        //check apakah Stockist

		function isMasterStockist($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fstockist from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fstockist");

			}

			if ($vres == 2)

	  		   return 1;

			else

			   return 0;   

		}



        //check  Stockist Code

		function stockistCode($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fstockist from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fstockist");

			}

			   return  $vres;   

		}



        //get Random Member

		function getRandomMember() {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fidmember from m_anggota where faktif='1' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vid[] = $oDB->f("fidmember");

			}



			$vrand=rand(0,count($vid)-1);

			$vret=$vid[$vrand];

			return $vret;   

		}



        //get Prov

		function getProv($pKode) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fidprov, fnamaprov from m_prov where fidprov='$pKode' and fstatusrow='1' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres['id'] = $oDB->f("fidprov");

				$vres['nama'] = $oDB->f("fnamaprov");

			}

			 

			if (is_array($vres))

			    return $vres;   

			else 

			    return -1;	 

		}





        //get Wilayah

		function getWilayah($pKode) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fidkabwil, fnamakabwil from m_kab where fidkabwil='$pKode' and fstatusrow='1' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres['id'] = $oDB->f("fidkabwil");

				$vres['nama'] = $oDB->f("fnamakabwil");

			}

			 

			if (is_array($vres))

			    return $vres;   

			else 

			    return -1;	 

		}





		function getWilName($pNeg,$pProp,$pKota='00',$pKec='00',$pKel='0000') {	

            global $oDB; 

			 $vsql="SELECT fnamawil from m_wilayah where fkodeneg='$pNeg' and fprop='$pProp' and fkabkota='$pKota' and fkec='$pKec' and fdeskel='$pKel' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fnamawil");

			}

			 

			if ($vres!='')

			    return $vres;   

			else 

			    return -1;	 

		}







		function getCountryName($pNeg) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fcountry_name from m_country where fcountry_code='$pNeg' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fcountry_name");

			}

			 

			if ($vres!="")

			    return $vres;   

			else 

			    return -1;	 

		}

		

		function getBankName($pCode) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fnamabank from m_bank where fkodebank='$pCode' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fnamabank");

			}

			 

			if ($vres!="")

			    return $vres;   

			else 

			    return -1;	 

		}

		

        //get detail stockist

		function getDetStockist($pKode) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fidprov, fidkab, fidmob from m_stockist where fidmember='$pKode' and fstatusrow='1' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres['idprov'] = $oDB->f("fidprov");

				$vres['idkab'] = $oDB->f("fidkab");

				$vres['idmob'] = $oDB->f("fidmob");

			}

			 

			if (is_array($vres))

			    return $vres;   

			else 

			    return -1;	 

		}



        //Explain detail stockist

		function expDetStockist($pKode) {

            global $oDB; 

			$vres="";

			$vProv=substr($pKode,0,2);

			$vProvIndex=substr($pKode,2,1);

			$vWil=substr($pKode,4,2);

			$vWilIndex=substr($pKode,6,1);

			$vMob=substr($pKode,8,2);

			$vProv=$this->getProvById($vProv);

			$vWil=$this->getWilById($vWil);

			$vres['prov']=$vProv." ".$vProvIndex;

			$vres['wil']=$vWil." ".$vWilIndex;

			$vres['mob']=$vMob;

			return $vres;

		}





       //Get Next Induk

		function getNextInduk($pPrefix) {

		    global $oDB; 

			global $oPrefix;

			$vsql="select max(fnoinduk) as flastinduk from m_anggota where fnoinduk like '$pPrefix%'";	

			$oDB->query($vsql);

			

			while ($oDB->next_record()) {

			   $lastinduk = $oDB->f("flastinduk");

			}

			if (strlen($lastinduk)<=0) {

			   $vStartPrefix=$pPrefix;

			   $lastinduk=$vStartPrefix."0000";

			 }  

			$prefix=substr($lastinduk,0,16);

			$lastinduk=substr($lastinduk,16,4);

			$lastinduk=intval($lastinduk);

			

				$lastinduk+=1;

				$len=strlen($lastinduk);

				for ($i=0;$i<(4-$len);$i++)

					  $lastinduk="0".$lastinduk;

				return $lastinduk=$prefix.$lastinduk;	  

		 }	  	 

		 

			 //Apakah member pertama

	   function isFirst($pID) {

		  $vFirst=$this->getFirstID();

		  if ($pID==$vFirst)

			  return 1;

		  else	return 0;  

	   }





  //get Prov

    function getListProv() {

	    global $oDB;

		$vsql="select fidprov,fnamaprov,fstatusrow from m_prov where fstatusrow=1 order by fnamaprov";

		$oDB->query($vsql);

		$i=1;

		while ($oDB->next_record()) {

		   $vres['id'][$i]=$oDB->f('fidprov');

		   $vres['nama'][$i]=$oDB->f('fnamaprov');

		   $i++;

		}

		return $vres;

	}   



  //get Prov by ID

    function getProvByID($pID) {

	    global $oDB;

		$vsql="select fidprov,fnamaprov,fstatusrow from m_prov where fidprov='$pID' and fstatusrow=1";

		$oDB->query($vsql);

		while ($oDB->next_record()) {

		   $vres=$oDB->f('fnamaprov');

		}

		return $vres;

	}   





  //get Prov by ID

    function getWilByID($pID) {

	    global $oDB;

		$vsql="select fidkabwil,fnamakabwil,fstatusrow from m_kab where fidkabwil='$pID' and fstatusrow=1";

		$oDB->query($vsql);

		while ($oDB->next_record()) {

		   $vres=$oDB->f('fnamakabwil');

		}

		return $vres;

	}   



  //get Wilayah

    function getListWilayah() {

	    global $oDB;

		$vsql="select fidkabwil,fnamakabwil,fstatusrow from m_kab where fstatusrow=1 order by fnamakabwil";

		$oDB->query($vsql);

		$i=1;

		while ($oDB->next_record()) {

		   $vres['id'][$i]=$oDB->f('fidkabwil');

		   $vres['nama'][$i]=$oDB->f('fnamakabwil');

		   $i++;

		}

		return $vres;

	}   



  //get Maximum Prov terpakai

    function getMaxProv($pIDProv) {

	    global $oDB;

		$vsql="select max(fidprov) as maxprov from m_stockist where fidprov like '$pIDProv%' and fstatusrow=1";

		$oDB->query($vsql);



		while ($oDB->next_record()) {

		   $vres=substr($oDB->f('maxprov'),2,1);

		}

		if ($vres=="") $vres=0;

		return $vres;

	}   



  //get Maximum Mobile terpakai

    function getMaxMob($pIDProv) {

	    global $oDB;

		$vsql="select max(fidmob) as maxmob from m_stockist where fidprov like '$pIDProv%' and fstatusrow=1";

		$oDB->query($vsql);



		while ($oDB->next_record()) {

		   $vres=$oDB->f('maxmob');

		}

		

		if ($vres=="") $vres=0;

		$vval=intval($vres);

		return $vres;

	}   



  //get Maximum Prov terpakai

    function getMaxWil($pIDWil) {

	    global $oDB;

		$vsql="select max(fidkab) as maxwil from m_stockist where fidkab like '$pIDWil%' and fstatusrow=1";

		$oDB->query($vsql);



		while ($oDB->next_record()) {

		   $vres=substr($oDB->f('maxwil'),2,1);

		}

		if ($vres=="") $vres=0;

		return $vres;

	}   



  //set Stockist

    function setStockistSystem($pID,$pProv,$pWil,$pMob) {

	    global $oDB;

		$vsql="select fidprov,fidkab,fidmob,fidmember from m_stockist where fidmember='$pID'";

		$oDB->query($vsql);



		while ($oDB->next_record()) {

		   $vres=$oDB->f('fidmember');

		}

		if ($vres=="") {

		   $vsql="insert into m_stockist (fidprov,fidkab,fidmob,fidmember) ";

		   $vsql.="values('$pProv','$pWil','$pMob','$pID') ";		   

		   $oDB->query($vsql);

		   $vsql="insert into m_stockist_log (fidprov,fidkab,fidmob,fidmember,ftglentry) ";

		   $vsql.="values('$pProv','$pWil','$pMob','$pID',now()) ";		   

		   $oDB->query($vsql);



		   $vsql="update m_anggota set fstockist=1 where fidmember='$pID'";

		   $oDB->query($vsql);

		} else {

		   $vsql="update m_stockist set fidprov='$pProv',fidkab='$pWil',fidmob='$pMob' where fidmember='$pID'";

		   $oDB->query($vsql);



		   $vsql="insert into m_stockist_log (fidprov,fidkab,fidmob,fidmember,ftglentry) ";

		   $vsql.="values('$pProv','$pWil','$pMob','$pID',now()) ";		   

		   $oDB->query($vsql);

		  

		}

		

		//echo $vsql;

	}



       function getListStockist(&$pCount) {

	   	  global $oDB;

		  $vres="";

		  $vsql="select a.fidmember,concat(a.fidprov,'-',a.fidkab,'-',a.fidmob) as fidstockist,b.fnamaprov,c.fnamakabwil from m_stockist a";

		  $vsql.=" left join m_prov b on substr(a.fidprov,1,2)=b.fidprov ";

		  $vsql.=" left join m_kab c on substr(a.fidkab,1,2)=c.fidkabwil where a.fidmob = '00'";

		  $oDB->query($vsql);

		  $i=0;

		  while ($oDB->next_record()) {

		     $vres['idmember'][$i]=$oDB->f('fidmember');

			 $vres['idstockist'][$i]=$oDB->f('fidstockist');

			 $vres['prov'][$i]=$oDB->f('fnamaprov');

			 $vres['wil'][$i]=$oDB->f('fnamakabwil');

			 $i++;

		  }

		  $pCount=$i;

			return $vres;

	   }



			//REGISTER provinsi 

	 function regProv($fidprov, $fnamaprov ,  $fketerangan , $fuserid) {

			 global $oDB, $oRules, $oSystem;

			 $except="";

			 if ($fidprov=="") {

			      $except.="<font color='#FF0000'> ID Provinsi tidak boleh kosong!</font><br>";

				  $oSystem->jsAlert("ID Provinsi tidak boleh kosong!");

			 }

			 if ($this->checkProv($fidprov)==1) {

			    $except.="<font color='#FF0000'>Error!, ID Provinsi $fidprov sudah digunakan!</font><br>";

				 $oSystem->jsAlert("Error!, ID Provinsi $fidprov sudah digunakan!");

			 }	

			 if ($fnamaprov=="") {

			    $except.="<font color='#FF0000'>Nama Provinsi tidak boleh kosong!</FONT><br>"; 

				$oSystem->jsAlert("Nama Provinsi tidak boleh kosong!");	

			 } 	

	 		 $vsql="INSERT INTO m_prov ( fidprov , fnamaprov ,  fketerangan  , fuserid , ftglentry )"; 

			 $vsql.="VALUES ('$fidprov', '$fnamaprov'  , '$fketerangan' ,  '$fuserid' , now() )" ;

				

			 if ($except!="") {

			    echo $except;	

				return -1;

			 } else {

				$oDB->query($vsql);	

				$oSystem->jsAlert("Data provinsi sudah tersimpan!");	 	

				if ($oDB->affected_rows() > 0 ) {

				  return 1;

				   

				}  

				else

				  return 0;   

				

			 }	  

	}		

	

	

			//REGISTER W53ayah 

	 function regWil($fidkabwil, $fnamakabwil ,  $fketerangan , $fuserid) {

			 global $oDB, $oRules, $oSystem;

			 $except="";

			 if ($fidkabwil=="") {

			      $except.="<font color='#FF0000'> ID Wilayah tidak boleh kosong!</font><br>";

				  $oSystem->jsAlert("ID Wilayah tidak boleh kosong!");

			 }

			 if ($this->checkWil($fidkabwil)==1) {

			    $except.="<font color='#FF0000'>Error!, ID Wilayah $fidkabwil sudah digunakan!</font><br>";

				 $oSystem->jsAlert("Error!, ID Wilayah $fidkabwil sudah digunakan!");

			 }	

			 if ($fnamakabwil=="") {

			    $except.="<font color='#FF0000'>Nama Wilayah tidak boleh kosong!</FONT><br>"; 

				$oSystem->jsAlert("Nama Wilayah tidak boleh kosong!");	

			 } 	

	 		 $vsql="INSERT INTO m_kab ( fidkabwil , fnamakabwil ,  fketerangan  , fuserid , ftglentry )"; 

			 $vsql.="VALUES ('$fidkabwil', '$fnamakabwil'  , '$fketerangan' ,  '$fuserid' , now() )" ;

				

			 if ($except!="") {

			    echo $except;	

				return -1;

			 } else {

				$oDB->query($vsql);	

				$oSystem->jsAlert("Data wilayah sudah tersimpan!");	 	

				if ($oDB->affected_rows() > 0 ) {

				  return 1;

				   

				}  

				else

				  return 0;   

				

			 }	  

	}		

	

        //check apakah ID Prov ada

		function checkProv($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fidprov from m_prov where fidprov='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidprov");

			}

			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}

        //check apakah ID Prov ada

		function checkWil($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fidkabwil from m_kab where fidkabwil='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidkabwil");

			}

			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}

		

		

//Update Provinsi

     function updateProv($fidprov , $fnamaprov , $fketerangan  , $fuserid) {

     	global $oDB, $oSystem;

        $vsql="update m_prov set fidprov='$fidprov',fnamaprov='$fnamaprov',fketerangan='$fketerangan',fuserid='fuserid' where fidprov='$fidprov'"; 

		$oDB->query($vsql);

		$oSystem->jsAlert("Provinsi updated!");

 	 }

	//Delete Provinsi

	 function delProv($pID) {

		 global $oDB, $oSystem;

	 	   $vsql="delete from m_prov where fidprov='$pID' ";	   

		   $oDB->query($vsql);		

 		   $oSystem->jsAlert("Provinsi deleted!");

	 }





//Update Wilayah

     function updateWil($fidkabwil , $fnamakabwil , $fketerangan  , $fuserid) {

     	global $oDB, $oSystem;

        $vsql="update m_kab set fidkabwil='$fidkabwil',fnamakabwil='$fnamakabwil',fketerangan='$fketerangan',fuserid='fuserid' where fidkabwil='$fidkabwil'"; 

		$oDB->query($vsql);

		$oSystem->jsAlert("Wilayah updated!");

 	 }

	//Delete Provinsi

	 function delWil($pID) {

		 global $oDB, $oSystem;

	 	   $vsql="delete from m_kab where fidkabwil='$pID' ";	   

		   $oDB->query($vsql);		

 		   $oSystem->jsAlert("Wilayah deleted!");

	 }



        //get Jumlah member bulan ini

		function getMemberCountThisMonth($pDate) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT count(fidmember) as fjumlah from m_anggota where month(ftglaktif) = month('$pDate') and year(ftglaktif) = year('$pDate') and faktif=1";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fjumlah");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return 0;   

		}



        //get Jumlah member hari ini

		function getMemberCountThisDay($pDate) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT count(fidmember) as fjumlah from m_anggota where ftglaktif like '$pDate%' and faktif=1";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fjumlah");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return 0;   

		}





        //get Jumlah member berdasarkan paket

		function getMemberCountPack($pPack) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT count(fidmember) as fjumlah from m_anggota where fpaket = '$pPack' and faktif=1";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fjumlah");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return 0;   

		}



        //get Jumlah member MS

		function getMemberCountMS() {

            global $oDB; 

			$vres="";

		    $vsql="SELECT count(fidmember) as fjumlah from m_anggota where fstockist = '1' and faktif=1";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fjumlah");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return 0;   

		}



        //get Jumlah member minggu ini

		function getMemberCountThisWeek($pDate) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT count(fidmember) as fjumlah from m_anggota where week(ftglaktif) = week('$pDate') and faktif=1";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fjumlah");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return 0;   

		}

		

		

        //get Jumlah membertotal

		function getMemberCount() {

            global $oDB; 

			$vres="";

		    $vsql="SELECT count(fidmember) as fjumlah from m_anggota where  faktif=1";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fjumlah");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return 0;   

		}

		

//Serial id Used

		function isUsed($pSerno) {

		    global $oDB;

			$vsql="select fserno from m_anggota where fserno='$pSerno'";

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fserno");

			}



			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}

		

		//Check Serial

		function checkSerno($pSerno,$pPin) {

		    global $oDB, $oSystem;

			$vsql="select fserno,fpin from tb_actserial where fserno='$pSerno' and fpin like '%$pPin%' and fstatus=1";

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vserno = $oDB->f("fserno");

				$vpin = $oDB->f("fpin");

			}

			if ($vserno=="") {

			   $oSystem->jsAlert("Serial number <$pSerno> tidak cocok dengan PIN <$pPin>, atau tidak ada, atau tidak aktif, silakan ulangi, atau masukkan serial number yang lain!");		   

			   return 0;			

			} else if ($this->isUsed($vserno)==1) {

			   $oSystem->jsAlert("Serial number sudah pernah digunakan, masukkan serial number yang lain!");

			   return 0;

			} else {

			  return 1;

			}

			

		}





		//Check Serial

		function checkSernoExt($pSerno,$pPin) {

		    global $oDB, $oSystem;

			$vsql="select fserno,fpin from tb_actserial where fserno like '$pSerno%' and fpin like '$pPin%'";

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vserno = $oDB->f("fserno");

				$vpin = $oDB->f("fpin");

			}

			if ($vserno=="") {

			   $oSystem->jsAlert("Serial number <$pSerno> tidak cocok dengan PIN <$pPin>, atau tidak ada, atau tidak aktif, silakan ulangi, atau masukkan serial number yang lain!");		   

			   return 0;			

			} else if ($this->isUsed($vserno)==1) {

			   $oSystem->jsAlert("Serial number sudah pernah digunakan!");

			   return 0;

			} else {

			   $oSystem->jsAlert("Serial number dalam keadaan aktif dan siap digunakan!");

			  return 1;

			}

			

		}



		//Check Serial

		function serialExist($pSerno) {

		    global $oDB, $oSystem;

			 $vsql="select fserno,fpin from tb_actserial where fserno='$pSerno'";

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vserno = $oDB->f("fserno");

				$vpin = $oDB->f("fpin");

			}

			if ($vserno!="") {

			   return 1;			

			} else {

			  return 0;

			}

			

		}





		 //set Premium

	function setPremium($pId) {

		     global $oDB; 

  			 $vsql="update m_anggota set fispremium=1,ftglupgrade=now() where (fidmember='$pId') ";	

			 $oDB->query($vsql);		

		}



		 //set Serial PIN

	function setSerialPIN($pId,$pSerial,$pPIN) {

		     global $oDB; 

  			 $vsql="update m_anggota set fispremium=1, fserno='$pSerial',fpin='$pPIN' where fidmember='$pId' ";	

			 $oDB->query($vsql);		

		}





		 //Deactivate Serial 

	function deactiveSerial($pSerial) {

		     global $oDB; 

  			 $vsql="update tb_actserial set fstatus=0 where fserno='$pSerial' ";	

			 $oDB->query($vsql);		

		}





        //check apakah Premium

		function isPremiumOld($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fispremium from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fispremium");

			}

			if ($vres == 1)

	  		   return 1;

			else

			   return 0;   

		}



        //check apakah Premium

		function isPremium($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fpaket from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fpaket");

			}

			if ($vres == 'P')

	  		   return 1;

			else

			   return 0;   

		}



		//Check Serial Premium

		function checkSernoPrem($pSerno) {

		    global $oDB, $oSystem;

		//	echo "Len:".strlen($pSerno);

			if (strlen($pSerno)==9)  

			  return 1; 

			 else 

			  return 0;

		}



		 //Set Temp

	function setTemp($pId) {

		     global $oDB; 

  			 $vsql="update m_anggota set ftemp='1' where fidmember='$pId' ";	

			 $oDB->query($vsql);		

		}





		 //Un Set Temp

	function unsetTemp($pId) {

		     global $oDB; 

  			 $vsql="update m_anggota set ftemp='0' where fidmember='$pId' ";	

			 $oDB->query($vsql);		

		}



        //check apakah Temp

		function isTemp($pID) {

            global $oDB, $oSystem; 

			$vres="";

		    $vsql="SELECT ftemp from m_anggota where fidmember='$pID' ";	

			

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("ftemp");

			}

			if ($vres == 'Y')

	  		   return 1;

			else

			   return 0;   

		}



        //ambil paket dari ID yang diketahui

		function getPaket($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fpaket from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fpaket");

			}

			if ($vres != "") {

			   if ($vres=='S') $vres="SILVER";

			   if ($vres=='G') $vres="GOLD";

			   if ($vres=='P') $vres="PREMIUM";

			   if ($vres=='B') $vres="BASIC";

			   return $vres;

			}   

			else

			   return -1;   

		}



        //ambil ID paket dari ID yang diketahui

		function getPaketID($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fpaket from m_anggota where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fpaket");

			}

			if ($vres != "") {

			   return $vres;

			}   

			else

			   return -1;   

		}



        //Hitung Member Paket

		function getCountMember($pPaket) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT count(fidmember) as vcount from m_anggota where fpaket='$pPaket' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("vcount");

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}





        //Check Invest

		function checkInvest($pID) {

            global $oDB,$oPhpdate; 

			$vres="";

		    $vsql="SELECT *  from tb_investasi where fidmember='$pID' and ftglaktif= (select max(ftglaktif) from tb_investasi where fidmember='$pID') ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

				$vres['fpaket']=$oDB->f('fpaket');

				$vres['fnominal']=$oDB->f('fnominal');

				$vres['ftgldaftar']=$oDB->f('ftgldaftar');

				$vres['ftglaktif']=$oDB->f('ftglaktif');

				$vres['fstatusrow']=$oDB->f('fstatusrow');

				$vres['fidmember']=$oDB->f('fidmember');

				$vLama=$oPhpdate->dateDiff("d",$oDB->f('ftglaktif'),date("Y-m-d"));

				$vres['period']=$vLama;

			}

			if ($vres != "")

	  		   return $vres;

			else

			   return -1;   

		}







       //Get Next Invest ID

		function getNextInvestID($pTgl) {

		    global $oDB, $oMydate; 

			global $oPrefix;

			 $vsql="select max(fidinvest) as flastid from tb_investasi where year(ftgldaftar) = year('$pTgl') and month(ftgldaftar)=month('$pTgl')";	

			$oDB->query($vsql);

			

			while ($oDB->next_record()) {

			   $lastid = $oDB->f("flastid");

			}

			if (strlen($lastid)<=0) {

			   $vStartPrefix=$oPrefix->getPrefixName(1);

			   $lastid=$vStartPrefix."-".substr($oMydate->getYear($pTgl),2,2).$oMydate->getMonth($pTgl)."0000";

			 }  

			 $prefix=substr($lastid,0,5);

			 $lastid=substr($lastid,5,8);

			$lastid=intval($lastid);

			

			//if ($lastid < 9999) {

				$lastid+=1;

				$len=strlen($lastid);

				for ($i=0;$i<(4-$len);$i++)

					  $lastid="0".$lastid;

				return $lastid=$prefix.$lastid;	  

			

			//} 

		 }	  	 





			//REGISTER Investasi

	 function regInvest($fidinvest,$fidmember, $fpaket='', $fnominal, $ffeeday, $ftgldaftar) {

			 global $oDB, $oRules;

	 		 $vsql="INSERT INTO tb_investasi (fidinvest,fidmember , fpaket , fnominal ,  ffeeday, ftgldaftar) " ;

			  $vsql.="VALUES ('$fidinvest','$fidmember', '$fpaket', $fnominal, $ffeeday, '$ftgldaftar');";	

			 $oDB->query($vsql);

	 }		



        //check apakah ada invest

		function isInvest($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fidmember from tb_investasi where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres != "")

	  		   return 1;

			else

			   return 0;   

		}





        //get invest

		function getInvest($pID) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT * from tb_investasi where fidmember='$pID' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres['nom'] = $oDB->f("fnominal");

				$vres['fee'] = $oDB->f("ffeeday");

			}

	  		   return $vres;

		}





        //ambil ID semua

		function getAllMember($pDate) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT fidmember from m_anggota where faktif='1' and concat(year(ftglaktif),if(month(ftglaktif) < 10,concat('0',month(ftglaktif)),month(ftglaktif)) ) <  '$pDate' order by fidmember ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres[] = $oDB->f("fidmember");

			}

			if (is_array($vres))

	  		   return $vres;

			else

			   return -1;   

		}









        function isCoupledLevel($pID,$pLevel) {

	        global $oDB; 

			$vres="";

		    $vsql="SELECT  fidmember from tb_couple where (fidmember='$pID' or fidcouple='$pID') and flevel=$pLevel";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres!="")

	  		   return true;

			else

			   return false;   

	   

        }





        function isCoupled($pID) {

	        global $oDB; 

			$vres="";

		    $vsql="SELECT  fidmember from tb_couple where (fidmember='$pID' or fidcouple='$pID') ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fidmember");

			}

			if ($vres!="")

	  		   return true;

			else

			   return false;   

	   

        }

		

		function imagePath($vUser){

		   $vImage="images/users/$vUser.";

			if (file_exists($vImage.'jpg'))

			   $vImage="images/users/$vUser.jpg";     

			else if (file_exists($vImage.'JPG'))

			   $vImage="images/users/$vUser.JPG";     

			else if (file_exists($vImage.'jpeg'))

			   $vImage="images/users/$vUser.jpeg";     

			else if (file_exists($vImage.'JPEG'))

			   $vImage="images/users/$vUser.JPEG";     

			else if (file_exists($vImage.'png'))

			   $vImage="images/users/$vUser.png";     

			else if (file_exists($vImage.'PNG'))

			   $vImage="images/users/$vUser.PNG";     

			else if (file_exists($vImage.'gif'))

			   $vImage="images/users/$vUser.gif";     

			else if (file_exists($vImage.'GIF'))

			   $vImage="images/users/$vUser.GIF";  

			else   

			   $vImage="images/users/user2.png";  

			return $vImage;

		}



		 //Set Saldo

	function updateBal($pId,$pBal) {

		     global $oDB; 

  			 $vsql="update m_anggota set fsaldovcr=$pBal where fidmember='$pId' ";	

			 $oDB->query($vsql);		

		}

		 //Set Saldo

	function updateBalBis($pId,$pBal) {

		     global $oDB; 

  			 $vsql="update m_pebisnis set fsaldovcr=$pBal where fidmember='$pId' ";	

			 $oDB->query($vsql);		

		}



	function changeBal($pId,$pAmt,$pDK) {

		     global $oDB; 

		     if ($pDK=='D')

		        $vsql="update m_anggota set fsaldovcr=fsaldovcr-$pAmt where fidmember='$pId' ";	 

  			 else if ($pDK=='K')

  			    $vsql="update m_anggota set fsaldovcr=fsaldovcr+$pAmt where fidmember='$pId' ";	 

  			 

			 $oDB->query($vsql);		

		}

function changeBalBis($pId,$pAmt,$pDK) {

		     global $oDB; 

		     if ($pDK=='D')

		        $vsql="update m_pebisnis set fsaldovcr=fsaldovcr-$pAmt where fidmember='$pId' ";	 

  			 else if ($pDK=='K')

  			    $vsql="update m_pebisnis set fsaldovcr=fsaldovcr+$pAmt where fidmember='$pId' ";	 

  			 

			 $oDB->query($vsql);		

		}

	function updateBalConn($pId,$pBal,$pConn) {

		     global $oDB; 

  			 $vsql="update m_anggota set fsaldovcr=$pBal where fidmember='$pId' ";	

			 $pConn->query($vsql);		

		}





	function updateBalConnMo($pId,$pBal,$pConn) {

		     global $oDB; 

  			 $vsql="update m_anggota set fsaldovcrmo=$pBal where fidmember='$pId' ";	

			 $pConn->query($vsql);		

		}



	function updateBalConnWProd($pId,$pBal,$pConn) {

		     global $oDB; 

  			 $vsql="update m_anggota set fsaldowprod=$pBal where fidmember='$pId' ";	

			 $pConn->query($vsql);		

		}





	function updateBalConnWKit($pId,$pBal,$pConn) {

		     global $oDB; 

  			 $vsql="update m_anggota set fsaldowkit=$pBal where fidmember='$pId' ";	

			 $pConn->query($vsql);		

		}



	function updateBalConnWAcc($pId,$pBal,$pConn) {

		     global $oDB; 

  			 $vsql="update m_anggota set fsaldowacc=$pBal where fidmember='$pId' ";	

			 $pConn->query($vsql);		

		}



	function updateBalConnAdm($pId,$pBal,$pConn) {

		     global $oDB; 

  			 $vsql="update m_admin set fsaldovcr=$pBal where fidmember='$pId' ";	

			 $pConn->query($vsql);		

		}



	function updateBalConnRO($pId,$pBal,$pConn) {

		     global $oDB; 

  			 $vsql="update m_anggota set fsaldoro=$pBal where fidmember='$pId' ";	

			 $pConn->query($vsql);		

		}



	function updateBalConnROAdm($pId,$pBal,$pConn) {

		     global $oDB; 

  			 $vsql="update m_admin set fsaldoro=$pBal where fidmember='$pId' ";	

			 $pConn->query($vsql);		

		}



	function changeBalConn($pId,$pAmt,$pDK,$pConn) {

		     global $oDB; 

		     if ($pDK=='D')

		        $vsql="update m_anggota set fsaldovcr=fsaldovcr-$pBal where fidmember='$pId' ";	 

  			 else if ($pDK=='K')

  			    $vsql="update m_anggota set fsaldovcr=fsaldovcr+$pBal where fidmember='$pId' ";	 

  			 

			 $pConn->query($vsql);		

		}





     //Get Next WD ID

		function getNextWDID($pTgl) {

		    global $oDB, $oMydate; 

			global $oPrefix;

			 $vsql="select max(fidwithdraw) as flastid from tb_withdraw ";	

			$oDB->query($vsql);

			

			while ($oDB->next_record()) {

			   $lastid = $oDB->f("flastid");

			}

			if (strlen($lastid)<=0) {

			   //$vStartPrefix=$oPrefix->getPrefixName(1);

			   $vStartPrefix='VC';

			   $lastid=$vStartPrefix."-".substr($oMydate->getYear($pTgl),2,2).$oMydate->getMonth($pTgl)."0000";

			 }  

			 $prefix=substr($lastid,0,5);

			 $lastid=substr($lastid,5,8);

			$lastid=intval($lastid);

			

			//if ($lastid < 9999) {

				$lastid+=1;

				$len=strlen($lastid);

				for ($i=0;$i<(4-$len);$i++)

					  $lastid="0".$lastid;

				return $lastid=$prefix.$lastid;	  

			

			//} 

		 }	  	 



	//REGISTER Withdraw old

	 function regWithdrawOld($fidwithdraw,$fidmember,$fnominal, $ftglupdate,$fket,$frekfrom,$frekto,$fsync=0,$fcurr) {

			 global $oDB, $oRules;

	 		 $vsql="INSERT INTO tb_withdraw (fidwithdraw,fidmember ,  fnominal ,  ftglupdate,fket,frekfrom,frekto,fsync,fcurr,fstatusrow,ftglappv) " ;

			 $vsql.="VALUES ('$fidwithdraw','$fidmember',  $fnominal, '$ftglupdate','$fket','$frekfrom','$frekto','$fidsyset','$fcurr','2',now());";	

			 $oDB->query($vsql);

			 

			 if (preg_match("/Koreksi Saldo/",$fket)) {

				 $vsql="update tb_withdraw set fstatusrow='2',ftglappv=now(),fadmin='darsa_koreksi' where fidwithdraw='$fidwithdraw'";

			     $oDB->query($vsql);				 

			 }

	 }	


	//REGISTER Transfer
	 function regTransfer($fidtrans,$fidmember,$fnominal, $ftglupdate,$fket,$fidto,$fsync=0) {
			 global $oDB, $oRules;
	 		 $vsql="INSERT INTO tb_baltrans (fidtrans,fidmember ,  fnominal ,  ftglupdate,fket,fidto,fsync) " ;
			 $vsql.="VALUES ('$fidtrans','$fidmember',  $fnominal, '$ftglupdate','$fket','$fidto','$fsync');";	
			
			 if ($oDB->query($vsql)) {
				return 1; 
			 } else return 0;
			 
	 }		
  

	//REGISTER Withdraw
	 function regWithdraw($fidwithdraw,$fidmember,$fnominal, $ftglupdate,$fket,$frekfrom,$frekto,$pJenis,$fsync=0) {
			 global $oDB, $oRules, $oSystem;
			 $vSal=$this->getSaldoAdm($fidmember,$pJenis);
			 if ($vSal >= $fnominal) {

			if($pJenis=='korwil')	{
			    $vsql="select a.fidbisnis from m_korwil a left join m_pebisnis b on b.fidmember=a.fidbisnis  where a.fidkorwil='$fidmember' ";	
			    $oDB->query($vsql);
				$oDB->next_record();
				$fidmember = $oDB->f('fidbisnis');	
			}
				

				 
				 $vsql="INSERT INTO tb_withdraw (fidwithdraw,fidmember ,  fnominal ,  ftglupdate,fket,frekfrom,frekto,fsync) " ;
				 $vsql.="VALUES ('$fidwithdraw','$fidmember',  $fnominal, '$ftglupdate','$fket','$frekfrom','$frekto','$fsync');";	
				 $oDB->query($vsql);
				 
				 if (preg_match("/Koreksi Saldo/",$fket)) {
					 $vsql="update tb_withdraw set fstatusrow='2',ftglappv=now(),fadmin='darsa_koreksi' where fidwithdraw='$fidwithdraw'";
					 $oDB->query($vsql);				 
				 }
				 return 1;
			 } else {
				//$oSystem->jsAlert('Saldo tidak cukup untuk jumlah withdraw yang diinginkan');
				return 0;
			 }
	 }			 

	function getStockPos($pIDMem,$pKodeBrg,$pSize,$pColor) {

	        global $oDB;



			$vres=0;

		   $vsql="SELECT  fbalance from tb_stok_position where fidmember='$pIDMem' and fidproduk='$pKodeBrg' and fsize='$pSize' and fcolor='$pColor'";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fbalance");

			}

			if ($vres == '') $vres='Not Found';

			return $vres;

	}	



	function getStockPosCafe($pIDMem,$pKodeBrg) {

	        global $oDB;



			$vres=0;

		   $vsql="SELECT  fbalance from tb_stok_position where fidmember='$pIDMem' and fidproduk='$pKodeBrg' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fbalance");

			}

			if ($vres == '') $vres='Not Found';

			return $vres;

	}	

	

	

	



	function getStockPosNex($pIDMem,$pKodeBrg) {

	        global $oDB;



			$vres=0;

		   $vsql="SELECT  fbalance from tb_stok_position where fidmember='$pIDMem' and fidproduk='$pKodeBrg' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fbalance");

			}

			if ($vres == '') $vres='Not Found';

			return $vres;

	}	



	function getStockPosUnig($pIDMem,$pKodeBrg) {

	        global $oDB;



			$vres=0;

		   $vsql="SELECT  fbalance from tb_stok_position where fidmember='$pIDMem' and fidproduk='$pKodeBrg' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fbalance");

			}

			if ($vres == '') $vres='Not Found';

			return $vres;

	}	



	function getStockPosNexRO($pIDMem,$pKodeBrg) {

	        global $oDB;



			$vres=0;

		   $vsql="SELECT  fbalance from tb_stok_positionro where fidmember='$pIDMem' and fidproduk='$pKodeBrg' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fbalance");

			}

			if ($vres == '') $vres='Not Found';

			return $vres;

	}



		 //Set saldo

	function setSaldo($pId,$pNom) {

		     global $oDB; 

		     $vsql="update m_anggota set fsaldovcr=$pNom where fidmember='$pId' ";	

			 $oDB->query($vsql);		

		}





		 //Set saldo RO

	function setSaldoRO($pId,$pNom) {

		     global $oDB; 

		     $vsql="update m_anggota set fsaldoro=$pNom where fidmember='$pId' ";	

			 $oDB->query($vsql);		

		}

	

		 //Set saldo

	function setSaldoStock($pId,$pProd,$pSize,$pColor,$pNom) {

		     global $oDB; 

		     $vsql="update tb_stok_position set fbalance=$pNom where fidmember='$pId' and fidproduk='$pProd' and fsize='$pSize' and fcolor='$pColor'";	

			 $oDB->query($vsql);		

		}



		 //Set saldo

	function setSaldoStockNex($pId,$pProd,$pNom,$pConn) {

		     global $oDB; 

		     $vsql="update tb_stok_position set fbalance=$pNom where fidmember='$pId' and fidproduk='$pProd' ";	

			 $pConn->query($vsql);		

		}





		 //Set saldo

	function setSaldoStockWH($pId,$pProd,$pNom,$pConn) {

		     global $oDB; 

		     $vsql="update tb_stok_position set fbalance=$pNom where fidmember='$pId' and fidproduk='$pProd' ";	

			 $pConn->query($vsql);		

		}





		 //Set saldo

	function setSaldoStockNexRO($pId,$pProd,$pNom,$pConn) {

		     global $oDB; 

		     $vsql="update tb_stok_positionro set fbalance=$pNom where fidmember='$pId' and fidproduk='$pProd' ";	

			 $pConn->query($vsql);		

		}



      //Get Next Topup ID

		function getNextTopupID($pTgl) {

		    global $oDB, $oMydate; 

			global $oPrefix;

			 $vsql="select max(fidtopup) as flastid from tb_topup ";	

			$oDB->query($vsql);

			

			while ($oDB->next_record()) {

			   $lastid = $oDB->f("flastid");

			}

			if (strlen($lastid)<=0) {

			   $vStartPrefix=$oPrefix->getPrefixName(1);

			   $lastid=$vStartPrefix."-".substr($oMydate->getYear($pTgl),2,2).$oMydate->getMonth($pTgl)."0000";

			 }  

			 $prefix=substr($lastid,0,5);

			 //$prefix=str_replace("/","-",$prefix);

			 $lastid=substr($lastid,5,8);

			$lastid=intval($lastid);

			

			//if ($lastid < 9999) {

				$lastid+=1;

				$len=strlen($lastid);

				for ($i=0;$i<(4-$len);$i++)

					  $lastid="0".$lastid;

				return $lastid=$prefix.$lastid;	  

			

			//} 

		 }	 









		//REGISTER Topup

	 function regTopup($fidtopup,$fidmember,$fnominal, $ftglupdate,$fket,$frekfrom,$frekto,$fstatusrow='0',$fsync='0') {

			 global $oDB, $oRules;

	 		 $vsql="INSERT INTO tb_topup (fidtopup,fidmember ,  fnominal ,  ftglupdate,fket,frekfrom,frekto,fstatusrow,fsync) " ;

			 $vsql.="VALUES ('$fidtopup','$fidmember',  $fnominal, '$ftglupdate','$fket','$frekfrom','$frekto',$fstatusrow,'$fsync');";	

			 $oDB->query($vsql);



			 if (preg_match("/Koreksi Saldo/",$fket)) {

				 $vsql="update tb_topup set fstatusrow='2',ftglappv=now(),fadmin='darsa_koreksi' where fidtopup='$fidtopup'";

			     $oDB->query($vsql);				 

			 }

			 

	 }	

	 

	 

		 //Update saldo

	function updateSaldo($pId,$pNom,$pDK) {

		     global $oDB, $oSystem; 

  			 if ($pDK=='K')

			    $vsql="update m_anggota set fsaldovcr=fsaldovcr+$pNom,fsync='0' where fidmember='$pId' ";	

			 else $vsql="update m_anggota set fsaldovcr=fsaldovcr-$pNom,fsync='0' where fidmember='$pId' ";	

			 	//$oSystem->sendMail("didit@operamail.com","japri_s@yahoo.com","Didit Opera","","Debug Update Saldo AMH",$vsql,"localhost");

			 $oDB->query($vsql);		

		}	

		
		 //Update saldo

	function updateSaldoBiz($pId,$pNom,$pDK) {

		     global $oDB, $oSystem; 

  			 if ($pDK=='K')

			    $vsql="update m_pebisnis set fsaldovcr=fsaldovcr+$pNom where fidmember='$pId' ";	

			 else $vsql="update m_pebisnis set fsaldovcr=fsaldovcr-$pNom where fidmember='$pId' ";	

			 	//$oSystem->sendMail("didit@operamail.com","japri_s@yahoo.com","Didit Opera","","Debug Update Saldo AMH",$vsql,"localhost");

			 $oDB->query($vsql);		

		}	

        //get Outlet

		function getOutletName($pIDOut) {

            global $oDB; 

			$vres="";

		    $vsql="SELECT * from m_outlet where fidoutlet='$pIDOut' ";	

			$oDB->query($vsql);

			while ($oDB->next_record()) {

			    $vres = $oDB->f("fnama");

				

			}

	  		   return $vres;

		}	
		
		


        //get Member counter

		function getMemCount($pYear,$pMonth) {

              global $oDB; 
			$vres="";
		    $vsql="SELECT fvalue,fyear from tb_idcounter where fyear='$pYear' and fmonth='$pMonth' ";	
			$oDB->query($vsql);

			while ($oDB->next_record()) {
			    $vres = $oDB->f("fvalue");
				$vresy = $oDB->f("fyear");
			}
	  		
			if (trim($vres)=='' && trim($vresy)=='') {
						$vsql="insert into tb_idcounter(fyear,fmonth,fvalue) values('$pYear','$pMonth',0) ";
						$oDB->query($vsql);		     	
						$vres=0;
			} else if (trim($vres)!='' || trim($vresy) !='') {
					   		$vsql="update tb_idcounter set  fvalue = 0 where fyear='$pYear' and fmonth='$pMonth' and  (fvalue =''  or fvalue is null )  ";	
							$oDB->query($vsql);		     	
						
			   
			}
			if (trim($vres) == '' ) $vres=0;
			return $vres;

		}				

//get Tabungan counter

		function getTabCount($pYear,$pMonth) {

              global $oDB; 
			$vres="";
		    $vsql="SELECT fvalue,fyear from tb_tabcounter where fyear='$pYear' and fmonth='$pMonth' ";	
			$oDB->query($vsql);

			while ($oDB->next_record()) {
			    $vres = $oDB->f("fvalue");
				$vresy = $oDB->f("fyear");
			}
	  		
			if (trim($vres)=='' && trim($vresy)=='') {
						$vsql="insert into tb_tabcounter(fyear,fmonth,fvalue) values('$pYear','$pMonth',0) ";
						$oDB->query($vsql);		     	
						$vres=0;
			} else if (trim($vres)!='' || trim($vresy) !='') {
					   		$vsql="update tb_tabcounter set  fvalue = 0 where fyear='$pYear' and fmonth='$pMonth' and  (fvalue =''  or fvalue is null )  ";	
							$oDB->query($vsql);		     	
						
			   
			}
			if (trim($vres) == '' ) $vres=0;
			return $vres;

		}	

        //get Kuitansi counter

		function getKuiCount($pYear,$pMonth) {

            global $oDB; 
			$vres="";
		    $vsql="SELECT fvaluekui,fyear from tb_idcounter where fyear='$pYear' and fmonth='$pMonth' ";	
			$oDB->query($vsql);

			while ($oDB->next_record()) {
			    $vres = $oDB->f("fvaluekui");
				$vresy = $oDB->f("fyear");
			}
	  		
			if (trim($vres)=='' && trim($vresy)=='') {
						$vsql="insert into tb_idcounter(fyear,fmonth,fvaluekui) values('$pYear','$pMonth',0) ";
						$oDB->query($vsql);		     	
						$vres=0;
			} else if (trim($vres)=='' && trim($vresy) !='') {
					   		$vsql="update tb_idcounter set  fvaluekui = 0 where fyear='$pYear' and fmonth='$pMonth'  and  (fvaluekui =''  or fvaluekui is null ) ";	
							$oDB->query($vsql);		     	
							
			   
			}
			if (trim($vres) == '' ) $vres=0;
			return $vres;

		}				



      //get Invoice counter

		function getInvCount($pYear,$pMonth) {

            global $oDB; 
			$vres="";
		    $vsql="SELECT fvalueinv,fyear from tb_idcounter where fyear='$pYear' and fmonth='$pMonth' ";	
			$oDB->query($vsql);

			while ($oDB->next_record()) {
			    $vres = $oDB->f("fvalueinv");
				$vresy = $oDB->f("fyear");
			}
	  		
			if (trim($vres)=='' && trim($vresy)=='') {
						$vsql="insert into tb_idcounter(fyear,fmonth,fvalueinv) values('$pYear','$pMonth',0) ";
						$oDB->query($vsql);		     	
						$vres=0;
			} else if (trim($vres)=='' &&  trim($vresy) !='') {
					   		$vsql="update tb_idcounter set  fvalueinv = 0 where fyear='$pYear' and fmonth='$pMonth' ";	
							$oDB->query($vsql);		     	
							$vres=0;
			   
			}
		//	echo $vsql;
			return $vres;

		}				
        //Update Member counter

		function updMemCount($pYear,$pMonth,$pValue,$db) {

            global $oDB; 
			$vres="";
		    $vsql="update tb_idcounter set fvalue=$pValue where fyear='$pYear' and fmonth='$pMonth' ";	
			
			$db->query($vsql);
		}		
		

        //Update Tabungan counter

		function updTabCount($pYear,$pMonth,$pValue,$db) {

            global $oDB; 
			$vres="";
		    $vsql="update tb_tabcounter set fvalue=$pValue where fyear='$pYear' and fmonth='$pMonth' ";	
			
			$db->query($vsql);
		}		
       //Get Next WD ID
		function getNextTransID($pTgl) {
		    global $oDB, $oMydate; 
			global $oPrefix;
			 $vsql="select max(fidtrans) as flastid from tb_baltrans ";	
			$oDB->query($vsql);
			
			while ($oDB->next_record()) {
			   $lastid = $oDB->f("flastid");
			}
			if (strlen($lastid)<=0) {
			   //$vStartPrefix=$oPrefix->getPrefixName(1);
			   $vStartPrefix='TR';
			   $lastid=$vStartPrefix."-".substr($oMydate->getYear($pTgl),2,2).$oMydate->getMonth($pTgl)."0000";
			 }  
			 $prefix=substr($lastid,0,5);
			 $lastid=substr($lastid,5,8);
			$lastid=intval($lastid);
			
			//if ($lastid < 9999) {
				$lastid+=1;
				$len=strlen($lastid);
				for ($i=0;$i<(4-$len);$i++)
					  $lastid="0".$lastid;
				return $lastid=$prefix.$lastid;	  
			
			//} 
		 }						 		 	 


      //Get Next TRXPulsa ID
		function getNextTrxID($pTgl) {
		    global $oDB, $oMydate; 
			global $oPrefix;
			$vStartPrefix="TP";

			$vMonth=$oMydate->getMonth($pTgl);
			if ($vMonth < 10)
			    $vMonth="0".(int) $vMonth;
			
			$vDay=$oMydate->getDay($pTgl);	
			if ($vDay < 10)
			     $vDay="0".(int) $vDay;
			
			$lastidx=$vStartPrefix."-".substr($oMydate->getYear($pTgl),2,2).$vMonth.$vDay;
			$lastid="";
			$vsql="select fidtrx as flastid from tb_trxpulsa_temp where fidtrx like '$lastidx%'";	
			$oDB->query($vsql);
			
			while ($oDB->next_record()) {
			   $lastid = $oDB->f("flastid");
			}
			if (strlen($lastid)<=0) {
			   $lastid=$vStartPrefix."-".substr($oMydate->getYear($pTgl),2,2).$vMonth.$vDay."0000";
			 }  
            $vPrefixDay=substr($lastid,0,9);
			 $vsql="select max(fidtrx) as flastid from tb_trxpulsa_temp where fidtrx like '$vPrefixDay%'";	
			$oDB->query($vsql);
			
			while ($oDB->next_record()) {
			   $lastid = $oDB->f("flastid");
			}

			$lastid=substr($lastid,9,4);
			$lastid=intval($lastid);
			
			//if ($lastid < 9999) {
				$lastid+=1;
				$len=strlen($lastid);
				for ($i=0;$i<(4-$len);$i++)
					  $lastid="0".$lastid;
				return $lastid=$vPrefixDay.$lastid;	  
			
			//} 
		 }	  	 



     //Get Next TRXPPOB ID
		function getNextTrxIDPO($pTgl) {
		    global $oDB, $oMydate; 
			global $oPrefix;
			$vStartPrefix="TO";

			$vMonth=$oMydate->getMonth($pTgl);
			if ($vMonth < 10)
			     $vMonth="0".(int) $vMonth;
			
			$vDay=$oMydate->getDay($pTgl);	
			if ($vDay < 10)
			    $vDay="0".(int) $vDay;
			
			$lastidx=$vStartPrefix."-".substr($oMydate->getYear($pTgl),2,2).$vMonth.$vDay;
			$lastid="";
			$vsql="select fidtrx as flastid from tb_trxpulsa_temp where fidtrx like '$lastidx%'";	
			$oDB->query($vsql);
			
			while ($oDB->next_record()) {
			   $lastid = $oDB->f("flastid");
			}
			if (strlen($lastid)<=0) {
			   $lastid=$vStartPrefix."-".substr($oMydate->getYear($pTgl),2,2).$vMonth.$vDay."0000";
			 }  
            $vPrefixDay=substr($lastid,0,9);
			 $vsql="select max(fidtrx) as flastid from tb_trxpulsa_temp where fidtrx like '$vPrefixDay%'";	
			$oDB->query($vsql);
			
			while ($oDB->next_record()) {
			   $lastid = $oDB->f("flastid");
			}

			$lastid=substr($lastid,9,4);
			$lastid=intval($lastid);
			
			//if ($lastid < 9999) {
				$lastid+=1;
				$len=strlen($lastid);
				for ($i=0;$i<(4-$len);$i++)
					  $lastid="0".$lastid;
				return $lastid=$vPrefixDay.$lastid;	  
			
			//} 
		 }	  	 



    //Get Next TRXPPOB ID
		function getNextTrxIDCek($pTgl) {
		    global $oDB, $oMydate; 
			global $oPrefix;
			$vStartPrefix="CK";

			$vMonth=$oMydate->getMonth($pTgl);
			if ($vMonth < 10)
			    $vMonth="0".(int) $vMonth;
			
			$vDay=$oMydate->getDay($pTgl);	
			if ($vDay < 10)
			    $vDay="0".(int) $vDay;
			
			$lastidx=$vStartPrefix."-".substr($oMydate->getYear($pTgl),2,2).$vMonth.$vDay;
			$lastid="";
			$vsql="select fidtrx as flastid from tb_cekppob where fidtrx like '$lastidx%'";	
			$oDB->query($vsql);
			
			while ($oDB->next_record()) {
			   $lastid = $oDB->f("flastid");
			}
			if (strlen($lastid)<=0) {
			   $lastid=$vStartPrefix."-".substr($oMydate->getYear($pTgl),2,2).$vMonth.$vDay."0000";
			 }  
            $vPrefixDay=substr($lastid,0,9);
			 $vsql="select max(fidtrx) as flastid from tb_cekppob where fidtrx like '$vPrefixDay%'";	
			$oDB->query($vsql);
			
			while ($oDB->next_record()) {
			   $lastid = $oDB->f("flastid");
			}

			$lastid=substr($lastid,9,4);
			$lastid=intval($lastid);
			
			//if ($lastid < 9999) {
				$lastid+=1;
				$len=strlen($lastid);
				for ($i=0;$i<(4-$len);$i++)
					  $lastid="0".$lastid;
				return $lastid=$vPrefixDay.$lastid;	  
			
			//} 
		 }	
		 
    //Get Next TRXPPOB Listprod
		function getNextTrxIDCekList($pTgl) {
		    global $oDB, $oMydate; 
			global $oPrefix;
			$vStartPrefix="CL";

			$vMonth=$oMydate->getMonth($pTgl);
			if ($vMonth < 10)
			    $vMonth="0".(int) $vMonth;
			
			$vDay=$oMydate->getDay($pTgl);	
			if ($vDay < 10)
			    $vDay="0".(int) $vDay;
			
			$lastidx=$vStartPrefix."-".substr($oMydate->getYear($pTgl),2,2).$vMonth.$vDay;
			$lastid="";
			$vsql="select fidtrx as flastid from tb_cekppob where fidtrx like '$lastidx%'";	
			$oDB->query($vsql);
			
			while ($oDB->next_record()) {
			   $lastid = $oDB->f("flastid");
			}
			if (strlen($lastid)<=0) {
			   $lastid=$vStartPrefix."-".substr($oMydate->getYear($pTgl),2,2).$vMonth.$vDay."0000";
			 }  
            $vPrefixDay=substr($lastid,0,9);
			 $vsql="select max(fidtrx) as flastid from tb_cekppob where fidtrx like '$vPrefixDay%'";	
			$oDB->query($vsql);
			
			while ($oDB->next_record()) {
			   $lastid = $oDB->f("flastid");
			}

			$lastid=substr($lastid,9,4);
			$lastid=intval($lastid);
			
			//if ($lastid < 9999) {
				$lastid+=1;
				$len=strlen($lastid);
				for ($i=0;$i<(4-$len);$i++)
					  $lastid="0".$lastid;
				return $lastid=$vPrefixDay.$lastid;	  
			
			//} 
		 }	  	 		   	 

} //Class




$oMember = new member;



?>
