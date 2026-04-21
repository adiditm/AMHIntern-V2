<? include_once("../framework/admin_headside.blade.php")?>

<script language="Javascript">

$(document).ready(function(){

      $('#caption').html('Download Log');

});	

	

	

</script>



<div class="content-wrapper">

       <section class="content">
    <!-- left side start-->





<div style="font-size:14px;font-weight:bold">

<ul>

       <?

          $dir    = '../files';

			$files = scandir($dir);



			while(list($key,$val)=each($files)) {

			   if ($val !="." && $val !=".." && $val !="index.php") {

			      echo '<li><a target="blank" href="../files/'.$val.'"><span class="fa fa-download"></span> '.$val.'</a></li>';

			   }

			}

       

       ?>

</ul>         

      


<!-- Placed js at the end of the document so the pages load faster -->



<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>

<script src="../js/jquery-migrate-1.2.1.min.js"></script>



<script src="../js/modernizr.min.js"></script>

<script src="../js/jquery.nicescroll.js"></script>





<!--common scripts for all pages-->

<script src="../js/scripts.js"></script>

       </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->





<?
 include('../framework/admin_footside.blade.php');
?>

