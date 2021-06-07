<?php 	

require_once 'db_connect.php';

$userId = $_GET['i'];

$sql = "SELECT user_image FROM users WHERE user_id = {$userId}";
$data = $connect->query($sql);
$result = $data->fetch_row();

$connect->close();

echo "users/" . $result[0];
