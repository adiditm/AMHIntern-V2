<?
 @mkdir("../images/tour/".$_POST['PME_data_fidtour'],0755);
 @mkdir("../images/tour/".$_POST['PME_data_fidtour']."/thumb",0755);
 @chmod("../images/tour/".$_POST['PME_data_fidtour']."/thumb",0777);
 @chmod("../images/tour/".$_POST['PME_data_fidtour'],0777);
 
?>
