<?

session_start();
ini_set('display_errors', true);
error_reporting(E_ERROR);
include_once("../server/config.php");
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
   
   $vKit=$_GET['kit'];
   
   $vSQL="select * from tb_kit_active where fidmember='$vKit';";
   
?>
 <label for="exampleInputEmail1" style="font-weight:bold;">
								 Product Purchase</label><br />
    							<table style="width: 90%;border-radius:3px" cellpadding="6" class="table">

									<tr style="font-weight:bold">

										<td width="14%" valign="top" align="center" nowrap="nowrap">

										 Product Code&nbsp;</td>

										<td width="35%" valign="top" align="center"> 

							               	 Product Name&nbsp;</td>

										<td width="18%" valign="top" align="center">

										 Qty&nbsp;</td>
										<td width="18%" valign="top" align="center">Price</td>
										<td width="15%" valign="top" align="center">Subtotal</td>

									</tr>
<?
   $db->query($vSQL);
   $vTot=0;
   while($db->next_record())  {
	   $vCode=$db->f('fidproduk');
	   $vName = $oProduct->getProductName($vCode);
	   $vQty=$db->f('fjumlah');
	   $vPrice = $db->f('fhargasat');
	   $vSubTot = $db->f('fsubtotal');
	   
?>
									<tr>

										<td valign="top"><?=$vCode?></td>

										<td valign="top"><?=$vName?></td>

										<td valign="top" align="right"><?=number_format($vQty,0,",",".")?></td>
										<td valign="top" align="right"><?=number_format($vPrice,0,",",".")?></td>
										<td valign="top" align="right"><?=number_format($vSubTot,0,",",".");$vTot+=$vSubTot?></td>

									</tr>
									
<? } ?>

<tr style="font-weight:bold">
									  <td colspan="4" valign="top" align="right">Total: </td>
									  <td valign="top" align="right"><?=number_format($vTot,0,",",".")?></td>
								  </tr>
								</table>

