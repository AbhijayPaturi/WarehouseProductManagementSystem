<?php
	require "../config/config.php";
	$isAdded = false;
	$already = false;
	if ( !isset($_POST['product_name']) || 
	empty($_POST['product_name']) || 
	!isset($_POST['product_quantity']) || 
	empty($_POST['product_quantity']) || 
	!isset($_POST['product_price']) || 
	empty($_POST['product_price']) || 
	!isset($_POST['warehouse_aisle']) || 
	empty($_POST['warehouse_aisle']) || 
	!isset($_POST['product_model']) || 
	empty($_POST['product_model']) || 
	!isset($_POST['product_category_id']) || 
	empty($_POST['product_category_id']) || 
	!isset($_POST['product_manufacturer_id']) || 
	empty($_POST['product_manufacturer_id']) || 
	!isset($_POST['product_condition_id']) || 
	empty($_POST['product_condition_id']) ) 
	{
		$error = "Please fill out the required fields.";
	}
	else {
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->errno ) {
			echo $mysqli->error;
			exit();
	}

	$sql_check = "SELECT * FROM products WHERE name LIKE '" . $_POST['product_name'] . "' AND price=" . $_POST['product_price'] ." AND model LIKE '" . $_POST['product_model'] . "' AND categories_id=" . $_POST['product_category_id'] . " AND manufacturers_id=" . $_POST['product_manufacturer_id'] . " AND conditions_id=" . $_POST['product_condition_id'] . ";";
	$results_check = $mysqli->query($sql_check);
	if ( $results_check == false ) {
	    echo $mysqli->error;
	    exit();
	}

	if ($results_check->fetch_assoc() == null) {
	    if ( isset($_POST['product_features']) && !empty($_POST['product_features']) ) {
		$product_features = $_POST['product_features'];
	    } else {
		$product_features = NULL;
	    }

	    $statement = $mysqli->prepare("INSERT INTO products(name, quantity, warehouse_section, price, model, features, categories_id, manufacturers_id, conditions_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?);");
	    $statement->bind_param("sisdssiii", $_POST["product_name"], $_POST["product_quantity"], $_POST["warehouse_aisle"], $_POST["product_price"], $_POST["product_model"], $product_features, $_POST["product_category_id"], $_POST["product_manufacturer_id"], $_POST["product_condition_id"]); 
	    $executed = $statement->execute();
	    if (!$executed) {
		$error = $mysqli->error;
	    }
	    if($mysqli->affected_rows == 1) {
		$isAdded = true;
	    }
	    else {
		$error = "There was an error with this add action.<br> Please try again.";
	    }
	} 
	else 
	{
	    $error = "This product is ALREADY in the warehouse! <br><strong>Please try to add a NEW product!</strong>";
	    $already = true;
	}       
		$mysqli->close();
      }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/add_production_confirmation.css">
    <link rel="stylesheet" type="text/css" href="../css/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <title>Confirm Product Add</title>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light my-color sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand nav-brand-padding fs-2" href="home.php"><strong class="navbar-text-color">WPMS</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end nav-outer-text-padding" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link navtext-padding" aria-current="page" href="home.php"><span class="navbar-text-color navbar-text-size">Home</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link navtext-padding" href="view_product.php"><span class="navbar-text-color navbar-text-size">View Products</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link navtext-padding active" href="change_products.php"><span class="navbar-text-color-active navbar-text-size">Change Products</span></a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link navtext-padding" href="make_shipment.php"><span class="navbar-text-color navbar-text-size">Make Shipment</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
            <div class="row">
                <div class="col col-12 register-row-text-center">
                        <?php if ( isset($error) && !empty($error) ) : ?>
                            <div class="register-row-text-center img-div">
                                    <img src="../pictures/error_picture.jpeg" alt="Error Image">
                            </div>
                        <?php else : ?>
                            <div class="col col-6 register-row-text-center img-div">
                                    <img src="../pictures/success_picture.jpeg" alt="Success Image">
                            </div>
                        <?php endif; ?>
                        <div class="client-name-spacing">
                            <?php if ( isset($error) && !empty($error) ) : ?>
                                <div class="text-danger font-italic">
                                    <?php if ($already): ?>
                                        <?php echo $error; ?></div>
                                    <?php else : ?>
                                        <div id="msg"><span class="font-italic italics-msg"><?php $_POST["product_name"];?></span> Has NOT Been Successfully Added.<br>Press Back and Try Again!</div>
                                    <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($isAdded) : ?>
                                <div class="text-success error-message">
                                    <div><span class="font-italic italics-msg"><?php echo $_POST["product_name"];?></span> Has Been Successfully Added!</div>
                                </div>
                            <?php endif; ?>                         
                            <?php if ( isset($error) && !empty($error) ) : ?>
                                <!-- <a href="home.php" class="btn btn-primary submit-button-colors button-rounded-error home-fonts">Home</a> -->
                                <a href="home.php" class="btn btn-primary submit-button-colors button-rounded-error home-fonts">Home</a>
                                <a href="add_product.php" class="btn btn-primary submit-button-colors button-rounded-error home-fonts">Back</a>
                            <?php else : ?>
                                <a href="home.php" class="btn btn-primary submit-button-colors button-rounded-error home-fonts">Home</a>
                                <a href="add_product.php" class="btn btn-primary submit-button-colors button-rounded-error home-fonts">Back</a>
                            <?php endif; ?>
                        </div>
                </div>
            </div>       
    </div>
    <?php include 'footer.php'; ?> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>

