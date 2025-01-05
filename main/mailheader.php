<?
	$headers .= "From: ".$from."\n"; // FROM email user
	//$headers .= "Reply-To: <$from>\n"; //REPLY to email user
	$headers .= "Errors-To: japri_s@yahoo.com\n";
	$headers .= "Return-path: <japri_s@yahoo.com>\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "X-Sender: $from\n";
	$headers .= "X-Mailer: UNEEDS\n"; 
	$headers .= "X-Priority: 1\n"; 
	$smtp=$pSMTP;
	ini_set("SMTP",$smtp);
    ini_set("sendmail_from",$from);
    //ini_restore(sendmail_from);
?>