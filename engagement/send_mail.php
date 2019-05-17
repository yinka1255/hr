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
    $to = $row['candidate_email'];
    $subject = "Imeprial group consult - Unboarding update";
    $txt = "<html>
    <body>
    <table>
    <tr>
    <td>Hi ".$row['candidate_name'].",</td>
    </tr>
    <tr>
    <td>We are satisfied with the responses you provided to our questions online few days ago. 
    Our client has requested we invite you over for a brief chat with their team. At this stage we will need you to sign the agency agreement attached to this mail and bring it along with you.
    You are expected to read the agency agreement carefully and if you are satisfied with the terms, you are expected to pay a sum of N10,000 agency fee online using the link below on or before friday 17th of may 2019. The date and venue shall be communicated to you after payment.
    
    Payment link: <a href='https://imperialgroupconsult.com/engagement/index.php?candidateID='".$row['candidate_id']."'>Click here to pay online</a>
    
    DETAILS
    Role: Front desk officer
    Monthly Salary: Approximately N82,000 will be reviewed after 3months probation period.
    End of year profit sharing.
    Pension
    Health insurance
    
    </td>
    </tr>" ;
    $headers = "From: yinka.benson@imperialgroupconsult.com";

    mail($to,$subject,$txt,$headers);
}



?>