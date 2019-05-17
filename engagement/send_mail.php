<?php
$to = "adeniranadeyinka101@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: yinka.benson@imperialgroupconsult.com" . "\r\n" ;

mail($to,$subject,$txt,$headers);
?>