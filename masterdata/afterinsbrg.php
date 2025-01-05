<?
 @mkdir("../images/prod/".$_POST['PME_data_fidproduk'],0755);
 @mkdir("../images/prod/".$_POST['PME_data_fidproduk']."/thumb",0755);
 @chmod("../images/prod/".$_POST['PME_data_fidproduk']."/thumb",0777);
 @chmod("../images/prod/".$_POST['PME_data_fidproduk'],0777);
 
?>
