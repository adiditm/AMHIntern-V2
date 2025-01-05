

<?
include_once("../server/config.php");
include_once("../classes/networkclass.php");
include_once("../classes/memberclass.php");
 



	 if ($_GET['uMemberId'] != '')
	
		$vUserActive=$_GET['uMemberId'];
	
	 else  $vUserActive=$vUser;

	 $vKakiL=$oNetwork->getDownLR($vUserActive,'L');
	  $vKakiR=$oNetwork->getDownLR($vUserActive,'R');
	 $vKarirKakiL=$oMember->getMemField('flevel',$vKakiL);
	 $vKarirKakiR=$oMember->getMemField('flevel',$vKakiR);		 

		if ($vKakiL !=-1 && $vKakiL !='') {
		   // $vOmzetDownL=$oKomisi->getOmzetROSetWholeMember($vKakiL);
		    $vOmzetDownL=$oNetwork->getDownlineCountActivePeriodPeringkat($vKakiL,'2016-01-01','2200-01-01');
			$vDownAllL=$oNetwork->getDownlineAllActivePeriod($vKakiL,$vOutL,'2016-10-03','2200-01-01');
			$vDLLCountE=$oNetwork->getDownlineCountCareer($vKakiL,'E');
			$vDLLCountPE=$oNetwork->getDownlineCountCareer($vKakiL,'PE');
			$vDLLCountM=$oNetwork->getDownlineCountCareer($vKakiL,'M');
			$vDLLCountPM=$oNetwork->getDownlineCountCareer($vKakiL,'PM');
			$vDLLCountD=$oNetwork->getDownlineCountCareer($vKakiL,'D');
			$vDLLCountRD=$oNetwork->getDownlineCountCareer($vKakiL,'RD');
		} else	{
			$vDownAllL="";
		    $vOmzetDownL=0;
			$vDLLCountE=0;
			$vDLLCountPE=0;
			$vDLLCountM=0;
			$vDLLCountPM=0;
			$vDLLCountD=0;
			$vDLLCountRD=0;
			
		}
			
		if ($vKakiR !=-1 && $vKakiR !='') {
		   // $vOmzetDownR=$oKomisi->getOmzetROSetWholeMember($vKakiR);
		    $vOmzetDownR=$oNetwork->getDownlineCountActivePeriodPeringkat($vKakiR,'2016-01-01','2200-01-01');
			$vDownAllR=$oNetwork->getDownlineAllActivePeriod($vKakiR,$vOutR,'2016-10-03','2200-01-01');
			$vDLRCountE=$oNetwork->getDownlineCountCareer($vKakiR,'E');
			$vDLRCountPE=$oNetwork->getDownlineCountCareer($vKakiR,'PE');
			$vDLRCountM=$oNetwork->getDownlineCountCareer($vKakiR,'M');
			$vDLRCountPM=$oNetwork->getDownlineCountCareer($vKakiR,'PM');
			$vDLRCountD=$oNetwork->getDownlineCountCareer($vKakiR,'D');
			$vDLRCountRD=$oNetwork->getDownlineCountCareer($vKakiR,'RD');

		} else	{
		    $vDownAllR="";
			$vOmzetDownR=0;
			$vDLRCountE=0;
			$vDLRCountPE=0;
			$vDLRCountM=0;
			$vDLRCountPM=0;
			$vDLRCountD=0;
			$vDLRCountRD=0;
			
		}
			
		if ($vPaketKakiL == 'S')
		   $vOmzetDownL+=1;
		else if ($vPaketKakiL == 'G')
		   $vOmzetDownL+=3;
		else if ($vPaketKakiL == 'P')
		   $vOmzetDownL+=7;

		if ($vPaketKakiR == 'S')
		   $vOmzetDownR+=1;
		else if ($vPaketKakiR == 'G')
		   $vOmzetDownR+=3;
		else if ($vPaketKakiR == 'P')
		   $vOmzetDownR+=7;

		
		if ($vKarirKakiL=='E')	
		   $vDLLCountE+=1;
		if ($vKarirKakiL=='PE')	
		   $vDLLCountPE+=1;
		if ($vKarirKakiL=='M')	
		   $vDLLCountM+=1;
		if ($vKarirKakiL=='PM')	
		   $vDLLCountPM+=1;
		if ($vKarirKakiL=='D')	
		   $vDLLCountD+=1;
		if ($vKarirKakiL=='RD')	
		   $vDLLCountRD+=1;



		if ($vKarirKakiR=='E')	
		   $vDLRCountE+=1;
		if ($vKarirKakiR=='PE')	
		   $vDLRCountPE+=1;
		if ($vKarirKakiR=='M')	
		   $vDLRCountM+=1;
		if ($vKarirKakiR=='PM')	
		   $vDLRCountPM+=1;
		if ($vKarirKakiR=='D')	
		   $vDLRCountD+=1;

		if ($vKarirKakiL=='RD')	
		   $vDLLCountRD+=1;




?>

<script language="Javascript">


	

	

</script>

<style>
.tabelrekap {
 /* background-color:#FFFFFF;*/
  color:#000000;
  border:1px solid;
  border-color:#666;
  border-collapse: collapse;
  
}

.tabelrekap tr:nth-of-type(odd) { 
  background-color: #999; 
}


.tabelrekap td{
  border:1px solid;
  border-color:#666;
  padding:0px 5px 0px 5px;
  color:#000000;
  border-collapse:collapse;
}

.tabelrekap tr:first-child {
	background-color:#CCCCCC;
	border-bottom:double;
	color:#666;
	text-align:center;
	
	}
	
	
	.tabelrekapin {
  background-color:#FFFFFF;
  color:#000000;
  border-top:none;
  border-color:#000000;
  border-collapse: collapse;
  border:1px solid #999;
  
}

.tabelrekapin td{
  border:1px solid;
  border-color:#000000;
  padding:0px 5px 0px 5px;
  color:#000000;
  border-collapse:collapse;
}

.tabelrekapin tr:first-child {
	color:#000000;
	text-align:left;
	 border-collapse:collapse;
	 border:1px solid #999;
	
	}
</style>

<body class="" bgcolor="#fff" style="background-color:white">

 <link rel="stylesheet" type="text/css" href="../js/bootstrap-datepicker/css/datepicker-custom.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-timepicker/css/timepicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-colorpicker/css/colorpicker.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-daterangepicker/daterangepicker-bs3.css" />

  <link rel="stylesheet" type="text/css" href="../js/bootstrap-datetimepicker/css/datetimepicker-custom.css" />





 <section>

             <!--body wrapper start-->

 	   <section class="wrapper" style="width:100%;background-color:white">

 		  <div align="left" style="width:98%;margin-left:1%" class="">               

 		    <b>Username / Name :  <?=$vUserActive?> / <?=($oMember->getMemberName($vUserActive))?></b><br> 
 		    <table width="90%" border="0" style="border:1px solid" >
 		      <tr style="background-color:#999;color:#000;font-weight:bold">
 		        <td width="48%"><div align="center">L</div></td>
 		        <td width="52%"><div align="center">R</div></td>
	          </tr>
 		      <tr>
 		        <td valign="top"><table border="0" align="center" cellpadding="1" cellspacing="0" class="tabelrekap" >

				<tr bgcolor="#CCCCFF">

					<td width="9%" align="center" style="width: 11%"><strong><span class="style5">

					No</span></strong></td>

					<td width="28%" align="center" style="width: 32%"><strong><span class="style5">

					Downline Username</span></strong></td>

					<td width="33%" align="center" style="width: 38%"><strong><span class="style5">Downline Name</span></strong></td>

					<td width="15%" align="center"><strong>Package</strong></td>
					<td width="15%" align="center"><strong>Value</strong></td>

				</tr>

            <?php

			$vArrCangkok = $oNetwork->getArrayCangkok();
			//print_r($vArrCangkok);
 			if (!in_array($vKakiL,$vArrCangkok))
			     $vOutL[]=$vKakiL;
			$vNo=0;	 $vTotVal=0;
			 while(list($key,$val)=@each($vOutL)) {
				 $vNo++;
				
		?>

            	<tr >

					<td height="21" align="center" style="width: 11%"><span class="style9">

                <?=$vNo?>

              	  </span></td>

					<td align="center" style="width: 32%">

					<div align="left" class="style9">

                  <? if($val==-1) $val='No Downline'; echo $val; ?>

              	  </div>

					</td>

					<td align="center" style="width: 38%">

					<div align="left" >

                  <? $vNama=$oMember->getMemberName($val);
				      if($vNama==-1) $vNama='No Downline'; echo $vNama;
				  ?>

              	  </div>

					</td>

					<td align="center"><span class="style9">
					  <? $vPack=$oMember->getPaketID($val);
					      if($vPack==-1) $vPack='-'; echo $vPack;
					  ?>
					</span></td>
					<td align="center"><div align="right">
                    
                    <?
                       if ($vPack=='S')
					      $vValue=1;
                       else if ($vPack=='G')
					      $vValue=3;
                       else if ($vPack=='P')
					      $vValue=7;
					    if($vValue=='') $vValue='0'; 
					   echo $vValue;
					   
					   $vTotVal+=$vValue;	  
						  
					?></div></td>

				</tr>

            <? } ?>

            	<tr >

					<td height="21" colspan="4" align="center" class="style6">

					<div align="right"><span class="style8"><strong>Total Omzet </strong>
					  
				    </span>
					  
					  </div>
					<div align="right" class="style9">
					  
					  </div>				    </td>

					<td align="center" ><div align="right"><strong>
				    <?=number_format($vTotVal,0,",",".")?>
					</strong></div></td>

				</tr>

			</table></td>
 		        <td valign="top"><table border="0" align="center" cellpadding="1" cellspacing="0" class="tabelrekap" >

				<tr bgcolor="#CCCCFF">

					<td width="9%" align="center" style="width: 11%"><strong><span class="style5">

					No</span></strong></td>

					<td width="28%" align="center" style="width: 32%"><strong><span class="style5">

					Downline Username</span></strong></td>

					<td width="33%" align="center" style="width: 38%"><strong><span class="style5">Downline Name</span></strong></td>

					<td width="15%" align="center"><strong>Package</strong></td>
					<td width="15%" align="center"><strong>Value</strong></td>

				</tr>

            <?php

			$vArrCangkok = $oNetwork->getArrayCangkok();
			//print_r($vArrCangkok);
 			if (!in_array($vKakiR,$vArrCangkok))
			     $vOutR[]=$vKakiR;
			$vNo=0;	 $vTotVal=0;
			 while(list($key,$val)=@each($vOutR)) {
				 $vNo++;
				
		?>

            	<tr >

					<td height="21" align="center" style="width: 11%"><span class="style9">

                <?=$vNo?>

              	  </span></td>

					<td align="center" style="width: 32%">

					<div align="left" class="style9">

                  <? if($val==-1) $val='No Downline'; echo $val; ?>

              	  </div>

					</td>

					<td align="center" style="width: 38%">

					<div align="left" >

                  <? $vNama=$oMember->getMemberName($val);
				      if($vNama==-1) $vNama='No Downline'; echo $vNama;
				  ?>

              	  </div>

					</td>

					<td align="center"><span class="style9">
					  <? $vPack=$oMember->getPaketID($val);
					      if($vPack==-1) $vPack='-'; echo $vPack;
					  ?>
					</span></td>
					<td align="center"><div align="right">
                    
                    <?
                       if ($vPack=='S')
					      $vValue=1;
                       else if ($vPack=='G')
					      $vValue=3;
                       else if ($vPack=='P')
					      $vValue=7;
					    if($vValue=='') $vValue='0'; 
					   echo $vValue;
					   
					   $vTotVal+=$vValue;	  
						  
					?></div></td>

				</tr>

            <? } ?>

            	<tr >

					<td height="21" colspan="4" align="center" class="style6">

					<div align="right"><span class="style8"><strong>Total Omzet </strong>
					  
				    </span>
					  
					  </div>
					<div align="right" class="style9">
					  
					  </div>				    </td>

					<td align="center" ><div align="right"><strong>
				    <?=number_format($vTotVal,0,",",".")?>
					</strong></div></td>

				</tr>

			</table></td>
	          </tr>
	        </table>
 		    <br>


			

		        </div>

</section>

        <!--body wrapper end-->



        <!--footer section start-->



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

