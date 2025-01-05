<div class="left-side sticky-left-side">



        <!--logo and iconic logo start-->

        <div class="logo">

            <a href="../manager/indexadmin.php"><img src="../images/admin-logo.png" alt="" ></a>

        </div>



        <div class="logo-icon text-center">

            <a href="index.html"><img src="../images/logo_icon.png" alt=""></a>

        </div>

        <!--logo and iconic logo end-->



        <div class="left-side-inner">



            <!-- visible to small devices only -->

            <div class="visible-xs hidden-sm hidden-md hidden-lg">

                <div class="media logged-user">

                    <img alt="" src="../images/admin-icon.png" class="media-object">

                    <div class="media-body">

                        <h4> <?=$vUser." (".$oMember->getMemFieldAdmin('fnama','manager').")";?></h4>

                       

                    </div>

                </div>



                <h5 class="left-nav-title">Account Information</h5>

                <ul class="nav nav-pills nav-stacked custom-nav">

                  <li><a href="../manager/passwdadmin.php"><i class="fa fa-user"></i> <span>Change Password</span></a></li>

                 

                  <li><a href="../main/logout.php"><i class="fa fa-sign-out"></i> <span>Sign Out</span></a></li>

                </ul>

            </div>



            <!--sidebar nav start-->

            <ul class="nav nav-pills nav-stacked custom-nav">

                <li ><a href="../manager/indexadmin.php"><i class="fa fa-home"></i> <span>Dashboard</span></a>

                    

                </li>



                <li ><a href="../manager/passwdadmin.php"><i class="fa fa-key"></i> <span>Change Password</span></a>

                    

                </li>

                <?

                   $vArrMaster=array('madmin.php','mbank.php','mbarang.php','mcatbarang.php','mcountry.php','msize.php','mcolor.php','msetting.php','mkurs.php');

				   $vMenu=$_SERVER['SCRIPT_NAME'];

				   $vMenu=explode("/",$vMenu);

				   $vCountExplode=count($vMenu);

				   $vLast=$vCountExplode -1;

				   if (in_array($vMenu[$vLast],$vArrMaster))

				      $vActive='active';

				   else	  

				      $vActive='';

				   

				?>

                <li class="menu-list <?=$vActive?>"><a href="#"><i class="fa fa-tasks"></i> <span>Master Data</span></a>

                    <ul class="sub-menu-list">

                        <li><a href="../masterdata/msize.php">Ukuran</a></li>

                        <li><a href="../masterdata/mcolor.php">Warna</a></li>

                        <li><a href="../masterdata/mcatbarang.php">Kategori Barang</a></li>

                        <li><a href="../masterdata/mbarang.php"> Barang</a></li>

                        <li><a href="../masterdata/mbank.php"> Bank</a></li>

                        <li><a href="../masterdata/mcountry.php"> Negara</a></li>

                        <li><a href="../masterdata/mkurs.php"> Rate</a></li>

                        <li><a href="../masterdata/madmin.php"> User Admin</a></li>

                        <li><a href="../masterdata/msetting.php"> System Setting</a></li>



                    </ul>

                    

                </li>

                                <?

                   $vArrMaster=array('aktif.php','aktiftemp.php','profiletemp.php','profile.php','veriwith.php','veriro.php','koreksi.php','koreksistock.php','rptstock.php','rptkit.php','ewalletbal.php','stockbal.php','historyro.php','stjaringan.php','reorder.php','register.php','genelogi2.php');

				   $vMenu=$_SERVER['SCRIPT_NAME'];

				   $vMenu=explode("/",$vMenu);

				   $vCountExplode=count($vMenu);

				   $vLast=$vCountExplode -1;

				   if (in_array($vMenu[$vLast],$vArrMaster))

				      $vActive='active';

				   else	  

				      $vActive='';

				   

				?>



                <li class="menu-list <?=$vActive?>"><a href=""><i class="fa fa-cogs"></i> <span>Member & Network</span></a>

                    <ul class="sub-menu-list">

                        <li><a href="../manager/aktif.php"> Members Profile</a></li>

                        <li><a href="../memstock/genealogi2.php"> Genealogi</a></li>



                         <li><a href="../manager/aktiftemp.php"> Members Bebek Hanyut</a></li>



                        <li><a href="../manager/veriwith.php"> Withdraw Approval</a></li>

                         <li><a href="../manager/veriro.php"> List Repeat Order</a></li>

						 <li><a href="../memstock/registerst.php"> Register New Member</a></li>

						 <li><a href="../memstock/reorder.php"> Member RO</a></li>







                    </ul>

                </li>



          

                 

           



                                <?

                   $vArrMaster=array('regstockist.php','regmasterstockist.php','entrypo.php');

				   $vMenu=$_SERVER['SCRIPT_NAME'];

				   $vMenu=explode("/",$vMenu);

				   $vCountExplode=count($vMenu);

				   $vLast=$vCountExplode -1;

				   if (in_array($vMenu[$vLast],$vArrMaster))

				      $vActive='active';

				   else	  

				      $vActive='';

				   

				?>



                <li class="menu-list <?=$vActive?>"><a href=""><i class="fa fa-cogs"></i> <span>Stockist</span></a>

                    <ul class="sub-menu-list">

                        <li><a href="../manager/regstockist.php"> Register New Agent</a></li>

                        <li><a href="../manager/regmasterstockist.php"> Register Master Agent</a></li>



                        <li><a href="../manager/entrypo.php"> Entry Agent PO</a></li>

                        

                    </ul>

                </li>



               <?    $vArrMaster=array('rptstockout.php','rptsumstockout.php','rptkitout.php','rptsumkitout.php','rptsumomzet.php','rptadjustment.php');

				   $vMenu=$_SERVER['SCRIPT_NAME'];

				   $vMenu=explode("/",$vMenu);

				   $vCountExplode=count($vMenu);

				   $vLast=$vCountExplode -1;

				   if (in_array($vMenu[$vLast],$vArrMaster))

				      $vActive='active';

				   else	  

				      $vActive='';

				   

				?>



                <li class="menu-list <?=$vActive?>"><a href=""><i class="fa fa-bars"></i> <span>Reports</span></a>

                    <ul class="sub-menu-list">

                        <li><a href="../manager/rptsumomzet.php"> Omzet Summary</a></li>

                         <li><a href="../manager/rptadjustment.php"> Stock Adjustment Summary</a></li>

                        <li><a href="../manager/rptsumstockout.php"> Summary Barang Keluar</a></li>

                       

                        <li><a href="../manager/rptkitout.php"> Starter KIT Keluar</a></li>

                        <li><a href="../manager/rptsumkitout.php"> Summary KIT Keluar</a></li>

                    </ul>

                </li>



  



            

            </ul>



                                

  



            

            </ul>





            <!--sidebar nav end-->



        </div>

    </div>