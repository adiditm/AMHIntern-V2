<?
  session_start();
  session_destroy();
  header("Location: /main/loginform.php");
?>
