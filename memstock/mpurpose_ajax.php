<?

session_start();
ini_set('display_errors', true);
error_reporting(E_ERROR);
include_once("../server/config.php");
$vUser=$_SESSION['LoginUser'];

//print_r($_POST);



   include_once("../classes/memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once(CLASS_DIR."ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."systemclass.php");
   include_once(CLASS_DIR."productclass.php");
   include_once(CLASS_DIR."texttoimageclass.php");


   $vOp=$_GET['op'];

  if ($vOp=='countkui' ) {
	    $vYear = $_GET['year'];
		$vMonth = $_GET['month'];
		echo $vCounterInv = $oMember->getKuiCount($vYear,$vMonth);		
  }  else if ($vOp=='printkui') {
	    $vYear = $_GET['year'];
		$vMonth = $_GET['month'];
	  
		$vMemId = $_POST['mem'];	  
		$vKuiId = $_POST['kuiid'];
		$vKuiIdHis = str_pad($vKuiId,4,'0',STR_PAD_LEFT)."/".date('m/Y')."/AMINAH TOUR";
		$vPayFor = $_POST['payfor'];
		$vNom = $_POST['nom'];
		$vJenis = 'KUI';
		
		$vSQLIn ="INSERT INTO `tb_print_invkui` ( `fjenis`, `fidmember`, `fnoinvkui`, `fpayfor`, `fnominal`, `ftglentry`, `fuserid`) VALUES ( '$vJenis ', '$vMemId', '$vKuiIdHis', '$vPayFor', $vNom, CURRENT_TIMESTAMP, '{$_SESSION['LoginUser']}')";
		$db->query($vSQLIn);
		
		
		$vSQLUpd = "update tb_idcounter set  fvaluekui=$vKuiId where fyear='$vYear' and fmonth='$vMonth' ";
		
		$vUpd=$db->query($vSQLUpd);
		
		if ($vUpd)
		echo 'kuisuccess';
		
		
  } else if ($vOp=='countinv' ) {
	    $vYear = $_GET['year'];
		$vMonth = $_GET['month'];
		echo $vCounterInv = $oMember->getInvCount($vYear,$vMonth);		
  } else if ($vOp=='printinv') {
	    $vYear = $_GET['year'];
		$vMonth = $_GET['month'];
	  
		$vMemId = $_POST['mem'];	  
		$vInvId = $_POST['invid'];
		$vInvIdHis = "INVAMH.".date('Y.m').".".str_pad($vInvId,4,'0',STR_PAD_LEFT);
		$vPayFor = $_POST['payfor'];
		$vNom = $_POST['nom'];
		$vNomin = $_POST['nomin'];
		$vJenis = 'INV';
		
		$vSQLIn ="INSERT INTO `tb_print_invkui` ( `fjenis`, `fidmember`, `fnoinvkui`, `fpayfor`, `fnominal`, `ftglentry`, `fuserid`,`fnomin`) VALUES ( '$vJenis ', '$vMemId', '$vInvIdHis', '$vPayFor', $vNom, CURRENT_TIMESTAMP, '{$_SESSION['LoginUser']}',$vNomin)";
		$db->query($vSQLIn);
		
		
		$vSQLUpd = "update tb_idcounter set  fvalueinv=$vInvId where fyear='$vYear' and fmonth='$vMonth' ";
		
		$vUpd=$db->query($vSQLUpd);
		
		if ($vUpd)
		echo 'invsuccess';
		
		
  }

 

 ?> 

