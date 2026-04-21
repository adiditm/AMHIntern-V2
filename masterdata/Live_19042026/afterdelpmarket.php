<?php
$vUser=strtolower($_SESSION['LoginUser']);
$vKey=$this->rec;

   
   $vID=$oldvals['id'];
   $vKode=$oldvals['kode'];
   $vNama=$oldvals['nama'];
   $vSF=$oldvals['sf'];
   $vR1=$oldvals['r1'];
   $vR2=$oldvals['r2'];    
   
   //echo "$vID : $vKode : $vNama : $vSF : $vR1 : $vR2";


			      $pURL = "https://amhtechno.com/api/paket/delete";
			      $pData = "id=$vID" ;
				  $curl = curl_init(); 
				  curl_setopt($curl, CURLOPT_URL,$pURL);
				  curl_setopt($curl, CURLOPT_TIMEOUT, 30);
				  curl_setopt($curl, CURLOPT_POST, 1); 
				  curl_setopt($curl, CURLOPT_POSTFIELDS,$pData); 
				  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
				  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
				  $vRet = curl_exec($curl);	   	
				  curl_close($curl);
				  
				  $vRetJSON = json_decode($vRet,true);
				  echo $vRetJSON['result']." ";
				  echo $vRetJSON['desc']." ";
                  echo $vRetJSON['code'];
				  
?>
