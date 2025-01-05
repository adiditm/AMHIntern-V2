<html>
<head>
<title>Jaya Bersama</title>
<link href="css.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="netto.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
}
.style1 {
	font-size: 16px;
	font-weight: bold;
	color: #000000;
}
.style2 {
	font-size: 12px;
	color: #000000;
	font-weight: bold;
}
.style4 {font-size: 10pt; font-weight: bold; }
-->
</style></head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%"  border="0" cellpadding="5" cellspacing="0" >
  <tr class="tblBorder"> 
    <td height="49" align="center" valign="middle"> <p class="style1">SERTIFIKAT<br>
        MITRA USAHA </p></td>
  </tr>
  <tr> 
    <td height="25"><hr></td>
  </tr>
  <tr valign="top"> 
    <td align="center" valign="top"> <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
        <tr> 
          <td> 
              <div align="left">
                <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2"><div align="left" class="style4">Diberikan kepada :<br> 
                    </div></td>
                  </tr>
                  <tr>
                    <td width="31%"><div align="left" class="style4">Nama </div></td>
                    <td width="69%"><div align="left" class="style4">: 
                      <?
					      echo $oMember->getMemberName($vUser);
					  
					?>
                    </div></td>
                  </tr>
                  <tr>
                    <td><div align="left" class="style4">User Name </div></td>
                    <td><div align="left" class="style4">: 
                      <?
						    echo $vUser;
					  ?>
                    </div></td>
                  </tr>
                  <tr style="display:none">
                    <td><div align="left" class="style4">No ID  </div></td>
                    <td><div align="left" class="style4">: 
                      <?=$vUser;?>
                    </div></td>
                  </tr>
                  <tr>
                    <td><div align="left" class="style4">Tanggal Aktivasi </div></td>
                    <td><div align="left" class="style4">: 
                      <?
						   echo $oPhpdate->YMDT2DMYT($oMember->getActivationDate($vUser),"-");
					  ?>
                    </div></td>
                  </tr>
                  </table>
              </div>
            
              <div align="left"><br>
                  <br>
                <?=$oInterface->getMenuContent("cert");?>
              </div>
          <p align="left"><a href="certprint.php" target="_blank" name="wCert">Cetak Sertifikat  <img src="images/printer.png" width="36" height="35" border="0" align="absmiddle"> </a> </p></td>
        </tr>
      </table>
      <br> <div align="center"></div></td>
  </tr>
</table>
</body>
</html>
