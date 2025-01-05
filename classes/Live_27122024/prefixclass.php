<?php

   class prefix {
        //ambil nama prefix dari ID yang diketahui
		function getPrefixName($pIDPrefix) {
            global $oDB; 
		    $result="";
			$vsql="SELECT fprefix from tb_prefix where fidprefix='$pIDPrefix' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $result = $oDB->f("fprefix");
			}
			if ($result != "")
	  		   return $result;
			else
			   return -1;   
		}
      //ambil ID prefix dari nama yang diketahui
		function getPrefixID($pPrefix) {
            global $oDB; 
		    $result="";
			$vsql="SELECT fidprefix from tb_prefix where fprefix='$pPrefix' ";	
			$oDB->query($vsql);
			while ($oDB->next_record()) {
			    $result = $oDB->f("fidprefix");
			}
			if ($result != "")
	  		   return $result;
			else
			   return -1;   
		}

      //Tambah prefix
		function insertPrefix($pPrefix) {
            global $oDB; 
		    $result="";
			$vsql="INSERT INTO tb_prefix(fprefix) values('$pPrefix') ";	
			if ($this->getPrefixID($pPrefix)==-1) {
			   $oDB->query($vsql);
			   $result=0;
			} else
			   $result=-1;
   		    return $result;
		}

      //Tambah prefix
		function delPrefix($pPrefix) {
            global $oDB; 
		    $result="";
			$vsql="DELETE FROM tb_prefix where fprefix='$pPrefix'";	
			if ($this->getPrefixID($pPrefix)!=-1) {
			   $oDB->query($vsql);
			   $result=0;
			} else
			   $result=-1;
   		    return $result;
		}
   }

   $oPrefix=new prefix;

?>