<?php include 'connection.php' ;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
     
</head>
<body>
    <?php 
    $oid=$_GET['oid'];
    $sql="SELECT * FROM `order` o inner join customer c on o.CID=c.C_ID where o.O_ID='$oid'";
    $run=mysqli_query($connect,$sql);
    if(mysqli_num_rows($run)){
        while($show=mysqli_fetch_array($run)){

    

   ?>
    <div id="invoice" class="invoice-box">
        <header>
            <div class="logo">
                <img src="images/logo.png" alt="Company Logo">
            </div>
            <div class="invoice-details">
                <p>Date: <?php echo date("M d, Y", strtotime($show['O_date']));?></p>
                <p>Invoice : <?php echo $show['invoice_no'];?></p>
            </div>
        </header>
        <section class="company-details">
            <p><b style="color: black;"><?php echo $show['cname'];?></b><br>
               <div class="address"><?php echo $show['caddress'];?></div>
            </p>
        </section>
        <h2 style="text-transform:uppercase;">QUOTATION FOR SUPPLY OF <?php echo $show['topic'];?></h2>
        <table class="items">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Item</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 

                  $sql2="SELECT * FROM bill b inner join products p on b.PID=p.P_ID where b.OID='$oid'";
                  $run2=mysqli_query($connect,$sql2);
                  if(mysqli_num_rows($run2)){
                    $x=1;
                    while($show2=mysqli_fetch_array($run2)){?>
                        <tr>
                        <td><?php echo $x;?></td>
                        <td><?php echo $show2['P_name'];?></td>
                        <td><?php echo $show2['P_unit_price'];?></td>
                        <td><?php echo $show2['B_qty'];?></td>
                        <td><?php echo $show2['P_unit_price']* $show2['B_qty'];?></td>
                    </tr><?php
                    $x++;
                    }
                    
                  }
?>
               
                 
            </tbody>
        </table>
        <section class="terms">
            <h4 style="color: black;
    font-weight: 700;
    font-size: 15px;">Terms and Conditions</h4>
            <p><b>Delivery</b>: Ex-Stock, Subject to Prior Sales.</p>
            <p><b>Services</b>:<span class="foc">FOC for the on-Site Technical Support & Delivery</span></p>
            <p><b>Quotation Validity</b>: 03 Days from the date of issue</p>
            <p><b>Price Fluctuations</b>: Prices are subject to change should there be any significant changes in duty, taxes, and exchange rates.</p>
            <p><b>This quotation's price calculation is done at the prevailing exchange rate issued by commercial banks under the central bank regulations. All Prices are subject to any Government Taxes applicable at the time of Invoice.</b></p>
            <p><b>Payment</b>: Cash on Delivery</p>
            <p>Please contact the undersigned for any further clarification details that you require.</p>
        </section>
        <footer>
            <p style="font-size: 15px;
    font-weight: 500;
    color: black;
    font-family: 'Roboto';">Refer The Web for More Products <a href="http://startechlk.com"  >Shop - Star Technology (startechlk.com)</a></p>
           <div class="contact-info">
    <div class="contact-item">
        <img src="images/call.png" alt="Phone Icon" class="contact-icon">
        <div>
            <p>PHONE</p>
            <p>+94 76 231 7707</p>
        </div>
    </div>
    <div class="contact-item">
        <img src="images/net.png" alt="Email Icon" class="contact-icon">
        <div>
            <p>info@startechlk.com</p>
            <p>startechlk.com</p>
        </div>
    </div>
    <div class="contact-item">
        <img src="images/location.png" alt="Address Icon" class="contact-icon">
        <div>
            <p>249/2<sup>nd</sup> Floor, Janajaya City, Rajagiriya</p>
        </div>
    </div>
</div>

        </footer>
    </div>
    <?php 
        }
    } ?>
    <button id="download" onclick="downloadPDF()">Download PDF</button>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        function downloadPDF() {
            const { jsPDF } = window.jspdf;

            html2canvas(document.querySelector("#invoice")).then(canvas => {
                const imgData = canvas.toDataURL("image/png");
                const pdf = new jsPDF();
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save("invoice.pdf");
            });
        }
    </script>
</body>
</html>

<style>
    .contact-info {
    display: flex;
    justify-content: space-around;
    align-items: center;
    border-top: 1px solid #ccc;
    padding: 10px 0;
}

.contact-item {
    display: flex;
    align-items: center;
}

.contact-icon {
    width: 54px;
    height: 54px;
    margin-right: 10px;
}

.contact-item p {
    margin: 0;
    font-size: 14px;
}

.contact-item p:first-child {
    font-weight: bold;
    font-size: 12px;
}

    .address{
        display: inline-flex;
    width: 300px;
    }
    body {
    font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
}

.invoice-box {
    max-width: 800px;
    margin: auto;
    padding: 20px;
    border: 1px solid #eee;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
    color: #555;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}

.logo img {
    max-width: 150px;
}

.invoice-details {
    text-align: right;
    color: black;
    font-weight: 900;
    font-size: 15px;
}

.company-details {
    margin-top: 20px;
}

h2 {
    margin-top: 20px;
    font-size: 20px;
    text-align: center;
    color: black;
    font-weight: 800;
    font-family: 'Roboto';
    text-decoration: underline;
}

.items {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

.items thead {
    background-color: #f5f5f5;
}

.items th, .items td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.items th {
    background-color: #f2f2f2;
    text-align: center;
    
}

.terms {
    margin-top: 20px;
    font-size: 12px;
    color: black;
}

.terms h4 {
    margin-bottom: 10px;
}

footer {
    text-align: center;
    margin-top: 20px;
    font-size: 12px;
}

footer a {
    color: #333;
     
}

button {
    display: block;
    margin: 20px auto;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
}

.foc {
    color: red;
}

</style>