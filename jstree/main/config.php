<?php
  
 //$vRoot=getcwd().'/';
 $vRoot='/home/spek8237/public_html/xsystem/';
 $vRootWeb='/home/spek8237/public_html/';
  $vRoot."classes/phplib.php";
 
 include_once $vRoot."classes/phplib.php";
 define('DOC_ROOT', $vRoot); 
 
 $vHost=$_SERVER['HTTP_HOST'];
 define('CLASS_DIR', DOC_ROOT.'classes/');
 $CLASS_DIR = DOC_ROOT.'classes/';
 include_once($CLASS_DIR."systemclass.php");
 $oSystem->insertLog();
  class DB_Example extends DB_MySQL {
	var $Host     = "localhost";
	var $Database = "spek8237_spectra";
	var $User     = "spek8237_spectra";
	var $Password = "j4l4nm4sihp4nj4ng";
  }





	$db=new DB_Example;
	$dbin=new DB_Example;
	$db1=new DB_Example;

	$dbin1=new DB_Example;
	$dbtime=new DB_Example;
	$oDB=new DB_Example;	
	$host = $db->Host;
	$user = $db->User;
	$passwd = $db->Password;
	$dataBase=$db->Database;


	$conn = @mysql_connect($host,$user,$passwd);
	@mysql_select_db($dataBase,$conn);


	
	
?>