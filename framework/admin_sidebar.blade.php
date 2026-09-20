<!-- sidebar menu -->
<?
  $vCurrent=$_GET['current'];
  if($vCurrent == '') $vCurrent='mdm_dashboard';
  $vMenuChoosed = $_GET['menu'];
?>
<ul>
<?
    if ($_SESSION['Kind']=='member') {
        $vSQL="select * from m_menu where is_active='1' and fismenu='1' and flevel='1' and fpriv like '%{$_SESSION['Kind']}%' order by menu_order, menu_id, flink  ";
    } else if ($vPriv=='administrator')  {
        $vSQL="select * from m_menu where is_active='1' and fismenu='1' and flevel='1' and menu_id  in (select menu_id from tb_menupriv where user_id='$vUser') order by menu_order, menu_id, flink  ";
    } else {
        $vSQL="select * from m_menu where is_active='1' and fismenu='1' and flevel='1' and fpriv like '%$vPriv%' order by menu_order, menu_id, flink  ";
    }
    $dbmenu->query($vSQL);
    while($dbmenu->next_record()) {
        $vMenuTitle=$dbmenu->f("menu_title");
        $vMenuID=$dbmenu->f("menu_id");
        $vIcon = $dbmenu->f('ficon');
        $vHasSub = $dbmenu->f('fhassub');
        $vLink = $dbmenu->f("flink");
?>
    <li class="<? if ($vCurrent==$vMenuID) echo 'active';?>">
      <? if($vHasSub=='1' ) { ?>
        <a href="javascript:;"><i class="fa <?=$vIcon?>"></i> <?=$vMenuTitle?> <i class="fa fa-chevron-down" style="float:right;"></i></a>
      <? } else { ?>
        <a href="<?=$vLink?>?op=admin&current=<?=$vMenuID?>"><i class="fa <?=$vIcon?>"></i> <?=$vMenuTitle?></a>
      <? } ?>
      <ul class="amh-submenu" <? if ($vCurrent==$vMenuID) echo 'style="display:block;"'; else echo 'style="display:none;"';?>>
        <?
        if ($vPriv=='administrator') {
            $vSQL="select * from m_menu where is_active='1' and fismenu='1' and flevel='2' and fparent='$vMenuID' and fpriv like '%$vPriv%' and menu_id  in (select menu_id from tb_menupriv where user_id='$vUser') order by menu_order, menu_id, flink  ";
            $dbmenuin->query($vSQL);
        } else {
            $vSQL="select * from m_menu where is_active='1' and fismenu='1' and flevel='2' and fparent='$vMenuID' and fpriv like '%$vPriv%'  order by menu_order, menu_id, flink  ";
            $dbmenuin->query($vSQL);
        }
        while($dbmenuin->next_record()) {
            $vMenuTitleIn=$dbmenuin->f("menu_title");
            $vMenuIDIn=$dbmenuin->f("menu_id");
            $vLinkIn = $dbmenuin->f("flink");
            $vParent = $dbmenuin->f("fparent");
            $vOP='';
            if ($vMenuIDIn=='mdm_memnet_genea') $vOP='admin';
        ?>
        <li><a href="<?=$vLinkIn?>?op=<?=$vOP?>&current=<?=$vParent?>&menu=<?=$vMenuIDIn?>" class="<? if ($vMenuChoosed==$vMenuIDIn && basename($_SERVER['PHP_SELF'])==basename($vLinkIn)) echo 'active'; ?>">&equiv; <?=$vMenuTitleIn?></a>
        </li>
        <? if ($vMenuIDIn=='spon_trans_prd') { ?>
        <li><a href="../memstock/statustrans.php">&equiv; Status Transaksi</a></li>
        <? } ?>
        <? } ?>
      </ul>
    </li>
<? } ?>
</ul>
<!-- /sidebar menu -->
