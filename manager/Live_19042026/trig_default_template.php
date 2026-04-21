<?
$vUser=strtolower($_SESSION['LoginUser']);
 $vKey=$this->rec;

/*
if (!preg_match("/.png/i",$newvals['Gambar_Denah_Terminal']) && !preg_match("/.jpg/i",$newvals['Gambar_Denah_Terminal']) && !preg_match("/.jpeg/i",$newvals['Gambar_Denah_Terminal']) && !preg_match("/.gif/i",$newvals['Gambar_Denah_Terminal'])) {
    $vSQL="update m_terminal set Gambar_Denah_Terminal='".$oldvals['Gambar_Denah_Terminal']."' where fidsys=".$this->rec;
   $this->myquery($vSQL);
}

*/
   
 
   $vDefault=$newvals['fdefault'];
   if ($vDefault=='1') {
   		$vSQL="update tb_recomm set fdefault='0' where fidsys <> $vKey ;";
   	$this->myquery($vSQL);
   }

/*
if (!preg_match("/.xls/i",$newvals['lampiran']) && !preg_match("/.xlsx/i",$newvals['lampiran'])) {
    $vSQL="update m_terminal set lampiran='".$oldvals['lampiran']."' where fidsys=".$this->rec;
   $this->myquery($vSQL);
}
*/


?>