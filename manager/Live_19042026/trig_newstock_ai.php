<?
$vUser=strtolower($_SESSION['LoginUser']);
$vKey=$this->rec;

/*
if (!preg_match("/.png/i",$newvals['Gambar_Denah_Terminal']) && !preg_match("/.jpg/i",$newvals['Gambar_Denah_Terminal']) && !preg_match("/.jpeg/i",$newvals['Gambar_Denah_Terminal']) && !preg_match("/.gif/i",$newvals['Gambar_Denah_Terminal'])) {
    $vSQL="update m_terminal set Gambar_Denah_Terminal='".$oldvals['Gambar_Denah_Terminal']."' where fidsys=".$this->rec;
   $this->myquery($vSQL);
}

*/
   
   $vIDMem=$newvals['fidmember'];
   $vIDProd=$newvals['fidproduk'];
   $vBal=$newvals['fbalance'];
   $vIDSys=$newvals['fidsys'];
   
   $vSQL="INSERT INTO tb_mutasi_stok (fidmember, fidproduk, fidfunder, ftanggal, fdesc, fcredit, fdebit, fbalance, fkind, fstatus, flastuser, flastupdate, fref) ";
   
   $vSQL .="values('$vIDMem', '$vIDProd', 'admin', now(), 'Opening Balance', $vBal, 0, $vBal, 'opbal', '1', '$vUser', now(), '$vIDSys')";
   $this->myquery($vSQL);

/*
if (!preg_match("/.xls/i",$newvals['lampiran']) && !preg_match("/.xlsx/i",$newvals['lampiran'])) {
    $vSQL="update m_terminal set lampiran='".$oldvals['lampiran']."' where fidsys=".$this->rec;
   $this->myquery($vSQL);
}
*/


?>