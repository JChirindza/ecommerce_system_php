<?php    

require_once 'core.php';

$orderId = $_POST['orderId'];

$sql = "SELECT order_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due, payment_place,gstn FROM orders WHERE order_id = $orderId";

$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderDate = $orderData[0];
$clientName = $orderData[1];
$clientContact = $orderData[2]; 
$subTotal = $orderData[3];
$vat = $orderData[4];
$totalAmount = $orderData[5]; 
$discount = $orderData[6];
$grandTotal = $orderData[7];
$paid = $orderData[8];
$due = $orderData[9];
$payment_place = $orderData[10];
$gstn = $orderData[11];


$orderItemSql = "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
   product.product_name FROM order_item
   INNER JOIN product ON order_item.product_id = product.product_id 
   WHERE order_item.order_id = $orderId";
$orderItemResult = $connect->query($orderItemSql);

$table = '
<style>
   label { border: 0; font: 14px Georgia, Serif; overflow: hidden; resize: none; }
   table { border-collapse: collapse; }
   table td, table th { border: 1px solid black; padding: 5px; }

   #header { height: 15px; width: 100%; margin: 20px 0; border: 1px solid black; background: #eee; text-align: center; color: black; font: bold 15px Helvetica, Sans-Serif; text-decoration: uppercase; letter-spacing: 20px; padding: 8px 0px; }

   #address { width: 250px; height: 150px; float: left; margin-left: .5rem}
   #customer { overflow: hidden; }

   #logo { text-align: right; float: right; position: relative; max-width: 540px; max-height: 100px; overflow: hidden; margin-right: .5rem;}
   #customer-title { font-size: 20px; font-weight: bold; float: left; }

   #client { margin-top: 1px; width: 300px; float: left; }
   #client td { text-align: right;  }
   #client td.meta-head { text-align: left; background: #eee; }
   #client td label { width: 100%; height: 20px; text-align: right; }

   #meta { margin-top: 1px; width: 300px; float: right; }
   #meta td { text-align: right;  }
   #meta td.meta-head { text-align: left; background: #eee; }
   #meta td label { width: 100%; height: 20px; text-align: right; }

   .qty{ text-align: center; }

   #items { clear: both; width: 100%; margin: 30px 0 0 0; border: 1px solid black; }
   #items th { background: #eee; }
   #items label { width: 80px; height: 50px; }
   #items tr.item-row td { border:  1px solid black; vertical-align: top; }
   #items td.description { width: 300px; }
   #items td.item-name { width: 175px; }
   #items td.description label, #items td.item-name label { width: 100%; }
   #items td.total-line { border-right: 0; text-align: right; }
   #items td.total-value { border-left: 0; padding: 10px; }
   #items td.total-value label { height: 20px; background: none; }
   #items td.balance { background: #eee; }
   #items td.blank { border: 0; }

   #terms { text-align: center; margin: 20px 0 0 0; }
   #terms h5 { text-transform: uppercase; font: 13px Helvetica, Sans-Serif; letter-spacing: 10px; border-bottom: 1px solid black; padding: 0 0 8px 0; margin: 0 0 8px 0; }
   #terms label { width: 100%; text-align: center;}
</style>

<div id="page-wrap">

      <p id="header">INVOICE</p>
      
      <div id="identity">

         <label id="address">
            Computer Only Corp.;<br>
            Av.: Karl Max Nr.: 1234;<br>
            Maputo, Mocambique;<br>
            Tel: (+258) 82 11 11 111; <br>
            Email: computersonly@pconly.co.mz
         </label>
         <div id="logo">
            <img id="image" src="assests/images/logo.png" alt="logo" />
         </div>
      </div>
      
      <div style="clear:both"></div>
      
      <div id="customer">

         <table id="client">
            <tr>
               <td class="meta-head">Nome do Cliente: </td>
               <td>'.$clientName.'</td>
            </tr>
            <tr>

               <td class="meta-head">Contacto: </td>
               <td>'.$clientContact.'</td>
            </tr>
            <tr>
               <td class="meta-head">Nuit: </td>
               <td>3453453</div></td>
            </tr>
         </table>

         <table id="meta">
            <tr>
               <td class="meta-head">Recibo & Data Nr.</td>
               <td>'.$orderDate.'</td>
            </tr>
            <tr>

               <td class="meta-head">Date</td>
               <td>'.$orderDate.'</td>
            </tr>
            <tr>
               <td class="meta-head">Amount Due</td>
               <td><div class="due">$875.00</div></td>
            </tr>
         </table>
      </div>
      
      <table id="items">

         <tr>
            <th width="5%">#</th>
            <th width="55%">Descricao do produto</th>
            <th width="15%">Preco</th>
            <th width="10%">Quantity</th>
            <th width="15%">Preco Acumulado</th>
         </tr>
         ';
         $x = 1;
         $cgst = 0;
         $igst = 0;
         if($payment_place == 2) {
            $igst = $subTotal*17/100;
         } else {
            $cgst = $subTotal*9/100;
         }
         $total = $subTotal+2*$cgst+$igst;
         while($row = $orderItemResult->fetch_array()) {       
         $table .= '
            <tr class="item-row">
               <td class="item-name"><label>'.$x.'</label></td>
               <td class="description"><label>'.$row[4].'</label></td>
               <td><label class="cost">'.$row[1].'</label></td>
               <td><label class="qty">'.$row[2].'</label></td>
               <td><span class="price">'.$row[3].'</span></td>
            </tr>
         ';
            $x++;
            } // /while
            $table.= '
         <tr>
            <td colspan="2" class="blank"> </td>
            <td colspan="2" class="total-line">Total Acumulado</td>
            <td class="total-value"><div id="subtotal">'.$subTotal.'</div></td>
         </tr>
         <tr>
            <td colspan="2" class="blank"> </td>
            <td colspan="2" class="total-line balance">Grande Total</td>
            <td class="total-value balance"><div class="due">'.$total.'</div></td>
         </tr>
      </table>

      <div class="">
         <label>Assinatura do Funcionario:</label>
         <br>
         &nbsp;
      </div>

      <div id="terms">
         <h5>Terms</h5>
         <label>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</label>
      </div>

   </div>
   ';
   $connect->close();

echo $table;