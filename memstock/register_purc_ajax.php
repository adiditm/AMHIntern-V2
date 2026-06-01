<?
session_start();
ini_set('display_errors', true);
error_reporting(E_ERROR);
include_once("../server/config.php");
if (!isset($_SESSION['save']) || !is_array($_SESSION['save']))
	$_SESSION['save'] = array();
$vUser=$_SESSION['LoginUser'];
$vRefer = $_SERVER['HTTP_REFERER'];
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
					   $_SESSION['record']['lmColor']=$_POST['hJmlItem'];
;
		
					   $_SESSION['record']['txtJml']=$_POST['txtJml'];
					   $_SESSION['record']['hHarga']=$_POST['hHarga'];
					   $_SESSION['record']['hSubTot']=$_POST['hSubTot'];
					   $_SESSION['record']['hWeight']=$_POST['hWeight'];
					   $_SESSION['save'][]=$_SESSION['record'];
			    
			   }   else {
			   
			      echo '<font color="#f00"><b>Kode produk '.$lmKode.' sudah ada dalam list item Anda, silakan hapus dan tambahakan lagi jika ingin mengoreksi Jumlah!</b></font>';
			   
			   }
	} else {
	//delete
					   $vArrDel='';		//   $_SESSION['record']['lmKode']=$_POST['delKode'];
			  		   $vDelno=$_POST['delNo'];
 					   $_SESSION['record']['lmKode']=$_POST['delKode'];
					   $_SESSION['record']['nama']=$_POST['delNama'];
  
					   $_SESSION['record']['lmSize']=$_POST['delSize'];
					   $_SESSION['record']['lmColor']=$_POST['delColor'];
					   $_SESSION['record']['hWeight']=$_POST['delWeight'];
		
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
     if (trim($_POST['delKode']) =='' || $_SESSION['save'][0]['lmKode']=='')
        unset( $_SESSION['save']);
  
	
	}
    
   
   
   
   

   
   
//print_r($_SESSION['save']);
    $_SESSION['savestock']=$_SESSION['save'];

?>
<table class="table table-striped" >
                            <thead>
                            <tr class="bgtr">
                                <th width="3%" style="height: 23px">#</th>
                                <th width="15%" style="height: 23px">Product Code</th>
                                <th width="25%" style="height: 23px">Product Name</th>
                                <th width="9%" class="hide" style="height: 23px">Ukuran</th>
                                <th width="9%" style="text-align:right; height: 23px;"> Qty</th>
                                <th style="width: 10%; height: 23px;text-align:right"  align="right" class="hide">Item Qty</th>
                                <th style="width: 104px; height: 23px;text-align:right" > Price</th>
                                <th style="width: 94px; height: 23px;text-align:right" >Sub Total</th>
                                <th width="12%" style="height: 23px">&radic;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr id="trAdd" style="display:">
                                <th style="width: 33px; height: 30px;"></th>
                                <th style="width: 208px; height: 30px;">
                                <select onchange="selectProd(this)" name="lmKode" id="lmKode" class="form-control" style="display:none;width:140px">
								
								<option value="" selected="selected">---Pilih---</option>
								<?
								   
									$vNo=0;
								    if (preg_match("/reorderkit.php/i",$vRefer))
									   $vSQL="select * from m_product  where  faktif='1' and fidcat='CAT-0002' order by fidproduk";
									else if (preg_match("/reorderacc.php/i",$vRefer))  
									   $vSQL="select * from m_product  where  faktif='1' and fidcat='CAT-0003' order by fidproduk";
									else if (preg_match("/reorder.php/i",$vRefer) || preg_match("/reorderms.php/i",$vRefer) ||  preg_match("/reorderout.php/i",$vRefer))  
									   $vSQL="select * from m_product  where  faktif='1'  order by fidproduk";
									   
									// echo $vSQL;  
								    $db->query($vSQL);
								    $vColorText="";
								    while($db->next_record()) {
								       $vCode=$db->f('fidproduk');
								       $vNama=$db->f('fnamaproduk');
								       $vHarga=number_format($db->f('fhargajual1'),0,"","");
								       $vSize=$db->f('fsize');
								       $vColor = $db->f('fidcolor');
									   $vWeight = $db->f('fberat');
								       $vJmlItem = $db->f('fsatuan');

								      								       
								?>
								<option colors="<?=$vColor?>"   price="<?=$vHarga?>" jmlitem="<?=$vJmlItem?>" sizes="<?=$vSize?>" value="<?=$vCode?>" sweight="<?=$vWeight?>" selected="selected"><?=$vCode.";".$vNama?></option>

								<? } ?>
								</select>
							
								
								
                                </th>
                                <th id="thNama" style="height: 30px; width: 277px;" ></th>
                                <th id="thUkur" style="height: 30px" class="hide">
                                
                                <select name="lmSize" id="lmSize" style="display:none" class="form-control">
								<option value="">---Pilih---</option>
								</select>
								
								</th>
                                <th style="height: 30px; width: 10%;"> 
                                <input name="txtJml" id="txtJml" class="form-control"  type="text" dir="rtl" style="display:none;text-align:right" size="10" onkeyup="calcSub(this)" onblur="calcSub(this)" >                                
                                
                                </th>
                                <th style="height: 30px; width: 10%;text-align:right" id="thJmlItem" class="hide"> </th>
                                <input type="hidden" name="hJmlItem" id="hJmlItem" value="" />
                                <input type="hidden"  id="hItemSat" name="hItemSat" value="">
                                 <input type="hidden"  id="hWeight" name="hWeight" value="">
                                <th style="width: 162px; height: 30px;text-align:right" id="thHarga"></th>
                                <th align="right" id="thSubTot" style="height: 30px; width: 94px;text-align:right"></th>
                                <th align="center" id="thSubTot" style="height: 30px"><input id="btSaveRow" type="button" onclick="return doSaveRow()" class="btn btn-success btn-sm" value="Save Item" style="display:none"/></th>
                                <th style="display:none; height: 30px;"></th><input type="hidden" name="hSubTot" id="hSubTot" value="" />
                                <input type="hidden" name="hWeight" id="hWeight" value="" />
                                </th>
                            </tr>
                            <?
                                $vCount = count($_SESSION['save']);
                                $vTot=0;$vTotJum=0;$vTotWeight=0;
                                for ($i=0;$i<$vCount;$i++) {
									
									
                                    
                            ?>
                            <tr>
                                <td><?=$i+1?></td>
                                <td style="width: 33px"><?=$_SESSION['save'][$i]['lmKode']?></td>
                                <td align="left" style="width: 277px"><?=$_SESSION['save'][$i]['nama']?></td>
                                <td align="left" class="hide"><?=$_SESSION['save'][$i]['lmSize']?></td>
                                
                                <td align="right" style="margin-right:1em; width: 10%;"><?=number_format($_SESSION['save'][$i]['txtJml'],0,",",".");$vTotJum+=$_SESSION['save'][$i]['txtJml'];?></td>
                                <td align="right" class="hide"><?=$_SESSION['save'][$i]['lmColor']?>
                                <?=$_SESSION['save'][$i]['lmWeight']?></td>
                                <td align="right"><?=number_format($_SESSION['save'][$i]['hHarga'],0,",",".")?></td>
                                <td style="width: 94px" align="right"><?=number_format($_SESSION['save'][$i]['hSubTot'],0,",",".");$vTot+=$_SESSION['save'][$i]['hSubTot']; $vTotWeight+=$_SESSION['save'][$i]['hWeight'] * $_SESSION['save'][$i]['txtJml'];?></td>
                                <?
								//print_r($_SESSION['save']);
                                   $sKode=$_SESSION['save'][$i]['lmKode'];
                                   $sSize=$_SESSION['save'][$i]['lmSize'];
                                   $sColor=$_SESSION['save'][$i]['lmColor'];
								   $sWeight=$_SESSION['save'][$i]['hWeight'];
                                   $vNamaX=$_SESSION['save'][$i]['nama'];
                                   $vJmlX=$_SESSION['save'][$i]['txtJml'];
                                   $vHargaX=$_SESSION['save'][$i]['hHarga'];
                                   $vSubTotX=$_SESSION['save'][$i]['hSubTot'];
                                ?>
                                <td><input id="btDelItem<?=$vNo?>" type="button" onclick="doDel('<?=$vNo?>','<?=$sKode?>','<?=$sSize?>','<?=$sColor?>','<?=$vNamaX?>','<?=$vJmlX?>','<?=$vHargaX?>','<?=$vSubTotX?>')" class="btn btn-success btn-xs btn-minus hide" value="&nbsp;&nbsp;-&nbsp;&nbsp; "/>
                                <? $vNo++; ?>
                                </td>
                            </tr>
                            
                            <? } ?>
                            <tr>
                                <td style="width: 33px">&nbsp;<input type="hidden"  id="hHarga" name="hHarga" value=""></td>
                                <td align="left" colspan="2"><input id="btAdd" type="button" onclick="doAdd()" class="btn btn-info btn-sm hide" value="Add Item +"/>&nbsp;<input type="button" onclick="doCancel()" class="btn btn-default  btn-sm" value="Cancel" id="btCancel" style="display:none"/></td>
                                <td align="left" id="tdLoad" class="hide"></td>
                                <td align="right" style="width: 10%;margin-right:1em"><span style="display:<? if ($vTotJum==0) echo 'none';?>"><?=number_format($vTotJum,0,",",".")?></span><input type="hidden" name="hTotJum" id="hTotJum" value="<?=$vTotJum?>" /></td>
                                <td class="hide">&nbsp;</td>
                                
                                <td>&nbsp;</td>
                                <td style="width: 94px" align="right"><span style="display:<? if ($vTot==0) echo 'none';?>"><?=number_format($vTot,0,",",".")?></span><input type="hidden" name="hTot" id="hTot" value="<?=$vTot?>" />
                                <input type="hidden" name="hTotWeight" id="hTotWeight" value="<?=$vTotWeight?>" />
                                <input type="hidden" name="hCartJson" id="hCartJson" value="<?=htmlspecialchars(json_encode(is_array($_SESSION['save']) ? $_SESSION['save'] : array()), ENT_QUOTES, 'UTF-8')?>" /></td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            </tbody>
                        </table>

