<?
session_start();

   if ($_POST['hPost']=='1') {
	  $vCountry=$_POST['lmCountry']; 
	  $vLang=$_POST['lmLang'];
	  
	  $_SESSION['lmCountry'] = $vCountry;
	  $_SESSION['lmLang']=$vLang;
	  header("Location: registernex2.php");   
   }


?>

<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    
<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nexsukses - Registration Form</title>
    
    
    <link rel="stylesheet" href="../css/normalize.css">

    
        <link rel="stylesheet" href="../css/stylereg.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script language="javascript">
	function checkForm() {
	   if ($('#lmCountry').val()==''){
	   alert('Choose your region!');
	   return false;
	}  else {
	    document.regForm.submit();	
	}
}

</script>
    
  </head>

  <body>

     <div class="main">

      <div class="one">
      <div align="center" class="col-xs-offset-1 col-lg-offset-3"  style="border-radius:3px;background-color:#6acbde;width:60px;color:white">Logo</div>
        <div class="register col-lg-6 col-sm-6 col-lg-offset-3">
          <label style="font-size:1.6em">Nexsukses Registration</label>
          <form id="regForm" name="regForm" method="post">
            <div class="row">
            <div class="col-lg-12 col-sm-6 col-md-6">
              <label for="country">Please select the region you are signing up from.</label>
              <select  id="lmCountry" name="lmCountry"  onchange="javascript:(onRegionsChange(this.form,'siteurl=xiangli'));">
            <option value="">----- Choose Your Region -----</option>
            

            
                    <option value="ID" <? if ($_SESSION['lmCountry']=='ID') echo 'selected';?>>INDONESIA </option>
            
 
            
                    <option value="MY" <? if ($_SESSION['lmCountry']=='MY') echo 'selected';?>>MALAYSIA</option>
            
 
            
                    <option value="SG" <? if ($_SESSION['lmCountry']=='SG') echo 'selected';?>>SINGAPORE</option>
            
                    
            
            </select>
            </div>
            
            </div>
            
            <div class="row">
            <div class="col-lg-12 col-sm-6 col-md-6">
              <label for="language">Please select language</label>
              <select name="lmLang" id="lmLang">
            
            
                    <option value="1">English</option>
               <option value="15">Indonesian</option>
            

            
            </select>
            </div>
            </div>
            
            <div class="row">
            <div class="col-lg-4">
              <label></label>
              <input type="button" onClick="checkForm()" value="Continue" id="create-account" class="btn btn-success"/>&nbsp;
              <input type="button" value="Decline" id="create-account" class="btn btn-default" onClick="document.location.href='../../index.php'" />
              <input type="hidden" name="hPost" id="hPost" value="1">
            </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

        <script src="../js/index.js"></script>

    
    
    
  </body>
</html>
