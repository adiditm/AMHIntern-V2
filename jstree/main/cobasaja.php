<?
session_start();
ini_set('display_errors', true);
error_reporting(E_ERROR);
include_once("../server/config.php");

//print_r($_POST);

   include_once(CLASS_DIR."memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once("../classes/networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once(CLASS_DIR."ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."systemclass.php");
   include_once(CLASS_DIR."productclass.php");
   include_once(CLASS_DIR."texttoimageclass.php");
   
   $vGetWil=$_GET['wil'];
   $vWilID=$_GET['kodewil'];
   $vCountry=$_GET['neg'];
   $vOp=$_GET['op'];
   $vKitMem=$_POST['serno'];
    $vKitSpon=$_POST['sernospon'];
   
 
  //  if ($oMember->authActiveID($vKitSpon)==1)
  //     echo 'yes';
   // else echo 'no';   
 // echo "L:".$oNetwork->get1stSponsorshipLR('UNEEDS5','L')."<br>";
 // echo "R:".$oNetwork->get1stSponsorshipLR('UNEEDS5','R');
 // echo $oNetwork->isInNetwork('UEC960562159','UBC496772508');
 
echo "sssssssss". $oKomisi->getOmzetROWholeMemberByDate('UFC773699955','2015-11-02','2015-11-02');
 
 ?> 
