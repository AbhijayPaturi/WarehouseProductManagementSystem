<?php
	require "../config/config.php";
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->errno ) {
		echo $mysqli->error;
		exit();
	}
	$mysqli->set_charset('utf8');
	$sql = "SELECT products.id AS products_id, name, quantity, warehouse_section, price, conditions.condition FROM products LEFT JOIN conditions ON products.conditions_id = conditions.id WHERE 1=1"; 
	if ( isset($_GET['prodName']) && !empty($_GET['prodName']) ) {

	$sql = $sql . " AND products.name LIKE '%" . $_GET["prodName"] . "%'";
	} else {
	}
	if ( isset($_GET['manufacturerId']) && !empty($_GET['manufacturerId']) ) {
	if ($_GET['manufacturerId'] != 0) {
	    $sql = $sql . " AND products.manufacturers_id = " . $_GET["manufacturerId"];
	}
	else {
	}
	} else {
	}
	if ( isset($_GET['categoryId']) && !empty($_GET['categoryId']) ) {
	if ($_GET['categoryId'] != 0) {
	    $sql = $sql . " AND products.categories_id = " . $_GET["categoryId"];
	}
	else {
	}
	} else { 
	}
	if ( isset($_GET['warehouseAisle']) && !empty($_GET['warehouseAisle']) ) {
	if ($_GET['warehouseAisle'] != '0') {
	    $sql = $sql . " AND products.warehouse_section LIKE '" . $_GET["warehouseAisle"] . "'";
	}
	else {
	}
	} else {
	}
	if ( isset($_GET['conditionId']) && !empty($_GET['conditionId']) ) {
		if ($_GET['conditionId'] != 0) {
		    $sql = $sql . " AND products.conditions_id = " . $_GET["conditionId"];
		}
		else {
		}
		} else {
	}
	$sql = $sql . ";";
	$results = $mysqli->query($sql);
	if ( !$results ) {
		echo $mysqli->error;
		exit();
	}
	$results_array = [];
	while ( $row = $results->fetch_assoc() ) {
		array_push($results_array, $row);
	}
	echo json_encode($results_array);
	$mysqli->close();
?>
