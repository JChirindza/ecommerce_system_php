<?php 
require_once '../../php_action/db_connect.php';
require_once '../../php_action/ctrl_functions_general.php';

session_start();
/**
 *	
 * */
if (isset($_GET['action']) && !empty($_GET['action'])) {
	$action = Sys_Secure($_GET['action']);
	switch($action) {
		case 'readRelated':
		fetchRelated();
		break;
		case 'readFilters':
		filterProducts();
		break;
		
		// default:
		// 	// code...
		// break;
	}
}


function fetchRelated(){
	global $connect;

	// Multi-lingual
	$lang = 'en';
	if (isset($_SESSION['lang'])) {
		$lang = Sys_Secure($_SESSION['lang']);
	}
	if (isset($_COOKIE['lang'])) {
		$lang = Sys_Secure($_COOKIE['lang']);
	}
	if (isset($_GET['lang'])) {

		$lang = Sys_Secure($_GET['lang']);

		$cookie_name = "lang";
		$cookie_value = $lang;
	    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
	}
	require_once '../../includes/language/lang.'.$lang.'.php';

	if(isset($_POST["product_id"])) {

		$product_id = Sys_Secure($_POST['product_id']);

		$sql1 = " SELECT * FROM product WHERE product_id = {$product_id} ";
		$query1 = $connect->query($sql1);
		$result1 = $query1->fetch_assoc();

		$sql = " SELECT * FROM product WHERE active = '1' AND categories_id = {$result1['categories_id']} AND product_id != {$product_id} ORDER BY RAND() limit 5";
		$result = $connect->query($sql);

		$output = '';
		if($result->num_rows > 0) { 
			foreach($result as $row) {
				$brandID = $row['brand_id'];

				$sql2 = "SELECT brand_name FROM brands WHERE brand_id = '$brandID' ";
				$query2 = $connect->query($sql2);
				$result2 = $query2->fetch_assoc();

				$output .= '
				<div class="col-auto col-lg-2 p-0 mb-0">
				<a href="product_details.php?product_id='. $row['product_id'] .'">
				<div class="product-entry">
				<div class="product-img">
				<img src="../src/'. $row['product_image'] .'" class="img-fluid" style="height: 100px; " >
				</div>
				<div class="product-brand" style= "text-align: center;">'.$language['brand'].' '. $result2['brand_name'] .' </div>

				<input type="hidden" name="product_id" id="product_id" value="'. $row['product_id'] .'" />
				</div>
				</a>
				</div>
				';
			}
		} else {
			$output = '<div class="col-md-12" style="display:flex; justify-content: center; align-items: center;"> 
			<h5 class="p-5 text-muted">No Data Found</h5></div>';
		}
		echo $output;
	}
}

function filterProducts(){
	global $connect;
	require_once 'ctrl_pagination.php';

	// Multi-lingual
	$lang = 'en';
	if (isset($_SESSION['lang'])) {
		$lang = Sys_Secure($_SESSION['lang']);
	}
	if (isset($_COOKIE['lang'])) {
		$lang = Sys_Secure($_COOKIE['lang']);
	}
	if (isset($_GET['lang'])) {

		$lang = Sys_Secure($_GET['lang']);

		$cookie_name = "lang";
		$cookie_value = $lang;
	    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
	}
	require_once '../../includes/language/lang.'.$lang.'.php';

	if(isset($_POST["action"])) {

		$sql = "SELECT * FROM product WHERE  active = '1'";
		// Categories
		if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
			$categories_id = Sys_Secure($_POST["category_id"]);
			$sql .= " AND categories_id = {$categories_id} ";
		}
		// Price range
		if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"])) {
			$sql .= "AND rate BETWEEN '".Sys_Secure($_POST["minimum_price"])."' AND '".Sys_Secure($_POST["maximum_price"])."'";
		}
		// brands
		if(isset($_POST["brand"])) {
			$brand_filter = implode("','", $_POST["brand"]); // array given in
			$sql .= " AND brand_id IN('".$brand_filter."')";
		}
		
		if (!isset($_POST['category_id']) || empty($_POST['category_id'])) {
			$sql .= " ORDER BY RAND() ";
		}else{
			// Sort - default 1
			$sort = Sys_Secure($_POST['sort']);
			if($sort == 2) { // A - Z
				$sql .= "ORDER BY product_name ASC ";
			}elseif ($sort == 3){ // Z - A
				$sql .= "ORDER BY product_name DESC ";
			}elseif ($sort == 4) { // price Low - High
				$sql .= "ORDER BY rate ASC ";
			}elseif ($sort == 5) { // price High - Low
				$sql .= "ORDER BY rate DESC ";
			}
		}
		
		// Limit of products to show
		$limits = Sys_Secure($_POST['limit']);
		
		// Class Instance
		$paginationModel = new Pagination();
		$pageResult = $paginationModel->getPage($limits, $sql);
		$queryString = "?";

		$pn = 1;
		if (isset($_POST["page"]) && !empty($_POST['page'])) {
			$pn = Sys_Secure($_POST["page"]);
		}

		$totalRecords = $paginationModel->getAllRecords($sql);
		$totalPages = ceil($totalRecords / $limits);
		
		$startFrom = ($pn - 1) * $limits;

		// end of the sql query
		$sql .= " limit {$startFrom}, {$limits}";

		$result = $connect->query($sql);

		$output = '';
		if($result && $result->num_rows > 0) { 
			foreach($result as $row) {
				$brandID = $row['brand_id'];

				$sql2 = "SELECT brand_name FROM brands WHERE brand_id = '$brandID' ";
				$query2 = $connect->query($sql2);
				$result2 = $query2->fetch_assoc();

				$output .= '
				<div class="col-sm-4 col-lg-3 col-md-3 mt-3">
					<a href="product_details.php?product_id='. $row['product_id'] .'">
						<div class="product-entry">
							<div class="col-md-12 product-img" style="display: flex; justify-content: center; align-items: center;">
							<img src="../src/'. $row['product_image'] .'" class="img-fluid" style="height: 200px; " >
							</div>
							<div class="product-brand">'.$language['brand'].' '. $result2['brand_name'] .' </div>
							<div class="product-name card-body">
							<p align="center"><strong><a href="product_details.php?product_id='. $row['product_id'] .'" class="" data-toggle="tooltip" title="'. $row['product_name'] .'">'. $row['product_name'] .'</a></strong></p>
							</div>
							<div class="product-stars">
								<h6>
									<i class="fas fa-star"></i>
									<i class="fas fa-star"></i>
									<i class="fas fa-star"></i>
									<i class="fas fa-star"></i>
									<i class="far fa-star"></i>
								</h6>
							</div>
							<div class="product-price">
								<h5 style="text-align:center;" class="text-danger" >'. number_format($row['rate'], 2). " Mt" .' </h5>
							</div>
						</div>
					</a>
				</div>
				';
			}
			$output .= '
				<div class="row col-12">
					<!-- Pagination -->
					<div class="pagination col-8 pl-3">'; 
						$categ_id = null;
						if(isset($_POST['category_id']) && !empty($_POST['category_id'])){ $categ_id = $_POST['category_id']; }
						
						if (($row > 1) && ($pn > 1)) {
							
							$output .= '<a class="previous-page" id="prev-page" href="'.$queryString.'category_id='.$categ_id.'&page='.(($pn-1)).' " title="'.$language['previous-page'].'"><span>&#10094; '.$language['previous'].'</span></a>';
						
						}
						if (($pn - 1) > 1) {
							$output .= '<a href="productFilters.php?category_id='. $categ_id .'&page=1"><div class="page-a-link">1</div></a>
							<div class="page-before-after">...</div>';
						}
						
						for ($i = ($pn - 1); $i <= ($pn + 1); $i ++) {
							if ($i < 1)
								continue;
							if ($i > $totalPages)
								break;
							if ($i == $pn) {
								$class = "active";
							} else {
								$class = "page-a-link";
							} 
							$output .= '<a href="productFilters.php?category_id='. $categ_id .'&page='. $i .' ">
								<div class='.$class.'>'. $i .'</div>
							</a>';
						}

						if (($totalPages - ($pn + 1)) >= 1) { 
							$output .= '<div class="page-before-after">...</div>';
						}

						if (($totalPages - ($pn + 1)) > 0) {
							if ($pn == $totalPages) {
								$class = "active";
							} else {
								$class = "page-a-link";
							}

							$output .= '<a href="productFilters.php?category_id='. $categ_id .'&page='. $totalPages .' "><div class="'. $class .'">'. $totalPages .'</div></a>';
						}
						if (($row > 1) && ($pn < $totalPages)) {
							$output .= '<a class="next" id="next-page" href="'.$queryString.'category_id='. $categ_id .'&page='. (($pn+1)).' " title="'.$language['next-page'].'"><span>'.$language['next'].' &#10095;</span></a> ';
						}

					$output .= '
					</div>
					
					<!-- Go to page -->
					<div class="goto-page col-3 m-auto d-flex justify-content-end">
						<form action="" method="GET" onsubmit="return pageValidation()" class="m-auto">
							<input type="submit" class="goto-button" value="'.$language['goto'].'"> 
							<input type="text" class="enter-page-no" name="page" min="1" id="page-no" style="width: 42px;"> 
							<input type="hidden" id="total-page" value="'. $totalPages.'">
						</form>
					</div>
				</div>
			';
		}else{
			$output = '<div class="col-md-12" style="display:flex; justify-content: center; align-items: center;"> 
			<h5 class="p-5 text-muted">'.$language['no-data-found'].'</h5></div>';
		}
		echo $output;
	}
}

?>