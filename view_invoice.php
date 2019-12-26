<?php
session_start();
if($_SESSION['user']){
		
}
else{
	header("location:index.php");
}
$user_id = $_SESSION['user'];
?>

<?php
if (isset($_GET['invoice_id']) ){
	$invoice_id = $_GET['invoice_id'];
	
}else{
	header("Location: error/pageNotFound.html");
}
?>

<?php
	require_once("config/config.php");
	require_once(PHP_CLASS_PATH . "/Invoice.inc");
	require_once(PHP_CLASS_PATH . "/Format.inc");
	
	$invoice = new Invoice();
	$json_invoice = $invoice -> get_Invoice_details($invoice_id);
	$json = json_decode($json_invoice, true); // decode the JSON into an associative array

	/*	Print the Array Structure	*/
	/* $html .= '<pre>' . print_r($json, true) . '</pre>'; */

	/* Example Array Json */
	/* $name_custom = $json["Result"][1]["name"]; */

	
	if ($json_invoice){
		foreach ($json["Result"] as $field) {

					
			$quotation_number = $field['quotation_number'];
			$invoice_id = $field['invoice_id'];
			$value = $field['value'];
			$date = $field['date'];
			$status_id = $field['status_id'];
			$customer_id = $field['customer_id'];
			$name = $field['name'];
			$company = $field['company'];
			
			//Get status name
			$status_name = $invoice -> getStatus($status_id);
			
			//Format invoice id
			$frmt_invoice_id = $invoice-> format_invoice($invoice_id);
			
			//Format currency
			$frmt = new Format();
			$format_value = $frmt ->format_currency($value);		
			/*
			$html ='';
			$html .= '<tr>';
			$html .= '<td>' . $frmt_invoice_id . '</td>';
			$html .= '<td>' . $date . '</td>';
			$html .= '<td>' . $format_value . '</td>';
			$html .= '<td>' . $status_name . '</td>';
			$html .= '<td> <a href="view_invoice.php?invoice_id='.$invoice_id.'">View</a></td>';
			$html .= '</tr>';
			//echo $html;
			*/

		}
	}else{
		echo false;	
	}


?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Editable Invoice</title>
	
	<link rel='stylesheet' type='text/css' href='assets/css/style.css' />
	<link rel='stylesheet' type='text/css' href='assets/css/print.css' media="print" />
	<script type='text/javascript' src='assets/js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='assets/js/invoice.js'></script>
		<!-- BOOTSTRAP STYLES-->
    <link href='assets/css/bootstrap.css' rel='stylesheet' />
     <!-- FONTAWESOME STYLES-->
    <link href='assets/css/font-awesome.css' rel='stylesheet' />

</head>

<body>

	<div id="page-wrap">

		<textarea id="header">INVOICE</textarea>
		
		<div id="identity">
		
            <div id="address">2500 Yale St<br>
				Suite B<br>
				Houston, TX 77008<br>
				<a href="www.sheerindustries.com" >www.sheerindustries.com</a>
			</div>

            <div id="logo">
				<!--
              <div id="logoctr">
                <a href="javascript:;" id="change-logo" title="Change logo">Change Logo</a>
                <a href="javascript:;" id="save-logo" title="Save changes">Save</a>
                
                <a href="javascript:;" id="delete-logo" title="Delete logo">Delete Logo</a>
                <a href="javascript:;" id="cancel-logo" title="Cancel changes">Cancel</a>
              </div>

              <div id="logohelp">
                <input id="imageloc" type="text" size="50" value="" /><br />
                (max width: 540px, max height: 100px)
              </div>
			  -->
              <img id="image" src="assets/img/logo.png" alt="logo" height="100px" width="130px"/>
            </div>
			
		
		</div>
		
		<div style="clear:both"></div>
		
		<form method="post">
		<div id="customer">

            <textarea id="customer-title"><?php echo $company .' '. $name; ?></textarea>

            <table id="meta">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><div id="invoice-id"><?php echo $frmt_invoice_id; ?></div></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <!--<td><textarea id="date"></textarea></td>-->
                    <td><input type="date" id="date"/></td>
                </tr>
                <tr>
                    <td class="meta-head">Amount Due</td>
                    <td><div class="due"><?php echo $format_value; ?></div></td>
                </tr>

            </table>
		
		</div>
		
		<table id="items">
		 <thead>
		  <tr>
		      <th>Item</th>
		      <th>Description</th>
		      <th>Unit Cost</th>
		      <th>Quantity</th>
		      <th>Price</th>
		  </tr>
		 </thead>
		  
		  <tbody id="invoice_items">
		  </tbody>
		  <!--
		  <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><textarea>Web Updates</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>
		      <td class="description"><textarea>Monthly web updates for http://widgetcorp.com (Nov. 1 - Nov. 30, 2009)</textarea></td>
		      <td><textarea class="cost">$650.00</textarea></td>
		      <td><textarea class="qty">1</textarea></td>
		      <td><span class="price">$650.00</span></td>
		  </tr>
		  -->
		  <!--
		  <tr class="item-row">
		      <td class="item-name"><div class="delete-wpr"><textarea>SSL Renewals</textarea><a class="delete" href="javascript:;" title="Remove row">X</a></div></td>

		      <td class="description"><textarea>Yearly renewals of SSL certificates on main domain and several subdomains</textarea></td>
		      <td><textarea class="cost">$75.00</textarea></td>
		      <td><textarea class="qty">3</textarea></td>
		      <td><span class="price">$225.00</span></td>
		  </tr>
		  -->
		  
		  <tr id="hiderow">
		    <td colspan="5"><a id="addrow" href="javascript:;" title="Add a row">Add a row</a></td>
		  </tr>
		  
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Subtotal</td>
		      <td class="total-value"><div id="subtotal"><?php echo $format_value; ?></div></td>
		  </tr>
		  <tr>

		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Total</td>
		      <td class="total-value"><div id="total"><?php echo $format_value; ?></div></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line">Amount Paid</td>

		      <td class="total-value"><textarea id="paid">$0.00</textarea></td>
		  </tr>
		  <tr>
		      <td colspan="2" class="blank"> </td>
		      <td colspan="2" class="total-line balance">Balance Due</td>
		      <td class="total-value balance"><div class="due"><?php echo $format_value; ?></div></td>
		  </tr>
		
		</table>
	</form>	
		<div id="terms">
		  <h5>Terms</h5>
		  <textarea>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</textarea>
		</div>
	
	</div>

</form>
	<br><br>
		<center>
			<a href="update_invoice.php" class="btn btn-default btn-md">
			<i class="fa fa-save"></i>&nbsp;&nbsp;SAVE CHANGES</a>			
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="send_invoice.php" class="btn btn-default btn-md">
			<i class="fa fa-envelope"></i>&nbsp;&nbsp;SEND INVOICE BY EMAIL</a>
		</center>
	<br><br>
	
</body>

<script type="text/javascript">
invoice_items();


function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}

function invoice_items(){
var invoice_id = getUrlParameter('invoice_id');
var formData = "invoice_id="+invoice_id;

$.ajax({
		type: 'POST',
		url: 'php-show_invoice_items.php',
		data: formData,
		success:function(data){
			if (data == false){
				//No results

			}else{
				$("#invoice_items").append(data);
			}
				
		},
		error:function(){
			// failed request; give feedback to user
			alert("Request Failed");
		}
	});
	
}


</script>

</html>