<?php
 //include_once $CLASS_DIR."phplib.php";	
   class rules {
        //ambil HP Konfirmasi
		function getHPConf($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fhpconf from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fhpconf");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil HP/Phone CS
		function getHPCS($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fhpcs from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fhpcs");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil jumlah fee registrasi dari aturan
		function getRegFee($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fsetval from tb_rules_config where fsetname='fregfee' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fsetval");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //Set jumlah fee registrasi dari aturan
		function setRegFee($pID, $pFee) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fsetval=$pFee, ftglupdate=now()  where fsetname='fregfee' ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil jumlah fee management dari aturan
		function getManFee($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fsetval from tb_rules_config where fsetname='fmanfee' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fsetval");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //Set jumlah fee management dari aturan
		function setManFee($pID, $pFee) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fmanfee=$pFee, ftglupdate=now()  where fidrule=$pID ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil max jumlah downline langsung dari seorang member dari aturan
		function getMaxDownline($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fsetval from tb_rules_config where fsetname='fmaxdownline' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fsetval");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //Set jumlah max downline dari aturan
		function setMaxDownline($pID, $pDown) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fsetval=$pDown, ftglupdate=now()  where fsetname='fmaxdownline' ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}



        //ambil jumlah fee matrix member dari aturan
		function getMtxFee($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fsetval from tb_rules_config where fsetname='fmtxfee' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fsetwal");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //Set jumlah fee matrix member dari aturan
		function setMtxFee($pID, $pFee) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fsetval=$pFee, ftglupdate=now()  where fsetname='fmtxfee' ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil jumlah fee sponsor member dari aturan
		function getSponFee($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fsetval from tb_rules_config where fsetname='fsponfee' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fsetval");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //Set jumlah fee sponsor member dari aturan
		function setSponFee($pID, $pFee) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fsponfee=$pFee, ftglupdate=now()  where fidrule=$pID ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil jumlah max level dari aturan
		function getMaxLevel($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fsetval from tb_rules_config where fsetname='fmaxlevel' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fsetval");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil jumlah max level dari real level matrix
		function getRealMaxLevel($pFee) {
            global $oDB; 
			$vres=0;
			
			switch($pFee) {
			case 1:
				$vFee="ffee";
				break;
			case 2:
				$vFee="ffeebuy";
				break;
			case 3:
				$vFee="ffeeext1";
				break;
			case 4:
				$vFee="ffeeext2";
				break;
			case 5:
				$vFee="ffeeext3";
				break;			
			}
		     $vsql="SELECT count(fidsys) as  fmaxlevel from tb_level where $vFee <> -1  ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fmaxlevel");
			}
			if ($vres > 0)
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil jumlah Fee Matrix total
		function getRealMtxFee() {
            global $oDB; 
			$vres=0;
		    $vsql="SELECT sum(ffee) as  ftotfee from tb_level  ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("ftotfee");
			}
			if ($vres > 0)
	  		   return $vres;
			else
			   return -1;   
		}


		
        //Set Max Level dari aturan
		function setMaxLevel($pID, $pLevel) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fmaxlevel=$pLevel, ftglupdate=now()  where fidrule=$pID ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}
		
		
        //ambil Minimum Transfer  dari Aturan
		function getMinTrans($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fmintransfer from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fmintransfer");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil Minimum Transfer Komisi Penjualan  dari Aturan
		function getMinTransBuy($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fmintransferbuy from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fmintransferbuy");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil Harga Paket penjualan
		function getHrgPaket($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fhrgpaket from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fhrgpaket");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //Set jumlah minimum transfer dari aturan
		function setMinTrans($pID, $pTrans) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fmintransfer=$pTrans, ftglupdate=now()  where fidrule=$pID ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}


        //Set jumlah minimum transfer penjualan dari aturan
		function setMinTransBuy($pID, $pTrans) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fmintransferbuy=$pTrans, ftglupdate=now()  where fidrule=$pID ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil Minimum Transfer Breakaway  dari Aturan
		function getMinBreak($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fminbreak from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fminbreak");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;		}

        //ambil SMTP Server
		function getSMTP($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fsmtp from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fsmtp");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //Set SMTP
		function setSMTP($pID, $pSMTP) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fsmtp=$pSMTP, ftglupdate=now()  where fidrule=$pID ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil From Mail
		function getMailFrom() {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fsetval from tb_rules_config where fsetname='fmailfrom' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fsetval ");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //Set Mail From
		function setMailFrom($pID, $pFrom) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fmailfrom=$pFrom, ftglupdate=now()  where fidrule=$pID ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil BCC Mail
		function getMailBCC() {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fsetval from tb_rules_config where fsetname='fmailbcc'";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fsetval ");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //Set BCC Mail
		function setMailBCC($pID, $pBCC) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fmailbcc=$pBCC, ftglupdate=now()  where fidrule=$pID ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil Bank
		function getBank($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fbank from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fbank");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil Rekening
		function getRekening($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fnorekening from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fnorekening");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil Atas Nama
		function getAtasNama($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fatasnama from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fatasnama");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil All Bank
		function getAllBank($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fbank,fnorekening,fatasnama from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fbank")." no. ".$oDB->f("fnorekening")." a.n. ".$oDB->f("fatasnama");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}





        //ambil Bank2
		function getBank2($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fbank2 from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fbank2");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil Rekening2
		function getRekening2($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fnorekening2 from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fnorekening2");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil Atas Nama2
		function getAtasNama2($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fatasnama2 from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fatasnama2");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil All Bank 2
		function getAllBank2($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fbank2,fnorekening2,fatasnama2 from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fbank2")." no. ".$oDB->f("fnorekening2")." a.n. ".$oDB->f("fatasnama2");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}



        //ambil Subjeck Konfirmasi
		function getSubjConf($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fsubjconf from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fsubjconf");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil Isi Konfirmasi
		function getIsiConf($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fisiconf from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fisiconf");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil Subject Aktifasi
		function getSubjAct() {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fsetval from tb_rules_config where fsetname='fsubjact' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fsetval ");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil Isi Aktifasi
		function getIsiAct($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fisiact from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fisiact");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil lokasi gambar Header
		function getHeaderSrc($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fimageheader from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fimageheader");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil lokasi gambar Header Member
		function getMemberSrc($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fimagemember from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fimagemember");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil lokasi gambar Header Admin
		function getAdminSrc($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fimageadmin from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fimageadmin");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}
//set Header utama
		function setHeaderSrc($pID, $pHead) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fimageheader='$pHead', ftglupdate=now()  where fidrule=$pID ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}


//set Header Admin
		function setAdminSrc($pID, $pHead) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fimageadmin='$pHead', ftglupdate=now()  where fidrule=$pID ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}

//set Header Member
		function setMemberSrc($pID, $pHead) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fimagemember='$pHead', ftglupdate=now()  where fidrule=$pID ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil Fee Level
		function getLevelNum($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fidsys,fidlevel from tb_level where fidsys=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fidlevel");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}



        //Set  Level
		function setLevel($pID,$pLevel,$pFee,$pFeeBuy,$pFeeExt1,$pFeeExt2,$pFeeExt3) {
            global $oDB; 
			$vres="";
		    $vsql="update tb_level set fidlevel=$pLevel,ffee=$pFee,ffeebuy=$pFeeBuy,ffeeext1=$pFeeExt1,ffeeext2=$pFeeExt2,ffeeext3=$pFeeExt3 where fidsys=$pID ";	
			$oDB->query($vsql);
		}

        //Del  Level
		function delLevel($pID) {
            global $oDB; 
			$vres="";
		    $vsql="delete from tb_level where fidsys=$pID ;";
			$oDB->query($vsql);
		}


        //Del  KNP
		function delKNP($pID) {
            global $oDB; 
			$vres="";
		    $vsql="delete from tb_knp where fidsys=$pID ;";
			$oDB->query($vsql);
		}

        //Add  Level
		function addLevel($pLevel,$pFee,$pFeeBuy,$pFeeExt1,$pFeeExt2,$pFeeExt3) {
            global $oDB; 
			$vres="";
		     $vsql="insert into tb_level(fidlevel,ffee,ffeebuy,ffeeext1,ffeeext2,ffeeext3) values($pLevel,$pFee,$pFeeBuy,$pFeeExt1,$pFeeExt2,$pFeeExt3);";
			$oDB->query($vsql);
		}


        //Add  KNP
		function addKNP($pMonth,$pYear,$pKNP,$pUserid) {
            global $oDB, $oSystem; 
			$vres="";
		    $vsql="select fidsys from tb_knp where fmonth=$pMonth and fyear=$pYear ";
			$oDB->query($vsql);
			$oDB->next_record();
			if ($oDB->f("fidsys") != "") 
			   $oSystem->jsAlert("KNP bulan $pMonth tahun $pYear sudah ada, silakan masukkan bulan-tahun yang lain atau hapus dulu bulan $pMonth tahun $pYear dan masukkan lagi!");
			else {
			   $vsql="insert into tb_knp(fmonth,fyear,fknp,fuserid,ftglentry) values($pMonth,$pYear,$pKNP,'$pUserid',now());";
			   $oDB->query($vsql);
			}
		}


        //ambil Fee Level berdasarkan ID Sys
		function getLevelFeeByIDSys($pID,$pFeeType) {
            global $oDB; 
			if ($pFeeType==1)
			   $vFeeType="ffee";
			else if ($pFeeType==2) 
			    $vFeeType="ffeebuy";
			else if ($pFeeType==3) 
			    $vFeeType="ffeeext1";
			else if ($pFeeType==4) 
			    $vFeeType="ffeeext2";
			else if ($pFeeType==5) 
			    $vFeeType="ffeeext3";
	
			$vres="";
		    $vsql="SELECT fidsys,fidlevel,$vFeeType from tb_level where fidsys=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f($vFeeType);
			}
			if ($vres != "")
	  		   return number_format($vres,0,",","");
			else
			   return -1;   
		}


        //ambil Fee Level berdasarkan ID Level
		function getLevelFeeByID($pID,$pFeeType) {
            global $oDB; 
			if ($pFeeType==1)
			   $vFeeType="ffee";
			else if ($pFeeType==2) 
			    $vFeeType="ffeebuy";
			else if ($pFeeType==3) 
			    $vFeeType="ffeeext1";
			else if ($pFeeType==4) 
			    $vFeeType="ffeeext2";
			else if ($pFeeType==5) 
			    $vFeeType="ffeeext3";

			$vres=0;
		    $vsql="SELECT $vFeeType from tb_level where fidlevel=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f($vFeeType);
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}



        //Set minumum breakaway tertransfer dari aturan
		function setMinBreak($pID, $pBreak) {
            global $oDB; 
			$vres="";
		    $vsql="UPDATE tb_rules_config set fminbreak=$pBreak, ftglupdate=now()  where fidrule=$pID ";	
			$oDB->query($vsql);
			$vres=$oDB->affected_rows();
			if ($vres > 0 )
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil Start Periode
		function getStartPeriod($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fstartperiode from tb_rules_config where fidrule=$pID ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fstartperiode");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil Setting berdasarkan Field
		function getSettingByField($pField,$pAdd=0) {
            global $oDB; 
			$vres="";
		    if ($pAdd==0)
			    $vsql="SELECT fsetval as fres from tb_rules_config where fsetname='$pField' ";	
			else 
			    $vsql="SELECT fsetadd1 as fres from tb_rules_config where fsetname='$pField' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("fres");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil Fee dari invest
		function getFeeByInvest($pInvest) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT ffeebuy from tb_level where ffeeext1=$pInvest ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("ffeebuy");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return 0;   
		}


        //ambil label dari invest
		function getLabelByInvest($pInvest) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT flabel from tb_level where ffeeext1=$pInvest ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $vres = $oDB->f("flabel");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}
		
	   //Ambil Setting bonus Korwil
		function getBnsSetting($pJenis,$pProgram, $pLevel='',$pPaket='') {
            global $oDB; 
			$vres="";
			$vsql="";
		    if ($pJenis=='KTP' && $pLevel=='KOR')
				$vsql="SELECT fbnskorwil as fbns from tb_rules_bnskorwil where fidprogram='$pProgram' and fpackid='$pPaket' and factive='1' ";	
		    else if ($pJenis=='KTP' && $pLevel=='SUBKOR')
				$vsql="SELECT fbnssubkor as fbns from tb_rules_bnskorwil where fidprogram='$pProgram' and fpackid='$pPaket' and factive='1' ";	
		    else if ($pJenis=='REG' && $pLevel=='KOR')
				$vsql="SELECT fbnsregkor as fbns from tb_rules_bnskorwil where fidprogram='$pProgram' and fpackid='$pPaket' and factive='1' ";	
		    else if ($pJenis=='REG' && $pLevel=='SUBKOR')
				$vsql="SELECT fbnsregsubkor as fbns from tb_rules_bnskorwil where fidprogram='$pProgram' and fpackid='$pPaket' and factive='1' ";	
		    else if ($pJenis=='REG' && $pLevel=='KORBYSUB')
				$vsql="SELECT fbnsregkorbysub as fbns from tb_rules_bnskorwil where fidprogram='$pProgram' and fpackid='$pPaket' and factive='1' ";	
		    else if ($pJenis=='REG' && $pLevel=='SPON')
				$vsql="SELECT fbnsregspon as fbns from tb_rules_bnskorwil where fidprogram='$pProgram' and fpackid='$pPaket' and factive='1' ";	
		    else if ($pJenis=='REG' && $pLevel=='SPONSUB')
				$vsql="SELECT fbnsregsubspon as fbns from tb_rules_bnskorwil where fidprogram='$pProgram' and fpackid='$pPaket' and factive='1' ";	
		    else if ($pJenis=='REG' && $pLevel=='HPSPON')
				$vsql="SELECT fbnssponhp as fbns from tb_rules_bnskorwil where fidprogram='$pProgram' and fpackid='$pPaket' and factive='1' ";	
		    else if ($pJenis=='SPON')
				$vsql="SELECT fbnsspon as fbns from tb_rules_bnskorwil where fidprogram='$pProgram' and fpackid='$pPaket' and factive='1' ";	
			
			if ($vsql != "") {
				$oDB->query($vsql);
				if ($pJenis=='REG' && $pLevel=='HPSPON' && $oDB->num_rows() <= 0) {
					$vsql="SELECT fbnssponhp as fbns from tb_rules_bnskorwil where factive='1' ";
					$oDB->query($vsql);
				}
				while ($oDB->next_record()) {
				    $vres = $oDB->f("fbns");
				}
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return 0;   
		}		
		
		
   } //Class
   
   $oRules = new rules;

?>
