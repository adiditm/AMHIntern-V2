		<!-- begin #sidebar -->
<style>
    .ahover{
		color:yellow;
	}
	.ahover:hover{
		color:white;
	}
</style>
<script src="../js/md5.js"></script>
		<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<li class="nav-profile">
						<div class="image hide">
							<a href="javascript:;"><img src="../assets/img/user-13.jpg" alt="" /></a>
						</div>
						<div class="info">
							<?
                                //echo $oMember->getMemFieldAdm('fnama',$vUser)
								echo $vUser;
							?>
							<small>Admin</small>
						</div>
					</li>
				</ul>
				<!-- end sidebar user -->
				<!-- begin sidebar nav -->
               <?

                   $vArrMaster=array('indexmem.php');
				   $vMenu=$_SERVER['SCRIPT_NAME'];
				   $vMenu=explode("/",$vMenu);
				   $vCountExplode=count($vMenu);
				   $vLast=$vCountExplode -1;
				   if (in_array($vMenu[$vLast],$vArrMaster))
				      $vActive='active';
				   else	  
				      $vActive='';
					  
					//$vPaket=$oMember->getPaketID($_SESSION['LoginUser']);  

				?>        
                
				<ul class="nav">
					<li class="nav-header hide">Navigation</li>
					<li class="<?=$vActive?>">
						<a href="../manager/dashboard.php">
						    <b class="caret pull-right hide"></b>
						    <i class="fa fa-laptop"></i>
						    <span>Dashboard</span>
					    </a>
					</li>

 <?

                   $vArrMaster=array('requestpo.php','msetting.php','madmin.php','mcountry.php','mbank.php','mcatbarang.php','mbarang.php','menupriv.php','mshipcost.php');
				   $vMenu=$_SERVER['SCRIPT_NAME'];
				   $vMenu=explode("/",$vMenu);
				   $vCountExplode=count($vMenu);
				   $vLast=$vCountExplode -1;
				   if (in_array($vMenu[$vLast],$vArrMaster)) {
				      $vActive='active';
					  $vExpand= 'expand';
				   } else	 { 
				      $vActive='';
					   $vExpand='';
				   }
					  
					//$vPaket=$oMember->getPaketID($_SESSION['LoginUser']);  

				?>                    
					<li class="has-sub <?=$vActive?> <?=$vExpand?>">
						<a href="javascript:;">
							<span class="badge pull-right hide">10</span>
                             <b class="caret pull-right "></b>
							<i class="fa fa-list"></i> 
							<span>Master Data</span>
						</a>
						<ul class="sub-menu">

							
                              
                       <? if ($oSystem->checkPriv($vUser,"mdm_master_data_category")) { ?><li><a href="../masterdata/mcatbarang.php">Product Category</a></li> <? } ?>

                        <? if ($oSystem->checkPriv($vUser,"mdm_master_data_barang")) { ?><li><a href="../masterdata/mbarang.php"> Product</a></li> <? } ?>

                        <? if ($oSystem->checkPriv($vUser,"mdm_master_data_bank")) { ?><li><a href="../masterdata/mbank.php"> Bank</a></li> <? } ?>
                        
                        <? if ($oSystem->checkPriv($vUser,"mdm_master_data_shcost")) { ?><li><a href="../masterdata/mshipcost.php"> Biaya Kirim</a></li> <? } ?>

                        <? if ($oSystem->checkPriv($vUser,"mdm_master_data_country")) { ?> <li><a href="../masterdata/mcountry.php"> Country</a></li> <? } ?>

                        <? if ($oSystem->checkPriv($vUser,"mdm_master_data_rate")) { ?><li><a href="../masterdata/mkurs.php"> Rate</a></li> <? } ?>

                       <? if ($oSystem->checkPriv($vUser,"mdm_master_data_admin")) { ?> <li><a href="../masterdata/madmin.php"> User Admin</a></li> <? } ?>

                       <? if ($oSystem->checkPriv($vUser,"mdm_master_data_system")) { ?> <li><a href="../masterdata/msetting.php"> System Setting</a></li> <? } ?>
                        <? if ($oSystem->checkPriv($vUser,"mdm_master_data_admpriv")) { ?> <li><a href="../masterdata/menupriv.php"> Admin Privilege</a></li> <? } ?>

					  </ul>
					</li>



              <?
                    $vArrMaster=array('editoro.php','mastercontent.php');
				   $vMenu=$_SERVER['SCRIPT_NAME'];
				   $vMenu=explode("/",$vMenu);
				   $vCountExplode=count($vMenu);
				   $vLast=$vCountExplode -1;
				   if (in_array($vMenu[$vLast],$vArrMaster)) {
				      $vActive='active';
					  $vExpand= 'expand';
				   } else	 { 
				      $vActive='';
					   $vExpand='';
				   }
					  
					//$vPaket=$oMember->getPaketID($_SESSION['LoginUser']);  

				?>        
                  <? if ($oSystem->checkPriv($vUser,"mdm_content_man")) { ?>            
					<li class="has-sub <?=$vActive?> <?=$vExpand?>">
						<a href="javascript:;">
							<span class="badge pull-right hide">10</span>
                             <b class="caret pull-right "></b>
							<i class="fa fa-file-code-o"></i> 
							<span>Content Management </span>
						</a>
						<ul class="sub-menu">
                            <? if ($oSystem->checkPriv($vUser,"mdm_content_man_page")) { ?> <li><a href="../manager/editoro.php"><i><i class="fa fa-file-code-o"></i></i> Page Editor</a></li><? } ?>
                          <? if ($oSystem->checkPriv($vUser,"mdm_content_man_1st")) { ?>   <li><a href="../manager/mastercontent.php"><i><i class="fa fa-file-code-o"></i></i> 1st Content (Developer &nbsp;&nbsp;&nbsp;&nbsp;Only)</a></li><? } ?>
                       
                         


						</ul>
					</li>
       <? } ?>                         

                    

<?

                   $vArrMaster=array('stockman.php','newstock.php','stockbalho.php','kitactive.php','listkitact.php','listkitused.php','listserial.php');
				   $vMenu=$_SERVER['SCRIPT_NAME'];
				   $vMenu=explode("/",$vMenu);
				   $vCountExplode=count($vMenu);
				   $vLast=$vCountExplode -1;
				   if (in_array($vMenu[$vLast],$vArrMaster)) {
				      $vActive='active';
					  $vExpand= 'expand';
				   } else	 { 
				      $vActive='';
					   $vExpand='';
				   }
					  
					//$vPaket=$oMember->getPaketID($_SESSION['LoginUser']);  

				?>           
                 <? if ($oSystem->checkPriv($vUser,"mdm_ho_inv")) { ?>                
					<li class="has-sub <?=$vActive?> <?=$vExpand?>">
						<a href="javascript:;">
							<span class="badge pull-right hide">10</span>
                             <b class="caret pull-right "></b>
							<i class="fa fa-building"></i> 
							<span>Head Office Inventory</span>
						</a>
						<ul class="sub-menu">
                          <? if ($oSystem->checkPriv($vUser,"mdm_ho_inv_newitem")) { ?><li><a href="../manager/newstock.php"><i class="fa fa-pencil"></i> Entry New Item</a></li><? } ?>
                          <? if ($oSystem->checkPriv($vUser,"mdm_ho_inv_stadj")) { ?><li><a href="../manager/stockman.php"><i class="fa fa-cogs"></i> Stock Adjustment</a></li><? } ?>  				
						 <? if ($oSystem->checkPriv($vUser,"mdm_ho_inv_stmut")) { ?><li><a href="../manager/stockbalho.php"><i class="fa fa-cogs"></i> Stock Mutation</a></li><? } ?>  	
                         <? if ($oSystem->checkPriv($vUser,"mdm_ho_inv_kitact")) { ?>  <li><a href="../manager/kitactive.php"><i class="fa fa-list"></i> KIT Activation</a></li><? } ?>
 						 <? if ($oSystem->checkPriv($vUser,"mdm_ho_inv_kitlist")) { ?>  <li> <a href="../manager/listkitact.php"><i class="fa fa-list"></i> KIT Active List</a></li><? } ?>                      
                       
						<? if ($oSystem->checkPriv($vUser,"mdm_ho_inv_serstock")) { ?><li><a href="../manager/listserial.php"><i  class="fa fa-product-hunt"></i>  Serial Stock</a></li> 
						<? } ?>
						 
					  </ul>
					</li>
                    <? } ?>
                    
               <?

                   $vArrMaster=array('aktif.php','register.php','topup.php','reorder.php','profile.php','upgrade.php','reorderkit.php','reorderacc.php','historyro.php','registermem.php','approvesell.php','genealogi2.php');
				   $vMenu=$_SERVER['SCRIPT_NAME'];
				   $vMenu=explode("/",$vMenu);
				   $vCountExplode=count($vMenu);
				   $vLast=$vCountExplode -1;
				   if (in_array($vMenu[$vLast],$vArrMaster)) {
				      $vActive='active';
					  $vExpand= 'expand';
				   } else	 { 
				      $vActive='';
					   $vExpand='';
				   }
					  
					//$vPaket=$oMember->getPaketID($_SESSION['LoginUser']);  
					$vSpy=md5('spy').md5('UNIGTOP');;

				?>                    
					 <? if ($oSystem->checkPriv($vUser,"mdm_memnet")) { ?>    
                    <li class="has-sub <?=$vActive?> <?=$vExpand?>">
						<a href="javascript:;">
							<span class="badge pull-right hide">10</span>
                             <b class="caret pull-right "></b>
							<i class="fa fa-group"></i> 
							<span>Member &amp; Network</span>
						</a>
						<ul class="sub-menu">
							<? if ($oSystem->checkPriv($vUser,"mdm_memnet_profile")) { ?> <li><a href="../manager/aktif.php"> Members Profile</a></li><? } ?>
							  <? if ($oSystem->checkPriv($vUser,"mdm_memnet_genea")) { ?>  <li><a href="../memstock/genealogi2.php?op=<?=$vSpy?>&uMemberId=UNIGTOP"> Genealogi</a></li><? } ?>     
                               <? if ($oSystem->checkPriv($vUser,"mdm_memnet_roappv")) { ?> <li><a href="../manager/approvesell.php"> RO Approval</a></li><? } ?>                
						 <li class="hide"><a href="../manager/approval.php">Member Activation</a></li>
 

                       
                         <li class="hide"><a href="../memstock/genealogispon.php"> Genealogy Unilevel</a></li>

                        
                        




                         <!-- <li><a href="../manager/aktiftemp.php"> Members Bebek Hanyut</a></li> 



                        <li><a href="../manager/veriwith.php"> Withdraw Approval</a></li>-->

                        <!--  <li><a href="../manager/verirpo.php"> Request PO Processing</a></li>-->


                      <!--   <li><a href="../manager/veriro.php"> List Repeat Order</a></li>

						 <li><a href="../memstock/register.php"> Register New Member</a></li> -->

						 <li class="hide"><a href="../memstock/reorder.php"> Member RO</a></li>
						</ul>
					</li>
		<? } ?>


  


              <?
                    $vArrMaster=array('stjaringan.php','info.php','genealogispon.php','approvepo.php','approvekit.php','approvest.php');
				   $vMenu=$_SERVER['SCRIPT_NAME'];
				   $vMenu=explode("/",$vMenu);
				   $vCountExplode=count($vMenu);
				   $vLast=$vCountExplode -1;
				   if (in_array($vMenu[$vLast],$vArrMaster)) {
				      $vActive='active';
					  $vExpand= 'expand';
				   } else	 { 
				      $vActive='';
					   $vExpand='';
				   }
					  
					//$vPaket=$oMember->getPaketID($_SESSION['LoginUser']);  

				?>   
                 <? if ($oSystem->checkPriv($vUser,"mdm_stockist")) { ?>                     
					
                    <li class="has-sub <?=$vActive?> <?=$vExpand?>">
						<a href="javascript:;">
							<span class="badge pull-right hide">10</span>
                             <b class="caret pull-right "></b>
							<i class="fa fa-share-alt"></i> 
							<span>Stockist</span>
						</a>
						<ul class="sub-menu">
                        <li class="hide"><a href="../manager/regstockist.php"> Register New Stockist</a></li>

                       <!-- <li><a href="../manager/regmasterstockist.php"> Register Master Agent</a></li>



                        <li><a href="../manager/entrypo.php"> Entry MS PO</a></li> -->
                         <? if ($oSystem->checkPriv($vUser,"mdm_stockist_poappv")) { ?>  <li><a href="../manager/approvepo.php"><i>&radic;</i> Stockist PO Approval</a></li><? } ?>
                         <? if ($oSystem->checkPriv($vUser,"mdm_stockist_serappv")) { ?>  <li><a href="../manager/approvekit.php"><i>&radic;</i> St. PO Serial Approval</a></li><? } ?>
                        <? if ($oSystem->checkPriv($vUser,"mdm_stockist_regappv")) { ?> <li><a href="../manager/approvest.php"><i>&radic;</i> Stockist Reg. Approval</a></li><? } ?>
                          
                         


						</ul>
					</li>
                  <?  } ?>                      
					
					
					
              <?
                   $vArrMaster=array('rptbnsspon.php','pairingcf.php','pairing.php','rptrewardmem.php','statemonth.php','statemonthbm.php','stateday.php','statedaybm.php','rptbnssponreal.php','rptbnsdevel.php','rptbnsmatch.php','rptbnsps.php','rptbnsnetdev.php','rptbnsroyalty.php','rptactivation.php','rptsumreg.php','rptdetreg.php','rptsumomzet.php','rptsumstockout.php','rptrewardadm.php','rpttour.php','cftransday.php','cftransmonth.php','statemonthstbm.php','cftransmonthst.php');
				   $vMenu=$_SERVER['SCRIPT_NAME'];
				   $vMenu=explode("/",$vMenu);
				   $vCountExplode=count($vMenu);
				   $vLast=$vCountExplode -1;
				   if (in_array($vMenu[$vLast],$vArrMaster)) {
				      $vActive='active';
					  $vExpand= 'expand';
				   } else	 { 
				      $vActive='';
					   $vExpand='';
				   }
					  
					//$vPaket=$oMember->getPaketID($_SESSION['LoginUser']);  

				?>                    
					<? if ($oSystem->checkPriv($vUser,"mdm_report")) { ?> 
                    <li class="has-sub <?=$vActive?> <?=$vExpand?>">
						<a href="javascript:;">
							<span class="badge pull-right hide">10</span>
                             <b class="caret pull-right "></b>
							<i class="fa fa-credit-card"></i> 
							<span>Reports </span>
						</a>
						<ul class="sub-menu">
						<? if ($oSystem->checkPriv($vUser,"mdm_report_omzetsum")) { ?> <li><a href="../manager/rptsumomzet.php"> Turnover Summary</a></li><? } ?>
                        <? if ($oSystem->checkPriv($vUser,"mdm_report_stockosum")) { ?> <li><a href="../manager/rptsumstockout.php"> Stock Out Summary </a></li><? } ?> 
                        <? if ($oSystem->checkPriv($vUser,"mdm_report_regsum")) { ?> <li><a href="../manager/rptsumreg.php"> Registration Summary</a></li><? } ?> 
                        <? if ($oSystem->checkPriv($vUser,"mdm_report_reg")) { ?> <li><a href="../manager/rptactivation.php"> Activation </a></li><? } ?> 
                        
						<? if ($oSystem->checkPriv($vUser,"mdm_report_romem")) { ?>  <li><a href="../memstock/rptromember.php"> RO Member </a></li><? } ?> 
                        <? if ($oSystem->checkPriv($vUser,"mdm_report_autoro")) { ?>  <li><a href="../memstock/rptautoro.php"> Auto RO Member </a></li><? } ?> 

                       
<!--
                        <li><a href="../manager/rptkitout.php"> Starter KIT Keluar</a></li>

                        <li><a href="../manager/rptsumkitout.php"> Summary KIT Keluar</a></li> -->

              
                         


                        
                          

						<? if ($oSystem->checkPriv($vUser,"mdm_report_tax")) { ?> <li><a href="../manager/rptincometax.php"> Income Tax </a></li><? } ?> 
						<? if ($oSystem->checkPriv($vUser,"mdm_report_topspon")) { ?> <li><a href="../manager/rptincometax.php"> <li><a href="../manager/rpt_topspon.php"> Top Referensi </li></a> </a></li><? } ?> 
                        <? if ($oSystem->checkPriv($vUser,"mdm_report_rwdlead")) { ?> <li><a href="../manager/rptincometax.php"> <li><a href="../manager/rptrewards.php"> Penghrg. Kepemimpinan</li></a> </a></li><? } ?>   
						<? if ($oSystem->checkPriv($vUser,"mdm_report_klubpres")) { ?>  <li><a href="../manager/rptrewardso.php">Bns. Klub Presiden</a></li> </a></li><? } ?> 
                         <? if ($oSystem->checkPriv($vUser,"mdm_report_stateday")) { ?>  <li><a href="../manager/stateday.php"> Statement Report Harian </a></li><? } ?> 
						<? if ($oSystem->checkPriv($vUser,"mdm_report_mandiriday")) { ?>  <li><a style="color:yellow" href="../manager/statedaybm.php"> Transfer Mandiri Harian </a></li><? } ?> 
  						  <? if ($oSystem->checkPriv($vUser,"mdm_report_cftrday")) { ?>  <li><li><a href="../manager/cftransday.php"> Rpt CF Transfer Harian </a></li><? } ?> 
                          
                          <? if ($oSystem->checkPriv($vUser,"mdm_report_statemo")) { ?>   <li><a href="../manager/statemonth.php">  Statement Report Bulanan </a></li><? } ?> 
                          
  <? if ($oSystem->checkPriv($vUser,"mdm_report_statemo")) { ?>   <li><a href="../manager/statemonthst.php">  Statement Bulanan Stockist</a></li><? } ?>                         
                          
						  <? if ($oSystem->checkPriv($vUser,"mdm_report_mandirimo")) { ?>  <li><a style="color:yellow" href="../manager/statemonthbm.php"> Transfer Mandiri Bulanan </a></li><? } ?> 
                         
                  <? if ($oSystem->checkPriv($vUser,"mdm_report_cftrmo")) { ?>  <li><a href="../manager/cftransmonth.php"> Rpt CF Transfer Bulanan </a></li><? } ?>          

<? if ($oSystem->checkPriv($vUser,"mdm_report_mandirimo")) { ?>  <li ><a style="color:yellow" class="ahover"  href="../manager/statemonthstbm.php"> Trans Mandiri Bns Stockist </a></li><? } ?> 
       
                  <? if ($oSystem->checkPriv($vUser,"mdm_report_cftrmo")) { ?>  <li><a href="../manager/cftransmonthst.php"> Rpt CF Transfer Bln Stockist </a></li><? } ?>          
                            
<? if ($oSystem->checkPriv($vUser,"mdm_report_rwd")) { ?>  <li><a href="../manager/rptrewardadm.php"> Reward Report </a></li><? } ?><? if ($oSystem->checkPriv($vUser,"mdm_report_tour")) { ?>  <li><a href="../manager/rpttour.php"> Tour Report </a></li><? } ?>                                      
                          
                           
                            
                           
                           

						</ul>
					</li>					
					<? } ?>


            
                    					
					<li><a href="../manager/passwdadmin.php"><i class="fa fa-key"></i> <span>Change Password</span></a></li>
                    <li><a href="../main/logout.php"><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>
					
					                

					
					
					
					
					
					
			        <!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
			        <!-- end sidebar minify button -->
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end #sidebar -->