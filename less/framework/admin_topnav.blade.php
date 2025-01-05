<!-- top navigation -->
<?
 if ($vPriv=='sponsor')
     $vJenis = 'sponsor';
 else if ($vPriv=='korwil')
     $vJenis = 'korwil';
 else $vJenis='';	
?>
<div class="top_nav">

          <div class="nav_menu">

            <nav>

              <div class="nav toggle " style="display:inline">

                <a id="menu_toggle"><i class="fa fa-bars"></i></a>

              </div>
              <? if($vMarkDev !='') { ?>
              <br /><span style="margin-top:15px !important;font-weight:bold;color:#f00"><?=$vMarkDev?></span>
              <? } ?>



              <ul class="nav navbar-nav navbar-right">

                <li class="">

                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">

                    <!--<img src="../images/img.jpg" alt="">--><span class="fa fa-user-circle" style="font-size:1.7em"></span> <?=$_SESSION['LoginUser']?>

                    <span class=" fa fa-angle-down"></span>

                  </a>

                  <ul class="dropdown-menu dropdown-usermenu pull-right">

                  <!--  <li><a href="../masterdata/madmin.php"> Profile</a></li>

                    <li>

                      <a href="javascript:;">

                        <span class="badge bg-red pull-right">50%</span>

                        <span>Settings</span>

                      </a>

                    </li>
					<? 
					   if ($vJenis=='korwil') {
                                $vsql="select a.fidbisnis from m_korwil a   where a.fidkorwil='$vUser' ";	
                                $db->query($vsql);
                                $db->next_record();
                                $vIDSal = $db->f('fidbisnis');
                                
					   } else {
                                 $vIDSal = $vUser;
					   }
					    $vSaldo= $oMember->getSaldoAdm($vUser,$vJenis);
					    $vPendingWD=$oJual->getPendingWD($vUser,$vJenis);
				 		$vPendingTrans=$oJual->getPendingTrans($vUser,$vJenis)	;
				 		
					?>
                    <li><a href="javascript:;">Help</a></li>-->
                    <li><a href="javascript:;">Saldo <br>[ID: <?=$vIDSal ?>] : <?=number_format($vSaldo,0,",",".")?></a></li> 
                    <li><a href="../main/logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>

                  </ul>

                </li>



                <li role="presentation" class="dropdown">

                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">

                   <!-- <i class="fa fa-envelope-o"></i>

                    <span class="badge bg-green">6</span>-->

                  </a>

                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">

                    <li>

                      <a>

                        <span class="image"><img src="../images/img.jpg" alt="Profile Image" /></span>

                        <span>

                          <span>John Smith</span>

                          <span class="time">3 mins ago</span>

                        </span>

                        <span class="message">

                          Film festivals used to be do-or-die moments for movie makers. They were where...

                        </span>

                      </a>

                    </li>

                    <li>

                      <a>

                        <span class="image"><img src="../images/img.jpg" alt="Profile Image" /></span>

                        <span>

                          <span>John Smith</span>

                          <span class="time">3 mins ago</span>

                        </span>

                        <span class="message">

                          Film festivals used to be do-or-die moments for movie makers. They were where...

                        </span>

                      </a>

                    </li>

                    <li>

                      <a>

                        <span class="image"><img src="../images/img.jpg" alt="Profile Image" /></span>

                        <span>

                          <span>John Smith</span>

                          <span class="time">3 mins ago</span>

                        </span>

                        <span class="message">

                          Film festivals used to be do-or-die moments for movie makers. They were where...

                        </span>

                      </a>

                    </li>

                    <li>

                      <a>

                        <span class="image"><img src="../images/img.jpg" alt="Profile Image" /></span>

                        <span>

                          <span>John Smith</span>

                          <span class="time">3 mins ago</span>

                        </span>

                        <span class="message">

                          Film festivals used to be do-or-die moments for movie makers. They were where...

                        </span>

                      </a>

                    </li>

                    <li>

                      <div class="text-center">

                        <a>

                          <strong>See All Alerts</strong>

                          <i class="fa fa-angle-right"></i>

                        </a>

                      </div>

                    </li>

                  </ul>

                </li>

              </ul>

            </nav>

          </div>

        </div>

         <!-- /top navigation -->
