<?php

include_once CLASS_DIR."ruleconfigclass.php";   
include_once CLASS_DIR."memberclass.php";   
include_once CLASS_DIR."systemclass.php";   

   class interfaces {
    function getTitle($pName) {
	    global $oDB;
		$vsql="select fheader from tb_content where fname='$pName'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('fheader');
		}
		return $vres;
	}   
  //Ambil menu
    function getMenu($pGroup='') {
	    global $oDB;
		 $vsql="select fname from tb_content where fgroup='$pGroup' and fstatusrow='1'  order by fdesc ";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres[]=$oDB->f('fname');
		}
		return $vres;
	}   

  //Ambil Group
    function getGroup() {
	    global $oDB;
		 $vsql="select fgroupid from tb_contgroup where factive='1' order by fgroupname ";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres[]=$oDB->f('fgroupid');
		}
		return $vres;
	}   

  
//get Deskripsi menu
    function getMenuDesc($pMenu) {
	    global $oDB;
		 $vsql="select fdesc from tb_content where fname='$pMenu'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('fdesc');
		}
		return $vres;
	}   


//get Deskripsi Group
    function getGroupDesc($pGroup) {
	    global $oDB;
		 $vsql="select fgroupname from tb_contgroup where fgroupid='$pGroup'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('fgroupname');
		}
		return $vres;
	}  
//get Header menu
    function getMenuHeader($pMenu) {
	    global $oDB;
		 $vsql="select fheader from tb_content where fname='$pMenu'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('fheader');
		}
		return $vres;
	}   

//get Font Color menu
    function getMenuColor($pMenu) {
	    global $oDB;
		 $vsql="select fcolor from tb_content where fname='$pMenu'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('fcolor');
		}
		return $vres;
	}   

  
  //get Background Color menu
    function getMenuBgColor($pMenu) {
	    global $oDB;
		 $vsql="select fbgcolor from tb_content where fname='$pMenu'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('fbgcolor');
		}
		return $vres;
	}   

  //get isi menu
    function getMenuContent($pMenu,$pLang='') {
	    global $oDB;
		if ($pLang=='id' || $pLang=='')
		   $vField = 'fcontent';
		else $vField='fcontenten';   
		 $vsql="select $vField from tb_content where fname='$pMenu'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f($vField);
		   $vCopy=substr($vres,0,3);
		   if ($vCopy=='<p>') {
			  $vres = substr($vres,3,-4);   
		   }
		}
		return $vres;
	}   

  //get Height
    function getHeight($pMenu) {
	    global $oDB;
		 $vsql="select fheight from tb_content where fname='$pMenu'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('fheight');
		}
		return $vres;
	}   

  //get Background Color menu
    function updateMenu($pMenu,$pDesc,$pHeader,$pColor,$pBgColor,$pContent,$pHeight) {
	    global $oDB;
		//$vContent=addslashes($pContent);
		 $vsql="update tb_content set fdesc='$pDesc', fheader='$pHeader',fcolor='$pColor',fbgcolor='$pBgColor', fcontent='$pContent',fheight='$pHeight' where fname='$pMenu'";
		if($oDB->query($vsql))
		   return 1;
		   else return 0;
		
	}   

  //check menu
    function checkMenu($pMenu) {
	    global $oDB;
		$vsql="select fname from tb_content where fname='$pMenu'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('fname');
		}
		
		if ($vres!="")
		  return 1;
		else
		  return -1 ; 
	}   

  function updateBgColorAll($pColor) {
  	 	global $oDB;
		$vsql="update tb_content set fbgcolor='$pColor'";
		$oDB->query($vsql);
  } 
   

  function displayNews($pSticky,$pLimit) {
  	 	global $oDB;
		$vres="";
		$vsql="select * from tb_news where fsticky='$pSticky' order by ftgl desc limit 0,$pLimit";
		$oDB->query($vsql);
		
		while ($oDB->next_record()) {
		   $vres['inewsid'][]=$oDB->f('fnewsid');
		   $vres['itgl'][]=$oDB->f('ftgl');
		   $vres['iheader'][]=$oDB->f('fheader');
		   $vres['ibody'][]=$oDB->f('fbody');
		}
		
		return $vres;
  } 


  function formatPreview($pContent,$pURL) {
		if (strlen($pContent)>100) {
			$vres=substr($pContent,0,100)."....</p>";
			$vres.="<a href='#' onClick=\"window.open('$pURL','News','width=700,height=600,top=50,left=100,scrollbars=1')\">Selengkapnya</a>";
			return $vres;
		} else return $pContent;
  } 

  function prevContent($pContent,$pChar) {
		if (strlen(strip_tags($pContent,"<img>"))>($pChar+400)) {
			$vres=substr(strip_tags($pContent,"<img>"),0,($pChar+400)).".....";
			
			return $vres;
		} else return $pContent;
  } 

  function prevContentAll($pContent,$pChar) {
		if (strlen($pContent)>($pChar+400)) {
			$vres=substr($pContent,0,($pChar+400)).".....";
			
			return $vres;
		} else return $pContent;
  } 

  function prevContentNews($pContent,$pChar) {
		 $vAll=strlen($pContent);
		 $vTags=strlen($pContent)-strlen(strip_tags($pContent));
		 $vClean=$vAll-$vTags;
         //if ($vClean>1000) $pChar-=100;
         // echo ($vClean - $vTags); 
		if ($vClean > $pChar) {
			$vres=substr(strip_tags($pContent,"<img>"),0,$pChar).".....";
			return $vres;
		} else return $pContent; 
  } 

function prevContentOri($pContent,$pChar,$pURL) {
		if (mb_strlen(strip_tags($pContent,"<img><style>"),'UTF-8')>($pChar)) {
			$vres=substr(strip_tags($pContent,"<img><style>"),0,($pChar)).".....";
			$vres.="<a style='color:#00F;font-size:11px;font-weight:bold' href='$pURL'> Selengkapnya&nbsp;>> </a>";
			return $vres;
		} else return $pContent;
  } 

  function formatArtikel($pContent,$pURL) {
        
		$vres="<strong><a href=\"$pURL\" target=\"_blank\">$pContent</a></strong>";
		return $vres;

  } 

  //ambil title menu
    function getMenuTitle($pMenuID,$pDefault='') {
	    global $oDB;
		$vsql="select menu_title from m_menu where menu_id='$pMenuID'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('menu_title');
		}
		
		if ($vres!="")
		  return $vres;
		else
		  return -1 ; 
	}   
	
  //ambil title menu
    function getMenuTitleMem($pMenuID,$lang='id') {
	    global $oDB;
		$vsql="select flangtext from m_lang_$lang where flangid='$pMenuID'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('flangtext');
		}
		
		if ($vres!="")
		  return $vres;
		else
		  return -1 ; 
	}   	

	function addSpace($pCount) {
	   for ($i=0;$i<$pCount;$i++) 
	       echo "&nbsp;";
	}


  //get head news
    function getNewsHeader($pId) {
	    global $oDB;
		$vsql="select fheader from tb_news where fnewsid='$pId'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('fheader');
		}
		return $vres;
	}   

  //get isi news
    function getNewsContent($pId) {
	    global $oDB;
		 $vsql="select fbody from tb_news where fnewsid='$pId'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('fbody');
		}
		return $vres;
	}   


function convertYoutube($string) {
	
    return preg_replace(
        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
        "<iframe src=\"//www.youtube.com/embed/$2?rel=0\" allowfullscreen></iframe>",
        $string
    );
}

 //ambil kata
    function getWord($pWordId,$pLang,$pDefault) {
	    global $oDB;
		$vLang=strtolower($pLang);
		$vsql="select flangtext from m_lang_$vLang where flangid='$pWordId'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('flangtext');
		}
		
		if ($vres=="")
		  return "Notfound $pLang: ".$pDefault;
		else
		  return $vres ; 
	}   
	
	
	function getImgSrc($pHTML) {
	    preg_match('/<img(.*)src(.*)=(.*)"(.*)"/U', $pHTML, $result);
		return array_pop($result);	
	}
	
	function embedYoutube($string) {
		return preg_replace(
			"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
			"<iframe frameborder='0' src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>",
			$string
		);
	}
	
	//get Caption
    function getCaptionLang($pMenu,$pLang) {
	    global $oDB;
		$vsql="select menu_id, menu_title, menu_title_en from m_menu where menu_id='$pMenu'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('menu_title');
		   $vresen=$oDB->f('menu_title_en');
		}
		
		if ($pLang=="id")
		   return $vres;
		else if ($pLang=="en")   
		   return $vresen;
	}   


   //list kota voucher/tour
   function getKotaCnt($pCnt) {
	    global $oDB;
		$vsql="select * from m_kotav where faktif=1 and fidcountry='$pCnt' and fnamakota not like '%pilih%' order by fnamakota;";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres['id'][]=$oDB->f('fidsys');
		   $vres['nama'][]=$oDB->f('fnamakota');
		}
		return $vres;
   }

   //list kota 
   function getKota($pIDSys) {
	    global $oDB;
		$vsql="select * from m_kotav where faktif=1 and fidsys='$pIDSys'  order by fnamakota;";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   
		   $vres=$oDB->f('fnamakota');
		}
		return $vres;
   }


   //list kota voucher/tour
   function getKotaCntHon($pCnt) {
	    global $oDB;
		$vsql="select * from m_kotav where ftourbul=1 and faktif=1 and fidcountry='$pCnt' and fnamakota not like '%pilih%' order by fnamakota;";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres['id'][]=$oDB->f('fidsys');
		   $vres['nama'][]=$oDB->f('fnamakota');
		}
		return $vres;
   }


  //get isi overview
    function getOvervLang($pId,$pLang) {
	    global $oDB;
		 $vsql="select foverv, foverven from m_tour where fidtour='$pId'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('foverv');
		   $vresen=$oDB->f('foverven');
		}
		if ($pLang=="id")
		   return $vres;
		else if ($pLang=="en")   
		   return $vresen;
	}   

  //get isi detail
    function getDetailLang($pId,$pLang) {
	    global $oDB;
		 $vsql="select fdetail, fdetailen from m_tour where fidtour='$pId'";
		$oDB->query($vsql);
		while ($oDB->next_record()) {
		   $vres=$oDB->f('fdetail');
		   $vresen=$oDB->f('fdetailen');
		}
		if ($pLang=="id")
		   return $vres;
		else if ($pLang=="en")   
		   return $vresen;
	}   

}//class

$oInterface = new interfaces; 
?>