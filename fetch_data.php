<?php

//fetch_data.php

// include('database_connection.php');
$connect = new PDO("mysql:host=localhost;dbname=testing", "root", "");

if(isset($_POST["action"]))
{
	$query = " SELECT * FROM product WHERE product_status = '1' limit 4";
	if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
	{
		$query .= " AND product_price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."' ";
	}
	if(isset($_POST["brand"]))
	{
		$brand_filter = implode("','", $_POST["brand"]);
		$query .= " AND product_brand IN('".$brand_filter."') ";
	}
	if(isset($_POST["ram"]))
	{
		$ram_filter = implode("','", $_POST["ram"]);
		$query .= " AND product_ram IN('".$ram_filter."') ";
	}
	if(isset($_POST["storage"]))
	{
		$storage_filter = implode("','", $_POST["storage"]);
		$query .= " AND product_storage IN('".$storage_filter."') ";
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			$output .= '
			<div class="col-sm-4 col-lg-3 col-md-3">
				<div class="mb-4" style="border:1px solid #ccc; border-radius:1px; height:450px;">
					<div>
						<img src="image/'. $row['product_image'] .'" alt="" class="img-fluid" >
					</div>
					<div class=\"card-body\">
						<p align="center"><strong><a href="#">'. $row['product_name'] .'</a></strong></p>
						<h5 style="text-align:center;" class="text-danger" >'. $row['product_price'] .' Mt</h5>
						
					</div>
				</div>

			</div>
			';
		}
	}
	else
	{
		$output = '<h3>No Data Found</h3>';
	}
	echo $output;
}

?>