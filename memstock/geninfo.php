<li><a ><i class="fa fa-user"></i>  Sponsor : <?=$oNetwork->getSponsor($vUser)?></a></li>
<li><a ><i class="fa fa-money"></i>  Balance : <? $vSaldo=$oMember->getMemField('fsaldovcr',$vUser); echo number_format($vSaldo,0,",",".");?></a><input type="hidden" id="hSaldo" name="hSaldo" value="<?=$vSaldo?>" /></li>
                            <?
								$vDate=date("Y-m-d");
								$vSponL=$oNetwork->get1stSponsorshipLR($vUser,'L');
		 						$vSponR=$oNetwork->get1stSponsorshipLR($vUser,'R');
		 						$vOmzetPrivDownL=$oKomisi->getOmzetROAllMember($vSponL);
		 						$vOmzetPrivDownR=$oKomisi->getOmzetROAllMember($vSponR);



								
								$OmzetDownL=$oKomisi->getOmzetROWholeMember($vSponL)+$vOmzetPrivDownL;
								$OmzetDownR=$oKomisi->getOmzetROWholeMember($vSponR)+$vOmzetPrivDownR;
                            
							?>
                            
                           <li class="hide"><a ><i class="fa fa-money"></i>  Omzet Group L : <?=number_format($OmzetDownL,0,",",".")?></a></li>
                           <li class="hide"><a ><i class="fa fa-money"></i>  Omzet Group R : <?=number_format($OmzetDownR,0,",",".")?></a></li>					