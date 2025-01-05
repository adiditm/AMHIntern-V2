<? include_once("../framework/member_headside.blade.php")?>

<style type="text/css">
.img-responsive { 
    /* other definitions */
    width:100%;
}
</style>
<div>
<div class="content-wrapper" style="width:100%;">
<section class="content" >
   


		

  <script type="text/javascript">
    $(function(){
       //SyntaxHighlighter.all();
    });
    $(window).load(function(){
     
    });
  </script>    
         <a target="_blank" href="#"><img src="" alt="" class="img-responsive hide"  /></a>
         <br>
            <div class="row states-info" > <!-- dashboard -->
            
            
            
            
            
            <div class="col-md-3">
                <div class="panel" style="min-height:100px;background-color:#00F">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-th-large"></i>
                            </div>
                            <div class="col-xs-8">
                                <span class="state-title"> Value 1</span>
                                <h4>
                               
                                
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
 </div>


   


<script src="../js/jquery-ui-1.9.2.custom.min.js"></script>

<script src="../js/jquery-migrate-1.2.1.min.js"></script>



<script src="../js/modernizr.min.js"></script>

<script src="../js/jquery.nicescroll.js"></script>





<!--common scripts for all pages-->


 <script src="../js/lobibox.js"></script>
  <script src="../js/notif/demo.js"></script>
<?
   $vMaxMaRO = (float) $oRules->getSettingByField('fmaxrowal');
   $vRoMaMonth = (float) $oKomisi->getROMaMonth($vUser,date("Y"),date("m"));
   $vRemain=$vMaxMaRO - $vRoMaMonth;
   //$vRoMaMonth=999999;
?>

<script language="Javascript">
$(document).ready(function(){

      $('#caption').html('Home &amp; Dashboard');
});	
	
	
</script>

</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?
 include('../framework/member_footside.blade.php');
?>
