<? include_once("../framework/member_headside.blade.php")?>
<style type="text/css">
   .widget-stats {padding:5px 5px 5px 5px; border-radius:3px};
   
</style>
    <!-- end #headside -->
		
		<!-- begin #content -->
		<div class="right_col" role="main">

  
  
  <div><label><h3><?=$oInterface->getWord('0001',$_SESSION['lang'],'Dasbor')?> </h3></label></div>
			
			<!-- begin page-header -->
		
        
			<!-- end page-header -->
			
			<!-- begin row -->
			<div class="row">
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-green">
						<div class="stats-icon"><i class="fa fa-desktop"></i></div>
						<div class="stats-info">
							<h4><?=strtoupper($oInterface->getWord('0002',$_SESSION['lang'],'TOTAL SPONSOR'))?></h4>
							<p><?=$oNetwork->getSponsorshipCount($vUser)?></p>	
						</div>
						<div class="stats-link hide">
							<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-blue">
						<div class="stats-icon"><i class="fa fa-chain-broken"></i></div>
						<div class="stats-info">
							<h4><?=strtoupper($oInterface->getWord('0003',$_SESSION['lang'],'MITRA KIRI / KANAN'))?></h4>
							<p>L : <?=number_format($oNetwork->getDownlineCountLR($vUser,'L'),0)?>  | R: <?=number_format($oNetwork->getDownlineCountLR($vUser,'R'),0)?></p>	
						</div>
						<div class="stats-link hide">
							<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-purple">
						<div class="stats-icon"><i class="fa fa-users"></i></div>
						<div class="stats-info">
							<h4><?=strtoupper($oInterface->getWord('0004',$_SESSION['lang'],'TOTAL BELANJA ULANG (BU)'))?></h4>
							<p><?=number_format($oJual->getBuyedTot($vUser),0)?></p>	
						</div>
						<div class="stats-link hide">
							<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
				<!-- begin col-3 -->
				<div class="col-md-3 col-sm-6 hide">
					<div class="widget widget-stats bg-red">
						<div class="stats-icon"><i class="fa fa-clock-o"></i></div>
						<div class="stats-info">
							<h4>OUTSTANDING BONUS</h4>
							<p><?=number_format($oKomisi->getAllBonusStand($vUser),0)?></p>	
						</div>
						<div class="stats-link hide">
							<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>
				<!-- end col-3 -->
                

<div class="col-md-3 col-sm-6">
					<div class="widget widget-stats bg-orange">
						<div class="stats-icon"><i class="fa fa-clock-o"></i></div>
						<div class="stats-info">
							<h4><?=strtoupper($oInterface->getWord('0005',$_SESSION['lang'],'TOTAL BONUS'))?></h4>
							<p><?=number_format($oKomisi->getAllBonus($vUser),0)?></p>	
						</div>
						<div class="stats-link hide">
							<a href="javascript:;">View Detail <i class="fa fa-arrow-circle-o-right"></i></a>
						</div>
					</div>
				</div>                
			</div>
			<!-- end row -->
			<!-- begin row --><!-- end row -->
		</div>
		<!-- end #content -->
		
        <!-- begin theme-panel -->

        <!-- end theme-panel -->
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->

	<!-- end page container -->
	


<? include_once("../framework/member_footside.blade.php") ; ?>



