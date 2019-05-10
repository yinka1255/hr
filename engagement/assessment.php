<?php
$servername = "localhost";
$username = "root";
$password = "Adeniran1255$";
$dbname = "imperialhr";

$conn = mysqli_connect($hostname, $username, $password)
        or die("Could not connect to server " . mysql_error()); 
    mysqli_select_db($conn, $dbname)
        or die("Error: Could not connect to the database: " . mysql_error());
                      
?>


<!DOCTYPE html>
<!--
  Invoice template by invoicebus.com
  To customize this template consider following this guide https://invoicebus.com/how-to-create-invoice-template/
  This template is under Invoicebus Template License, see https://invoicebus.com/templates/license/
-->
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Imperial group consult | Assessment</title>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="description" content="Invoicebus Invoice Template">
    <meta name="author" content="Invoicebus">

    <meta name="template-hash" content="baadb45704803c2d1a1ac3e569b757d5">

    <link rel="stylesheet" href="css/template.css">
  </head>
  <body>
      <div class="center">
        <div id="container">
          <section id="memo">
            <div class="logo">
              <img src="logo.png" />
            </div>
            
            <div class="company-info">
              <div class="hidden-sm">Candidate Assessment</div>
    
              <br />
              
              <span>22 Prince Alaba oniru st, Oniru, Victoria Island</span>
              <span>Lagos</span>
    
              <br />
              
              <span>08161523473</span>
              <span>info@imperialgroupconsult.com</span>
            </div>
    
          </section>
          
          <div class="clearfix"></div>
          
          <section id="client-info">
            <form class="form-group" method="post"  enctype="multipart/form-data" action="{{url('admin/save_feed')}}">    
              <div class="form-group">
                  <label class="form-label">FullName</label>
                  <input type="text" name="candidate_name" placeholder="Candidate Name" class="form-control" required/>
              </div>

              <div class="form-group">
                  <label class="form-label">Email</label>
                  <input type="text" name="candidate_name" placeholder="Candidate Name" class="form-control" required/>
              </div>
                        
          
            
          </section>

        </script>
    </form>
  </body>
</html>
