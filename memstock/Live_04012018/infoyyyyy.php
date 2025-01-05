<? include_once("../framework/masterheader.php")?>
<script language="Javascript">
$(document).ready(function(){
      $('#caption').html('General Info');
});	
	
	
</script>

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
        <!-- BEGIN HEADER -->
                 <?   if ($_GET['uMemberId'] != '') 
           include "../framework/headeradmin.php"; 
        else
           include "../framework/headermem.php";    
     
     ?>

        <!-- END HEADER -->
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN SIDEBAR -->
 		
			   <?   if ($_GET['uMemberId'] != '') 
			     include "../framework/leftmem.php"; 
			   else
			     include "../framework/leftmem.php"; ?>
                 
                <!-- END SIDEBAR -->
 		  <div align="left" style="width:98%;margin-left:1%" class="table-responsive">               
 		    
			<table border="0" align="left" cellpadding="1" cellspacing="0" style="width: 570px"  >
				<tr >
					<td  align="left" style="color:black">
						
					  <? include("../memstock/geninfo.php");?>
					</td>
				</tr>
			</table>
		        </div>
</div>

        <!--body wrapper end-->

        <!--footer section start-->
   

<!-- Placed js at the end of the document so the pages load faster -->

        <!-- BEGIN FOOTER -->
			 <? include "../framework/footer.php"; ?>
        <!-- END FOOTER -->
         <? include "../framework/masterfooter.php"; ?>