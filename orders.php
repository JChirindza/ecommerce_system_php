<?php 
require_once 'includes/header.php'; 

if($_GET['p'] == 'add') { 
// add order
	echo "<div class='div-request div-hide'>add</div>";
} else if($_GET['p'] == 'manord') { 
	echo "<div class='div-request div-hide'>manord</div>";
} else if($_GET['p'] == 'editOrd') { 
	echo "<div class='div-request div-hide'>editOrd</div>";
} // /else manage order


// GET User data
$user_id = Sys_Secure($_SESSION['userId']);
$sql = "SELECT * FROM users WHERE user_id = {$user_id}";
$query = $connect->query($sql);
$result = $query->fetch_assoc();

?>

<div class="border border-top-0 bg-white m-0 p-0 row">
	<button type="button" id="menu-toggle" class="border-right rounded-0 btn">
		<i class="fas fa-align-left"></i>
	</button>
	<ol class="breadcrumb bg-transparent mb-0">
	    <li class="breadcrumb-item"><a href="dashboard.php"><?php echo $language['dashboard'] ?></a></li>
	    <li class="breadcrumb-item active"><?php echo $language['orders'] ?></li>
	    <li class="breadcrumb-item active" aria-current="page">
	    	<?php if($_GET['p'] == 'add') {  
	    		echo $language['add-order'];
			} else if($_GET['p'] == 'manord') {
				echo $language['manage-orders'];	
			} else if($_GET['p'] == 'editOrd') {
				echo $language['edit-order'];
			} // /else manage order ?>
		</li>
  	</ol>
</div>

<div class="d-sm-flex align-items-center justify-content-between m-3">
	<h1 class="pageTitle"><?php echo $language['orders'] ?></h1>
	<?php if($_GET['p'] == 'manord') { ?>
		<a type="button" class="btn-primary btn-sm" href="orders.php?p=add"><i class="fas fa-cart-plus"></i> <?php echo $language['add-order'] ?> </a>
	<?php } else { ?>
		<a type="button" class="btn-primary btn-sm" href="orders.php?p=manord"><i class="fas fa-cart-arrow-down"></i> <?php echo $language['manage-orders'] ?> </a>
	<?php } ?>
</div>
<style type="text/css">

	#productTable thead th{
		text-align: center;
	}
</style>


<div class="card shadow-sm mb-3">
	<div class="card-header bg-white">

		<?php if($_GET['p'] == 'add') { ?>
			<i class="fas fa-cart-plus"></i> <?php echo $language['add-order'] ?>
		<?php } else if($_GET['p'] == 'manord') { ?>
			<i class="fas fa-cart-arrow-down"></i> <?php echo $language['manage-orders'] ?>
		<?php } else if($_GET['p'] == 'editOrd') { ?>
			<i class="fas fa-edit"></i> <?php echo $language['edit-order'] ?>
		<?php } ?>

	</div>
	<div class="card-body">

		<?php if($_GET['p'] == 'add') { // add order ?>			
			<div class="success-messages"></div> <!--/success-messages-->

			<form class="form-horizontal" method="POST" action="php_action/ctrl_order.php?action=create" id="createOrderForm">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							
							<label for="clientName" class="col-sm control-label"><?php echo $language['client-name'] ?>:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="clientName" name="clientName" placeholder="Client Name" autocomplete="off" required/>
							</div>
						</div> <!--/form-group-->
						<div class="form-group">
							<label for="clientContact" class="col-sm control-label"><?php echo $language['client-contact'] ?>:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="<?php echo $language['client-number'] ?>" autocomplete="off" required/>
							</div>
						</div> <!--/form-group-->
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="orderDate" class="col-sm-3 control-label"><?php echo $language['vendor'] ?>:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" disabled id="userName" name="userName" value="<?php echo $result['name'] ." ".  $result['surname']; ?>" autocomplete="off" required />
								<input type="hidden" name="systemUserId" id="systemUserId" value="<?php echo $result['user_id']; ?>">
							</div>
						</div> <!--/form-group-->
						<div class="form-group">
							<label for="orderDate" class="col-sm-3 control-label"><?php echo $language['order-date'] ?>:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" disabled id="orderDate" name="orderDate" autocomplete="off" value="<?php echo date('d-m-Y')."          ". date('H:i:s') ?>"/>
							</div>
						</div> <!--/form-group-->
					</div>
				</div>
				
				<div class="table-responsive">
					<table class="table" id="productTable">
						<thead>
							<tr>			  			
								<th style="width:40%;"><?php echo $language['product'] ?></th>
								<th style="width:15%;"><?php echo $language['price'] ?></th>
								<th style="width:10%;"><?php echo $language['available'] ?></th>			  			
								<th style="width:10%;"><?php echo $language['quantity'] ?></th>			  			
								<th style="width:15%;"><?php echo $language['total'] ?></th>			  			
								<th style="width:5%;"></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$arrayNumber = 0;
							for($x = 1; $x < 4; $x++) { ?>
								<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
									<td style="margin-left:20px;">
										<div class="form-group">
											<select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" required>
												<option value="">~~<?php echo $language['select'] ?>~~</option>
												<?php
												$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
												$productData = $connect->query($productSql);

												while($row = $productData->fetch_array()) {									 		
													echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."'>".$row['product_name']."</option>";
										 	} // /while 

										 	?>
										 </select>
										</div>
									</td>
									<td style="padding-left:20px;">			  					
										<input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />			  					
										<input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" />			  					
									</td>
									<td style="padding-left:20px; text-align: center;">
										<div class="form-group">
											<p id="available_quantity<?php echo $x; ?>"></p>
										</div>
									</td>
									<td style="padding-left:20px;">
										<div class="form-group">
											<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" oninput="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" required/>
										</div>
									</td>
									<td style="padding-left:20px;">			  					
										<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />			  					
										<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" />			  					
									</td>
									<td>
										<button class="btn border text-danger removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="fas fa-trash"></i></button>
									</td>
								</tr>
								<?php
								$arrayNumber++;
							} // /for ?>
						</tbody>			  	
					</table>
				</div>

				<button type="button" class="btn btn-primary btn-sm ml-3 mb-4" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="fas fa-plus"></i> <?php echo $language['add-field'] ?> </button>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="subTotal" class="col-sm-4 control-label"><?php echo $language['sub-amount'] ?>:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" />
								<input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
							</div>
						</div> <!--/form-group-->			  
						<div class="form-group">
							<label for="vat" class="col-sm-4 control-label"><?php echo $language['vat'] ?> 17%:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="vat" name="vat" readonly="true" />
								<input type="hidden" class="form-control" id="vatValue" name="vatValue" />
							</div>
						</div>				  
						<div class="form-group">
							<label for="totalAmount" class="col-sm-4 control-label"><?php echo $language['total-amount'] ?>:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true"/>
								<input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" />
							</div>
						</div> <!--/form-group-->			  
						<div class="form-group">
							<label for="discount" class="col-sm-4 control-label"><?php echo $language['discount'] ?>:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" required/>
							</div>
						</div> <!--/form-group-->	
						<div class="form-group">
							<label for="grandTotal" class="col-sm-4 control-label "><strong><?php echo $language['grand-total'] ?>:</strong></label>
							<div class="col-sm-8">
								<input type="text" class="form-control form-control-lg border-success " id="grandTotal" name="grandTotal" disabled="true" />
								<input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" />
							</div>
						</div> <!--/form-group-->	

					</div> <!--/col-md-6-->

					<div class="col-md-6">
						<div class="form-group">
							<label for="clientContact" class="col-sm-4 control-label"><?php echo $language['payment-status'] ?>:</label>
							<div class="col-sm-8">
								<select class="form-control" name="paymentStatus" id="paymentStatus" required>
									<option value="1"><?php echo $language['full-payment'] ?></option>
									<option value="2"><?php echo $language['partial-payment'] ?></option>
									<option value="3"><?php echo $language['no-payment'] ?></option>
								</select>
							</div>
						</div> <!--/form-group-->
						
						<div class="form-group">
							<label for="clientContact" class="col-sm-4 control-label"><?php echo $language['payment-type'] ?>:</label>
							<div class="col-sm-8">
								<select class="form-control" name="paymentType" id="paymentType" required>
									<option value="1" disabled><?php echo $language['cheque'] ?></option>
									<option value="2"><?php echo $language['cash'] ?></option>
									<option value="3"><?php echo $language['credit-card'] ?></option>
								</select>
							</div>
						</div> <!--/form-group-->
						<div class="form-group">
							<label for="paid" class="col-sm-4 control-label"><strong><?php echo $language['paid-amount'] ?>:</strong></label>
							<div class="col-sm-8">
								<input type="text" class="form-control form-control-lg border-success" id="paid" name="paid" autocomplete="off" onkeyup="paidAmount()" required/>
							</div>
						</div> <!--/form-group-->			  
						<div class="form-group">
							<label for="due" class="col-sm-4 control-label"><?php echo $language['due-amount'] ?>:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="due" name="due" disabled="true" />
								<input type="hidden" class="form-control" id="dueValue" name="dueValue" />
							</div>
						</div> <!--/form-group-->		

						
					</div> <!--/col-md-6-->
				</div>

				<div class="form-group submitButtonFooter">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="reset" class="btn btn-secondary" onclick="resetOrderForm()"><i class="fas fa-eraser"></i> <?php echo $language['clear'] ?></button>
						<button type="submit" id="createOrderBtn" data-loading-text="Loading..." class="btn btn-success"><i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
					</div>
				</div>
			</form>
		<?php } else if($_GET['p'] == 'manord') { // manage order ?>

			<div id="success-messages"></div>
			<div class="table-responsive">
				<table class="table table-hover" id="manageOrderTable">
					<thead>
						<tr>
							<th>#</th>
							<th><?php echo $language['order-date'] ?></th>
							<th><?php echo $language['client-name'] ?></th>
							<th><?php echo $language['contact'] ?></th>
							<th><?php echo $language['total-items'] ?></th>
							<th><?php echo $language['paid'] ?></th>
							<th><?php echo $language['payment-status'] ?></th>
							<th><?php echo $language['options'] ?></th>
						</tr>
					</thead>
				</table>
			</div>
			<?php // /else manage order
		} else if($_GET['p'] == 'editOrd') { // get order ?>
			
			<div class="success-messages"></div> <!--/success-messages-->

			<form class="form-horizontal" method="POST" action="php_action/ctrl_order.php?action=update" id="editOrderForm">

				<?php $orderId = $_GET['i'];

				$sql = "SELECT orders.order_id, orders.order_date, orders.client_name, orders.client_contact, orders.sub_total, orders.vat, orders.total_amount, orders.discount, orders.grand_total, orders.paid, orders.due, orders.payment_type, orders.payment_status FROM orders 	
				WHERE orders.order_id = {$orderId}";

				$result = $connect->query($sql);
				$data = $result->fetch_assoc();
				?>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="clientName" class="col-sm control-label"><?php echo $language['client-name'] ?>:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="clientName" name="clientName" placeholder="<?php echo $language['client-name'] ?>" autocomplete="off" value="<?php echo $data['client_name'] ?>" required/>
							</div>
						</div> <!--/form-group-->
						<div class="form-group">
							<label for="clientContact" class="col-sm control-label">Client Contact:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="<?php echo $language['client-number'] ?>" autocomplete="off" value="<?php echo $data['client_contact'] ?>" required/>
							</div>
						</div> <!--/form-group-->	
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="orderDate" class="col-sm control-label"><?php echo $language['order-date'] ?>:</label>
							<div class="col-sm-9">
								<input type="text" class="form-control" id="orderDate" name="orderDate" disabled="true" autocomplete="off" value="<?php echo $data['order_date'] ?>" />
							</div>
						</div> <!--/form-group-->
					</div>
				</div>

				<div class="table-responsive">
					<table class="table" id="productTable">
						<thead>
							<tr>			  			
								<th style="width:45%;"><?php echo $language['product'] ?></th>
								<th style="width:15%;"><?php echo $language['price'] ?></th>
								<th style="width:10%;"><?php echo $language['available'] ?></th>			  			
								<th style="width:10%;"><?php echo $language['quantity'] ?></th>			  			
								<th style="width:15%;"><?php echo $language['total'] ?></th>			  			
								<th style="width:5%;"></th>
							</tr>
						</thead>
						<tbody>
							<?php

							$orderItemSql = "SELECT order_item.order_item_id, order_item.order_id, order_item.product_id, order_item.quantity, order_item.rate, order_item.total FROM order_item WHERE order_item.order_id = {$orderId}";
							$orderItemResult = $connect->query($orderItemSql);
						// $orderItemData = $orderItemResult->fetch_all();						

						// print_r($orderItemData);
							$arrayNumber = 0;
			  		// for($x = 1; $x <= count($orderItemData); $x++) {
							$x = 1;
							while($orderItemData = $orderItemResult->fetch_array()) { 
			  			// print_r($orderItemData); ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:20px;">
			  					<div class="form-group">

			  						<select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" required>
			  							<option value="">~~<?php echo $language['select'] ?>~~</option>
			  							<?php
			  							$productSql = "SELECT * FROM product";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {									 		
			  								$selected = "";
			  								if($row['product_id'] == $orderItemData['product_id']) {
			  									$selected = "selected";
			  								} else {
			  									$selected = "";
			  								}

			  								echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."' ".$selected." >".$row['product_name']."</option>";
										 	} // /while 

										 	?>
										 </select>
										</div>
									</td>
									<td style="padding-left:20px;">			  					
										<input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" value="<?php echo $orderItemData['rate']; ?>" />			  					
										<input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['rate']; ?>" />			  					
									</td>
									<td style="padding-left:20px;">
										<div class="form-group text-center">
											<?php
											$productSql = "SELECT * FROM product";
											$productData = $connect->query($productSql);

											while($row = $productData->fetch_array()) {									 		
												$selected = "";
												if($row['product_id'] == $orderItemData['product_id']) { 
													echo "<p id='available_quantity".$row['product_id']."'>".$row['quantity']."</p>";
												}
												else {
													$selected = "";
												}
										 	} // /while 

										 	?>

										 </div>
										</td>
										<td style="padding-left:20px;">
											<div class="form-group">
												<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" oninput="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" value="<?php echo $orderItemData['quantity']; ?>" />
											</div>
										</td>
										<td style="padding-left:20px;">			  					
											<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" value="<?php echo $orderItemData['total']; ?>"/>			  					
											<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['total']; ?>"/>			  					
										</td>
										<td>
											<button class="btn border text-danger removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="fas fa-trash"></i></button>
										</td>
									</tr>
									<?php
									$arrayNumber++;
									$x++;
				  		} // /for
				  		?>
				  	</tbody>			  	
				  </table>
				</div>
				<button type="button" class="btn btn-primary btn-sm ml-3 mb-4" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="fas fa-plus"></i> <?php echo $language['add-field'] ?></button>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="subTotal" class="col-sm-4 control-label"><?php echo $language['sub-amount'] ?>:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" value="<?php echo $data['sub_total'] ?>" />
								<input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" value="<?php echo $data['sub_total'] ?>" />
							</div>
						</div> <!--/form-group-->			  
						<div class="form-group">
							<label for="vat" class="col-sm-4 control-label">IVA 17%:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="vat" name="vat" disabled="true" value="<?php echo $data['vat'] ?>"  />
								<input type="hidden" class="form-control" id="vatValue" name="vatValue" value="<?php echo $data['vat'] ?>"  />
							</div>
						</div>
						<div class="form-group">
							<label for="totalAmount" class="col-sm-4 control-label"><?php echo $language['total-amount'] ?>:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true" value="<?php echo $data['total_amount'] ?>" />
								<input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" value="<?php echo $data['total_amount'] ?>"  />
							</div>
						</div> <!--/form-group-->			  
						<div class="form-group">
							<label for="discount" class="col-sm-4 control-label"><?php echo $language['discount'] ?>:</label>
							<div class="col-sm-8">
								<input type="number" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" value="<?php echo $data['discount'] ?>" required/>
							</div>
						</div> <!--/form-group-->	
						<div class="form-group">
							<label for="grandTotal" class="col-sm-4 control-label"><?php echo $language['grand-total'] ?>:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control form-control-lg border-success" id="grandTotal" name="grandTotal" disabled="true" value="<?php echo $data['grand_total'] ?>"  />
								<input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" value="<?php echo $data['grand_total'] ?>"  />
							</div>
						</div> <!--/form-group-->	
					</div> <!--/col-md-6-->

					<div class="col-md-6">
						<div class="form-group">
							<label for="clientContact" class="col-sm-4 control-label"><?php echo $language['payment-status'] ?>:</label>
							<div class="col-sm-8">
								<select class="form-control" name="paymentStatus" id="paymentStatus" required>
									<option value="">~~<?php echo $language['select'] ?>~~</option>
									<option value="1" <?php if($data['payment_status'] == 1) {
										echo "selected";
									} ?>  ><?php echo $language['full-payment'] ?></option>
									<option value="2" <?php if($data['payment_status'] == 2) {
										echo "selected";
									} ?> ><?php echo $language['partial-payment'] ?></option>
									<option value="3" <?php if($data['payment_status'] == 3) {
										echo "selected";
									} ?> ><?php echo $language['no-payment'] ?></option>
								</select>
							</div>
						</div> <!--/form-group-->
						<div class="form-group">
							<label for="paid" class="col-sm-4 control-label"><?php echo $language['paid-amount'] ?>:</label>
							<div class="col-sm-8">
								<input type="number" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="paidAmount()" value="<?php echo $data['paid'] ?>"  required/>
							</div>
						</div> <!--/form-group-->			  
						<div class="form-group">
							<label for="due" class="col-sm-4 control-label"><?php echo $language['due-amount'] ?>:</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="due" name="due" disabled="true" value="<?php echo $data['due'] ?>"  />
								<input type="hidden" class="form-control" id="dueValue" name="dueValue" value="<?php echo $data['due'] ?>"  required/>
							</div>
						</div> <!--/form-group-->		
						<div class="form-group">
							<label for="clientContact" class="col-sm-4 control-label"><?php echo $language['payment-type'] ?>:</label>
							<div class="col-sm-8">
								<select class="form-control" name="paymentType" id="paymentType" required>
									<option value="">~~<?php echo $language['select'] ?>~~</option>
									<option value="1" disabled <?php if($data['payment_type'] == 1) {
										echo "selected";
									} ?> >Cheque</option>
									<option value="2" <?php if($data['payment_type'] == 2) {
										echo "selected";
									} ?>  >Cash</option>
									<option value="3" <?php if($data['payment_type'] == 3) {
										echo "selected";
									} ?> >Credit Card</option>
								</select>
							</div>
						</div> <!--/form-group-->							  
						
					</div> <!--/col-md-6-->
				</div>

				<div class="form-group editButtonFooter">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="hidden" name="orderId" id="orderId" value="<?php echo $_GET['i']; ?>" />

						<button type="submit" id="editOrderBtn" data-loading-text="Loading..." class="btn btn-success"><i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>
					</div>
				</div>
			</form>
		<?php } // /get order else  ?>
	</div> <!--/card-->	
</div> <!--/card-->	


<!-- edit order (Payment) -->
<div class="modal fade" tabindex="-1" role="dialog" id="paymentOrderModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-edit"></i> <?php echo $language['edit-payment'] ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>      

			<div class="modal-body form-horizontal" style="max-height:500px; overflow:auto;" >

				<div class="paymentOrderMessages"></div>


				<div class="form-group">
					<label for="due" class="col-sm-3 control-label"><?php echo $language['due-amount'] ?>:</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="due" name="due" disabled="true" />					
					</div>
				</div> <!--/form-group-->		
				<div class="form-group">
					<label for="payAmount" class="col-sm-3 control-label">Pay Amount:</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="payAmount" name="payAmount" required/>					      
					</div>
				</div> <!--/form-group-->		
				<div class="form-group">
					<label for="clientContact" class="col-sm-3 control-label"><?php echo $language['payment-type'] ?>:</label>
					<div class="col-sm-9">
						<select class="form-control" name="paymentType" id="paymentType" required>
							<option value="">~~<?php echo $language['select'] ?>~~</option>
							<option value="1" disabled><?php echo $language['cheque'] ?></option>
							<option value="2"><?php echo $language['cash'] ?></option>
							<option value="3"><?php echo $language['credit-card'] ?></option>
						</select>
					</div>
				</div> <!--/form-group-->							  
				<div class="form-group">
					<label for="clientContact" class="col-sm-3 control-label"><?php echo $language['payment-status'] ?>:</label>
					<div class="col-sm-9">
						<select class="form-control" name="paymentStatus" id="paymentStatus" required>
							<option value="">~~<?php echo $language['select'] ?>~~</option>
							<option value="1"><?php echo $language['full-payment'] ?></option>
							<option value="2"><?php echo $language['partial-payment'] ?></option>
							<option value="3"><?php echo $language['no-payment'] ?></option>
						</select>
					</div>
				</div> <!--/form-group-->							  				  

			</div> <!--/modal-body-->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				<button type="button" class="btn btn-success" id="updatePaymentOrderBtn" data-loading-text="Loading..."> <i class="fas fa-save"></i> <?php echo $language['save-changes'] ?></button>	
			</div>           
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /edit order-->

<!-- remove order -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeOrderModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><i class="fas fa-trash"></i> <?php echo $language['remove-order'] ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="removeOrderMessages"></div>

				<p><?php echo $language['do-y-really-w-to-remove'] ?> ?</p>
			</div>
			<div class="modal-footer removeProductFooter">
				<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fas fa-times"></i></button>
				<button type="button" class="btn btn-danger" id="removeOrderBtn" data-loading-text="Loading..."> <i class="fas fa-trash"></i> <?php echo $language['remove'] ?></button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove order-->


<script src="custom/js/order.js"></script>

<?php require_once 'includes/footer.php'; ?>


