<? include_once("../framework/masterheader.php")?>
<script language="Javascript">
$(document).ready(function(){
      $('#caption').html('Summary');
});	
	
	
</script>

<body class="sticky-header">

<section>
    <!-- left side start-->
    <? include "../framework/leftmem.php"; ?>
    <!-- left side end-->
    
    <!-- main content start-->
    <div class="main-content" >

        <!-- header section start-->
        <? include "../framework/headermem.php"; ?>
        <!-- header section end-->



        <!--body wrapper start-->
        <div class="wrapper">
         <div class="hide"><label>Dashboard</label></div>
    
         
       <script src="../flex/js/modernizr.js"></script>
		<script defer src="../flex/js/jquery.flexslider.js"></script>

  <script type="text/javascript">
    $(function(){
      SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
  </script>    

         
            <div class="row states-info" style="display:"> <!-- dashboard -->
            <div class="col-md-3">
                <div class="panel red-bg" style="min-height:100px;cursor:pointer" onClick="document.location.href='../memstock/stjaringan.php'">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-money"></i>
                            </div>
                            <div class="col-xs-8">
                                <span class="state-title"> Total Direct Sponsor </span>
                                <h4> <?=number_format($oNetwork->getSponsorShipCount($vUser),0,',','.')?>
</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel blue-bg" style="min-height:100px">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-tag"></i>
                            </div>
                            <div class="col-xs-8">
                                <span class="state-title">  Total Downlines  </span>
                                <h4> L : <?=number_format($oNetwork->getDownlineCountLR($vUser,'L'),0,',','.')?>
                               &nbsp;|&nbsp; R : <? if ($oNetwork->hasDownlineLR($vUser,'R')=='1') echo number_format($oNetwork->getDownlineCountLR($vUser,'R'),0,',','.'); else echo 0;?>

</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel green-bg"  style="background-color:maroon;min-height:100px">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-money"></i>
                            </div>
                            <div class="col-xs-8">
                                Nex<span class="state-title"> Wallet Balance  </span>
                                <h4>IDR <?=number_format($oMember->getMemField('fsaldovcr',$vUser),0,".",",")?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel yellow-bg" style="min-height:100px">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-th-large"></i>
                            </div>
                            <div class="col-xs-8">
                                <span class="state-title">  Package </span>
                                <h4>
                                <?
                                   $vPack=$oMember->getPaket($vUser);
                                   if ($vPack=='E' || $vPack=='S')
                                      echo 'Silver';
                                   else if ($vPack=='B' || $vPack=='G')   
                                      echo 'Gold';
                                   else echo 'Platinum';   
                                ?>
                                
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
<div class="col-md-3">
                <div class="panel green-bg" style="min-height:100px">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-th-large"></i>
                            </div>
                            <div class="col-xs-8">
                                <span class="state-title">  Peringkat </span>
                                <h4>
                                <?
                                   $vPering=$oMember->getMemField('flevel',$vUser);
                                   if ($vPering=='E')
                                      echo 'Executive';
                                   else if ($vPering=='PE')   
                                      echo 'Platinum Executive';
                                   else if ($vPering=='M')   
                                      echo 'Manager';
                                   else if ($vPering=='PM')   
                                      echo 'Platinum Manager';
                                   else if ($vPering=='D')   
                                      echo 'Director';
                                   else if ($vPering=='RD')   
                                      echo 'Royal Director';

                                   else echo '-';   
                                ?>
                                
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            



<div class="col-md-3">
                <div class="panel" style="min-height:100px;background-color:#00F">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-th-large"></i>
                            </div>
                            <div class="col-xs-8">
                                <span class="state-title"> CF Real Time </span>
                                <h4>
                                <?
										 $vSQL="select max(fidsys) as fmaxid from tb_kom_coupcf where fidreceiver='$vUser'";
										 $dbin->query($vSQL);
										 $dbin->next_record();
										 $vMaxid= $dbin->f('fmaxid');
										 if ($vMaxid=='') { 
										    $vMaxid=0;
											$vCFSisaL=0;
											$vCFSisaR=0;
										 } else {
											$vSQL="select * from tb_kom_coupcf where fidsys=$vMaxid";
											$dbin->query($vSQL);
											$dbin->next_record();
											$vCF=$dbin->f('fcf');
											$vLR=$dbin->f('flr');
											if ($vLR=='L') {
											   $vCFSisaL= $vCF;
											   $vCFSisaR= 0;

											} 	else if ($vLR=='R') {
											   $vCFSisaR= $vCF;
											   $vCFSisaL= 0;

											}

										 }
										 
										 $vKakiL=$oNetwork->getDownLR($vUser,'L');
										 $vKakiR=$oNetwork->getDownLR($vUser,'R');
										$vDate=date('Y-m-d');
										if ($vKakiL !=-1 && $vKakiL !='') {
											$OmzetDownL=$oNetwork->getDownlineCountActivePeriod($vKakiL,$vDateNow,$vDateNow);
											
										} else	{
											$OmzetDownL=0;
											
										}
											
										if ($vKakiR !=-1 && $vKakiR !='') {
											$OmzetDownR=$oNetwork->getDownlineCountActivePeriod($vKakiR,$vDateNow,$vDateNow);
											
										} else	{
											$OmzetDownR=0;
										}
											
											
						
										 
										 $vCFNowL=$OmzetDownL;
										 $vCFNowR=$OmzetDownR ;
										 echo "L: ".number_format($vCFNowL + $vCFSisaL,0,",",".");
										 echo " | ";
										 echo "R: ".number_format($vCFNowR + $vCFSisaR,0,",",".");
                                ?>
                                
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

 
 <div class="col-md-3">
                <div class="panel" style="min-height:100px;background-color:#C09">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4 hide">
                                <i class="fa fa-th-large"></i>
                            </div>
                            <div class="col-xs-8 col-lg-8" style="width:13em">
                                <span class="state-title"> Omzet RO Kiri Kanan </span>
                                <h4>
                                <?
										   $vRegular4=$oNetwork->getDownlinePos($vUser); 
										   $vOmzetPriv=$oKomisi->getOmzetROMonthMember($vUser,date('m'),date('Y'));
										   $vOmzetPriv+=$oKomisi->getOmzetROMonthMemberWallet($vUser,date('m'),date('Y'));
									
										   $vOmzetDownL=$oKomisi->getOmzetROWholeMemberMonth($vRegular4['L'],date('m'),date('Y'));
										   $vOmzetDownR=$oKomisi->getOmzetROWholeMemberMonth($vRegular4['R'],date('m'),date('Y'));
										   $vOmzetDownLW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular4['L'],date('m'),date('Y'));
										   $vOmzetDownRW=$oKomisi->getOmzetROWholeMemberMonthWallet($vRegular4['R'],date('m'),date('Y'));
								
										   $vOmzetDownLF=number_format(($vOmzetDownL+$vOmzetDownLW)/1000,0,",",".");
										   $vOmzetDownRF=number_format(($vOmzetDownR+$vOmzetDownRW)/1000,0,",",".");
										   echo "L: ".$vOmzetDownLF."K";
										   echo " | ";
										   echo "R: ".$vOmzetDownRF."K";
                                ?>
                                
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div> 


            
        </div>         <!--body wrapper end-->

   

    </div>
    <!-- main content end-->
</section>

<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>

<script src="../js/jquery-migrate-1.2.1.min.js"></script>



<script src="../js/modernizr.min.js"></script>

<script src="../js/jquery.nicescroll.js"></script>





<!--common scripts for all pages-->

<script src="../js/scripts.js"></script>


<!--common scripts for all pages-->
<div align="center">
<? include "../framework/footer.php";?>
</div>
</body>
</html>
