<?

session_start();

ini_set('display_errors', true);

error_reporting(E_ERROR);

include_once("../server/config.php");
include_once("../classes/ruleconfigclass.php");
$vUserHO = $oRules->getSettingByField('fuserho');



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

   

  // echo "xxx".$oProduct->getColor('C-0001');

  

  while (list($key,$val)=each($_POST)) {

      $$key = $val;

   }

   $vTot=0;

   

   $vSQL = "select * from m_product where fidproduk='$lmKode'";

   $db->query($vSQL);

   $db->next_record();

   $vNama=$db->f('fnamaproduk');

   $vOp=$_POST['op'];

   

   if ($vOp != 'del') {

		   $vDup=0;

		   if (is_array($_SESSION['save'])) {

			   while (list($key,$val)=each($_SESSION['save'])) {

			      if ($_POST['lmKode']==$val['lmKode']) {

			         $vDup=1;  

		

			      }

		       }	

		    }      

		

		   if ($vDup==0) {  

		

		

					   $_SESSION['record']['lmKode']=$_POST['lmKode'];

					   $_SESSION['record']['nama']=$vNama;   

					   $_SESSION['record']['lmSize']=$_POST['lmSize'];

					   $_SESSION['record']['lmColor']=$_POST['lmColor'];

		

					   $_SESSION['record']['txtJml']=$_POST['txtJml'];

					   $_SESSION['record']['hHarga']=$_POST['hHarga'];

					   $_SESSION['record']['hSubTot']=$_POST['hSubTot'];

					   $_SESSION['save'][]=$_SESSION['record'];

			    

			   }   else {

			   

			      echo '<font color="#f00"><b>Product ID '.$lmKode.' already in the list, please delete and re-add for qty correction!</b></font>';

			   

			   }

	} else {

	//delete

					   $vArrDel='';		//   $_SESSION['record']['lmKode']=$_POST['delKode'];

			  		   $vDelno=$_POST['delNo'];

 					   $_SESSION['record']['lmKode']=$_POST['delKode'];

					   $_SESSION['record']['nama']=$_POST['delNama'];

  

					   $_SESSION['record']['lmSize']=$_POST['delSize'];

					   $_SESSION['record']['lmColor']=$_POST['delColor'];

		

					   $_SESSION['record']['txtJml']=$_POST['delJml'];

					   $_SESSION['record']['hHarga']=$_POST['delHarga'];

					   $_SESSION['record']['hSubTot']=$_POST['delSubTot'];

					   $vArrDel[$vDelno]=$_SESSION['record'];





	  

	  $vArrDiff = array_diff_assoc($_SESSION['save'],$vArrDel);	  

	  $_SESSION['save']=$vArrDiff;



	  $vCountArrBaru = count( $_SESSION['save']);

	  

	  //Re Index

	  $vArrTemp="";

      while (list($key,$val)=each($_SESSION['save'])) {

         $vArrTemp[]=$val;

         

      }

	  

     $_SESSION['save']=$vArrTemp;

     if (trim($_POST['delKode']) =='' )

        unset( $_SESSION['save']);

  

	

	}

   // print_r($_SESSION['save']);

   

  



?>

<table class="table" style="table-layout:fixed;">

                            <thead>

                            <tr class="bgtr">
                                <th width="3%" style="height: 23px">#</th>
                                <th width="15%" style="height: 23px">Product Code</th>
                                <th width="25%" style="height: 23px">Product Name</th>
                                <th width="9%" style="text-align:right; height: 23px;"> Qty</th>
                                <th style="width: 173px; height: 23px;text-align:right" > Price</th>
                                <th style="width: 92px; height: 23px;text-align:right" >Sub Total</th>
                                <th width="12%" style="height: 23px">&radic;</th>
                            </tr>

                            </thead>

                            <tbody>

                            <tr id="trAdd" style="display:">

                                <th style="width: 33px; height: 30px;"></th>

                                <th width="25%" style=" height: 30px;">

                                <select onchange="selectProd(this)" name="lmKode" id="lmKode" class="form-control" style="display:none;width:140px">

								

								<option value="" selected="selected">---Pilih---</option>

								<?

								    $vNo=0;

								    $vSQL="select * from m_product  where  faktif='1' and fidproduk in (select fidproduk from tb_stok_position where fidmember='$vUserHO')  order by fidproduk";

								    $db->query($vSQL);

								    $vColorText="";

								    while($db->next_record()) {

								       $vCode=$db->f('fidproduk');

								       $vNama=$db->f('fnamaproduk');

								       $vHarga=number_format($db->f('fhargajual1'),0,"","");

								       $vSize=$db->f('fsize');

								       $vColor = $db->f('fidcolor');

								      								       

								?>

								<option colors="<?=$vColor?>"   price="<?=$vHarga?>" sizes="<?=$vSize?>" value="<?=$vCode?>" selected="selected"><?=$vCode.";".$vNama?></option>



								<? } ?>

								</select>

							

								

								</th>

                                <th id="thNama" style="height: 30px" ></th>

                                <th style="height: 30px"> <div class="form-group col-lg-12 col-md-12 col-xs-12 "><input name="txtJml" id="txtJml" class="form-control"  type="text" dir="rtl" style="display:none" size="10" onkeyup="calcSub(this)" onblur="calcSub(this)" ></div></th>

                                <th style="width: 162px; height: 30px;" id="thHarga"></th>

                                <th align="right" id="thSubTot" style="height: 30px"></th>

                                <th align="center" id="thSubTot" style="height: 30px"><input id="btSaveRow" type="button" onclick="return doSaveRow()" class="btn btn-success btn-sm" value="Save Item" style="display:none"/></th>

                                <input type="hidden" name="hSubTot" id="hSubTot" value="" />

                            </tr>

                            <?

                                $vCount = count($_SESSION['save']);

                                $vTot=0;$vTotJum=0;
								if (count($_SESSION['save']) == 1 && $_SESSION['save'][0]['lmKode'] == '') {
								   $vCount=0;
								   $_SESSION['save']=array();
								}
                                for ($i=0;$i<$vCount;$i++) {

                                    

                            ?>

                            <tr>

                                <td><?=$i+1?></td>

                                <td style="width: 33px"><?=$_SESSION['save'][$i]['lmKode']?></td>

                                <td align="left" style="width: 208px"><?=$_SESSION['save'][$i]['nama']?></td>

                                <td align="right"><?=number_format($_SESSION['save'][$i]['txtJml'],0,",",".");$vTotJum+=$_SESSION['save'][$i]['txtJml'];?></td>

                                <td align="right"><?=number_format($_SESSION['save'][$i]['hHarga'],0,",",".")?></td>

                                <td style="width: 162px" align="right"><?=number_format($_SESSION['save'][$i]['hSubTot'],0,",",".");$vTot+=$_SESSION['save'][$i]['hSubTot'];?></td>

                                <?

                                   $sKode=$_SESSION['save'][$i]['lmKode'];

                                   $sSize=$_SESSION['save'][$i]['lmSize'];

                                   $sColor=$_SESSION['save'][$i]['lmColor'];

                                   $vNamaX=$_SESSION['save'][$i]['nama'];

                                   $vJmlX=$_SESSION['save'][$i]['txtJml'];

                                   $vHargaX=$_SESSION['save'][$i]['hHarga'];

                                   $vSubTotX=$_SESSION['save'][$i]['hSubTot'];

                                ?>

                                <td><input id="btAdd" type="button" onclick="doDel('<?=$vNo?>','<?=$sKode?>','<?=$sSize?>','<?=$sColor?>','<?=$vNamaX?>','<?=$vJmlX?>','<?=$vHargaX?>','<?=$vSubTotX?>')" class="btn btn-success btn-xs" value="&nbsp;&nbsp;-&nbsp;&nbsp; "/>

                                <? $vNo++; ?>

                                </td>

                            </tr>

                            

                            <? } ?>

                            <tr>

                                <td style="width: 33px">&nbsp;<input type="hidden"  id="hHarga" name="hHarga" value=""></td>

                                <td align="left" style="width: 208px" colspan="2"><input id="btAdd" type="button" onclick="doAdd()" class="btn btn-info btn-sm" value="Add Item +"/>&nbsp;<input type="button" onclick="doCancel()" class="btn btn-default  btn-sm" value="Cancel" id="btCancel" style="display:none"/></td>

                                <td align="right"><span style="display:<? if ($vTotJum==0) echo 'none';?>"><?=number_format($vTotJum,0,",",".")?></span><input type="hidden" name="hTotJum" id="hTotJum" value="<?=$vTotJum?>" /></td>

                                <td>&nbsp;</td>

                                <td style="width: 162px" align="right"><span style="display:<? if ($vTot==0) echo 'none';?>"><?=number_format($vTot,0,",",".")?></span><input type="hidden" name="hTot" id="hTot" value="<?=$vTot?>" /></td>

                                <td>&nbsp;</td>

                              

                            </tr>

                            </tbody>

                        </table>



