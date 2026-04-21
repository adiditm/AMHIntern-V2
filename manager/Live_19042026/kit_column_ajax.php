<?
session_start();
   
   $vEco=$_GET['eco'];
   $vBus = $_GET['bus'];
   $v1st = $_GET['x1st'];
   
   if ($vEco=='') $vEco=0;
   if ($vBus=='') $vBus=0;
   if ($v1st=='') $v1st=0;
   
   
   
?>


    							<table style="width: 90%" cellpadding="6" class="table">
									<tr style="font-weight:bold">
										<td width="33%" valign="top">
										 Economy&nbsp;</td>
										<td width="33%" valign="top">
							               	 Business&nbsp;</td>
										<td width="33%" valign="top">
										 First&nbsp;</td>
									</tr>
									<tr>
										<td valign="top">
										 <div class="row">
							                  <? for ($i=0;$i<$vEco;$i++) {?>
												 <div class="col-sm-8 col-md-8 col-lg-8"><input lang="UEC" id="KIT_E<?=$i?>" name="KIT_E[]" type="text" class="form-control" onblur="checkValidKit(this)" /></div>
											  <? } ?>	 
										</div>
										
										</td>
										<td valign="top">
							               	 <div class="row">
												<? for ($i=0;$i<$vBus;$i++) {?>
							                    <div class="col-sm-8 col-md-8 col-lg-8"><input lang="UBC" id="KIT_B<?=$i?>" name="KIT_B[]" type="text" class="form-control" onblur="checkValidKit(this)" /></div>
							                   <? } ?>
											</div>
										
										</td>
										<td valign="top">
										 <div class="row">
							                  <? for ($i=0;$i<$v1st;$i++) {?>                    
												 <div class="col-sm-8 col-md-8 col-lg-8"><input lang="UFC" id="KIT_F<?=$i?>" name="KIT_F[]" type="text" class="form-control" onblur="checkValidKit(this)" /></div>
											  <? } ?>	 
											  </div>
										
										</td>
									</tr>
								</table>
