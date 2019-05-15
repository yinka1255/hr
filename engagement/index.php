<?php
$servername = "localhost";
$username = "root";
$password = "Adeniran1255$";
$dbname = "imperialhr";

$conn = mysqli_connect($hostname, $username, $password)
        or die("Could not connect to server " . mysql_error()); 
    mysqli_select_db($conn, $dbname)
        or die("Error: Could not connect to the database: " . mysql_error());
        
$candidateID = $_GET['candidateID'];

$sql = 'SELECT * FROM candidates WHERE candidate_id = "'.$candidateID.'"';
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) <1){
    header("location:http://imperialgroupconsult.com/not-found.html");
}
$row = mysqli_fetch_assoc($result);
if($row['payment_status'] == 1){
    header("location:http://imperialgroupconsult.com/engagement/success.html");
}

    function recordPayment(){
        $sql = "UPDATE candidates SET payment_status='1' WHERE candidate_id='".$candidateID."'";

        if (mysqli_query($conn, $sql)) {
            header("location:http://imperialgroupconsult.com/engagement/success.html");
        }
    }
                            
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
    <title>Imperial group consult | Invoice</title>
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <meta name="description" content="Invoicebus Invoice Template">
    <meta name="author" content="Invoicebus">

    <meta name="template-hash" content="baadb45704803c2d1a1ac3e569b757d5">

    <link rel="stylesheet" href="css/template.css">
    <script src="https://js.paystack.co/v1/inline.js"></script>
  </head>
  <body>
      <div class="center">
        <div id="container">
          <section id="memo">
            <div class="logo">
              <img src="logo.png" />
            </div>
            
            <div class="company-info">
              <div class="hidden-sm">Imperial group consult</div>
    
              <br />
              
              <span>22 Prince Alaba oniru st, Oniru, Victoria Island</span>
              <span>Lagos</span>
    
              <br />
              
              <span>08161523473</span>
              <span>info@imperialgroupconsult.com</span>
            </div>
    
          </section>
    
          <section id="invoice-title-number">
          
            <span id="title">INVOICE</span>
            <span id="number"><?php echo $row['invoice_number']; ?></span>
            
          </section>
          
          <div class="clearfix"></div>
          
          <section id="client-info">
            <div>
              <span class="bold"><?php echo $row['candidate_name']; ?></span>
            </div>
            
            <div>
              <span><?php echo $row['candidate_address']; ?></span>
            </div>
            
            
            
            <div>
              <span><?php echo $row['candidate_phone']; ?></span>
            </div>
            
            <div>
              <span><?php echo $row['candidate_email']; ?></span>
            </div>
            
            
          </section>
          
          <div class="clearfix"></div>
          
          <section id="items">
            
            <table cellpadding="0" cellspacing="0">
            
              <tr>
                <th>Sn</th> <!-- Dummy cell for the row number and row commands -->
                <th>Item</th>
                <th>Total</th>
              </tr>
              
              <tr data-iterate="item">
                <td>1</td> <!-- Don't remove this column as it's needed for the row commands -->
                <td>Agency registration fee</td>
                <td>₦10,000</td>
              </tr>
              
            </table>
            
          </section>
          
          <section id="sums">
          
            <table cellpadding="0" cellspacing="0">
              <tr>
                <th>Subtotal</th>
                <td>₦10,000</td>
              </tr>
              
              
              
              <!-- You can use attribute data-hide-on-quote="true" to hide specific information on quotes.
                   For example Invoicebus doesn't need amount paid and amount due on quotes  -->
              <tr data-hide-on-quote="true">
                <th>Paid</th>
                <td>0.00</td>
              </tr>
              
              <tr data-hide-on-quote="true">
                <th>Total</th>
                <td>₦10,000</td>
              </tr>
              
            </table>
    
            <div class="clearfix"></div>
            
          </section>
          
          <div class="clearfix"></div>
    
          <section id="invoice-info">
            <div>
              <span>Issue date</span> <span><?php echo $row['created']; ?></span>
            </div>
            <div>
              <span>Due date</span> <span><?php echo $row['due_date']; ?></span>
            </div>
    
            <br />
    
            
          </section>
          
          <section id="terms">
    
            <div class="notes">Kindly click the pay button below to pay agency registration fee online <br/>on or before the due date to avoid loosing this opportunity</div>
    
            <br />
    
            
          </section>
    
          <div class="clearfix"></div>
    
          <div class="thank-you"><a href="javascript:void(0)" style="color: #fff;text-decoration: none;" onclick="payWithPaystack()"> Pay online </a></div>
    
          <div class="clearfix"></div>
        </div>
    </div>

    <form>
        <script>
            
            function payWithPaystack(){
                var name = "<?php echo $row['candidate_name']; ?>";
                var email = "<?php if(!empty($row['candidate_email'])){
                                    echo $row['candidate_email']; 
                                    }else{
                                      echo "yinka.benson@imperialgoupconsult.com";
                                    }
                            ?>";
                var phone = "<?php echo $row['candidate_phone']; ?>";
                var amount = 10000;
                var service = "Agency due";

            
                
                var handler = PaystackPop.setup({
                    key: "pk_live_44879993078226bd019febc572062f2cafc95db5",
                    email: email,
                    amount: amount+"00",
                    ref: Date.now(),
                    currency: "NGN",
                    metadata: {
                        custom_fields: [
                        { display_name: "Name", variable_name: "name", value: name },
                        { display_name: "Email", variable_name: "email", value: email },
                        { display_name: "Phone", variable_name: "phone", value: phone },
                        { display_name: "Amount", variable_name: "amount", value: amount },
                        { display_name: "Service", variable_name: "service", value: service },
                        
                        ]
                    },
                    callback: function(response){
                        if(response.success){
                            var x="<?php recordPayment(); ?>";
	                        alert(x);
                                
                                                    //getSuccess("We appreciate your patron'age. We would definetly get back to ypu within 24 hours");
                            //document.getElementById("pay-form").submit();
                        }else{
                            alert('A server error occured');
                        }
                        
                    },
                    onClose: function(){
                        alert('Transaction Cancelled');
                        
                    }
                });
                handler.openIframe();
            }

        </script>
    </form>
  </body>
</html>
