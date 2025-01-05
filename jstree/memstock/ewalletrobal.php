<? include_once("../framework/masterheader.php")?>

<?

  $vRefURL=$_SERVER['HTTP_REFERER'];

  if ($vRefURL=="")

      $oSystem->jsLocation("../main/logout.php");

 

  $vRefUser=$_GET['uMemberId'];

  $vUser=$_SESSION['LoginUser'];

  $vSpy = md5('spy').md5($_GET['uMemberId']);

   if ($_GET['op']==$vSpy)

      $vUserChoosed=$_GET['uMemberId'];



  if (isset($vRefUser))

  	 $vUserChoosed=$vRefUser;

  else	 

  	 $vUserChoosed=$_SESSION['LoginUser'];



 $vPage=$_POST['lmPage'];	 

    if ($vPage=="") $vPage=1;



 $vStart=$_POST['dc'];$vEnd=$_POST['dc1'];

 

 $vStartString=$vStart." 00:00:00";

 $vEndString=$vEnd." 23:59:59";

 $vSearch=$_POST['tfSearch'];



 $vCrit="";$vFilterText="";

 if ($vStart!="" || $vEnd!="") {

	    $vCrit.=" and ftanggal >= '$vStartString' and ftanggal <= '$vEndString' " ;
	    $vFilterText.="[Date: $vStartString - $vStartString]";
}

 if ($vSearch!="")	{	

        $vCrit.=" and fdesc like '%$vSearch%' ";
	    $vFilterText.="[Description: $vSearch]";
}        




  $vSQL="select count(*) as fjumrec from tb_mutasi_ro where fidmember='$vUserChoosed' $vCrit";

 

  	 // echo "xxx";

 //exit;	

 $db->query($vSQL);

 $db->next_record();

 

 $vJumRec=$db->f("fjumrec");

 $vRecPerPage=$_POST['lmPP'];

 if ($vRecPerPage=="") $vRecPerPage=25;

 $vRecPerPage;

 $vJumPage=ceil($vJumRec / $vRecPerPage);

 $vOffset=($vPage-1) *  $vRecPerPage ;

// $oKomisi->delZeroMut();

 $vByy=	 $oRules->getSettingByField('fbyyadmin');

?>





<script language="Javascript">

$(document).ready(function(){

      $('#caption').html('RO-Wallet Balance');



   $('#dc').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  
  

    

       $('#dc1').datepicker({

                    format: "yyyy-mm-dd",

                    autoclose : true

    }).on('changeDate', function (ev) {
    $(this).datepicker('hide');
    });  
 

  

});	

	

	

</script>



<script language="javascript">

   function clearForm() {    

	 document.demoform.dc.value='';

	 document.demoform.dc1.value='';

	 document.demoform.lmPP.selectedIndex=0;

	 document.demoform.tfSearch.value='';

   }

   

   function doSearch() {

     document.demoform.lmPage.selectedIndex=0;

	 document.demoform.submit();

   }

</script>





<style type="text/css">

<!--

.style1 {	color: #000000;

	font-weight: bold;

}

.style4 {color: #000000}

-->

table td {

	padding:3px 3px 3px 3px;

}

.auto-style1 {

	font-weight: bold;

}

</style>





<body class="sticky-header">

 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />







 <section>

    <!-- left side start-->

      <?  if ($_GET['uMemberId'] != '' && $_GET['op']==$vSpy) 

           include "../framework/leftadmin.php"; 

        else

           include "../framework/leftmem.php"; 

      ?>

    <!-- main content start-->

    <div class="main-content" >



      <?  if ($_GET['uMemberId'] != '' && $_GET['op']==$vSpy) 

           include "../framework/headeradmin.php"; 

        else

           include "../framework/headermem.php"; 

      ?>

  



           <!--body wrapper start-->

 	   <section class="wrapper">

 		       


      <form name="demoform" method="post" id="demoform" >

      <div class="col-lg-12 col-centered" >
       <div class="col-lg-8 " align="left" style="margin-left:-1em">



<div class="row">
            <div align="left" class="col-sm-4"><strong>Date </strong></div>


              <div  class="col-lg-2  col-sm-2 col-md-2 col-xs-4" style="min-width:10em">
              <input class="dpick form-control form-inline"  name="dc"  id="dc"  value="<?=$vStart?>"   />
              </div>
              
              <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><strong>To</strong></div>
                            
              <div  class="col-lg-2 col-sm-2 col-md-2 col-xs-4" style="min-width:10em">
              <input  class="dpick form-control form-inline" name="dc1" id="dc1" value="<?=$vEnd?>" /></div>

            </div>
<br>
         <div class="row ">
            <div align="left" class="col-sm-4"><strong>Record </strong></div>
            <div align="left" class="col-sm-6 col-md-6 col-xs-6">
   

              <select name="lmPP" id="lmPP" class="form-control">

                <option selected="selected" value="">--Default--</option>

                <option value="10" <? if ($vRecPerPage==10) echo "selected";?>>10</option>

                <option value="20" <? if ($vRecPerPage==20) echo "selected";?>>20</option>

                <option value="30" <? if ($vRecPerPage==30) echo "selected";?>>30</option>

                <option value="40" <? if ($vRecPerPage==40) echo "selected";?>>40</option>

                <option value="50" <? if ($vRecPerPage==50) echo "selected";?>>50</option>

              </select>

            </div>
          </div>

<br>
         <div class="row">
            <div align="left" class="col-sm-4"><strong>Desc. Search </strong></div>

           <div align="left" class="col-sm-6 col-md-6 col-xs-6">
              <input name="tfSearch" type="text" id="tfSearch" value="<?=$vSearch?>" class="form-control" />
            </div></div>
<br>

          
        <div class="row">
                      <div class="col-lg-6">


        <input name="btRefresh" type="button" id="btRefresh" value="Search" onClick="doSearch()" class="btn btn-success" /> 

        &nbsp;

        <input name="btReset" type="button" id="btReset" value="Reset" onClick="clearForm()" class="btn btn-default"  />
    </div>
    </div>
      </div></div>

<div style="float:left;margin-top:1em;width:100%">
        <p>

              <strong><font size="3" face="Arial, Helvetica, sans-serif"><a name="mutasi" id="mutasi"></a><br />
			  RO-Wallet  

              Balance [<?=$vUserChoosed;?> / <?=$oMember->getMemberName($vUserChoosed)?>]

                </font></strong>        </p>

        <p align="right" style="font-family:Arial, Helvetica, sans-serif;font-size:14px"><strong>

		Page :</strong> 

          <select name="lmPage" id="lmPage" onChange="document.demoform.submit()" class="form-control" style="width:65px">

            <? for ($i=1;$i<=$vJumPage;$i++) {?>

			<option value="<?=$i?>" <? if ($vPage==$i) echo "selected";?>>-<?=$i?>-</option>

			<? } ?>

          </select>

</p><div class="table-responsive">

        <table width="100%" border="1" align="center" cellpadding="5" cellspacing="0" >

        <tr style="font-weight:bold">

          <td width="3%" align="center">No</td>

          <td width="11%" align="center" class="auto-style1">Date</td>

          <td width="48%" align="center" class="auto-style1">Description</td>

          <td width="13%" align="center">Credit</td>

          <td width="13%" align="center">Debit</td>

          <td width="12%" align="center">Balance</td>

        </tr>

        <?

			   

			    $vSQL="select * from tb_mutasi_ro where  1 and fidmember='$vUserChoosed' ";

				$vSQL.=$vCrit;

				$vSQL.=" order by ftanggal,fidsys ";
				


				$db->query($vSQL);
				$vArrData="";
				$vArrHead=array('No.','Date','Description','Credit','Debit','Balance');
				$vArrBlank=array('','','','','','');
				$vArrDateFilter=array('Filter :  '.$vFilterText,'','','','','');
				
				
				$i=0;$vTot=0;
				$vArrData[]=$vArrDateFilter;
				$vArrData[]=$vArrBlank;
				$vArrData[]=$vArrHead;
				
				while ($db->next_record()) { //Convert Excel
				     $i++;

					   $vDateList=$db->f("ftanggal");
					   $vFee=$db->f("ffee");
					   $vTanggalKom=$oPhpdate->YMD2DMY($db->f("ftanggal"),"-");
					   $vDesc=$db->f("fdesc");
					   $vFunder=$db->f("fidfunder");
					   $vCred=$db->f("fcredit");
					   $vKind=$db->f('fkind');
					   $vDeb=$db->f("fdebit");
					   $vBal=$db->f("fbalance");
   
				     

				 //$vArrHead=array('No.','Date','Description','Credit','Debit','Balance');

				 $vArrData[]=array($i,$vTanggal,$vDesc,$vCred,$vDeb,$vBal);
					//$vArrMem['fpassword'][$i]=$oSystem->doED('decrypt',$db->f('fpassword'));
				
				}
				
				//$vArrTot=array('','','','','','',$vTot);
				//$vArrData[]=$vArrTot;
				$_SESSION['ewalletro']=$vArrData;

				
				
				$vSQL.=" limit $vRecPerPage offset $vOffset ";

				

				$db->query($vSQL);

				$vTotFee=0;

				$vNo=0;

				while ($db->next_record()) {

				   $vNo+=1;

				   $vDateList=$db->f("ftanggal");

				   $vFee=$db->f("ffee");

				   $vTanggalKom=$oPhpdate->YMD2DMY($db->f("ftanggal"),"-");

				   $vDesc=$db->f("fdesc");

				   $vCred=$db->f("fcredit");

				   $vDeb=$db->f("fdebit");

				   $vBal=$db->f("fbalance");

				   $vKind=$db->f("fkind");

				  

		  ?>

        <tr class="tbrekapfont">

          <td  align="center"><div align="right"><?=$vNo+$vOffset?></div></td>

          <td  align="center"><?=$oPhpdate->YMD2DMY($vDateList,"-")?></td>

          <td  align="center"><div align="left">

                <?

                 //  if (!in_array($vKind,array('koreksi')))
//
         //              $vDesc .= " (nett - admin $vByy%)";

                   echo $vDesc;    

                

                ?>

            </div></td>

          <td align="center"><div align="right">

            <?=number_format($vCred,0,",",".");?>

          </div></td>

          <td align="center"><div align="right">

<?=number_format($vDeb,0,",",".");?>

</div></td>

          <td align="center"><div align="right">

<?=number_format($vBal,0,",",".");?>

</div></td>

        </tr>

        <? } ?>

      </table>

      </div>

        <p align="right" style="font-family:Arial, Helvetica, sans-serif;font-size:14px"><strong>

		Page :</strong>

		<select style="width:65px" class="form-control" name="lmPage1" id="lmPage1" onChange="document.demoform.lmPage.value=document.demoform.lmPage1.value; document.demoform.submit()">

            <? for ($i=1;$i<=$vJumPage;$i++) {?>

			<option value="<?=$i?>" <? if ($vPage==$i) echo "selected";?>>-<?=$i?>-</option>

			<? } ?>

        </select></p>

  </form> 
  </div>

</section>
<button style="margin-left:2em" class="btn btn-info btn-sm" onClick="document.location.href='../manager/getexcel.php?arr=ewalletro&file=ewalletro_report_<?=$vUserChoosed?>'"><i class="fa fa-file-text-o"></i> Export Excel</button> 
</div>

        <!--body wrapper end-->



        <!--footer section start-->

        <? include "../framework/footer.php";?>

        <!--footer section end-->





<!-- Placed js at the end of the document so the pages load faster -->



<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>

<script src="../js/jquery-migrate-1.2.1.min.js"></script>



<script src="../js/modernizr.min.js"></script>

<script src="../js/jquery.nicescroll.js"></script>

<script src="../js/jquery.price_format.js"></script>









<script type="text/javascript" src="../js/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-daterangepicker/moment.min.js"></script>

<script type="text/javascript" src="../js/bootstrap-daterangepicker/daterangepicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

<script type="text/javascript" src="../js/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>

<!--common scripts for all pages-->

<script src="../js/pickers-init.js"></script>

<script src="../js/scripts.js"></script>



</body>

</html>



