<?
session_start();
   $vAgree=$_POST['cboxAgree'];
   if ($vAgree == 'yes') {
	   $_SESSION['cboxAgree']=$vAgree;
	   header("Location: registernexr.php");   
	   
   } else {
	   $_SESSION['cboxAgree']='';
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
   function nextStep() {
	    if (!document.getElementById('cboxAgree').checked) {
			alert("You must check 'I Agree' in order to continue!");
			return false;
		} else {
		    document.regForm.submit();	
			
		}
   }
   </script> 
    
  </head>

  <body>

     <div class="main">
    
      <div class="one">
      <div align="center" class="col-xs-offset-1 col-lg-offset-3"  style="border-radius:3px;background-color:#6acbde;width:60px;color:white">Logo</div>
      <br>
        <div class="register col-lg-6 col-sm-6 col-lg-offset-3">
         
          <label style="font-size:1.6em">Term &amp; Condition</label>
          <form id="regForm" name="regForm" method="post">
<p>Now wait, some companies have some crazy clauses too. Here are a few of them.            </p>
<p>1. Its compulsory to attend the yearly company conventions. You need to attend them to be able to renew your distributorship.
  
  Yes, I have seen this clause, however companies don't implement it. Don't let that fool you. If they have issues with you, then you not attending the company convention is a ready made reason for them to throw you out. Of course, this is a rare clause but it exists.
  
  </p>
<p>2. The company can switch over its model from network marketing to direct sales at any point of time.
  
  This is a freaking dangerous clause designed to protect the company. </p>     
  
  <div class="clearfix"></div>
  <div class="row">
  <div class="col-lg-4">
  <input name="cboxAgree" id="cboxAgree" type="checkbox" value="yes"> I Agree
  </div>
  </div>     
            <div class="row">
            <div class="col-lg-4">
              <label></label>
              <input type="button" value="Continue" id="create-account" class="btn btn-success" onClick="return nextStep()"/>&nbsp;
              <input  type="button" value="Decline" id="create-account" class="btn btn-default" onClick="document.location.href='registernex.php'"/>
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
