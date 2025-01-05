 <!-- sidebar menu -->
<?
//  include_once("../classes/memberclass.php");
  $vIsStock = $oMember->getMemField("fstockist",$_SESSION['LoginUser']);
  $vCurrent=$_GET['current'];
  if($vCurrent == '') $vCurrent='mdm_dashboard';
?>
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <!--<h3>General</h3>-->
                <ul class="nav side-menu">
                
                <?
                    $vSQL="select * from m_lang_".$_SESSION['lang']." where 1  and fismenu='1' and flevel='1' order by fseq ";
                    $dbmenu->query($vSQL);
                    
                    while($dbmenu->next_record()) {
                            $vMenuTitle=$dbmenu->f("flangtext");
                            $vMenuID=$dbmenu->f("flangid");
                            $vIcon = $dbmenu->f('ficon');
							$vHasSub = $dbmenu->f('fhassub');
							$vLink = $dbmenu->f("flink");
							$vSeq = $dbmenu->f("fseq");
							 if (($vIsStock !='0' && substr($vSeq,0,1) == '2') || substr($vSeq,0,1) != '2')  {
                            
                ?>
                <? if($vHasSub=='1' ) { ?>
                  <li class="<? if ($vCurrent==$vMenuID) echo 'active';?>"><a><i class="fa <?=$vIcon?>"></i> <?=$vMenuTitle?> <i class="fa fa-chevron-down"></i></a>
                <? } else { ?>
                  <li class="<? if ($vCurrent==$vMenuID) echo 'active';?>" ><a href="<?=$vLink?>?op=admin&current=<?=$vMenuID?>"><i class="fa <?=$vIcon?>"></i> <?=$vMenuTitle?> </a>
                <? } ?>  
                    <ul class="nav child_menu " <? if ($vCurrent==$vMenuID) echo 'style="display: block;"';?> >
                      <?
                         $vSQL="select * from m_lang_".$_SESSION['lang']." where 1 and fismenu='1' and flevel='2' and fparent='$vMenuID' order by fseq  ";
                       $dbmenuin->query($vSQL);
                         while($dbmenuin->next_record()) {
                            $vMenuTitleIn=$dbmenuin->f("flangtext");
                            $vMenuIDIn=$dbmenuin->f("flangid");
                            $vLinkIn = $dbmenuin->f("flink");
							$vParent = $dbmenuin->f("fparent");
							$vSeq = $dbmenu->f("fseq");
                           // $vIcon = $dbmenu->f('ficon');
						   $vOP='';
						   if ($vMenuIDIn=='mdm_memnet_genea') $vOP='admin';
						   if (($vIsStock !='0' && substr($vSeq,0,1) == '2') || substr($vSeq,0,1) != '2')  {
                      ?>
                      
                      <li ><a href="<?=$vLinkIn?>?op=<?=$vOP?>&current=<?=$vParent?>&menu=<?=$vMenuIDIn?>">&equiv; <?=$vMenuTitleIn?></a></li>
                      <? }
					}
					   ?>
                    </ul>
                  </li>
                  
                <? } 
					} //while luar?>  
                </ul>
              </div>
              <!--<div class="menu_section">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                  
                  <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="#level1_1">Level One</a>
                        <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li class="sub_menu"><a href="level2.html">Level Two</a>
                            </li>
                            <li><a href="#level2_1">Level Two</a>
                            </li>
                            <li><a href="#level2_2">Level Two</a>
                            </li>
                          </ul>
                        </li>
                        <li><a href="#level1_2">Level One</a>
                        </li>
                    </ul>
                  </li>
                </ul>
              </div>-->

            </div>
<!-- /sidebar menu -->            
