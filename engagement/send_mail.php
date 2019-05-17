<?php

$servername = "localhost";
$username = "root";
$password = "Adeniran1255$";
$dbname = "imperialhr";

$conn = mysqli_connect($hostname, $username, $password)
        or die("Could not connect to server " . mysql_error()); 
    mysqli_select_db($conn, $dbname)
        or die("Error: Could not connect to the database: " . mysql_error());
        

$sql = 'SELECT * FROM candidates WHERE sent = 0';
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) <1){
    header("location:http://imperialgroupconsult.com/not-found.html");
}
while($row = mysqli_fetch_assoc($result)) {
    echo $row['candidate_email'];
    $to = $row['candidate_email'];
    $subject = "Imeprial group consult - Unboarding update";
    $txt = "Hi" ;
    $headers = "From: yinka.benson@imperialgroupconsult.com";

    mail($to,$subject,$txt,$headers);
}



?>