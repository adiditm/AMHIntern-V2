<?php
  // include_once "../config.php";   
   include_once CLASS_DIR."ruleconfigclass.php";   
   include_once CLASS_DIR."memberclass.php";   
   include_once CLASS_DIR."systemclass.php";   
   include_once CLASS_DIR."komisiclass.php";   
   include_once CLASS_DIR."jualclass.php";   
    include_once CLASS_DIR."dateclass.php";   
   include_once "../classes/espayclass.php";  
    	
   class cMember {
	   var $prLevel;
	   var $prMember;
   }
  
   class network {

        //ambil sponsor  dari ID yang diketahui , digunakan juga oleh getUplineLevel
		function getSponsor($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fsponsor from tb_updown where fdownline='$pID'  ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres = $oDB->f("fsponsor");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

        //ambil upline  dari ID yang diketahui , digunakan juga oleh getUplineLevel
		function getUpline($pID) {
            global $dbin1; 
			$vres="";
		    $vsql="SELECT fupline from tb_updown where fdownline='$pID'  ";	
			$dbin1->query($vsql);
			while ($dbin1->next_record()) {
			   $vres = $dbin1->f("fupline");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}
		


        //ambil downline kiri atau kanan  dari ID yang diketahui LR
		function getDownLR($pID,$pPos) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fdownline from tb_updown where fupline='$pID'  and fposisi='$pPos' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres = $oDB->f("fdownline");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}
        //ambil downline kiri atau kanan  dari ID yang diketahui 1 2
		function getDown12($pID,$pPos) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fdownline from tb_updown where fupline='$pID'  and fkakike='$pPos' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres = $oDB->f("fdownline");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil downline kiri atau kanan  dari ID yang diketahui
		function getDownLRGP($pID,$pPos) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fdownline from tb_updown where fupline='$pID'  and fkakike='$pPos' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres = $oDB->f("fdownline");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil downline kiri atau kanan  dari ID yang diketahui
		function getDownLRP($pID,$pPos) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fdownline from tb_updown where fupline='$pID'  and fposisi='$pPos' ";	
		 
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres = $oDB->f("fdownline");
			}
			 // echo "<br>";
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil downline kiri atau kanan  dari ID yang diketahui by date
		function getDownLRByDate($pID,$pPos,$pDate) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fdownline from tb_updown where fupline='$pID'  and fkakike='$pPos' and ftanggal like '$pDate%'";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres = $oDB->f("fdownline");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


        //ambil downline kiri atau kanan  dari ID yang diketahui by date
		function getDownLRByDateRange($pID,$pPos,$pDate,$pDateTo) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT a.fdownline from tb_updown a, m_anggota b where fupline='$pID' and a.fdownline=b.fidmember  and b.fispremium=0 and a.fkakike='$pPos' and a.ftanggal between '$pDate' and '$pDateTo'";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres = $oDB->f("fdownline");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}



        //ambil downline kiri atau kanan  dari ID yang diketahui by date Premium
		function getDownLRByDateRangePrem($pID,$pPos,$pDate,$pDateTo) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT a.fdownline from tb_updown a, m_anggota b where a.fupline='$pID' and a.fdownline=b.fidmember and b.fispremium=1 and a.fkakike='$pPos' and b.ftglupgrade between '$pDate' and '$pDateTo'";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres = $oDB->f("fdownline");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}


//ambil upline sampai level tertentu		
		function getUplineLevel($pID,$pLevel) {
    			$vres=$this->getUpline($pID);			
				$vcount=$pLevel-1;
				for ($i=0;$i<($vcount);$i++) {
					$vres=$this->getUpline($vres);
				}
			   return $vres; 
		}

//ambil upline sampai level 10 atau dibawahnya		
		function getUplineLevel10($pID) {
    			$vres=$this->getUpline($pID);			
				$vcount=10;
				for ($i=0;$i<$vcount;$i++) {
					$vout=$vres;
					$vres=$this->getUpline($vres);
					if ($vres==-1)
					   break; 
					
				}
			   return $vout; 
		}


//ambil upline sponsor level tertentu		
		function getSponLevel($pID,$pLevel) {
    			$vres=$this->getSponsor($pID);			
				$vcount=$pLevel-1;
				for ($i=0;$i<($vcount);$i++) {
					$vres=$this->getSponsor($vres);
				}
			   return $vres; 

		}

        //jumlah downline langsung dibawahnya (level 1)
		function getDownlineCount1($pID) {
            global $oDB;
			$vres="";
		    $vsql="SELECT count(fdownline) as fcountdown from tb_updown where fupline='$pID'  ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres=$oDB->f("fcountdown");
			}
	  		   return $vres; 
		}


        //jumlah downline langsung dibawahnya Tutup Point
		function getDownlineCount1TPoint($pID) {
            global $oDB;
			$vres="";
		    $vsql="SELECT count(fdownline) as fcountdown from tb_updown where fupline='$pID'  and fdownline in (select fidmember from tb_penjualan where month(ftanggal)=month(now()) and year(ftanggal)=year(now()))";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres=$oDB->f("fcountdown");
			}
	  		   return $vres; 
		}

  /*      //Downline langsung dibawahnya
		function getDownline($pID, &$pOut) {
            global $oDB;
			$vres="";
		    $vsql="SELECT fdownline  from tb_updown where fupline='$pID'  ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $pOut[]=$oDB->f("fdownline");
			}  
		}
*/
        //Downline langsung dibawahnya
		function getDownline($pID) {
            global $oDB;
			$vres="";
		    $vsql="SELECT fdownline  from tb_updown where fupline='$pID'  ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres[]=$oDB->f("fdownline");
			}  
			return $vres;
		}

        //Downline langsung dibawahnya
		function getDirectSponTPoint($pID) {
            global $oDB;
			$vres="";
		    $vsql="SELECT fdownline  from tb_updown where fsponsor='$pID' and fdownline in (select fidmember from tb_penjualan where month(ftanggal)=month(now()) and year(ftanggal)=year(now())) ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres[]=$oDB->f("fdownline");
			}  
			return $vres;
		}


				//Cek ada bawahan/tidak
		 function hasDownline($pId) {
				 global $oDB;
				 $vsql="select fdownline from tb_updown where fupline='$pId'";	
				 $oDB->query($vsql);		
				 if ($oDB->num_rows() > 0 ) 
				   return 1;
				 else
				   return 0;   
						 
		}	
		
				//Cek ada bawahan/tidak di kiri apa kanan
		 function hasDownlineLR($pId,$pPos) {
				 global $oDB;
				 $vsql="select fdownline from tb_updown where fupline='$pId' and fposisi='$pPos'";	
				 $oDB->query($vsql);		
				 if ($oDB->num_rows() > 0 ) 
				   return 1;
				 else
				   return 0;   
						 
		}			
			
                //Punya sponsorship
		 function hasSponsorship($pId) {
				 global $oDB;
				 $vsql="select fdownline from tb_updown where fsponsor='$pId'";	
				 $oDB->query($vsql);		
				 if ($oDB->num_rows() > 0 ) 
				   return 1;
				 else
				   return 0;   
						 
		}		

                //Punya sponsorship Bulan Tahun
		 function hasSponsorshipMonth($pId,$pThBl) {
				 global $oDB;
				 $vsql="select fdownline from tb_updown where fsponsor='$pId' and date_format(ftanggal,'%Y%m')='$pThBl' ";	
				 $oDB->query($vsql);		
				 if ($oDB->num_rows() > 0 ) 
				   return 1;
				 else
				   return 0;   
						 
		}		

               //Punya pairing  Bulan Tahun
		 function hasPairingMonth($pId,$pThBl) {
				 global $oDB;
				 $vsql="select fidreceiver from tb_kom_couple where fidreceiver ='$pId' and date_format(ftanggal,'%Y%m')='$pThBl' ";	
				 $oDB->query($vsql);		
				 if ($oDB->num_rows() > 0 ) 
				   return 1;
				 else
				   return 0;   
						 
		}		



                //Punya sponsorship
		 function hasSponsorshipLR($pId) {
				 global $oDB;
				 $vHasL='0'; $vHasR='0'; 
				  $vDownL=$this->getDownLR($pId,'L');
				 if ($vDownL != '' && $vDownL != -1) {
					 
					if ($this->getSponsor($vDownL)==$pId) {
					   $vHasL='1';
					//   echo "Punya Kiri L1:".$vDownL.":";
					} else {
					   $vDownAllL=$this->getDownlineAll($vDownL,$vArrOut);	
					   while (list($key,$val)=@each($vArrOut)) {
						   $vSpon=$this->getSponsor($val);
						   if ($vSpon==$pId) {
							   $vHasL='1';
						//	   echo "Punya Kiri LX:".$val.":";
							   break;
						   }
					   }
					}
				 } else $vHasL='0'; 
				 
				 $vDownR=$this->getDownLR($pId,'R');
				 if ($vDownR != '' && $vDownR != -1) {
					 
					if ($this->getSponsor($vDownR)==$pId) {
					   $vHasR='1';
					//   echo ":Punya Kanan L1:".$vDownR.":";
					} else {
					   $vDownAllR=$this->getDownlineAll($vDownR,$vArrOut);	
					   while (list($key,$val)=each($vArrOut)) {
						   $vSpon=$this->getSponsor($val);
						   if ($vSpon==$pId) {
							   $vHasR='1';
							//   echo "Punya Kanan LX:".$val.":";
							   break;
						   }
					   }
					}
				 } else $vHasR='0';


				
				 if ($vHasL=='1' && $vHasR=='1' ) 
				   return 1;
				 else
				   return 0;   
						 
		}	                

             //get 1st sponsorship
		 function get1stSponsorshipLR($pId,$pLR) {
				 global $oDB;
				 $vHasL='0'; $vHasR='0'; $vSpon='';
				 
				 if ($pLR=='L')  {
					 $vDownL=$this->getDownLR($pId,'L');
					 if ($vDownL != '' && $vDownL  != -1) {
						if ($this->getSponsor($vDownL)==$pId) {
						   $vHasL='1';
						 $vSpon = $vDownL;
						   
						   //   echo "Punya Kiri L1:".$vDownL.":";
						} else {
						   $vSQL="select fdownline from tb_updown where fsponsor='$pId' order by fsponsorke";
						   $oDB->query($vSQL);
						   while ($oDB->next_record()) {
							  $vSponX=$oDB->f('fdownline');
							  if ($this->isInNetwork($vSponX,$vDownL) == 1) {
								$vSpon = $vSponX;
								 break; 
							  }
						   }
						}
					 } 
				 } else { //LR
				     
				$vDownR=$this->getDownLR($pId,'R');
					 if ($vDownR != '' && $vDownR  != -1) {
						 
						if ($this->getSponsor($vDownR)==$pId) {
						   $vHasR='1';
						   $vSpon = $vDownR;
						  // echo ":Kanan 1:".$vDownR.":";
						} else {
						 // echo $vDownR;
						 $vSQL="select fdownline from tb_updown where fsponsor='$pId' order by fsponsorke";
						   $oDB->query($vSQL);
						   while ($oDB->next_record()) {
							$vSponX=$oDB->f('fdownline');
							 $this->isInNetwork($vSponX,$vDownR);
							  if ($this->isInNetwork($vSponX,$vDownR) == 1) {
								 $vSpon = $vSponX;
								 break; 
							  }
						   }
	
						}
					 } 
				 }//LR

				   return $vSpon;
						 
		}

				//Cek pernah belanja
		 function hasBuy($pId) {
				 global $oDB;
				 $vres=0;
				 $vsql="select fidmember from tb_penjualan where fidmember='$pId'";	
				 $oDB->query($vsql);		
				 $vres+=$oDB->num_rows();
				 $vsql="select fidmember from tb_withdraw_pulsa where fidmember='$pId'";	
				 $oDB->query($vsql);		
				 $vres+=$oDB->num_rows();
				 if ($vres > 0 ) 
				   return 1;
				 else
				   return 0;   
						 
		}		


		
		//Jumlah Downline (All)
		function getDownlineCount($pID) {
			$vcount=0;
			if ($this->hasDownline($pID)==1) {
				$vsql="select fdownline from tb_updown where fupline='$pID'";	
				$vres=mysql_query($vsql);
				while ($rsDownline = mysql_fetch_array($vres)) {
				  $vdown = $rsDownline['fdownline'];
				  $vcountdown=$this->getDownlineCount($vdown);
				  $vcount+=1;
				  if ($vcountdown > 0) 
					 $vcount+=$vcountdown;
				}
			}//hasdownline
			   return $vcount;   
		
		}

		//Jumlah Downline (All) GP
		function getDownlineCountGP($pID) {
			global $oMember;
			$vcount=0;
			if ($this->hasDownline($pID)==1) {
				$vsql="select fdownline from tb_updown where fupline='$pID'";	
				$vres=mysql_query($vsql);
				while ($rsDownline = mysql_fetch_array($vres)) {
				  $vdown = $rsDownline['fdownline'];
				  $vcountdown=$this->getDownlineCountGP($vdown);
				  if ($oMember->getPaketID($vdown)=="G" || $oMember->getPaketID($vdown)=="P")
				  $vcount+=1;
				  if ($vcountdown > 0) 
					 $vcount+=$vcountdown;
				}
			}//hasdownline
			   return $vcount;   
		
		}


		//Jumlah Downline (All) P
		function getDownlineCountP($pID) {
			global $oMember;
			$vcount=0;
			if ($this->hasDownline($pID)==1) {
				$vsql="select fdownline from tb_updown where fupline='$pID'";	
				//echo "<br>";
				$vres=mysql_query($vsql);
				while ($rsDownline = mysql_fetch_array($vres)) {
				  $vdown = $rsDownline['fdownline'];
				  $vcountdown=$this->getDownlineCountP($vdown);
				  if ($oMember->getPaketID($vdown)=="P")
				     $vcount+=1;
				  if ($vcountdown > 0) 
					 $vcount+=$vcountdown;
				}
			}//hasdownline
			   return $vcount;   
		
		}
		
		
		//Jumlah Downline (All) Sesuai Peringkat
		function getDownlineCountCareer($pID,$pCareer) {
			global $oMember;
			$vArrCangkok=$this->getArrayCangkok();
			$vcount=0;
			if ($this->hasDownline($pID)==1) {
				$vsql="select fdownline from tb_updown where fupline='$pID'";	
				$vres=mysql_query($vsql);
				while ($rsDownline = mysql_fetch_array($vres)) {
				  $vdown = $rsDownline['fdownline'];
				  $vcountdown=$this->getDownlineCountCareer($vdown,$pCareer);
				  
				  if ($oMember->getMemField('flevel',$vdown)==$pCareer && !in_array($vdown,$vArrCangkok))
				  $vcount+=1;
				  
				  if ($vcountdown > 0) 
					 $vcount+=$vcountdown;
				}
			}//hasdownline
			   return $vcount;   
		
		}

		//Jumlah Downline by Date (All)
		function getDownlineCountByDate($pID,$pDate) {
			global $oMember;
			$vcount=0;
			if ($this->hasDownline($pID)==1) {
				$vsql="select fdownline from tb_updown where fupline='$pID' ";	
				$vres=mysql_query($vsql);
				while ($rsDownline = mysql_fetch_array($vres)) {
				  $vdown = $rsDownline['fdownline'];
				  $vDate=$oMember->getActivationDate($vdown);
				  $vcountdown=$this->getDownlineCountByDate($vdown,$pDate);
				  if (preg_match("/".$pDate."/",$vDate))
				  $vcount+=1;
				  if ($vcountdown > 0) 
					 $vcount+=$vcountdown;
				}
			}//has downline
			   return $vcount;   
		
		}



		//Jumlah Downline by Premium (All)
		function getDownlineCountByPrem($pID) {
			global $oMember;
			$vcount=0;
			if ($this->hasDownline($pID)==1) {
				$vsql="select fdownline from tb_updown where fupline='$pID' ";	
				$vres=mysql_query($vsql);
				while ($rsDownline = mysql_fetch_array($vres)) {
				  $vdown = $rsDownline['fdownline'];
				  $vcountdown=$this->getDownlineCountByPrem($vdown);
				  if ($oMember->isPremium($vdown)==1) //Prem
				  $vcount+=1;
				  if ($vcountdown > 0) 
					 $vcount+=$vcountdown;
				}
			}//has downline
			   return $vcount;   
		
		}


		//Jumlah Downline by Date range (All)
		function getDownlineCountByDateRange($pID,$pDate,$pDateTo) {
			global $oMember;
			$vcount=0;
			if ($this->hasDownline($pID)==1) {
				$vsql="select fdownline from tb_updown where fupline='$pID' ";	
				$vres=mysql_query($vsql);
				while ($rsDownline = mysql_fetch_array($vres)) {
				  $vdown = $rsDownline['fdownline'];
				  $vDate=$oMember->getActivationDate($vdown);
				  $vprem=$oMember->isPremium($vdown);
				  $vcountdown=$this->getDownlineCountByDateRange($vdown,$pDate,$pDateTo);
				  if ($vDate>=$pDate && $vDate<=$pDateTo && $vprem==0)
				  $vcount+=1;
				  if ($vcountdown > 0) 
					 $vcount+=$vcountdown;
				}
			} //hasdownline
			   return $vcount;   
		
		}


		//Jumlah Downline by Date range (All) Prem
		function getDownlineCountByDateRangePrem($pID,$pDate,$pDateTo) {
			global $oMember;
			$vcount=0;
			if ($this->hasDownline($pID)==1) {
				$vsql="select fdownline from tb_updown where fupline='$pID' ";	
				$vres=mysql_query($vsql);
				while ($rsDownline = mysql_fetch_array($vres)) {
				  $vdown = $rsDownline['fdownline'];
				  $vDate=$oMember->getUpgradeDate($vdown);
				  $vprem=$oMember->isPremium($vdown);
				  $vcountdown=$this->getDownlineCountByDateRangePrem($vdown,$pDate,$pDateTo);
				  if ($vDate>=$pDate && $vDate<=$pDateTo && $vprem==1)
				  $vcount+=1;
				  if ($vcountdown > 0) 
					 $vcount+=$vcountdown;
				}
			} //hasdownline
			   return $vcount;   
		
		}



		//Jumlah Downline Kiri/kanan(All)
		function getDownlineCountLR($pID,$pPos) {
			$vCount=0;
			$vDownLR=$this->getDownLR($pID,$pPos);
			
			$vCount=$this->getDownlineCount($vDownLR);
			if ($vDownLR !=-1)
			   return $vCount+1;   
			else 
			   return 0;   
		
		}

		//Jumlah Downline Kiri/kanan(Level)
		function getDownlineCountLRLevel($pID,$pPos,$pLevel) {
			
			$vCount=0; $vLevel=0;
			 $vDownLR=$this->getDownLR($pID,$pPos);
			
			if ($pLevel==1) {
			   $vLevel=$pLevel;
			   $vDown=$pID;
			} else if ($pLevel > 1) {   
			   $vLevel=$pLevel-1;
			   $vDown=$vDownLR;
			}
			
			  $vCount=$this->getDownlineCountLevel($vDown,$vLevel);
			if ($vDownLR !=-1)
			   return $vCount;   
			else 
			   return 0;   
		
		}


		//Jumlah Downline Kiri/kanan(All)
		function getDownlineCountLRGP($pID,$pPos) {
			$vCount=0;
			$vDownLR=$this->getDownLRGP($pID,$pPos);
			
			$vCount=$this->getDownlineCountGP($vDownLR);
			if ($vDownLR !=-1)
			   return $vCount+1;   
			else 
			   return 0;   
		
		}

		//Jumlah Downline Kiri/kanan(All) P
		function getDownlineCountLRP($pID,$pPos) {
			global $oMember;
			$vCount=0;
			$vDownLR=$this->getDownLRP($pID,$pPos);
			
			$vCount=$this->getDownlineCountP($vDownLR);
			
			if ($vDownLR !=-1) {
			   $vPaket=$oMember->getPaketID($vDownLR);
			   if ($vPaket=='P')
			      return $vCount+1;   
			   else return $vCount;	  
			} else 
			   return 0;   
		
		}

		//Jumlah Downline Kiri/kanan(All by date)
		function getDownlineCountLRByDate($pID,$pPos,$pDate) {
			$vCount=0;
			$vDownLR=$this->getDownLR($pID,$pPos);
			$vDownLRDate=$this->getDownLRByDate($pID,$pPos,$pDate);	
			$vCount=$this->getDownlineCountByDate($vDownLR,$pDate);
			if ($vDownLRDate!=-1)
			   return $vCount+1;   
			else 
			   return $vCount;  
		}




		//Jumlah Downline Kiri/kanan(All by range date)
		function getDownlineCountLRByDateRange($pID,$pPos,$pDate,$pDateTo) {
			$vCount=0;
			$vDownLR=$this->getDownLR($pID,$pPos);
			$vDownLRDate=$this->getDownLRByDateRange($pID,$pPos,$pDate,$pDateTo);	
			$vCount=$this->getDownlineCountByDateRange($vDownLR,$pDate,$pDateTo);
			if ($vDownLRDate!=-1)
			   return $vCount+1;   
			else 
			   return $vCount;  
		}


		//Jumlah Downline Kiri/kanan(All by range date) Premium
		function getDownlineCountLRByDateRangePrem($pID,$pPos,$pDate,$pDateTo) {
			$vCount=0;
			$vDownLR=$this->getDownLR($pID,$pPos);
			$vDownLRDate=$this->getDownLRByDateRangePrem($pID,$pPos,$pDate,$pDateTo);	
			$vCount=$this->getDownlineCountByDateRangePrem($vDownLR,$pDate,$pDateTo);
			if ($vDownLRDate!=-1)
			   return $vCount+1;   
			else 
			   return $vCount;  
		}



		
        //Hitung jumlah pasangan
        function getCountCouple($pID) {
		    $vLDown=$this->getDownlineCountLR($pID,"L");
		    $vRDown=$this->getDownlineCountLR($pID,"R");
		   
		   if ($vLDown < $vRDown)
		      $vres=$vLDown;
		   else if ($vLDown == $vRDown) 	  
		      $vres=$vLDown;
		   else if ($vLDown > $vRDown) 	  	  
		      $vres=$vRDown;
		   return $vres;	  
		}


        //Hitung jumlah pasangan Gold Platinum
        function getCountCoupleGP($pID) {
		    $vLDown=$this->getDownlineCountLRGP($pID,"L");
		    $vRDown=$this->getDownlineCountLRGP($pID,"R");
		   
		   if ($vLDown < $vRDown)
		      $vres=$vLDown;
		   else if ($vLDown == $vRDown) 	  
		      $vres=$vLDown;
		   else if ($vLDown > $vRDown) 	  	  
		      $vres=$vRDown;
		   return $vres;	  
		}


        //Hitung jumlah pasangan Premium
        function getCountCoupleP($pID) {
		     $vLDown=$this->getDownlineCountLRP($pID,"L");
		     $vRDown=$this->getDownlineCountLRP($pID,"R");
		   
		   if ($vLDown < $vRDown)
		      $vres=$vLDown;
		   else if ($vLDown == $vRDown) 	  
		      $vres=$vLDown;
		   else if ($vLDown > $vRDown) 	  	  
		      $vres=$vRDown;
		   return $vres;	  
		}


        //Hitung jumlah pasangan dengan tanggal
        function getCountCoupleByDate($pID,$pDate) {
		    $vLDown=$this->getDownlineCountLRByDate($pID,"L",$pDate);
		    $vRDown=$this->getDownlineCountLRByDate($pID,"R",$pDate);
		   
		   if ($vLDown < $vRDown)
		      $vres=$vLDown;
		   else if ($vLDown == $vRDown) 	  
		      $vres=$vLDown;
		   else if ($vLDown > $vRDown) 	  	  
		      $vres=$vRDown;
		   return $vres;	  
		}

		//Jumlah Downline (Alternative)
		function getDownlineCountTPoint($pID) {
			$vcount=0;
			$vsql="select fdownline from tb_updown where fupline='$pID' and fdownline in (select fidmember from tb_penjualan where month(ftanggal)=month(now()) and year(ftanggal)=year(now()))";	
			$vres=mysql_query($vsql);
			while ($rsDownline = mysql_fetch_array($vres)) {
			  $vdown = $rsDownline['fdownline'];
			  $vcountdown=$this->getDownlineCountTPoint($vdown);
			  $vcount+=1;
			  if ($vcountdown > 0) 
				 $vcount+=$vcountdown;
			}
			   return $vcount;   
		
		}


		//Jumlah Downline (Active)
		function getDownlineCountActive($pID) {
			$vcount=0;
			$vsql="select fdownline from tb_updown where fupline='$pID' and fdownline in (select fidmember from m_anggota where faktif=1)";	
			$vres=mysql_query($vsql);
			while ($rsDownline = mysql_fetch_array($vres)) {
			  $vdown = $rsDownline['fdownline'];
			  $vcountdown=$this->getDownlineCountActive($vdown);
			  $vcount+=1;
			  
			  if (($vcountdown > 0)) 
				 $vcount+=$vcountdown;
			}
			   return $vcount;   
		
		}


		//Jumlah Downline (Active Limikted)
		function getDownlineCountActiveLimited($pID,$pFixID) {
			$this->getDownlineAllActiveLimited($pID,$pFixID,$vOut);
			$vCount=count($vOut);
			return $vCount;
				
		}





		//Hitung Downline Semua
		function getDownlineAll($pID,&$vout) {
			$vcount=0;
			$vsql="select fdownline from tb_updown where fupline='$pID'";	
			$vres=mysql_query($vsql);
			while ($rsDownline = mysql_fetch_array($vres)) {
			 $vcount+=1;
			 $vdown = $rsDownline['fdownline'];		 
			 $vout[]=$vdown;
			 $vdown=$this->getDownlineAll($vdown,$vout);	  
			}
			   return $vdown;   
		}


		//Hitung Downline by Paket   Period
		function getDownlineByPaket($pID,&$vout,$pStart,$pEnd,$pPaket) {
			global $oMember;
			$vcount=0;

			$vsql="select fdownline from tb_updown where fupline='$pID' ";
			//and (ftanggal between '$pStart 00:00:00' and '$pEnd 23:59:59') ";	
			$vres=mysql_query($vsql);
			while ($rsDownline = mysql_fetch_array($vres)) {
			 $vcount+=1;
			 $vdown = $rsDownline['fdownline'];	
			// echo $oMember->getPaketID($vdown);	 
			 $vTglDown=$oMember->getActivationDate($vdown);
			
			if ($oMember->getPaketID($vdown)==$pPaket && $vTglDown>="$pStart 00:00:00" && $vTglDown<="$pEnd 23:59:59") {
			   $vout[]=$vdown;
			}
			 $vdown=$this->getDownlineByPaket($vdown,$vout,$pStart,$pEnd,$pPaket);	  
			}
			   return $vdown;   
		}


		//Hitung Downline Semua
		function getDownlineAllTPoint($pID,&$vout) {
			$vcount=0;
			$vsql="select fdownline from tb_updown where fupline='$pID' and fdownline in (select fidmember from tb_penjualan where month(ftanggal)=month(now()) and year(ftanggal)=year(now()))";	
			$vres=mysql_query($vsql);
			while ($rsDownline = mysql_fetch_array($vres)) {
			 $vcount+=1;
			 $vdown = $rsDownline['fdownline'];		 
			 $vout[]=$vdown;
			 $vdown=$this->getDownlineAllTPoint($vdown,$vout);	  
			}
			   return $vdown;   
		}


		//Hitung Downline Limited
		function getDownlineLimited($pID,&$vout,$pFixID) {
			$vcount=0;
			 $vsql="select fdownline from tb_updown where fupline='$pID'";	
			$vres=mysql_query($vsql);
			while ($rsDownline = mysql_fetch_array($vres)) {
			 $vcount+=1;
			 $vdown = $rsDownline['fdownline'];		 
			 if ($this->getDistance($vdown,$pFixID) < 8)
			   $vout[]=$vdown;
			 $vdown=$this->getDownlineLimited($vdown,$vout,$pFixID);	  
			}
			   return $vdown;   
		}



		//Hitung Downline Semua yg aktif
		function getDownlineAllActive($pID,&$vout) {
			global $oMember;
			$vcount=0;
			$vsql="select fdownline from tb_updown where fupline='$pID'  ";	
			$vres=mysql_query($vsql);
			while ($rsDownline = mysql_fetch_array($vres)) {
			 $vcount+=1;
			  $vdown = $rsDownline['fdownline'];		
			  $this->getDistance($vdown,$pID); 
			 if (($oMember->isFullActive($vdown)==1) )
			    $vout[]=$vdown;
			 $vdown=$this->getDownlineAllActive($vdown,$vout);	  
			}
			   return $vdown;   
		}

		//Hitung Downline Semua yg aktif Period
		function getDownlineAllActivePeriod($pID,&$vout,$pStart,$pEnd) {
			global $oMember, $conn;
			
			$vcount=0;
			// $vsql="select fdownline from tb_updown where fupline='$pID' and (ftanggal between '$pStart 00:00:00' and '$pEnd 23:59:59') ";	
			 $vsql="select fdownline from tb_updown where fupline='$pID'  ";	
			 $vres=mysql_query($vsql,$conn);
			while ($rsDownline = mysql_fetch_array($vres)) {
			 
			 $vcount+=1;
			  $vdown = $rsDownline['fdownline'];		
			 // $this->getDistance($vdown,$pID); 
			
			 if ($oMember->getActivationDateOnly($vdown) >= $pStart && $oMember->getActivationDateOnly($vdown) <= $pEnd) {
			//  if ('2017-11-16' >= $pStart && '2017-11-16' <= $pEnd) {
			     $vout[]=$vdown;
				
				
			 }
			 
			 //print_r($vout);
			 $vdown=$this->getDownlineAllActivePeriod($vdown,$vout,$pStart,$pEnd);	  
			}
			
		//echo $vdown;
			   return $vdown;   
		}








		//Hitung Downline Semua yg aktif level terbatas
		function getDownlineAllActiveLimited($pID,$pFixID,&$vout) {
			global $oMember,$oRules;
			$vMaxLevel=$oRules->getRealMaxLevel(1);
			$vcount=0;
			$vsql="select fdownline from tb_updown where fupline='$pID' ";
			$vres=mysql_query($vsql);
			while ($rsDownline = mysql_fetch_array($vres)) {
			 $vcount+=1;
			  $vdown = $rsDownline['fdownline'];		
			  $this->getDistance($vdown,$pID); 
			 if (($oMember->isFullActive($vdown)==1) && $this->getDistance($vdown,$pFixID) <= $vMaxLevel)
			    $vout[]=$vdown;
			 $vdown=$this->getDownlineAllActiveLimited($vdown,$pFixID,$vout);	  
			}
			   return $vdown;   
		}


// Jumlah Downline level tertentu
		function getDownlineCountLevel($pID,$pLevel) {
			global $oMember;
		    $this->getDownlineAll($pID,$vout);
			
			if (strlen($vout[0])>=1)
			   $vcout=count($vout);
			else
			   $vcout=0;  
			for ($i=0;$i<$vcout;$i++) {
	   			$vdistance= $this->getDistance($vout[$i],$pID);
	   			if ($vdistance==$pLevel) {
	      			$vjumlevel[]=$vout[$i];
	   			}
			}
			
			
			$vCountBobot=0;
			while(list($key,$val)=@each($vjumlevel)) {
				 $vPaket=$oMember->getPaketID($val);
				if ($vPaket=='S' || $vPaket=='E')
				   $vBobot=1;
				else if ($vPaket=='G' || $vPaket=='B')  
				   $vBobot=3;
				else if ($vPaket=='F' || $vPaket=='P')  
				   $vBobot=7;
				
				 $vCountBobot+=$vBobot;
			}
			return $vCountBobot;
		}
		

// Jumlah Downline level tertentu Lama
		function getDownlineCountLevel_Lama($pID,$pLevel) {
		    $this->getDownlineAll($pID,$vout);
			if (strlen($vout[0])>=1)
			   $vcout=count($vout);
			else
			   $vcout=0;  
			for ($i=0;$i<$vcout;$i++) {
	   			$vdistance= $this->getDistance($vout[$i],$pID);
	   			if ($vdistance==$pLevel) {
	      			$vjumlevel[]=$vout[$i];
	   			}
			}
			return count($vjumlevel);
		}		
		


//  Downline level tertentu
		function getDownlineLevel($pID,$pLevel) {
		    $this->getDownlineAll($pID,$vout);
			if (strlen($vout[0])>=1)
			   $vcout=count($vout);
			else
			   $vcout=0;  
			for ($i=0;$i<$vcout;$i++) {
	   			$vdistance= $this->getDistance($vout[$i],$pID);
	   			if ($vdistance==$pLevel) {
	      			$vjumlevel[]=$vout[$i];
	   			}
			}
			return $vjumlevel;
		}




//  Downline First, level tertentu posisi kiri / kanan
		function getFirstDownLevelPos($pID,$pLevel,$pPos) {
			global $oMember,$oSystem;
			$vArr="";$vArr2="";$vRet="";
			$vFirstDown=$this->getDownLR($pID,$pPos);
		    $this->getDownlineAll($vFirstDown,$vout);
			if (strlen($vout[0])>=1)
			   $vcout=count($vout);
			else
			   $vcout=0;  
			for ($i=0;$i<$vcout;$i++) {
	   			$vdistance= $this->getDistance($vout[$i],$vFirstDown);
	   			if ($vdistance==($pLevel-1)) {
	      			$vjumlevel[]=$vout[$i];
	   			}
			}
			
			if ($pLevel > 1)
			    $vArr=$vjumlevel;
			else $vArr=array($vFirstDown);	
			$vArr2="";
			while (list($key,$val) = each($vArr)) {
			    $vSys=$oMember->getIdSys($val);	
				
				if (!$oMember->isCoupledLevel($val,$pLevel))
				   $vArr2[]=$vSys.'|'.$val;		
			
			}
			//print_r($vArr2);
			if (is_array($vArr2)) 
			   sort($vArr2);
			$vCanRet=explode('|',$vArr2[0]);		
			return $vCanRet[1];
			//return $vArr2;

		}


//  Downline First,  kiri / kanan
		function getFirstDownPos($pID,$pPos,$pLevel) {
			global $oMember,$oSystem;
			$vArr="";$vArr2="";$vRet="";
			$vFirstDown=$this->getDownLR($pID,$pPos);
		    $this->getDownlineAll($vFirstDown,$vout);
			if (strlen($vout[0])>=1)
			   $vcout=count($vout);
			else
			   $vcout=0;  
			for ($i=0;$i<$vcout;$i++) {	   			
	      			$vjumlevel[]=$vout[$i];
			}
			
			if ($vcout > 0)
			    $vArr=$vjumlevel;
			else $vArr=array($vFirstDown);	
			
			$vArr[]=$vFirstDown;
			$vArr=array_unique($vArr);
			
			
			$vArr2="";
			while (list($key,$val) = each($vArr)) {
			    $vSys=$oMember->getIdSys($val);	
				
				if (!$oMember->isCoupledLevel($val,$pLevel))
				   $vArr2[]=$vSys.'|'.$val;		
			
			}
			//print_r($vArr2);
			if (is_array($vArr2)) 
			   sort($vArr2);
			
			$vCanRet=explode('|',$vArr2[0]);		
			return $vCanRet[1];
			

		}




//  Downline level tertentu yg tutup Point
		function getDownlineLevelTPoint($pID,$pLevel) {
		    $this->getDownlineAllTPoint($pID,$vout);
			if (strlen($vout[0])>=1)
			   $vcout=count($vout);
			else
			   $vcout=0;  
			for ($i=0;$i<$vcout;$i++) {
	   			$vdistance= $this->getDistance($vout[$i],$pID);
	   			if ($vdistance==$pLevel) {
	      			$vjumlevel[]=$vout[$i];
	   			}
			}
			return $vjumlevel;
		}



// Jumlah Downline level tertentu yg Aktif
		function getDownlineCountLevelActive($pID,$pLevel) {
		    $this->getDownlineAllActive($pID,$vout);
			if (strlen($vout[0])>=3)
			   $vcout=count($vout);
			else
			   $vcout=0;  
			for ($i=0;$i<$vcout;$i++) {
	   			$vdistance= $this->getDistance($vout[$i],$pID);
	   			if ($vdistance==$pLevel) {
	      			$vjumlevel[]=$vout[$i];
	   			}
			}
			return count($vjumlevel);
		}


// Jumlah Downline level tertentu yg Aktif Periode
		function getDownlineCountLevelActivePeriod($pID,$pLevel,$pStart,$pEnd) {
		    $this->getDownlineAllActivePeriod($pID,$vout,$pStart,$pEnd);
			
			if (strlen($vout[0])>=3)
			   $vcout=count($vout);
			else
			   $vcout=0;  
			for ($i=0;$i<$vcout;$i++) {
	   			$vdistance= $this->getDistance($vout[$i],$pID);
	   			if ($vdistance==$pLevel) {
	      			$vjumlevel[]=$vout[$i];
	   			}
			}
			return count($vjumlevel);
		}

// Jumlah Downline  yg Aktif Periode tanpa level
		function getDownlineCountActivePeriod($pID,$pStart,$pEnd) {
			global $oMember, $oPhpdate;
		    $this->getDownlineAllActivePeriod($pID,$vout,$pStart,$pEnd);
			
			if (strlen($vout[0])>=1)
			   $vcout=count($vout);
			else
			   $vcout=0;  
			  // echo "aaaaaaaaaa".$vcout;
			   
			for ($i=0;$i<$vcout;$i++) {
	   			
	   		//	echo "sssssssss";
	      			$vjumlevel[]=$vout[$i];
	   			
			}
			
			
			$vCountBobot=0;
			while(list($key,$val)=@each($vjumlevel)) {
				$vBobot=1;
				/* $vPaket=$oMember->getPaketID($val);
				
				if ($vPaket=='S' || $vPaket=='E')
				   $vBobot=1;
				else if ($vPaket=='G' || $vPaket=='B')  
				   $vBobot=3;
				else if ($vPaket=='F' || $vPaket=='P')  
				   $vBobot=7;
			*/	
				 $vCountBobot+=$vBobot;
			}
			 
			 $vActSelf=substr($oMember->getActivationDate($pID),0,10);
			 if ($vActSelf >= $pStart && $vActSelf <= $pEnd) {
				  $vBobotSelf=1;
				 
				/* $vPaketSelf=$oMember->getPaketID($pID);
	
				if ($vPaketSelf=='S' || $vPaketSelf=='E')
				   $vBobotSelf=1;
				else if ($vPaketSelf=='G' || $vPaketSelf=='B')  
				   $vBobotSelf=3;
				else if ($vPaketSelf=='F' || $vPaketSelf=='P')  
				   $vBobotSelf=7;*/
			   
			 }
			 
			
			return $vCountBobot+$vBobotSelf;
		}


// Jumlah Downline  yg Aktif Periode tanpa level untuk peringkat
		function getDownlineCountActivePeriodPeringkat($pID,$pStart,$pEnd) {
			global $oMember, $oPhpdate;
		    $this->getDownlineAllActivePeriod($pID,$vout,$pStart,$pEnd);
			
			if (strlen($vout[0])>=1)
			   $vcout=count($vout);
			else
			   $vcout=0;  
			  // echo "aaaaaaaaaa".$vcout;
			   
			for ($i=0;$i<$vcout;$i++) {
	   			
	   		//	echo "sssssssss";
	      			$vjumlevel[]=$vout[$i];
	   			
			}
			
			$vArrCangkok=$this->getArrayCangkok();
			$vCountBobot=0;
			while(list($key,$val)=@each($vjumlevel)) {
				$vPaket=$oMember->getPaketID($val);
				
				if (!in_array($val,$vArrCangkok)) {
					if ($vPaket=='S' || $vPaket=='E')
					   $vBobot=1;
					else if ($vPaket=='G' || $vPaket=='B')  
					   $vBobot=3;
					else if ($vPaket=='F' || $vPaket=='P')  
					   $vBobot=7;
				} else $vBobot=0;
				
				 $vCountBobot+=$vBobot;
			}
			 
			 $vActSelf=substr($oMember->getActivationDate($pID),0,10);
			 if ($vActSelf >= $pStart && $vActSelf <= $pEnd) {
				 $vPaketSelf=$oMember->getPaketID($pID);
				 if (!in_array($pID,$vArrCangkok)) {
					if ($vPaketSelf=='S' || $vPaketSelf=='E')
					   $vBobotSelf=1;
					else if ($vPaketSelf=='G' || $vPaketSelf=='B')  
					   $vBobotSelf=3;
					else if ($vPaketSelf=='F' || $vPaketSelf=='P')  
					   $vBobotSelf=7;
				 } else $vBobotSelf=0;
			 }
			 
			
			return $vCountBobot+$vBobotSelf;
		}

    //Downline Level Tertentu
		function getDownlineLevel_Deprecated($pID,$pLevel,&$pJumlevel) {
		    $this->getDownlineAll($pID,$vout);
			$vcout=count($vout);
			for ($i=0;$i<$vcout;$i++) {
	   			$vdistance= $this->getDistance($vout[$i],$pID);
	   			if ($vdistance==$pLevel) {
	      			$pJumlevel[]=$vout[$i];
	   			}
			}
			
		}

    //Downline Level Tertentu yg Aktif saja
		function getDownlineLevelActive($pID,$pLevel,&$pJumlevel) {
		    $this->getDownlineAllActive($pID,$vout);
			$vcout=count($vout);
			for ($i=0;$i<$vcout;$i++) {
	   			$vdistance= $this->getDistance($vout[$i],$pID);
	   			if ($vdistance==$pLevel) {
	      			$pJumlevel[]=$vout[$i];
	   			}
			}
			
		}



		//Get kedalaman upline
  	    function getDistance($pID,$pUpline) {
			$vdeep=1;
   			$vres=$this->getUpline($pID);			
			while (strtolower($vres)!=strtolower($pUpline)) {			
				$vres=$this->getUpline($vres);
				$vdeep+=1;	
			}
		   return $vdeep;
		}		

       //Ambil Sponsorship
  	    function getSponsorship($pID, &$pOut) {
		   global $oDB;
		   $vsql="select fdownline from tb_updown where fsponsor='$pID' and fsponsorstatus='1'";
		   $oDB->query($vsql);
		   while ($oDB->next_record()) {
		      $pOut[]=$oDB->f('fdownline');
		   }
		   return $pOut;
		}		

                
       //Ambil Sponsorship versi baru
  	    function getReferral($pID) {
		   global $oDB;
		   $vsql="select fdownline from tb_updown where fsponsor='$pID' and fsponsorstatus='1'";
		   $oDB->query($vsql);
		   $vOut="";
                   while ($oDB->next_record()) {
		      $vOut[]=$oDB->f('fdownline');
		   }
		   return $vOut;
		}		
 
     //Ambil Sponsorship versi baru dengan periode
  	    function getReferralPeriod($pID,$pStart,$pEnd) {
		   global $oDB;
		   $vsql="select fdownline from tb_updown where fsponsor='$pID' and ftanggal between '$pStart' and '$pEnd' and fsponsorstatus='1'";
		   $oDB->query($vsql);
		   $vOut="";
                   while ($oDB->next_record()) {
		      $vOut[]=$oDB->f('fdownline');
		   }
		   return $vOut;
		}	               
                


     //Ambil Sponsorship bobot dengan periode
  	    function getBobot($pID) {
		   global $oDB;
		   $vsql="select fpaket from m_anggota where fidmember='$pID' ";
		   $oDB->query($vsql);
		   $vOut="";
           while ($oDB->next_record()) {
		      $vPaket=$oDB->f('fpaket');
		      if ($vPaket=='S')
		         $vOut=1;
		      else  if ($vPaket=='G')  
		         $vOut=3;
		      else  if ($vPaket=='P')  
		         $vOut=7;

		         
		   }
		   
		   return $vOut;

		}	               
                



       //Ambil Jumlah Sponsorship
  	    function getSponsorshipCount($pID) {
		   global $oDB;
		   $vsql="select count(fdownline) as fcountspon from tb_updown where fsponsor='$pID' and fsponsorstatus='1'";
		   $oDB->query($vsql);
		   while ($oDB->next_record()) {
		      $vres=$oDB->f('fcountspon');
		   }
		   return $vres;
		}		


       //Ambil Jumlah Presentership
  	    function getPresCount($pID) {
		   global $oDB;
		   $vsql="select count(fdownline) as fcount from tb_updown where fpresenter='$pID' ";
		   $oDB->query($vsql);
		   while ($oDB->next_record()) {
		      $vres=$oDB->f('fcount');
		   }
		   return $vres;
		}		

       //Ambil Jumlah Sponsorship berdasarkan paket
  	    function getSponsorshipCountPack($pID,$pPack,$pFrom='1981-01-01',$pTo='1981-01-01') {
		   global $oDB, $oMember,$dbin;
		   $vsql="select * from tb_updown where fsponsor='$pID' and fsponsorstatus='1' and date(ftanggal) between '$pFrom' and '$pTo'";
		   $oDB->query($vsql);
		   $vCount=0;
		   while ($oDB->next_record()) {
		      $vDownline = $oDB->f('fdownline');
			
			   $vSQL="select fpaket from m_anggota where fidmember='$vDownline'";
			  //echo "<br>";
			  $dbin->query($vSQL);
			  $dbin->next_record();
			  $vPaket=$dbin->f('fpaket');
			  if ($vPaket == $pPack)
			     $vCount++;
			  
		   }
		   return $vCount;
		}		


       //Ambil Jumlah Sponsorship berdasarkan jenis Stockist (1=mob stock, 2=stockist)
  	    function getSponsorshipCountStock($pID,$pStock,$pFrom='1981-01-01',$pTo='1981-01-01') {
		   global $oDB, $oMember,$dbin1;
		   $vsql="select * from tb_updown where fsponsor='$pID' and fsponsorstatus='1' and date(ftanggal) between '$pFrom' and '$pTo'";
		   $oDB->query($vsql);
		   $vCount=0;
		   while ($oDB->next_record()) {
		      $vDownline = $oDB->f('fdownline');
			
			   $vSQL="select fstockist from m_anggota where fidmember='$vDownline'";
			  //echo "<br>";
			  $dbin1->query($vSQL);
			  $dbin1->next_record();
			 $vStock=$dbin1->f('fstockist');
			// echo "<br>";
			  if ($vStock == $pStock)
			     $vCount++;
			  
		   }
		   return $vCount;
		}	
 /*      //Ambil Jumlah Sponsorship berdasarkan stokis
  	    function getSponsorshipCountSto($pID,$pSto) {
		   global $oDB, $oMember,$dbin;
		   $vsql="select * from tb_updown where fsponsor='$pID' and fsponsorstatus='1'";
		   $oDB->query($vsql);
		   $vCount=0;
		   while ($oDB->next_record()) {
		      $vDownline = $oDB->f('fdownline');
			
			   $vSQL="select fstockist from m_anggota where fidmember='$vDownline'";
			  //echo "<br>";
			  $dbin->query($vSQL);
			  $dbin->next_record();
			  $vPaket=$dbin->f('fstockist');
			  
			  if ($vPaket == $pSto)
			     $vCount++;
			  
		   }
		   return $vCount;
		}		
*/

       //Ambil Jumlah Sponsorship Periode dari tb_kom_spon
  	    function getSponsorshipCountPeriodBns($pID, $pStart, $pEnd) {
		   global $oDB;
		   $vsql="select count(fidregistrar) as fcountspon from tb_kom_spon ";
		   $vsql.="where fidsponsor='$pID' and ftanggal between '$pStart 00:00:00' and '$pEnd 23:59:59' and ffeestatus='1'";
		   $oDB->query($vsql);
		   while ($oDB->next_record()) {
		      $vres=$oDB->f('fcountspon');
		   }
		   return $vres;
		}		


       //Ambil Jumlah Sponsorship Periode dari tb_updown
  	    function getSponsorshipCountPeriod($pID, $pStart, $pEnd) {
		   global $oDB;
		   $vsql="select count(fdownline) as fcountspon from tb_updown ";
		   $vsql.="where fsponsor='$pID' and ftanggal between '$pStart 00:00:00' and '$pEnd 23:59:59' and fsponsorstatus='1'";
		   $oDB->query($vsql);
		   while ($oDB->next_record()) {
		      $vres=$oDB->f('fcountspon');
		   }
		   return $vres;
		}		

       //Ambil Jumlah Member Periode
  	    function getMemberCountPeriod($pStart, $pEnd) {
		   global $oDB;
		   $vsql="select count(fidregistrar) as fcountspon from tb_kom_spon ";
		   $vsql.="where ftanggal between '$pStart 00:00:00' and '$pEnd 23:59:59' and ffeestatus='1'";
		   $oDB->query($vsql);
		   while ($oDB->next_record()) {
		      $vres=$oDB->f('fcountspon');
		   }
		   return $vres;
		}		
                

       //Ambil Jumlah Sponsorship Periode tanpa waktu
  	    function getSponsorshipCountPeriodNT($pID, $pStart, $pEnd) {
		   global $oDB;
		   $vsql="select count(fidregistrar) as fcountspon from tb_kom_spon ";
		   $vsql.="where fidsponsor='$pID' and date(ftanggal) between '$pStart' and '$pEnd' ";
		   $oDB->query($vsql);
		   while ($oDB->next_record()) {
		      $vres=$oDB->f('fcountspon');
		   }
		   return $vres;
		}		

	  
        //apakah upline  dari ID yang diketahui?
		function isUpline($pUp, $pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fupline from tb_updown where fdownline='$pID'  ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres = $oDB->f("fupline");
			}
			if ($vres == $pUp)
	  		   return 1;
			else
			   return -1;   
		}
	

        //apakah downline  dari ID yang diketahui?
		function isDownline($pDown, $pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fdownline from tb_updown where fupline='$pID'  ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres.=$oDB->f("fdownline");
			}
			if (in_array($pDown,$vres))
	  		   return 1;
			else
			   return -1;   
		}

        //apakah jumlah downline complete/penuh  dalam matrix?
		function isFull($pID) {
            global $oDB, $oRules, $oMember; 
			$vres="";
			$vFisrt=$oMember->getFirstID();
		    $vsql="SELECT count(fdownline) as fcountdown from tb_updown where fupline='$pID'  ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres=$oDB->f("fcountdown");
			}
			$vmaxdown=$oRules->getMaxDownline(1);
			if ($vres>=$vmaxdown)
	  		   return 1;
			else
			   return -1;   
		}

        //ambil posisi downline
		function getDownPos($pID) {
            global $oDB, $oRules, $oMember; 
			$vres="";
		    $vsql="SELECT fdownline,fkakike  from tb_updown where fupline='$pID' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres=$oDB->f("fkakike");
			}
 		   return $vres  ;
		}



        //apakah jumlah downline sempurna dalam level tertentu
		function isPerfect($pID, $pLevel) {   
		    global $oRules;        
			$vres=$this->getDownlineCountLevel($pID,$pLevel);
			$vmaxdown=$oRules->getMaxDownline(1);
			$vperfect=pow($vmaxdown,$pLevel);
			if ($vres==$vperfect)
	  		   return 1;
			else
			   return -1;   
		}



	
	       //apakah ID berada dalam network suatu ID lain
		function isInNetwork($pID,$pNet) {
				$vrestot='';
				$vflag=1;
				 $vres=trim($this->getUpline($pID));
				
				if (trim($vres)==trim($pNet)) {
				   return 1;
				  
				} else if (trim($pID)==trim($pNet))
			      return 1;
				else {  
					$vrestot[]=$vres;
					while ($vflag!=0) {
						if ($vres==-1) $vflag=0;			
						 $vres=$this->getUpline($vres);
						$vrestot[]=$vres;
					}
				//	print_r($vrestot);
					
					    if (in_array(trim($pNet),$vrestot))
			      			return 1;
			   			else
				  			return 0;   
			    }

		}



     //Cari tempat Kosong Rata Kiri atau kanan
	function findSpilloverLR($pID,$pPos) {
			global $oDB, $oRules, $oMember;
			if ($this->hasDownlineLR($pID,$pPos)!=1)
			   return $pID;
			$vMatrixWidth=$oRules->getMaxDownline(1);
		    $vDownLR=$this->getDownLR($pID,$pPos);
		    if ($this->hasDownlineLR($vDownLR,$pPos) !=1 )
		       return $vDownLR; 
			$this->getDownlineAll($vDownLR,$vDown);
			
			$vDown= array_merge(array($vDownLR),$vDown);
			$vDownX=array();$vDownAllX=array();
			while(list($key,$val) = each($vDown)) {
				  $vPos1=$this->getPosOne($val);	
				  if ($vPos1 != $pPos) {
				  	$this->getDownlineAll($val,$vDownX);
				  	unset($vDown[$key]);
				  }
				$vDownAllX=array_merge($vDownAllX,$vDownX)  ;
			}

			$vArrX=array_diff($vDown,$vDownAllX);
			

			while(list($key,$val) = each($vArrX)) {
			  $vHas=$this->hasDownlineLR($val,$pPos);
			  if ($vHas=='0') {
			  	$vSpill=$val;
			  	break;
			  }	
			}
			if ($vSpill !='')
			   return $vSpill;
			else return '0';    

		    

		
  }


     //Cari tempat Kosong
	function findSpillover($pID,$pPos='L') {
			global $oDB, $oRules, $oMemSort;
			if ($this->isFull($pID)!=1)
			   return $pID;
			$vMatrixWidth=$oRules->getMaxDownline(1);
			$this->getDownlineAll($pID,$vDown);			
			sort($vDown);
			
			$vCountDown=count($vDown);
			$vCountDown-=1;
			$vCountAr=0;
			for ($i=0;$i<$vCountDown+1;$i++) {
			  $vJmlDown=$this->getDownlineCount1($vDown[$i]);
			  $vLevel=$this->getDistance($vDown[$i],$pID);
			  $vSpill=$vDown[$i];
			  if ($vJmlDown<$vMatrixWidth) {//break;
			  	$MemSort[$vCountAr]->prLevel=$vLevel;
			  	$MemSort[$vCountAr]->prMember=$vDown[$i];
			    $vCountAr+=1;
			  } 
			}
			asort($MemSort);
			$vSpill=$MemSort[0]->prMember;

			if ($vSpill!="")
			  return $vSpill;
			else  
			  return -1;
		}


   //Masukkan member ke jaringan<em></em>
function putMember($pID,$db='') {
    global $oDB, $oMember, $oRules,$oSystem, $oKomisi, $oJual, $oEspay;
 //   $vSponFeeBasic=$oRules->getSettingByField('fbasicspon');//
//	$vRoyalFeeBasic=$oRules->getSettingByField('fbasicroyal');
	$vPaketMem=$oMember->getPaketID($pID);
	$vProsenFeeSpon = $oRules->getSettingByField('fprosenspon');
	
	if ($vPaketMem=='S')
	   $vRegFee=$oRules->getSettingByField('fregsilver');
	else   if ($vPaketMem=='G')
	   $vRegFee=$oRules->getSettingByField('freggold');
	else if ($vPaketMem=='P')
	   $vRegFee=$oRules->getSettingByField('fregplat');
	   
// di sini
    $vSernoMem = $oMember->getMemField('fserno',$pID);
    $vBelanja = $oJual->getKITNom($vSernoMem);
   // $vSponFee = $vBelanja * $vProsenFeeSpon /100;
	 $vSponFee = $oRules->getSettingByField('fsponfee');
	  $vPresFee = $oRules->getSettingByField('fpresfee');
	
    $vResSponsor=$oMember->getResSponsor($pID);
	$vFeeAdmin=$oRules->getSettingByField('fbyyadmin');
	$vProsenCash=$oRules->getSettingByField('fprosencash');
	$vProsenWProd=$oRules->getSettingByField('fprosenwprod');
	$vMaxWProd=$oRules->getSettingByField('fmaxwprod');
	$vVAT=$oRules->getSettingByField('fvat');
	//$vProsenWKit=$oRules->getSettingByField('fprosenwkit');
	//$vProsenWAcc=$oRules->getSettingByField('fprosenwacc');
	$vProsenTaxNPWP=$oRules->getSettingByField('ftaxnpwp');
	$vProsenTaxNonNPWP=$oRules->getSettingByField('ftaxnonpwp');
	
	$vNPWPSpon = $oMember->getMemField('fnpwp',$vResSponsor);
	if (trim($vNPWPSpon) != '')
	   $vProsenTax = $vProsenTaxNPWP;
	else    
	   $vProsenTax = $vProsenTaxNonNPWP;
//	$vProsenTax=0;   
	//$vMaxMaRO = $oRules->getSettingByField('fmaxrowal');
	
	
   // $vTotBelanja=$oMember->getMemField('ftotbelanja',$pID);
    //$vPaket=$oMember->getMemField('fpaket',$pID);
    //$vBonusRO=35000;
    
    
    //$vSponFee=$oRules->getSettingByField('fsponfee');
   $vPTKPMonth=$oRules->getSettingByField('fptkp');
   $vPTKPYear=$oRules->getSettingByField('fptkpy');
   $vProsenNormaPPH=$oRules->getSettingByField('fnormapph');
   $vProsenAdm=$oRules->getSettingByField('ffeeadmin');
	
    
 
	$vSponFeeCash=$vSponFee * $vProsenCash / 100;
	$vSponFeeWProd=$vSponFee * $vProsenWProd / 100;

	$vPresFeeCash=$vPresFee * $vProsenCash / 100;
	$vPresFeeWProd=$vPresFee * $vProsenWProd / 100;
	
//=============Income Sponsor===================//
			//$vProsenAdm=0;
		    $vYearMonth=substr(date("Y-m-d"),0,7);
			$vYear=substr(date("Y-m-d"),0,4);
		    $vIncomeMonth = $oKomisi->getBonusMonth($vResSponsor,$vYearMonth);
			$vIncomeYear = $oKomisi->getBonusYear($vResSponsor,$vYear);

		    $vIncomeMonthPres = $oKomisi->getBonusMonth($vResPres,$vYearMonth);
			$vIncomeYearPres = $oKomisi->getBonusYear($vResPres,$vYear);

			$vSponFeeAdm=$vSponFeeCash * ($vProsenAdm / 100);
			$PresFeeAdm=$vPresFeeCash * ($vProsenAdm / 100);

			if ($vIncomeMonth >= $vPTKPMonth || $vIncomeYear >= $vPTKPYear) {
		  	    $vTaxPPH = $vSponFeeCash  * ($vProsenTax /100) * ($vProsenNormaPPH / 100);
				$vSponFeeCashNett = $vSponFeeCash - $vTaxPPH - $vSponFeeAdm;
				
				
				$vFeeID .= " nett with PPH $vProsenNormaPPH%";
			} else {
			    $vTaxPPH = 0;
				$vSponFeeCashNett = $vSponFeeCash - $vTaxPPH - $vSponFeeAdm;
				$vFeeID .= " nett ";
			}
			
			
			if ($vIncomeMonthPres >= $vPTKPMonth || $vIncomeYearPres >= $vPTKPYear) {
		  	    $vTaxPPH = $vPresFeeCash  * ($vProsenTax /100) * ($vProsenNormaPPH / 100);
				$vPresFeeCashNett = $vPresFeeCash - $vTaxPPH - $vPresFeeAdm;
				
				
				$vFeeID .= " nett with PPH $vProsenNormaPPH%";
			} else {
			    $vTaxPPH = 0;
				$vPresFeeCashNett = $vPresFeeCash - $vTaxPPH - $vPresFeeAdm;
				$vFeeID .= " nett ";
			}			
//=============Income Sponso & Presr===================//

	//$vSponFeeTax=$vSponFeeCash * $vProsenTax / 100;
	
    //$vSponFeeCashNett = $vSponFeeCash -  $vSponFeeTax;
	
	
    
    
	if ($oMember->isActive($pID)==0) {
	   $vFirstID=$oMember->getFirstID();
	   $vResUpline=$oMember->getResUpline($pID);
	   $vResUplineFix=$oMember->getResUpline($pID);
	   $vResPos=$oMember->getMemField('fposition',$pID);
	    $vResPres=$oMember->getMemField('fidrespres',$pID);

	  
	 //  $oMember->isActive($vResUpline);
	   if ($oMember->isActive($vResUpline)==0) {
	      $oSystem->jsAlert("Upline tidak aktif. Sistem akan melakukan spillover!");
		  $vResUpline=-1;
	   }
	   
	   if ($this->hasDownlineLR($vResUpline,$vResPos)==1) {
	      $oSystem->jsAlert("Upline sudah memiliki downline di posisi yang di pilih. Sistem akan melakukan spillover!");
		  $vResUpline=-1;
	   }

	   
	   
	   if ($oMember->isActive($vResSponsor)==0) {
	      $oSystem->jsAlert("Sponsor yg dikehendaki tidak ada/tidak aktif, sponsor akan di set ke $vFirstID !");
		  $vResSponsor=-1;
	   }


	   if ($oMember->isActive($vResPres)==0) {
	      $oSystem->jsAlert("Presenter yg dikehendaki tidak ada/tidak aktif, presenter akan di set ke $vFirstID !");
		  $vResPres=-1;
	   }

	   //Ambil aturan-aturan
	    //; // Loop mulai dari ID yg diaktifkan sampai puncak
	   //$vRegFee=$oRules->getRegFee(1);
	   //$vManFee=$oRules->getManFee(1);
	 //  $vMtxFee=$oRules->getMtxFee(1); 
	 //  $vMtxFee=$vInvNom * $vMtxFee / 100;
	   
	   //Cek adanya reserved Sponsor

	   if ($vResSponsor==-1)
	      $vSponsor=$vFirstID;
	   else
	      $vSponsor=$vResSponsor;

	   if ($vResPres==-1)
	      $vPresenter=$vFirstID;
	   else
	      $vPresenter=$vResPres;

		// echo $vSponsor; 


       //Cek adanya Reserved Upline
	   
	   if ($vResUpline==-1) {	   	
	        
  			$vUpline=$this->findSpilloverLR($vSponsor,$vResPos);
			
	   // $oSystem->jsAlert("Upline1 $vUpline");
	   } else {
			// Apakah upline berada dalam jaringan sponsor?	
	   		if ($this->isInNetwork($vResUpline,$vSponsor)!=1) {
	      		$oSystem->jsAlert("Upline tidak berada dalam jaringan sponsor, sistem akan meletakkan upline ke dalam jaringan sponsor!");
		  		$vUpline=$this->findSpilloverLR($vSponsor,$vResPos);
	   		} else if ($oMember->isFirst($vResUpline)==0) {
			    $vUpline=$this->findSpilloverLR($vResUpline,$vResPos);   	 
			}  	else $vUpline=$vResUpline;
			 
			        
	   }	

	      
	 //   $oSystem->jsAlert("Upline2 $vUpline");
	    $vPos=$vResPos;
		if ($this->hasDownline($vUpline)==1) {		   
		      $vKe='2';
		}  else {
		      $vKe='1';
		}
		
		
		$vJmlSpon=0;
		$vJmlSpon = $this->getSponsorshipCount($vSponsor);
		$vNextSpon=$vJmlSpon+1;	

		$vJmlPres = $this->getPresCount($vSponsor);
		$vNextPres=$vJmlPres+1;	

		$vYear=date("Y");
		$vMonth=date("m");
		$vMonth = (int) $vMonth;
		
		//$vRoMaMonth = 	$oKomisi->getROMaMonth($vSponsor,$vYear, $vMonth);

	//	$oDB->query('START TRANSACTION;');
			$vUpline=trim($vUpline);$vSponsor=trim($vSponsor);$pID=trim($pID);
			$vsql="insert into tb_updown(fupline,fdownline,fsponsor,ftanggal,fkakike,fposisi,fsponsorke,fsponsorstatus,fpresenter) ";
			$vsql.=" values ('$vUpline','$pID', '$vSponsor',now(),'$vKe','$vPos',($vJmlSpon+1),1,'$vResPres')"; //Masukkan ke jaringan  kiri
		    $db->query($vsql);    
		    
		        
		    
		    $vsql="insert into tb_kom_spon(fidsponsor,fidregistrar,ffee,ftanggal,ffeestatus) ";
			$vsql.="values ('$vSponsor','$pID',$vSponFee,now(),'S$vNextSpon')"; //Masukkan komisi sponsor
			$db->query($vsql);   
			
//presenter
		    $vsql="insert into tb_kom_spon(fidsponsor,fidregistrar,ffee,ftanggal,ffeestatus) ";
			$vsql.="values ('$vPresenter','$pID',$vPresFee,now(),'P$vNextPres')"; //Masukkan komisi Presenter
			$db->query($vsql);   

			$vLastBal=$oMember->getMemField('fsaldovcr',$vSponsor);
			$vLastBalWprod=$oMember->getMemField('fsaldowprod',$vSponsor);
			
			if ($vLastBalWprod >= $vMaxWProd) {
					 $vTaxPPH =($vSponFeeCash + $vSponFeeWProd)  * ($vProsenTax /100) * ($vProsenNormaPPH / 100);
					 $vSponFeeCashNett =($vSponFeeCash + $vSponFeeWProd)  - $vTaxPPH - $vSponFeeAdm;				 
					
			}
			
			$vNewBal=$vLastBal + $vSponFeeCashNett;
			$vUserL=$_SESSION['LoginUser'];
			if (trim($vUserL) == '')
			   $vUserL='newreg';
			
			$vVATNom = $vBelanja * $vVAT / 100;
			$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fvat) "; 
			$vsql.="values ('$vSponsor', '$pID', now(),'Bonus sponsor [$pID] $vFeeID' , $vSponFeeCashNett,0 ,$vNewBal ,'spon' , '1','$vUserL' , now(),$vTaxPPH,0) "; 
			$db->query($vsql); 
			$oMember->updateBalConn($vSponsor,$vNewBal,$db);
			
//Presenter


			$vLastBalWprod=$oMember->getMemField('fsaldowprod',$vSponsor);
			
			if ($vLastBalWprod >= $vMaxWProd) {
		  	    $vTaxPPH = ($vPresFeeCash + $vPresFeeWProd)  * ($vProsenTax /100) * ($vProsenNormaPPH / 100);
				$vPresFeeCashNett = ($vPresFeeCash + $vPresFeeWProd) - $vTaxPPH - $vPresFeeAdm;
					
			}

			$vLastBal=$oMember->getMemField('fsaldovcr',$vPresenter);



			$vNewBal=$vLastBal + $vPresFeeCashNett;
			$vUserL=$_SESSION['LoginUser'];
			if (trim($vUserL) == '')
			   $vUserL='newreg';

			$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax,fvat) "; 
			$vsql.="values ('$vPresenter', '$pID', now(),'Bonus presenter [$pID] $vFeeID' , $vPresFeeCashNett,0 ,$vNewBal ,'pres' , '1','$vUserL' , now(),$vTaxPPH,0) "; 
			$db->query($vsql); 
			$oMember->updateBalConn($vPresenter,$vNewBal,$db);
			
			
		
			//Wallet Prod
			$vLastBal=$oMember->getMemField('fsaldowprod',$vSponsor);

			if ($vLastBal >= $vMaxWProd) {
				  $vSponFeeWProd = 0;
				  $vDescX = "Bonus sponsor [$pID] - cutoff";
			} else    $vDescX = "Bonus sponsor [$pID]";

			
			$vNewBal=$vLastBal + $vSponFeeWProd;

		 //Wallet Product
			$vsql="insert into tb_mutasi_wprod (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax) "; 
			$vsql.="values ('$vSponsor', '$pID', now(),'$vDescX' , $vSponFeeWProd,0 ,$vNewBal ,'spon' , '1','$vUserL' , now(),0) "; 
			$db->query($vsql); 
			
			$oMember->updateBalConnWProd($vSponsor,$vNewBal,$db);



			//Wallet Prod
			$vLastBal=$oMember->getMemField('fsaldowprod',$vPresenter);

			if ($vLastBal >= $vMaxWProd) {
				  $vPresFeeWProd = 0;
				  $vDescX = "Bonus presenter [$pID] - cutoff";
			} else    $vDescX = "Bonus presenter [$pID]";
			
			$vNewBal=$vLastBal + $vPresFeeWProd;

		 //Wallet Product
			$vsql="insert into tb_mutasi_wprod (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax) "; 
			$vsql.="values ('$vPresenter', '$pID', now(),'$vDescX ' , $vPresFeeWProd,0 ,$vNewBal ,'pres' , '1','$vUserL' , now(),0) "; 
			$db->query($vsql); 
			
			$oMember->updateBalConnWProd($vPresenter,$vNewBal,$db);
			
		   

		    $vsql="update tb_skit set fstatus = '4' where fserno = '$pID' ";
			//$vsql.="values ('$vSponsor','$pID',$vSponFee,now(),'S$vNextSpon')"; //Masukkan komisi sponsor
			$db->query($vsql);   
			
			//Bayar
			/*$vDate = date("Y-m-d");

			 $vURL = "https://www.onotoko.co.id/xsystem/main/calcreal.php?uStart=0_89999999&uDate=$vDate&uId=$vSponsor";
			$oEspay->sendGet($vURL);

			$vURL ="https://www.onotoko.co.id/xsystem/main/calcfreal.php?op=compile&uAkhir=$vDate&uId=$vSponsor";
			$oEspay->sendGet($vURL);*/
			
			//Komisi Stockist
			//$oKomisi->spreadStBonus($vIdMember,$vFee,'bnstock','poin','Bonus Aktifasi sebagai Stockist','$vIdMember');
		
		//$oDB->query('COMMIT;');
		//mail("adiditm@gmail.com","Debug Bonus Sponsor",$vsql);
	//	$vMaxLevel=$this->getDistanceSpon($pID,$vFirstID);
	   //Masukkan komisi matrix/titik 
	 
	
		
	   $oMember->changeActiveDB($pID,'1',$db);
	   $oMember->setActiveDateDB($pID,"now()",$db);
	   
	   
	   //$oSystem->jsAlert("Pendaftaran sukses, sponsor=$vSponsor, upline=$vUpline");
	  } else {//isActive 
	    $oSystem->jsAlert("Member sudah aktif, Anda tidak bisa mengaktifkan lagi!");
	  }
   } //putMember
  

   //Masukkan free member ke jaringan
   function putFreeMember($pID) {
    global $oDB, $oMember, $oRules,$oSystem;
	if ($oMember->isActive($pID)==0) {
	   $vFirstID=$oMember->getFirstID();
	   $vResUpline=$oMember->getResUpline($pID);
	   $oMember->isActive($vResUpline);
	   if ($oMember->isActive($vResUpline)==0) {
	      $oSystem->jsAlert("Upline yg dikehendaki tidak ada/tidak aktif, sistem akan melakukan spillover!");
		  $vResUpline=-1;
	   }
	    $vResSponsor=$oMember->getResSponsor($pID);
	   if ($oMember->isActive($vResSponsor)==0) {
	      $oSystem->jsAlert("Sponsor yg dikehendaki tidak ada/tidak aktif, sponsor akan di set ke $vFirstID !");
		  $vResSponsor=-1;
	   }

	   //Ambil aturan-aturan
	 //  $vMaxLevel=$oRules->getRealMaxLevel(1); // Dari tb_rules_config
	   $vRegFee=$oRules->getRegFee(1);
	   $vManFee=$oRules->getManFee(1);
	   $vSponFee=$oRules->getSponFee(1);
	   //$vMtxFee=$oRules->getMtxFee(1); //dipindah per level beda
	   
	   //Cek adanya reserved Sponsor

	   if ($vResSponsor==-1)
	      $vSponsor=$vFirstID;
	   else
	      $vSponsor=$vResSponsor;
		  
       //Cek adanya Reserved Upline
	   if ($vResUpline==-1)
	      $vUpline=$this->findSpillover($vSponsor);
	   else {
			// Apakah upline berada dalam jaringan sponsor?	
	   		if ($this->isInNetwork($vResUpline,$vSponsor)!=1) {
	      		$oSystem->jsAlert("Upline tidak berada dalam jaringan sponsor, sistem akan meletakkan upline ke dalam jaringan sponsor!");
		  		$vUpline=$this->findSpillover($vSponsor);
	   		} else
			 $vUpline=$this->findSpillover($vResUpline);   	        
	   }	
	    $vsql="insert into tb_updown(fsponsor,fupline,fdownline,ftanggal) values ('$vSponsor','$vUpline','$pID',now())"; //Masukkan ke jaringan
	    $oDB->query($vsql);
	   $oMember->changeActive($pID,'2');
	   $oMember->setActiveDate($pID,"now()");
	   $oSystem->jsAlert("Sponsor=$vSponsor, upline=$vUpline");
	  } else {//isActive 
	    $oSystem->jsAlert("Member sudah aktif, Anda tidak bisa mengaktifkan lagi!");
	  }
   } //putMember










  
     //Hapus komisi matrix
   function delFee($pID) {
   	   global $oDB, $oMember, $oRules,$oSystem;
   	   $vsql="delete from tb_kom_mtx where fidregistrar='$pID'";
	   $oDB->query($vsql);
   	   $vsql="delete from tb_overmatrix where fidregistrar='$pID'";
	   $oDB->query($vsql);
	   $oSystem->jsAlert("Komisi sudah dihapus!");
   }	   
   //Masukkan komisi matrix
   function sendFee($pID) {
	
   	   global $oDB, $oMember, $oRules,$oSystem;
   	   $vFirstID=$oMember->getFirstID();
	   $vMaxLevel=$oRules->getMaxLevel(1);
	   $vRegFee=$oRules->getRegFee(1);
	   $vManFee=$oRules->getManFee(1);
	   $vSponFee=$oRules->getSponFee(1);
	   $vMtxFee=$oRules->getMtxFee(1);

	   for ($i=1;$i<$vMaxLevel+1;$i++) {
		  $vIDReceiver=$this->getUplineLevel($pID,$i);
		  if ($vIDReceiver==$vFirstID)
		     $vFunderOver=$this->getUplineLevel($pID,$i-1);			 
		  if ($i==1) 
		      $vFunder=$pID;
		  else
		  	  $vFunder=$this->getUplineLevel($pID,$i-1);		 
	      if ($vIDReceiver==-1)  {
		     $vsql="insert into tb_overmatrix(fidregistrar,ftanggal,fidfunder,fidmember,ffee) values('$pID',now(),'$vFunderOver','$vFirstID',$vMtxFee)";
			 $oDB->query($vsql);    
		  } else {	   
			 $vsql="insert into tb_kom_mtx(fidregistrar,ftanggal,fidfunder,fidmember,ffee) values('$pID',now(),'$vFunder','$vIDReceiver',$vMtxFee)";   
  		  	 $oDB->query($vsql); 
			    
		  }		 
		 
	  }
   
    $oSystem->jsAlert("Komisi Matrix dan Overmatrix sudah diupdate!");
   }
   
   
    //Masukkan komisi matrix
   function sendFeeSponTitik($pID) {
	
   	   global $oDB, $oMember, $oRules,$oSystem;
   	   $vFirstID=$oMember->getFirstID();

		$vTitikFeeBasic=$oRules->getSettingByField('froyalbasic');
		
		$vTitikFeeSil=$oRules->getSettingByField('fmulsilver') * $vTitikFeeBasic;
		$vTitikFeeGold=$oRules->getSettingByField('fmulgold') * $vTitikFeeBasic;
		$vTitikFeePlat=$oRules->getSettingByField('fmulplat') * $vTitikFeeBasic;
		
		$vFeeAdmin=$oRules->getSettingByField('fbyyadmin');
		$vProsenNex=$oRules->getSettingByField('fprosencash');
		$vProsenRO=$oRules->getSettingByField('fprosenauto');

/*
		if ($vPaket=='S') {
		   $vTitikFee=$vTitikFeeSil;
		} else if ($vPaket=='G') {
		   $vTitikFee=$vTitikFeeGold;
		} else if ($vPaket=='P') {
		   $vTitikFee=$vTitikFeePlat;
		}
	*/   
	   
	   $vMaxLevel=$oRules->getMaxLevel(1);

	   for ($i=1;$i<$vMaxLevel+1;$i++) {
		  $vIDReceiver=$this->getUplineLevel($pID,$i);
		  if ($vIDReceiver==$vFirstID)
		     $vFunderOver=$this->getUplineLevel($pID,$i-1);			 
		  if ($i==1) 
		      $vFunder=$pID;
		  else
		  	  $vFunder=$this->getUplineLevel($pID,$i-1);		 

			 $vsql="insert into tb_kom_mtx(fidregistrar,ftanggal,fidfunder,fidmember,ffee) values('$pID',now(),'$vFunder','$vIDReceiver',$vTitikFee)";   
  		  	 $oDB->query($vsql); 
			    
	  }
   
    $oSystem->jsAlert("Komisi Royalty  sudah diupdate!");
   } 
   

   //Masukkan komisi matrix
   function sendFeeTitikCompress($pID,$pDeep,$pMulti=1,$pRef,$vDateCompile) {
	// MUlti=Jumlah pembelian
	$vMsgAll ="";
   	   global $oDB, $oMember, $oRules,$oSystem, $oKomisi, $oMydate;
	   		
			$vDate=$oMydate->dateSub($vDateCompile,1,'day');
		    $vYearMonth=substr($vDate,0,7);
			$vYear=substr($vDate,0,4);

	   
   	   $vFirstID=$oMember->getFirstID();
	   $vFeeSet0=$oRules->getSettingByField('funifee0');
	   $vFeeSet1=$oRules->getSettingByField('funifee1');
	   $vFeeSet2=$oRules->getSettingByField('funifee2');
	   $vFeeSet3=$oRules->getSettingByField('funifee3');
	   $vFeeSetNext=$oRules->getSettingByField('funifeeo');

	   $vPTKPMonth=$oRules->getSettingByField('fptkp');
	   $vPTKPYear=$oRules->getSettingByField('fptkpy');
	   $vProsenNormaPPH=$oRules->getSettingByField('fnormapph');
	   
	   	$vProsenTaxNPWP=$oRules->getSettingByField('ftaxnpwp');
	    $vProsenTaxNonNPWP=$oRules->getSettingByField('ftaxnonpwp');

	   
	   
		$vTitikFee0=$vFeeSet0* $pMulti / 100;	
		$vTitikFee1=$vFeeSet1 * $pMulti / 100;		
		$vTitikFee2=$vFeeSet2 * $pMulti / 100;
		$vTitikFee3=$vFeeSet3 * $pMulti / 100;
		$vTitikFeeNext=$vFeeSetNext * $pMulti / 100;
		 
	//	echo "$vTitikFee0 $vTitikFee1 $vTitikFee2 $vTitikFee3 $vTitikFeeNext ";
		//$vTitikFeeNext = $vTitikFeeNext * $pMulti;
/*		$vFeeAdmin=$oRules->getSettingByField('fbyyadmin');
		$vProsenNex=$oRules->getSettingByField('fprosencash');
		$vProsenRO=$oRules->getSettingByField('fprosenauto');
*/
/*
		if ($vPaket=='S') {
		   $vTitikFee=$vTitikFeeSil;
		} else if ($vPaket=='G') {
		   $vTitikFee=$vTitikFeeGold;
		} else if ($vPaket=='P') {
		   $vTitikFee=$vTitikFeePlat;
		}
	*/   
	   //Check Omzet
	   
	 
	   $i=1; $j=1;	$k=1;

//Level 0

				echo $vMsg="<br><font color='#f0f'>Insert fee titik $pID --> $pID (level 0) dari RO $pRef  sebesar ($pMulti x $vFeeSet0"."%) =  $vTitikFee0 !</font>";
						 $vMsgAll .= $vMsg;
				$vsql="insert into tb_kom_mtx(fidregistrar,ftanggal,fidfunder,fidmember,ffee,ffeestatus,fdesc) values('$pID',now(),'$pID','$pID',$vTitikFee0,'1','$pRef')";   
				 $oDB->query($vsql);

				$vNPWP = $oMember->getMemField('fnpwp',$pID);
				if (trim($vNPWP) != '')
				   $vProsenTax = $vProsenTaxNPWP;
				else    
				   $vProsenTax = $vProsenTaxNonNPWP;


				
				$vIncomeMonth = $oKomisi->getBonusMonthOno($pID,$vYearMonth);
				$vIncomeYear = $oKomisi->getBonusYearOno($pID,$vYear);
				
//echo "$vIncomeMonth > $vPTKPMonth || $vIncomeYear > $vPTKPYear";
				if ($vIncomeMonth > $vPTKPMonth || $vIncomeYear > $vPTKPYear) {
					$vTaxPPH = $vTitikFee0 * ($vProsenTax /100) * ( $vProsenNormaPPH / 100);
					$vTitikFeeNett = $vTitikFee0 - $vTaxPPH ;
					
					$vFeeID .= " nett with PPH $vProsenTax + $vProsenNormaPPH%";
					echo $vMsg=", <font color='#f0f'>tax applied!</font>";
						 $vMsgAll .= $vMsg;
					
				} else {
					$vTitikFeeNett = $vTitikFee0 ;
					$vTaxPPH = 0;
					$vFeeID .= " nett ";
					echo $vMsg=", <font color='#f0f'>no tax!</font>";
						 $vMsgAll .= $vMsg;
					
				}
							
				 $vLastBal=$oKomisi->getLastBalance($pID);
				 $vNewBal=$vLastBal + $vTitikFeeNett;
				 $vDesc="Bonus unilevel dari RO $pID Level 0 - $vFeeID ";
				 $oKomisi->insertMutasi($pID,$vFunder,date("Y-m-d H:i:s"),$vDesc,$vTitikFeeNett,0,$vNewBal,'unile',$pRef);
				 $oMember->updateBal($pID,$vNewBal);

//End level 0				 


				 	   
	   while ($i < ($pDeep + 1)) {
		  $vIDReceiver=$this->getUplineLevel($pID,$j);
		  $vSQL="select * from tb_trxstok_member where fidmember='$vIDReceiver' and fprocessed='2' ";
		// echo "$i <br>";
		  $oDB->query($vSQL);
		  $oDB->next_record();
		  $vRec=$oDB->num_rows();
		//  echo "Rec  $vRec ";
		  if ($vRec > 0) { //Syarat
	
				 
			  if ($i==1)  {
				  $vTitikFee=$vTitikFee1;
				  $vSet = $vFeeSet1;
			  } else if ($i==2)  {
				  $vTitikFee=$vTitikFee2;
				   $vSet = $vFeeSet2;
			  }  else if ($i==3)  {
				  $vTitikFee=$vTitikFee3;
				   $vSet = $vFeeSet3;
			  } else {
				 
				  $vTitikFee=$vTitikFeeNext;		
				   $vSet = $vFeeSetNext;
			  }
			$vFunder=$pID;
	//echo "$vTitikFee <br> ";
	//echo "$i Ada<br>";

	
		  if ($vIDReceiver!=-1 && $vIDReceiver!='-' ) {
				echo $vMsg="<br><font color='#f0f'>Insert fee titik $pID --> $vIDReceiver (level $i)  dari RO $pRef  sebesar ($pMulti x $vSet"."%) =  $vTitikFee !</font>";
						 $vMsgAll .= $vMsg;
						 

			
				$vsql="insert into tb_kom_mtx(fidregistrar,ftanggal,fidfunder,fidmember,ffee,ffeestatus,fdesc) values('$pID',now(),'$vFunder','$vIDReceiver',$vTitikFee,'1','$pRef')";   
				 $oDB->query($vsql);
			//	 echo $vsql."<br>";
			
				$vNPWP = $oMember->getMemField('fnpwp',$vIDReceiver);
				if (trim($vNPWP) != '')
				   $vProsenTax = $vProsenTaxNPWP;
				else    
				   $vProsenTax = $vProsenTaxNonNPWP;


				
				$vIncomeMonth = $oKomisi->getBonusMonthOno($vIDReceiver,$vYearMonth);
				$vIncomeYear = $oKomisi->getBonusYearOno($vIDReceiver,$vYear);
				
//echo "$vIncomeMonth > $vPTKPMonth || $vIncomeYear > $vPTKPYear";
				if ($vIncomeMonth > $vPTKPMonth || $vIncomeYear > $vPTKPYear) {
					$vTaxPPH = $vTitikFee * ($vProsenTax /100) * ( $vProsenNormaPPH / 100);
					$vTitikFeeNett = $vTitikFee - $vTaxPPH ;
					
					$vFeeID .= " nett with PPH $vProsenTax + $vProsenNormaPPH%";
					echo $vMsg=", <font color='#f0f'>tax applied!</font>";
						 $vMsgAll .= $vMsg;
					
				} else {
					$vTitikFeeNett = $vTitikFee ;
					$vTaxPPH = 0;
					$vFeeID .= " nett ";
					echo $vMsg=", <font color='#f0f'>no tax!</font>";
						 $vMsgAll .= $vMsg;
					
				}
							
				 $vLastBal=$oKomisi->getLastBalance($vIDReceiver);
				 $vNewBal=$vLastBal + $vTitikFeeNett;
				 $vDesc="Bonus unilevel dari RO $pID Level $i - $vFeeID ";
				 $oKomisi->insertMutasi($vIDReceiver,$vFunder,date("Y-m-d H:i:s"),$vDesc,$vTitikFeeNett,0,$vNewBal,'unile',$pRef);
				 $oMember->updateBal($vIDReceiver,$vNewBal);
			//	 echo "<br> $vDesc OK  $j <br> ";
		  }
				 $i++; $j++;
		  } else { //Tidak Tupo
			
	
		//	echo "<br> Compress  $j <br> ";
			  if ($i==1)  {
				  $vFunder=$pID;
				 
			  } else {
				  $vFunder=$this->getUplineLevel($pID,$i-1);
				
			  }

echo $vMsg="<br><font color='#f0f'>Insert fee titik $pID --> $vIDReceiver (no level) dari RO $pRef  sebesar 0 (compressed) !</font>";
						 $vMsgAll .= $vMsg;

	
			  if ($vIDReceiver!=-1 && $vIDReceiver!='-' ) {
					$vsql="insert into tb_kom_mtx(fidregistrar,ftanggal,fidfunder,fidmember,ffee,ffeestatus,fdesc) values('$pID',now(),'$vFunder','$vIDReceiver',0,'0','$pRef')";   
					 $oDB->query($vsql);			
			  }
				 
		
			$j++;
		  }
		  
	   if ($vIDReceiver==-1 || $vIDReceiver=='-' ||  $vIDReceiver==$vFirstID || $i >= ($pDeep + 2)) {
	     // $i = ($pDeep + 2);
		  break;
	   }
			    
	  }
        return $vMsgAll;
   } 
   
      
   //Ganti Upline di tb_updown
   function updateNetwork($pID,$pNewUpline) {
      global $oDB, $oMember, $oRules,$oSystem;
	  $vsql="update tb_updown set fupline='$pNewUpline' where fdownline='$pID'";
	  $oDB->query($vsql);
	  $oSystem->jsAlert("Network Updated!");
   }
   
//Update Sponsor
   function updateSponsor($pID,$pNewSponsor) {
      global $oDB, $oMember, $oRules,$oSystem;
	  $vsql="update tb_kom_spon set fidsponsor='$pNewSponsor' where fidregistrar='$pID'";
	  $oDB->query($vsql);
	  $oSystem->jsAlert("Sponsor Updated!");
   }



   //Ambil Komisi Matrix 
   function getKomMtx($pID) {
		global $oDB;
		$vsql="select sum(ffee) as fmtxfee from tb_kom_mtx where fidmember='$pID' and ffeestatus='1'";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vmatrix = $oDB->f('fmtxfee');
		}
		if ($vmatrix!="")
		   return $vmatrix;
		else
		   return 0;  
	}


  //Ambil Komisi Matrix Sekarang
   function getKomMtxNow($pID) {
		global $oDB;
		$vsql="select ffee as jumlah from (select fidmember as fid,sum(ffee) AS ffee,'mtx' from tb_kom_mtx where ftanggal <= (select ftglkomisi  from tb_criteria) and ffeestatus = 1 group by fidmember ) as vkom_mtx where fid='$pID'";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vmatrix = $oDB->f('jumlah');
		}
		if ($vmatrix!="")
		   return $vmatrix;
		else
		   return 0;  
	}


   //Ambil Komisi Penjualan 
   function getKomSell($pID) {
		global $oDB;
		$vsql="select sum(ffee) as fsellfee from tb_kom_buy where fidmember='$pID' and ffeestatus='1'";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vmatrix = $oDB->f('fsellfee');
		}
		if ($vmatrix!="")
		   return $vmatrix;
		else
		   return 0;  
	}


  //Ambil Komisi Sponsor Sekarang
   function getKomSponNow($pID) {
		global $oDB;
		$vsql="select ffee as jumlah from (select fidsponsor as fid,sum(ffee) AS ffee,'spo' from tb_kom_spon where ftanggal <= (select ftglkomisi  from tb_criteria) and ffeestatus = 1 group by fidsponsor) as vkom_spon where fid='$pID'";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vspon = $oDB->f('jumlah');
		}
		if ($vspon!="")
		   return $vspon;
		else
		   return 0;  
	}

  //Ambil Komisi Sponsor Sekarang
   function getKomSponDay($pID) {
		global $oDB;
		$vsql="select ffee as jumlah from (select fidsponsor as fid,sum(ffee) AS ffee,'spo' from tb_kom_spon where date(ftanggal) = (select date(ftglkomisi)  from tb_criteria)  group by fidsponsor) as vkom_spon where fid='$pID'";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vspon = $oDB->f('jumlah');
		}
		if ($vspon!="")
		   return $vspon;
		else
		   return 0;  
	}


  //Ambil Komisi Matrix Sekarang
   function getKomSellNow($pID) {
		global $oDB;
		 $vsql="select ffee as jumlah from (select fidmember as fid,sum(ffee) AS ffee,'jual' from tb_kom_buy where ftanggal <= (select ftglkomisi  from tb_criteria) and ffeestatus = 1 group by fidmember ) as vkom_sell where fid='$pID'";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vmatrix = $oDB->f('jumlah');
		}
		if ($vmatrix!="")
		   return $vmatrix;
		else
		   return 0;  
	}

  //Ambil Komisi Cash Plan A Sekarang
   function getKomCash($pID) {
		global $oDB;
		
		$v_kom_spon="select fidsponsor as fid,sum(ffee) AS ffee,'spo' from tb_kom_spon where  ftanggal <= (select ftglkomisi  from tb_criteria)  group by fidsponsor";
		$v_kom_coup="select fidreceiver as fid,sum(ffee) AS ffee,'coup' from tb_kom_couple where ftanggal <= (select ftglkomisi  from tb_criteria) and ffeestatus = 1 group by fidreceiver ";
		//$v_kom_match="select fidreceiver as fid,sum(ffee) AS ffee,'match' from tb_kom_match where ftanggal <= (select ftglkomisi  from tb_criteria) and ffeestatus = 1 group by fidreceiver ";
		$v_kom_level="select fidmember as fid,sum(ffee) AS ffee,'level' from tb_kom_mtx where ftanggal <= (select ftglkomisi  from tb_criteria) and ffeestatus = 1 group by fidmember ";
		$v_kom_gab="select fid,sum(ffee) AS ffeegab from ($v_kom_spon union $v_kom_coup union $v_kom_level) as kom_gab group by fid  ";
		$vsql="select a.fid,a.ffeegab from ($v_kom_gab) as a where a.fid='$pID'"; 
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vcash = $oDB->f('ffeegab');
		}
		if ($vcash!="")
		   return $vcash;
		else
		   return 0;  
	}



  //Ambil Komisi Cash Plan B Sekarang
   function getKomBCash($pID) {
		global $oDB;
			$v_kom_b="select fidmember as fid,sum(ffee * 100 / 100) AS ffeegab,'komb' from tb_kom_b where  ftglcreated <= (select ftglkomisi  from tb_criteria) and ffeestatus = 1 group by fidmember";
			$vsql="select a.fid,a.ffeegab from ($v_kom_b) as a  WHERE  a.fid='$pID'  "; 
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vcash = $oDB->f('ffeegab');
		}
		if ($vcash!="")
		   return $vcash;
		else
		   return 0;  
	}


  //Ambil Komisi Cash KNP Sekarang
   function getKomKNPCash($pID) {
		global $oDB;
			$v_kom_knp="select fidmember as fid,sum(ffee) AS ffeegab,'komb' from tb_profit_knp where  ftanggal <= (select ftglkomisi  from tb_criteria) and ffeestatus = 1 group by fidmember";
			$vsql="select a.fid,a.ffeegab from ($v_kom_knp) as a  WHERE  a.fid='$pID'  "; 
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vcash = $oDB->f('ffeegab');
		}
		if ($vcash!="")
		   return $vcash;
		else
		   return 0;  
	}



   //Apa sudah pernah terbayar? 
   function isPaid($pID) {
		global $oDB;
		$vsql="select count(fidmember) as fcbukti from tb_transfer where fidmember='$pID'  ";	
		$oDB->query($vsql);
		$oDB->next_record();
		$vbukti = $oDB->f('fcbukti');
		if ($vbukti>0)
		   return 1;
		else
		   return 0;  
	}


   //Apa sudah pernah terbayar Matrix dan Sponsor? 
   function isPaidSponMat($pID) {
		global $oDB;
		$vsql="select count(fidmember) as fcbukti from tb_transfer where fidmember='$pID' and(fstatus='matrix' or fstatus='sponsor')  ";	
		$oDB->query($vsql);
		$oDB->next_record();
		$vbukti = $oDB->f('fcbukti');
		if ($vbukti>0)
		   return 1;
		else
		   return 0;  
	}


   //Ambil Bukti Pembayaran 
   function getDocPaid($pID,$pTanggal) {
		global $oDB;
		$vsql="select fbukti from tb_transfer where fidmember='$pID' and ftanggal='$pTanggal' ";	
		$oDB->query($vsql);
		$oDB->next_record();
		$vbukti = $oDB->f('fbukti');
		if ($vbukti!="")
		   return $vbukti;
		else
		   return 0;  
	}

   //Ambil Komisi Matrix Terbayar 
   function getMtxPaid($pID) {
		global $oDB;
		$vsql="select sum(ffee) as fmtxpaid from tb_transfer where fidmember='$pID' and fstatus='matrix' ";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vmatrix = $oDB->f('fmtxpaid');
		}
		if ($vmatrix!="")
		   return $vmatrix;
		else
		   return 0;  
	}

   //Ambil Komisi Sponsor Terbayar 
   function getSponPaid($pID) {
		global $oDB;
		$vsql="select sum(ffee) as fsponpaid from tb_transfer where fidmember='$pID' and fstatus='sponsor' ";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vres = $oDB->f('fsponpaid');
		}
		if ($vres!="")
		   return $vres;
		else
		   return 0;  
	}


   //Ambil Komisi Mingguan Terbayar 
   function getWeekPaid($pID) {
		global $oDB;
		$vsql="select sum(ffee) as fweekpaid from tb_transfer where fidmember='$pID' and fstatus='weekcash' ";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vmatrix = $oDB->f('fweekpaid');
		}
		if ($vmatrix!="")
		   return $vmatrix;
		else
		   return 0;  
	}

   //Ambil Komisi harian Terbayar 
   function getDayPaid($pID) {
		global $oDB;
		 $vsql="select sum(ffee) as fdaypaid from tb_transfer where fidmember='$pID' and fstatus='daycash' ";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vmatrix = $oDB->f('fdaypaid');
		}
		if ($vmatrix!="")
		   return $vmatrix;
		else
		   return 0;  
	}


   //Ambil Komisi B Terbayar 
   function getBPaid($pID) {
		global $oDB;
		$vsql="select sum(ffee) as fbpaid from tb_transfer where fidmember='$pID' and fstatus='bcash' ";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vmatrix = $oDB->f('fbpaid');
		}
		if ($vmatrix!="")
		   return $vmatrix;
		else
		   return 0;  
	}


   //Ambil Komisi B Terbayar 
   function getKNPPaid($pID) {
		global $oDB;
		$vsql="select sum(ffee) as fknppaid from tb_transfer where fidmember='$pID' and fstatus='knp' ";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vmatrix = $oDB->f('fknppaid');
		}
		if ($vmatrix!="")
		   return $vmatrix;
		else
		   return 0;  
	}



   //Ambil Komisi Matrix Terbayar 
   function getSellPaid($pID) {
		global $oDB;
		$vsql="select sum(ffee) as fsellpaid from tb_transfer where fidmember='$pID' and fstatus='jual' ";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vres = $oDB->f('fsellpaid');
		}
		if ($vres!="")
		   return $vres;
		else
		   return 0;  
	}

   //Ambil Komisi Stockist Terbayar 
   function getStockPaid($pID) {
		global $oDB;
		$vsql="select sum(ffee) as fmtxpaid from tb_transfer where fidmember='$pID' and fstatus='stock' ";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vmatrix = $oDB->f('fmtxpaid');
		}
		if ($vmatrix!="")
		   return $vmatrix;
		else
		   return 0;  
	}


   //Bayar Komisi Matrix  
   function setMtxPaid($pID,$pFee,$pBukti,$pTanggal) {
		global $oDB;
		$vsql="insert into tb_transfer(ftanggal,fpaid,fbukti,ftglpaid,fidmember,fstatus,ffee) ";	
		$vsql.="values('$pTanggal','1','$pBukti',now(),'$pID','matrix',$pFee) ";	
		$oDB->query($vsql);
	}

   //Bayar Komisi Sponsor  
   function setSponPaid($pID,$pFee,$pBukti,$pTanggal) {
		global $oDB;
		$vsql="insert into tb_transfer(ftanggal,fpaid,fbukti,ftglpaid,fidmember,fstatus,ffee) ";	
		$vsql.="values('$pTanggal','1','$pBukti',now(),'$pID','sponsor',$pFee) ";	
		$oDB->query($vsql);
	}


   //Bayar Komisi Cash
   function setCashPaid($pID,$pFee,$pBukti,$pTanggal) {
		global $oDB;
		$vsql="insert into tb_transfer(ftanggal,fpaid,fbukti,ftglpaid,fidmember,fstatus,ffee) ";	
		 $vsql.="values('$pTanggal','1','$pBukti',now(),'$pID','daycash',$pFee) ";	
		$oDB->query($vsql);
	}


   //Bayar Komisi B Cash
   function setCashBPaid($pID,$pFee,$pBukti,$pTanggal) {
		global $oDB;
		$vsql="insert into tb_transfer(ftanggal,fpaid,fbukti,ftglpaid,fidmember,fstatus,ffee) ";	
		$vsql.="values('$pTanggal','1','$pBukti',now(),'$pID','bcash',$pFee) ";	
		$oDB->query($vsql);
	}

   //Bayar Komisi KNPCash
   function setCashKNPPaid($pID,$pFee,$pBukti,$pTanggal) {
		global $oDB;
		$vsql="insert into tb_transfer(ftanggal,fpaid,fbukti,ftglpaid,fidmember,fstatus,ffee) ";	
		$vsql.="values('$pTanggal','1','$pBukti',now(),'$pID','knp',$pFee) ";	
		$oDB->query($vsql);
	}


   //Bayar Komisi Penjualan  
   function setSellPaid($pID,$pFee,$pBukti,$pTanggal) {
		global $oDB;
		$vsql="insert into tb_transfer(ftanggal,fpaid,fbukti,ftglpaid,fidmember,fstatus,ffee) ";	
		$vsql.="values('$pTanggal','1','$pBukti',now(),'$pID','jual',$pFee) ";	
		$oDB->query($vsql);
	}


   //Ambil Reward Terbayar 
   function getRewardPaid($pID) {
		global $oDB;
		$vsql="select sum(b.fnominal) as fnomrewards from tb_rewards a "; 
		$vsql.="left join m_rewards b on a.flevel=b.flevel ";
		$vsql.="where a.fidmember='$pID'";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vres = $oDB->f('fnomrewards');
		}
		if ($vres!="")
		   return $vres;
		else
		   return 0;  
	}



	//Ambil nama reward
   function getRewardName($pLevel) {
		global $oDB;
		$vsql="select freward from m_rewards where flevel='$pLevel' ";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vres = $oDB->f('freward');
		}
		if ($vres!="")
		   return $vres;
		else
		   return 0;  
	}

	//Ambil Jumlah Anggota reward
   function getRewardCount($pLevel) {
		global $oDB;
		$vsql="select fjmllevel from m_rewards where flevel='$pLevel' ";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vres = $oDB->f('fjmllevel');
		}
		if ($vres!="")
		   return $vres;
		else
		   return 0;  
	}


	//Ambil Nominal Reward
   function getRewardNom($pLevel) {
		global $oDB;
		$vsql="select fnominal from m_rewards where flevel='$pLevel' ";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vres = $oDB->f('fnominal');
		}
		if ($vres!="")
		   return $vres;
		else
		   return 0;  
	}


	//Ambil Anggota Terakhir
   function getLastMember($pID) { //Belum
		global $oDB;
		$vsql="select fdownline,ftanggal from tb_updown where fupline='$pLevel' ";	
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		  $vres['downline'] = $oDB->f('fdownline');
		  $vres['tanggal'] = $oDB->f('ftanggal');
		}
		if ($vres!="")
		   return $vres;
		else
		   return 0;  
	}
//Jumlah Sempurna level
   function perfectCount($pLevel) {
       global $oRules;
       $vMaxDownline=$oRules->getMaxDownline(1);
	   $vres=pow($vMaxDownline,$pLevel);
	   return $vres;
   }

//Get Fee Matrix All tanpa ID
   function getAllMtxFeeNoID() {
   global $oDB;
   $vsql="select sum(ffee) as fmtxfee from tb_kom_mtx where ffeestatus='1'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres=$oDB->f('fmtxfee');
	}
	   return $vres;
   }



//Get Fee Matrix All
   function getAllMtxFee($pID) {
   global $oDB;
   $vsql="select sum(ffee) as fmtxfee from tb_kom_mtx where fidmember='$pID' and ffeestatus='1'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres=$oDB->f('fmtxfee');
	}
	   return $vres;
   }


//Get Fee Matrix Minggu 
   function getWeekMtxFee($pID,$pWeek,$pYear) {
   global $oDB;
   $vsql="select sum(ffee) as fmtxfee from tb_kom_mtx where fidmember='$pID' and weekofyear(ftanggal)=$pWeek and year(ftanggal)=$pYear and ffeestatus='1'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres=$oDB->f('fmtxfee');
	}
	   return $vres;
   }


//Get Fee Matrix Minggu  tanpa ID
   function getWeekMtxFeeNoID($pWeek,$pYear) {
   global $oDB;
   $vsql="select sum(ffee) as fmtxfee from tb_kom_mtx where  weekofyear(ftanggal)=$pWeek and year(ftanggal)=$pYear and ffeestatus='1'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres=$oDB->f('fmtxfee');
	}
	   return $vres;
   }

//Get Fee Sponsor All tanpa ID
   function getAllSponFeeNoID() {
   global $oDB;
   $vsql="select sum(ffee) as fsponfee from tb_kom_spon where ffeestatus='1' ";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres=$oDB->f('fsponfee');
	}
	   return $vres;
   }

//Get Fee Sponsor All
   function getAllSponFee($pID) {
   global $oDB;
   $vsql="select sum(ffee) as fsponfee from tb_kom_spon where fidsponsor='$pID' and ffeestatus='S'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres=$oDB->f('fsponfee');
	}
	   return $vres;
   }

//Get Fee Sponsor Minggu tanpa ID
   function getWeekSponFeeNoID($pWeek,$pYear) {
   global $oDB;
   $vsql="select sum(ffee) as fsponfee from tb_kom_spon  weekofyear(ftanggal)=$pWeek and year(ftanggal)=$pYear and  ffeestatus='1'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres=$oDB->f('fsponfee');
	}
	   return $vres;
   }


//Get Fee Sponsor Minggu 
   function getWeekSponFee($pID,$pWeek,$pYear) {
   global $oDB;
   $vsql="select sum(ffee) as fsponfee from tb_kom_spon where fidsponsor='$pID' and weekofyear(ftanggal)=$pWeek and year(ftanggal)=$pYear and  ffeestatus='1'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres=$oDB->f('fsponfee');
	}
	   return $vres;
   }

//Get Fee Sponsor+MAtrix All
   function getAllMtxSpon($pID,$pTgl) {
   global $oDB;
   $vWhere="";
   if (trim($pID)!="") $vWhere="and fidsponsor = '$pID'";
   $vsql="select sum(ffee) as fsponfee from tb_kom_spon where 1 $vWhere and  ftanggal < '$pTgl'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres1=$oDB->f('fsponfee');
	}
	   return $vres=$vres1;
   }


//Get Fee Sponsor+MAtrix All tanpa ID
   function getAllMtxSponNoID() {
   global $oDB;
   $vsql="select sum(ffee) as fsponfee from tb_kom_spon where ffeestatus='1'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres1=$oDB->f('fsponfee');
	}
   $vsql="select sum(ffee) as fmtxfee from tb_kom_mtx where ffeestatus='1'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres2=$oDB->f('fmtxfee');
	}
	   return $vres=$vres1+$vres2;
   }




//Get Fee Sponsor+MAtrix Minggu
   function getWeekMtxSpon($pID,$pWeek,$pYear) {
   global $oDB;
   $vsql="select sum(ffee) as fsponfee from tb_kom_spon where fidsponsor='$pID' and weekofyear(ftanggal)=$pWeek and year(ftanggal)=$pYear and ffeestatus='1'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres1=$oDB->f('fsponfee');
	}

   $vsql="select sum(ffee) as fmtxfee from tb_kom_mtx where fidmember='$pID' and weekofyear(ftanggal)=$pWeek and year(ftanggal)=$pYear and ffeestatus='1'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres2=$oDB->f('fmtxfee');
	}
	   return $vres=$vres1+$vres2;
   }

//Get Fee Sponsor+MAtrix Minggu tanpa ID
   function getWeekMtxSponNoID($pWeek,$pYear) {
   global $oDB;
   $vsql="select sum(ffee) as fsponfee from tb_kom_spon where weekofyear(ftanggal)=$pWeek and year(ftanggal)=$pYear and ffeestatus='1'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres1=$oDB->f('fsponfee');
	}

   $vsql="select sum(ffee) as fmtxfee from tb_kom_mtx where fidmember='$pID' and weekofyear(ftanggal)=$pWeek and year(ftanggal)=$pYear and ffeestatus='1'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres2=$oDB->f('fmtxfee');
	}
	   return $vres=$vres1+$vres2;
   }


// Get All overmatrix
   function getAllOver() {
   global $oDB;
   $vsql="select sum(ffee) as foverfee from tb_overmatrix ";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres=$oDB->f('foverfee');
	}
	   return $vres;
   }


// Get  overmatrix Minggu
   function getWeekOver($pWeek, $pYear) {
   global $oDB;
   $vsql="select sum(ffee) as foverfee from tb_overmatrix where weekofyear(ftanggal)=$pWeek and year(ftanggal)=$pYear ";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres=$oDB->f('foverfee');
	}
	   return $vres;
   }

// Get All Management Fee
   function getAllManFee() {
   global $oDB;
   $vsql="select sum(ffee) as fmanfee from tb_fee_man where ffeestatus='1'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres=$oDB->f('fmanfee');
	}
	   return $vres;
   }

// Get Week Management Fee
   function getWeekManFee($pWeek, $pYear) {
   global $oDB;
   $vsql="select sum(ffee) as fmanfee from tb_fee_man where  weekofyear(ftanggal)=$pWeek and year(ftanggal)=$pYear and ffeestatus='1'";
	$oDB->query($vsql);
	while ($oDB->next_record()) {
	   $vres=$oDB->f('fmanfee');
	}
	   return $vres;
   }


// Set Fee to Active
   function activateFee($pID) {
	   global $oDB, $oSystem;
	   
	   $vsql="update tb_updown set fsponsorstatus='1' where fdownline='$pID' and fupline in (select fidmember from m_anggota where faktif=1)"; //Aktifkan Sponsorship ke Atas
	   $oDB->query($vsql);

	   $vsql="update tb_updown set fsponsorstatus='1' where fupline='$pID' and fdownline in (select fidmember from m_anggota where faktif=1)"; //Aktifkan Sponsorship Diri sendiri
	   $oDB->query($vsql);

	
	   $vsql="update tb_kom_mtx set ffeestatus='1' where fidregistrar='$pID' and fidmember in (select fidmember from m_anggota where faktif=1)"; //Aktifkan Fee Matrix ke atas
	  // $oSystem->jsAlert($vsql);
	   $oDB->query($vsql);

	   $vsql="update tb_kom_mtx set ffeestatus='1' where fidmember='$pID' and fidregistrar in (select fidmember from m_anggota where faktif=1)"; //Aktifkan Fee Matrix diri sendiri
	   $oDB->query($vsql);

	
	   $vsql="update tb_kom_spon set ffeestatus='1' where fidregistrar='$pID' and fidsponsor in (select fidmember from m_anggota where faktif=1)"; //Aktifkan Fee Sponsor ke atas
	   $oDB->query($vsql);
	
	   $vsql="update tb_kom_spon set ffeestatus='1' where fidsponsor='$pID' and  fidregistrar in (select fidmember from m_anggota where faktif=1)"; //Aktifkan Fee Sponsor diri sendiri
	   $oDB->query($vsql);
	
	   $vsql="update tb_overmatrix set ffeestatus='1' where fidregistrar='$pID' "; //Overmatrix
	   $oDB->query($vsql);
	
	   $vsql="update tb_fee_man set ffeestatus='1' where fidregistrar='$pID'"; //Fee Management
	   $oDB->query($vsql);
	   
	   
	   $oSystem->jsAlert("Success, all fee activated!");
   }

   //Masukkan fee penjualan ke jaringan
   function sendFeeProduct($pID,$pJumlah) {
    global $oDB, $oMember, $oRules,$oSystem;
	$vFirstID=$oMember->getFirstID();
	if ($oMember->isActive($pID)==1) {
	   //Ambil aturan-aturan
	   $vMaxLevel=$oRules->getRealMaxLevel(2); // Dari tb_rules_config

	   //Masukkan komisi matrix penjualan
     for ($j=0;$j<$pJumlah;$j++) {
	   for ($i=1;$i<$vMaxLevel+1;$i++) {
	      //$vUpFee=$vMaxLevel+1-$i; //Jika level dimulai dari bawah
	      $vBuyFee=$oRules->getLevelFeeByID($i,2);
		  $vIDReceiver=$this->getUplineLevel($pID,$i);
		  if ($vIDReceiver==$vFirstID)
		     $vFunderOver=$this->getUplineLevel($pID,$i-1);			 
		  if ($i==1) 
		      $vFunder=$pID;
		  else
		  	  $vFunder=$this->getUplineLevel($pID,$i-1);		 
	      if ($vIDReceiver==-1)  {
		     $vsql="insert into tb_overbuy(fidbuyer,ftanggal,fidfunder,fidmember,ffee,ffeestatus) values('$pID',now(),'$vFunderOver','$vFirstID',$vBuyFee,1)";
			 $oDB->query($vsql);    
		  } else {	   
			 $vsql="insert into tb_kom_buy(fidbuyer,ftanggal,fidfunder,fidmember,ffee,ffeestatus) values('$pID',now(),'$vFunder','$vIDReceiver',$vBuyFee,1)";   
  		  	 $oDB->query($vsql); 
		  }		 
	   } //for $i
	   } // for $j
	  // $oSystem->jsAlert("Pembelian sukses!");
	  } else {//isActive 
	   // $oSystem->jsAlert("Anda tidak memasukkan ID member dengan benar atau member tidak aktif, tidak dapat melakukan pembelian!");
	  }
   } //sendFeeProduct

   
   //Insert Penjualan 
   function insertSell($pID,$pIDProd,$pQty,$pHarga,$pTanggal) {
		global $oDB,$oSystem,$oMember;
		if ($oMember->isActive($pID)==1) {
			$vsql="insert into tb_penjualan(fidmember,fidproduk,fjumlah,fharga, ftanggal,ftglentry) ";	
			$vsql.="values('$pID','$pIDProd',$pQty,$pHarga,'$pTanggal',now()) ";	
			$oDB->query($vsql);
		} else $oSystem->jsAlert("Anda tidak memasukkan ID member dengan benar atau member tidak aktif, tidak bisa melakukan pembelian");
	}
   
		//Get deep level
  	    function getDeep($pID) {
			$vdownline=$this->getDownlineAll($pID,$vout);
			$vCount=count($vout);
			for($i=0;$i<($vCount);$i++) {
			   $vDisc=$this->getDistance($vout[$i],$pID);
			   $vArrDisc[]=$vDisc;
			}  
			if (count($vArrDisc)>0)
			   sort($vArrDisc,SORT_REGULAR); 
			$vDeep=$vArrDisc[$vCount-1];
			return $vDeep;
		}		
// Jumlah Downline level tertentu tanpa batasan titik yg mengeluarkan komisi
		function getDownlineCountLevelAll($pID,$pLevel) {
		    $this->getDownlineAll($pID,$vout);
			if (strlen($vout[0])>=1)
			   $vcout=count($vout);
			else
			   $vcout=0;  
			for ($i=0;$i<$vcout;$i++) {
	   			$vdistance= $this->getDistance($vout[$i],$pID);
	   			if ($vdistance==$pLevel) {
	      			$vjumlevel[]=$vout[$i];
	   			}
			}
			return count($vjumlevel);
		}
   
		function getTopSpon($pID, $pPeriode) {
		   global $oDB, $oPhpdate;
		   // dateDiff($interval,$dateTimeBegin,$dateTimeEnd)
		   
		   $vSQL="select a.fsponsor,  count(a.fdownline) as fcountspon from tb_updown a where a.fsponsor <> a.fdownline  and a.fsponsorstatus='1' and a.ftanggal between __ and __ group by fsponsor order by count(fdownline) desc limit 3";
		   $oDB->query($vSQL);
		   $i=0;
		   while ($oDB->next_record()) {
		      $i+=1;
			  $vres[$i]["a"]=$oDB->f("fsponsor");
			  $vres[$i]["b"]=$oDB->f("fcountspon"); 
		   }
		   
		   echo $vres[3]["b"];
		}
		
   function getPerfectCount() {
      global $oMember, $oDB;
      $vRetCount=0;
	  $vsql="select fidmember from m_anggota where faktif=1;";
	  $oDB->query($vsql);
	  while ($oDB->next_record()) {
	     $vID=$oDB->f("fidmember");
	     if ($this->isPerfect($vID,1)==1)
		    $vRetCount+=1;
	  }
	  return $vRetCount;
   }

   function getPos($pID,$pUpline) {
     $vDownL=$this->getDownLR($pUpline,"L");
     $vDownR=$this->getDownLR($pUpline,"R");
	
	 if ($this->isInNetwork($pID,$vDownL)==1)
	    return "L";
	 else	
	    return "R";
   }

   function getPosOne($pID) {
   	 global $oDB;
  	 $vSQL="select fposisi from tb_updown WHERE fdownline='$pID'";
  	 $oDB->query($vSQL);
  	 while($oDB->next_record()){
	   	 $vPos=$oDB->f('fposisi'); 
	 }
	    	
    return $vPos;
   }


   //Kirim Fee Couple
   function sendFeeCouple($pID,$pNom,$db) {
       global $oRules, $dbin, $oSystem,$oMember;
	   $vFixID=$pID;
	   $vFirstID=$oMember->getFirstID();
	   $vCouple=$oRules->getSettingByField("ffeecouple",1);
	   $vFeeAdmin=$oRules->getSettingByField('fbyyadmin');
	   
	   //$vCouple=$pNom * $vCouple / 100;
	   //$vFlush=$oRules->getSettingByField("fcountflush",1);
	   $vFlush=12;
	   //$vDisctance=$this->getDistance($pID,$vFirstID);	
	   //if ($vDisctance > 10) $vDisctance = 10;
	   //Ambil upline paling atas, max 10 level
	   $vTop10=$this->getUplineLevel10($vFixID);
	   $vDisctance=$this->getDistance($vFixID,$vTop10);	
	   $vLevel=0;
       for ($i=0;$i<$vDisctance;$i++) { 
	      $vLevel=$i+1;
		  $vCoupleFinal=0;
		  $pID=$this->getUpline($pID);
		 // $oSystem->jsAlert("Upline Lv $vLevel: $pID");
		  $vCountCouple=$this->getCountCoupleByDate($pID,date("Y-m-d"));
		  //$oSystem->jsAlert($vCountCouple);
		//  if ($vCountCouple<=$vFlush) { //Check flush out
		  if (true) { //Check flush out
		     $vPos=$this->getPos($vFixID,$pID);
			// $oSystem->jsAlert("Posisi $vFixID terhadap $pID : $vPos");
			 //Ambil jumlah doenline kiri dan kanan
			echo  "L:".$vCountL=$this->getDownlineCountLRLevel($pID,"L",$vLevel);
			echo "<br>";
			 
			  echo  "R:".$vCountR=$this->getDownlineCountLRLevel($pID,"R",$vLevel);
			echo "<br>";  
			 
			 //$vCountL=$this->getDownlineCountLR($pID,"L");
			 //$vCountR=$this->getDownlineCountLR($pID,"R");
			 
			 //kembalikan jumlah sebelumnya
			 if ($vPos=="L") $vCountL-=1;
			 if ($vPos=="R") $vCountR-=1;			 
			// $oSystem->jsAlert("CountL: $vCountL, CountR: $vCountR");
			 if (($vPos=="L") && ($vCountL < $vCountR)) {
			    $vNomCoup=$vCountL * $pNom;
				
			    //masukkan komisi disini
				 
				$vPartner=$this->getFirstDownLevelPos($pID,$vLevel,'R');
				/* $vInvest=$oMember->getInvest($vPartner);
				 $vInvPart=$vInvest['nom'];
				 $vInvest=$oMember->getInvest($vFixID);
				 $vInvSelf=$vInvest['nom']; */
				 $vCoupleFinal=$vCountL * $pNom;
				
	$vProsenNex=$oRules->getSettingByField('fprosencash');
	$vProsenRO=$oRules->getSettingByField('fprosenauto');

	$vCoupleFinalRO=$vCoupleFinal * $vProsenRO / 100;
	$vCoupleFinal=$vCoupleFinal * $vProsenNex / 100;
				 
				 $vCoupleFinalAdm=$vCoupleFinal * $vFeeAdmin /100;
				 $vCoupleFinal = $vCoupleFinal - $vCoupleFinalAdm;
				
				 //$oSystem->jsAlert("Masuk Kiri, InvSelf ($vFixID):$vInvSelf, InvPartner($vPartner):$vInvPart, FeeCouple:$vCoupleFinal");
				 $vsql="insert into tb_kom_couple(fidreceiver,fidregistrar,fidcouple,ffee,ftanggal,flr,ffeestatus) values ('$pID','$vFixID','$vPartner',$vCoupleFinal,now(),'L',1)"; //Masukkan komisi sponsor
				 $dbin->query($vsql);   
	
				 $vsql="insert into tb_couple(fidmember,fidcouple,flevel,fpos,ftglentry) ";
				 $vsql.="values('$vFixID','$vPartner',$vLevel,'L',now())";
				 $dbin->query($vsql);   
				 

			$vLastBal=$oMember->getMemField('fsaldovcr',$pID);
			$vNewBal=$vLastBal + $vCoupleFinal;
			$vUserL=$_SESSION['LoginUser'];
			$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax) "; 
			$vsql.="values ('$pID', '$vFixID', now(),'Bonus pairing dari pasangan $vFixID|$vPartner' , $vCoupleFinal,0 ,$vNewBal ,'pairing' , '1','$vFixID' , now(),0) "; 
			$db->query($vsql); 
			$oMember->updateBalConn($pID,$vNewBal,$db);

			$vLastBal=$oMember->getMemField('fsaldoro',$pID);
			$vNewBal=$vLastBal + $vCoupleFinalRO;

			$vsql="insert into tb_mutasi_ro (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax) "; 
			$vsql.="values ('$pID', '$vFixID', now(),'Bonus pairing dari pasangan $vFixID|$vPartner' , $vCoupleFinalRO,0 ,$vNewBal ,'pairing' , '1','$vFixID' , now(),$vSponFeeAdm) "; 
			$db->query($vsql); 
			$oMember->updateBalConnRO($pID,$vNewBal,$db);
				 
				 
			 }
 
 			 if (($vPos=="R") && ($vCountR < $vCountL)) {
			    //masukkan komisi disini
				
			     $vPartner=$this->getFirstDownLevelPos($pID,$vLevel,'L');
			/*	 $vInvest=$oMember->getInvest($vPartner);
				 $vInvPart=$vInvest['nom'];
				 $vInvest=$oMember->getInvest($vFixID);
				 $vInvSelf=$vInvest['nom'];
				 $vCoupleFinal=($vInvPart+$vInvSelf) * $vCouple /100; */

				  $vCoupleFinal=$vCountR * $pNom;
				
	$vProsenNex=$oRules->getSettingByField('fprosencash');
	$vProsenRO=$oRules->getSettingByField('fprosenauto');

	$vCoupleFinalRO=$vCoupleFinal * $vProsenRO / 100;
	$vCoupleFinal=$vCoupleFinal * $vProsenNex / 100;
				 
				 $vCoupleFinalAdm=$vCoupleFinal * $vFeeAdmin /100;
				 $vCoupleFinal = $vCoupleFinal - $vCoupleFinalAdm;
				
				 //$oSystem->jsAlert("Masuk Kiri, InvSelf ($vFixID):$vInvSelf, InvPartner($vPartner):$vInvPart, FeeCouple:$vCoupleFinal");
				 $vsql="insert into tb_kom_couple(fidreceiver,fidregistrar,fidcouple,ffee,ftanggal,flr,ffeestatus) values ('$pID','$vFixID','$vPartner',$vCoupleFinal,now(),'R',1)"; //Masukkan komisi sponsor
				 $dbin->query($vsql);   
	
				 $vsql="insert into tb_couple(fidmember,fidcouple,flevel,fpos,ftglentry) ";
				 $vsql.="values('$vFixID','$vPartner',$vLevel,'L',now())";
				 $dbin->query($vsql);   
				 

			$vLastBal=$oMember->getMemField('fsaldovcr',$pID);
			$vNewBal=$vLastBal + $vCoupleFinal;
			$vUserL=$_SESSION['LoginUser'];
			$vsql="insert into tb_mutasi (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax) "; 
			$vsql.="values ('$pID', '$vFixID', now(),'Bonus pairing dari pasangan $vFixID|$vPartner' , $vCoupleFinal,0 ,$vNewBal ,'pairing' , '1','$vUserL' , now(),0) "; 
			$db->query($vsql); 
			$oMember->updateBalConn($pID,$vNewBal,$db);

			$vLastBal=$oMember->getMemField('fsaldoro',$pID);
			$vNewBal=$vLastBal + $vCoupleFinalRO;

			$vsql="insert into tb_mutasi_ro (fidmember, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate,fincometax) "; 
			$vsql.="values ('$pID', '$vFixID', now(),'Bonus pairing dari pasangan $vFixID|$vPartner' , $vCoupleFinalRO,0 ,$vNewBal ,'pairing' , '1','$vFixID' , now(),$vSponFeeAdm) "; 
			$db->query($vsql); 
			$oMember->updateBalConnRO($pID,$vNewBal,$db);			 }

		  }//Flush
	   }//Loop
	   
   }
   
  
  function sendFeeCoupEx($pID,$vPartner,$pRegistrar,$vCoupleFinal,$pLR) {
	   global $dbin;
	   //Masukkan komisi matrix
	   for ($i=1;$i<10;$i++) {
	     // $vUpFee=$vMaxLevel+1-$i; //Jika level dimulai dari bawah
	     
		  $vIDReceiver=$this->getUplineLevel($pID,$i);
          if ($vIDReceiver != -1) {
		      $vsql="insert into tb_kom_couple(fidreceiver,fidregistrar,fidcouple,ffee,ftanggal,flr,ffeestatus) values ('$vIDReceiver','$pRegistrar','$vPartner',$vCoupleFinal,now(),'$pLR',1)"; //Masukkan komisi sponsor
		      $dbin->query($vsql); 
		  }
	   }
		  
  }
   
      //Masukkan komisi Matching
   function sendFeeMatch($pID) {
	
   	   global $oDB, $oMember, $oRules,$oSystem;
   	   $vFirstID=$oMember->getFirstID();
	   $vMaxLevel=$oRules->getRealMaxLevel(2);

	   for ($i=1;$i<$vMaxLevel+1;$i++) {
		  $vIDReceiver=$this->getSponLevel($pID,$i);
		  $vMatchFee=$oRules->getLevelFeeByID($i,2);
		  if ($vIDReceiver==$vFirstID)
		     $vFunderOver=$this->getSponLevel($pID,$i-1);			 
		  if ($i==1) 
		      $vFunder=$pID;
		  else
		  	  $vFunder=$this->getSponLevel($pID,$i-1);		 
	      if ($vIDReceiver==-1)  {
		     $vsql="insert into tb_overmatch(fidregistrar,ftanggal,fidfunder,fidreceiver,ffee) values('$pID',now(),'$vFunderOver','$vFirstID',$vMatchFee)";
			 $oDB->query($vsql);    
		  } else {	   
			 $vsql="insert into tb_kom_match(fidregistrar,ftanggal,fidfunder,fidreceiver,ffee) values('$pID',now(),'$vFunder','$vIDReceiver',$vMatchFee)";   
  		  	 $oDB->query($vsql); 
			    
		  }		 
		 
	  }
   
    //$oSystem->jsAlert("Komisi Matching dan OverMatch sudah diupdate!");
   }

//  Downspon level tertentu
		function getSponsorLevel($pID,$pLevel) {
		    $this->getSponsorAll($pID,$vout);
			if (strlen($vout[0])>=1)
			   $vcout=count($vout);
			else
			   $vcout=0;  
			for ($i=0;$i<$vcout;$i++) {
	   			$vdistance= $this->getDistanceSpon($vout[$i],$pID);
	   			if ($vdistance==$pLevel) {
	      			$vjumlevel[]=$vout[$i];
	   			}
			}
			return $vjumlevel;
		}

//  Downspon level tertentu by Tanggal 
		function getSponsorLevelDate($pID,$pLevel,$pDateFrom,$pDateTo) {
		    global $oMember, $oPhpdate;
		    $this->getSponsorAll($pID,$vout);
			if (strlen($vout[0])>=1)
			   $vcout=count($vout);
			else
			   $vcout=0;  
			for ($i=0;$i<$vcout;$i++) {
	   			$vdistance= $this->getDistanceSpon($vout[$i],$pID);
				$vDateExtend=$oMember->getExtendDate($vout[$i]);
				$vDateExtend=substr($vDateExtend,0,10);
				$vDateFrom=substr($pDateFrom,0,10);
				$vDateTo=substr($pDateTo,0,10);
	   			if ($vdistance==$pLevel && $vDateExtend>=$vDateFrom && $vDateExtend<=$vDateTo) {
	      			$vjumlevel[]=$vout[$i];
	   			}
			}
			return $vjumlevel;
		}

		//Get kedalaman sponsor
  	    function getDistanceSpon($pID,$pSpon) {
			$vdeep=1;
   			$vres=$this->getSponsor($pID);			
			while (!preg_match('/'.strtolower($vres).'/',strtolower($pSpon))) {			
				$vres=$this->getSponsor($vres);
				$vdeep+=1;	
			}
		   return $vdeep;
		}		

		//Hitung Sponsor Semua
		function getSponsorAll($pID,&$vout) {
			$vcount=0;
			$vsql="select fdownline from tb_updown where fsponsor='$pID'";	
			$vres=mysql_query($vsql);
			while ($rsDownline = mysql_fetch_array($vres)) {
			 $vcount+=1;
			 $vdown = $rsDownline['fdownline'];		 
			 $vout[]=$vdown;
			 $vdown=$this->getSponsorAll($vdown,$vout);	  
			}
			   return $vdown;   
		}

        //ambil posisi diri L/R
		function iamLR($pID) {
            global $oDB; 
			$vres="";
		    $vsql="SELECT fkakike from tb_updown where fdownline='$pID' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vres = $oDB->f("fkakike");
			}
			if ($vres != "")
	  		   return $vres;
			else
			   return -1;   
		}

           //Downline langsung dibawahnya dengan Index kaki
		function getDownlineKaki($pID) {
            global $oDB;
			$vres="";
		    $vsql="SELECT fdownline,fkakike  from tb_updown where fupline='$pID'  ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vKakike=$oDB->f("fkakike");
			   $vres[$vKakike]=$oDB->f("fdownline");
			}
	  		 return $vres;
		}
		
		
           //Downline langsung dibawahnya dengan Index kaki
		function getDownlinePos($pID) {
            global $oDB;
			$vres="";
		    $vsql="SELECT fdownline,fposisi  from tb_updown where fupline='$pID'  ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			   $vPosisi=$oDB->f("fposisi");
			   $vres[$vPosisi]=$oDB->f("fdownline");
			}
	  		 return $vres;
		}		
		//Get deep level
  	    function getDeepSpon($pID) {
			$vdownline=$this->getSponsorAll($pID,$vout);
			$vCount=count($vout);
			for($i=0;$i<($vCount);$i++) {
			   $vDisc=$this->getDistanceSpon($vout[$i],$pID);
			   $vArrDisc[]=$vDisc;
			}  
			if (count($vArrDisc)>0)
			   sort($vArrDisc,SORT_REGULAR); 
			$vDeep=$vArrDisc[$vCount-1];
			return $vDeep;
		}		
   // Jumlah SPon level tertentu tanpa batasan titik yg mengeluarkan komisi
		function getSponsorCountLevelAll($pID,$pLevel) {
		    $this->getSponsorAll($pID,$vout);
			if (strlen($vout[0])>=1)
			   $vcout=count($vout);
			else
			   $vcout=0;  
			for ($i=0;$i<$vcout;$i++) {
	   			$vdistance= $this->getDistanceSpon($vout[$i],$pID);
	   			if ($vdistance==$pLevel) {
	      			$vjumlevel[]=$vout[$i];
	   			}
			}
			return count($vjumlevel);
		}

 	//Ambil Nama Reward dari nilai
   function getRewardFromNominal($pNom) {
		global $dbin1;
		$vsql="select freward from m_rewards where fnominal <= $pNom order by flevel desc";	
		$dbin1->query($vsql);
		$dbin1->next_record();
		$vres=$dbin1->f("freward");
		
		if ($vres!="")
		   return $vres;
		else
		   return 0;  
	}  

function getCFDate($vUser,$pDate) {
		 $vKakiL=$this->getDownLR($vUser,'L');
		 $vKakiR=$this->getDownLR($vUser,'R');
		 $vDateNow=$pDate;
		if ($vKakiL !=-1 && $vKakiL !='') {
			$OmzetDownL=$this->getDownlineCountActivePeriod($vKakiL,$vDateNow,$vDateNow);
			
		} else	{
			$OmzetDownL=0;
			
		}
			
		if ($vKakiR !=-1 && $vKakiR !='') {
			$OmzetDownR=$this->getDownlineCountActivePeriod($vKakiR,$vDateNow,$vDateNow);
			
		} else	{
			$OmzetDownR=0;
		}	
		
		$vRes['L'] = $OmzetDownL;
		$vRes['R'] = $OmzetDownR;
		
		return $vRes;
	
}

	//Array cangkokan
	function getArrayCangkok() {
		global $oMember;
		$vcount=0;$vCangkok="";

			$vsql="select fidmember from tb_cangkok  ";	
			$vres=mysql_query($vsql);
			while ($rsCangkok = mysql_fetch_array($vres)) {
			  $vCangkok[] = $rsCangkok['fidmember'];
			}

		   return $vCangkok;   
	
	}
  
 } //Class   
   
   $oNetwork = new network;
   $oMemSort=new cMember;
   ?>