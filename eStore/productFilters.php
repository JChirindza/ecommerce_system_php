<?php require_once 'includes/header.php'; ?>

<script>
	function pageValidation() {
		var valid = true;
		var pageNo = $('#page-no').val();
		var totalPage = $('#total-page').val();
		if(pageNo == ""|| pageNo < 1 || !pageNo.match(/\d+/) || pageNo > parseInt(totalPage)){
			$("#page-no").css("border-color","#ee0000").show();
			valid=false;
		}
		return valid;
	}
</script>
<div class="d-flex" id="wrapper">
	<div class="container-fluid productFilters ml-md-4 mr-md-4 ml-lg-4 mr-lg-4">

		<div class="m-0 p-0">
			<ol class="breadcrumb bg-transparent m-0">
				<li class="breadcrumb-item"><a href="home.php"><?php echo $language['home'] ?></a></li>
				<li class="breadcrumb-item active"><?php echo $language['filters'] ?></li>
			</ol>
		</div>

		<div class="row bg-white mt-2 mt-md-0 mt-lg-0">      	
			<div class="col-md-2 border-right p-3  ">                				
				<div class="list-group filterByRate">
					<h4><?php echo $language['price'] ?></h4>
					<?php 

					$sql = "SELECT Min(rate) as minPrice, Max(rate) as maxPrice FROM product WHERE active = 1";

					if (isset($_GET['category_id']) && !empty($_GET['category_id'])) {
						$category_id = $_GET['category_id'];
						$sql .= " AND categories_id = {$category_id}";
					}

					$query = $connect->query($sql);
					$result = $query->fetch_assoc();

					$minPrice = $result['minPrice'];
					$maxPrice = $result['maxPrice'];
					?>
					<input type="hidden" id="hidden_minimum_price" value="<?php echo $minPrice; ?>" />
					<input type="hidden" id="hidden_maximum_price" value="<?php echo $maxPrice; ?>" />
					<p id="price_show"><?php echo $minPrice ." - ". $maxPrice; ?></p>
					<div id="price_range"></div>
				</div>	

				<div class="list-group mt-4 border-top filterByCategories">
					<h4 class="mt-4"><?php echo $language['categories'] ?></h4>
					<div class="col-12 p-0">

						<div style="height: auto; max-height: 200px; overflow-y: auto; overflow-x: hidden; ">
							<?php
							// gets all active categories
							$sql = "SELECT categories_id, categories_name FROM categories WHERE categories_active = 1";
							$result = $connect->query($sql);

							foreach($result as $row) { 
								// Counts the total products by category
								$sql = "SELECT count(*) as countProduct FROM product WHERE categories_id = {$row['categories_id']} AND active = 1";
								$query = $connect->query($sql);
								$resultCount = $query->fetch_assoc();

								if ($resultCount['countProduct'] > 0) { ?>
									<div class="list-group-item p-0 m-0 border-0">
										<a href="productFilters.php?category_id=<?php echo $row['categories_id']; ?>" class="ctg col-12 p-0"><label> <i class="fa fa-angle-right fa-w-10"></i> <?php echo $row['categories_name']; ?> (<?php echo $resultCount['countProduct']; ?>)</label></a>
									</div>
									<?php 
								} 
							} 
							?>
						</div>
					</div>
				</div>

				<div class="list-group mt-4 border-top">
					<h4 class="mt-4"><?php echo $language['brands'] ?></h4>
					<div style="height: auto; max-height: 280px; overflow-y: auto; overflow-x: hidden;">
						<?php

						$sql = "SELECT DISTINCT(brand_id) FROM product WHERE active = '1' ";

						if (isset($_GET['category_id'])) {
							$sql .= " AND categories_id = {$_GET['category_id']} ";
						}

						$sql .= " ORDER BY product_id DESC";
						$result = $connect->query($sql);

						if ($result) {

							foreach($result as $row) {
								$brandID = $row['brand_id'];
								$sql2 = "SELECT brand_name FROM brands WHERE brand_id = '$brandID' ";
								$query2 = $connect->query($sql2);
								$result2 = $query2->fetch_assoc();

								$sql = "SELECT * FROM product WHERE active = '1' AND brand_id = {$brandID}";
								if (isset($_GET['category_id'])) {
									$sql .= " AND categories_id = {$_GET['category_id']} ";
								}
								$query2 = $connect->query($sql);
								$countBrands = $query2->num_rows;

								?>
								<div class="list-group-item checkbox">
									<label><input type="checkbox" class="common_selector brand" value="<?php echo $row['brand_id']; ?>"  > <?php echo $result2['brand_name']; ?> (<?php echo $countBrands; ?>)</label>
								</div>
							<?php } 
						} ?>
					</div>
				</div>

				<?php if (!isset($_SESSION['userId'])){ ?>
					<div class="d-flex justify-content-center mt-5">
						<a href="../sign-in.php" class="btn btn-warning btn-sm border border-dark pl-4 pr-4" data-toggle="tooltip" title="Sign-in for a better experience."><i class="fas fa-unlock"></i> <?php echo $language['sign-in'] ?></a>
					</div>
				<?php } ?>
			</div>

			<div class="col-sm-12 col-md-10 col-lg-10">
				<div class="row p-2 justify-content-end">
					<div class="limit "><?php echo $language['show'] ?>:
						<select id="product_limit">
							<option value="8">8</option>
							<option value="12">12</option>
							<option value="20">20</option>
							<option value="28">28</option>
						</select>
					</div>
					<div class="sort pl-4"><?php echo $language['sort-by'] ?>:
						<select id="product_sort">
							<option value="1"><?php echo $language['default'] ?></option>
							<option value="2"><?php echo $language['name'] ?> (A - Z)</option>
							<option value="3"><?php echo $language['name'] ?> (Z - A)</option>
							<option value="4"><?php echo $language['low-high'] ?></option>
							<option value="5"><?php echo $language['high-low'] ?></option>
						</select>
					</div>
				</div>

				<input type="hidden" id="page" value="<?php if(isset($_GET['page'])){ echo $_GET['page']; } ?>">
				<input type="hidden" id="category_id" value="<?php if(isset($_GET['category_id'])){ echo $_GET['category_id']; } ?>">
				<div class="border-top row filter_data "></div>
				<div class="loading_area"></div>
			</div>
		</div>
	</div>
</div>
<style>
#loading {
	text-align:center; 
	background: url('../assests/images/app/loader.gif') no-repeat center; 
	height: 150px;
}
</style>

<script type="text/javascript" src="custom/js/product.js"></script>
<script type="text/javascript" src="custom/js/cart.js"></script>
<?php require_once 'includes/footer.php'; ?>