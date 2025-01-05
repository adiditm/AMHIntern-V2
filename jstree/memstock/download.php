<? include_once("../framework/masterheader.php")?>

<script language="Javascript">

$(document).ready(function(){

      $('#caption').html('Download Stuff');

});	

	

	

</script>



<body class="sticky-header">



<section>

    <!-- left side start-->

    <? include "../framework/leftmem.php"; ?>

    <!-- left side end-->

    

    <!-- main content start-->

    <div class="main-content" >



        <!-- header section start-->

        <? include "../framework/headermem.php"; ?>

        <!-- header section end-->



<br><br>

<div style="font-size:14px;font-weight:bold">

<ul>

       <?

          $dir    = '../download';

			$files = scandir($dir);



			while(list($key,$val)=each($files)) {

			   if ($val !="." && $val !="..") {

			      echo '<li><a href="../download/'.$val.'"><span class="fa fa-download"></span> '.$val.'</a></li>';

			   }

			}

       

       ?>

</ul>         

        </div>         <!--body wrapper end-->



   

    <!-- main content end-->

</section>



<!-- Placed js at the end of the document so the pages load faster -->



<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>

<script src="../js/jquery-migrate-1.2.1.min.js"></script>



<script src="../js/modernizr.min.js"></script>

<script src="../js/jquery.nicescroll.js"></script>





<!--common scripts for all pages-->

<script src="../js/scripts.js"></script>

<div align="center">

<? include "../framework/footer.php";?>

</div>

</body>

</html>

