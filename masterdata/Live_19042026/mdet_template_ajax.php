<?
session_start();
ini_set('display_errors', true);
error_reporting(E_ERROR);
include_once("../server/config.php");
include_once("../classes/memberclass.php");
$vUser=$_SESSION['LoginUser'];

//print_r($_POST);

   include_once(CLASS_DIR."memberclass.php");
   include_once(CLASS_DIR."dateclass.php");
   include_once(CLASS_DIR."networkclass.php");
   include_once(CLASS_DIR."ifaceclass.php");
   include_once(CLASS_DIR."ruleconfigclass.php");
   include_once(CLASS_DIR."komisiclass.php");
   include_once(CLASS_DIR."jualclass.php");
   include_once(CLASS_DIR."systemclass.php");
   include_once(CLASS_DIR."productclass.php");
   include_once(CLASS_DIR."texttoimageclass.php");
   $oSystem->checkLogin();
   $vIdTemp = $_GET['idtemp'];
   
?>

<table class="table table-hover table-striped table-bordered">
                <tbody><tr>
                  <th width="51" class="hide">ID Korwil</th>
                  <th width="70">Propinsi</th>
                  <th width="79">Kab / Kota</th>
                  <th width="40">Kecamatan</th>
                  <th width="52"><i class="fa fa-cogs"></i></th>
                 
                </tr>
<?
    $vSQL="select * from tb_korwil_area where fidkorwil='$vIdTemp' ";
   $db->query($vSQL);
   while ($db->next_record())  {
	    $vID=$db->f("fidkorwil");
		$vIdSys=$db->f("fidsys");
		$vProp = $db->f("fprop");
		$vPropName = $oMember->getWilName('ID',$vProp);
		$vKota = $db->f("fkabkota");
		$vKotaName=$oMember->getWilName('ID',$vProp,$vKota);
		$vKec = $db->f("fkec");
		$vKecName=$oMember->getWilName('ID',$vProp,$vKota,$vKec);
?>                
                <tr>
                  <td class="hide"><?=$vID?></td>
                  <td><span class="label label-primary"><?=$vPropName;?></span></td>
                  <td><span class="label label-default label-lg"><?=$vKotaName;?></span></td>
                  <td><span class="label label-success"><?=$vKecName?></span></td>
                  <td><button type="button" class="btn btn-danger btn-xs" onClick="delTemplate('<?=$vIdSys?>','<?=$vID?>','<?=$vPropName;?>','<?=$vKotaName;?>','<?=$vKecName?>');"><i class="glyphicon glyphicon-minus"></i> </i>
                  </button> 
                  
                  <!-- &nbsp; <button type="button" data-toggle="modal" data-target="#templateModal"  class="btn btn-info btn-xs" onClick="doEditTemplate('<?=$vIdSys?>');"><i class="glyphicon glyphicon-pencil"></i></button>--></td> 
                 
                </tr>
<? } ?>                
                
               
              </tbody></table>