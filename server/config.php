<?php
    $vHost=$_SERVER['HTTP_HOST'];
 //$vRoot=getcwd().'/';
 if (preg_match("/trial.amhtechno/i",$vHost))
 		$vRoot='/home/amhtechno/public_html/trial.amhtechno.com/';
 else		
 		$vRoot='/home/amhtechno/public_html/intern.amhtechno.com/';
		//$vRoot='/home/coidotoko/public_html/xsystem/';
 

 
 $vRootWeb='/';
  $vRoot."classes/phplib.php";
 
 include_once $vRoot."classes/phplib.php";
 define('DOC_ROOT', $vRoot); 
 
 $vHost=$_SERVER['HTTP_HOST'];
 define('CLASS_DIR', DOC_ROOT.'classes/');
 $CLASS_DIR = DOC_ROOT.'classes/';
 include_once($CLASS_DIR."systemclass.php");

  if (preg_match("/training.amhtechno/i",$vHost)){  
        class DB_Example extends DB_MySQL {
			var $Host     = "localhost";
			var $Database = "amhtechn_intrain";
			var $User     = "amhtechn_intrain";
			var $Password = "j4l4nm4sihp4nj4ng";     
        }
        $vMarkDev="TRAINING SITE";
  } else if (preg_match("/trial.amhtechno/i",$vHost)){ 
        class DB_Example extends DB_MySQL {
			var $Host     = "localhost";
			var $Database = "amhtechn_intrial";
			var $User     = "amhtechn_intrial";
			var $Password = "j4l4nm4sihp4nj4ng";
        }
        $vMarkDev="TESTING DEV SITE";
  } else {  
		  class DB_Example extends DB_MySQL {
			var $Host     = "localhost";
			var $Database = "amhtechn_intern";
			var $User     = "amhtechn_intern";
			var $Password = "j4l4nm4sihp4nj4ng";
		  }
         $vMarkDev="";
  }



  

  class DB_AMHTechno extends DB_MySQL {
	var $Host     = "localhost";
	var $Database = "amhtechn_amhtechno";
	var $User     = "amhtechn_amhtech";
	var $Password = "Aminah?Techno+2019";
  }



	$db=new DB_Example;
	$dbin=new DB_Example;
	$db1=new DB_Example;
    $dbmenu=new DB_Example;
    $dbmenuin=new DB_Example;
    
	$dbin1=new DB_Example;
	$dbtime=new DB_Example;
	$oDB=new DB_Example;	
	$host = $db->Host;
	$user = $db->User;
	$passwd = $db->Password;
	$dataBase=$db->Database;
	
	
	$oDBAMHT=new DB_AMHTechno;
	$oDBAMHTIn=new DB_AMHTechno;

	 $oSystem->insertLog();


	$conn = @mysql_connect($host,$user,$passwd);

	@mysql_select_db($dataBase,$conn);

	if ($_SESSION['LoginUser'] !='') {
		$vLogin = $_SESSION['LoginUser'] ;
		
		
		
		$vSQL = "update m_admin set  flastactive=now() where fidmember='$vLogin'";
		$db->query($vSQL);
		$vSQL = "update m_anggota set  flastactive=now() where fidmember='$vLogin'";
		$db->query($vSQL);
		
	}
	
	
?>
